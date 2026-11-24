<?php
/**
 * Admin Panel Layout Header
 * Muhammad Salman - AI Engineer Portfolio
 */

defined('SECURE_ACCESS') or die('Direct access forbidden.');

require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/csrf.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/functions.php';

// Guard: verify admin authentication
require_admin_login();

$admin = get_logged_in_admin();
$unreadMessages = get_unread_message_count();
$flash = get_flash();
$currentScript = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($pageTitle ?? 'Admin Dashboard') ?> • Private Control Center</title>
  <meta name="robots" content="noindex, nofollow">

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="<?= asset('assets/images/favicon.svg') ?>">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">

  <!-- Admin Stylesheet -->
  <link rel="stylesheet" href="<?= asset('assets/css/admin.css') ?>">
</head>
<body class="admin-body">
  <?php require_once __DIR__ . '/admin_sidebar.php'; ?>

  <div class="admin-main">
    <header class="admin-topbar">
      <div class="topbar-title"><?= e($pageTitle ?? 'Dashboard Overview') ?></div>
      <div class="topbar-actions">
        <a href="<?= BASE_URL ?>/" target="_blank" class="btn-admin btn-admin-secondary" style="font-size: 0.8rem; padding: 0.45rem 0.85rem;">
          <?= render_icon('external-link', 'w-3.5 h-3.5') ?>
          <span>View Public Site</span>
        </a>
        <div style="display: flex; align-items: center; gap: 0.75rem;">
          <img src="<?= asset($admin['avatar_url'] ?? 'assets/images/profile.jpg') ?>" alt="Admin" style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 1.5px solid var(--admin-primary);">
          <span style="font-size: 0.85rem; font-weight: 600; color: #ffffff;"><?= e($admin['full_name'] ?? 'Muhammad Salman') ?></span>
        </div>
      </div>
    </header>

    <div class="admin-content">
      <?php if ($flash): ?>
        <div class="admin-alert admin-alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?>">
          <span><?= e($flash['message']) ?></span>
        </div>
      <?php endif; ?>

