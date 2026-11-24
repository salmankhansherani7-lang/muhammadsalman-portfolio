<?php
/**
 * Global Helper Functions
 * Muhammad Salman - AI Engineer Portfolio
 */

defined('SECURE_ACCESS') or die('Direct access forbidden.');

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/csrf.php';

/**
 * Escape HTML output for XSS prevention
 */
function e(?string $string): string {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Get client IP address safely
 */
if (!function_exists('get_client_ip')) {
    function get_client_ip(): string {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $parts = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($parts[0]);
        }
        return filter_var($ip, FILTER_VALIDATE_IP) ?: '127.0.0.1';
    }
}

/**
 * Sanitize text input
 */
function clean_input(mixed $data): string {
    if (is_array($data)) {
        return '';
    }
    return trim(strip_tags((string)$data));
}

/**
 * Generate asset URL with cache-busting timestamp
 */
function asset(string $path): string {
    $cleanPath = ltrim($path, '/');
    $fullPath = BASE_PATH . '/' . $cleanPath;
    $v = file_exists($fullPath) ? filemtime($fullPath) : time();
    return BASE_URL . '/' . $cleanPath . '?v=' . $v;
}

/**
 * Retrieve a website setting by key
 */
function get_setting(string $key, string $default = ''): string {
    static $settingsCache = null;
    if ($settingsCache === null) {
        $rows = DB::fetchAll("SELECT setting_key, setting_value FROM site_settings");
        $settingsCache = [];
        foreach ($rows as $r) {
            $settingsCache[$r['setting_key']] = $r['setting_value'];
        }
    }
    return $settingsCache[$key] ?? $default;
}

/**
 * Update a website setting
 */
function update_setting(string $key, string $value): bool {
    $exists = DB::fetchOne("SELECT id FROM site_settings WHERE setting_key = :k", ['k' => $key]);
    if ($exists) {
        return DB::execute(
            "UPDATE site_settings SET setting_value = :v WHERE setting_key = :k",
            ['v' => $value, 'k' => $key]
        ) >= 0;
    } else {
        return DB::execute(
            "INSERT INTO site_settings (setting_key, setting_value) VALUES (:k, :v)",
            ['k' => $key, 'v' => $value]
        ) > 0;
    }
}

/**
 * Retrieve Profile Data
 */
function get_profile(): array {
    $profile = DB::fetchOne("SELECT * FROM profile ORDER BY id ASC LIMIT 1");
    if (!$profile) {
        return [
            'id' => 1,
            'full_name' => 'Muhammad Salman',
            'profession' => 'AI Engineer',
            'headline_titles' => 'AI Engineer | Machine Learning Specialist | Generative AI & Autonomous Agents Architect',
            'short_bio' => 'AI Engineer specializing in Machine Learning, Generative AI & Autonomous Agents, Computer Vision, and Full-Stack Systems.',
            'full_bio' => 'Passionate AI Engineer bridging deep learning research with production-ready real-time systems.',
            'avatar_url' => 'assets/images/profile.jpg',
            'location' => 'Islamabad & Rawalpindi, Pakistan',
            'academic_degree' => 'B.S. in Computer Science / Artificial Intelligence',
            'direct_email' => 'contact@muhammadsalman.ai',
            'direct_phone' => '+92 300 1234567',
            'availability_status' => 'Available for Opportunities',
            'availability_badge' => 'Open',
            'cv_download_url' => 'assets/docs/Muhammad_Salman_CV.pdf'
        ];
    }
    return $profile;
}

/**
 * Retrieve Hero Statistics Cards
 */
function get_hero_stats(bool $activeOnly = true): array {
    $sql = "SELECT * FROM hero_stats" . ($activeOnly ? " WHERE is_active = 1" : "") . " ORDER BY sort_order ASC, id ASC";
    return DB::fetchAll($sql);
}

/**
 * Retrieve Orbiting Hero Tags
 */
function get_hero_tags(bool $activeOnly = true): array {
    $sql = "SELECT * FROM hero_tags" . ($activeOnly ? " WHERE is_active = 1" : "") . " ORDER BY sort_order ASC, id ASC";
    return DB::fetchAll($sql);
}

/**
 * Retrieve Skill Categories
 */
function get_skill_categories(bool $activeOnly = true): array {
    $sql = "SELECT * FROM skill_categories" . ($activeOnly ? " WHERE is_active = 1" : "") . " ORDER BY sort_order ASC, id ASC";
    return DB::fetchAll($sql);
}

/**
 * Retrieve Skills by Category
 */
function get_skills_by_category(int $categoryId, bool $activeOnly = true): array {
    $sql = "SELECT * FROM skills WHERE category_id = :cat_id" . ($activeOnly ? " AND is_active = 1" : "") . " ORDER BY sort_order ASC, id ASC";
    return DB::fetchAll($sql, ['cat_id' => $categoryId]);
}

