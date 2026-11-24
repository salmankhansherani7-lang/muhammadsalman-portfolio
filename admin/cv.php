<?php
/**
 * CV Management Controller
 * Muhammad Salman - AI Engineer Portfolio
 */

define('SECURE_ACCESS', true);

$pageTitle = 'Curriculum Vitae Management';
require_once __DIR__ . '/includes/admin_header.php';

$cvData = get_cv_data();
$summaryData = $cvData['summary']['data'] ?? [];

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_or_die();
    $postAction = $_POST['post_action'] ?? '';

    // 1. Update CV Summary Text
    if ($postAction === 'update_cv_summary') {
        $newSummary = clean_input($_POST['summary_text'] ?? '');
        $json = json_encode(['text' => $newSummary], JSON_UNESCAPED_UNICODE);

        DB::execute(
            "UPDATE cv_sections SET content_json = :json WHERE section_key = 'summary'",
            ['json' => $json]
        );

        set_flash('success', 'CV professional summary updated.');
        header('Location: ' . BASE_URL . '/admin/cv.php');
        exit;
    }

    // 2. Upload and replace CV PDF
    if ($postAction === 'upload_cv_pdf') {
        if (!empty($_FILES['cv_pdf_file']['name'])) {
            $uploadRes = handle_file_upload(
                $_FILES['cv_pdf_file'],
                BASE_PATH . '/assets/docs',
                ['application/pdf']
            );

            if ($uploadRes['success']) {
                // Rename or point to Muhammad_Salman_CV.pdf
                $targetOfficial = BASE_PATH . '/assets/docs/Muhammad_Salman_CV.pdf';
                copy($uploadRes['fullpath'], $targetOfficial);

                DB::execute(
                    "UPDATE profile SET cv_download_url = 'assets/docs/Muhammad_Salman_CV.pdf' WHERE id = 1"
                );

                set_flash('success', 'Official CV PDF successfully replaced!');
            } else {
                set_flash('danger', 'PDF upload failed: ' . $uploadRes['error']);
            }
        } else {
            set_flash('danger', 'Please choose a valid PDF file.');
        }

        header('Location: ' . BASE_URL . '/admin/cv.php');
        exit;
    }

    // 3. Regenerate CV PDF using Python script
    if ($postAction === 'regenerate_cv') {
        $pyScript = BASE_PATH . '/scripts/generate_cv_pdf.py';
        $cmd = 'python "' . $pyScript . '" 2>&1';
        $output = shell_exec($cmd);

        set_flash('success', 'Official ATS CV PDF successfully regenerated using ReportLab engine.');
        header('Location: ' . BASE_URL . '/admin/cv.php');
        exit;
    }
}

$pdfPath = BASE_PATH . '/assets/docs/Muhammad_Salman_CV.pdf';
$pdfExists = file_exists($pdfPath);
$pdfSize = $pdfExists ? round(filesize($pdfPath) / 1024, 1) : 0;
$pdfTime = $pdfExists ? date('F j, Y, g:i a', filemtime($pdfPath)) : 'N/A';
?>

<!-- CV PDF File Management -->
<div class="admin-card">
  <div class="admin-card-header">
    <div>
      <h3 class="admin-card-title">Official Downloadable CV Document</h3>
      <span style="font-size: 0.8rem; color: var(--admin-text-dim);">Format: High-precision ATS Standard PDF</span>
    </div>

    <div style="display: flex; gap: 0.75rem;">
      <a href="<?= BASE_URL ?>/cv.php" target="_blank" class="btn-admin btn-admin-secondary" style="font-size: 0.8rem;">
        <?= render_icon('file-text', 'w-3.5 h-3.5') ?>
        <span>Preview Web CV</span>
      </a>

      <?php if ($pdfExists): ?>
        <a href="<?= asset('assets/docs/Muhammad_Salman_CV.pdf') ?>" target="_blank" class="btn-admin btn-admin-primary" style="font-size: 0.8rem;">
          <?= render_icon('download', 'w-3.5 h-3.5') ?>
          <span>Download Current PDF (<?= $pdfSize ?> KB)</span>
        </a>
      <?php endif; ?>
    </div>
  </div>

  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 1rem;">
    <!-- Upload Custom Replacement PDF -->
    <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--admin-border); border-radius: 10px; padding: 1.5rem;">
      <h4 style="font-size: 1rem; color: #ffffff; margin-bottom: 0.35rem;">Upload New Custom CV PDF</h4>
      <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.25rem;">
        Directly upload a prepared PDF document to replace the current downloadable file.
      </p>

      <form action="<?= BASE_URL ?>/admin/cv.php" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="post_action" value="upload_cv_pdf">

        <div class="admin-form-group">
          <input type="file" name="cv_pdf_file" accept="application/pdf" class="admin-input" required style="font-size: 0.85rem;">
        </div>

        <button type="submit" class="btn-admin btn-admin-secondary" style="margin-top: 0.5rem;">
          <?= render_icon('download', 'w-4 h-4') ?>
          <span>Upload & Replace PDF</span>
        </button>
      </form>
    </div>

    <!-- Regenerate with Automated ReportLab Engine -->
    <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--admin-border); border-radius: 10px; padding: 1.5rem;">
      <h4 style="font-size: 1rem; color: #ffffff; margin-bottom: 0.35rem;">Automated PDF Generator</h4>
      <p style="font-size: 0.85rem; color: var(--admin-text-muted); margin-bottom: 1.25rem;">
        Re-run the automated Python ReportLab generator to build an ATS-compliant 1-page PDF stopping strictly at Programming Languages.
      </p>

      <form action="<?= BASE_URL ?>/admin/cv.php" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="post_action" value="regenerate_cv">

        <div style="margin-bottom: 1.25rem; font-size: 0.8rem; color: var(--admin-text-dim);">
          <div>File Status: <strong><?= $pdfExists ? 'Generated' : 'Missing' ?></strong></div>
          <div>Last Modified: <strong><?= $pdfTime ?></strong></div>
        </div>

        <button type="submit" class="btn-admin btn-admin-primary">
          <?= render_icon('sparkles', 'w-4 h-4') ?>
          <span>Regenerate Official PDF</span>
        </button>
      </form>
    </div>
  </div>
</div>

<!-- Edit CV Summary -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title">CV Professional Summary</h3>
  </div>

  <form action="<?= BASE_URL ?>/admin/cv.php" method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="post_action" value="update_cv_summary">

    <div class="admin-form-group">
      <label for="summary_text" class="admin-label">Summary Paragraph *</label>
      <textarea id="summary_text" name="summary_text" class="admin-textarea" style="min-height: 140px;" required><?= e($summaryData['text'] ?? '') ?></textarea>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-top: 1rem;">
      <button type="submit" class="btn-admin btn-admin-primary">Save Summary</button>
    </div>
  </form>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

