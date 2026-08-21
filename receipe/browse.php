<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'Browse Recipes';
$filters = [
    'q' => trim($_GET['q'] ?? ''),
    'cuisine' => trim($_GET['cuisine'] ?? ''),
    'food_type' => trim($_GET['food_type'] ?? ''),
    'meal_type' => trim($_GET['meal_type'] ?? ''),
    'difficulty' => trim($_GET['difficulty'] ?? ''),
    'sort' => trim($_GET['sort'] ?? 'newest'),
];
$recipes = get_published_recipes($filters, 30);
$cuisines = get_cuisines();

require __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section__head" data-reveal>
            <h2>Browse Malaysian recipes</h2>
            <p>Filter by cuisine, veg / non-veg / vegan, meal type, and difficulty.</p>
        </div>

        <form class="filters" method="get" data-reveal>
            <input type="search" name="q" placeholder="Search recipes…" value="<?= e($filters['q']) ?>">
            <select name="cuisine">
                <option value="">All cuisines</option>
                <?php foreach ($cuisines as $c): ?>
                    <option value="<?= e($c['slug']) ?>" <?= $filters['cuisine'] === $c['slug'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="food_type">
                <option value="">All food types</option>
                <?php foreach (['VEG','NON_VEG','VEGAN','EGGETARIAN'] as $ft): ?>
                    <option value="<?= $ft ?>" <?= $filters['food_type'] === $ft ? 'selected' : '' ?>><?= e(food_type_label($ft)) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="meal_type">
                <option value="">All meals</option>
                <?php foreach (['BREAKFAST','LUNCH','DINNER','SNACK','DESSERT','BEVERAGE'] as $mt): ?>
                    <option value="<?= $mt ?>" <?= $filters['meal_type'] === $mt ? 'selected' : '' ?>><?= e(ucfirst(strtolower($mt))) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="difficulty">
                <option value="">Any difficulty</option>
                <?php foreach (['EASY','MEDIUM','HARD'] as $d): ?>
                    <option value="<?= $d ?>" <?= $filters['difficulty'] === $d ? 'selected' : '' ?>><?= e(ucfirst(strtolower($d))) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="sort">
                <option value="newest" <?= $filters['sort'] === 'newest' ? 'selected' : '' ?>>Newest</option>
                <option value="popular" <?= $filters['sort'] === 'popular' ? 'selected' : '' ?>>Most viewed</option>
                <option value="cooked" <?= $filters['sort'] === 'cooked' ? 'selected' : '' ?>>Most cooked</option>
                <option value="rating" <?= $filters['sort'] === 'rating' ? 'selected' : '' ?>>Top rated</option>
            </select>
            <button class="btn btn--primary" type="submit">Apply</button>
        </form>

        <?php if (!$recipes): ?>
            <p data-reveal>No recipes matched your filters. Try clearing a filter or browse all cuisines.</p>
        <?php else: ?>
            <div class="recipe-grid">
                <?php foreach ($recipes as $recipe) { recipe_card($recipe); } ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
