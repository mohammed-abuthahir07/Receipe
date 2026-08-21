<?php
require_once dirname(__DIR__) . '/config/app.php';
require_role(['ADMIN', 'MODERATOR']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $hero = trim($_POST['hero_image_url'] ?? '');
    if ($name !== '') {
        $slug = slugify($name);
        db()->prepare('INSERT INTO cuisines (name, slug, description, hero_image_url) VALUES (?, ?, ?, ?)')
            ->execute([$name, $slug, $description, $hero ?: null]);
        flash('success', 'Cuisine added.');
        redirect('admin/cuisines.php');
    }
}

$cuisines = get_cuisines();
$pageTitle = 'Manage Cuisines';
require dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section__head">
            <h2>Cuisines</h2>
            <p>Manage Malaysian cuisine landings.</p>
        </div>
        <div class="panel" data-reveal style="margin-bottom:1.25rem">
            <h3>Add cuisine</h3>
            <form method="post">
                <div class="form-field"><label>Name</label><input name="name" required></div>
                <div class="form-field"><label>Description</label><textarea name="description" rows="2"></textarea></div>
                <div class="form-field"><label>Hero image URL</label><input name="hero_image_url"></div>
                <button class="btn btn--primary" type="submit">Add</button>
            </form>
        </div>
        <div class="panel" data-reveal>
            <table class="table">
                <thead><tr><th>Name</th><th>Slug</th><th></th></tr></thead>
                <tbody>
                <?php foreach ($cuisines as $c): ?>
                    <tr>
                        <td><?= e($c['name']) ?></td>
                        <td><?= e($c['slug']) ?></td>
                        <td><a href="<?= e(url('cuisine.php?slug=' . $c['slug'])) ?>">View</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
