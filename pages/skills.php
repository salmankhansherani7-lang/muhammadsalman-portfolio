<?php
/**
 * Skills Section Module
 * Muhammad Salman - AI Engineer Portfolio
 * Inspired by Screenshot 3
 */

defined('SECURE_ACCESS') or die('Direct access forbidden.');

$groupedSkills = get_all_skills_grouped(true);

// CSS mapping for category badge colors
$categoryColorClasses = [
    'ai-ml-dl' => 'ai-ml',
    'genai-rag-agents' => 'gen-ai',
    'robotics-iot' => 'robotics',
    'web-software' => 'web',
    'programming-languages' => 'prog',
    'devops-tools' => 'devops'
];

function get_pill_class(string $label): string {
    $clean = strtolower(trim($label));
    return match ($clean) {
        'mastery' => 'mastery',
        'expert' => 'expert',
        'production' => 'production',
        'advanced' => 'advanced',
        'firmware pro' => 'firmware-pro',
        'core expert' => 'core-expert',
        'backend pro' => 'backend-pro',
        'cloud ready' => 'cloud-ready',
        default => 'expert'
    };
}
?>
<section id="skills" class="site-section">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">
        <?= render_icon('code', 'w-4 h-4') ?>
        <span>Technical Arsenal</span>
      </span>
      <h2 class="section-title">Specialized Skills & <span class="gradient-text">Core Competencies</span></h2>
      <p class="section-subtitle">Production-grade competencies spanning deep learning algorithms, generative agent systems, embedded hardware, and robust web engineering.</p>
    </div>

    <!-- 6-Category Skills Dashboard Grid (Matching Screenshot 3) -->
    <div class="skills-grid">
      <?php foreach ($groupedSkills as $cat): ?>
        <?php $colorClass = $categoryColorClasses[$cat['slug']] ?? 'ai-ml'; ?>
        <div class="glass-card skill-category-card">
          <!-- Category Card Header -->
          <div class="category-card-header">
            <div class="cat-header-left">
              <div class="cat-icon-wrap <?= $colorClass ?>">
                <?= render_icon($cat['icon_name'] ?? 'brain', 'w-6 h-6') ?>
              </div>
              <div class="cat-title-block">
                <h3><?= e($cat['name']) ?></h3>
                <div class="cat-status-badge">
                  <span>●</span>
                  <span><?= e($cat['status_text']) ?></span>
                </div>
              </div>
            </div>
            <span class="cat-count-badge"><?= e($cat['badge_text']) ?></span>
          </div>

          <!-- Skills List -->
          <div class="category-skills-list">
            <?php foreach ($cat['skills'] as $skill): ?>
              <div class="skill-row">
                <div class="skill-meta">
                  <span class="skill-name"><?= e($skill['name']) ?></span>
                  <?php if (!empty($skill['description'])): ?>
                    <span class="skill-desc"><?= e($skill['description']) ?></span>
                  <?php endif; ?>
                </div>
                <span class="skill-pill <?= get_pill_class($skill['proficiency_label']) ?>">
                  <?= e($skill['proficiency_label']) ?>
                </span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

