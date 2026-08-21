</main>
<?php $user = $user ?? current_user(); ?>
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand-col">
                <div class="footer-brand">
                    <span class="brand__mark">R</span>
                    <h3><?= e(APP_NAME) ?></h3>
                </div>
                <p>Ruchi is a Malaysian recipe platform dedicated to preserving and celebrating the rich diversity of Malaysian cuisine. Discover authentic recipes from Malay, Chinese Malaysian, Indian Malaysian, Nyonya, and Borneo kitchens, thoughtfully presented with modern tools to make home cooking simple and enjoyable.</p>
                <div class="footer-social" aria-label="Social media" style="display:flex;flex-direction:row;flex-wrap:nowrap;align-items:center;gap:10px;">
                    <a class="footer-social__link" href="<?= e(url('contact.php')) ?>" aria-label="Instagram" style="display:inline-flex;width:40px;height:40px;margin:0;flex:0 0 40px;">
                        <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="currentColor" d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4H7.6m9.65 1.5a1.2 1.2 0 1 1 0 2.4 1.2 1.2 0 0 1 0-2.4M12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10m0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z"/></svg>
                    </a>
                    <a class="footer-social__link" href="<?= e(url('contact.php')) ?>" aria-label="Facebook" style="display:inline-flex;width:40px;height:40px;margin:0;flex:0 0 40px;">
                        <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="currentColor" d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14C17.17 2.09 15.77 2 14.22 2 10.93 2 9 4.03 9 7.32V9.5H6.5v4H9V22h5v-8.5Z"/></svg>
                    </a>
                    <a class="footer-social__link" href="<?= e(url('contact.php')) ?>" aria-label="YouTube" style="display:inline-flex;width:40px;height:40px;margin:0;flex:0 0 40px;">
                        <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="currentColor" d="M10 15l5.19-3L10 9v6m11.56-7.83c.13.47.22 1.1.28 1.9.07.8.1 1.49.1 2.09L22 12c0 2.19-.16 3.8-.44 4.83-.25.9-.83 1.48-1.73 1.73-.47.13-1.33.22-2.65.28-1.3.07-2.49.1-3.59.1L12 19c-4.19 0-6.8-.16-7.83-.44-.9-.25-1.48-.83-1.73-1.73-.13-.47-.22-1.1-.28-1.9-.07-.8-.1-1.49-.1-2.09L2 12c0-2.19.16-3.8.44-4.83.25-.9.83-1.48 1.73-1.73.47-.13 1.33-.22 2.65-.28 1.3-.07 2.49-.1 3.59-.1L12 5c4.19 0 6.8.16 7.83.44.9.25 1.48.83 1.73 1.73Z"/></svg>
                    </a>
                    <a class="footer-social__link" href="<?= e(url('contact.php')) ?>" aria-label="Pinterest" style="display:inline-flex;width:40px;height:40px;margin:0;flex:0 0 40px;">
                        <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="currentColor" d="M9.04 21.54c.96.29 1.93.46 2.96.46a10 10 0 0 0 10-10A10 10 0 0 0 12 2 10 10 0 0 0 2 12c0 4.25 2.67 7.9 6.44 9.34-.08-.78-.15-1.98.03-2.82l1.16-4.92s-.3-.6-.3-1.48c0-1.38.8-2.41 1.8-2.41.85 0 1.26.64 1.26 1.4 0 .86-.54 2.14-.82 3.33-.24.99.5 1.8 1.47 1.8 1.77 0 3.13-1.87 3.13-4.56 0-2.38-1.71-4.04-4.16-4.04-2.82 0-4.48 2.12-4.48 4.31 0 .85.33 1.77.74 2.27a.3.3 0 0 1 .07.28l-.27 1.11c-.04.18-.14.22-.32.13-1.25-.58-2.03-2.4-2.03-3.87 0-3.14 2.28-6.02 6.58-6.02 3.45 0 6.14 2.46 6.14 5.75 0 3.43-2.16 6.2-5.17 6.2-1.01 0-1.96-.52-2.29-1.14l-.62 2.37c-.23.86-.84 1.94-1.25 2.6Z"/></svg>
                    </a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Explore</h4>
                <a href="<?= e(url('browse.php')) ?>">All recipes</a>
                <a href="<?= e(url('cuisine.php?slug=chinese-malaysian')) ?>">Chinese Malaysian</a>
                <a href="<?= e(url('cuisine.php?slug=indian-malaysian')) ?>">Indian Malaysian</a>
                <a href="<?= e(url('cuisine.php?slug=malay')) ?>">Malay</a>
                <a href="<?= e(url('cuisine.php?slug=nyonya')) ?>">Nyonya</a>
                <a href="<?= e(url('cuisine.php?slug=sabah-sarawak')) ?>">Sabah &amp; Sarawak</a>
                <a href="<?= e(url('cuisine.php?slug=traditional-indian')) ?>">Traditional Indian</a>
            </div>
            <div class="footer-pair">
            <div class="footer-col">
                <h4>For cooks</h4>
                <a href="<?= e(url('submit.php')) ?>">Submit a recipe</a>
                <a href="<?= e(url('about.php')) ?>">Our Story</a>
                <?php if ($user): ?>
                    <a href="<?= e(url('account/index.php')) ?>">My Kitchen</a>
                <?php else: ?>
                    <a href="<?= e(url('register.php')) ?>">Create an account</a>
                <?php endif; ?>
            </div>
            <div class="footer-col">
                <h4>Contact us</h4>
                <?php if ($user): ?>
                    <a href="<?= e(url('contact.php')) ?>">Contact</a>
                <?php else: ?>
                    <a href="<?= e(url('login.php')) ?>">Contact</a>
                <?php endif; ?>
                <a href="<?= e(url('privacy.php')) ?>">Privacy policy</a>
                <a href="<?= e(url('terms.php')) ?>">Terms of service</a>
            </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© <?= date('Y') ?> Ruchi Malaysia. All rights reserved.</p>
            <div class="footer-legal">
                <a href="<?= e(url('privacy.php')) ?>">Privacy</a>
                <a href="<?= e(url('terms.php')) ?>">Terms</a>
                <?php if ($user): ?>
                    <a href="<?= e(url('contact.php')) ?>">Support</a>
                <?php else: ?>
                    <a href="<?= e(url('login.php')) ?>">Support</a>
                <?php endif; ?>
            </div>
        </div>
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
