<?php
require_once __DIR__ . '/config/app.php';

$slug = trim($_GET['slug'] ?? '');
$recipe = get_recipe_by_slug($slug);

if (!$recipe) {
    flash('error', 'Recipe not found.');
    redirect('browse.php');
}

$recipe['description'] = repair_text((string) $recipe['description']);

db()->prepare('UPDATE recipes SET view_count = view_count + 1 WHERE id = ?')->execute([(int) $recipe['id']]);

$ingredients = db()->prepare('SELECT * FROM ingredients WHERE recipe_id = ? ORDER BY sort_order, id');
$ingredients->execute([(int) $recipe['id']]);
$ingredients = $ingredients->fetchAll();

$steps = db()->prepare('SELECT * FROM recipe_steps WHERE recipe_id = ? ORDER BY step_number');
$steps->execute([(int) $recipe['id']]);
$steps = $steps->fetchAll();

$nutrition = db()->prepare('SELECT * FROM nutrition_info WHERE recipe_id = ?');
$nutrition->execute([(int) $recipe['id']]);
$nutrition = $nutrition->fetch() ?: null;

$comments = db()->prepare(
    'SELECT c.*, u.name AS user_name FROM comments c
     JOIN users u ON u.id = c.user_id
     WHERE c.recipe_id = ? AND c.parent_id IS NULL AND c.is_flagged = 0
     ORDER BY c.created_at DESC'
);
$comments->execute([(int) $recipe['id']]);
$comments = $comments->fetchAll();

$related = get_published_recipes(['cuisine' => $recipe['cuisine_slug'], 'sort' => 'popular'], 4);
$related = array_values(array_filter($related, fn($r) => (int) $r['id'] !== (int) $recipe['id']));

$rating = avg_rating((int) $recipe['id']);
$totalTime = (int) $recipe['prep_time_mins'] + (int) $recipe['cook_time_mins'];

$pageTitle = $recipe['title'];
$pageDescription = $recipe['description'];
$pageScripts = ['assets/js/recipe.js'];
$preloadImage = $recipe['hero_image_url'];

$jsonLd = json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Recipe',
    'name' => $recipe['title'],
    'description' => $recipe['description'],
    'image' => [$recipe['hero_image_url']],
    'author' => ['@type' => 'Person', 'name' => $recipe['author_name']],
    'prepTime' => 'PT' . (int) $recipe['prep_time_mins'] . 'M',
    'cookTime' => 'PT' . (int) $recipe['cook_time_mins'] . 'M',
    'totalTime' => 'PT' . $totalTime . 'M',
    'recipeYield' => $recipe['servings'] . ' servings',
    'recipeCategory' => $recipe['meal_type'],
    'recipeCuisine' => $recipe['cuisine_name'],
    'keywords' => $recipe['cuisine_name'] . ', Malaysian, ' . food_type_label($recipe['food_type']),
    'aggregateRating' => $rating ? [
        '@type' => 'AggregateRating',
        'ratingValue' => $rating,
        'ratingCount' => 1,
    ] : null,
    'nutrition' => $nutrition ? [
        '@type' => 'NutritionInformation',
        'calories' => $nutrition['calories'] . ' calories',
        'proteinContent' => $nutrition['protein_g'] . ' g',
        'carbohydrateContent' => $nutrition['carbs_g'] . ' g',
        'fatContent' => $nutrition['fat_g'] . ' g',
    ] : null,
    'recipeIngredient' => array_map(
        fn($i) => format_qty($i['quantity']) . ' ' . $i['unit'] . ' ' . $i['name'],
        $ingredients
    ),
    'recipeInstructions' => array_map(
        fn($s) => ['@type' => 'HowToStep', 'text' => $s['instruction']],
        $steps
    ),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

// Handle comment POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_body'])) {
    require_login();
    $body = trim($_POST['comment_body'] ?? '');
    if ($body !== '') {
        $user = current_user();
        $isAuthor = (int) $user['id'] === (int) $recipe['author_id'];
        $stmt = db()->prepare('INSERT INTO comments (recipe_id, user_id, body, is_author_reply) VALUES (?, ?, ?, ?)');
        $stmt->execute([(int) $recipe['id'], (int) $user['id'], $body, $isAuthor ? 1 : 0]);
        flash('success', 'Comment posted.');
        redirect('recipe.php?slug=' . $slug);
    }
}

