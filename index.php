<?php
/**
 * Main Website Entry Point
 * Muhammad Salman - AI Engineer Portfolio
 */

define('SECURE_ACCESS', true);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/database.php';
require_once __DIR__ . '/includes/csrf.php';
require_once __DIR__ . '/includes/functions.php';

// Handle Contact Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact'])) {
    // 1. Verify CSRF
    if (!verify_csrf_token()) {
        set_flash('error', 'Security token invalid or expired. Please refresh and try again.');
        header('Location: ' . BASE_URL . '/index.php#contact');
        exit;
    }

    // 2. Honeypot check for bots
    if (!empty($_POST['website_hp'])) {
        // Silently redirect bot
        header('Location: ' . BASE_URL . '/index.php#contact');
        exit;
    }

    // 3. Extract & Validate Inputs
    $name = clean_input($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = clean_input($_POST['subject'] ?? '');
    $message = clean_input($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        set_flash('error', 'Please complete all required fields.');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        set_flash('error', 'Please provide a valid email address.');
    } else {
        $ip = get_client_ip();
        $saved = save_contact_message($name, $email, $subject, $message, $ip);
        if ($saved) {
            set_flash('success', 'Thank you, ' . $name . '! Your message has been received successfully. I will respond to your inquiry promptly.');
        } else {
            set_flash('error', 'An unexpected error occurred while saving your message. Please reach out directly via email.');
        }
    }

    header('Location: ' . BASE_URL . '/index.php#contact');
    exit;
}

// Assemble Modular Page Components
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/pages/home.php';
require_once __DIR__ . '/pages/about.php';
require_once __DIR__ . '/pages/skills.php';
require_once __DIR__ . '/pages/portfolio.php';
require_once __DIR__ . '/pages/experience.php';
require_once __DIR__ . '/pages/certifications.php';
require_once __DIR__ . '/pages/services.php';
require_once __DIR__ . '/pages/contact.php';
require_once __DIR__ . '/includes/footer.php';

