<?php
require_once dirname(__DIR__) . '/config/app.php';
header('Content-Type: application/json');

if (!is_logged_in()) {
    echo json_encode(['ok' => false, 'message' => 'Please sign in to like recipes.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true) ?: [];
$recipeId = (int) ($input['recipe_id'] ?? 0);
$userId = (int) current_user()['id'];

// Reuse ratings as a quick "like" = 5 stars upsert
$stmt = db()->prepare(
    'INSERT INTO ratings (recipe_id, user_id, stars) VALUES (?, ?, 5)
     ON DUPLICATE KEY UPDATE stars = 5'
);
$stmt->execute([$recipeId, $userId]);
echo json_encode(['ok' => true, 'message' => 'Thanks for the love!']);
