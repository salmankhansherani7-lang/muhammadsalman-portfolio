<?php
/**
 * Admin Dashboard Overview
 * Muhammad Salman - AI Engineer Portfolio
 */

define('SECURE_ACCESS', true);

$pageTitle = 'Dashboard Overview';
require_once __DIR__ . '/includes/admin_header.php';

// Fetch Metrics
$projectCount = (int)(DB::fetchOne("SELECT COUNT(*) as c FROM projects")['c'] ?? 0);
$skillCount = (int)(DB::fetchOne("SELECT COUNT(*) as c FROM skills")['c'] ?? 0);
$messageCount = (int)(DB::fetchOne("SELECT COUNT(*) as c FROM contact_messages")['c'] ?? 0);
$unreadCount = (int)(DB::fetchOne("SELECT COUNT(*) as c FROM contact_messages WHERE is_read = 0")['c'] ?? 0);
$certCount = (int)(DB::fetchOne("SELECT COUNT(*) as c FROM certifications")['c'] ?? 0);

// Fetch Recent Messages
$recentMessages = DB::fetchAll("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5");

// Handle Quick Read / Delete from Overview
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    verify_csrf_or_die();
    $msgId = (int)($_POST['message_id'] ?? 0);

    if ($_POST['action'] === 'mark_read') {
        DB::execute("UPDATE contact_messages SET is_read = 1 WHERE id = :id", ['id' => $msgId]);
        set_flash('success', 'Message marked as read.');
    } elseif ($_POST['action'] === 'delete') {
        DB::execute("DELETE FROM contact_messages WHERE id = :id", ['id' => $msgId]);
        set_flash('success', 'Message deleted permanently.');
    }
    header('Location: ' . BASE_URL . '/admin/index.php');
    exit;
}
?>

<!-- KPI Cards Grid -->
<div class="admin-kpi-grid">
  <div class="kpi-card">
    <div class="kpi-icon-wrap" style="background: rgba(139, 92, 246, 0.15); color: #c084fc;">
      <?= render_icon('folder-git-2', 'w-6 h-6') ?>
    </div>
    <div>
      <div class="kpi-val"><?= $projectCount ?></div>
      <div class="kpi-label">Portfolio Projects</div>
    </div>
  </div>

  <div class="kpi-card">
    <div class="kpi-icon-wrap" style="background: rgba(6, 182, 212, 0.15); color: #38bdf8;">
      <?= render_icon('code', 'w-6 h-6') ?>
    </div>
    <div>
      <div class="kpi-val"><?= $skillCount ?></div>
      <div class="kpi-label">Active Skills</div>
    </div>
  </div>

  <div class="kpi-card">
    <div class="kpi-icon-wrap" style="background: rgba(236, 72, 153, 0.15); color: #f472b6;">
      <?= render_icon('mail', 'w-6 h-6') ?>
    </div>
    <div>
      <div class="kpi-val"><?= $unreadCount ?> / <?= $messageCount ?></div>
      <div class="kpi-label">Unread / Total Messages</div>
    </div>
  </div>

  <div class="kpi-card">
    <div class="kpi-icon-wrap" style="background: rgba(16, 185, 129, 0.15); color: #34d399;">
      <?= render_icon('award', 'w-6 h-6') ?>
    </div>
    <div>
      <div class="kpi-val"><?= $certCount ?></div>
      <div class="kpi-label">Certifications</div>
    </div>
  </div>
</div>

