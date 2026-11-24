<?php
/**
 * Admin Logout Controller
 * Muhammad Salman - AI Engineer Portfolio
 */

define('SECURE_ACCESS', true);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

logout_admin();

header('Location: ' . BASE_URL . '/admin/login.php');
exit;

