<?php
/**
 * Profile & Photograph Management
 * Muhammad Salman - AI Engineer Portfolio
 */

define('SECURE_ACCESS', true);

$pageTitle = 'Profile & Identity Management';
require_once __DIR__ . '/includes/admin_header.php';

$profile = get_profile();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_profile'])) {
    verify_csrf_or_die();

    $fullName = clean_input($_POST['full_name'] ?? '');
    $profession = clean_input($_POST['profession'] ?? '');
    $headline = clean_input($_POST['headline_titles'] ?? '');
    $shortBio = clean_input($_POST['short_bio'] ?? '');
    $fullBio = clean_input($_POST['full_bio'] ?? '');
    $location = clean_input($_POST['location'] ?? '');
    $degree = clean_input($_POST['academic_degree'] ?? '');
    $email = filter_var(trim($_POST['direct_email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone = clean_input($_POST['direct_phone'] ?? '');
    $availStatus = clean_input($_POST['availability_status'] ?? '');
    $availBadge = clean_input($_POST['availability_badge'] ?? 'Open');

    // Handle Profile Photo Upload if provided
    $avatarPath = $profile['avatar_url'];
    if (!empty($_FILES['avatar_file']['name'])) {
        $uploadRes = handle_file_upload(
            $_FILES['avatar_file'],
            BASE_PATH . '/assets/images',
            ['image/jpeg', 'image/png', 'image/webp']
        );

        if ($uploadRes['success']) {
            $avatarPath = $uploadRes['filepath'];
        } else {
            set_flash('danger', 'Photo upload failed: ' . $uploadRes['error']);
            header('Location: ' . BASE_URL . '/admin/profile.php');
            exit;
        }
    }

    // Update Profile Record
    DB::execute(
        "UPDATE profile SET 
            full_name = :name,
            profession = :prof,
            headline_titles = :head,
            short_bio = :sbio,
            full_bio = :fbio,
            avatar_url = :avatar,
            location = :loc,
            academic_degree = :deg,
            direct_email = :email,
            direct_phone = :phone,
            availability_status = :status,
            availability_badge = :badge,
            updated_at = :now
        WHERE id = :id",
        [
            'name' => $fullName,
            'prof' => $profession,
            'head' => $headline,
            'sbio' => $shortBio,
            'fbio' => $fullBio,
            'avatar' => $avatarPath,
            'loc' => $location,
            'deg' => $degree,
            'email' => $email,
            'phone' => $phone,
            'status' => $availStatus,
            'badge' => $availBadge,
            'now' => date('Y-m-d H:i:s'),
            'id' => $profile['id']
        ]
    );

    // Synchronize Admin User Full Name & Avatar
    DB::execute(
        "UPDATE admin_users SET full_name = :name, avatar_url = :avatar WHERE id = :id",
        ['name' => $fullName, 'avatar' => $avatarPath, 'id' => $_SESSION['admin_user_id']]
    );

    $_SESSION['admin_name'] = $fullName;

    set_flash('success', 'Profile and photograph successfully updated! Changes are live on the website.');
    header('Location: ' . BASE_URL . '/admin/profile.php');
    exit;
}

// Re-fetch updated profile
$profile = get_profile();
?>

<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">Edit Personal & Professional Identity</h3>
    <span style="font-size: 0.8rem; color: var(--admin-text-dim);">Last updated: <?= e($profile['updated_at'] ?? 'Initial') ?></span>
  </div>

  <form action="<?= BASE_URL ?>/admin/profile.php" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <!-- Photo Management Section -->
    <div style="display: flex; align-items: center; gap: 2rem; padding: 1.5rem; background: rgba(255,255,255,0.02); border: 1px solid var(--admin-border); border-radius: 12px; margin-bottom: 2rem;">
      <div style="position: relative;">
        <img src="<?= asset($profile['avatar_url']) ?>" alt="Profile" style="width: 110px; height: 110px; border-radius: 50%; object-fit: cover; border: 3px solid var(--admin-primary); box-shadow: 0 0 20px rgba(139,92,246,0.35);">
      </div>
      <div>
        <h4 style="font-size: 1.1rem; color: #ffffff; margin-bottom: 0.35rem;">Profile Photograph</h4>
        <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1rem;">
          Upload a high-resolution professional portrait. Supports JPG, PNG, and WebP (Max 8MB).
        </p>
        <input type="file" name="avatar_file" accept="image/jpeg,image/png,image/webp" class="admin-input" style="max-width: 340px; padding: 0.45rem 0.75rem; font-size: 0.85rem;">
      </div>
    </div>

    <!-- Core Identity Fields -->
    <div class="admin-form-grid">
      <div class="admin-form-group">
        <label for="full_name" class="admin-label">Full Name *</label>
        <input type="text" id="full_name" name="full_name" class="admin-input" value="<?= e($profile['full_name']) ?>" required>
      </div>

      <div class="admin-form-group">
        <label for="profession" class="admin-label">Profession / Title *</label>
        <input type="text" id="profession" name="profession" class="admin-input" value="<?= e($profile['profession']) ?>" required>
      </div>

      <div class="admin-form-group full-width">
        <label for="headline_titles" class="admin-label">Animated Typing Slogans (Pipe-separated)</label>
        <input type="text" id="headline_titles" name="headline_titles" class="admin-input" value="<?= e($profile['headline_titles']) ?>">
        <small style="color: var(--admin-text-dim); font-size: 0.75rem;">Example: AI Engineer | Machine Learning Specialist | Generative AI & Autonomous Agents Architect</small>
      </div>

      <div class="admin-form-group full-width">
        <label for="short_bio" class="admin-label">Hero Short Summary *</label>
        <textarea id="short_bio" name="short_bio" class="admin-textarea" style="min-height: 80px;" required><?= e($profile['short_bio']) ?></textarea>
      </div>

      <div class="admin-form-group full-width">
        <label for="full_bio" class="admin-label">About Section Detailed Biography *</label>
        <textarea id="full_bio" name="full_bio" class="admin-textarea" style="min-height: 140px;" required><?= e($profile['full_bio']) ?></textarea>
      </div>

      <div class="admin-form-group">
        <label for="location" class="admin-label">Location / Base *</label>
        <input type="text" id="location" name="location" class="admin-input" value="<?= e($profile['location']) ?>" required>
      </div>

      <div class="admin-form-group">
        <label for="academic_degree" class="admin-label">Academic Degree *</label>
        <input type="text" id="academic_degree" name="academic_degree" class="admin-input" value="<?= e($profile['academic_degree']) ?>" required>
      </div>

      <div class="admin-form-group">
        <label for="direct_email" class="admin-label">Primary Contact Email *</label>
        <input type="email" id="direct_email" name="direct_email" class="admin-input" value="<?= e($profile['direct_email']) ?>" required>
      </div>

      <div class="admin-form-group">
        <label for="direct_phone" class="admin-label">Direct Phone / WhatsApp *</label>
        <input type="text" id="direct_phone" name="direct_phone" class="admin-input" value="<?= e($profile['direct_phone']) ?>" required>
      </div>

      <div class="admin-form-group">
        <label for="availability_status" class="admin-label">Availability Status Text</label>
        <input type="text" id="availability_status" name="availability_status" class="admin-input" value="<?= e($profile['availability_status']) ?>">
      </div>

      <div class="admin-form-group">
        <label for="availability_badge" class="admin-label">Availability Pill State</label>
        <select id="availability_badge" name="availability_badge" class="admin-select">
          <option value="Open" <?= ($profile['availability_badge'] ?? '') === 'Open' ? 'selected' : '' ?>>Open to Work / Opportunities</option>
          <option value="Consulting" <?= ($profile['availability_badge'] ?? '') === 'Consulting' ? 'selected' : '' ?>>Available for Consulting</option>
          <option value="Busy" <?= ($profile['availability_badge'] ?? '') === 'Busy' ? 'selected' : '' ?>>Limited Availability</option>
        </select>
      </div>
    </div>

    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--admin-border); display: flex; justify-content: flex-end;">
      <button type="submit" name="save_profile" class="btn-admin btn-admin-primary" style="padding: 0.85rem 2rem;">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
        </svg>
        <span>Save Profile Changes</span>
      </button>
    </div>
  </form>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

