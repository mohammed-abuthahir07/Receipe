<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'Home';
$pageDescription = 'Ruchi — traditional Malaysian recipes with Cook Mode, nutrition, and community.';
$preloadImage = url('assets/img/home-hero.png');

$featured = get_published_recipes(['sort' => 'popular'], 1)[0] ?? null;
$trending = get_published_recipes(['sort' => 'popular'], 6);
$newest = get_published_recipes(['sort' => 'newest'], 3);
$cuisines = get_cuisines();

require __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <img class="hero__bg" data-parallax src="<?= e(url('assets/img/home-hero.png')) ?>" alt="Traditional dishes and spices" width="1600" height="900" fetchpriority="high" decoding="async">
    <div class="hero__overlay"></div>
    <div class="hero__content">
        <p class="chip badge-inline hero__chip">Malaysia · Resepi Tradisional</p>
        <h1 class="hero__brand"><?= e(APP_NAME) ?></h1>
        <p class="hero__lead">Cook authentic Malaysian favourites with step timers, live serving adjusters, and a distraction-free Cook Mode — built for phones propped next to the stove.</p>
        <div class="hero__actions">
            <a class="btn btn--accent" href="<?= e(url('browse.php')) ?>">Browse recipes</a>
            <?php if ($featured): ?>
                <a class="btn btn--ghost-light" href="<?= e(url('recipe.php?slug=' . $featured['slug'])) ?>">
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
            <p>Malaysian kitchens, plus Traditional Indian millet, onion, and Kanchipuram classics.</p>
        </div>
        <?php if (!$cuisines): ?>
            <div class="empty-state" data-reveal>
                <div class="empty-state__icon">🍲</div>
                <h3>Cuisines coming soon</h3>
                <p>Cuisine collections will appear here once they are published.</p>
            </div>
        <?php else: ?>
            <div class="cuisine-strip">
                <?php foreach ($cuisines as $cuisine): ?>
                    <a class="cuisine-tile" data-reveal href="<?= e(url('cuisine.php?slug=' . $cuisine['slug'])) ?>">
                        <img src="<?= e($cuisine['hero_image_url']) ?>" alt="<?= e($cuisine['name']) ?>" width="480" height="176" loading="lazy" decoding="async">
                        <span><?= e($cuisine['name']) ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="section section--tight">
    <div class="container">
        <div class="section__head" data-reveal>
            <h2>Trending this week</h2>
            <p>Most-viewed recipes from home cooks across Malaysia.</p>
        </div>
        <?php if (!$trending): ?>
            <div class="empty-state" data-reveal>
                <div class="empty-state__icon">🔥</div>
                <h3>No trending recipes yet</h3>
                <p>Published recipes will appear here as cooks start exploring the kitchen.</p>
                <a class="btn btn--primary" href="<?= e(url('browse.php')) ?>">Browse all recipes</a>
            </div>
        <?php else: ?>
            <div class="recipe-grid">
                <?php foreach ($trending as $recipe) { recipe_card($recipe); } ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="section section--tight">
    <div class="container">
        <div class="section__head" data-reveal>
            <h2>Fresh from the dapur</h2>
            <p>Newly published recipes, ready for your weekend menu.</p>
        </div>
        <?php if (!$newest): ?>
            <div class="empty-state" data-reveal>
                <div class="empty-state__icon">🌿</div>
                <h3>No new recipes yet</h3>
                <p>Check back soon — fresh dishes are on the way.</p>
            </div>
        <?php else: ?>
            <div class="recipe-grid">
                <?php foreach ($newest as $recipe) { recipe_card($recipe); } ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
