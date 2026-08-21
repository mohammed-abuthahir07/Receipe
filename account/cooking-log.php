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
            <h2>Cooking log</h2>
            <p>Your personal cooking journal.</p>
        </div>
        <nav class="subnav" aria-label="Kitchen">
            <a href="<?= e(url('account/index.php')) ?>">Overview</a>
            <a href="<?= e(url('account/cookbook.php')) ?>">Cookbook</a>
            <a href="<?= e(url('account/shopping-list.php')) ?>">Shopping list</a>
            <a class="is-active" href="<?= e(url('account/cooking-log.php')) ?>">Cooking log</a>
        </nav>
        <?php if (!$logs): ?>
            <div class="empty-state" data-reveal>
                <div class="empty-state__icon">🍳</div>
                <h3>Nothing logged yet</h3>
                <p>Open a recipe and tap <strong>I cooked this</strong> to start your journal.</p>
                <a class="btn btn--primary" href="<?= e(url('browse.php')) ?>">Find a recipe to cook</a>
            </div>
        <?php else: ?>
            <div class="recipe-grid">
                <?php foreach ($logs as $log): ?>
                    <article class="recipe-card" data-reveal>
                        <a class="recipe-card__media" href="<?= e(url('recipe.php?slug=' . $log['slug'])) ?>">
                            <img src="<?= e($log['hero_image_url']) ?>" alt="<?= e($log['title']) ?>" width="400" height="300" loading="lazy" decoding="async">
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
