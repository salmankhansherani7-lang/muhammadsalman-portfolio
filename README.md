# Muhammad Salman — AI Engineer Portfolio & Private Admin Management System

A production-grade, high-performance personal portfolio website and private administration suite built for **Muhammad Salman**, AI Engineer.

---

## 🌟 Key Highlights & Architecture

- **Visual Aesthetics**: Deep navy (`#070a12`) & dark charcoal backgrounds, neon violet/purple/magenta gradients, frosted glassmorphism cards (`backdrop-filter: blur(16px)`), interactive neural network canvas background.
- **Strict Identity Integrity**:
  - Full Name: **Muhammad Salman**
  - Profession: **AI Engineer**
  - Profile Photograph: Uploaded portrait configured in hero and about cards.
  - Zero presence of external individual references.
  - Strictly no Kaggle references.
  - Realistic, verified data and editable placeholders.
- **Dedicated Curriculum Vitae (CV)**:
  - Follows executive two-column ATS-friendly layout.
  - **Stops strictly at Programming Languages** as requested (Personal Header, Professional Summary, Core Competencies, AI/ML/CV, GenAI/Agents, Robotics & IoT, Full-Stack Web, Programming Languages).
  - Standalone downloadable PDF (`assets/docs/Muhammad_Salman_CV.pdf`) generated via ReportLab.
  - Responsive web CV preview (`/cv.php`) with browser-native printing (`@media print`).
- **Complete Private Admin Suite (`/admin/`)**:
  - Hidden from public site: Zero public links, buttons, or hints.
  - Enterprise security: Session authentication, `session_regenerate_id(true)`, BCRYPT hashing (`password_hash`), CSRF tokens on all POST requests, login rate-limiting (max 5 attempts per 15 min), PDO prepared statements.
  - Full Dynamic CRUD: Profile, Hero Metrics, Skills, Portfolio Projects with Image Upload, Experience, Education, Certifications, Services, Contact Messages Inbox, Social Links, and Password Management.
- **Zero-Friction Dual Database Support**:
  - **SQLite (Default)**: Pre-configured and automatically provisioned on first run. Zero server setup required to test immediately.
  - **MySQL / MariaDB**: Fully supported via standard PDO in `includes/config.php` with provided `database/schema.sql`.

---

## 🚀 Quick Start & Local Testing

### Option 1: Built-in PHP Development Server (Instant)

1. Open PowerShell or Terminal in the project root:
   ```powershell
   cd "a:\My Portfolio"
   ```

2. Start the PHP server:
   ```powershell
   php -S localhost:8000
   ```

3. Open your browser:
   - **Public Portfolio**: `http://localhost:8000/`
   - **Curriculum Vitae**: `http://localhost:8000/cv.php`
   - **Private Admin Panel**: `http://localhost:8000/admin/login.php`

---

## 🔐 Default Admin Credentials

- **Admin URL**: `http://localhost:8000/admin/login.php`
- **Username**: `admin` (or `admin@muhammadsalman.ai`)
- **Password**: `Admin@12345`

> ⚠️ *Important: After your initial login, navigate to **Security & Password** in the sidebar to change your password.*

---

## 🗄️ MySQL / Production Hosting Setup (Optional)

If deploying to Apache / cPanel / VPS with MySQL:

1. Import `database/schema.sql` and `database/seed.sql` into your MySQL database using phpMyAdmin or CLI:
   ```bash
   mysql -u root -p salman_portfolio < database/schema.sql
   mysql -u root -p salman_portfolio < database/seed.sql
   ```

2. Update `includes/config.php`:
   ```php
   define('DB_DRIVER', 'mysql');
   define('DB_HOST', '127.0.0.1');
   define('DB_PORT', '3306');
   define('DB_NAME', 'salman_portfolio');
   define('DB_USER', 'your_db_username');
   define('DB_PASS', 'your_db_password');
   ```

---

## 📁 Project Directory Structure

