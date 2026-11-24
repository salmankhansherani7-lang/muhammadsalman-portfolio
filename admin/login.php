<?php
/**
 * Admin Secure Authentication Portal
 * Muhammad Salman - AI Engineer Portfolio
 */

define('SECURE_ACCESS', true);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

// Redirect if already logged in
if (is_admin_logged_in()) {
    header('Location: ' . BASE_URL . '/admin/index.php');
    exit;
}

$error = '';
$isRateLimited = is_login_rate_limited();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_submit'])) {
    if (!verify_csrf_token()) {
        $error = 'Security session expired. Please reload and try again.';
    } elseif ($isRateLimited) {
        $error = 'Too many failed login attempts. System locked for ' . LOGIN_LOCKOUT_MINUTES . ' minutes.';
    } else {
        $identifier = trim($_POST['identifier'] ?? '');
        $password = (string)($_POST['password'] ?? '');

        if (empty($identifier) || empty($password)) {
            $error = 'Please enter both your username/email and password.';
        } else {
            $result = attempt_login($identifier, $password);
            if ($result['success']) {
                header('Location: ' . BASE_URL . '/admin/index.php');
                exit;
            } else {
                $error = $result['message'];
                $isRateLimited = is_login_rate_limited();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Private Portal • Authentication</title>
  <meta name="robots" content="noindex, nofollow">

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="<?= asset('assets/images/favicon.svg') ?>">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">

  <!-- Main & Admin CSS -->
  <link rel="stylesheet" href="<?= asset('assets/css/main.css') ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/components.css') ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/admin.css') ?>">

  <style>
    .login-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      position: relative;
      background: radial-gradient(circle at top, #141b31 0%, #070a12 100%);
    }
    .login-card {
      width: 100%;
      max-width: 440px;
      padding: 2.75rem 2.25rem;
      background: rgba(17, 24, 46, 0.85);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 20px;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.7), 0 0 30px rgba(139, 92, 246, 0.15);
      backdrop-filter: blur(20px);
    }
    .login-header {
      text-align: center;
      margin-bottom: 2rem;
    }
    .login-icon {
      width: 56px;
      height: 56px;
      border-radius: 16px;
      background: linear-gradient(135deg, #8b5cf6, #ec4899);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.25rem;
      color: #ffffff;
      box-shadow: 0 0 25px rgba(139, 92, 246, 0.4);
    }
    .login-title {
      font-size: 1.5rem;
      font-weight: 800;
      color: #ffffff;
      letter-spacing: -0.02em;
    }
    .login-subtitle {
      font-size: 0.85rem;
      color: var(--text-muted);
      margin-top: 0.35rem;
    }
  </style>
</head>
<body class="admin-body">
  <div class="login-wrapper">
    <div class="login-card">
      <div class="login-header">
        <div class="login-icon">
          <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
            <path d="M7 11V7a5 5 0 0110 0v4"></path>
          </svg>
        </div>
        <h1 class="login-title">Private Management Portal</h1>
        <p class="login-subtitle">Muhammad Salman • AI Engineer Dashboard</p>
      </div>

      <?php if (!empty($error)): ?>
        <div class="admin-alert admin-alert-danger" style="margin-bottom: 1.5rem;">
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
          </svg>
          <span><?= e($error) ?></span>
        </div>
      <?php endif; ?>

      <form action="<?= BASE_URL ?>/admin/login.php" method="POST">
        <?= csrf_field() ?>

        <div class="admin-form-group">
          <label for="identifier" class="admin-label">Username or Email</label>
          <input
            type="text"
            id="identifier"
            name="identifier"
            class="admin-input"
            placeholder="admin or email address"
            required
            autocomplete="username"
            autofocus
          >
        </div>

        <div class="admin-form-group">
          <label for="password" class="admin-label">Password</label>
          <input
            type="password"
            id="password"
            name="password"
            class="admin-input"
            placeholder="••••••••••••"
            required
            autocomplete="current-password"
          >
        </div>

        <button
          type="submit"
          name="login_submit"
          class="btn btn-primary"
          style="width: 100%; padding: 0.85rem; margin-top: 1.25rem; font-size: 0.95rem;"
          <?= $isRateLimited ? 'disabled' : '' ?>
        >
          <span>Authenticate & Access Control</span>
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
          </svg>
        </button>
      </form>

      <div style="margin-top: 2rem; padding-top: 1.25rem; border-top: 1px solid rgba(255,255,255,0.06); text-align: center;">
        <span style="font-size: 0.75rem; color: var(--admin-text-dim);">
          🔒 AES & BCRYPT Encrypted • Session Isolated Route
        </span>
      </div>
    </div>
  </div>
</body>
</html>

