<?php
require_once dirname(__DIR__) . '/config/app.php';
require_role(['AUTHOR', 'ADMIN', 'MODERATOR']);
$user = current_user();

$stats = db()->prepare(
    'SELECT
        COUNT(*) AS total,
        SUM(status = \'PUBLISHED\') AS published,
        SUM(status = \'SUBMITTED\') AS submitted,
        SUM(status = \'DRAFT\') AS drafts,
        COALESCE(SUM(view_count),0) AS views,
        COALESCE(SUM(cooked_count),0) AS cooked
     FROM recipes WHERE author_id = ?'
);
$stats->execute([(int) $user['id']]);
$stats = $stats->fetch();

$recipes = db()->prepare('SELECT id, title, slug, status, view_count, cooked_count, created_at FROM recipes WHERE author_id = ? ORDER BY created_at DESC');
$recipes->execute([(int) $user['id']]);
$recipes = $recipes->fetchAll();

$pageTitle = 'Author Dashboard';
require dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section__head">
            <h2>Author dashboard</h2>
            <p>Track performance and manage submissions.</p>
        </div>
        <div class="dashboard-grid" data-reveal>
            <div class="stat"><span>Published</span><strong><?= (int) $stats['published'] ?></strong></div>
            <div class="stat"><span>Total views</span><strong><?= (int) $stats['views'] ?></strong></div>
            <div class="stat"><span>Times cooked</span><strong><?= (int) $stats['cooked'] ?></strong></div>
        </div>
        <p style="margin:1.5rem 0"><a class="btn btn--primary" href="<?= e(url('submit.php')) ?>">New recipe</a></p>
        <div class="panel" data-reveal>
            <table class="table">
                <thead>
                    <tr><th>Title</th><th>Status</th><th>Views</th><th>Cooked</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($recipes as $r): ?>
                        <tr>
                            <td>
                                <?php if ($r['status'] === 'PUBLISHED'): ?>
                                    <a href="<?= e(url('recipe.php?slug=' . $r['slug'])) ?>"><?= e($r['title']) ?></a>
                                <?php else: ?>
                                    <?= e($r['title']) ?>
                                <?php endif; ?>
                            </td>
                            <td><?= e($r['status']) ?></td>
                            <td><?= (int) $r['view_count'] ?></td>
                            <td><?= (int) $r['cooked_count'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (!$recipes): ?>
                        <tr><td colspan="4">No recipes yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
