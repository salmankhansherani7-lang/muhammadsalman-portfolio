<?php
/**
 * Admin Panel Sidebar
 * Muhammad Salman - AI Engineer Portfolio
 */

defined('SECURE_ACCESS') or die('Direct access forbidden.');

$active = basename($_SERVER['PHP_SELF']);
?>
<aside class="admin-sidebar">
  <div class="sidebar-brand">
    <img src="<?= asset($admin['avatar_url'] ?? 'assets/images/profile.jpg') ?>" alt="Admin Avatar" class="sidebar-brand-avatar">
    <div>
      <div class="sidebar-brand-title"><?= e($admin['full_name'] ?? 'Muhammad Salman') ?></div>
      <div class="sidebar-brand-sub">AI Admin Control</div>
    </div>
  </div>

  <ul class="sidebar-nav">
    <li class="sidebar-nav-item <?= $active === 'index.php' ? 'active' : '' ?>">
      <a href="<?= BASE_URL ?>/admin/index.php">
        <?= render_icon('layout', 'w-4 h-4') ?>
        <span>Overview</span>
      </a>
    </li>

    <li class="sidebar-nav-item <?= $active === 'profile.php' ? 'active' : '' ?>">
      <a href="<?= BASE_URL ?>/admin/profile.php">
        <?= render_icon('users', 'w-4 h-4') ?>
        <span>Profile & Photo</span>
      </a>
    </li>

    <li class="sidebar-nav-item <?= $active === 'skills.php' ? 'active' : '' ?>">
      <a href="<?= BASE_URL ?>/admin/skills.php">
        <?= render_icon('code', 'w-4 h-4') ?>
        <span>Skills Dashboard</span>
      </a>
    </li>

    <li class="sidebar-nav-item <?= $active === 'projects.php' ? 'active' : '' ?>">
      <a href="<?= BASE_URL ?>/admin/projects.php">
        <?= render_icon('folder-git-2', 'w-4 h-4') ?>
        <span>Portfolio Projects</span>
      </a>
    </li>

    <li class="sidebar-nav-item <?= $active === 'experience.php' ? 'active' : '' ?>">
      <a href="<?= BASE_URL ?>/admin/experience.php">
        <?= render_icon('briefcase', 'w-4 h-4') ?>
        <span>Experience & Edu</span>
      </a>
    </li>

    <li class="sidebar-nav-item <?= $active === 'certifications.php' ? 'active' : '' ?>">
      <a href="<?= BASE_URL ?>/admin/certifications.php">
        <?= render_icon('award', 'w-4 h-4') ?>
        <span>Certifications</span>
      </a>
    </li>

    <li class="sidebar-nav-item <?= $active === 'services.php' ? 'active' : '' ?>">
      <a href="<?= BASE_URL ?>/admin/services.php">
        <?= render_icon('cpu', 'w-4 h-4') ?>
        <span>Services</span>
      </a>
    </li>

    <li class="sidebar-nav-item <?= $active === 'messages.php' ? 'active' : '' ?>">
      <a href="<?= BASE_URL ?>/admin/messages.php">
        <?= render_icon('mail', 'w-4 h-4') ?>
        <span>Inquiries</span>
        <?php if ($unreadMessages > 0): ?>
          <span class="sidebar-badge"><?= $unreadMessages ?></span>
        <?php endif; ?>
      </a>
    </li>

    <li class="sidebar-nav-item <?= $active === 'cv.php' ? 'active' : '' ?>">
      <a href="<?= BASE_URL ?>/admin/cv.php">
        <?= render_icon('file-text', 'w-4 h-4') ?>
        <span>CV Management</span>
      </a>
    </li>

    <li class="sidebar-nav-item <?= $active === 'settings.php' ? 'active' : '' ?>">
      <a href="<?= BASE_URL ?>/admin/settings.php">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <circle cx="12" cy="12" r="3"></circle>
          <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"></path>
        </svg>
        <span>Site Settings</span>
      </a>
    </li>

    <li class="sidebar-nav-item <?= $active === 'password.php' ? 'active' : '' ?>">
      <a href="<?= BASE_URL ?>/admin/password.php">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
          <path d="M7 11V7a5 5 0 0110 0v4"></path>
        </svg>
        <span>Security & Password</span>
      </a>
    </li>
  </ul>

  <div class="sidebar-footer">
    <a href="<?= BASE_URL ?>/admin/logout.php" class="btn-admin btn-admin-danger" style="width: 100%; justify-content: center; font-size: 0.825rem; padding: 0.5rem 0.85rem;">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
      </svg>
      <span>Secure Logout</span>
    </a>
  </div>
</aside>

