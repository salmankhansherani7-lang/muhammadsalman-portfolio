<?php
/**
 * Portfolio Projects Management
 * Muhammad Salman - AI Engineer Portfolio
 */

define('SECURE_ACCESS', true);

$pageTitle = 'Portfolio Projects Management';
require_once __DIR__ . '/includes/admin_header.php';

$action = $_GET['action'] ?? 'list';
$editProject = null;

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_or_die();
    $postAction = $_POST['post_action'] ?? '';

    // 1. Create or Update Project
    if ($postAction === 'save_project') {
        $projId = (int)($_POST['project_id'] ?? 0);
        $title = clean_input($_POST['title'] ?? '');
        $slug = clean_input($_POST['slug'] ?? '');
        if (empty($slug)) {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
        }
        $category = clean_input($_POST['category'] ?? 'AI / Machine Learning');
        $domainLabel = clean_input($_POST['domain_label'] ?? 'AI & Machine Learning');
        $badgeText = clean_input($_POST['badge_text'] ?? 'PROJECT');
        $shortDesc = clean_input($_POST['short_desc'] ?? '');
        $fullDesc = clean_input($_POST['full_desc'] ?? '');
        $techStack = clean_input($_POST['tech_stack'] ?? '');
        $liveDemo = clean_input($_POST['live_demo_url'] ?? '');
        $githubUrl = clean_input($_POST['github_url'] ?? '');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        $isPublished = isset($_POST['is_published']) ? 1 : 0;
        $isFeatured = isset($_POST['is_featured']) ? 1 : 0;

        // Existing thumbnail fallback
        $existingThumb = clean_input($_POST['existing_thumbnail'] ?? 'assets/images/projects/laptop-price-prediction.svg');
        $thumbnailPath = $existingThumb;

        // Handle Project Image Upload if provided
        if (!empty($_FILES['thumbnail_file']['name'])) {
            $uploadRes = handle_file_upload(
                $_FILES['thumbnail_file'],
                BASE_PATH . '/assets/images/projects',
                ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']
            );

            if ($uploadRes['success']) {
                $thumbnailPath = $uploadRes['filepath'];
            } else {
                set_flash('danger', 'Image upload failed: ' . $uploadRes['error']);
                header('Location: ' . BASE_URL . '/admin/projects.php' . ($projId > 0 ? '?action=edit&id=' . $projId : '?action=create'));
                exit;
            }
        }

        if (empty($title) || empty($shortDesc)) {
            set_flash('danger', 'Project title and short description are required.');
        } else {
            if ($projId > 0) {
                DB::execute(
                    "UPDATE projects SET 
                        title = :title, slug = :slug, short_desc = :sdesc, full_desc = :fdesc,
                        category = :cat, thumbnail_url = :thumb, tech_stack = :tech,
                        live_demo_url = :demo, github_url = :git, domain_label = :dom,
                        badge_text = :badge, is_featured = :feat, is_published = :pub, sort_order = :sort
                    WHERE id = :id",
                    [
                        'title' => $title, 'slug' => $slug, 'sdesc' => $shortDesc, 'fdesc' => $fullDesc,
                        'cat' => $category, 'thumb' => $thumbnailPath, 'tech' => $techStack,
                        'demo' => $liveDemo, 'git' => $githubUrl, 'dom' => $domainLabel,
                        'badge' => $badgeText, 'feat' => $isFeatured, 'pub' => $isPublished,
                        'sort' => $sortOrder, 'id' => $projId
                    ]
                );
                set_flash('success', 'Project updated successfully.');
            } else {
                DB::execute(
                    "INSERT INTO projects (
                        title, slug, short_desc, full_desc, category, thumbnail_url,
                        tech_stack, live_demo_url, github_url, domain_label, badge_text,
                        is_featured, is_published, sort_order
                    ) VALUES (
                        :title, :slug, :sdesc, :fdesc, :cat, :thumb,
                        :tech, :demo, :git, :dom, :badge,
                        :feat, :pub, :sort
                    )",
                    [
                        'title' => $title, 'slug' => $slug, 'sdesc' => $shortDesc, 'fdesc' => $fullDesc,
                        'cat' => $category, 'thumb' => $thumbnailPath, 'tech' => $techStack,
                        'demo' => $liveDemo, 'git' => $githubUrl, 'dom' => $domainLabel,
                        'badge' => $badgeText, 'feat' => $isFeatured, 'pub' => $isPublished, 'sort' => $sortOrder
                    ]
                );
                set_flash('success', 'New project added successfully.');
            }

            header('Location: ' . BASE_URL . '/admin/projects.php');
            exit;
        }
    }

    // 2. Toggle Publish
    if ($postAction === 'toggle_publish') {
        $projId = (int)($_POST['project_id'] ?? 0);
        $curr = (int)($_POST['current_status'] ?? 0);
        $newStatus = $curr ? 0 : 1;
        DB::execute("UPDATE projects SET is_published = :s WHERE id = :id", ['s' => $newStatus, 'id' => $projId]);
        set_flash('success', 'Project visibility toggled.');
        header('Location: ' . BASE_URL . '/admin/projects.php');
        exit;
    }

    // 3. Delete Project
    if ($postAction === 'delete_project') {
        $projId = (int)($_POST['project_id'] ?? 0);
        DB::execute("DELETE FROM projects WHERE id = :id", ['id' => $projId]);
        set_flash('success', 'Project permanently deleted.');
        header('Location: ' . BASE_URL . '/admin/projects.php');
        exit;
    }
}

