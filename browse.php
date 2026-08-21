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
$hasFilters = $filters['q'] !== '' || $filters['cuisine'] !== '' || $filters['food_type'] !== '' || $filters['meal_type'] !== '' || $filters['difficulty'] !== '';

require __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section__head" data-reveal>
            <h2>Browse recipes</h2>
            <p>Filter by cuisine, diet, meal type, and difficulty to find your next dish.</p>
        </div>

        <form class="filters" method="get" data-reveal>
            <input type="search" name="q" placeholder="Search recipes…" value="<?= e($filters['q']) ?>" aria-label="Search recipes">
            <select name="cuisine" aria-label="Cuisine">
                <option value="">All cuisines</option>
                <?php foreach ($cuisines as $c): ?>
                    <option value="<?= e($c['slug']) ?>" <?= $filters['cuisine'] === $c['slug'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="food_type" aria-label="Food type">
                <option value="">All food types</option>
                <?php foreach (['VEG','NON_VEG','VEGAN','EGGETARIAN'] as $ft): ?>
                    <option value="<?= $ft ?>" <?= $filters['food_type'] === $ft ? 'selected' : '' ?>><?= e(food_type_label($ft)) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="meal_type" aria-label="Meal type">
                <option value="">All meals</option>
                <?php foreach (['BREAKFAST','LUNCH','DINNER','SNACK','DESSERT','BEVERAGE'] as $mt): ?>
                    <option value="<?= $mt ?>" <?= $filters['meal_type'] === $mt ? 'selected' : '' ?>><?= e(ucfirst(strtolower($mt))) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="difficulty" aria-label="Difficulty">
                <option value="">Any difficulty</option>
                <?php foreach (['EASY','MEDIUM','HARD'] as $d): ?>
                    <option value="<?= $d ?>" <?= $filters['difficulty'] === $d ? 'selected' : '' ?>><?= e(ucfirst(strtolower($d))) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="sort" aria-label="Sort by">
                <option value="newest" <?= $filters['sort'] === 'newest' ? 'selected' : '' ?>>Newest</option>
                <option value="popular" <?= $filters['sort'] === 'popular' ? 'selected' : '' ?>>Most viewed</option>
                <option value="cooked" <?= $filters['sort'] === 'cooked' ? 'selected' : '' ?>>Most cooked</option>
                <option value="rating" <?= $filters['sort'] === 'rating' ? 'selected' : '' ?>>Top-rated</option>
            </select>
            <button class="btn btn--primary" type="submit">Apply filters</button>
        </form>

        <?php if (!$recipes): ?>
            <div class="empty-state" data-reveal>
                <div class="empty-state__icon">🔍</div>
                <h3><?= $hasFilters ? 'No recipes match your search' : 'No recipes available' ?></h3>
                <p><?= $hasFilters
                    ? 'Try a different keyword, or clear a filter to see more dishes.'
                    : 'Published recipes will appear here. Check back soon.' ?></p>
                <?php if ($hasFilters): ?>
                    <a class="btn btn--primary" href="<?= e(url('browse.php')) ?>">Clear filters</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="recipe-grid">
                <?php foreach ($recipes as $recipe) { recipe_card($recipe); } ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
