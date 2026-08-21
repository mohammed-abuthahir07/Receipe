<?php
require_once dirname(__DIR__) . '/config/app.php';
require_role(['ADMIN', 'MODERATOR']);

$queue = db()->query(
    'SELECT r.*, u.name AS author_name, c.name AS cuisine_name,
            (SELECT COUNT(*) FROM ingredients i WHERE i.recipe_id = r.id) AS ing_count,
            (SELECT COUNT(*) FROM recipe_steps s WHERE s.recipe_id = r.id) AS step_count,
            (SELECT COUNT(*) FROM nutrition_info n WHERE n.recipe_id = r.id) AS has_nutrition
     FROM recipes r
     JOIN users u ON u.id = r.author_id
     JOIN cuisines c ON c.id = r.cuisine_id
     WHERE r.status = \'SUBMITTED\'
     ORDER BY r.created_at ASC'
)->fetchAll();

$publishedIndian = db()->query(
    'SELECT r.title, r.slug, r.video_clip_url, c.name AS cuisine_name
     FROM recipes r
     JOIN cuisines c ON c.id = r.cuisine_id
     WHERE r.status = \'PUBLISHED\' AND c.slug = \'traditional-indian\'
     ORDER BY r.published_at DESC
     LIMIT 8'
)->fetchAll();

$pageTitle = 'Review Queue';
require dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section__head">
            <h2>Submission review queue</h2>
            <p>Authors submit recipes. Open each item, complete the ingredients, preparation, nutrition, and a short video, then publish.</p>
        </div>
        <nav class="subnav" aria-label="Admin">
            <a href="<?= e(url('admin/index.php')) ?>">Overview</a>
            <a class="is-active" href="<?= e(url('admin/review.php')) ?>">Review queue</a>
            <a href="<?= e(url('admin/cuisines.php')) ?>">Cuisines</a>
            <a href="<?= e(url('admin/messages.php')) ?>">Messages</a>
        </nav>
        <div class="panel" data-reveal>
            <?php if (!$queue): ?>
                <div class="empty-state empty-state--compact">
                    <div class="empty-state__icon">✅</div>
                    <h3>Queue is empty</h3>
                    <p>New author submissions will appear here.</p>
                </div>
            <?php else: ?>
                <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Cuisine</th>
                            <th>Checklist</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($queue as $item): ?>
                        <?php
                        $readyBits = [];
                        $readyBits[] = ((int) $item['ing_count'] >= 1 ? '✓' : '✗') . ' ingredients';
                        $readyBits[] = ((int) $item['step_count'] >= 2 ? '✓' : '✗') . ' steps';
                        $readyBits[] = ((int) $item['has_nutrition'] ? '✓' : '✗') . ' nutrition';
                        $readyBits[] = (!empty($item['video_clip_url']) ? '✓' : '✗') . ' video';
                        ?>
                        <tr>
                            <td><?= e($item['title']) ?></td>
                            <td><?= e($item['author_name']) ?></td>
                            <td><?= e($item['cuisine_name']) ?></td>
                            <td><small><?= e(implode(' · ', $readyBits)) ?></small></td>
                            <td>
                                <a class="btn btn--primary btn--sm" href="<?= e(url('admin/edit-recipe.php?id=' . $item['id'])) ?>">
                                    Complete &amp; publish
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($publishedIndian): ?>
        <div class="section__head section__head--spaced">
            <h2>Live Traditional Indian recipes</h2>
            <p>Millet, chinna vengaya (onion), and Kanchipuram classics already on the site.</p>
        </div>
        <div class="panel" data-reveal>
            <div class="table-wrap">
            <table class="table">
                <thead><tr><th>Recipe</th><th>Video</th><th></th></tr></thead>
                <tbody>
                <?php foreach ($publishedIndian as $row): ?>
                    <tr>
                        <td><?= e($row['title']) ?></td>
                        <td><?= !empty($row['video_clip_url']) ? 'Yes' : 'No' ?></td>
                        <td><a href="<?= e(url('recipe.php?slug=' . $row['slug'])) ?>">View</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
