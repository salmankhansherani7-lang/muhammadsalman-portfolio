<?php
/**
 * Certifications Section Module
 * Muhammad Salman - AI Engineer Portfolio
 */

defined('SECURE_ACCESS') or die('Direct access forbidden.');

$certifications = get_certifications(true);
?>
<section id="certifications" class="site-section">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">
        <?= render_icon('award', 'w-4 h-4') ?>
        <span>Verified Credentials</span>
      </span>
      <h2 class="section-title">Professional Accreditations & <span class="gradient-text">Certifications</span></h2>
      <p class="section-subtitle">Industry-recognized specializations validating mastery in Artificial Intelligence, Deep Learning, Cloud, and Embedded Systems.</p>
    </div>

    <div class="certifications-grid">
      <?php foreach ($certifications as $cert): ?>
        <div class="glass-card cert-card">
          <div class="cert-header">
            <div class="cert-icon">
              <?= render_icon('award', 'w-5 h-5') ?>
            </div>
            <span class="cert-year"><?= e($cert['issue_year']) ?></span>
          </div>

          <h3 class="cert-title"><?= e($cert['title']) ?></h3>
          <p class="cert-issuer">Issued by: <?= e($cert['issuer']) ?></p>

          <div class="cert-footer">
            <span class="cert-id"><?= e($cert['credential_id']) ?></span>
            <?php if (!empty($cert['credential_url']) && $cert['credential_url'] !== '#'): ?>
              <?php
                $url = $cert['credential_url'];
                $href = (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) ? $url : asset($url);
              ?>
              <a href="<?= e($href) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm" style="padding: 0.25rem 0.75rem; font-size: 0.75rem; gap: 0.4rem;" title="View Official Certificate">
                <span style="color: #34d399;">●</span>
                <span>Verified</span>
                <?= render_icon('external-link', 'w-3 h-3') ?>
              </a>
            <?php else: ?>
              <span style="font-size: 0.75rem; color: #34d399; font-weight: 600; display: flex; align-items: center; gap: 0.25rem;">
                <?= render_icon('check-circle', 'w-3.5 h-3.5') ?>
                <span>Verified</span>
              </span>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

