<?php
/**
 * Experience & Education Management
 * Muhammad Salman - AI Engineer Portfolio
 */

define('SECURE_ACCESS', true);

$pageTitle = 'Career Experience & Education';
require_once __DIR__ . '/includes/admin_header.php';

$action = $_GET['action'] ?? 'list';
$editExp = null;
$editEdu = null;

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_or_die();
    $postAction = $_POST['post_action'] ?? '';

    // 1. Save Work Experience
    if ($postAction === 'save_experience') {
        $expId = (int)($_POST['exp_id'] ?? 0);
        $role = clean_input($_POST['role_title'] ?? '');
        $company = clean_input($_POST['company_name'] ?? '');
        $loc = clean_input($_POST['location'] ?? 'Pakistan');
        $start = clean_input($_POST['start_date'] ?? '');
        $end = clean_input($_POST['end_date'] ?? 'Present');
        $desc = clean_input($_POST['description'] ?? '');
        $stack = clean_input($_POST['tech_stack'] ?? '');
        $sort = (int)($_POST['sort_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if (empty($role) || empty($company)) {
            set_flash('danger', 'Role title and company name are required.');
        } else {
            if ($expId > 0) {
                DB::execute(
                    "UPDATE experience SET role_title = :r, company_name = :c, location = :l, start_date = :s, end_date = :e, description = :d, tech_stack = :t, sort_order = :sort, is_active = :act WHERE id = :id",
                    ['r' => $role, 'c' => $company, 'l' => $loc, 's' => $start, 'e' => $end, 'd' => $desc, 't' => $stack, 'sort' => $sort, 'act' => $isActive, 'id' => $expId]
                );
                set_flash('success', 'Experience record updated.');
            } else {
                DB::execute(
                    "INSERT INTO experience (role_title, company_name, location, start_date, end_date, description, tech_stack, sort_order, is_active) VALUES (:r, :c, :l, :s, :e, :d, :t, :sort, :act)",
                    ['r' => $role, 'c' => $company, 'l' => $loc, 's' => $start, 'e' => $end, 'd' => $desc, 't' => $stack, 'sort' => $sort, 'act' => $isActive]
                );
                set_flash('success', 'New experience record added.');
            }
            header('Location: ' . BASE_URL . '/admin/experience.php');
            exit;
        }
    }

    // 2. Delete Work Experience
    if ($postAction === 'delete_experience') {
        $expId = (int)($_POST['exp_id'] ?? 0);
        DB::execute("DELETE FROM experience WHERE id = :id", ['id' => $expId]);
        set_flash('success', 'Experience record deleted.');
        header('Location: ' . BASE_URL . '/admin/experience.php');
        exit;
    }

    // 3. Save Education
    if ($postAction === 'save_education') {
        $eduId = (int)($_POST['edu_id'] ?? 0);
        $degree = clean_input($_POST['degree_title'] ?? '');
        $inst = clean_input($_POST['institution'] ?? '');
        $loc = clean_input($_POST['location'] ?? 'Pakistan');
        $start = clean_input($_POST['start_year'] ?? '');
        $end = clean_input($_POST['end_year'] ?? '');
        $honors = clean_input($_POST['grade_or_honors'] ?? '');
        $desc = clean_input($_POST['description'] ?? '');
        $sort = (int)($_POST['sort_order'] ?? 0);

        if (empty($degree) || empty($inst)) {
            set_flash('danger', 'Degree title and institution are required.');
        } else {
            if ($eduId > 0) {
                DB::execute(
                    "UPDATE education SET degree_title = :d, institution = :i, location = :l, start_year = :s, end_year = :e, grade_or_honors = :h, description = :desc, sort_order = :sort WHERE id = :id",
                    ['d' => $degree, 'i' => $inst, 'l' => $loc, 's' => $start, 'e' => $end, 'h' => $honors, 'desc' => $desc, 'sort' => $sort, 'id' => $eduId]
                );
                set_flash('success', 'Education record updated.');
            } else {
                DB::execute(
                    "INSERT INTO education (degree_title, institution, location, start_year, end_year, grade_or_honors, description, sort_order) VALUES (:d, :i, :l, :s, :e, :h, :desc, :sort)",
                    ['d' => $degree, 'i' => $inst, 'l' => $loc, 's' => $start, 'e' => $end, 'h' => $honors, 'desc' => $desc, 'sort' => $sort]
                );
                set_flash('success', 'New education record added.');
            }
            header('Location: ' . BASE_URL . '/admin/experience.php');
            exit;
        }
    }

    // 4. Delete Education
    if ($postAction === 'delete_education') {
        $eduId = (int)($_POST['edu_id'] ?? 0);
        DB::execute("DELETE FROM education WHERE id = :id", ['id' => $eduId]);
        set_flash('success', 'Education record deleted.');
        header('Location: ' . BASE_URL . '/admin/experience.php');
        exit;
    }
}

