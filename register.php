<?php
require_once __DIR__ . '/config/app.php';

if (is_logged_in()) {
    redirect('account/index.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = register_user($_POST['name'] ?? '', $_POST['email'] ?? '', $_POST['password'] ?? '');
    if ($result['ok']) {
        flash('success', $result['message']);
        redirect('account/index.php');
    }
    $error = $result['message'];
}

$pageTitle = 'Join Ruchi';
require __DIR__ . '/includes/header.php';
?>

<div class="auth-card" data-reveal>
    <h1>Join Ruchi</h1>
    <p class="lead">Save recipes, track what you cook, and build shopping lists.</p>
    <?php if ($error): ?><p class="form-error" role="alert"><?= e($error) ?></p><?php endif; ?>
    <form method="post">
        <div class="form-field">
            <label for="name">Name</label>
            <input id="name" type="text" name="name" placeholder="Your name" autocomplete="name" required>
        </div>
        <div class="form-field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" placeholder="you@example.com" autocomplete="email" required>
        </div>
        <div class="form-field">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" minlength="6" placeholder="At least 6 characters" autocomplete="new-password" required>
            <span class="form-hint">Use at least 6 characters.</span>
        </div>
        <button class="btn btn--primary btn--block" type="submit">Create account</button>
    </form>
    <p class="auth-footer">Already have an account? <a href="<?= e(url('login.php')) ?>">Sign in</a></p>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
