<?php
require_once dirname(__DIR__) . '/config/app.php';
require_login();
$user = current_user();

$stmt = db()->prepare(
    'SELECT cl.*, r.title, r.slug, r.hero_image_url
     FROM cooked_logs cl
     JOIN recipes r ON r.id = cl.recipe_id
     WHERE cl.user_id = ?
     ORDER BY cl.cooked_at DESC'
);
$stmt->execute([(int) $user['id']]);
$logs = $stmt->fetchAll();

$pageTitle = 'Cooking Log';
require dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section__head">
            <h2>I Cooked This</h2>
            <p>Your personal cooking journal.</p>
        </div>
        <?php if (!$logs): ?>
            <p>Nothing logged yet. Open a recipe and tap <strong>I cooked this</strong>.</p>
        <?php else: ?>
            <div class="recipe-grid">
                <?php foreach ($logs as $log): ?>
                    <article class="recipe-card" data-reveal>
                        <a class="recipe-card__media" href="<?= e(url('recipe.php?slug=' . $log['slug'])) ?>">
                            <img src="<?= e($log['hero_image_url']) ?>" alt="<?= e($log['title']) ?>" loading="lazy">
                        </a>
                        <div class="recipe-card__body">
                            <p class="recipe-card__meta"><?= e(date('d M Y', strtotime($log['cooked_at']))) ?></p>
                            <h3><a href="<?= e(url('recipe.php?slug=' . $log['slug'])) ?>"><?= e($log['title']) ?></a></h3>
                            <?php if ($log['note']): ?><p class="recipe-card__desc"><?= e($log['note']) ?></p><?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
