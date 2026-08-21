<?php
require_once __DIR__ . '/config/app.php';

if (is_logged_in()) {
    redirect('account/index.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    if (attempt_login($email, $password)) {
        flash('success', 'Welcome back!');
        redirect('account/index.php');
    }
    $error = 'Invalid email or password.';
}

$pageTitle = 'Sign in';
require __DIR__ . '/includes/header.php';
?>

<div class="auth-card" data-reveal>
    <h1>Sign in to Ruchi</h1>
    <p class="lead">Welcome back. Sign in to save recipes, log what you cook, and manage your kitchen.</p>
    <?php if ($error): ?><p class="form-error" role="alert"><?= e($error) ?></p><?php endif; ?>
    <form method="post">
        <div class="form-field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" placeholder="you@example.com" autocomplete="email" required>
        </div>
        <div class="form-field">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
        </div>
        <button class="btn btn--primary btn--block" type="submit">Sign in</button>
    </form>
    <p class="auth-footer">New here? <a href="<?= e(url('register.php')) ?>">Create an account</a></p>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