/**
 * Retrieve All Skills Grouped by Category
 */
function get_all_skills_grouped(bool $activeOnly = true): array {
    $categories = get_skill_categories($activeOnly);
    $result = [];
    foreach ($categories as $cat) {
        $cat['skills'] = get_skills_by_category($cat['id'], $activeOnly);
        $result[] = $cat;
    }
    return $result;
}

/**
 * Retrieve Portfolio Projects
 */
function get_projects(?string $category = null, bool $onlyPublished = true): array {
    $where = [];
    $params = [];

    if ($onlyPublished) {
        $where[] = "is_published = 1";
    }
    if (!empty($category) && $category !== 'All Projects' && $category !== 'all') {
        $where[] = "category = :cat";
        $params['cat'] = $category;
    }

    $whereClause = !empty($where) ? " WHERE " . implode(" AND ", $where) : "";
    $sql = "SELECT * FROM projects" . $whereClause . " ORDER BY sort_order ASC, created_at DESC";

    return DB::fetchAll($sql, $params);
}

/**
 * Retrieve Single Project by ID or Slug
 */
function get_project(int|string $identifier): ?array {
    if (is_numeric($identifier)) {
        return DB::fetchOne("SELECT * FROM projects WHERE id = :id", ['id' => $identifier]);
    }
    return DB::fetchOne("SELECT * FROM projects WHERE slug = :slug", ['slug' => $identifier]);
}

/**
 * Retrieve distinct project categories
 */
function get_project_categories(): array {
    $rows = DB::fetchAll("SELECT DISTINCT category FROM projects WHERE is_published = 1 ORDER BY category ASC");
    $categories = ['All Projects'];
    foreach ($rows as $r) {
        if (!empty($r['category']) && !in_array($r['category'], $categories)) {
            $categories[] = $r['category'];
        }
    }
    return $categories;
}

/**
 * Retrieve Work Experience
 */
function get_experience(bool $activeOnly = true): array {
    $sql = "SELECT * FROM experience" . ($activeOnly ? " WHERE is_active = 1" : "") . " ORDER BY sort_order ASC, id ASC";
    return DB::fetchAll($sql);
}

/**
 * Retrieve Academic Education
 */
function get_education(bool $activeOnly = true): array {
    $sql = "SELECT * FROM education" . ($activeOnly ? " WHERE is_active = 1" : "") . " ORDER BY sort_order ASC, id ASC";
    return DB::fetchAll($sql);
}

/**
 * Retrieve Professional Certifications
 */
function get_certifications(bool $activeOnly = true): array {
    $sql = "SELECT * FROM certifications" . ($activeOnly ? " WHERE is_active = 1" : "") . " ORDER BY sort_order ASC, id ASC";
    return DB::fetchAll($sql);
}

/**
 * Retrieve Services Offered
 */
function get_services(bool $activeOnly = true): array {
    $sql = "SELECT * FROM services" . ($activeOnly ? " WHERE is_active = 1" : "") . " ORDER BY sort_order ASC, id ASC";
    return DB::fetchAll($sql);
}

/**
 * Retrieve Social Links
 */
function get_social_links(bool $activeOnly = true): array {
    $sql = "SELECT * FROM social_links WHERE 1=1" . ($activeOnly ? " AND is_active = 1" : "") . " ORDER BY sort_order ASC, id ASC";
    return DB::fetchAll($sql);
}

/**
 * Retrieve CV Data from cv_sections table
 */
function get_cv_data(): array {
    $rows = DB::fetchAll("SELECT * FROM cv_sections ORDER BY sort_order ASC");
    $cv = [];
    foreach ($rows as $r) {
        $decoded = json_decode($r['content_json'], true);
        $cv[$r['section_key']] = [
            'id' => $r['id'],
            'title' => $r['section_title'],
            'data' => $decoded ?? []
        ];
    }
    return $cv;
}

/**
 * Save Contact Message
 */
function save_contact_message(string $name, string $email, string $subject, string $message, string $ip): bool {
    return DB::execute(
        "INSERT INTO contact_messages (name, email, subject, message, ip_address) VALUES (:name, :email, :subject, :message, :ip)",
        [
            'name' => clean_input($name),
            'email' => filter_var(trim($email), FILTER_SANITIZE_EMAIL),
            'subject' => clean_input($subject),
            'message' => clean_input($message),
            'ip' => $ip
        ]
    ) > 0;
}

/**
 * Get count of unread contact messages
 */
function get_unread_message_count(): int {
    $row = DB::fetchOne("SELECT COUNT(*) as cnt FROM contact_messages WHERE is_read = 0");
    return (int)($row['cnt'] ?? 0);
}

