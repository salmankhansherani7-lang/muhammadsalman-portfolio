"""
Muhammad Salman - Executive Curriculum Vitae (CV) Generator
Generates an ATS-compliant, ultra-clean executive 1-page PDF
matching the exact design, typography, and sections uploaded by the user.
"""

import os
from reportlab.lib.pagesizes import letter
from reportlab.lib import colors
from reportlab.platypus import (
    SimpleDocTemplate, Paragraph, Spacer, Table, TableStyle, HRFlowable
)
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.lib.units import inch

def generate_pdf(output_path):
    os.makedirs(os.path.dirname(output_path), exist_ok=True)
    # Target exact 1 page with tight, clean margins
    doc = SimpleDocTemplate(
        output_path,
        pagesize=letter,
        leftMargin=36,
        rightMargin=36,
        topMargin=28,
        bottomMargin=24
    )

    styles = getSampleStyleSheet()

    # Custom styles
    header_name = ParagraphStyle(
        'HeaderName',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=20,
        leading=22,
        textColor=colors.HexColor('#0f172a')
    )

    header_role = ParagraphStyle(
        'HeaderRole',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=9.5,
        leading=13,
        textColor=colors.HexColor('#3b82f6')
    )

    header_right = ParagraphStyle(
        'HeaderRight',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=8.5,
        leading=12,
        alignment=2, # Right align
        textColor=colors.HexColor('#1e293b')
    )

    contact_sub = ParagraphStyle(
        'ContactSub',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=8,
        leading=10,
        alignment=1, # Center
        textColor=colors.HexColor('#334155')
    )

    section_heading = ParagraphStyle(
        'SectionHeading',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=9,
        leading=11,
        textColor=colors.HexColor('#0f172a'),
        spaceAfter=2
    )

    summary_text = ParagraphStyle(
        'SummaryText',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=7.2,
        leading=9.8,
        textColor=colors.HexColor('#334155'),
        alignment=4 # Justify
    )

    exp_title = ParagraphStyle(
        'ExpTitle',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=8,
        leading=10.5,
        textColor=colors.HexColor('#0f172a')
    )

    bullet_text = ParagraphStyle(
        'BulletText',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=7.2,
        leading=9.5,
        textColor=colors.HexColor('#334155'),
        leftIndent=10
    )

    card_title = ParagraphStyle(
        'CardTitle',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=7.8,
        leading=10,
        textColor=colors.HexColor('#2563eb')
    )

    card_body = ParagraphStyle(
        'CardBody',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=7,
        leading=9.2,
        textColor=colors.HexColor('#334155')
    )

    footer_text = ParagraphStyle(
        'FooterText',
        parent=styles['Normal'],
        fontName='Helvetica-Oblique',
        fontSize=7,
        leading=9,
        alignment=1,
        textColor=colors.HexColor('#64748b')
    )

    story = []

    # 1. Header (Name/Role on Left, Location/Email on Right)
    left_header = [
        Paragraph("M SALMAN", header_name),
        Paragraph("AI ENGINEER • PROMPT PROGRAMMER", header_role)
    ]
    right_header = [
        Paragraph("<b>Rawalpindi / Islamabad, Pakistan</b>", header_right),
        Paragraph("muhammadsalman@gmail.com", header_right)
    ]
    header_table = Table([[left_header, right_header]], colWidths=[320, 220])
    header_table.setStyle(TableStyle([
        ('VALIGN', (0, 0), (-1, -1), 'TOP'),
        ('BOTTOMPADDING', (0, 0), (-1, -1), 0),
        ('TOPPADDING', (0, 0), (-1, -1), 0),
        ('LEFTPADDING', (0, 0), (-1, -1), 0),
        ('RIGHTPADDING', (0, 0), (-1, -1), 0),
    ]))
    story.append(header_table)
    story.append(Spacer(1, 4))

    # Contact line
    story.append(Paragraph("0332-7768335 &nbsp;•&nbsp; muhammadsalman@gmail.com", contact_sub))
    story.append(Spacer(1, 4))
    story.append(HRFlowable(width="100%", thickness=0.75, color=colors.HexColor('#0f172a'), spaceAfter=5))

    # 2. Professional Summary
    story.append(Paragraph("PROFESSIONAL SUMMARY", section_heading))
    summary_content = (
        "Motivated and customer-focused professional, Intermediate (ICS) qualified and currently pursuing a "
        "BS in Computer Science (BSCS), with a strong foundation in Computer Science, Mathematics, and Physics. "
        "Brings two years of hands-on experience running an e-commerce dropshipping business, managing customer support, "
        "digital marketing campaigns, and supplier relationships. Holds Huawei certificates in AI, 5G and Cloud Computing "
        "and has completed an AI Advanced & Professional course at Corvit Institute of Information Technology. "
        "Analytical and detail-oriented, with solid skills in data tracking, reporting, and problem-solving, plus strong "
        "bilingual communication in English and Urdu. Quick to learn new systems and eager to bring proven customer service "
        "and marketing skills to a call center and marketing development role."
    )
    story.append(Paragraph(summary_content, summary_text))
    story.append(Spacer(1, 5))
    story.append(HRFlowable(width="100%", thickness=0.5, color=colors.HexColor('#cbd5e1'), spaceAfter=4))

    # 3. Work Experience
    story.append(Paragraph("WORK EXPERIENCE", section_heading))
    story.append(Paragraph("<b>E-Commerce Dropshipping Operator (Self-Employed)</b> • Online Retail Business — Remote • <b>2 Years</b>", exp_title))
    story.append(Spacer(1, 2))
    bullets = [
        "• Provided responsive, friendly customer support via chat and email, resolving order and product inquiries to maintain high customer satisfaction and encourage repeat business.",
        "• Planned and ran social media marketing campaigns (Facebook & Instagram) to drive website traffic, generate leads, and increase online sales.",
        "• Built and maintained strong relationships with suppliers and vendors, negotiating pricing and coordinating timely order fulfillment.",
        "• Tracked sales, inventory levels, and campaign performance using Google Sheets and MS Excel, using the data to make informed business decisions.",
        "• Handled day-to-day business operations independently, developing strong self-management, organization, and problem-solving skills."
    ]
    for b in bullets:
        story.append(Paragraph(b, bullet_text))
        story.append(Spacer(1, 1.5))
    story.append(Spacer(1, 3))
    story.append(HRFlowable(width="100%", thickness=0.5, color=colors.HexColor('#cbd5e1'), spaceAfter=4))

    # 4. Education
    story.append(Paragraph("EDUCATION", section_heading))
    edu_left = [
        Paragraph("<b>Bachelor of Science in Computer Science (BSCS)</b>", card_title),
        Paragraph("Status: Continuing / In Progress", card_body)
    ]
    edu_right = [
        Paragraph("<b>Intermediate in Computer Science (ICS)</b>", card_title),
        Paragraph("Concentration: Computer Science, Mathematics & Physics", card_body)
    ]
    edu_table = Table([[edu_left, edu_right]], colWidths=[270, 270])
    edu_table.setStyle(TableStyle([
        ('BOX', (0, 0), (-1, -1), 0.5, colors.HexColor('#e2e8f0')),
        ('BACKGROUND', (0, 0), (-1, -1), colors.HexColor('#f8fafc')),
        ('INNERGRID', (0, 0), (-1, -1), 0.5, colors.HexColor('#e2e8f0')),
        ('TOPPADDING', (0, 0), (-1, -1), 3),
        ('BOTTOMPADDING', (0, 0), (-1, -1), 3),
        ('LEFTPADDING', (0, 0), (-1, -1), 6),
        ('RIGHTPADDING', (0, 0), (-1, -1), 6),
        ('VALIGN', (0, 0), (-1, -1), 'TOP'),
    ]))
    story.append(edu_table)
    story.append(Spacer(1, 4))
    story.append(HRFlowable(width="100%", thickness=0.5, color=colors.HexColor('#cbd5e1'), spaceAfter=4))

    # 5. Certifications & Courses
    story.append(Paragraph("CERTIFICATIONS & COURSES", section_heading))
    cert_left = [
        Paragraph("<b>Huawei Certificates</b>", ParagraphStyle('SubT', parent=card_title, textColor=colors.HexColor('#1e293b'))),
        Paragraph("• 5G Basics: What It's All About<br/>• Overview of AI<br/>• 5G Network Architecture and Key Technologies<br/>• Search and AI<br/>• Development and Basic Concepts of Cloud Computing", card_body)
    ]
    cert_right = [
        Paragraph("<b>Corvit Institute of Information Technology</b>", ParagraphStyle('SubT2', parent=card_title, textColor=colors.HexColor('#1e293b'))),
        Paragraph("• AI Advanced & Professional Course", card_body)
    ]
    cert_table = Table([[cert_left, cert_right]], colWidths=[270, 270])
    cert_table.setStyle(TableStyle([
        ('BOX', (0, 0), (-1, -1), 0.5, colors.HexColor('#e2e8f0')),
        ('BACKGROUND', (0, 0), (-1, -1), colors.HexColor('#f8fafc')),
        ('INNERGRID', (0, 0), (-1, -1), 0.5, colors.HexColor('#e2e8f0')),
        ('TOPPADDING', (0, 0), (-1, -1), 3),
        ('BOTTOMPADDING', (0, 0), (-1, -1), 3),
        ('LEFTPADDING', (0, 0), (-1, -1), 6),
        ('RIGHTPADDING', (0, 0), (-1, -1), 6),
        ('VALIGN', (0, 0), (-1, -1), 'TOP'),
    ]))
    story.append(cert_table)
    story.append(Spacer(1, 4))
    story.append(HRFlowable(width="100%", thickness=0.5, color=colors.HexColor('#cbd5e1'), spaceAfter=4))

    # 6. Key Qualities
    story.append(Paragraph("KEY QUALITIES", section_heading))
    qual_left = [
        Paragraph("<b>Strong Communicator</b>", card_title),
        Paragraph("Clear, friendly, and patient when explaining things or resolving issues.", card_body),
        Spacer(1, 2),
        Paragraph("<b>Problem Solver</b>", card_title),
        Paragraph("Stays calm under pressure and finds practical solutions quickly.", card_body),
        Spacer(1, 2),
        Paragraph("<b>Adaptable & Quick Learner</b>", card_title),
        Paragraph("Comfortable picking up new tools, systems, and processes.", card_body)
    ]
    qual_right = [
        Paragraph("<b>Team Player</b>", card_title),
        Paragraph("Works well with suppliers, customers, and colleagues to get results.", card_body),
        Spacer(1, 2),
        Paragraph("<b>Self-Motivated</b>", card_title),
        Paragraph("Managed a business independently with strong discipline and ownership.", card_body),
        Spacer(1, 2),
        Paragraph("<b>Detail-Oriented</b>", card_title),
        Paragraph("Careful and accurate when tracking data, orders, and reports.", card_body)
    ]
    qual_table = Table([[qual_left, qual_right]], colWidths=[270, 270])
    qual_table.setStyle(TableStyle([
        ('BOX', (0, 0), (-1, -1), 0.5, colors.HexColor('#e2e8f0')),
        ('BACKGROUND', (0, 0), (-1, -1), colors.HexColor('#f8fafc')),
        ('INNERGRID', (0, 0), (-1, -1), 0.5, colors.HexColor('#e2e8f0')),
        ('TOPPADDING', (0, 0), (-1, -1), 3),
        ('BOTTOMPADDING', (0, 0), (-1, -1), 3),
        ('LEFTPADDING', (0, 0), (-1, -1), 6),
        ('RIGHTPADDING', (0, 0), (-1, -1), 6),
        ('VALIGN', (0, 0), (-1, -1), 'TOP'),
    ]))
    story.append(qual_table)
    story.append(Spacer(1, 4))
    story.append(HRFlowable(width="100%", thickness=0.5, color=colors.HexColor('#cbd5e1'), spaceAfter=4))

    # 7. Skills
    story.append(Paragraph("SKILLS", section_heading))
    skills_left = [
        Paragraph("<b>MS Excel & MS Word</b>", card_title),
        Paragraph("Preparing reports, tracking sheets, and business documents with strong formatting and formula skills.", card_body),
        Spacer(1, 2),
        Paragraph("<b>Customer Service & Support</b>", card_title),
        Paragraph("Handling customer queries and complaints via chat/email with a friendly, solution-focused approach.", card_body),
        Spacer(1, 2),
        Paragraph("<b>Supplier & Vendor Coordination</b>", card_title),
        Paragraph("Negotiating pricing and coordinating with suppliers to ensure timely, reliable order fulfillment.", card_body)
    ]
    skills_right = [
        Paragraph("<b>Google Sheets & Data Tracking</b>", card_title),
        Paragraph("Monitoring sales, inventory, and campaign performance to support day-to-day decisions.", card_body),
        Spacer(1, 2),
        Paragraph("<b>Social Media & Digital Marketing</b>", card_title),
        Paragraph("Planning and running Facebook & Instagram campaigns to generate leads and drive online sales.", card_body),
        Spacer(1, 2),
        Paragraph("<b>Bilingual Communication</b>", card_title),
        Paragraph("Fluent in English and Urdu, written and spoken, for clear customer and team communication.", card_body)
    ]
    skills_table = Table([[skills_left, skills_right]], colWidths=[270, 270])
    skills_table.setStyle(TableStyle([
        ('BOX', (0, 0), (-1, -1), 0.5, colors.HexColor('#e2e8f0')),
        ('BACKGROUND', (0, 0), (-1, -1), colors.HexColor('#f8fafc')),
        ('INNERGRID', (0, 0), (-1, -1), 0.5, colors.HexColor('#e2e8f0')),
        ('TOPPADDING', (0, 0), (-1, -1), 3),
        ('BOTTOMPADDING', (0, 0), (-1, -1), 3),
        ('LEFTPADDING', (0, 0), (-1, -1), 6),
        ('RIGHTPADDING', (0, 0), (-1, -1), 6),
        ('VALIGN', (0, 0), (-1, -1), 'TOP'),
    ]))
    story.append(skills_table)
    story.append(Spacer(1, 5))

    # Footer
    story.append(Paragraph("Curriculum Vitae • M Salman • AI Engineer • Prompt Programmer", footer_text))

    # Build document
    doc.build(story)
    print(f"CV PDF successfully generated at: {output_path}")

if __name__ == "__main__":
    out_file = r"a:\My Portfolio\assets\docs\Muhammad_Salman_CV.pdf"
    generate_pdf(out_file)