if ($action === 'edit_exp' && !empty($_GET['id'])) {
    $editExp = DB::fetchOne("SELECT * FROM experience WHERE id = :id", ['id' => (int)$_GET['id']]);
}
if ($action === 'edit_edu' && !empty($_GET['id'])) {
    $editEdu = DB::fetchOne("SELECT * FROM education WHERE id = :id", ['id' => (int)$_GET['id']]);
}

$experiences = DB::fetchAll("SELECT * FROM experience ORDER BY sort_order ASC");
$educations = DB::fetchAll("SELECT * FROM education ORDER BY sort_order ASC");
?>

<!-- Work Experience Section -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><?= $editExp ? 'Edit Applied Experience' : 'Add Applied Experience' ?></h3>
    <?php if ($editExp): ?>
      <a href="<?= BASE_URL ?>/admin/experience.php" class="btn-admin btn-admin-secondary" style="font-size: 0.8rem;">Cancel Edit</a>
    <?php endif; ?>
  </div>

  <form action="<?= BASE_URL ?>/admin/experience.php" method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="post_action" value="save_experience">
    <input type="hidden" name="exp_id" value="<?= $editExp['id'] ?? 0 ?>">

    <div class="admin-form-grid">
      <div class="admin-form-group">
        <label for="role_title" class="admin-label">Role Title *</label>
        <input type="text" id="role_title" name="role_title" class="admin-input" placeholder="e.g. AI Engineer & Solutions Architect" value="<?= e($editExp['role_title'] ?? '') ?>" required>
      </div>

      <div class="admin-form-group">
        <label for="company_name" class="admin-label">Company / Organization *</label>
        <input type="text" id="company_name" name="company_name" class="admin-input" placeholder="e.g. Tech Innovation Lab" value="<?= e($editExp['company_name'] ?? '') ?>" required>
      </div>

      <div class="admin-form-group">
        <label for="exp_location" class="admin-label">Location</label>
        <input type="text" id="exp_location" name="location" class="admin-input" placeholder="e.g. Islamabad, Pakistan" value="<?= e($editExp['location'] ?? 'Pakistan') ?>">
      </div>

      <div class="admin-form-group">
        <label for="start_date" class="admin-label">Start Period *</label>
        <input type="text" id="start_date" name="start_date" class="admin-input" placeholder="e.g. 2024 or Jan 2023" value="<?= e($editExp['start_date'] ?? '') ?>" required>
      </div>

      <div class="admin-form-group">
        <label for="end_date" class="admin-label">End Period</label>
        <input type="text" id="end_date" name="end_date" class="admin-input" placeholder="e.g. Present or Dec 2024" value="<?= e($editExp['end_date'] ?? 'Present') ?>">
      </div>

      <div class="admin-form-group">
        <label for="tech_stack" class="admin-label">Tech Stack (Comma-separated)</label>
        <input type="text" id="tech_stack" name="tech_stack" class="admin-input" placeholder="e.g. Python, PyTorch, YOLOv8, FastAPI" value="<?= e($editExp['tech_stack'] ?? '') ?>">
      </div>

      <div class="admin-form-group full-width">
        <label for="exp_desc" class="admin-label">Responsibilities & Achievements</label>
        <textarea id="exp_desc" name="description" class="admin-textarea" style="min-height: 90px;"><?= e($editExp['description'] ?? '') ?></textarea>
      </div>

      <div class="admin-form-group">
        <label for="exp_sort" class="admin-label">Sort Order</label>
        <input type="number" id="exp_sort" name="sort_order" class="admin-input" value="<?= $editExp['sort_order'] ?? 0 ?>">
      </div>

      <div class="admin-form-group" style="justify-content: center;">
        <label class="admin-label" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; margin-top: 1.5rem;">
          <input type="checkbox" name="is_active" value="1" <?= (!isset($editExp) || ($editExp['is_active'] ?? 1) == 1) ? 'checked' : '' ?>>
          <span>Active (Visible on public timeline)</span>
        </label>
      </div>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-top: 1rem;">
      <button type="submit" class="btn-admin btn-admin-primary">
        <?= render_icon('briefcase', 'w-4 h-4') ?>
        <span><?= $editExp ? 'Update Experience' : 'Save Experience' ?></span>
      </button>
    </div>
  </form>
</div>

