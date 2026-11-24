<?php
/**
 * Home / Hero Section Module
 * Muhammad Salman - AI Engineer Portfolio
 */

defined('SECURE_ACCESS') or die('Direct access forbidden.');

$profile = get_profile();
$heroStats = get_hero_stats(true);
$socials = get_social_links(true);
$cvUrl = !empty($profile['cv_download_url']) ? asset($profile['cv_download_url']) : asset('assets/docs/Muhammad_Salman_CV.pdf');
?>
<section id="home" class="hero-section">
  <div class="container">
    <div class="hero-grid">
      <!-- Left Column: Content & Intro -->
      <div class="hero-intro">
        <div class="hero-status-pill">
          <span class="status-dot-pulse"></span>
          <span><?= e($profile['availability_status']) ?></span>
        </div>

        <h1 class="hero-name">
          <span class="gradient-text"><?= e($profile['full_name']) ?></span>
        </h1>

        <div class="hero-typed-wrapper">
          <span id="hero-typed-text"></span>
          <span class="typed-cursor"></span>
        </div>

        <p class="hero-bio">
          <?= e($profile['short_bio']) ?>
        </p>

        <!-- Social Media Profiles -->
        <div class="hero-socials">
          <?php foreach ($socials as $s): ?>
            <a href="<?= e($s['url']) ?>" target="_blank" rel="noopener noreferrer" class="social-icon-btn" title="<?= e($s['platform_name']) ?>" aria-label="<?= e($s['platform_name']) ?>">
              <?= render_icon($s['platform_icon'], 'w-5 h-5') ?>
            </a>
          <?php endforeach; ?>
        </div>

        <!-- Call to Action Buttons -->
        <div class="hero-buttons">
          <a href="#contact" class="btn btn-primary">
            <span>Get In Touch</span>
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
          </a>
          <a href="#portfolio" class="btn btn-secondary">
            <span>View Portfolio</span>
          </a>
          <a href="<?= e($cvUrl) ?>" download="Muhammad_Salman_CV.pdf" class="btn btn-outline">
            <?= render_icon('download', 'w-4 h-4') ?>
            <span>Download CV</span>
          </a>
        </div>
      </div>

      <!-- Right Column: Glowing Avatar & Orbiting Tech Badges -->
      <div class="hero-avatar-area">
        <div class="hero-avatar-wrapper">
          <div class="hero-avatar-inner">
            <img src="<?= asset($profile['avatar_url']) ?>" alt="<?= e($profile['full_name']) ?>" class="hero-avatar-img">
          </div>

          <!-- Orbiting Tech Badges (Matching Screenshot 4) -->
          <div class="floating-tag tag-top-left">
            <span class="tag-badge ai-ml">AI / ML</span>
            <span class="tag-title">Python & PyTorch</span>
          </div>

          <div class="floating-tag tag-top-right">
            <span class="tag-badge hardware">HARDWARE</span>
            <span class="tag-title">IoT & Robotics</span>
          </div>

          <div class="floating-tag tag-bottom-left">
            <span class="tag-badge full-stack">FULL-STACK</span>
            <span class="tag-title">Web & Systems</span>
          </div>

          <div class="floating-tag tag-bottom-right">
            <span class="tag-badge gen-ai">GEN-AI</span>
            <span class="tag-title">LLMs & RAG</span>
          </div>
        </div>

        <!-- 4 Metric Cards (Matching Screenshot 4) -->
        <div class="hero-stats-grid">
          <?php foreach ($heroStats as $st): ?>
            <div class="hero-stat-card">
              <div class="stat-number"><?= e($st['stat_number']) ?></div>
              <div class="stat-label"><?= e($st['stat_label']) ?></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
