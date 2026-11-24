<?php
/**
 * Experience & Education Section Module
 * Muhammad Salman - AI Engineer Portfolio
 */

defined('SECURE_ACCESS') or die('Direct access forbidden.');

$experiences = get_experience(true);
$education = get_education(true);
?>
<section id="experience" class="site-section">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">
        <?= render_icon('briefcase', 'w-4 h-4') ?>
        <span>Career Journey</span>
      </span>
      <h2 class="section-title">Professional Experience & <span class="gradient-text">Education</span></h2>
      <p class="section-subtitle">A chronological record of hands-on engineering leadership, systems architecture, and academic background.</p>
    </div>

    <div class="experience-layout">
      <!-- Left Column: Work Experience Timeline -->
      <div>
        <h3 style="font-size: 1.35rem; font-weight: 700; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.65rem;">
          <span style="color: var(--primary);"><?= render_icon('briefcase', 'w-5 h-5') ?></span>
          <span>Applied Engineering Experience</span>
        </h3>

        <div class="timeline">
          <?php foreach ($experiences as $exp): ?>
            <div class="timeline-item">
              <span class="timeline-dot"></span>
              <div class="glass-card timeline-content">
                <div class="timeline-header">
                  <div>
                    <h4 class="timeline-role"><?= e($exp['role_title']) ?></h4>
                    <p class="timeline-company"><?= e($exp['company_name']) ?> • <?= e($exp['location']) ?></p>
                  </div>
                  <span class="timeline-date-chip"><?= e($exp['start_date']) ?> &ndash; <?= e($exp['end_date']) ?></span>
                </div>
                <p class="timeline-desc"><?= nl2br(e($exp['description'])) ?></p>
                <?php if (!empty($exp['tech_stack'])): ?>
                  <div class="timeline-stack">
                    <?php foreach (explode(',', $exp['tech_stack']) as $t): ?>
                      <span class="tag-pill"><?= e(trim($t)) ?></span>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Right Column: Academic Education Timeline -->
      <div>
        <h3 style="font-size: 1.35rem; font-weight: 700; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.65rem;">
          <span style="color: var(--accent-cyan-light);"><?= render_icon('award', 'w-5 h-5') ?></span>
          <span>Academic Background</span>
        </h3>

        <div class="timeline">
          <?php foreach ($education as $edu): ?>
            <div class="timeline-item">
              <span class="timeline-dot" style="background: var(--accent-cyan);"></span>
              <div class="glass-card timeline-content">
                <div class="timeline-header">
                  <div>
                    <h4 class="timeline-role"><?= e($edu['degree_title']) ?></h4>
                    <p class="timeline-company"><?= e($edu['institution']) ?> • <?= e($edu['location']) ?></p>
                  </div>
                  <span class="timeline-date-chip" style="background: rgba(6, 182, 212, 0.15); border-color: rgba(6, 182, 212, 0.3); color: #38bdf8;">
                    <?= e($edu['start_year']) ?> &ndash; <?= e($edu['end_year']) ?>
                  </span>
                </div>
                <?php if (!empty($edu['grade_or_honors'])): ?>
                  <p style="font-size: 0.8rem; font-weight: 700; color: #34d399; margin-bottom: 0.5rem;">
                    🏆 <?= e($edu['grade_or_honors']) ?>
                  </p>
                <?php endif; ?>
                <p class="timeline-desc"><?= nl2br(e($edu['description'])) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