require __DIR__ . '/includes/header.php';
?>

<article data-recipe data-recipe-id="<?= (int) $recipe['id'] ?>" data-servings="<?= (int) $recipe['servings'] ?>">
    <section class="recipe-hero">
        <img data-parallax src="<?= e($recipe['hero_image_url']) ?>" alt="<?= e($recipe['title']) ?>" width="1600" height="900" fetchpriority="high" decoding="async">
        <div class="recipe-hero__shade"></div>
        <div class="recipe-hero__content">
            <p class="chip"><?= e($recipe['cuisine_name']) ?></p>
            <h1><?= e($recipe['title']) ?></h1>
            <p><?= e($recipe['description']) ?></p>
            <div class="chip-row">
                <span class="chip badge-inline <?= e(food_type_class($recipe['food_type'])) ?>"><?= e(food_type_label($recipe['food_type'])) ?></span>
                <span class="chip"><?= (int) $recipe['prep_time_mins'] ?> min prep</span>
                <span class="chip"><?= (int) $recipe['cook_time_mins'] ?> min cook</span>
                <span class="chip"><?= e(ucfirst(strtolower($recipe['difficulty']))) ?></span>
                <?php if ($rating): ?>
                    <span class="chip">★ <?= e((string) $rating) ?></span>
                <?php endif; ?>
            </div>
            <p>By <a href="<?= e(url('author.php?id=' . $recipe['author_id'])) ?>"><strong><?= e($recipe['author_name']) ?></strong></a>
                · <span data-cooked-count><?= (int) $recipe['cooked_count'] ?></span> cooked</p>
            <div class="engagement">
                <a class="btn btn--accent" href="<?= e(url('cook.php?slug=' . $recipe['slug'])) ?>">Open Cook Mode</a>
                <button class="btn btn--ghost-light" data-action="favorite" data-pop type="button">Save</button>
                <button class="btn btn--ghost-light" data-action="like" data-pop type="button">Like</button>
                <button class="btn btn--ghost-light" data-action="cooked" type="button">I cooked this</button>
                <button class="btn btn--ghost-light" type="button" onclick="window.print()">Print</button>
            </div>
        </div>
    </section>

    <div class="container recipe-layout">
        <div>
            <?php if (!empty($recipe['video_clip_url'])): ?>
            <section class="panel recipe-video-panel" data-reveal>
                <h2>Watch the cooking clip</h2>
                <div class="recipe-video">
                    <video
                        data-recipe-video
                        controls
                        playsinline
                        muted
                        loop
                        preload="metadata"
                        poster="<?= e($recipe['hero_image_url']) ?>"
                        src="<?= e($recipe['video_clip_url']) ?>">
                        Your browser does not support video playback.
                    </video>
                    <button type="button" class="btn btn--ghost recipe-video__unmute" data-unmute-video>Tap to unmute</button>
                </div>
            </section>
            <?php endif; ?>

            <section class="panel" data-reveal>
                <h2>Preparation steps</h2>
                <div class="steps">
                    <?php foreach ($steps as $step): ?>
                        <div class="step">
                            <div class="step__num"><?= (int) $step['step_number'] ?></div>
                            <div>
                                <p><?= e($step['instruction']) ?></p>
                                <?php if (!empty($step['timer_seconds'])): ?>
                                    <div class="timer" data-timer="<?= (int) $step['timer_seconds'] ?>">
                                        <span class="timer__display" data-timer-display>00:00</span>
                                        <button class="btn btn--primary" type="button" data-timer-start>Start timer</button>
                                        <button class="btn btn--ghost" type="button" data-timer-reset>Reset</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <?php if ($nutrition): ?>
            <section class="panel panel--spaced" data-reveal>
                <h2>Nutrition <small>(per serving)</small></h2>
                <div class="nutrition-grid">
                    <div><span>Calories</span><strong><?= e(format_qty($nutrition['calories'])) ?></strong></div>
                    <div><span>Protein</span><strong><?= e(format_qty($nutrition['protein_g'])) ?>g</strong></div>
                    <div><span>Carbs</span><strong><?= e(format_qty($nutrition['carbs_g'])) ?>g</strong></div>
                    <div><span>Fat</span><strong><?= e(format_qty($nutrition['fat_g'])) ?>g</strong></div>
                    <?php if ($nutrition['fiber_g'] !== null): ?>
                    <div><span>Fibre</span><strong><?= e(format_qty($nutrition['fiber_g'])) ?>g</strong></div>
                    <?php endif; ?>
                    <?php if ($nutrition['sugar_g'] !== null): ?>
                    <div><span>Sugar</span><strong><?= e(format_qty($nutrition['sugar_g'])) ?>g</strong></div>
                    <?php endif; ?>
                    <?php if ($nutrition['sodium_mg'] !== null): ?>
                    <div><span>Sodium</span><strong><?= e(format_qty($nutrition['sodium_mg'])) ?>mg</strong></div>
                    <?php endif; ?>
                </div>
                <div class="nutrition-chart">
                    <?php
                    $p = (float) $nutrition['protein_g'];
                    $c = (float) $nutrition['carbs_g'];
                    $f = (float) $nutrition['fat_g'];
                    $sum = max(1, $p + $c + $f);
                    ?>
                    <div>Protein <div class="bar"><span style="width:<?= round($p / $sum * 100) ?>%"></span></div></div>
                    <div>Carbs <div class="bar"><span style="width:<?= round($c / $sum * 100) ?>%"></span></div></div>
                    <div>Fat <div class="bar"><span style="width:<?= round($f / $sum * 100) ?>%"></span></div></div>
                </div>
            </section>
            <?php endif; ?>

            <section class="panel panel--spaced" data-reveal>
                <h2>Comments</h2>
                <?php if (is_logged_in()): ?>
                    <form method="post" class="comment-form">
                        <div class="form-field">
                            <label for="comment_body">Share a tip or ask a question</label>
                            <textarea id="comment_body" name="comment_body" rows="3" placeholder="What worked well in your kitchen?" required></textarea>
                        </div>
                        <button class="btn btn--primary" type="submit">Post comment</button>
                    </form>
                <?php else: ?>
                    <p><a href="<?= e(url('login.php')) ?>">Sign in</a> to join the discussion.</p>
                <?php endif; ?>

                <?php if (!$comments): ?>
                    <div class="empty-state empty-state--compact">
                        <p>No comments yet. Be the first to share a kitchen tip.</p>
                    </div>
                <?php else: ?>
                    <div class="comment-list">
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment">
                            <div class="comment__meta">
                                <strong><?= e($comment['user_name']) ?></strong>
                                <?php if ($comment['is_author_reply']): ?>
                                    <span class="chip badge-inline status-badge">Author</span>
                                <?php endif; ?>
                            </div>
                            <p><?= e($comment['body']) ?></p>
                        </div>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>

        <aside>
            <div class="panel sticky-panel" data-sticky-panel data-reveal>
                <div class="servings">
                    <div>
                        <strong>Servings</strong>
                        <div><span data-servings-value><?= (int) $recipe['servings'] ?></span> people</div>
                    </div>
                    <div class="servings__controls">
                        <button type="button" data-servings-btn="-1" aria-label="Decrease servings">−</button>
                        <button type="button" data-servings-btn="1" aria-label="Increase servings">+</button>
                    </div>
                </div>
                <h3>Ingredients</h3>
                <ul class="ingredient-list">
                    <?php foreach ($ingredients as $ing): ?>
                        <li>
                            <input type="checkbox" data-ingredient-check>
                            <span>
                                <strong data-base-qty="<?= e((string) $ing['quantity']) ?>"><?= e(format_qty($ing['quantity'])) ?></strong>
                                <?= e($ing['unit']) ?> <?= e($ing['name']) ?>
                                <?= $ing['is_optional'] ? '<em>(optional)</em>' : '' ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </aside>
    </div>

    <?php if ($related): ?>
    <section class="section section--tight">
        <div class="container">
            <div class="section__head">
                <h2>You might also like</h2>
                <p>More dishes from <?= e($recipe['cuisine_name']) ?>.</p>
            </div>
            <div class="recipe-grid">
                <?php foreach ($related as $item) { recipe_card($item); } ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
</article>

<?php require __DIR__ . '/includes/footer.php'; ?>
