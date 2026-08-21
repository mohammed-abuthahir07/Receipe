<?php
require_once dirname(__DIR__) . '/config/app.php';
require_login();
$user = current_user();

$stmt = db()->prepare(
    'SELECT r.*, c.name AS cuisine_name, c.slug AS cuisine_slug,
            (SELECT AVG(stars) FROM ratings rt WHERE rt.recipe_id = r.id) AS avg_rating
     FROM favorites f
     JOIN recipes r ON r.id = f.recipe_id
     JOIN cuisines c ON c.id = r.cuisine_id
     WHERE f.user_id = ?
     ORDER BY f.created_at DESC'
);
$stmt->execute([(int) $user['id']]);
$recipes = $stmt->fetchAll();

$pageTitle = 'My Cookbook';
require dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section__head">
            <h2>My Cookbook</h2>
            <p>Recipes you saved for later.</p>
        </div>
        <?php if (!$recipes): ?>
            <p>No saved recipes yet. <a href="<?= e(url('browse.php')) ?>">Browse and tap Save</a>.</p>
        <?php else: ?>
            <div class="recipe-grid">
                <?php foreach ($recipes as $recipe) { recipe_card($recipe); } ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
