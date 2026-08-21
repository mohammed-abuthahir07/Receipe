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

$roleLabel = ucfirst(strtolower($user['role']));

$pageTitle = 'My Kitchen';
require dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section__head" data-reveal>
            <h2>My Kitchen</h2>
            <p>Welcome, <?= e($user['name']) ?>.</p>
        </div>
        <nav class="subnav" data-reveal aria-label="Kitchen">
            <a class="is-active" href="<?= e(url('account/index.php')) ?>">Overview</a>
            <a href="<?= e(url('account/cookbook.php')) ?>">Cookbook</a>
            <a href="<?= e(url('account/shopping-list.php')) ?>">Shopping list</a>
            <a href="<?= e(url('account/cooking-log.php')) ?>">Cooking log</a>
        </nav>
        <div class="dashboard-grid" data-reveal>
            <div class="stat"><span>Saved recipes</span><strong><?= $favCount ?></strong></div>
            <div class="stat"><span>Cooking log</span><strong><?= $cookedCount ?></strong></div>
            <div class="stat"><span>Role</span><strong class="stat__role"><?= e($roleLabel) ?></strong></div>
        </div>
        <div class="action-row" data-reveal>
            <a class="btn btn--primary" href="<?= e(url('account/cookbook.php')) ?>">Cookbook</a>
            <a class="btn btn--ghost" href="<?= e(url('account/shopping-list.php')) ?>">Shopping list</a>
            <a class="btn btn--ghost" href="<?= e(url('account/cooking-log.php')) ?>">Cooking log</a>
            <a class="btn btn--ghost" href="<?= e(url('browse.php')) ?>">Find recipes</a>
        </div>
    </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
