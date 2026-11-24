import urllib.request
import re
import os

BASE_DIR = r"a:\My Portfolio"

def generate_static_pages():
    print("Fetching index from local PHP server...")
    req = urllib.request.Request("http://127.0.0.1:8080/", headers={"User-Agent": "StaticBuilder"})
    with urllib.request.urlopen(req) as resp:
        index_html = resp.read().decode("utf-8")

    print("Fetching cv from local PHP server...")
    req_cv = urllib.request.Request("http://127.0.0.1:8080/cv.php", headers={"User-Agent": "StaticBuilder"})
    with urllib.request.urlopen(req_cv) as resp:
        cv_html = resp.read().decode("utf-8")

    # Clean URLs for index.html
    # 1. CV links
    index_html = re.sub(r'https?://127\.0\.0\.1:8080/cv\.php', 'cv.html', index_html)
    index_html = re.sub(r'href="/cv\.php"', 'href="cv.html"', index_html)
    index_html = re.sub(r'href="cv\.php"', 'href="cv.html"', index_html)

    # 2. Localhost asset and anchor references
    index_html = re.sub(r'https?://127\.0\.0\.1:8080/index\.php#contact', '#contact', index_html)
    index_html = re.sub(r'https?://127\.0\.0\.1:8080/#home', '#home', index_html)
    index_html = re.sub(r'https?://127\.0\.0\.1:8080/', './', index_html)
    index_html = re.sub(r'https?://127\.0\.0\.1:8080', '.', index_html)

    # Add client-side static contact form handler script before </body> in index.html
    static_contact_script = """
  <script>
    // Static Fallback for Contact Form on GitHub Pages
    (function() {
      const contactForm = document.querySelector('.contact-form');
      if (contactForm && (window.location.hostname.includes('github.io') || window.location.protocol === 'file:')) {
        contactForm.addEventListener('submit', function(e) {
          e.preventDefault();
          const name = document.getElementById('contact-name')?.value || '';
          const email = document.getElementById('contact-email')?.value || '';
          const subject = document.getElementById('contact-subject')?.value || '';
          const message = document.getElementById('contact-message')?.value || '';
          
          const mailtoUri = `mailto:salmankhansherani7@gmail.com?subject=${encodeURIComponent('[Portfolio Inquiry] ' + subject)}&body=${encodeURIComponent('From: ' + name + ' (' + email + ')\\n\\n' + message)}`;
          
          alert('Thank you for reaching out, ' + name + '! Redirecting to your email client to send your message to Muhammad Salman.');
          window.location.href = mailtoUri;
        });
      }
    })();
  </script>
</body>"""
    index_html = index_html.replace('</body>', static_contact_script)

    # Clean URLs for cv.html
    cv_html = re.sub(r'https?://127\.0\.0\.1:8080/#home', './index.html#home', cv_html)
    cv_html = re.sub(r'https?://127\.0\.0\.1:8080/', './', cv_html)
    cv_html = re.sub(r'https?://127\.0\.0\.1:8080', '.', cv_html)

    # Write files
    index_path = os.path.join(BASE_DIR, "index.html")
    cv_path = os.path.join(BASE_DIR, "cv.html")
    nojekyll_path = os.path.join(BASE_DIR, ".nojekyll")

    with open(index_path, "w", encoding="utf-8") as f:
        f.write(index_html)
    print(f"Written: {index_path} ({len(index_html)} chars)")

    with open(cv_path, "w", encoding="utf-8") as f:
        f.write(cv_html)
    print(f"Written: {cv_path} ({len(cv_html)} chars)")

    with open(nojekyll_path, "w", encoding="utf-8") as f:
        f.write("")
    print(f"Written: {nojekyll_path}")

if __name__ == "__main__":
    generate_static_pages()

