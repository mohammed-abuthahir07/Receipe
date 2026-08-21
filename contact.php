<?php
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/includes/mail.php';
require_login();

$error = '';
$old = [
    'name' => '',
    'email' => '',
    'message' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['name'] = trim((string) ($_POST['name'] ?? ''));
    $old['email'] = trim((string) ($_POST['email'] ?? ''));
    $old['message'] = trim((string) ($_POST['message'] ?? ''));

    if ($old['name'] === '' || $old['email'] === '' || $old['message'] === '') {
        $error = 'Please fill in your name, email, and message.';
    } elseif (strlen($old['name']) > 100 || strlen($old['email']) > 190 || strlen($old['message']) > 4000) {
        $error = 'Please shorten your message and try again.';
    } elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (save_contact_message($old['name'], $old['email'], $old['message'])) {
        send_contact_query_email($old['name'], $old['email'], $old['message']);
        flash('success', 'Message received. Thank you.');
        redirect('contact.php');
    } else {
        $error = 'The message could not be saved. Please try again.';
    }
}

$pageTitle = 'Contact';
require __DIR__ . '/includes/header.php';
?>

<div class="page-card" data-reveal>
    <h1>Contact Ruchi</h1>
    <p class="lead">Partnerships, recipe corrections, or kitchen stories — send us a note.</p>
    <?php if ($error): ?><p class="form-error" role="alert"><?= e($error) ?></p><?php endif; ?>
    <form method="post">
        <div class="form-field">
            <label for="name">Name</label>
            <input id="name" name="name" placeholder="Your name" autocomplete="name" maxlength="100" value="<?= e($old['name']) ?>" required>
        </div>
        <div class="form-field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" placeholder="you@example.com" autocomplete="email" maxlength="190" value="<?= e($old['email']) ?>" required>
        </div>
        <div class="form-field">
            <label for="message">Message</label>
            <textarea id="message" name="message" rows="5" placeholder="How can we help?" maxlength="4000" required><?= e($old['message']) ?></textarea>
        </div>
        <button class="btn btn--primary" type="submit">Send message</button>
    </form>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
