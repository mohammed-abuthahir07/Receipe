<?php
require_once dirname(__DIR__) . '/config/app.php';
require_login();
$user = current_user();

$favCount = db()->prepare('SELECT COUNT(*) FROM favorites WHERE user_id = ?');
$favCount->execute([(int) $user['id']]);
$favCount = (int) $favCount->fetchColumn();

$cookedCount = db()->prepare('SELECT COUNT(*) FROM cooked_logs WHERE user_id = ?');
$cookedCount->execute([(int) $user['id']]);
$cookedCount = (int) $cookedCount->fetchColumn();

$pageTitle = 'My Kitchen';
require dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section__head" data-reveal>
            <h2>My Kitchen</h2>
            <p>Welcome, <?= e($user['name']) ?>.</p>
        </div>
        <div class="dashboard-grid" data-reveal>
            <div class="stat"><span>Saved recipes</span><strong><?= $favCount ?></strong></div>
            <div class="stat"><span>Cooked log</span><strong><?= $cookedCount ?></strong></div>
            <div class="stat"><span>Role</span><strong style="font-size:1.3rem"><?= e($user['role']) ?></strong></div>
        </div>
        <div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-top:1.5rem" data-reveal>
            <a class="btn btn--primary" href="<?= e(url('account/cookbook.php')) ?>">Cookbook</a>
            <a class="btn btn--ghost" href="<?= e(url('account/shopping-list.php')) ?>">Shopping list</a>
            <a class="btn btn--ghost" href="<?= e(url('account/cooking-log.php')) ?>">Cooking log</a>
            <a class="btn btn--ghost" href="<?= e(url('browse.php')) ?>">Find recipes</a>
        </div>
    </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
