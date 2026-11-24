<?php
/**
 * Skills & Categories Management
 * Muhammad Salman - AI Engineer Portfolio
 */

define('SECURE_ACCESS', true);

$pageTitle = 'Skills Dashboard Management';
require_once __DIR__ . '/includes/admin_header.php';

$action = $_GET['action'] ?? 'list';
$editSkill = null;

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_or_die();
    $postAction = $_POST['post_action'] ?? '';

    // 1. Add / Edit Skill
    if ($postAction === 'save_skill') {
        $skillId = (int)($_POST['skill_id'] ?? 0);
        $catId = (int)($_POST['category_id'] ?? 0);
        $name = clean_input($_POST['name'] ?? '');
        $desc = clean_input($_POST['description'] ?? '');
        $profLabel = clean_input($_POST['proficiency_label'] ?? 'Expert');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if (empty($name) || $catId <= 0) {
            set_flash('danger', 'Skill name and Category are required.');
        } else {
            if ($skillId > 0) {
                DB::execute(
                    "UPDATE skills SET category_id = :cat, name = :name, description = :desc, proficiency_label = :prof, sort_order = :sort, is_active = :active WHERE id = :id",
                    ['cat' => $catId, 'name' => $name, 'desc' => $desc, 'prof' => $profLabel, 'sort' => $sortOrder, 'active' => $isActive, 'id' => $skillId]
                );
                set_flash('success', 'Skill updated successfully.');
            } else {
                DB::execute(
                    "INSERT INTO skills (category_id, name, description, proficiency_label, sort_order, is_active) VALUES (:cat, :name, :desc, :prof, :sort, :active)",
                    ['cat' => $catId, 'name' => $name, 'desc' => $desc, 'prof' => $profLabel, 'sort' => $sortOrder, 'active' => $isActive]
                );
                set_flash('success', 'New skill added successfully.');
            }
            header('Location: ' . BASE_URL . '/admin/skills.php');
            exit;
        }
    }

    // 2. Delete Skill
    if ($postAction === 'delete_skill') {
        $skillId = (int)($_POST['skill_id'] ?? 0);
        DB::execute("DELETE FROM skills WHERE id = :id", ['id' => $skillId]);
        set_flash('success', 'Skill deleted successfully.');
        header('Location: ' . BASE_URL . '/admin/skills.php');
        exit;
    }

    // 3. Update Category Badges
    if ($postAction === 'save_category') {
        $catId = (int)($_POST['category_id'] ?? 0);
        $badgeText = clean_input($_POST['badge_text'] ?? '');
        $statusText = clean_input($_POST['status_text'] ?? '');

        if ($catId > 0) {
            DB::execute(
                "UPDATE skill_categories SET badge_text = :badge, status_text = :status WHERE id = :id",
                ['badge' => $badgeText, 'status' => $statusText, 'id' => $catId]
            );
            set_flash('success', 'Category badges updated.');
        }
        header('Location: ' . BASE_URL . '/admin/skills.php');
        exit;
    }
}

// Fetch edit target if requested
if ($action === 'edit' && !empty($_GET['id'])) {
    $editSkill = DB::fetchOne("SELECT * FROM skills WHERE id = :id", ['id' => (int)$_GET['id']]);
}

$categories = DB::fetchAll("SELECT * FROM skill_categories ORDER BY sort_order ASC");
$allSkillsGrouped = get_all_skills_grouped(false); // get all including inactive
?>

