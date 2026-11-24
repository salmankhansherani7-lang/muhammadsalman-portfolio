<?php
/**
 * Services Management
 * Muhammad Salman - AI Engineer Portfolio
 */

define('SECURE_ACCESS', true);

$pageTitle = 'Services Management';
require_once __DIR__ . '/includes/admin_header.php';

$action = $_GET['action'] ?? 'list';
$editService = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_or_die();
    $postAction = $_POST['post_action'] ?? '';

    if ($postAction === 'save_service') {
        $srvId = (int)($_POST['service_id'] ?? 0);
        $title = clean_input($_POST['title'] ?? '');
        $shortDesc = clean_input($_POST['short_desc'] ?? '');
        $detailedDesc = clean_input($_POST['detailed_desc'] ?? '');
        $iconName = clean_input($_POST['icon_name'] ?? 'cpu');
        $deliverables = clean_input($_POST['deliverables'] ?? '');
        $sort = (int)($_POST['sort_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if (empty($title) || empty($shortDesc)) {
            set_flash('danger', 'Service title and short description are required.');
        } else {
            if ($srvId > 0) {
                DB::execute(
                    "UPDATE services SET title = :t, short_desc = :s, detailed_desc = :d, icon_name = :i, deliverables = :del, sort_order = :sort, is_active = :a WHERE id = :id",
                    ['t' => $title, 's' => $shortDesc, 'd' => $detailedDesc, 'i' => $iconName, 'del' => $deliverables, 'sort' => $sort, 'a' => $isActive, 'id' => $srvId]
                );
                set_flash('success', 'Service updated successfully.');
            } else {
                DB::execute(
                    "INSERT INTO services (title, short_desc, detailed_desc, icon_name, deliverables, sort_order, is_active) VALUES (:t, :s, :d, :i, :del, :sort, :a)",
                    ['t' => $title, 's' => $shortDesc, 'd' => $detailedDesc, 'i' => $iconName, 'del' => $deliverables, 'sort' => $sort, 'a' => $isActive]
                );
                set_flash('success', 'New service added.');
            }
            header('Location: ' . BASE_URL . '/admin/services.php');
            exit;
        }
    }

    if ($postAction === 'delete_service') {
        $srvId = (int)($_POST['service_id'] ?? 0);
        DB::execute("DELETE FROM services WHERE id = :id", ['id' => $srvId]);
        set_flash('success', 'Service deleted.');
        header('Location: ' . BASE_URL . '/admin/services.php');
        exit;
    }
}

if ($action === 'edit' && !empty($_GET['id'])) {
    $editService = DB::fetchOne("SELECT * FROM services WHERE id = :id", ['id' => (int)$_GET['id']]);
}

$services = DB::fetchAll("SELECT * FROM services ORDER BY sort_order ASC");
?>

