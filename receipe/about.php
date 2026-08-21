<?php
require_once __DIR__ . '/config/app.php';
$pageTitle = 'Our Story';
require __DIR__ . '/includes/header.php';
?>

<div class="page-card" data-reveal>
    <h1 style="font-family:var(--font-display)">Our story</h1>
    <p>Ruchi is a Malaysian recipe platform for home cooks who want traditional dishes with modern cooking tools — step timers, serving adjusters, Cook Mode, and clear nutrition.</p>
    <p>We celebrate Malay, Chinese Malaysian, Indian Malaysian, Nyonya, and Sabah & Sarawak kitchens. Every recipe can carry a short cooking clip, structured steps, and community tips from people who actually cook these dishes at home.</p>
    <p>Built for phones in the kitchen: large tap targets, sticky ingredients, and a distraction-free Cook Mode.</p>
    <a class="btn btn--primary" href="<?= e(url('browse.php')) ?>">Explore recipes</a>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
