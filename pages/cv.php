<?php
/**
 * Dedicated CV Preview Page
 * Muhammad Salman - AI Engineer • Prompt Programmer
 */

defined('SECURE_ACCESS') or die('Direct access forbidden.');

$pdfUrl = asset('assets/docs/Muhammad_Salman_CV.pdf');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Curriculum Vitae • M Salman | AI Engineer • Prompt Programmer</title>
  <meta name="description" content="Official Curriculum Vitae of M Salman, AI Engineer and Prompt Programmer.">

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="<?= asset('assets/images/favicon.svg') ?>">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="<?= asset('assets/css/main.css') ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/components.css') ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/cv.css') ?>">
</head>
<body>
  <div class="cv-page-wrapper">
    <!-- Top Action Bar -->
    <div class="cv-actions-bar">
      <a href="<?= BASE_URL ?>/#home" class="btn btn-secondary btn-sm">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Back to Portfolio</span>
      </a>

      <div style="display: flex; gap: 0.75rem;">
        <button onclick="window.print()" class="btn btn-secondary btn-sm">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <polyline points="6 9 6 2 18 2 18 9"></polyline>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
            <rect width="12" height="8" x="6" y="14"></rect>
          </svg>
          <span>Print CV</span>
        </button>

        <a href="<?= $pdfUrl ?>" download="Muhammad_Salman_CV.pdf" class="btn btn-primary btn-sm">
          <?= render_icon('download', 'w-4 h-4') ?>
          <span>Download Official PDF</span>
        </a>
      </div>
    </div>

    <!-- The Exact ATS CV Document -->
    <div class="cv-document">
      <!-- Header -->
      <div class="cv-header">
        <div>
          <h1 class="cv-header-name">M SALMAN</h1>
          <div class="cv-header-role">AI ENGINEER • PROMPT PROGRAMMER</div>
        </div>
        <div class="cv-header-meta">
          <div><strong>Rawalpindi / Islamabad, Pakistan</strong></div>
          <div>muhammadsalman@gmail.com</div>
        </div>
      </div>

      <!-- Contact Sub Bar -->
      <div class="cv-contact-bar">
        0332-7768335 &nbsp;•&nbsp; muhammadsalman@gmail.com
      </div>

      <!-- 1. Professional Summary -->
      <div class="cv-section">
        <h2 class="cv-section-title">PROFESSIONAL SUMMARY</h2>
        <p class="cv-summary-text">
          Motivated and customer-focused professional, Intermediate (ICS) qualified and currently pursuing a BS in Computer Science (BSCS), with a strong foundation in Computer Science, Mathematics, and Physics. Brings two years of hands-on experience running an e-commerce dropshipping business, managing customer support, digital marketing campaigns, and supplier relationships. Holds Huawei certificates in AI, 5G and Cloud Computing and has completed an AI Advanced & Professional course at Corvit Institute of Information Technology. Analytical and detail-oriented, with solid skills in data tracking, reporting, and problem-solving, plus strong bilingual communication in English and Urdu. Quick to learn new systems and eager to bring proven customer service and marketing skills to a call center and marketing development role.
        </p>
      </div>

      <!-- 2. Work Experience -->
      <div class="cv-section">
        <h2 class="cv-section-title">WORK EXPERIENCE</h2>
        <div style="font-weight: 700; font-size: 0.9rem; color: #0f172a; margin-bottom: 0.35rem;">
          E-Commerce Dropshipping Operator (Self-Employed) • Online Retail Business — Remote • 2 Years
        </div>
        <ul style="margin: 0; padding-left: 1.25rem; font-size: 0.85rem; color: #334155; line-height: 1.55;">
          <li style="margin-bottom: 0.25rem;">Provided responsive, friendly customer support via chat and email, resolving order and product inquiries to maintain high customer satisfaction and encourage repeat business.</li>
          <li style="margin-bottom: 0.25rem;">Planned and ran social media marketing campaigns (Facebook & Instagram) to drive website traffic, generate leads, and increase online sales.</li>
          <li style="margin-bottom: 0.25rem;">Built and maintained strong relationships with suppliers and vendors, negotiating pricing and coordinating timely order fulfillment.</li>
          <li style="margin-bottom: 0.25rem;">Tracked sales, inventory levels, and campaign performance using Google Sheets and MS Excel, using the data to make informed business decisions.</li>
          <li>Handled day-to-day business operations independently, developing strong self-management, organization, and problem-solving skills.</li>
        </ul>
      </div>

      <!-- 3. Education -->
      <div class="cv-section">
        <h2 class="cv-section-title">EDUCATION</h2>
        <div class="cv-competencies-grid">
          <div class="cv-comp-card">
            <div class="cv-comp-title" style="color: #2563eb;">Bachelor of Science in Computer Science (BSCS)</div>
            <div class="cv-comp-body">Status: Continuing / In Progress</div>
          </div>
          <div class="cv-comp-card">
            <div class="cv-comp-title" style="color: #2563eb;">Intermediate in Computer Science (ICS)</div>
            <div class="cv-comp-body">Concentration: Computer Science, Mathematics & Physics</div>
          </div>
        </div>
      </div>

      <!-- 4. Certifications & Courses -->
      <div class="cv-section">
        <h2 class="cv-section-title">CERTIFICATIONS & COURSES</h2>
        <div class="cv-competencies-grid">
          <div class="cv-comp-card">
            <div class="cv-comp-title" style="color: #0f172a;">Huawei Certificates</div>
            <div class="cv-comp-body">
              • 5G Basics: What It's All About<br>
              • Overview of AI<br>
              • 5G Network Architecture and Key Technologies<br>
              • Search and AI<br>
              • Development and Basic Concepts of Cloud Computing
            </div>
          </div>
          <div class="cv-comp-card">
            <div class="cv-comp-title" style="color: #0f172a;">Corvit Institute of Information Technology</div>
            <div class="cv-comp-body">
              • AI Advanced & Professional Course
            </div>
          </div>
        </div>
      </div>

      <!-- 5. Key Qualities -->
      <div class="cv-section">
        <h2 class="cv-section-title">KEY QUALITIES</h2>
        <div class="cv-competencies-grid">
          <div class="cv-comp-card">
            <div style="margin-bottom: 0.5rem;">
              <div class="cv-comp-title" style="color: #2563eb; margin-bottom: 0.15rem;">Strong Communicator</div>
              <div class="cv-comp-body">Clear, friendly, and patient when explaining things or resolving issues.</div>
            </div>
            <div style="margin-bottom: 0.5rem;">
              <div class="cv-comp-title" style="color: #2563eb; margin-bottom: 0.15rem;">Problem Solver</div>
              <div class="cv-comp-body">Stays calm under pressure and finds practical solutions quickly.</div>
            </div>
            <div>
              <div class="cv-comp-title" style="color: #2563eb; margin-bottom: 0.15rem;">Adaptable & Quick Learner</div>
              <div class="cv-comp-body">Comfortable picking up new tools, systems, and processes.</div>
            </div>
          </div>
          <div class="cv-comp-card">
            <div style="margin-bottom: 0.5rem;">
              <div class="cv-comp-title" style="color: #2563eb; margin-bottom: 0.15rem;">Team Player</div>
              <div class="cv-comp-body">Works well with suppliers, customers, and colleagues to get results.</div>
            </div>
            <div style="margin-bottom: 0.5rem;">
              <div class="cv-comp-title" style="color: #2563eb; margin-bottom: 0.15rem;">Self-Motivated</div>
              <div class="cv-comp-body">Managed a business independently with strong discipline and ownership.</div>
            </div>
            <div>
              <div class="cv-comp-title" style="color: #2563eb; margin-bottom: 0.15rem;">Detail-Oriented</div>
              <div class="cv-comp-body">Careful and accurate when tracking data, orders, and reports.</div>
            </div>
          </div>
        </div>
      </div>

      <!-- 6. Skills -->
      <div class="cv-section">
        <h2 class="cv-section-title">SKILLS</h2>
        <div class="cv-competencies-grid">
          <div class="cv-comp-card">
            <div style="margin-bottom: 0.5rem;">
              <div class="cv-comp-title" style="color: #2563eb; margin-bottom: 0.15rem;">MS Excel & MS Word</div>
              <div class="cv-comp-body">Preparing reports, tracking sheets, and business documents with strong formatting and formula skills.</div>
            </div>
            <div style="margin-bottom: 0.5rem;">
              <div class="cv-comp-title" style="color: #2563eb; margin-bottom: 0.15rem;">Customer Service & Support</div>
              <div class="cv-comp-body">Handling customer queries and complaints via chat/email with a friendly, solution-focused approach.</div>
            </div>
            <div>
              <div class="cv-comp-title" style="color: #2563eb; margin-bottom: 0.15rem;">Supplier & Vendor Coordination</div>
              <div class="cv-comp-body">Negotiating pricing and coordinating with suppliers to ensure timely, reliable order fulfillment.</div>
            </div>
          </div>
          <div class="cv-comp-card">
            <div style="margin-bottom: 0.5rem;">
              <div class="cv-comp-title" style="color: #2563eb; margin-bottom: 0.15rem;">Google Sheets & Data Tracking</div>
              <div class="cv-comp-body">Monitoring sales, inventory, and campaign performance to support day-to-day decisions.</div>
            </div>
            <div style="margin-bottom: 0.5rem;">
              <div class="cv-comp-title" style="color: #2563eb; margin-bottom: 0.15rem;">Social Media & Digital Marketing</div>
              <div class="cv-comp-body">Planning and running Facebook & Instagram campaigns to generate leads and drive online sales.</div>
            </div>
            <div>
              <div class="cv-comp-title" style="color: #2563eb; margin-bottom: 0.15rem;">Bilingual Communication</div>
              <div class="cv-comp-body">Fluent in English and Urdu, written and spoken, for clear customer and team communication.</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Document Footer -->
      <div class="cv-footer-notice">
        Curriculum Vitae • M Salman • AI Engineer • Prompt Programmer
      </div>
    </div>
  </div>
</body>
</html>
