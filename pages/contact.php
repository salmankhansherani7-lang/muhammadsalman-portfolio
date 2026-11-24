<?php
/**
 * Contact Section Module
 * Muhammad Salman - AI Engineer Portfolio
 */

defined('SECURE_ACCESS') or die('Direct access forbidden.');

$profile = get_profile();
$socials = get_social_links(true);
$flash = get_flash();
?>
<section id="contact" class="site-section">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">
        <?= render_icon('mail', 'w-4 h-4') ?>
        <span>Get In Touch</span>
      </span>
      <h2 class="section-title">Let's Build Something <span class="gradient-text">Exceptional</span></h2>
      <p class="section-subtitle">Have an intelligent systems project, consultation inquiry, or collaboration opportunity? Send a message directly.</p>
    </div>

    <!-- Flash Feedback Alert -->
    <?php if ($flash): ?>
      <div class="form-alert <?= $flash['type'] === 'success' ? 'success' : 'error' ?>" style="max-width: 800px; margin: 0 auto 2.5rem;">
        <?= render_icon($flash['type'] === 'success' ? 'check-circle' : 'mail', 'w-5 h-5') ?>
        <span><?= e($flash['message']) ?></span>
      </div>
    <?php endif; ?>

    <div class="contact-grid">
      <!-- Left Column: Direct Contact Info Cards -->
      <div class="contact-info-panel">
        <div class="glass-card contact-info-card">
          <div class="contact-icon-box">
            <?= render_icon('mail', 'w-6 h-6') ?>
          </div>
          <div>
            <div class="contact-card-label">Direct Email</div>
            <a href="mailto:<?= e($profile['direct_email']) ?>" class="contact-card-value"><?= e($profile['direct_email']) ?></a>
          </div>
        </div>

        <div class="glass-card contact-info-card">
          <div class="contact-icon-box">
            <?= render_icon('message-circle', 'w-6 h-6') ?>
          </div>
          <div>
            <div class="contact-card-label">Phone / WhatsApp</div>
            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $profile['direct_phone']) ?>" target="_blank" rel="noopener noreferrer" class="contact-card-value">
              <?= e($profile['direct_phone']) ?>
            </a>
          </div>
        </div>

        <div class="glass-card contact-info-card">
          <div class="contact-icon-box">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
          </div>
          <div>
            <div class="contact-card-label">Location Base</div>
            <div class="contact-card-value"><?= e($profile['location']) ?></div>
          </div>
        </div>

        <!-- Professional Network Profiles -->
        <div class="glass-card" style="padding: 1.5rem;">
          <div class="contact-card-label" style="margin-bottom: 0.85rem;">Professional Networks</div>
          <div class="hero-socials" style="margin-bottom: 0;">
            <?php foreach ($socials as $s): ?>
              <a href="<?= e($s['url']) ?>" target="_blank" rel="noopener noreferrer" class="social-icon-btn" aria-label="<?= e($s['platform_name']) ?>" title="<?= e($s['platform_name']) ?>">
                <?= render_icon($s['platform_icon'], 'w-5 h-5') ?>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Right Column: Secure Contact Form -->
      <div class="glass-card contact-form-panel">
        <form action="<?= BASE_URL ?>/index.php#contact" method="POST" class="contact-form">
          <?= csrf_field() ?>
          
          <!-- Honeypot spam trap -->
          <div style="display: none !important;">
            <label for="website_hp">Leave this field blank</label>
            <input type="text" id="website_hp" name="website_hp" value="" tabindex="-1" autocomplete="off">
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="contact-name" class="form-label">Your Name *</label>
              <input type="text" id="contact-name" name="name" class="form-control" placeholder="e.g. John Doe" required maxlength="100">
            </div>

            <div class="form-group">
              <label for="contact-email" class="form-label">Email Address *</label>
              <input type="email" id="contact-email" name="email" class="form-control" placeholder="e.g. john@example.com" required maxlength="150">
            </div>
          </div>

          <div class="form-group">
            <label for="contact-subject" class="form-label">Subject *</label>
            <input type="text" id="contact-subject" name="subject" class="form-control" placeholder="e.g. AI Model Development Collaboration" required maxlength="200">
          </div>

          <div class="form-group">
            <label for="contact-message" class="form-label">Your Message *</label>
            <textarea id="contact-message" name="message" class="form-control" placeholder="Tell me about your technical goals, timeline, or inquiry..." required maxlength="3000"></textarea>
          </div>

          <button type="submit" name="submit_contact" class="btn btn-primary" style="align-self: flex-start; padding: 0.85rem 2.25rem;">
            <?= render_icon('mail', 'w-5 h-5') ?>
            <span>Send Direct Message</span>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>
