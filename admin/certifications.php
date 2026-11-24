<?php
/**
 * Certifications Management
 * Muhammad Salman - AI Engineer Portfolio
 */

define('SECURE_ACCESS', true);

$pageTitle = 'Certifications Management';
require_once __DIR__ . '/includes/admin_header.php';

$action = $_GET['action'] ?? 'list';
$editCert = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_or_die();
    $postAction = $_POST['post_action'] ?? '';

    if ($postAction === 'save_cert') {
        $certId = (int)($_POST['cert_id'] ?? 0);
        $title = clean_input($_POST['title'] ?? '');
        $issuer = clean_input($_POST['issuer'] ?? '');
        $year = clean_input($_POST['issue_year'] ?? '');
        $credId = clean_input($_POST['credential_id'] ?? '');
        $url = clean_input($_POST['credential_url'] ?? '');
        $sort = (int)($_POST['sort_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if (empty($title) || empty($issuer)) {
            set_flash('danger', 'Certification title and issuer are required.');
        } else {
            if ($certId > 0) {
                DB::execute(
                    "UPDATE certifications SET title = :t, issuer = :i, issue_year = :y, credential_id = :cid, credential_url = :u, sort_order = :s, is_active = :a WHERE id = :id",
                    ['t' => $title, 'i' => $issuer, 'y' => $year, 'cid' => $credId, 'u' => $url, 's' => $sort, 'a' => $isActive, 'id' => $certId]
                );
                set_flash('success', 'Certification updated.');
            } else {
                DB::execute(
                    "INSERT INTO certifications (title, issuer, issue_year, credential_id, credential_url, sort_order, is_active) VALUES (:t, :i, :y, :cid, :u, :s, :a)",
                    ['t' => $title, 'i' => $issuer, 'y' => $year, 'cid' => $credId, 'u' => $url, 's' => $sort, 'a' => $isActive]
                );
                set_flash('success', 'New certification added.');
            }
            header('Location: ' . BASE_URL . '/admin/certifications.php');
            exit;
        }
    }

    if ($postAction === 'delete_cert') {
        $certId = (int)($_POST['cert_id'] ?? 0);
        DB::execute("DELETE FROM certifications WHERE id = :id", ['id' => $certId]);
        set_flash('success', 'Certification deleted.');
        header('Location: ' . BASE_URL . '/admin/certifications.php');
        exit;
    }
}

if ($action === 'edit' && !empty($_GET['id'])) {
    $editCert = DB::fetchOne("SELECT * FROM certifications WHERE id = :id", ['id' => (int)$_GET['id']]);
}

$certifications = DB::fetchAll("SELECT * FROM certifications ORDER BY sort_order ASC, issue_year DESC");
?>

<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><?= $editCert ? 'Edit Certification' : 'Add New Certification' ?></h3>
    <?php if ($editCert): ?>
      <a href="<?= BASE_URL ?>/admin/certifications.php" class="btn-admin btn-admin-secondary" style="font-size: 0.8rem;">Cancel</a>
    <?php endif; ?>
  </div>

  <form action="<?= BASE_URL ?>/admin/certifications.php" method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="post_action" value="save_cert">
    <input type="hidden" name="cert_id" value="<?= $editCert['id'] ?? 0 ?>">

    <div class="admin-form-grid">
      <div class="admin-form-group">
        <label for="title" class="admin-label">Certification Title *</label>
        <input type="text" id="title" name="title" class="admin-input" placeholder="e.g. Huawei Certified ICT Associate - AI" value="<?= e($editCert['title'] ?? '') ?>" required>
      </div>

      <div class="admin-form-group">
        <label for="issuer" class="admin-label">Issuing Organization *</label>
        <input type="text" id="issuer" name="issuer" class="admin-input" placeholder="e.g. Huawei / DeepLearning.AI" value="<?= e($editCert['issuer'] ?? '') ?>" required>
      </div>

      <div class="admin-form-group">
        <label for="issue_year" class="admin-label">Year of Issue</label>
        <input type="text" id="issue_year" name="issue_year" class="admin-input" placeholder="e.g. 2024" value="<?= e($editCert['issue_year'] ?? '') ?>">
      </div>

      <div class="admin-form-group">
        <label for="credential_id" class="admin-label">Credential ID</label>
        <input type="text" id="credential_id" name="credential_id" class="admin-input" placeholder="e.g. HCIA-AI-2024" value="<?= e($editCert['credential_id'] ?? '') ?>">
      </div>

      <div class="admin-form-group full-width">
        <label for="credential_url" class="admin-label">Verification Link / URL</label>
        <input type="text" id="credential_url" name="credential_url" class="admin-input" placeholder="https://..." value="<?= e($editCert['credential_url'] ?? '') ?>">
      </div>

      <div class="admin-form-group">
        <label for="sort_order" class="admin-label">Sort Order</label>
        <input type="number" id="sort_order" name="sort_order" class="admin-input" value="<?= $editCert['sort_order'] ?? 0 ?>">
      </div>

      <div class="admin-form-group" style="justify-content: center;">
        <label class="admin-label" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; margin-top: 1.5rem;">
          <input type="checkbox" name="is_active" value="1" <?= (!isset($editCert) || ($editCert['is_active'] ?? 1) == 1) ? 'checked' : '' ?>>
          <span>Active (Visible on portfolio)</span>
        </label>
      </div>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-top: 1rem;">
      <button type="submit" class="btn-admin btn-admin-primary">
        <?= render_icon('award', 'w-4 h-4') ?>
        <span><?= $editCert ? 'Update Credential' : 'Add Credential' ?></span>
      </button>
    </div>
  </form>
</div>

<!-- Certifications Table -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">Accredited Certifications (<?= count($certifications) ?>)</h3>
  </div>

  <div class="admin-table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Credential Title</th>
          <th>Issuer</th>
          <th>Year</th>
          <th>Credential ID</th>
          <th>Visibility</th>
          <th style="text-align: right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($certifications as $c): ?>
          <tr>
            <td style="font-weight: 700; color: #ffffff;"><?= e($c['title']) ?></td>
            <td style="color: #38bdf8;"><?= e($c['issuer']) ?></td>
            <td><?= e($c['issue_year']) ?></td>
            <td style="font-family: monospace; font-size: 0.8rem;"><?= e($c['credential_id']) ?></td>
            <td>
              <span class="badge-status <?= $c['is_active'] ? 'badge-published' : 'badge-draft' ?>">
                <?= $c['is_active'] ? 'Active' : 'Hidden' ?>
              </span>
            </td>
            <td style="text-align: right;">
              <a href="<?= BASE_URL ?>/admin/certifications.php?action=edit&id=<?= $c['id'] ?>" class="btn-admin btn-admin-secondary" style="font-size: 0.75rem; padding: 0.25rem 0.65rem;">
                Edit
              </a>
              <form action="<?= BASE_URL ?>/admin/certifications.php" method="POST" style="display: inline-block;">
                <?= csrf_field() ?>
                <input type="hidden" name="post_action" value="delete_cert">
                <input type="hidden" name="cert_id" value="<?= $c['id'] ?>">
                <button type="submit" class="btn-admin btn-admin-danger" style="font-size: 0.75rem; padding: 0.25rem 0.65rem;" onclick="return confirm('Delete credential <?= e($c['title']) ?>?');">
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

