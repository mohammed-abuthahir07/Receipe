<?php
require_once __DIR__ . '/config/app.php';

$sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sent = true;
    flash('success', 'Message received — we will reply soon.');
    redirect('contact.php');
}

$pageTitle = 'Contact';
require __DIR__ . '/includes/header.php';
?>

<div class="page-card" data-reveal>
    <h1 style="font-family:var(--font-display)">Contact Ruchi</h1>
    <p style="color:var(--muted)">Partnerships, recipe corrections, or kitchen stories — drop us a note.</p>
    <form method="post">
        <div class="form-field">
            <label for="name">Name</label>
            <input id="name" name="name" required>
        </div>
        <div class="form-field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" required>
        </div>
        <div class="form-field">
            <label for="message">Message</label>
            <textarea id="message" name="message" rows="5" required></textarea>
        </div>
        <button class="btn btn--primary" type="submit">Send message</button>
    </form>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
