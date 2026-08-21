<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'Home';
$pageDescription = 'Ruchi — traditional Malaysian recipes with cook mode, nutrition, and community.';

$featured = get_published_recipes(['sort' => 'popular'], 1)[0] ?? null;
$trending = get_published_recipes(['sort' => 'popular'], 6);
$newest = get_published_recipes(['sort' => 'newest'], 3);
$cuisines = get_cuisines();

require __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <?php if ($featured): ?>
        <img class="hero__bg" data-parallax src="<?= e($featured['hero_image_url']) ?>" alt="<?= e($featured['title']) ?>">
    <?php endif; ?>
    <div class="hero__overlay"></div>
    <div class="hero__content">
        <p class="chip badge-inline" style="background:rgba(255,255,255,.14);border:0;color:#fff;">Malaysia · Resepi Tradisional</p>
        <h1 class="hero__brand"><?= e(APP_NAME) ?></h1>
        <p class="hero__lead">Cook authentic Malaysian favourites with step timers, live serving adjusters, and a distraction-free Cook Mode — built for phones propped next to the stove.</p>
        <div class="hero__actions">
            <a class="btn btn--accent" href="<?= e(url('browse.php')) ?>">Browse recipes</a>
            <?php if ($featured): ?>
                <a class="btn btn--ghost" style="color:#fff;border-color:rgba(255,255,255,.35)" href="<?= e(url('recipe.php?slug=' . $featured['slug'])) ?>">
                    Start with <?= e($featured['title']) ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section__head" data-reveal>
            <h2>Cuisines we celebrate</h2>
            <p>Malaysian kitchens plus Traditional Indian millet, onion and Kanchipuram classics.</p>
        </div>
        <div class="cuisine-strip">
            <?php foreach ($cuisines as $cuisine): ?>
                <a class="cuisine-tile" data-reveal href="<?= e(url('cuisine.php?slug=' . $cuisine['slug'])) ?>">
                    <img src="<?= e($cuisine['hero_image_url']) ?>" alt="<?= e($cuisine['name']) ?>" loading="lazy">
                    <span><?= e($cuisine['name']) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="container">
        <div class="section__head" data-reveal>
            <h2>Trending this week</h2>
            <p>Most-viewed recipes from home cooks across Malaysia.</p>
        </div>
        <div class="recipe-grid">
            <?php foreach ($trending as $recipe) { recipe_card($recipe); } ?>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="container">
        <div class="section__head" data-reveal>
            <h2>Fresh from the dapur</h2>
            <p>Newly published recipes ready for your weekend menu.</p>
        </div>
        <div class="recipe-grid">
            <?php foreach ($newest as $recipe) { recipe_card($recipe); } ?>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
