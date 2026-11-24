<?php
/**
 * Application Configuration
 * Muhammad Salman - AI Engineer Portfolio & Admin Panel
 */

// Prevent direct script access if required
if (!defined('SECURE_ACCESS')) {
    define('SECURE_ACCESS', true);
}

// Environment: 'development' or 'production'
defined('APP_ENV') or define('APP_ENV', 'development');

// Session security setup
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Lax');
    session_start();
}

// Application paths
define('BASE_PATH', dirname(__DIR__));
define('INCLUDES_PATH', BASE_PATH . '/includes');
define('PAGES_PATH', BASE_PATH . '/pages');
define('ADMIN_PATH', BASE_PATH . '/admin');
define('ASSETS_PATH', BASE_PATH . '/assets');
define('UPLOADS_PATH', BASE_PATH . '/assets/images');
define('DOCS_PATH', BASE_PATH . '/assets/docs');
define('DB_PATH', BASE_PATH . '/database');

// Base URL calculation
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || ($_SERVER['SERVER_PORT'] ?? 80) == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$script_name = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$base_url = rtrim($protocol . $host . ($script_name !== '/' ? $script_name : ''), '/');
// Remove /admin or /pages if loaded from subfolder
$base_url = preg_replace('#/(admin|pages).*$#i', '', $base_url);
define('BASE_URL', $base_url);

// Database Configuration
// Supports 'sqlite' (zero configuration) or 'mysql'
define('DB_DRIVER', 'sqlite'); // Options: 'sqlite' or 'mysql'

// MySQL Settings (used if DB_DRIVER is 'mysql')
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'salman_portfolio');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// SQLite Settings (used if DB_DRIVER is 'sqlite')
define('SQLITE_FILE', DB_PATH . '/portfolio.sqlite');

// Security & Uploads
define('MAX_UPLOAD_SIZE', 8 * 1024 * 1024); // 8 MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']);
define('ALLOWED_DOC_TYPES', ['application/pdf']);

// Login Security & Brute-force protection
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_MINUTES', 15);

// Error Reporting based on environment
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

