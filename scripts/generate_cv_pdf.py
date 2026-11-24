"""
Muhammad Salman - Executive Curriculum Vitae (CV) Generator
Generates an ATS-compliant, ultra-clean executive 1-page PDF
matching the exact design and sections requested by the client,
stopping strictly at 'Programming Languages'.
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
    doc = SimpleDocTemplate(
        output_path,
        pagesize=letter,
        leftMargin=36,
        rightMargin=36,
        topMargin=36,
        bottomMargin=36
    )

    styles = getSampleStyleSheet()

    # Custom styles
    header_name = ParagraphStyle(
        'HeaderName',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=20,
        leading=24,
        textColor=colors.HexColor('#0f172a')
    )

    header_title = ParagraphStyle(
        'HeaderTitle',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=10.5,
        leading=14,
        textColor=colors.HexColor('#6366f1')
    )

    header_meta = ParagraphStyle(
        'HeaderMeta',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=8.5,
        leading=12,
        alignment=2, # Right align
        textColor=colors.HexColor('#475569')
    )

    contact_bar = ParagraphStyle(
        'ContactBar',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=8.5,
        leading=12,
        textColor=colors.HexColor('#0f172a'),
        alignment=1 # Center
    )

    section_heading = ParagraphStyle(
        'SectionHeading',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=10,
        leading=13,
        textColor=colors.HexColor('#1e293b'),
        spaceAfter=3
    )

    body_text = ParagraphStyle(
        'BodyTextCustom',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=8.5,
        leading=12.5,
        textColor=colors.HexColor('#334155'),
        alignment=4 # Justify
    )

    comp_title = ParagraphStyle(
        'CompTitle',
        parent=styles['Normal'],
        fontName='Helvetica-Bold',
        fontSize=9,
        leading=12,
        textColor=colors.HexColor('#4338ca')
    )

    comp_body = ParagraphStyle(
        'CompBody',
        parent=styles['Normal'],
        fontName='Helvetica',
        fontSize=8,
        leading=11.5,
        textColor=colors.HexColor('#334155')
    )

    story = []

    # 1. Header Table (Name & Subtitle on Left, Location & Availability on Right)
    col1 = [
        Paragraph("MUHAMMAD SALMAN", header_name),
        Spacer(1, 2),
        Paragraph("AI ENGINEER • MACHINE LEARNING & ROBOTICS ARCHITECT", header_title)
    ]
    col2 = [
        Paragraph("<b>Islamabad & Rawalpindi, Pakistan</b>", header_meta),
        Paragraph("PEC Registered • UTC+5 (Remote Ready)", header_meta),
        Paragraph("contact@muhammadsalman.ai", header_meta)
    ]

    header_table = Table([[col1, col2]], colWidths=[330, 210])
    header_table.setStyle(TableStyle([
        ('VALIGN', (0, 0), (-1, -1), 'TOP'),
        ('LEFTPADDING', (0, 0), (-1, -1), 0),
        ('RIGHTPADDING', (0, 0), (-1, -1), 0),
        ('TOPPADDING', (0, 0), (-1, -1), 0),
        ('BOTTOMPADDING', (0, 0), (-1, -1), 0),
    ]))
    story.append(header_table)
    story.append(Spacer(1, 6))

    # Contact Bar
    contact_text = (
        "+92 3327768335 &nbsp;&nbsp;•&nbsp;&nbsp; "
        "contact@muhammadsalman.ai &nbsp;&nbsp;•&nbsp;&nbsp; "
        "linkedin.com/in/muhammad-salman-ai &nbsp;&nbsp;•&nbsp;&nbsp; "
        "github.com/salmankhansherani7-lang"
    )
    story.append(Paragraph(contact_text, contact_bar))
    story.append(Spacer(1, 6))
    story.append(HRFlowable(width="100%", thickness=1.5, color=colors.HexColor('#0f172a'), spaceAfter=8, spaceBefore=2))

    # 2. Professional Summary
    story.append(Paragraph("PROFESSIONAL SUMMARY", section_heading))
    summary_text = (
        "AI Engineer with extensive hands-on expertise bridging deep neural architectures with edge microcontrollers, "
        "autonomous multi-agent frameworks, and high-performance web systems. Proven track record architecting 99.4% "
        "accurate facial recognition pipelines (YOLOv8 + MediaPipe), RAG (Retrieval-Augmented Generation) vector systems, "
        "serverless ESP32/ESP-NOW wireless mesh telemetry networks, and enterprise web platforms. Skilled in designing scalable, "
        "secure full-stack architectures and delivering corporate AI instruction across Python, Machine Learning, and Robotics."
    )
    story.append(Paragraph(summary_text, body_text))
    story.append(Spacer(1, 10))

    # 3. Technical Core Competencies
    story.append(Paragraph("TECHNICAL CORE COMPETENCIES", section_heading))
    story.append(HRFlowable(width="100%", thickness=0.8, color=colors.HexColor('#cbd5e1'), spaceAfter=6, spaceBefore=2))

    # 2-column grid of competencies
    # Card 1: AI, Machine Learning & Computer Vision
    c1 = [
        Paragraph("AI, Machine Learning & Computer Vision:", comp_title),
        Spacer(1, 2),
        Paragraph("PyTorch, TensorFlow, Keras, Scikit-Learn, OpenCV, Ultralytics YOLOv8, MediaPipe Face Mesh, CNNs, Facial Landmark Alignment, Anti-spoofing Blink Detection, Scipy, NumPy, Pandas.", comp_body)
    ]

    # Card 2: Generative AI & Autonomous Multi-Agents
    c2 = [
        Paragraph("Generative AI & Autonomous Multi-Agents:", comp_title),
        Spacer(1, 2),
        Paragraph("CrewAI, LangChain, LangGraph Architecture, Multi-Agent Coordination, RAG Architecture, Vector DBs (ChromaDB, FAISS), OpenAI & Claude Tool-Use, Function Calling, Prompt Tuning, n8n.", comp_body)
    ]

    # Card 3: Robotics & Embedded IoT Systems
    c3 = [
        Paragraph("Robotics & Embedded IoT Systems:", comp_title),
        Spacer(1, 2),
        Paragraph("ESP32 Microcontrollers, ESP-NOW Mesh Protocol (Sub-20ms wireless latency), Arduino C++, Raspberry Pi, Sensor Fusion (Ultrasonic, PIR, DHT22, LDR), Motor Actuation (L298N, Servos), Wokwi.", comp_body)
    ]

    # Card 4: Full-Stack Web & API Architecture
    c4 = [
        Paragraph("Full-Stack Web & API Architecture:", comp_title),
        Spacer(1, 2),
        Paragraph("PHP & MySQL, Modern JavaScript (ES6+), React.js, Node.js, Tailwind CSS, Alpine.js, RESTful APIs, JSON, Google OAuth 2.0, Firebase, Figma UI/UX Design Systems.", comp_body)
    ]

    # Card 5: Programming Languages (Full width or paired)
    c5 = [
        Paragraph("Programming Languages:", comp_title),
        Spacer(1, 2),
        Paragraph("Python (Advanced OOP / Asynchronous / Scientific Stack), C++ (Firmware & Pointers), JavaScript (ES6+, DOM, Async/Await), PHP (Modern 8+, PDO), SQL (PostgreSQL, MySQL, SQLite).", comp_body)
    ]

    # Card 6: DevOps, Environments & Leadership
    c6 = [
        Paragraph("DevOps, Environments & Systems:", comp_title),
        Spacer(1, 2),
        Paragraph("Git, GitHub Actions, Docker, CI/CD, Linux/Bash, VS Code, Google Colab, Technical Instruction, STEM Curriculum Design, Engineering Team Leadership.", comp_body)
    ]

    comp_table_data = [
        [c1, c2],
        [c3, c4],
        [c5, c6]
    ]

    comp_table = Table(comp_table_data, colWidths=[265, 265])
    comp_table.setStyle(TableStyle([
        ('VALIGN', (0, 0), (-1, -1), 'TOP'),
        ('LEFTPADDING', (0, 0), (-1, -1), 8),
        ('RIGHTPADDING', (0, 0), (-1, -1), 8),
        ('TOPPADDING', (0, 0), (-1, -1), 6),
        ('BOTTOMPADDING', (0, 0), (-1, -1), 6),
        ('BACKGROUND', (0, 0), (-1, -1), colors.HexColor('#f8fafc')),
        ('BOX', (0, 0), (-1, -1), 0.5, colors.HexColor('#e2e8f0')),
        ('INNERGRID', (0, 0), (-1, -1), 0.5, colors.HexColor('#e2e8f0')),
    ]))

    story.append(comp_table)
    story.append(Spacer(1, 14))

    # Footer note indicating digital verification
    footer_text = ParagraphStyle(
        'FooterText',
        parent=styles['Normal'],
        fontName='Helvetica-Oblique',
        fontSize=7.5,
        textColor=colors.HexColor('#64748b'),
        alignment=1
    )
    story.append(HRFlowable(width="100%", thickness=0.5, color=colors.HexColor('#e2e8f0'), spaceAfter=4, spaceBefore=4))
    story.append(Paragraph("Curriculum Vitae • Muhammad Salman • AI Engineer • Verified Digital Portfolio", footer_text))

    doc.build(story)
    print(f"CV PDF generated successfully at: {output_path}")

if __name__ == '__main__':
    target = r'a:\My Portfolio\assets\docs\Muhammad_Salman_CV.pdf'
    generate_pdf(target)