<!-- Experience Records Table -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">Existing Work Experience Records</h3>
  </div>

  <div class="admin-table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Role Title</th>
          <th>Company</th>
          <th>Period</th>
          <th>Visibility</th>
          <th style="text-align: right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($experiences as $ex): ?>
          <tr>
            <td style="font-weight: 700; color: #ffffff;"><?= e($ex['role_title']) ?></td>
            <td style="color: #38bdf8;"><?= e($ex['company_name']) ?></td>
            <td style="font-size: 0.85rem; color: var(--admin-text-muted);"><?= e($ex['start_date']) ?> &ndash; <?= e($ex['end_date']) ?></td>
            <td>
              <span class="badge-status <?= $ex['is_active'] ? 'badge-published' : 'badge-draft' ?>">
                <?= $ex['is_active'] ? 'Active' : 'Hidden' ?>
              </span>
            </td>
            <td style="text-align: right;">
              <a href="<?= BASE_URL ?>/admin/experience.php?action=edit_exp&id=<?= $ex['id'] ?>" class="btn-admin btn-admin-secondary" style="font-size: 0.75rem; padding: 0.25rem 0.65rem;">
                Edit
              </a>
              <form action="<?= BASE_URL ?>/admin/experience.php" method="POST" style="display: inline-block;">
                <?= csrf_field() ?>
                <input type="hidden" name="post_action" value="delete_experience">
                <input type="hidden" name="exp_id" value="<?= $ex['id'] ?>">
                <button type="submit" class="btn-admin btn-admin-danger" style="font-size: 0.75rem; padding: 0.25rem 0.65rem;" onclick="return confirm('Delete this experience entry?');">
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

<!-- Education Form & Table -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><?= $editEdu ? 'Edit Academic Education' : 'Add Academic Education' ?></h3>
    <?php if ($editEdu): ?>
      <a href="<?= BASE_URL ?>/admin/experience.php" class="btn-admin btn-admin-secondary" style="font-size: 0.8rem;">Cancel Edit</a>
    <?php endif; ?>
  </div>

  <form action="<?= BASE_URL ?>/admin/experience.php" method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="post_action" value="save_education">
    <input type="hidden" name="edu_id" value="<?= $editEdu['id'] ?? 0 ?>">

    <div class="admin-form-grid">
      <div class="admin-form-group">
        <label for="degree_title" class="admin-label">Degree Title *</label>
        <input type="text" id="degree_title" name="degree_title" class="admin-input" placeholder="e.g. Bachelor of Science in Artificial Intelligence" value="<?= e($editEdu['degree_title'] ?? '') ?>" required>
      </div>

      <div class="admin-form-group">
        <label for="institution" class="admin-label">Institution *</label>
        <input type="text" id="institution" name="institution" class="admin-input" placeholder="e.g. University Name" value="<?= e($editEdu['institution'] ?? '') ?>" required>
      </div>

      <div class="admin-form-group">
        <label for="edu_start" class="admin-label">Start Year</label>
        <input type="text" id="edu_start" name="start_year" class="admin-input" placeholder="e.g. 2019" value="<?= e($editEdu['start_year'] ?? '') ?>">
      </div>

      <div class="admin-form-group">
        <label for="edu_end" class="admin-label">Graduation Year</label>
        <input type="text" id="edu_end" name="end_year" class="admin-input" placeholder="e.g. 2023" value="<?= e($editEdu['end_year'] ?? '') ?>">
      </div>

      <div class="admin-form-group">
        <label for="grade_or_honors" class="admin-label">Honors / Distinction</label>
        <input type="text" id="grade_or_honors" name="grade_or_honors" class="admin-input" placeholder="e.g. First Class Honours" value="<?= e($editEdu['grade_or_honors'] ?? '') ?>">
      </div>

      <div class="admin-form-group">
        <label for="edu_sort" class="admin-label">Sort Order</label>
        <input type="number" id="edu_sort" name="sort_order" class="admin-input" value="<?= $editEdu['sort_order'] ?? 0 ?>">
      </div>

      <div class="admin-form-group full-width">
        <label for="edu_desc" class="admin-label">Academic Focus Description</label>
        <textarea id="edu_desc" name="description" class="admin-textarea" style="min-height: 80px;"><?= e($editEdu['description'] ?? '') ?></textarea>
      </div>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-top: 1rem;">
      <button type="submit" class="btn-admin btn-admin-primary">
        <?= render_icon('award', 'w-4 h-4') ?>
        <span><?= $editEdu ? 'Update Education' : 'Save Education' ?></span>
      </button>
    </div>
  </form>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

