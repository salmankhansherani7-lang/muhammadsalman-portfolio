import sqlite3
import os

DB_PATH = r"a:\My Portfolio\database\portfolio.sqlite"

def update_db():
    conn = sqlite3.connect(DB_PATH)
    cur = conn.cursor()

    # 1. Update Profile
    cur.execute("""
        UPDATE profile SET
            full_name = 'Muhammad Salman',
            profession = 'AI Engineer • Prompt Programmer',
            headline_titles = 'AI Engineer | Prompt Programmer | Machine Learning | E-Commerce Data Analytics',
            short_bio = 'Motivated and customer-focused AI Engineer & Prompt Programmer pursuing a BS in Computer Science (BSCS). Experienced in AI systems, prompt programming, e-commerce dropshipping, customer support, and data tracking.',
            full_bio = 'Motivated and customer-focused professional, Intermediate (ICS) qualified and currently pursuing a BS in Computer Science (BSCS), with a strong foundation in Computer Science, Mathematics, and Physics. Brings two years of hands-on experience running an e-commerce dropshipping business, managing customer support, digital marketing campaigns, and supplier relationships. Holds Huawei certificates in AI, 5G and Cloud Computing and has completed an AI Advanced & Professional course at Corvit Institute of Information Technology. Analytical and detail-oriented, with solid skills in data tracking, reporting, and problem-solving, plus strong bilingual communication in English and Urdu.',
            avatar_url = 'assets/images/profile.jpg',
            location = 'Rawalpindi / Islamabad, Pakistan',
            academic_degree = 'BS in Computer Science (BSCS) • In Progress',
            direct_email = 'muhammadsalman@gmail.com',
            direct_phone = '0332-7768335',
            availability_status = 'Available for Opportunities • Rawalpindi / Islamabad (Remote Ready)',
            availability_badge = 'Open',
            cv_download_url = 'assets/docs/Muhammad_Salman_CV.pdf',
            updated_at = CURRENT_TIMESTAMP
        WHERE id = 1
    """)

    # 2. Update Experience
    cur.execute("DELETE FROM experience")
    cur.execute("""
        INSERT INTO experience (role_title, company_name, location, start_date, end_date, is_current, description, tech_stack, sort_order)
        VALUES (
            'E-Commerce Dropshipping Operator (Self-Employed)',
            'Online Retail Business',
            'Remote',
            '2024',
            'Present',
            1,
            '• Provided responsive, friendly customer support via chat and email, resolving order and product inquiries to maintain high customer satisfaction and encourage repeat business.
• Planned and ran social media marketing campaigns (Facebook & Instagram) to drive website traffic, generate leads, and increase online sales.
• Built and maintained strong relationships with suppliers and vendors, negotiating pricing and coordinating timely order fulfillment.
• Tracked sales, inventory levels, and campaign performance using Google Sheets and MS Excel, using the data to make informed business decisions.
• Handled day-to-day business operations independently, developing strong self-management, organization, and problem-solving skills.',
            'E-Commerce, Customer Support, Digital Marketing, Google Sheets, MS Excel, Supplier Relations',
            1
        )
    """)

    # 3. Update Education
    cur.execute("DELETE FROM education")
    cur.execute("""
        INSERT INTO education (degree_title, institution, location, start_year, end_year, grade_or_honors, description, sort_order)
        VALUES 
        (
            'Bachelor of Science in Computer Science (BSCS)',
            'University Level Higher Education',
            'Rawalpindi / Islamabad, Pakistan',
            'Status: Continuing',
            'In Progress',
            'Continuing / In Progress',
            'Pursuing BS in Computer Science with focus on Artificial Intelligence, Prompt Programming, Software Engineering, and Computing Systems.',
            1
        ),
        (
            'Intermediate in Computer Science (ICS)',
            'Board of Intermediate & Secondary Education',
            'Pakistan',
            'Completed',
            'ICS Qualified',
            'Concentration: Computer Science, Mathematics & Physics',
            'Strong foundation in Computer Science, Mathematics, and Physics with analytical and algorithmic problem-solving.',
            2
        )
    """)

    # 4. Update Certifications
    cur.execute("DELETE FROM certifications")
    cur.execute("""
        INSERT INTO certifications (title, issuer, issue_year, credential_id, credential_url, badge_color, sort_order)
        VALUES
        ('Overview of AI', 'Huawei ICT Academy', '2026', 'ICT20261121116239', 'assets/images/certificates/overview-of-ai.jpg', 'violet', 1),
        ('Search and AI', 'Huawei ICT Academy', '2026', 'ICT20261122000909', 'assets/images/certificates/search-and-ai.jpg', 'blue', 2),
        ('Development and Basic Concepts of Cloud Computing', 'Huawei ICT Academy', '2026', 'ICT20261122000289', 'assets/images/certificates/cloud-computing-concepts.jpg', 'cyan', 3),
        ('5G Network Architecture and Key Technologies', 'Huawei ICT Academy', '2026', 'ICT20261121000029', 'assets/images/certificates/5g-network-architecture.jpg', 'purple', 4),
        ('5G Basics: What It''s All About', 'Huawei ICT Academy', '2026', 'ICT20261121000162', 'assets/images/certificates/5g-basics.jpg', 'magenta', 5),
        ('AI Advanced & Professional Course', 'Corvit Institute of Information Technology', 'Certified', 'CORVIT-AI-ADV', '#', 'emerald', 6)
    """)

    # 5. Update Site Settings
    cur.execute("""
        UPDATE site_settings SET setting_value = 'Muhammad Salman | AI Engineer • Prompt Programmer' WHERE setting_key = 'site_name';
    """)
    cur.execute("""
        UPDATE site_settings SET setting_value = 'muhammadsalman@gmail.com' WHERE setting_key = 'admin_email';
    """)

    conn.commit()
    conn.close()
    print("Database updated successfully!")

if __name__ == '__main__':
    update_db()
