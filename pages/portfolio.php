<?php
/**
 * Portfolio Section Module
 * Muhammad Salman - AI Engineer Portfolio
 * Inspired by Screenshot 5
 */

defined('SECURE_ACCESS') or die('Direct access forbidden.');

$projects = get_projects(null, true);

// Standard filter categories matching user prompt
$filterCategories = [
    'all' => 'All Projects',
    'AI / Machine Learning' => 'AI (ML, DL)',
    'Web Development' => 'Web Development',
    'Data Analysis' => 'Data Analysis',
    'IoT & Robotics' => 'IoT & Robotics'
];
?>
<section id="portfolio" class="site-section">
  <div class="container">
    <div class="section-header">
      <span class="section-badge">
        <?= render_icon('folder-git-2', 'w-4 h-4') ?>
        <span>Featured Engineering</span>
      </span>
      <h2 class="section-title">Production & Flagship <span class="gradient-text">Projects</span></h2>
      <p class="section-subtitle">Real-world AI implementations, computer vision pipelines, autonomous multi-agent networks, and embedded IoT architectures.</p>
    </div>

    <!-- Category Filter Pills (Matching Screenshot 5) -->
    <div class="portfolio-filters">
      <button class="filter-btn active" data-filter="all">All Projects</button>
      <button class="filter-btn" data-filter="AI / Machine Learning">AI (ML, DL)</button>
      <button class="filter-btn" data-filter="Web Development">Web Development</button>
      <button class="filter-btn" data-filter="Data Analysis">Data Analysis</button>
      <button class="filter-btn" data-filter="IoT & Robotics">IoT & Robotics</button>
    </div>

    <!-- Projects Grid (4 columns on desktop, matching Screenshot 5) -->
    <div class="projects-grid">
      <?php foreach ($projects as $proj): ?>
        <div class="glass-card project-card" data-category="<?= e($proj['category']) ?>">
          <!-- Thumbnail with badge overlay -->
          <div class="project-thumbnail-wrapper">
            <img src="<?= asset($proj['thumbnail_url']) ?>" alt="<?= e($proj['title']) ?>" class="project-thumbnail" loading="lazy">
            <span class="project-badge-overlay"><?= e($proj['badge_text']) ?></span>
          </div>

          <!-- Project Content -->
          <div class="project-content">
            <h3 class="project-title"><?= e($proj['title']) ?></h3>
            <p class="project-desc"><?= e($proj['short_desc']) ?></p>

            <!-- Tech Tags -->
            <div class="project-tags">
              <?php
                $tags = explode(',', $proj['tech_stack']);
                foreach (array_slice($tags, 0, 4) as $t):
              ?>
                <span class="tag-pill"><?= e(trim($t)) ?></span>
              <?php endforeach; ?>
            </div>

            <!-- Footer Domain + Details CTA -->
            <div class="project-footer">
              <span class="project-domain"><?= e($proj['domain_label']) ?></span>
              <button
                class="project-details-btn"
                data-title="<?= e($proj['title']) ?>"
                data-desc="<?= e($proj['full_desc']) ?>"
                data-img="<?= asset($proj['thumbnail_url']) ?>"
                data-badge="<?= e($proj['badge_text']) ?>"
                data-domain="<?= e($proj['domain_label']) ?>"
                data-tags="<?= e($proj['tech_stack']) ?>"
                data-demo="<?= e($proj['live_demo_url']) ?>"
                data-github="<?= e($proj['github_url']) ?>"
              >
                <span>Details</span>
                <span>&rarr;</span>
              </button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

