<?php
$user = current_user();
$flash = get_flash();
$pageTitle = $pageTitle ?? APP_NAME;
$bodyClass = $bodyClass ?? '';
$uri = $_SERVER['REQUEST_URI'] ?? '';
$scriptName = basename($_SERVER['SCRIPT_NAME'] ?? '');
$scriptDir = basename(dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$isBrowse = $scriptName === 'browse.php';
$isTrending = $isBrowse && str_contains($uri, 'sort=popular');
$isHome = $scriptName === 'index.php' && !in_array($scriptDir, ['account', 'admin', 'author-dashboard'], true);
?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title><?= e($pageTitle) ?> · <?= e(APP_NAME) ?></title>
    <meta name="description" content="<?= e($pageDescription ?? 'Traditional Malaysian recipes with Cook Mode, nutrition, and community tips.') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Sora:wght@600;700&display=swap" rel="stylesheet">
    <?php if (!empty($preloadImage)): ?>
    <link rel="preload" as="image" href="<?= e($preloadImage) ?>" fetchpriority="high">
    <?php endif; ?>
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
        <button class="nav-toggle" type="button" data-nav-toggle aria-label="Open menu" aria-controls="site-nav" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
        <nav class="site-nav" id="site-nav" data-site-nav>
            <a href="<?= e(url('index.php')) ?>" class="<?= $isHome ? 'is-active' : '' ?>">Home</a>
            <a href="<?= e(url('browse.php')) ?>" class="<?= $isBrowse && !$isTrending ? 'is-active' : '' ?>">Browse</a>
            <a href="<?= e(url('browse.php?sort=popular')) ?>" class="<?= $isTrending ? 'is-active' : '' ?>">Trending</a>
            <a href="<?= e(url('about.php')) ?>" class="<?= str_contains($uri, 'about.php') ? 'is-active' : '' ?>">Our Story</a>
            <a href="<?= e(url('submit.php')) ?>" class="<?= str_contains($uri, 'submit.php') ? 'is-active' : '' ?>">Submit</a>
            <?php if ($user): ?>
                <a href="<?= e(url('account/index.php')) ?>" class="<?= str_contains($uri, '/account/') ? 'is-active' : '' ?>">My Kitchen</a>
                <?php if (in_array($user['role'], ['AUTHOR', 'ADMIN', 'MODERATOR'], true)): ?>
                    <a href="<?= e(url('author-dashboard/index.php')) ?>" class="<?= str_contains($uri, 'author-dashboard') ? 'is-active' : '' ?>">Dashboard</a>
                <?php endif; ?>
                <?php if (in_array($user['role'], ['ADMIN', 'MODERATOR'], true)): ?>
                    <a href="<?= e(url('admin/index.php')) ?>" class="<?= str_contains($uri, '/admin/') ? 'is-active' : '' ?>">Admin</a>
                <?php endif; ?>
                <a class="btn btn-nav btn-nav--signout" href="<?= e(url('logout.php')) ?>">Sign out</a>
            <?php else: ?>
                <a class="btn btn-nav btn-nav--signin" href="<?= e(url('login.php')) ?>">Sign in</a>
                <a class="btn btn-nav btn-nav--join" href="<?= e(url('register.php')) ?>">Join for free</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<?php if ($flash): ?>
<div class="toast toast--<?= e($flash['type']) ?>" data-toast><?= e($flash['message']) ?></div>
<?php endif; ?>

<main id="main">