```
My Portfolio/
├── .htaccess                   # Clean URL rewrites & security headers
├── index.php                   # Public frontend entry point (modular assembler)
├── cv.php                      # Dedicated CV preview entry point
├── compressed_photo.jpg        # Muhammad Salman's original photo
├── robots.txt                  # Search engine directive (blocks /admin/)
├── sitemap.xml                 # XML sitemap
├── includes/
│   ├── config.php              # App settings, environment, DB credentials
│   ├── database.php            # Unified PDO database handler (SQLite & MySQL)
│   ├── csrf.php                # CSRF token generation and validation
│   ├── auth.php                # Authentication, password verify, rate limiting
│   ├── functions.php           # Helper utilities, file uploads, SVG renderer
│   ├── header.php              # Public navigation header (no admin links)
│   └── footer.php              # Public footer & project detail modal
├── pages/
│   ├── home.php                # Hero section (glowing avatar, floating badges, stats)
│   ├── about.php               # About card (Screenshot 2 design)
│   ├── skills.php              # 6 categorized skill columns (Screenshot 3 design)
│   ├── portfolio.php           # Filterable gallery & modal trigger (Screenshot 5 design)
│   ├── experience.php          # Work experience & academic education timeline
│   ├── certifications.php      # Verified certifications grid
│   ├── services.php            # AI & engineering services offered
│   ├── contact.php             # Contact form with CSRF, validation & feedback
│   └── cv.php                  # ATS standard CV stopping at Programming Languages
├── admin/
│   ├── index.php               # Admin overview & system metrics
│   ├── login.php               # Secure login portal with brute-force protection
│   ├── logout.php              # Secure session termination
│   ├── profile.php             # Edit name, title, bio, contact details, photo upload
│   ├── skills.php              # Add, edit, delete skills & categories
│   ├── projects.php            # Add, edit, delete, publish projects & upload images
│   ├── experience.php          # Manage career & education records
│   ├── certifications.php      # Manage certifications & credentials
│   ├── services.php            # Manage services & deliverables
│   ├── messages.php            # Contact form inquiries inbox (read/unread/delete)
│   ├── settings.php            # Manage site settings, stats, hero tags, social links
│   ├── cv.php                  # CV content editor & automated PDF regenerator
│   ├── password.php            # Change admin password
│   └── includes/
│       ├── admin_header.php    # Admin layout header with auth check
│       ├── admin_sidebar.php   # Admin SaaS navigation sidebar
│       └── admin_footer.php    # Admin scripts & footer
├── assets/
│   ├── css/
│   │   ├── main.css            # Base styles, typography, reset, animations
│   │   ├── components.css      # Glassmorphism cards, buttons, badges, modals
│   │   ├── admin.css           # Premium SaaS dashboard styles
│   │   └── cv.css              # Executive CV styling & print stylesheet
│   ├── js/
│   │   ├── network.js          # Interactive neural network particle canvas
│   │   └── main.js             # Nav scrollspy, filter pills, modal, typing effect
│   ├── images/
│   │   ├── profile.jpg         # Profile photo of Muhammad Salman
│   │   ├── favicon.svg         # Modern glowing favicon
│   │   └── projects/           # High-resolution project mockup graphics
│   └── docs/
│       └── Muhammad_Salman_CV.pdf # Generated official executive PDF CV
├── database/
│   ├── schema.sql              # Clean SQL schema
│   ├── seed.sql                # Initial verified seed data
│   └── portfolio.sqlite        # Auto-initialized SQLite database
└── scripts/
    ├── generate_cv_pdf.py      # Python ReportLab CV PDF generator
    └── generate_svgs.py        # Project mockup SVG asset generator
```

---

## 🛡️ Security Features Implemented

1. **Password Hashing**: Strong bcrypt hashing (`PASSWORD_BCRYPT` with cost 12).
2. **Session Hardening**: `session_regenerate_id(true)` prevents session fixation; `httponly` & `samesite=Lax` cookies.
3. **Route Guards**: Every admin script enforces `require_admin_login()` on the server side.
4. **CSRF Protection**: Unique cryptographic tokens generated per session, validated on every POST request via `hash_equals()`.
5. **Rate Limiting**: Brute-force protection limits failed login attempts to 5 per IP address per 15 minutes.
6. **SQL Injection Defense**: 100% prepared PDO statements with parameter binding.
7. **Strict File Upload Validation**: Checks real MIME type via PHP `finfo`, enforces extension whitelists, randomizes stored file names, limits file size to 8MB.
8. **XSS Prevention**: Context-aware output escaping using `htmlspecialchars()` (`e()` helper function).
9. **Spam Defense**: Honeypot form trap field silently filters automated bot submissions.
10. **Zero Public Leakage**: The public site has no admin controls, login links, or cookies.

---

## ⚙️ Updating Content in the Future

All portfolio content is dynamically managed through the private admin panel at `/admin/login.php`:

- **Change Name or Profession**: Admin &rarr; Profile &rarr; Update Full Name / Profession &rarr; Save.
- **Upload New Profile Picture**: Admin &rarr; Profile &rarr; Choose Image &rarr; Save.
- **Add / Edit Portfolio Project**: Admin &rarr; Portfolio Projects &rarr; Add New Project &rarr; Upload Thumbnail &rarr; Save.
- **Add / Remove Skills**: Admin &rarr; Skills Dashboard &rarr; Add Skill &rarr; Save.
- **Change CV Details**: Admin &rarr; CV Management &rarr; Update Summary or Upload custom PDF.
- **Check Inquiries**: Admin &rarr; Inquiries &rarr; View messages sent by visitors.

