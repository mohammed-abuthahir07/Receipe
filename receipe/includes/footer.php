</main>
<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <h3><?= e(APP_NAME) ?></h3>
            <p>Traditional Malaysian recipes — Malay, Chinese Malaysian, Indian Malaysian, Nyonya, and Borneo flavours — with cook mode, nutrition, and community tips.</p>
        </div>
        <div>
            <h4>Explore</h4>
            <a href="<?= e(url('browse.php')) ?>">All recipes</a>
            <a href="<?= e(url('cuisine.php?slug=traditional-indian')) ?>">Traditional Indian</a>
            <a href="<?= e(url('cuisine.php?slug=malay')) ?>">Malay</a>
            <a href="<?= e(url('cuisine.php?slug=nyonya')) ?>">Nyonya</a>
            <a href="<?= e(url('contact.php')) ?>">Contact</a>
        </div>
        <div>
            <h4>For cooks</h4>
            <a href="<?= e(url('submit.php')) ?>">Submit a recipe</a>
            <a href="<?= e(url('about.php')) ?>">Our story</a>
            <a href="<?= e(url('register.php')) ?>">Create account</a>
        </div>
    </div>
    <div class="container footer-bottom">
        <p>© <?= date('Y') ?> Ruchi Malaysia · Built for XAMPP (PHP + MySQL)</p>
    </div>
</footer>
<script>
  window.RUCHI = {
    appUrl: <?= json_encode(APP_URL) ?>,
    effects: {
      scrollReveal: true,
      hoverLift: true,
      stickyPanel: true,
      parallaxHero: true,
      toasts: true
    }
  };
</script>
<script src="<?= e(url('assets/js/effects.js')) ?>"></script>
<?php if (!empty($pageScripts)): ?>
    <?php foreach ($pageScripts as $script): ?>
        <script src="<?= e(url($script)) ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>
