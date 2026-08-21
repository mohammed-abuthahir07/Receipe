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
            <p>Manage Malaysian cuisine landing pages.</p>
        </div>
        <nav class="subnav" aria-label="Admin">
            <a href="<?= e(url('admin/index.php')) ?>">Overview</a>
            <a href="<?= e(url('admin/review.php')) ?>">Review queue</a>
            <a class="is-active" href="<?= e(url('admin/cuisines.php')) ?>">Cuisines</a>
            <a href="<?= e(url('admin/messages.php')) ?>">Messages</a>
        </nav>
        <div class="panel panel--spaced" data-reveal>
            <h3>Add cuisine</h3>
            <form method="post">
                <div class="form-field">
                    <label for="name">Name</label>
                    <input id="name" name="name" placeholder="Cuisine name" required>
                </div>
                <div class="form-field">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="2" placeholder="Short description of this cuisine"></textarea>
                </div>
                <div class="form-field">
                    <label for="hero_image_url">Hero image URL</label>
                    <input id="hero_image_url" name="hero_image_url" placeholder="https://...">
                </div>
                <button class="btn btn--primary" type="submit">Add cuisine</button>
            </form>
        </div>
        <div class="panel" data-reveal>
            <div class="table-wrap">
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
                <?php if (!$cuisines): ?>
                    <tr><td colspan="3">No cuisines yet.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
