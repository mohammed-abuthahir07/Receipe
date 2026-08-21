<?php
require_once dirname(__DIR__) . '/config/app.php';
require_login();
$user = current_user();

// Merge ingredients across saved recipes
$stmt = db()->prepare(
    'SELECT i.name, i.unit, SUM(i.quantity) AS qty, COUNT(*) AS sources
     FROM favorites f
     JOIN ingredients i ON i.recipe_id = f.recipe_id
     WHERE f.user_id = ?
     GROUP BY i.name, i.unit
     ORDER BY i.name'
);
$stmt->execute([(int) $user['id']]);
$items = $stmt->fetchAll();

$pageTitle = 'Shopping List';
require dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section__head">
            <h2>Shopping list</h2>
            <p>Auto-merged from your saved recipes. Check items off as you shop.</p>
        </div>
        <div class="panel" data-reveal>
            <?php if (!$items): ?>
                <p>Save a few recipes first to build a list.</p>
            <?php else: ?>
                <ul class="ingredient-list">
                    <?php foreach ($items as $item): ?>
                        <li>
                            <input type="checkbox" data-ingredient-check onchange="this.closest('li').classList.toggle('is-checked', this.checked)">
                            <span>
                                <strong><?= e(format_qty($item['qty'])) ?></strong>
                                <?= e($item['unit']) ?> <?= e($item['name']) ?>
                                <small style="color:var(--muted)"> · from <?= (int) $item['sources'] ?> recipe(s)</small>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
