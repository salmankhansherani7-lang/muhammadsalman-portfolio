<?php
/**
 * About Section Module
 * Muhammad Salman - AI Engineer Portfolio
 * Inspired by Screenshot 2
 */

defined('SECURE_ACCESS') or die('Direct access forbidden.');

$profile = get_profile();
?>
<section id="about" class="site-section">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">
        <?= render_icon('brain', 'w-4 h-4') ?>
        <span>Identity & Background</span>
      </span>
      <h2 class="section-title">Engineering Intelligence from <span class="gradient-text">Concept to Scale</span></h2>
      <p class="section-subtitle">Bridging mathematical algorithms with physical hardware and enterprise software architectures.</p>
    </div>

    <div class="about-grid">
      <!-- Left: Identity Information Card (Matching Screenshot 2) -->
      <div class="glass-card about-card">
        <div class="about-card-photo-wrapper">
          <img src="<?= asset($profile['avatar_url']) ?>" alt="<?= e($profile['full_name']) ?>" class="about-card-photo">
          <div class="about-card-name-overlay">
            <div class="about-card-role-title"><?= e($profile['profession']) ?></div>
            <div class="about-card-name"><?= e($profile['full_name']) ?></div>
          </div>
        </div>

        <!-- Pill Row: Specialization & Availability -->
        <div class="about-pills-row">
          <div class="about-pill-box">
            <div class="about-pill-label">Specialization</div>
            <div class="about-pill-val">AI & Systems</div>
          </div>
          <div class="about-pill-box">
            <div class="about-pill-label">Availability</div>
            <div class="about-pill-val open">● <?= e($profile['availability_badge'] ?? 'Open') ?></div>
          </div>
        </div>

        <!-- Info List -->
        <div class="about-info-list">
          <div class="about-info-item">
            <span class="about-info-key">BASED IN</span>
            <span class="about-info-value">📍 <?= e($profile['location']) ?></span>
          </div>

          <div class="about-info-item">
            <span class="about-info-key">ACADEMIC DEGREE</span>
            <span class="about-info-value">🎓 <?= e($profile['academic_degree']) ?></span>
          </div>

          <div class="about-info-item">
            <span class="about-info-key">DIRECT CONTACT</span>
            <span class="about-info-value">📞 <?= e($profile['direct_phone']) ?></span>
          </div>

          <div class="about-info-item">
            <span class="about-info-key">PRIMARY EMAIL</span>
            <span class="about-info-value">✉️ <?= e($profile['direct_email']) ?></span>
          </div>
        </div>

        <!-- Curriculum Vitae Action -->
        <a href="<?= BASE_URL ?>/cv.php" class="about-cv-action-btn">
          <span>View CV (ATS Standard)</span>
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
          </svg>
        </a>
      </div>

      <!-- Right: Detailed Narrative & Core Focus Pillars -->
      <div class="about-narrative">
        <p class="about-lead">
          I am an <span class="gradient-text"><?= e($profile['profession']) ?></span> committed to building high-performance AI solutions that transform complex data into autonomous decisions.
        </p>

        <p class="about-desc">
          <?= nl2br(e($profile['full_bio'])) ?>
        </p>

        <!-- 4 Core Pillars Grid -->
        <div class="about-highlights-grid">
          <div class="glass-card about-highlight-card">
            <div class="highlight-icon-wrap">
              <?= render_icon('brain', 'w-6 h-6') ?>
            </div>
            <div>
              <h4 class="highlight-title">Applied Deep Learning</h4>
              <p class="highlight-desc">Developing custom neural architectures, fine-tuning computer vision pipelines, and deploying robust real-time inference models.</p>
            </div>
          </div>

          <div class="glass-card about-highlight-card">
            <div class="highlight-icon-wrap">
              <?= render_icon('sparkles', 'w-6 h-6') ?>
            </div>
            <div>
              <h4 class="highlight-title">Agentic AI & RAG</h4>
              <p class="highlight-desc">Designing multi-agent collaboration frameworks with CrewAI & LangGraph, vector search engines, and deterministic tool-calling.</p>
            </div>
          </div>

          <div class="glass-card about-highlight-card">
            <div class="highlight-icon-wrap">
              <?= render_icon('cpu', 'w-6 h-6') ?>
            </div>
            <div>
              <h4 class="highlight-title">Edge IoT & Robotics</h4>
              <p class="highlight-desc">Developing low-latency ESP32 C++ firmware, sensor fusion telemetry, and wireless mesh networks operating with sub-20ms latency.</p>
            </div>
          </div>

          <div class="glass-card about-highlight-card">
            <div class="highlight-icon-wrap">
              <?= render_icon('layout', 'w-6 h-6') ?>
            </div>
            <div>
              <h4 class="highlight-title">Full-Stack Architecture</h4>
              <p class="highlight-desc">Engineering secure, maintainable web systems, performant RESTful APIs, and responsive glassmorphism interfaces.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

