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
    <h1 style="font-family:var(--font-display);margin-top:0">Join Ruchi</h1>
    <p style="color:var(--muted)">Save recipes, track what you cook, and build shopping lists.</p>
    <?php if ($error): ?><p style="color:var(--danger)"><?= e($error) ?></p><?php endif; ?>
    <form method="post">
        <div class="form-field">
            <label for="name">Name</label>
            <input id="name" type="text" name="name" required>
        </div>
        <div class="form-field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" required>
        </div>
        <div class="form-field">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" minlength="6" required>
        </div>
        <button class="btn btn--primary" type="submit">Create account</button>
    </form>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
