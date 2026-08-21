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
        <div class="panel" data-reveal style="display:flex;gap:1.25rem;align-items:center;flex-wrap:wrap">
            <img src="<?= e($author['avatar_url'] ?: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=200&h=200&fit=crop') ?>"
                 alt="<?= e($author['name']) ?>"
                 style="width:96px;height:96px;border-radius:24px;object-fit:cover">
            <div>
                <h1 style="font-family:var(--font-display);margin:0"><?= e($author['name']) ?></h1>
                <p style="color:var(--muted);max-width:40rem"><?= e($author['bio'] ?: 'Home cook on Ruchi.') ?></p>
                <p><strong><?= count($recipes) ?></strong> published recipes
                    <?= $author['is_verified_author'] ? ' · Verified author' : '' ?></p>
            </div>
        </div>

        <div class="section__head" style="margin-top:2rem">
            <h2>Recipes by <?= e($author['name']) ?></h2>
        </div>
        <div class="recipe-grid">
            <?php foreach ($recipes as $recipe) { recipe_card($recipe); } ?>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
