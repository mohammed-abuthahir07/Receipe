<?php
require_once __DIR__ . '/config/app.php';

$slug = trim($_GET['slug'] ?? '');
$recipe = get_recipe_by_slug($slug);
if (!$recipe) {
    flash('error', 'Recipe not found.');
    redirect('browse.php');
}

$steps = db()->prepare('SELECT step_number, instruction, timer_seconds FROM recipe_steps WHERE recipe_id = ? ORDER BY step_number');
$steps->execute([(int) $recipe['id']]);
$steps = $steps->fetchAll();

$pageTitle = 'Cook Mode · ' . $recipe['title'];
$bodyClass = 'cook-body';
$pageScripts = ['assets/js/cook-mode.js'];
?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title><?= e($pageTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Sora:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(url('assets/css/style.css')) ?>">
</head>
<body class="cook-body">
<script id="cook-steps-data" type="application/json"><?= json_encode($steps, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
<div class="cook-shell"
     data-cook
     data-recipe-url="<?= e(url('recipe.php?slug=' . $recipe['slug'])) ?>">
    <div>
        <a class="cook-exit" href="<?= e(url('recipe.php?slug=' . $recipe['slug'])) ?>">← Exit Cook Mode</a>
        <div class="cook-progress"><span data-cook-bar></span></div>
        <p class="cook-title-meta"><?= e($recipe['title']) ?></p>
    </div>

    <section class="cook-step">
        <h1 data-cook-title>Step</h1>
        <p data-cook-text class="cook-step-text"></p>
        <p data-cook-meta class="cook-step-meta"></p>
        <div class="timer" data-cook-timer hidden>
            <span class="timer__display" data-cook-timer-display>00:00</span>
            <button class="btn btn--accent" type="button" data-cook-timer-start>Start timer</button>
        </div>
    </section>

    <div class="cook-nav">
        <button class="btn btn--ghost" type="button" data-cook-prev>Previous</button>
        <button class="btn btn--accent" type="button" data-cook-next>Next step</button>
    </div>
</div>
<script>
  window.RUCHI = { appUrl: <?= json_encode(APP_URL) ?>, effects: { scrollReveal:false, parallaxHero:false, toasts:false } };
</script>
<script src="<?= e(url('assets/js/cook-mode.js')) ?>"></script>
</body>
</html>
