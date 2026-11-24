<?php
/**
 * Contact Inquiries Inbox
 * Muhammad Salman - AI Engineer Portfolio
 */

define('SECURE_ACCESS', true);

$pageTitle = 'Contact Messages Inbox';
require_once __DIR__ . '/includes/admin_header.php';

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_or_die();
    $postAction = $_POST['post_action'] ?? '';
    $msgId = (int)($_POST['message_id'] ?? 0);

    if ($postAction === 'mark_read') {
        DB::execute("UPDATE contact_messages SET is_read = 1 WHERE id = :id", ['id' => $msgId]);
        set_flash('success', 'Message marked as read.');
    } elseif ($postAction === 'mark_unread') {
        DB::execute("UPDATE contact_messages SET is_read = 0 WHERE id = :id", ['id' => $msgId]);
        set_flash('success', 'Message marked as unread.');
    } elseif ($postAction === 'delete') {
        DB::execute("DELETE FROM contact_messages WHERE id = :id", ['id' => $msgId]);
        set_flash('success', 'Message deleted.');
    }
    header('Location: ' . BASE_URL . '/admin/messages.php');
    exit;
}

$messages = DB::fetchAll("SELECT * FROM contact_messages ORDER BY created_at DESC");
?>

<div class="admin-card">
  <div class="admin-card-header">
    <div>
      <h3 class="admin-card-title">Inquiries & Contact Requests (<?= count($messages) ?>)</h3>
      <span style="font-size: 0.8rem; color: var(--admin-text-dim);">Unread: <?= $unreadMessages ?></span>
    </div>
  </div>

  <?php if (empty($messages)): ?>
    <div style="text-align: center; padding: 4rem 1rem; color: var(--admin-text-dim);">
      <?= render_icon('mail', 'w-12 h-12') ?>
      <p style="margin-top: 1rem; font-size: 1rem;">No contact inquiries received yet.</p>
    </div>
  <?php else: ?>
    <div style="display: flex; flex-direction: column; gap: 1.25rem;">
      <?php foreach ($messages as $m): ?>
        <div style="background: rgba(255,255,255,0.02); border: 1px solid <?= $m['is_read'] ? 'var(--admin-border)' : 'rgba(236,72,153,0.4)' ?>; border-radius: 12px; padding: 1.5rem; transition: all 0.2s ease;">
          <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 0.85rem;">
            <div>
              <div style="display: flex; align-items: center; gap: 0.65rem;">
                <span class="badge-status <?= $m['is_read'] ? 'badge-read' : 'badge-unread' ?>">
                  <?= $m['is_read'] ? 'Read' : 'New Message' ?>
                </span>
                <h4 style="font-size: 1.1rem; font-weight: 700; color: #ffffff;"><?= e($m['subject']) ?></h4>
              </div>
              <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-top: 0.25rem;">
                From: <strong style="color: #ffffff;"><?= e($m['name']) ?></strong> &lt;<a href="mailto:<?= e($m['email']) ?>" style="color: #38bdf8;"><?= e($m['email']) ?></a>&gt;
              </p>
            </div>

            <div style="text-align: right; font-size: 0.75rem; color: var(--admin-text-dim);">
              <div><?= date('F j, Y, g:i a', strtotime($m['created_at'])) ?></div>
              <?php if (!empty($m['ip_address'])): ?>
                <div>IP: <?= e($m['ip_address']) ?></div>
              <?php endif; ?>
            </div>
          </div>

          <div style="background: rgba(0,0,0,0.25); border-radius: 8px; padding: 1.15rem; font-size: 0.925rem; color: #e2e8f0; line-height: 1.6; margin-bottom: 1.25rem;">
            <?= nl2br(e($m['message'])) ?>
          </div>

          <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--admin-border); padding-top: 0.85rem;">
            <a href="mailto:<?= e($m['email']) ?>?subject=Re: <?= rawurlencode($m['subject']) ?>" class="btn-admin btn-admin-primary" style="font-size: 0.8rem; padding: 0.4rem 0.85rem;">
              <?= render_icon('mail', 'w-3.5 h-3.5') ?>
              <span>Reply via Email</span>
            </a>

            <div style="display: flex; gap: 0.5rem;">
              <form action="<?= BASE_URL ?>/admin/messages.php" method="POST" style="display: inline-block;">
                <?= csrf_field() ?>
                <input type="hidden" name="message_id" value="<?= $m['id'] ?>">
                <?php if ($m['is_read']): ?>
                  <button type="submit" name="post_action" value="mark_unread" class="btn-admin btn-admin-secondary" style="font-size: 0.75rem; padding: 0.35rem 0.65rem;">
                    Mark Unread
                  </button>
                <?php else: ?>
                  <button type="submit" name="post_action" value="mark_read" class="btn-admin btn-admin-secondary" style="font-size: 0.75rem; padding: 0.35rem 0.65rem;">
                    Mark Read
                  </button>
                <?php endif; ?>
                <button type="submit" name="post_action" value="delete" class="btn-admin btn-admin-danger" style="font-size: 0.75rem; padding: 0.35rem 0.65rem;" onclick="return confirm('Permanently delete message?');">
                  Delete
                </button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