// Fetch single project for editing
if ($action === 'edit' && !empty($_GET['id'])) {
    $editProject = DB::fetchOne("SELECT * FROM projects WHERE id = :id", ['id' => (int)$_GET['id']]);
}

$allProjects = DB::fetchAll("SELECT * FROM projects ORDER BY sort_order ASC, created_at DESC");
?>

<?php if ($action === 'create' || $action === 'edit'): ?>
  <!-- Project Form -->
  <div class="admin-card">
    <div class="admin-card-header">
      <h3 class="admin-card-title"><?= $editProject ? 'Edit Portfolio Project' : 'Add New Portfolio Project' ?></h3>
      <a href="<?= BASE_URL ?>/admin/projects.php" class="btn-admin btn-admin-secondary" style="font-size: 0.8rem;">&larr; Back to List</a>
    </div>

    <form action="<?= BASE_URL ?>/admin/projects.php" method="POST" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <input type="hidden" name="post_action" value="save_project">
      <input type="hidden" name="project_id" value="<?= $editProject['id'] ?? 0 ?>">
      <input type="hidden" name="existing_thumbnail" value="<?= e($editProject['thumbnail_url'] ?? 'assets/images/projects/laptop-price-prediction.svg') ?>">

      <div class="admin-form-grid">
        <div class="admin-form-group">
          <label for="title" class="admin-label">Project Title *</label>
          <input type="text" id="title" name="title" class="admin-input" placeholder="e.g. AI-Powered Classroom Attendance System" value="<?= e($editProject['title'] ?? '') ?>" required>
        </div>

        <div class="admin-form-group">
          <label for="slug" class="admin-label">Slug (URL Identifier)</label>
          <input type="text" id="slug" name="slug" class="admin-input" placeholder="e.g. classroom-attendance-ai" value="<?= e($editProject['slug'] ?? '') ?>">
        </div>

        <div class="admin-form-group">
          <label for="category" class="admin-label">Category *</label>
          <select id="category" name="category" class="admin-select" required>
            <?php
              $catOptions = ['AI / Machine Learning', 'Web Development', 'Data Analysis', 'IoT & Robotics'];
              $currCat = $editProject['category'] ?? 'AI / Machine Learning';
              foreach ($catOptions as $c):
            ?>
              <option value="<?= $c ?>" <?= $currCat === $c ? 'selected' : '' ?>><?= $c ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="admin-form-group">
          <label for="domain_label" class="admin-label">Domain Label (Display Tag)</label>
          <input type="text" id="domain_label" name="domain_label" class="admin-input" placeholder="e.g. Computer Vision / ML Regression" value="<?= e($editProject['domain_label'] ?? 'AI & Machine Learning') ?>">
        </div>

        <div class="admin-form-group">
          <label for="badge_text" class="admin-label">Thumbnail Badge Text</label>
          <input type="text" id="badge_text" name="badge_text" class="admin-input" placeholder="e.g. FACE RECOGNITION AI / REGRESSION AI" value="<?= e($editProject['badge_text'] ?? 'PRODUCTION') ?>">
        </div>

        <div class="admin-form-group">
          <label for="tech_stack" class="admin-label">Technologies Used (Comma-separated) *</label>
          <input type="text" id="tech_stack" name="tech_stack" class="admin-input" placeholder="e.g. MediaPipe, YOLOv8, OpenCV, Python" value="<?= e($editProject['tech_stack'] ?? '') ?>" required>
        </div>

        <div class="admin-form-group">
          <label for="live_demo_url" class="admin-label">Live Demo URL</label>
          <input type="text" id="live_demo_url" name="live_demo_url" class="admin-input" placeholder="https://..." value="<?= e($editProject['live_demo_url'] ?? '') ?>">
        </div>

        <div class="admin-form-group">
          <label for="github_url" class="admin-label">GitHub Repository URL</label>
          <input type="text" id="github_url" name="github_url" class="admin-input" placeholder="https://github.com/..." value="<?= e($editProject['github_url'] ?? '') ?>">
        </div>

        <div class="admin-form-group full-width">
          <label for="short_desc" class="admin-label">Card Short Summary *</label>
          <textarea id="short_desc" name="short_desc" class="admin-textarea" style="min-height: 80px;" placeholder="Brief 1-2 sentence description for gallery cards..." required><?= e($editProject['short_desc'] ?? '') ?></textarea>
        </div>

        <div class="admin-form-group full-width">
          <label for="full_desc" class="admin-label">Detailed Architecture Description *</label>
          <textarea id="full_desc" name="full_desc" class="admin-textarea" style="min-height: 140px;" placeholder="Comprehensive explanation shown inside the details modal..." required><?= e($editProject['full_desc'] ?? '') ?></textarea>
        </div>

        <!-- Thumbnail Upload Section -->
        <div class="admin-form-group full-width" style="padding: 1.25rem; background: rgba(255,255,255,0.02); border: 1px solid var(--admin-border); border-radius: 8px;">
          <label class="admin-label">Project Thumbnail Image</label>
          <div style="display: flex; align-items: center; gap: 1.5rem; margin-top: 0.5rem;">
            <?php if (!empty($editProject['thumbnail_url'])): ?>
              <img src="<?= asset($editProject['thumbnail_url']) ?>" alt="Thumbnail Preview" style="width: 140px; height: 85px; border-radius: 6px; object-fit: cover; border: 1px solid var(--admin-border);">
            <?php endif; ?>
            <div style="flex-grow: 1;">
              <input type="file" name="thumbnail_file" accept="image/jpeg,image/png,image/webp,image/svg+xml" class="admin-input" style="font-size: 0.85rem;">
              <small style="color: var(--admin-text-dim); display: block; margin-top: 0.35rem;">Upload custom screenshot or graphic (JPG, PNG, WebP, SVG).</small>
            </div>
          </div>
        </div>

        <div class="admin-form-group">
          <label for="sort_order" class="admin-label">Sort Order</label>
          <input type="number" id="sort_order" name="sort_order" class="admin-input" value="<?= $editProject['sort_order'] ?? 0 ?>">
        </div>

        <div class="admin-form-group" style="justify-content: center;">
          <label class="admin-label" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; margin-top: 1.5rem;">
            <input type="checkbox" name="is_published" value="1" <?= (!isset($editProject) || ($editProject['is_published'] ?? 1) == 1) ? 'checked' : '' ?>>
            <span>Published (Visible on Portfolio Gallery)</span>
          </label>
        </div>
      </div>

      <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--admin-border); display: flex; justify-content: flex-end; gap: 1rem;">
        <a href="<?= BASE_URL ?>/admin/projects.php" class="btn-admin btn-admin-secondary">Cancel</a>
        <button type="submit" class="btn-admin btn-admin-primary">
          <?= render_icon('folder-git-2', 'w-4 h-4') ?>
          <span><?= $editProject ? 'Update Project' : 'Create Project' ?></span>
        </button>
      </div>
    </form>
  </div>

