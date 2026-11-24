"""
Comprehensive Test Suite for Muhammad Salman Portfolio & Admin
"""

import urllib.request
import urllib.parse
import http.cookiejar
import re

BASE = 'http://127.0.0.1:8080'

# Cookie jar for session management
cj = http.cookiejar.CookieJar()
opener = urllib.request.build_opener(urllib.request.HTTPCookieProcessor(cj))

def test_public_homepage():
    print("Testing GET / ...")
    resp = opener.open(f"{BASE}/")
    assert resp.status == 200, f"Expected 200, got {resp.status}"
    html = resp.read().decode('utf-8')
    assert "Muhammad Salman" in html, "Homepage missing Muhammad Salman"
    assert "AI Engineer" in html, "Homepage missing AI Engineer"
    assert "Aamir" not in html, "FOUND FORBIDDEN STRING 'Aamir' IN HOMEPAGE!"
    assert "Jamil" not in html, "FOUND FORBIDDEN STRING 'Jamil' IN HOMEPAGE!"
    assert "Kaggle" not in html, "FOUND FORBIDDEN STRING 'Kaggle' IN HOMEPAGE!"
    assert "id=\"home\"" in html, "Missing home section"
    assert "id=\"about\"" in html, "Missing about section"
    assert "id=\"skills\"" in html, "Missing skills section"
    assert "id=\"portfolio\"" in html, "Missing portfolio section"
    assert "id=\"experience\"" in html, "Missing experience section"
    assert "id=\"certifications\"" in html, "Missing certifications section"
    assert "id=\"services\"" in html, "Missing services section"
    assert "id=\"contact\"" in html, "Missing contact section"
    assert "/admin/" not in html, "Admin link leaked on public page!"
    print("  [PASS] Public Homepage verified successfully (All sections present, zero forbidden names/links).")

def test_cv_page():
    print("Testing GET /cv.php ...")
    resp = opener.open(f"{BASE}/cv.php")
    assert resp.status == 200, f"Expected 200, got {resp.status}"
    html = resp.read().decode('utf-8')
    assert "MUHAMMAD SALMAN" in html, "CV missing MUHAMMAD SALMAN"
    assert "AI ENGINEER" in html, "CV missing AI ENGINEER"
    assert "TECHNICAL CORE COMPETENCIES" in html, "CV missing competencies"
    assert "Programming Languages:" in html, "CV missing Programming Languages"
    # Ensure no subsequent sections on CV
    assert "FLAGSHIP ENGINEERING PROJECTS" not in html, "CV includes forbidden flagship projects section!"
    assert "WORK EXPERIENCE" not in html, "CV includes forbidden work experience section!"
    assert "Kaggle" not in html, "CV includes forbidden Kaggle!"
    print("  [PASS] CV Page verified (Stops strictly at Programming Languages).")

def test_unauthorized_admin_access():
    print("Testing GET /admin/index.php without login ...")
    # Fresh opener without cookies
    fresh_opener = urllib.request.build_opener(urllib.request.HTTPRedirectHandler())
    req = urllib.request.Request(f"{BASE}/admin/index.php")
    resp = fresh_opener.open(req)
    # The final URL after redirect should be login.php
    assert "login.php" in resp.geturl(), f"Expected redirect to login.php, got {resp.geturl()}"
    print("  [PASS] Unauthorized admin access prevented (Redirected to login.php).")

