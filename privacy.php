<?php
require_once __DIR__ . '/config/app.php';
$pageTitle = 'Privacy Policy';
require __DIR__ . '/includes/header.php';
?>

<div class="page-card" data-reveal>
    <h1>Privacy policy</h1>
    <p class="lead">How Ruchi collects, uses, and protects your information.</p>
    <h2>Information we collect</h2>
    <p>When you create an account, we store your name, email address, and the recipes you save, cook, or submit. Recipe pages may also record views and cooking activity so we can show popular dishes.</p>
    <h2>How we use it</h2>
    <p>We use this information to provide your kitchen, publish recipes, moderate submissions, and improve the platform. We do not sell your personal data.</p>
    <h2>Cookies and sessions</h2>
    <p>Ruchi uses a session cookie to keep you signed in while you browse. You can sign out at any time from the header.</p>
    <h2>Contact</h2>
    <p>Questions about privacy? <a href="<?= e(url('contact.php')) ?>">Send us a message</a> and we will help.</p>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
