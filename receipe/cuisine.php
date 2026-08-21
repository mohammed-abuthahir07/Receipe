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
$recipes = get_published_recipes(['cuisine' => $slug], 30);

require __DIR__ . '/includes/header.php';
?>

<section class="recipe-hero">
    <img data-parallax src="<?= e($cuisine['hero_image_url']) ?>" alt="<?= e($cuisine['name']) ?>">
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
            <p><?= count($recipes) ?> published dishes in this cuisine.</p>
        </div>
        <div class="recipe-grid">
            <?php foreach ($recipes as $recipe) { recipe_card($recipe); } ?>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
