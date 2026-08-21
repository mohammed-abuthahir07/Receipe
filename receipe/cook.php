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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700&family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
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
        <p style="margin:0;opacity:.75"><?= e($recipe['title']) ?></p>
    </div>

    <section class="cook-step">
        <h1 data-cook-title>Step</h1>
        <p data-cook-text style="font-size:1.25rem;line-height:1.55"></p>
        <p data-cook-meta style="opacity:.7"></p>
        <div class="timer" data-cook-timer hidden>
            <span class="timer__display" data-cook-timer-display style="color:var(--accent)">00:00</span>
            <button class="btn btn--accent" type="button" data-cook-timer-start>Start timer</button>
        </div>
    </section>

    <div class="cook-nav">
        <button class="btn btn--ghost" type="button" data-cook-prev style="color:#fff;border-color:rgba(255,255,255,.25)">Previous</button>
        <button class="btn btn--accent" type="button" data-cook-next>Next step</button>
    </div>
</div>
<script>
  window.RUCHI = { appUrl: <?= json_encode(APP_URL) ?>, effects: { scrollReveal:false, parallaxHero:false, toasts:false } };
</script>
<script src="<?= e(url('assets/js/cook-mode.js')) ?>"></script>
</body>
</html>
