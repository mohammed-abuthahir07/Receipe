<?php
require_once dirname(__DIR__) . '/config/app.php';
header('Content-Type: application/json');

if (!is_logged_in()) {
    echo json_encode(['ok' => false, 'message' => 'Please sign in to save recipes.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true) ?: [];
$recipeId = (int) ($input['recipe_id'] ?? 0);
$userId = (int) current_user()['id'];

$exists = db()->prepare('SELECT id FROM favorites WHERE recipe_id = ? AND user_id = ?');
$exists->execute([$recipeId, $userId]);
if ($exists->fetch()) {
    echo json_encode(['ok' => true, 'message' => 'Already in your cookbook.']);
    exit;
}

db()->prepare('INSERT INTO favorites (recipe_id, user_id) VALUES (?, ?)')->execute([$recipeId, $userId]);
echo json_encode(['ok' => true, 'message' => 'Saved to your cookbook.']);
