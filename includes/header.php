<?php
/**
 * Public Website Header
 * Muhammad Salman - AI Engineer Portfolio
 */

defined('SECURE_ACCESS') or die('Direct access forbidden.');

$profile = get_profile();
$siteTitle = get_setting('site_name', 'Muhammad Salman | AI Engineer');
$metaDesc = get_setting('meta_description', 'Official portfolio of Muhammad Salman, AI Engineer specializing in Machine Learning, Generative AI Agents, Computer Vision, and Embedded IoT.');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($siteTitle) ?></title>
  <meta name="description" content="<?= e($metaDesc) ?>">
  <meta name="author" content="Muhammad Salman">
  <meta name="robots" content="index, follow">

  <!-- Open Graph / Social Media -->
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?= e($siteTitle) ?>">
  <meta property="og:description" content="<?= e($metaDesc) ?>">
  <meta property="og:image" content="<?= asset($profile['avatar_url']) ?>">
  <meta property="og:url" content="<?= BASE_URL ?>">

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="<?= asset('assets/images/favicon.svg') ?>">

  <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="<?= asset('assets/css/main.css') ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/components.css') ?>">
</head>
<body>

  <!-- Background Interactive Neural Network Canvas -->
  <canvas id="network-canvas"></canvas>

  <div class="main-wrapper">
    <!-- Top Navigation Bar (Strictly NO admin links) -->
    <header class="site-header">
      <div class="container nav-container">
        <a href="<?= BASE_URL ?>/#home" class="nav-brand">
          <img src="<?= asset($profile['avatar_url']) ?>" alt="<?= e($profile['full_name']) ?>" class="brand-avatar">
          <div class="brand-text">
            <span class="brand-name"><?= e($profile['full_name']) ?></span>
            <span class="brand-role"><?= e($profile['profession']) ?></span>
          </div>
        </a>

        <!-- Desktop Navigation -->
        <nav>
          <ul class="nav-menu">
            <li><a href="#home" class="nav-link active">Home</a></li>
            <li><a href="#about" class="nav-link">About</a></li>
            <li><a href="#skills" class="nav-link">Skills</a></li>
            <li><a href="#portfolio" class="nav-link">Portfolio</a></li>
            <li><a href="#experience" class="nav-link">Experience</a></li>
            <li><a href="#certifications" class="nav-link">Certifications</a></li>
            <li><a href="#services" class="nav-link">Services</a></li>
            <li><a href="#contact" class="nav-link">Contact</a></li>
          </ul>
        </nav>

        <!-- Right Action: CV Button -->
        <div class="nav-actions">
          <a href="<?= BASE_URL ?>/cv.php" class="nav-cv-btn">
            <?= render_icon('file-text', 'w-4 h-4') ?>
            <span>CV</span>
          </a>
          <button class="nav-toggle" aria-label="Toggle navigation">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
        </div>
      </div>
    </header>

