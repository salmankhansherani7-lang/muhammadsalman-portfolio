<?php
/**
 * Public Website Footer
 * Muhammad Salman - AI Engineer Portfolio
 */

defined('SECURE_ACCESS') or die('Direct access forbidden.');

$profile = get_profile();
$socials = get_social_links(true);
$services = get_services(true);
$tagline = get_setting('footer_tagline', 'Engineered with precision for intelligence, autonomy, and speed.');
?>
    <!-- Site Footer (No admin links) -->
    <footer class="site-footer">
      <div class="container">
        <div class="footer-top">
          <div class="footer-brand">
            <h3><?= e($profile['full_name']) ?></h3>
            <p class="brand-role" style="margin-bottom: 0.85rem;"><?= e($profile['profession']) ?></p>
            <p class="footer-tagline"><?= e($tagline) ?></p>
            <div class="hero-socials" style="margin-bottom: 0;">
              <?php foreach ($socials as $s): ?>
                <a href="<?= e($s['url']) ?>" target="_blank" rel="noopener noreferrer" class="social-icon-btn" aria-label="<?= e($s['platform_name']) ?>">
                  <?= render_icon($s['platform_icon'], 'w-4 h-4') ?>
                </a>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="footer-col">
            <h4 class="footer-col-title">Navigation</h4>
            <ul class="footer-links">
              <li><a href="#home" class="footer-link">Home</a></li>
              <li><a href="#about" class="footer-link">About Identity</a></li>
              <li><a href="#skills" class="footer-link">Technical Skills</a></li>
              <li><a href="#portfolio" class="footer-link">Portfolio Projects</a></li>
              <li><a href="#experience" class="footer-link">Experience & Education</a></li>
              <li><a href="#certifications" class="footer-link">Certifications</a></li>
              <li><a href="#contact" class="footer-link">Get In Touch</a></li>
              <li><a href="<?= BASE_URL ?>/cv.php" class="footer-link">Official Curriculum Vitae</a></li>
            </ul>
          </div>

          <div class="footer-col">
            <h4 class="footer-col-title">Core Services</h4>
            <ul class="footer-links">
              <?php foreach (array_slice($services, 0, 5) as $srv): ?>
                <li><a href="#services" class="footer-link"><?= e($srv['title']) ?></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>

        <div class="footer-bottom">
          <p>&copy; <?= date('Y') ?> <?= e($profile['full_name']) ?>. All Rights Reserved. Built with performance & security.</p>
          <button id="back-to-top" class="back-to-top-btn" aria-label="Back to top">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"></path>
            </svg>
          </button>
        </div>
      </div>
    </footer>
  </div><!-- /.main-wrapper -->

  <!-- Project Details Glass Modal -->
  <div id="project-modal" class="modal-overlay" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-container glass-card">
      <button id="modal-close-btn" class="modal-close-btn" aria-label="Close modal">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>

      <div style="position: relative; width: 100%; height: 260px; border-radius: var(--radius-md); overflow: hidden; margin-bottom: 1.5rem; background: #080c18;">
        <img id="modal-project-img" src="" alt="Project Preview" style="width: 100%; height: 100%; object-fit: cover;">
        <span id="modal-project-badge" class="project-badge-overlay"></span>
      </div>

      <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 0.85rem;">
        <div>
          <span id="modal-project-domain" style="font-size: 0.8rem; font-weight: 600; color: var(--accent-cyan-light); text-transform: uppercase;"></span>
          <h3 id="modal-project-title" style="font-size: 1.6rem; color: #ffffff; margin-top: 0.25rem;"></h3>
        </div>
        <div style="display: flex; gap: 0.75rem;">
          <a id="modal-project-demo" href="#" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm">
            <?= render_icon('external-link', 'w-4 h-4') ?>
            <span>Live Demo</span>
          </a>
          <a id="modal-project-github" href="#" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm">
            <?= render_icon('github', 'w-4 h-4') ?>
            <span>GitHub</span>
          </a>
        </div>
      </div>

      <p id="modal-project-desc" style="color: var(--text-muted); line-height: 1.7; font-size: 0.95rem; margin-bottom: 1.5rem;"></p>

      <div style="padding-top: 1rem; border-top: 1px solid var(--border-subtle);">
        <p style="font-size: 0.8rem; font-weight: 700; color: var(--text-dim); text-transform: uppercase; margin-bottom: 0.5rem;">Technologies Used</p>
        <div id="modal-project-tags" class="project-tags"></div>
      </div>
    </div>
  </div>

  <!-- JavaScript Libraries & Modules -->
  <script src="<?= asset('assets/js/network.js') ?>"></script>
  <script src="<?= asset('assets/js/main.js') ?>"></script>
</body>
</html>

