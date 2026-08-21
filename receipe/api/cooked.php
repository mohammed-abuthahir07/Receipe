<?php
require_once dirname(__DIR__) . '/config/app.php';
header('Content-Type: application/json');

if (!is_logged_in()) {
    echo json_encode(['ok' => false, 'message' => 'Please sign in to log a cook.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true) ?: [];
$recipeId = (int) ($input['recipe_id'] ?? 0);
$userId = (int) current_user()['id'];

$exists = db()->prepare('SELECT id FROM cooked_logs WHERE recipe_id = ? AND user_id = ?');
$exists->execute([$recipeId, $userId]);

if ($exists->fetch()) {
    $count = db()->prepare('SELECT cooked_count FROM recipes WHERE id = ?');
    $count->execute([$recipeId]);
    echo json_encode([
        'ok' => true,
        'message' => 'Already logged — count stays the same.',
        'cooked_count' => (int) $count->fetchColumn(),
    ]);
    exit;
}

db()->prepare('INSERT INTO cooked_logs (recipe_id, user_id) VALUES (?, ?)')->execute([$recipeId, $userId]);
db()->prepare('UPDATE recipes SET cooked_count = cooked_count + 1 WHERE id = ?')->execute([$recipeId]);
$count = db()->prepare('SELECT cooked_count FROM recipes WHERE id = ?');
$count->execute([$recipeId]);

echo json_encode([
    'ok' => true,
    'message' => 'Logged — syabas!',
    'cooked_count' => (int) $count->fetchColumn(),
]);
