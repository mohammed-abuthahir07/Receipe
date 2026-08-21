<?php
require_once __DIR__ . '/config/app.php';

$slug = trim($_GET['slug'] ?? '');
$stmt = db()->prepare('SELECT * FROM cuisines WHERE slug = ?');
$stmt->execute([$slug]);
$cuisine = $stmt->fetch();

if (!$cuisine) {
    flash('error', 'Cuisine not found.');
    redirect('browse.php');
}

$pageTitle = $cuisine['name'] . ' Cuisine';
$pageDescription = $cuisine['description'] ?? '';
$preloadImage = $cuisine['hero_image_url'];
$recipes = get_published_recipes(['cuisine' => $slug], 30);

require __DIR__ . '/includes/header.php';
?>

<section class="recipe-hero">
    <img data-parallax src="<?= e($cuisine['hero_image_url']) ?>" alt="<?= e($cuisine['name']) ?>" width="1600" height="900" fetchpriority="high" decoding="async">
    <div class="recipe-hero__shade"></div>
    <div class="recipe-hero__content">
        <p class="chip">Cuisine</p>
        <h1><?= e($cuisine['name']) ?></h1>
        <p><?= e($cuisine['description']) ?></p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section__head">
            <h2>Recipes</h2>
            <p><?= count($recipes) ?> published <?= count($recipes) === 1 ? 'dish' : 'dishes' ?> in this cuisine.</p>
        </div>
        <?php if (!$recipes): ?>
            <div class="empty-state" data-reveal>
                <div class="empty-state__icon">🍽️</div>
                <h3>No recipes available yet</h3>
                <p>There are no published recipes in this cuisine yet. Browse other collections in the meantime.</p>
                <a class="btn btn--primary" href="<?= e(url('browse.php')) ?>">Browse all recipes</a>
            </div>
        <?php else: ?>
            <div class="recipe-grid">
                <?php foreach ($recipes as $recipe) { recipe_card($recipe); } ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