<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><?= $editService ? 'Edit Engineering Service' : 'Add New Service' ?></h3>
    <?php if ($editService): ?>
      <a href="<?= BASE_URL ?>/admin/services.php" class="btn-admin btn-admin-secondary" style="font-size: 0.8rem;">Cancel</a>
    <?php endif; ?>
  </div>

  <form action="<?= BASE_URL ?>/admin/services.php" method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="post_action" value="save_service">
    <input type="hidden" name="service_id" value="<?= $editService['id'] ?? 0 ?>">

    <div class="admin-form-grid">
      <div class="admin-form-group">
        <label for="title" class="admin-label">Service Title *</label>
        <input type="text" id="title" name="title" class="admin-input" placeholder="e.g. Generative AI & Autonomous Agents" value="<?= e($editService['title'] ?? '') ?>" required>
      </div>

      <div class="admin-form-group">
        <label for="icon_name" class="admin-label">Service Icon</label>
        <select id="icon_name" name="icon_name" class="admin-select">
          <?php
            $icons = ['brain' => 'Brain / Neural', 'sparkles' => 'Sparkles / GenAI', 'cpu' => 'CPU / Hardware', 'camera' => 'Camera / Vision', 'layout' => 'Layout / Web', 'graduation-cap' => 'Graduation / Training'];
            $curIcon = $editService['icon_name'] ?? 'cpu';
            foreach ($icons as $k => $v):
          ?>
            <option value="<?= $k ?>" <?= $curIcon === $k ? 'selected' : '' ?>><?= $v ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="admin-form-group full-width">
        <label for="short_desc" class="admin-label">Short Summary Description *</label>
        <textarea id="short_desc" name="short_desc" class="admin-textarea" style="min-height: 70px;" required><?= e($editService['short_desc'] ?? '') ?></textarea>
      </div>

      <div class="admin-form-group full-width">
        <label for="detailed_desc" class="admin-label">Detailed Description</label>
        <textarea id="detailed_desc" name="detailed_desc" class="admin-textarea" style="min-height: 90px;"><?= e($editService['detailed_desc'] ?? '') ?></textarea>
      </div>

      <div class="admin-form-group full-width">
        <label for="deliverables" class="admin-label">Key Deliverables (Comma-separated)</label>
        <input type="text" id="deliverables" name="deliverables" class="admin-input" placeholder="e.g. RAG pipeline, Agent orchestration, Vector store integration" value="<?= e($editService['deliverables'] ?? '') ?>">
      </div>

      <div class="admin-form-group">
        <label for="sort_order" class="admin-label">Sort Order</label>
        <input type="number" id="sort_order" name="sort_order" class="admin-input" value="<?= $editService['sort_order'] ?? 0 ?>">
      </div>

      <div class="admin-form-group" style="justify-content: center;">
        <label class="admin-label" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; margin-top: 1.5rem;">
          <input type="checkbox" name="is_active" value="1" <?= (!isset($editService) || ($editService['is_active'] ?? 1) == 1) ? 'checked' : '' ?>>
          <span>Active (Visible on portfolio)</span>
        </label>
      </div>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-top: 1rem;">
      <button type="submit" class="btn-admin btn-admin-primary">
        <?= render_icon('cpu', 'w-4 h-4') ?>
        <span><?= $editService ? 'Update Service' : 'Add Service' ?></span>
      </button>
    </div>
  </form>
</div>

<!-- Services Table -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">Services Offered (<?= count($services) ?>)</h3>
  </div>

  <div class="admin-table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Icon</th>
          <th>Service Title</th>
          <th>Short Description</th>
          <th>Visibility</th>
          <th style="text-align: right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($services as $srv): ?>
          <tr>
            <td style="color: #c084fc;">
              <?= render_icon($srv['icon_name'] ?? 'cpu', 'w-5 h-5') ?>
            </td>
            <td style="font-weight: 700; color: #ffffff;"><?= e($srv['title']) ?></td>
            <td style="font-size: 0.85rem; color: var(--admin-text-muted); max-width: 380px;"><?= e($srv['short_desc']) ?></td>
            <td>
              <span class="badge-status <?= $srv['is_active'] ? 'badge-published' : 'badge-draft' ?>">
                <?= $srv['is_active'] ? 'Active' : 'Hidden' ?>
              </span>
            </td>
            <td style="text-align: right;">
              <a href="<?= BASE_URL ?>/admin/services.php?action=edit&id=<?= $srv['id'] ?>" class="btn-admin btn-admin-secondary" style="font-size: 0.75rem; padding: 0.25rem 0.65rem;">
                Edit
              </a>
              <form action="<?= BASE_URL ?>/admin/services.php" method="POST" style="display: inline-block;">
                <?= csrf_field() ?>
                <input type="hidden" name="post_action" value="delete_service">
                <input type="hidden" name="service_id" value="<?= $srv['id'] ?>">
                <button type="submit" class="btn-admin btn-admin-danger" style="font-size: 0.75rem; padding: 0.25rem 0.65rem;" onclick="return confirm('Delete service <?= e($srv['title']) ?>?');">
                  Delete
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

