<?php
$user = current_user();
$flash = get_flash();
$pageTitle = $pageTitle ?? APP_NAME;
$bodyClass = $bodyClass ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> · <?= e(APP_NAME) ?></title>
    <meta name="description" content="<?= e($pageDescription ?? 'Traditional Malaysian recipes with cook mode, nutrition, and community tips.') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(url('assets/css/style.css')) ?>">
    <?php if (!empty($jsonLd)): ?>
    <script type="application/ld+json"><?= $jsonLd ?></script>
    <?php endif; ?>
</head>
<body class="<?= e($bodyClass) ?>">
<a class="skip-link" href="#main">Skip to content</a>
<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="<?= e(url('index.php')) ?>">
            <span class="brand__mark">R</span>
            <span class="brand__text">
                <strong><?= e(APP_NAME) ?></strong>
                <small><?= e(APP_TAGLINE) ?></small>
            </span>
        </a>
        <button class="nav-toggle" type="button" data-nav-toggle aria-label="Open menu">☰</button>
        <nav class="site-nav" data-site-nav>
            <a href="<?= e(url('browse.php')) ?>">Browse</a>
            <a href="<?= e(url('browse.php?sort=popular')) ?>">Trending</a>
            <a href="<?= e(url('about.php')) ?>">Our Story</a>
            <a href="<?= e(url('submit.php')) ?>">Submit</a>
            <?php if ($user): ?>
                <a href="<?= e(url('account/index.php')) ?>">My Kitchen</a>
                <?php if (in_array($user['role'], ['AUTHOR', 'ADMIN', 'MODERATOR'], true)): ?>
                    <a href="<?= e(url('author-dashboard/index.php')) ?>">Dashboard</a>
                <?php endif; ?>
                <?php if (in_array($user['role'], ['ADMIN', 'MODERATOR'], true)): ?>
                    <a href="<?= e(url('admin/index.php')) ?>">Admin</a>
                <?php endif; ?>
                <a class="btn btn--ghost" href="<?= e(url('logout.php')) ?>">Sign out</a>
            <?php else: ?>
                <a class="btn btn--ghost" href="<?= e(url('login.php')) ?>">Sign in</a>
                <a class="btn btn--primary" href="<?= e(url('register.php')) ?>">Join free</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<?php if ($flash): ?>
<div class="toast toast--<?= e($flash['type']) ?>" data-toast><?= e($flash['message']) ?></div>
<?php endif; ?>

<main id="main">