<?php else: ?>
  <!-- Projects List Table -->
  <div class="admin-card">
    <div class="admin-card-header">
      <div>
        <h3 class="admin-card-title">Portfolio Projects Gallery</h3>
        <span style="font-size: 0.8rem; color: var(--admin-text-dim);">Total: <?= count($allProjects) ?> Projects</span>
      </div>
      <a href="<?= BASE_URL ?>/admin/projects.php?action=create" class="btn-admin btn-admin-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>Add New Project</span>
      </a>
    </div>

    <div class="admin-table-responsive">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Preview</th>
            <th>Project Title</th>
            <th>Category</th>
            <th>Badge</th>
            <th>Status</th>
            <th>Order</th>
            <th style="text-align: right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($allProjects as $p): ?>
            <tr>
              <td>
                <img src="<?= asset($p['thumbnail_url']) ?>" alt="<?= e($p['title']) ?>" style="width: 70px; height: 42px; border-radius: 4px; object-fit: cover; border: 1px solid var(--admin-border);">
              </td>
              <td>
                <div style="font-weight: 700; color: #ffffff;"><?= e($p['title']) ?></div>
                <div style="font-size: 0.75rem; color: var(--admin-text-dim);"><?= e($p['domain_label']) ?></div>
              </td>
              <td>
                <span class="tag-pill" style="font-size: 0.75rem;"><?= e($p['category']) ?></span>
              </td>
              <td>
                <span style="font-size: 0.7rem; font-weight: 700; color: #c084fc;"><?= e($p['badge_text']) ?></span>
              </td>
              <td>
                <form action="<?= BASE_URL ?>/admin/projects.php" method="POST" style="display: inline-block;">
                  <?= csrf_field() ?>
                  <input type="hidden" name="post_action" value="toggle_publish">
                  <input type="hidden" name="project_id" value="<?= $p['id'] ?>">
                  <input type="hidden" name="current_status" value="<?= $p['is_published'] ?>">
                  <button type="submit" class="badge-status <?= $p['is_published'] ? 'badge-published' : 'badge-draft' ?>" style="cursor: pointer; border: none;">
                    <?= $p['is_published'] ? 'Published' : 'Draft' ?>
                  </button>
                </form>
              </td>
              <td style="font-family: monospace; font-size: 0.85rem;"><?= $p['sort_order'] ?></td>
              <td style="text-align: right;">
                <a href="<?= BASE_URL ?>/admin/projects.php?action=edit&id=<?= $p['id'] ?>" class="btn-admin btn-admin-secondary" style="font-size: 0.75rem; padding: 0.25rem 0.65rem;">
                  Edit
                </a>
                <form action="<?= BASE_URL ?>/admin/projects.php" method="POST" style="display: inline-block;">
                  <?= csrf_field() ?>
                  <input type="hidden" name="post_action" value="delete_project">
                  <input type="hidden" name="project_id" value="<?= $p['id'] ?>">
                  <button type="submit" class="btn-admin btn-admin-danger" style="font-size: 0.75rem; padding: 0.25rem 0.65rem;" onclick="return confirm('Delete project <?= e($p['title']) ?>?');">
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
<?php endif; ?>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

