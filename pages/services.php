<?php
/**
 * Services Section Module
 * Muhammad Salman - AI Engineer Portfolio
 */

defined('SECURE_ACCESS') or die('Direct access forbidden.');

$services = get_services(true);
?>
<section id="services" class="site-section">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">
        <?= render_icon('cpu', 'w-4 h-4') ?>
        <span>Solutions & Capabilities</span>
      </span>
      <h2 class="section-title">Specialized AI & Engineering <span class="gradient-text">Services</span></h2>
      <p class="section-subtitle">Delivering high-performance, robust engineering solutions from initial proof-of-concept to production deployment.</p>
    </div>

    <div class="services-grid">
      <?php foreach ($services as $srv): ?>
        <div class="glass-card service-card">
          <div class="service-icon-box">
            <?= render_icon($srv['icon_name'] ?? 'cpu', 'w-6 h-6') ?>
          </div>

          <h3 class="service-title"><?= e($srv['title']) ?></h3>
          <p class="service-desc"><?= e($srv['short_desc']) ?></p>

          <?php if (!empty($srv['deliverables'])): ?>
            <ul class="service-deliverables">
              <?php foreach (explode(',', $srv['deliverables']) as $item): ?>
                <li class="service-deliverable-item">
                  <?= render_icon('check-circle', 'w-4 h-4') ?>
                  <span><?= e(trim($item)) ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

