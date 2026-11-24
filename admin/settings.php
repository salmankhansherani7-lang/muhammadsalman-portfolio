<?php
/**
 * Website Settings, Stats & Socials Management
 * Muhammad Salman - AI Engineer Portfolio
 */

define('SECURE_ACCESS', true);

$pageTitle = 'Settings & Configuration';
require_once __DIR__ . '/includes/admin_header.php';

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_or_die();
    $postAction = $_POST['post_action'] ?? '';

    // 1. General Site Settings
    if ($postAction === 'save_general_settings') {
        update_setting('site_name', clean_input($_POST['site_name'] ?? ''));
        update_setting('meta_description', clean_input($_POST['meta_description'] ?? ''));
        update_setting('footer_tagline', clean_input($_POST['footer_tagline'] ?? ''));
        update_setting('enable_particles', isset($_POST['enable_particles']) ? '1' : '0');

        set_flash('success', 'General website settings updated.');
        header('Location: ' . BASE_URL . '/admin/settings.php');
        exit;
    }

    // 2. Hero Statistics Cards
    if ($postAction === 'save_hero_stats') {
        $statsData = $_POST['stats'] ?? [];
        foreach ($statsData as $id => $data) {
            DB::execute(
                "UPDATE hero_stats SET stat_number = :num, stat_label = :lbl WHERE id = :id",
                [
                    'num' => clean_input($data['number'] ?? ''),
                    'lbl' => clean_input($data['label'] ?? ''),
                    'id' => (int)$id
                ]
            );
        }
        set_flash('success', 'Hero metric cards updated.');
        header('Location: ' . BASE_URL . '/admin/settings.php');
        exit;
    }

    // 3. Social Media Links
    if ($postAction === 'save_socials') {
        $socialsData = $_POST['socials'] ?? [];
        foreach ($socialsData as $id => $url) {
            DB::execute(
                "UPDATE social_links SET url = :url WHERE id = :id",
                ['url' => clean_input($url), 'id' => (int)$id]
            );
        }
        set_flash('success', 'Social media URLs updated.');
        header('Location: ' . BASE_URL . '/admin/settings.php');
        exit;
    }
}

$heroStats = get_hero_stats(false);
$socials = get_social_links(false);
?>

<!-- General & SEO Settings -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">General & Search Engine Settings</h3>
  </div>

  <form action="<?= BASE_URL ?>/admin/settings.php" method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="post_action" value="save_general_settings">

    <div class="admin-form-grid">
      <div class="admin-form-group">
        <label for="site_name" class="admin-label">Website Title Tag *</label>
        <input type="text" id="site_name" name="site_name" class="admin-input" value="<?= e(get_setting('site_name', 'Muhammad Salman | AI Engineer')) ?>" required>
      </div>

      <div class="admin-form-group">
        <label for="footer_tagline" class="admin-label">Footer Tagline Quote</label>
        <input type="text" id="footer_tagline" name="footer_tagline" class="admin-input" value="<?= e(get_setting('footer_tagline')) ?>">
      </div>

      <div class="admin-form-group full-width">
        <label for="meta_description" class="admin-label">SEO Meta Description *</label>
        <textarea id="meta_description" name="meta_description" class="admin-textarea" style="min-height: 80px;" required><?= e(get_setting('meta_description')) ?></textarea>
      </div>

      <div class="admin-form-group full-width">
        <label class="admin-label" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
          <input type="checkbox" name="enable_particles" value="1" <?= get_setting('enable_particles', '1') === '1' ? 'checked' : '' ?>>
          <span>Enable Interactive Neural Network Canvas Particles</span>
        </label>
      </div>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-top: 1rem;">
      <button type="submit" class="btn-admin btn-admin-primary">Save Settings</button>
    </div>
  </form>
</div>

<!-- Hero Metric Statistics Cards -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">Hero Section Metric / Achievement Cards</h3>
  </div>

  <form action="<?= BASE_URL ?>/admin/settings.php" method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="post_action" value="save_hero_stats">

    <div class="admin-form-grid">
      <?php foreach ($heroStats as $st): ?>
        <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--admin-border); border-radius: 8px; padding: 1rem;">
          <div class="admin-form-group">
            <label class="admin-label">Metric Value (e.g. 15+ / 500+)</label>
            <input type="text" name="stats[<?= $st['id'] ?>][number]" class="admin-input" value="<?= e($st['stat_number']) ?>" required>
          </div>
          <div class="admin-form-group" style="margin-bottom: 0;">
            <label class="admin-label">Metric Label</label>
            <input type="text" name="stats[<?= $st['id'] ?>][label]" class="admin-input" value="<?= e($st['stat_label']) ?>" required>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem;">
      <button type="submit" class="btn-admin btn-admin-primary">Update Metric Cards</button>
    </div>
  </form>
</div>

<!-- Social Media Profiles -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">Social Media & Contact Links</h3>
  </div>

  <form action="<?= BASE_URL ?>/admin/settings.php" method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="post_action" value="save_socials">

    <div class="admin-form-grid">
      <?php foreach ($socials as $s): ?>
        <div class="admin-form-group">
          <label class="admin-label" style="display: flex; align-items: center; gap: 0.5rem;">
            <?= render_icon($s['platform_icon'], 'w-4 h-4') ?>
            <span><?= e($s['platform_name']) ?> URL</span>
          </label>
          <input type="text" name="socials[<?= $s['id'] ?>]" class="admin-input" value="<?= e($s['url']) ?>" required>
        </div>
      <?php endforeach; ?>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem;">
      <button type="submit" class="btn-admin btn-admin-primary">Update Social Links</button>
    </div>
  </form>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

