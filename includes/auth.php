<?php
/**
 * Authentication & Security Management
 * Muhammad Salman - AI Engineer Portfolio
 */

defined('SECURE_ACCESS') or die('Direct access forbidden.');

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/functions.php';

/**
 * Check if the admin is currently authenticated
 */
function is_admin_logged_in(): bool {
    return !empty($_SESSION['admin_user_id']) && !empty($_SESSION['admin_username']);
}

/**
 * Get data for currently authenticated admin
 */
function get_logged_in_admin(): ?array {
    if (!is_admin_logged_in()) {
        return null;
    }
    return DB::fetchOne("SELECT id, username, email, full_name, avatar_url, last_login FROM admin_users WHERE id = :id", [
        'id' => $_SESSION['admin_user_id']
    ]);
}

/**
 * Guard for protected admin pages
 */
function require_admin_login(): void {
    if (!is_admin_logged_in()) {
        $loginUrl = BASE_URL . '/admin/login.php';
        header("Location: $loginUrl");
        exit;
    }
}

/**
 * Check login rate limiting for IP
 */
function is_login_rate_limited(): bool {
    $ip = get_client_ip();
    $cutoff = date('Y-m-d H:i:s', strtotime('-' . LOGIN_LOCKOUT_MINUTES . ' minutes'));
    
    $row = DB::fetchOne(
        "SELECT COUNT(*) as attempts FROM login_attempts WHERE ip_address = :ip AND attempt_time > :cutoff",
        ['ip' => $ip, 'cutoff' => $cutoff]
    );

    return ($row['attempts'] ?? 0) >= MAX_LOGIN_ATTEMPTS;
}

/**
 * Record a failed login attempt
 */
function record_failed_login(): void {
    $ip = get_client_ip();
    DB::execute(
        "INSERT INTO login_attempts (ip_address, attempt_time) VALUES (:ip, :time)",
        ['ip' => $ip, 'time' => date('Y-m-d H:i:s')]
    );
}

/**
 * Clear failed login attempts after successful authentication
 */
function clear_failed_logins(): void {
    $ip = get_client_ip();
    DB::execute("DELETE FROM login_attempts WHERE ip_address = :ip", ['ip' => $ip]);
}

/**
 * Attempt admin login with credentials
 */
function attempt_login(string $identifier, string $password): array {
    if (is_login_rate_limited()) {
        return [
            'success' => false,
            'message' => 'Too many failed login attempts. Please wait ' . LOGIN_LOCKOUT_MINUTES . ' minutes before trying again.'
        ];
    }

    $identifier = trim($identifier);
    $user = DB::fetchOne(
        "SELECT * FROM admin_users WHERE username = :ident OR email = :ident LIMIT 1",
        ['ident' => $identifier]
    );

    if (!$user || !password_verify($password, $user['password_hash'])) {
        record_failed_login();
        return [
            'success' => false,
            'message' => 'Invalid username/email or password.'
        ];
    }

    // Authentication succeeded: clear rate-limiting, regenerate session ID to prevent session fixation
    clear_failed_logins();
    session_regenerate_id(true);

    $_SESSION['admin_user_id'] = $user['id'];
    $_SESSION['admin_username'] = $user['username'];
    $_SESSION['admin_name'] = $user['full_name'];
    $_SESSION['admin_email'] = $user['email'];
    $_SESSION['admin_logged_time'] = time();

    // Update last login timestamp
    DB::execute(
        "UPDATE admin_users SET last_login = :now WHERE id = :id",
        ['now' => date('Y-m-d H:i:s'), 'id' => $user['id']]
    );

    return [
        'success' => true,
        'message' => 'Login successful.'
    ];
}

/**
 * Securely destroy admin session
 */
function logout_admin(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
}

/**
 * Change administrator password
 */
function update_admin_password(int $userId, string $newPassword): bool {
    $newHash = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
    $affected = DB::execute(
        "UPDATE admin_users SET password_hash = :hash WHERE id = :id",
        ['hash' => $newHash, 'id' => $userId]
    );
    return $affected > 0;
}