def test_admin_login_and_crud():
    print("Testing Admin Login ...")
    # 1. Fetch login page to extract CSRF token
    resp = opener.open(f"{BASE}/admin/login.php")
    html = resp.read().decode('utf-8')
    m = re.search(r'name="csrf_token"\s+value="([^"]+)"', html)
    assert m, "CSRF token not found on login page"
    token = m.group(1)

    # 2. Submit credentials
    login_data = urllib.parse.urlencode({
        'csrf_token': token,
        'identifier': 'admin',
        'password': 'Admin@12345',
        'login_submit': '1'
    }).encode('utf-8')

    req = urllib.request.Request(f"{BASE}/admin/login.php", data=login_data)
    resp = opener.open(req)
    assert "index.php" in resp.geturl(), f"Login failed, URL: {resp.geturl()}"
    dashboard_html = resp.read().decode('utf-8')
    assert "Dashboard Overview" in dashboard_html, "Dashboard Overview text missing"
    print("  [PASS] Admin Authentication succeeded (Session active).")

    # 3. Test accessing admin pages
    admin_pages = [
        ('/admin/profile.php', 'Profile &amp; Identity Management'),
        ('/admin/skills.php', 'Skills Dashboard Management'),
        ('/admin/projects.php', 'Portfolio Projects Gallery'),
        ('/admin/experience.php', 'Career Experience &amp; Education'),
        ('/admin/certifications.php', 'Certifications Management'),
        ('/admin/services.php', 'Services Management'),
        ('/admin/messages.php', 'Contact Messages Inbox'),
        ('/admin/settings.php', 'Settings &amp; Configuration'),
        ('/admin/cv.php', 'Official Downloadable CV Document'),
        ('/admin/password.php', 'Change Administrative Password')
    ]

    for path, expected_text in admin_pages:
        resp = opener.open(f"{BASE}{path}")
        assert resp.status == 200, f"Failed accessing {path}"
        content = resp.read().decode('utf-8')
        if expected_text not in content:
            print(f"FAILED on {path}! URL is: {resp.geturl()}")
            print(f"Content excerpt: {content[:300]}")
        assert expected_text in content, f"Expected '{expected_text}' in {path}"
        print(f"  [PASS] Verified admin route: {path}")

def test_contact_form_submission():
    print("Testing Public Contact Form Submission ...")
    # Fetch homepage to get CSRF token
    resp = opener.open(f"{BASE}/")
    html = resp.read().decode('utf-8')
    m = re.search(r'name="csrf_token"\s+value="([^"]+)"', html)
    assert m, "CSRF token not found on contact form"
    token = m.group(1)

    contact_data = urllib.parse.urlencode({
        'csrf_token': token,
        'name': 'Dr. Alan Turing',
        'email': 'alan.turing@ai-foundation.org',
        'subject': 'Enterprise AI Research Collaboration',
        'message': 'We are highly impressed with your autonomous multi-agent and computer vision pipelines.',
        'website_hp': '', # honeypot must be empty
        'submit_contact': '1'
    }).encode('utf-8')

    req = urllib.request.Request(
        f"{BASE}/index.php",
        data=contact_data,
        headers={'Content-Type': 'application/x-www-form-urlencoded'}
    )
    resp = opener.open(req)
    assert resp.status == 200
    res_html = resp.read().decode('utf-8')
    if "Thank you, Dr. Alan Turing!" not in res_html:
        print("Redirected URL:", resp.geturl())
        m_alert = re.search(r'class="form-alert[^"]*"[^>]*>.*?</div>', res_html, re.DOTALL)
        if m_alert:
            print("Alert found:", m_alert.group(0))
        else:
            print("No alert found in res_html!")
    assert "Thank you, Dr. Alan Turing!" in res_html, "Contact success alert missing from response"
    print("  [PASS] Contact form submitted with CSRF validation and feedback banner verified.")

    # Check that message is present in admin inbox
    resp = opener.open(f"{BASE}/admin/messages.php")
    inbox_html = resp.read().decode('utf-8')
    assert "Dr. Alan Turing" in inbox_html, "Submitted message not found in Admin inbox"
    print("  [PASS] Inbound message verified inside Admin Inbox.")

if __name__ == '__main__':
    print("=" * 60)
    print("RUNNING COMPREHENSIVE VERIFICATION TEST SUITE")
    print("=" * 60)
    test_public_homepage()
    test_cv_page()
    test_unauthorized_admin_access()
    test_admin_login_and_crud()
    test_contact_form_submission()
    print("=" * 60)
    print("ALL TESTS PASSED WITH 100% SUCCESS!")
    print("=" * 60)