<!-- Skill Add / Edit Form Card -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><?= $editSkill ? 'Edit Technical Skill' : 'Add New Technical Skill' ?></h3>
    <?php if ($editSkill): ?>
      <a href="<?= BASE_URL ?>/admin/skills.php" class="btn-admin btn-admin-secondary" style="font-size: 0.8rem;">Cancel Edit</a>
    <?php endif; ?>
  </div>

  <form action="<?= BASE_URL ?>/admin/skills.php" method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="post_action" value="save_skill">
    <input type="hidden" name="skill_id" value="<?= $editSkill['id'] ?? 0 ?>">

    <div class="admin-form-grid">
      <div class="admin-form-group">
        <label for="category_id" class="admin-label">Category *</label>
        <select id="category_id" name="category_id" class="admin-select" required>
          <option value="">Select Category</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= ($editSkill['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
              <?= e($cat['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="admin-form-group">
        <label for="name" class="admin-label">Skill Name *</label>
        <input type="text" id="name" name="name" class="admin-input" placeholder="e.g. PyTorch & Deep Neural Networks" value="<?= e($editSkill['name'] ?? '') ?>" required>
      </div>

      <div class="admin-form-group">
        <label for="description" class="admin-label">Tech Subtitle / Stack Description</label>
        <input type="text" id="description" name="description" class="admin-input" placeholder="e.g. CNNs, Transformers & Custom Layers" value="<?= e($editSkill['description'] ?? '') ?>">
      </div>

      <div class="admin-form-group">
        <label for="proficiency_label" class="admin-label">Proficiency Badge Label</label>
        <select id="proficiency_label" name="proficiency_label" class="admin-select">
          <?php
            $profOptions = ['Mastery', 'Expert', 'Production', 'Advanced', 'Firmware Pro', 'Core Expert', 'Backend Pro', 'Cloud Ready'];
            $currentProf = $editSkill['proficiency_label'] ?? 'Expert';
            foreach ($profOptions as $opt):
          ?>
            <option value="<?= $opt ?>" <?= $currentProf === $opt ? 'selected' : '' ?>><?= $opt ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="admin-form-group">
        <label for="sort_order" class="admin-label">Sort Order</label>
        <input type="number" id="sort_order" name="sort_order" class="admin-input" value="<?= $editSkill['sort_order'] ?? 0 ?>">
      </div>

      <div class="admin-form-group" style="justify-content: center;">
        <label class="admin-label" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; margin-top: 1.5rem;">
          <input type="checkbox" name="is_active" value="1" <?= (!isset($editSkill) || ($editSkill['is_active'] ?? 1) == 1) ? 'checked' : '' ?>>
          <span>Active (Visible on public portfolio)</span>
        </label>
      </div>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-top: 1rem;">
      <button type="submit" class="btn-admin btn-admin-primary">
        <?= render_icon('code', 'w-4 h-4') ?>
        <span><?= $editSkill ? 'Update Skill' : 'Add Skill' ?></span>
      </button>
    </div>
  </form>
</div>

<!-- Skills Listed by Category -->
<?php foreach ($allSkillsGrouped as $cat): ?>
  <div class="admin-card">
    <div class="admin-card-header">
      <div>
        <h3 class="admin-card-title"><?= e($cat['name']) ?></h3>
        <span style="font-size: 0.8rem; color: #38bdf8;"><?= e($cat['status_text']) ?> • <?= e($cat['badge_text']) ?></span>
      </div>

      <!-- Quick update category badges -->
      <form action="<?= BASE_URL ?>/admin/skills.php" method="POST" style="display: flex; align-items: center; gap: 0.5rem;">
        <?= csrf_field() ?>
        <input type="hidden" name="post_action" value="save_category">
        <input type="hidden" name="category_id" value="<?= $cat['id'] ?>">
        <input type="text" name="badge_text" class="admin-input" style="padding: 0.35rem 0.6rem; width: 100px; font-size: 0.75rem;" value="<?= e($cat['badge_text']) ?>" placeholder="Badge">
        <input type="text" name="status_text" class="admin-input" style="padding: 0.35rem 0.6rem; width: 160px; font-size: 0.75rem;" value="<?= e($cat['status_text']) ?>" placeholder="Status text">
        <button type="submit" class="btn-admin btn-admin-secondary" style="font-size: 0.75rem; padding: 0.35rem 0.65rem;">Save</button>
      </form>
    </div>

    <?php if (empty($cat['skills'])): ?>
      <p style="color: var(--admin-text-dim); font-size: 0.85rem;">No skills assigned to this category yet.</p>
    <?php else: ?>
      <div class="admin-table-responsive">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Skill Name</th>
              <th>Subtitle Description</th>
              <th>Proficiency</th>
              <th>Visibility</th>
              <th style="text-align: right;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($cat['skills'] as $s): ?>
              <tr>
                <td style="font-weight: 600; color: #ffffff;"><?= e($s['name']) ?></td>
                <td style="color: var(--admin-text-muted); font-size: 0.85rem;"><?= e($s['description']) ?></td>
                <td>
                  <span class="badge-status badge-published" style="background: rgba(139,92,246,0.15); color: #c084fc;">
                    <?= e($s['proficiency_label']) ?>
                  </span>
                </td>
                <td>
                  <span class="badge-status <?= $s['is_active'] ? 'badge-published' : 'badge-draft' ?>">
                    <?= $s['is_active'] ? 'Active' : 'Hidden' ?>
                  </span>
                </td>
                <td style="text-align: right;">
                  <a href="<?= BASE_URL ?>/admin/skills.php?action=edit&id=<?= $s['id'] ?>" class="btn-admin btn-admin-secondary" style="font-size: 0.75rem; padding: 0.25rem 0.65rem;">
                    Edit
                  </a>
                  <form action="<?= BASE_URL ?>/admin/skills.php" method="POST" style="display: inline-block;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="post_action" value="delete_skill">
                    <input type="hidden" name="skill_id" value="<?= $s['id'] ?>">
                    <button type="submit" class="btn-admin btn-admin-danger" style="font-size: 0.75rem; padding: 0.25rem 0.65rem;" onclick="return confirm('Delete skill <?= e($s['name']) ?>?');">
                      Delete
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
<?php endforeach; ?>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

