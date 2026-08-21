<?php
require_once dirname(__DIR__) . '/config/app.php';
require_once dirname(__DIR__) . '/includes/mail.php';
require_role(['ADMIN', 'MODERATOR']);

ensure_contact_messages_table();
$messages = db()->query(
    'SELECT id, name, email, message, created_at
     FROM contact_messages
     ORDER BY created_at DESC'
)->fetchAll();

$pageTitle = 'Contact Messages';
require dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section__head">
            <h2>Contact messages</h2>
            <p>Name, email, and query from the contact form.</p>
        </div>
        <nav class="subnav" aria-label="Admin">
            <a href="<?= e(url('admin/index.php')) ?>">Overview</a>
            <a href="<?= e(url('admin/review.php')) ?>">Review queue</a>
            <a href="<?= e(url('admin/cuisines.php')) ?>">Cuisines</a>
            <a class="is-active" href="<?= e(url('admin/messages.php')) ?>">Messages</a>
        </nav>
        <div class="panel" data-reveal>
            <?php if (!$messages): ?>
                <div class="empty-state empty-state--compact">
                    <h3>No messages yet</h3>
                    <p>New contact form queries will appear here.</p>
                </div>
            <?php else: ?>
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Query</th>
                                <th>Sent</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($messages as $row): ?>
                            <tr>
                                <td><?= e($row['name']) ?></td>
                                <td><a href="mailto:<?= e($row['email']) ?>"><?= e($row['email']) ?></a></td>
                                <td><?= nl2br(e($row['message'])) ?></td>
                                <td><?= e((string) $row['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
