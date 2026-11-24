<?php
/**
 * Administrator Password Management
 * Muhammad Salman - AI Engineer Portfolio
 */

define('SECURE_ACCESS', true);

$pageTitle = 'Security & Password';
require_once __DIR__ . '/includes/admin_header.php';

$userId = (int)$_SESSION['admin_user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    verify_csrf_or_die();

    $currentPass = (string)($_POST['current_password'] ?? '');
    $newPass = (string)($_POST['new_password'] ?? '');
    $confirmPass = (string)($_POST['confirm_password'] ?? '');

    // Fetch user to verify current password
    $user = DB::fetchOne("SELECT password_hash FROM admin_users WHERE id = :id", ['id' => $userId]);

    if (!$user || !password_verify($currentPass, $user['password_hash'])) {
        set_flash('danger', 'Your current password was entered incorrectly.');
    } elseif (strlen($newPass) < 8) {
        set_flash('danger', 'The new password must be at least 8 characters in length.');
    } elseif ($newPass !== $confirmPass) {
        set_flash('danger', 'The new password and confirmation do not match.');
    } else {
        $updated = update_admin_password($userId, $newPass);
        if ($updated) {
            set_flash('success', 'Your password has been securely updated! Please use your new credentials for future logins.');
        } else {
            set_flash('danger', 'Failed to update password. Please try again.');
        }
    }

    header('Location: ' . BASE_URL . '/admin/password.php');
    exit;
}
?>

<div class="admin-card" style="max-width: 620px;">
  <div class="admin-card-header">
    <h3 class="admin-card-title">Change Administrative Password</h3>
  </div>

  <form action="<?= BASE_URL ?>/admin/password.php" method="POST">
    <?= csrf_field() ?>

    <div class="admin-form-group">
      <label for="current_password" class="admin-label">Current Password *</label>
      <input type="password" id="current_password" name="current_password" class="admin-input" required autocomplete="current-password">
    </div>

    <div class="admin-form-group">
      <label for="new_password" class="admin-label">New Password *</label>
      <input type="password" id="new_password" name="new_password" class="admin-input" required minlength="8" autocomplete="new-password">
      <small style="color: var(--admin-text-dim); font-size: 0.75rem;">Minimum 8 characters with letters, numbers or symbols.</small>
    </div>

    <div class="admin-form-group">
      <label for="confirm_password" class="admin-label">Confirm New Password *</label>
      <input type="password" id="confirm_password" name="confirm_password" class="admin-input" required minlength="8" autocomplete="new-password">
    </div>

    <div style="margin-top: 2rem; padding-top: 1.25rem; border-top: 1px solid var(--admin-border); display: flex; justify-content: flex-end;">
      <button type="submit" name="change_password" class="btn-admin btn-admin-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
          <path d="M7 11V7a5 5 0 0110 0v4"></path>
        </svg>
        <span>Update Password</span>
      </button>
    </div>
  </form>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

