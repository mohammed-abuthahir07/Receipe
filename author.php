<?php
require_once __DIR__ . '/config/app.php';

$id = (int) ($_GET['id'] ?? 0);
$stmt = db()->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$id]);
$author = $stmt->fetch();

if (!$author) {
    flash('error', 'Author not found.');
    redirect('browse.php');
}

$pageTitle = $author['name'];
$recipes = db()->prepare(
    'SELECT r.*, c.name AS cuisine_name, c.slug AS cuisine_slug,
            (SELECT AVG(stars) FROM ratings rt WHERE rt.recipe_id = r.id) AS avg_rating
     FROM recipes r
     JOIN cuisines c ON c.id = r.cuisine_id
     WHERE r.author_id = ? AND r.status = \'PUBLISHED\'
     ORDER BY r.published_at DESC'
);
$recipes->execute([$id]);
$recipes = $recipes->fetchAll();

require __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="panel author-profile" data-reveal>
            <img src="<?= e($author['avatar_url'] ?: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=200&h=200&fit=crop') ?>"
                 alt="<?= e($author['name']) ?>" width="104" height="104" loading="lazy" decoding="async">
            <div>
                <h1><?= e($author['name']) ?></h1>
                <p><?= e($author['bio'] ?: 'Home cook on Ruchi.') ?></p>
                <p><strong><?= count($recipes) ?></strong> published <?= count($recipes) === 1 ? 'recipe' : 'recipes' ?>
                    <?= $author['is_verified_author'] ? ' · Verified author' : '' ?></p>
            </div>
        </div>

        <div class="section__head section__head--spaced">
            <h2>Recipes by <?= e($author['name']) ?></h2>
        </div>
        <?php if (!$recipes): ?>
            <div class="empty-state" data-reveal>
                <div class="empty-state__icon">👩‍🍳</div>
                <h3>No published recipes yet</h3>
                <p>This cook has not published any recipes yet.</p>
                <a class="btn btn--primary" href="<?= e(url('browse.php')) ?>">Browse recipes</a>
            </div>
        <?php else: ?>
            <div class="recipe-grid">
                <?php foreach ($recipes as $recipe) { recipe_card($recipe); } ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
