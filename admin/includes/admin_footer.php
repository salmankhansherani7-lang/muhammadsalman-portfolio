<?php
/**
 * Admin Panel Layout Footer
 * Muhammad Salman - AI Engineer Portfolio
 */

defined('SECURE_ACCESS') or die('Direct access forbidden.');
?>
    </div><!-- /.admin-content -->
  </div><!-- /.admin-main -->

  <script>
    // Auto-dismiss alert after 5s
    setTimeout(() => {
      const alert = document.querySelector('.admin-alert');
      if (alert) {
        alert.style.transition = 'opacity 0.4s ease';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 400);
      }
    }, 5000);
  </script>
</body>
</html>

