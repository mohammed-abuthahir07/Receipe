<?php
require_once __DIR__ . '/config/app.php';
$pageTitle = 'Terms of Service';
require __DIR__ . '/includes/header.php';
?>

<div class="page-card" data-reveal>
    <h1>Terms of service</h1>
    <p class="lead">The ground rules for using Ruchi as a home cook or recipe author.</p>
    <h2>Using Ruchi</h2>
    <p>Ruchi is a recipe platform for home cooks. You may browse published recipes freely. Features such as saving recipes, logging the dishes you cook, and submitting dishes require an account.</p>
    <h2>Recipe submissions</h2>
    <p>Authors submit recipes for review. An admin completes the ingredients, preparation, nutrition, and video before a recipe is published. You must only submit content you have the right to share.</p>
    <h2>Community standards</h2>
    <p>Comments and tips should be helpful and respectful. We may remove content that is harmful, misleading, or off-topic.</p>
    <h2>Contact</h2>
    <p>If you need help with these terms, <a href="<?= e(url('contact.php')) ?>">contact Ruchi</a>.</p>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