<!-- Quick Shortcuts Bar -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">Management Quick Actions</h3>
  </div>
  <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
    <a href="<?= BASE_URL ?>/admin/projects.php?action=create" class="btn-admin btn-admin-primary">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
      </svg>
      <span>New Project</span>
    </a>

    <a href="<?= BASE_URL ?>/admin/skills.php" class="btn-admin btn-admin-secondary">
      <?= render_icon('code', 'w-4 h-4') ?>
      <span>Add / Edit Skills</span>
    </a>

    <a href="<?= BASE_URL ?>/admin/profile.php" class="btn-admin btn-admin-secondary">
      <?= render_icon('users', 'w-4 h-4') ?>
      <span>Edit Profile & Avatar</span>
    </a>

    <a href="<?= BASE_URL ?>/admin/cv.php" class="btn-admin btn-admin-secondary">
      <?= render_icon('file-text', 'w-4 h-4') ?>
      <span>Update Curriculum Vitae</span>
    </a>

    <a href="<?= BASE_URL ?>/admin/settings.php" class="btn-admin btn-admin-secondary">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="3"></circle>
        <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"></path>
      </svg>
      <span>Website Configuration</span>
    </a>
  </div>
</div>

<!-- Recent Inquiries Table -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">Recent Contact Inquiries</h3>
    <a href="<?= BASE_URL ?>/admin/messages.php" class="btn-admin btn-admin-secondary" style="font-size: 0.8rem; padding: 0.35rem 0.75rem;">
      View All Inquiries &rarr;
    </a>
  </div>

  <?php if (empty($recentMessages)): ?>
    <p style="color: var(--admin-text-dim); font-size: 0.9rem; text-align: center; padding: 2rem;">No inquiries received yet. Submissions from the contact form will appear here.</p>
  <?php else: ?>
    <div class="admin-table-responsive">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Status</th>
            <th>Sender Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Date</th>
            <th style="text-align: right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($recentMessages as $msg): ?>
            <tr>
              <td>
                <span class="badge-status <?= $msg['is_read'] ? 'badge-read' : 'badge-unread' ?>">
                  <?= $msg['is_read'] ? 'Read' : 'New' ?>
                </span>
              </td>
              <td style="font-weight: 600;"><?= e($msg['name']) ?></td>
              <td>
                <a href="mailto:<?= e($msg['email']) ?>" style="color: #38bdf8;"><?= e($msg['email']) ?></a>
              </td>
              <td><?= e($msg['subject']) ?></td>
              <td style="color: var(--admin-text-dim); font-size: 0.8rem;"><?= date('M d, Y H:i', strtotime($msg['created_at'])) ?></td>
              <td style="text-align: right;">
                <form action="<?= BASE_URL ?>/admin/index.php" method="POST" style="display: inline-block;">
                  <?= csrf_field() ?>
                  <input type="hidden" name="message_id" value="<?= $msg['id'] ?>">
                  <?php if (!$msg['is_read']): ?>
                    <button type="submit" name="action" value="mark_read" class="btn-admin btn-admin-secondary" style="font-size: 0.75rem; padding: 0.25rem 0.6rem;">
                      Mark Read
                    </button>
                  <?php endif; ?>
                  <button type="submit" name="action" value="delete" class="btn-admin btn-admin-danger" style="font-size: 0.75rem; padding: 0.25rem 0.6rem;" onclick="return confirm('Permanently delete this message?');">
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

<!-- System Environment Card -->
<div class="admin-card" style="background: rgba(12, 18, 32, 0.4);">
  <div class="admin-card-header">
    <h3 class="admin-card-title" style="font-size: 1rem;">System & Security Diagnostics</h3>
  </div>
  <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; font-size: 0.85rem;">
    <div>
      <span style="color: var(--admin-text-dim);">PHP Runtime:</span>
      <div style="font-weight: 700; color: #34d399; font-family: monospace;"><?= PHP_VERSION ?></div>
    </div>
    <div>
      <span style="color: var(--admin-text-dim);">Database Driver:</span>
      <div style="font-weight: 700; color: #38bdf8; font-family: monospace;"><?= strtoupper(DB_DRIVER) ?> (Active)</div>
    </div>
    <div>
      <span style="color: var(--admin-text-dim);">Authentication:</span>
      <div style="font-weight: 700; color: #c084fc;">BCRYPT (Cost 12)</div>
    </div>
    <div>
      <span style="color: var(--admin-text-dim);">Last Login:</span>
      <div style="color: var(--admin-text);"><?= e($admin['last_login'] ?? 'Just now') ?></div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