/**
 * Set flash message
 */
function set_flash(string $type, string $message): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['flash_msg'] = [
        'type' => $type, // 'success', 'danger', 'warning', 'info'
        'message' => $message
    ];
}

/**
 * Retrieve and clear flash message
 */
function get_flash(): ?array {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!empty($_SESSION['flash_msg'])) {
        $flash = $_SESSION['flash_msg'];
        unset($_SESSION['flash_msg']);
        return $flash;
    }
    return null;
}

/**
 * Secure file upload helper
 */
function handle_file_upload(array $file, string $targetDir, array $allowedMimes, int $maxBytes = MAX_UPLOAD_SIZE): array {
    if (empty($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['success' => false, 'error' => 'No file was uploaded.'];
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Upload error code: ' . $file['error']];
    }

    if ($file['size'] > $maxBytes) {
        return ['success' => false, 'error' => 'File exceeds maximum allowed size of ' . round($maxBytes / 1048576, 1) . 'MB.'];
    }

    // Verify MIME type using fileinfo
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $detectedMime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($detectedMime, $allowedMimes, true)) {
        return ['success' => false, 'error' => 'Invalid file format (' . htmlspecialchars($detectedMime) . ').'];
    }

    // Determine extension safely
    $extensionMap = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/svg+xml' => 'svg',
        'application/pdf' => 'pdf'
    ];
    $ext = $extensionMap[$detectedMime] ?? pathinfo($file['name'], PATHINFO_EXTENSION);
    $safeName = 'upload_' . date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $ext;

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $destPath = rtrim($targetDir, '/\\') . DIRECTORY_SEPARATOR . $safeName;

    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        return ['success' => false, 'error' => 'Failed to save uploaded file to destination.'];
    }

    // Return relative web path
    $relative = str_replace(str_replace('\\', '/', BASE_PATH) . '/', '', str_replace('\\', '/', $destPath));

    return [
        'success' => true,
        'filename' => $safeName,
        'filepath' => $relative,
        'fullpath' => $destPath
    ];
}

/**
 * Render standard SVG icons cleanly
 */
function render_icon(string $name, string $classes = 'w-5 h-5'): string {
    $icons = [
        'brain' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M9.5 2A2.5 2.5 0 0 1 12 4.5v15a2.5 2.5 0 0 1-4.96.44 2.5 2.5 0 0 1-2.96-3.08 3 3 0 0 1-.34-5.58 2.5 2.5 0 0 1 1.32-4.24 2.5 2.5 0 0 1 4.44-2.04z"/><path d="M14.5 2A2.5 2.5 0 0 0 12 4.5v15a2.5 2.5 0 0 0 4.96.44 2.5 2.5 0 0 0 2.96-3.08 3 3 0 0 0 .34-5.58 2.5 2.5 0 0 0-1.32-4.24 2.5 2.5 0 0 0-4.44-2.04z"/></svg>',
        'sparkles' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/><path d="M5 3v4"/><path d="M19 17v4"/><path d="M3 5h4"/><path d="M17 19h4"/></svg>',
        'cpu' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect width="16" height="16" x="4" y="4" rx="2"/><rect width="6" height="6" x="9" y="9" rx="1"/><path d="M15 2v2"/><path d="M15 20v2"/><path d="M2 15h2"/><path d="M2 9h2"/><path d="M20 15h2"/><path d="M20 9h2"/><path d="M9 2v2"/><path d="M9 20v2"/></svg>',
        'layout' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><line x1="3" x2="21" y1="9" y2="9"/><line x1="9" x2="9" y1="21" y2="9"/></svg>',
        'code' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>',
        'terminal' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="4 17 10 11 4 5"/><line x1="12" x2="20" y1="19" y2="19"/></svg>',
        'camera' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>',
        'award' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>',
        'users' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        'briefcase' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>',
        'folder-git-2' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"/><circle cx="12" cy="13" r="2"/><path d="M14 13h3"/><path d="M7 13h3"/></svg>',
        'linkedin' => '<svg class="' . $classes . '" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 8.76a1.64 1.64 0 1 0 0-3.28 1.64 1.64 0 0 0 0 3.28m1.4 9.74V9.93H5.06v8.57h2.8z"/></svg>',
        'github' => '<svg class="' . $classes . '" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0 1 12 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0 0 22 12.017C22 6.484 17.522 2 12 2z"/></svg>',
        'mail' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>',
        'message-circle' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>',
        'external-link' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>',
        'file-text' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>',
        'download' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>',
        'check-circle' => '<svg class="' . $classes . '" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>'
    ];

    return $icons[$name] ?? $icons['brain'];
}
