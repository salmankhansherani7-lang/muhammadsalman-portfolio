-- ========================================================
-- Muhammad Salman - Premium AI Engineer Portfolio
-- Database Schema (Compatible with MySQL 8.0+ and SQLite 3)
-- ========================================================

-- 1. Admin Users Table
CREATE TABLE IF NOT EXISTS admin_users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(191) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(150) NOT NULL,
    avatar_url VARCHAR(255) DEFAULT 'assets/images/profile.jpg',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_login DATETIME NULL
);

-- 2. Profile Information Table
CREATE TABLE IF NOT EXISTS profile (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    full_name VARCHAR(150) NOT NULL,
    profession VARCHAR(150) NOT NULL,
    headline_titles TEXT NOT NULL,
    short_bio TEXT NOT NULL,
    full_bio TEXT NOT NULL,
    avatar_url VARCHAR(255) DEFAULT 'assets/images/profile.jpg',
    location VARCHAR(150) DEFAULT 'Islamabad & Rawalpindi, Pakistan',
    academic_degree VARCHAR(150) DEFAULT 'B.S. in Computer Science / Artificial Intelligence',
    direct_email VARCHAR(150) DEFAULT 'contact@muhammadsalman.ai',
    direct_phone VARCHAR(50) DEFAULT '+92 300 1234567',
    availability_status VARCHAR(100) DEFAULT 'Available for Opportunities',
    availability_badge VARCHAR(50) DEFAULT 'Open',
    cv_download_url VARCHAR(255) DEFAULT 'assets/docs/Muhammad_Salman_CV.pdf',
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 3. Hero Statistics Cards (Editable)
CREATE TABLE IF NOT EXISTS hero_stats (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    stat_number VARCHAR(50) NOT NULL,
    stat_label VARCHAR(100) NOT NULL,
    icon_name VARCHAR(50) DEFAULT 'code',
    sort_order INTEGER DEFAULT 0,
    is_active INTEGER DEFAULT 1
);

-- 4. Hero Orbiting Tech Floating Badges
CREATE TABLE IF NOT EXISTS hero_tags (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    tag_label VARCHAR(100) NOT NULL,
    tag_category VARCHAR(100) NOT NULL,
    color_class VARCHAR(50) DEFAULT 'cyan',
    position_class VARCHAR(50) DEFAULT 'top-right',
    sort_order INTEGER DEFAULT 0,
    is_active INTEGER DEFAULT 1
);

-- 5. Skill Categories
CREATE TABLE IF NOT EXISTS skill_categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(150) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    badge_text VARCHAR(50) DEFAULT '6 Techs',
    status_text VARCHAR(100) DEFAULT 'Production Ready',
    icon_name VARCHAR(50) DEFAULT 'brain',
    sort_order INTEGER DEFAULT 0,
    is_active INTEGER DEFAULT 1
);

-- 6. Individual Skills
CREATE TABLE IF NOT EXISTS skills (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    category_id INTEGER NOT NULL,
    name VARCHAR(150) NOT NULL,
    description VARCHAR(255) DEFAULT '',
    proficiency_label VARCHAR(50) DEFAULT 'Expert',
    proficiency_level INTEGER DEFAULT 90,
    sort_order INTEGER DEFAULT 0,
    is_active INTEGER DEFAULT 1,
    FOREIGN KEY (category_id) REFERENCES skill_categories(id) ON DELETE CASCADE
);

-- 7. Portfolio Projects
CREATE TABLE IF NOT EXISTS projects (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    short_desc TEXT NOT NULL,
    full_desc TEXT NOT NULL,
    category VARCHAR(100) NOT NULL,
    thumbnail_url VARCHAR(255) NOT NULL,
    tech_stack VARCHAR(255) NOT NULL,
    live_demo_url VARCHAR(255) DEFAULT '',
    github_url VARCHAR(255) DEFAULT '',
    domain_label VARCHAR(100) DEFAULT 'AI & Machine Learning',
    badge_text VARCHAR(50) DEFAULT 'PRODUCTION',
    is_featured INTEGER DEFAULT 1,
    is_published INTEGER DEFAULT 1,
    sort_order INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 8. Experience Timeline
CREATE TABLE IF NOT EXISTS experience (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    role_title VARCHAR(150) NOT NULL,
    company_name VARCHAR(150) NOT NULL,
    location VARCHAR(150) DEFAULT 'Pakistan',
    start_date VARCHAR(50) NOT NULL,
    end_date VARCHAR(50) DEFAULT 'Present',
    is_current INTEGER DEFAULT 1,
    description TEXT NOT NULL,
    tech_stack VARCHAR(255) DEFAULT '',
    sort_order INTEGER DEFAULT 0,
    is_active INTEGER DEFAULT 1
);

-- 9. Education
CREATE TABLE IF NOT EXISTS education (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    degree_title VARCHAR(150) NOT NULL,
    institution VARCHAR(191) NOT NULL,
    location VARCHAR(150) DEFAULT 'Pakistan',
    start_year VARCHAR(50) NOT NULL,
    end_year VARCHAR(50) NOT NULL,
    grade_or_honors VARCHAR(100) DEFAULT '',
    description TEXT DEFAULT '',
    sort_order INTEGER DEFAULT 0,
    is_active INTEGER DEFAULT 1
);

-- 10. Professional Certifications
CREATE TABLE IF NOT EXISTS certifications (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(200) NOT NULL,
    issuer VARCHAR(150) NOT NULL,
    issue_year VARCHAR(50) NOT NULL,
    credential_id VARCHAR(150) DEFAULT '',
    credential_url VARCHAR(255) DEFAULT '',
    badge_color VARCHAR(50) DEFAULT 'violet',
    sort_order INTEGER DEFAULT 0,
    is_active INTEGER DEFAULT 1
);

-- 11. Services Offered
CREATE TABLE IF NOT EXISTS services (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(150) NOT NULL,
    short_desc TEXT NOT NULL,
    detailed_desc TEXT DEFAULT '',
    icon_name VARCHAR(50) DEFAULT 'cpu',
    deliverables TEXT DEFAULT '',
    sort_order INTEGER DEFAULT 0,
    is_active INTEGER DEFAULT 1
);

-- 12. Social Media Links (STRICTLY NO KAGGLE)
CREATE TABLE IF NOT EXISTS social_links (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    platform_name VARCHAR(50) NOT NULL,
    platform_icon VARCHAR(50) NOT NULL,
    url VARCHAR(255) NOT NULL,
    sort_order INTEGER DEFAULT 0,
    is_active INTEGER DEFAULT 1
);

-- 13. Contact Inquiries Messages
CREATE TABLE IF NOT EXISTS contact_messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(191) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    ip_address VARCHAR(50) DEFAULT '',
    is_read INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 14. CV Modular Content
CREATE TABLE IF NOT EXISTS cv_sections (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    section_key VARCHAR(100) NOT NULL UNIQUE,
    section_title VARCHAR(150) NOT NULL,
    content_json TEXT NOT NULL,
    sort_order INTEGER DEFAULT 0
);

-- 15. General Website Settings
CREATE TABLE IF NOT EXISTS site_settings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT NOT NULL,
    setting_group VARCHAR(50) DEFAULT 'general',
    description VARCHAR(255) DEFAULT ''
);

-- 16. Login Security & Rate Limiting
CREATE TABLE IF NOT EXISTS login_attempts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ip_address VARCHAR(50) NOT NULL,
    attempt_time DATETIME DEFAULT CURRENT_TIMESTAMP
);

