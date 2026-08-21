<?php
require_once dirname(__DIR__) . '/config/app.php';
require_role(['ADMIN', 'MODERATOR']);

$counts = [
    'recipes' => (int) db()->query('SELECT COUNT(*) FROM recipes')->fetchColumn(),
    'published' => (int) db()->query('SELECT COUNT(*) FROM recipes WHERE status = \'PUBLISHED\'')->fetchColumn(),
    'queue' => (int) db()->query('SELECT COUNT(*) FROM recipes WHERE status = \'SUBMITTED\'')->fetchColumn(),
    'users' => (int) db()->query('SELECT COUNT(*) FROM users')->fetchColumn(),
    'comments' => (int) db()->query('SELECT COUNT(*) FROM comments')->fetchColumn(),
];

$pageTitle = 'Admin';
require dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section__head">
            <h2>Admin panel</h2>
            <p>Moderation, curation, and platform health.</p>
        </div>
        <nav class="subnav" aria-label="Admin">
            <a class="is-active" href="<?= e(url('admin/index.php')) ?>">Overview</a>
            <a href="<?= e(url('admin/review.php')) ?>">Review queue</a>
            <a href="<?= e(url('admin/cuisines.php')) ?>">Cuisines</a>
            <a href="<?= e(url('admin/messages.php')) ?>">Messages</a>
        </nav>
        <div class="dashboard-grid" data-reveal>
            <div class="stat"><span>Published recipes</span><strong><?= $counts['published'] ?></strong></div>
            <div class="stat"><span>Review queue</span><strong><?= $counts['queue'] ?></strong></div>
            <div class="stat"><span>Users</span><strong><?= $counts['users'] ?></strong></div>
        </div>
        <div class="action-row">
            <a class="btn btn--primary" href="<?= e(url('admin/review.php')) ?>">Review &amp; complete recipes</a>
            <a class="btn btn--ghost" href="<?= e(url('browse.php?cuisine=traditional-indian')) ?>">Traditional Indian</a>
            <a class="btn btn--ghost" href="<?= e(url('admin/cuisines.php')) ?>">Manage cuisines</a>
        </div>
        <div class="panel panel--spaced" data-reveal>
            <h3>Quick analytics</h3>
            <p>Total recipes: <?= $counts['recipes'] ?> · Comments: <?= $counts['comments'] ?></p>
            <p class="form-hint">Top recipes by views</p>
            <?php
            $top = db()->query('SELECT title, slug, view_count, cooked_count FROM recipes WHERE status=\'PUBLISHED\' ORDER BY view_count DESC LIMIT 5')->fetchAll();
            ?>
            <?php if (!$top): ?>
                <div class="empty-state empty-state--compact">
                    <p>No published recipes to rank yet.</p>
                </div>
            <?php else: ?>
            <div class="table-wrap">
            <table class="table">
                <thead><tr><th>Recipe</th><th>Views</th><th>Cooked</th></tr></thead>
                <tbody>
                <?php foreach ($top as $row): ?>
                    <tr>
                        <td><a href="<?= e(url('recipe.php?slug=' . $row['slug'])) ?>"><?= e($row['title']) ?></a></td>
                        <td><?= (int) $row['view_count'] ?></td>
                        <td><?= (int) $row['cooked_count'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
