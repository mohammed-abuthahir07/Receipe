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
            <p>Recipes you have saved for later.</p>
        </div>
        <nav class="subnav" aria-label="Kitchen">
            <a href="<?= e(url('account/index.php')) ?>">Overview</a>
            <a class="is-active" href="<?= e(url('account/cookbook.php')) ?>">Cookbook</a>
            <a href="<?= e(url('account/shopping-list.php')) ?>">Shopping list</a>
            <a href="<?= e(url('account/cooking-log.php')) ?>">Cooking log</a>
        </nav>
        <?php if (!$recipes): ?>
            <div class="empty-state" data-reveal>
                <div class="empty-state__icon">📖</div>
                <h3>No saved recipes yet</h3>
                <p>Browse the collection and tap Save to add dishes to your cookbook.</p>
                <a class="btn btn--primary" href="<?= e(url('browse.php')) ?>">Browse recipes</a>
            </div>
        <?php else: ?>
            <div class="recipe-grid">
                <?php foreach ($recipes as $recipe) { recipe_card($recipe); } ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
