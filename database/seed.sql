-- ========================================================
-- Seed Data for Muhammad Salman - AI Engineer Portfolio
-- ========================================================

-- 1. Default Admin User (Password: Admin@12345)
INSERT INTO admin_users (username, email, password_hash, full_name, avatar_url)
VALUES (
    'admin',
    'admin@muhammadsalman.ai',
    '$2y$10$zI80WzAc.jR5AJyZhx9ld.GhPRIPTkr3PwTPOe4kbPjyM.Y7JLUiy',
    'Muhammad Salman',
    'assets/images/profile.jpg'
);

-- 2. Profile Information
INSERT INTO profile (
    full_name, profession, headline_titles, short_bio, full_bio, avatar_url,
    location, academic_degree, direct_email, direct_phone,
    availability_status, availability_badge, cv_download_url
) VALUES (
    'Muhammad Salman',
    'AI Engineer',
    'AI Engineer | Machine Learning Specialist | Generative AI & Autonomous Agents Architect | Computer Vision Engineer',
    'AI Engineer specializing in end-to-end Machine Learning pipelines, Generative AI & Autonomous Agent architectures, Edge Computer Vision, and high-performance Web Systems.',
    'I am an AI Engineer passionate about designing scalable intelligent systems that bridge deep neural networks, autonomous AI agents, and production web architectures. With hands-on expertise in PyTorch, YOLO computer vision pipelines, LLM-powered RAG systems, and embedded IoT intelligence, I deliver robust, production-grade solutions tailored for real-world impact.',
    'assets/images/profile.jpg',
    'Islamabad & Rawalpindi, Pakistan',
    'B.S. in Computer Science / Artificial Intelligence',
    'contact@muhammadsalman.ai',
    '+92 300 1234567',
    'Available for Opportunities • Islamabad, PK (Remote Ready)',
    'Open',
    'assets/docs/Muhammad_Salman_CV.pdf'
);

-- 3. Hero Metric Cards
INSERT INTO hero_stats (stat_number, stat_label, icon_name, sort_order) VALUES
('15+', 'Projects Completed', 'folder-git-2', 1),
('500+', 'Developers & Students Mentored', 'users', 2),
('4+', 'Years Applied Experience', 'briefcase', 3),
('10+', 'Enterprise Certifications', 'award', 4);

-- 4. Hero Orbiting Tech Badges
INSERT INTO hero_tags (tag_label, tag_category, color_class, position_class, sort_order) VALUES
('Python & PyTorch', 'AI / ML', 'tag-purple', 'orbit-top-left', 1),
('IoT & Robotics', 'HARDWARE', 'tag-amber', 'orbit-top-right', 2),
('Web & Systems', 'FULL-STACK', 'tag-cyan', 'orbit-bottom-left', 3),
('LLMs & RAG', 'GEN-AI', 'tag-magenta', 'orbit-bottom-right', 4);

-- 5. Skill Categories (6 Specific Categories)
INSERT INTO skill_categories (name, slug, badge_text, status_text, icon_name, sort_order) VALUES
('AI, Machine Learning & Deep Learning', 'ai-ml-dl', '6 Techs', 'Production Ready', 'brain', 1),
('Generative AI, RAG & AI Agents', 'genai-rag-agents', '6 Techs', 'Production Ready', 'sparkles', 2),
('Robotics & Embedded IoT', 'robotics-iot', '6 Techs', 'Embedded Systems', 'cpu', 3),
('Web Development & Software Engineering', 'web-software', '6 Techs', 'Full-Stack Architecture', 'layout', 4),
('Programming Languages', 'programming-languages', '5 Core', 'Core Mastery', 'code', 5),
('DevOps, Tools & Professional Skills', 'devops-tools', '6 Skills', 'CI/CD & Cloud', 'terminal', 6);

-- 6. Individual Skills
-- Category 1: AI, Machine Learning & Deep Learning
INSERT INTO skills (category_id, name, description, proficiency_label, proficiency_level, sort_order) VALUES
(1, 'Python & ML Core', 'NumPy, Scikit-Learn, Pandas & OOP', 'Mastery', 95, 1),
(1, 'PyTorch & Deep Neural Networks', 'CNNs, Transformers & Custom Layers', 'Expert', 92, 2),
(1, 'Computer Vision & YOLOv8', 'YOLOv8, MediaPipe Face Mesh, OpenCV', 'Advanced', 90, 3),
(1, 'Model Training & Evaluation', 'Hyperparameter Tuning, Cross-Validation', 'Production', 88, 4),
(1, 'TensorFlow & Keras', 'Transfer Learning, Loss Optimization', 'Expert', 87, 5),
(1, 'Facial Recognition & Liveness', '128D Embeddings, Anti-spoofing Blink', 'Production', 91, 6);

-- Category 2: Generative AI, RAG & AI Agents
INSERT INTO skills (category_id, name, description, proficiency_label, proficiency_level, sort_order) VALUES
(2, 'AI Multi-Agent Systems', 'CrewAI, LangChain & LangGraph Orchestration', 'Production', 93, 1),
(2, 'RAG Architecture', 'Vector DBs (ChromaDB, FAISS) & Embeddings', 'Expert', 90, 2),
(2, 'LLMs & FastAPI', 'OpenAI, Claude API, Tool-Use & Streaming', 'Production', 92, 3),
(2, 'Prompt Engineering', 'Structured JSON, Few-shot & Chain-of-Thought', 'Mastery', 94, 4),
(2, 'Hugging Face & Open Source', 'Model Fine-tuning, PEFT/LoRA & Quantization', 'Advanced', 86, 5),
(2, 'n8n & Workflow Automation', 'Autonomous Webhooks, Agent Tool-Calling', 'Expert', 88, 6);

-- Category 3: Robotics & Embedded IoT
INSERT INTO skills (category_id, name, description, proficiency_label, proficiency_level, sort_order) VALUES
(3, 'Arduino & C++ Firmware', 'Embedded C++, Interrupts & Register Control', 'Firmware Pro', 90, 1),
(3, 'ESP32 & ESP-NOW Mesh', 'Peer-to-Peer Mesh, Low-Latency Packets', 'Production', 92, 2),
(3, 'IoT Telemetry & MQTT', 'MQTT, WebSockets, Wi-Fi Cloud Gateways', 'Expert', 88, 3),
(3, 'Autonomous Mobile Rovers', 'Obstacle Avoidance, Ultrasonic, L298N', 'Advanced', 85, 4),
(3, 'Sensor Fusion & Actuation', 'PIR, DHT22, LDR, Servos & Steppers', 'Mastery', 89, 5),
(3, 'Wokwi Simulator & Circuitry', 'Hardware Emulation, Logic Prototyping', 'Expert', 91, 6);

-- Category 4: Web Development & Software Engineering
INSERT INTO skills (category_id, name, description, proficiency_label, proficiency_level, sort_order) VALUES
(4, 'Tailwind CSS & Modern UI', 'Design Systems, Glassmorphism & Responsive', 'Mastery', 95, 1),
(4, 'JavaScript (ES6+) & DOM', 'Async/Await, Custom Web Components', 'Core Expert', 93, 2),
(4, 'React & Node.js', 'SPA Architecture, RESTful Services', 'Production', 89, 3),
(4, 'PHP & MySQL Architecture', 'Secure PDO, MVC Patterns, Query Tuning', 'Backend Pro', 92, 4),
(4, 'HTML5 Semantic & Modern CSS', 'Semantic DOM, Flexbox, CSS Grid & Canvas', 'Mastery', 96, 5),
(4, 'RESTful APIs & Microservices', 'OAuth 2.0, JWT, Rate Limiting, JSON', 'Production', 90, 6);

-- Category 5: Programming Languages
INSERT INTO skills (category_id, name, description, proficiency_label, proficiency_level, sort_order) VALUES
(5, 'Python', 'Advanced OOP, Asynchronous, Data Structures', 'Mastery', 96, 1),
(5, 'C++ (Firmware & OOP)', 'Pointers, Memory Optimization, Classes', 'Advanced', 88, 2),
(5, 'JavaScript', 'Modern ES2023, Event Loop, Modular Code', 'Mastery', 92, 3),
(5, 'PHP', 'Object-Oriented PHP 8+, PDO & Security', 'Core Expert', 90, 4),
(5, 'SQL', 'PostgreSQL, MySQL, SQLite Optimization', 'Advanced', 89, 5);

-- Category 6: DevOps, Tools & Professional Skills
INSERT INTO skills (category_id, name, description, proficiency_label, proficiency_level, sort_order) VALUES
(6, 'Git & GitHub Workflows', 'CI/CD Actions, Branching & Version Control', 'Expert', 94, 1),
(6, 'Docker Containers', 'Microservices Packaging, Compose & Volumes', 'Production', 88, 2),
(6, 'Linux / Bash Scripting', 'Server Hardening, Cron Jobs & Shell Scripts', 'Core Expert', 90, 3),
(6, 'Cloud & AI Deployments', 'Cloud APIs, VPS Management, Serverless', 'Cloud Ready', 86, 4),
(6, 'UI/UX & Figma Prototyping', 'Wireframing, High-Fidelity UI Systems', 'Advanced', 87, 5),
(6, 'Technical Instruction & Mentorship', 'Curriculum Design, Engineering Workshops', 'Mastery', 95, 6);

-- 7. Portfolio Projects (Matching Screenshot & Requirements)
INSERT INTO projects (
    title, slug, short_desc, full_desc, category, thumbnail_url, tech_stack,
    live_demo_url, github_url, domain_label, badge_text, is_featured, is_published, sort_order
) VALUES
(
    'Laptop Price Prediction Engine',
    'laptop-price-prediction',
    'Machine learning regression engine analyzing hardware specifications to accurately forecast laptop market values.',
    'Engineered an end-to-end Machine Learning pipeline predicting computer hardware valuation. Implemented exploratory data analysis, feature engineering (RAM, CPU architecture, GPU memory bandwidth, screen resolution), and evaluated Random Forest, Gradient Boosting, and XGBoost models achieving superior R2 scores.',
    'AI / Machine Learning',
    'assets/images/projects/laptop-price-prediction.svg',
    'Python, Scikit-Learn, Pandas, Streamlit',
    '#',
    'https://github.com/salmankhansherani7-lang',
    'ML Regression Model',
    'REGRESSION AI',
    1, 1, 1
),
(
    'AI-Powered Classroom Attendance System',
    'classroom-attendance-ai',
    'Automated smart attendance via YOLOv8 face detection, Google MediaPipe mesh landmarks, and anti-spoofing verification.',
    'High-accuracy real-time facial recognition pipeline designed for educational institutions. Combines YOLOv8 multi-face bounding box localization with MediaPipe 468-point facial landmark alignment. Extracts 128D facial embeddings with anti-spoofing blink verification and logs records automatically into SQLite/PostgreSQL with millisecond latency.',
    'AI / Machine Learning',
    'assets/images/projects/classroom-attendance.svg',
    'MediaPipe, YOLOv8, OpenCV, Python',
    '#',
    'https://github.com/salmankhansherani7-lang',
    'Computer Vision',
    'FACE RECOGNITION AI',
    1, 1, 2
),
(
    'WhatsApp Chat NLP Analytics Suite',
    'whatsapp-chat-analysis',
    'Analytics pipeline parsing chat transcripts, sentiment trends, peak hours, emoji sentiment, and user interaction graphs.',
    'Natural Language Processing pipeline that extracts exported multi-user conversation logs. Performs regex sanitization, temporal message frequency decomposition, VADER sentiment analysis, word cloud generation, and interactive Plotly/Seaborn dashboards to discover user engagement patterns.',
    'Data Analysis',
    'assets/images/projects/whatsapp-analysis.svg',
    'Python, Regex, Matplotlib, Seaborn, NLTK',
    '#',
    'https://github.com/salmankhansherani7-lang',
    'NLP & Data Science',
    'DATA SCIENCE',
    1, 1, 3
),
(
    'Autonomous Obstacle-Avoiding Mobile Rover',
    'autonomous-delivery-rover',
    'Embedded mobile robotic platform with dual-motor actuation, ultrasonic echo ping, and real-time path planning.',
    'Autonomous physical rover designed on ESP32 / Arduino C++ firmware. Utilizes HC-SR04 ultrasonic sensor sweeps mounted on a micro-servo to dynamically evaluate spatial clearances and prevent navigational collisions via L298N motor bridge control.',
    'IoT & Robotics',
    'assets/images/projects/autonomous-rover.svg',
    'Arduino C++, ESP32, Ultrasonic, L298N',
    '#',
    'https://github.com/salmankhansherani7-lang',
    'Embedded Hardware',
    'AUTONOMOUS ROBOT',
    1, 1, 4
),
(
    'RAG Multi-Agent Research Assistant',
    'rag-multi-agent-research-assistant',
    'Autonomous multi-agent orchestration synthesizing complex technical research papers using hybrid vector retrieval.',
    'Built with LangGraph and CrewAI to coordinate specialized researcher, fact-checker, and summarizer agents. Employs ChromaDB vector store, semantic hybrid search, and OpenAI/Claude tool-calling to generate comprehensive technical briefs with exact source citations.',
    'AI / Machine Learning',
    'assets/images/projects/rag-agent-research.svg',
    'LangGraph, CrewAI, ChromaDB, FastAPI',
    '#',
    'https://github.com/salmankhansherani7-lang',
    'Generative AI & RAG',
    'AI MULTI-AGENT',
    1, 1, 5
),
(
    'Enterprise Telemetry Web Dashboard',
    'enterprise-telemetry-dashboard',
    'Industrial IoT telemetry and web dashboard ecosystem for real-time sensor monitoring, threshold alerts, and compliance reports.',
    'Full-stack industrial web portal acquiring real-time sensor telemetry via edge microcontrollers. Features interactive SVG data charts, threshold breach detection with immediate email/webhook alerts, and automated weekly compliance report generation.',
    'Web Development',
    'assets/images/projects/enterprise-web.svg',
    'PHP, MySQL, Tailwind CSS, Chart.js',
    '#',
    'https://github.com/salmankhansherani7-lang',
    'Full-Stack Web',
    'ENTERPRISE WEB',
    1, 1, 6
),
(
    'Smart IoT Hotel Room & ESP-NOW Mesh',
    'smart-iot-hotel-mesh',
    'Serverless, router-independent room management system transmitting peer-to-peer telemetry with sub-20ms wireless latency.',
    'Engineered an ultra-low-latency wireless mesh network using ESP32 nodes communicating via ESP-NOW protocol. Enables room climate automation, proximity badge authentication, and synchronized lighting without relying on external Wi-Fi routers.',
    'IoT & Robotics',
    'assets/images/projects/iot-mesh.svg',
    'ESP-NOW, ESP32, C++, Wokwi',
    '#',
    'https://github.com/salmankhansherani7-lang',
    'IoT Wireless Mesh',
    'SUB-20MS MESH',
    1, 1, 7
),
(
    'CertifAI — Document & Vector Certification Engine',
    'certifai-document-engine',
    'High-fidelity automated credential generation platform with animated SMIL vector certificate architecture and dynamic QR codes.',
    'A robust document verification system enabling automated issuance of cryptographically signed SVG credentials and PDF certificates with dynamic QR code verification endpoints.',
    'Web Development',
    'assets/images/projects/certifai-vector.svg',
    'Python, SVG DOM, QR Generation, PHP',
    '#',
    'https://github.com/salmankhansherani7-lang',
    'Vector Systems & PDF',
    'VECTOR SYSTEM',
    1, 1, 8
);

-- 8. Professional Experience (Editable Placeholders for Muhammad Salman)
INSERT INTO experience (role_title, company_name, location, start_date, end_date, is_current, description, tech_stack, sort_order) VALUES
(
    'AI Engineer & Solutions Architect',
    'Tech Innovation Lab',
    'Islamabad, Pakistan',
    '2024',
    'Present',
    1,
    'Spearheading the design and deployment of edge computer vision models, customized Generative AI RAG pipelines, and automated intelligence microservices. Mentoring engineering interns and leading AI workshops.',
    'Python, PyTorch, YOLOv8, LangChain, FastAPI, Docker',
    1
),
(
    'Machine Learning & IoT Developer',
    'Applied Systems & Embedded Tech',
    'Rawalpindi, Pakistan',
    '2023',
    '2024',
    0,
    'Developed real-time IoT telemetry pipelines and integrated sensor fusion algorithms with cloud dashboards. Engineered automated data extraction and predictive machine learning models.',
    'Python, ESP32, Scikit-Learn, C++, MQTT, MySQL',
    2
),
(
    'Junior Software & AI Engineer',
    'Digital Solutions Hub',
    'Pakistan',
    '2022',
    '2023',
    0,
    'Engineered full-stack responsive web applications, implemented RESTful API endpoints, and collaborated on computer vision classification prototypes.',
    'JavaScript, PHP, MySQL, OpenCV, Git, Tailwind CSS',
    3
);

-- 9. Academic Education
INSERT INTO education (degree_title, institution, location, start_year, end_year, grade_or_honors, description, sort_order) VALUES
(
    'Bachelor of Science in Computer Science / Artificial Intelligence',
    'Accredited Engineering & Science University',
    'Pakistan',
    '2019',
    '2023',
    'First Class Honours',
    'Four-year comprehensive curriculum focusing on Artificial Intelligence, Machine Learning, Data Structures & Algorithms, Computer Vision, Embedded Systems, and Software Engineering.',
    1
);

-- 10. Professional Certifications
INSERT INTO certifications (title, issuer, issue_year, credential_id, credential_url, badge_color, sort_order) VALUES
('Overview of AI', 'Huawei ICT Academy', '2026', 'ICT20261121116239', 'assets/images/certificates/overview-of-ai.jpg', 'violet', 1),
('Search and AI', 'Huawei ICT Academy', '2026', 'ICT20261122000909', 'assets/images/certificates/search-and-ai.jpg', 'blue', 2),
('Development and Basic Concepts of Cloud Computing', 'Huawei ICT Academy', '2026', 'ICT20261122000289', 'assets/images/certificates/cloud-computing-concepts.jpg', 'cyan', 3),
('5G Network Architecture and Key Technologies', 'Huawei ICT Academy', '2026', 'ICT20261121000029', 'assets/images/certificates/5g-network-architecture.jpg', 'purple', 4),
('5G Basics: What it\'s all about', 'Huawei ICT Academy', '2026', 'ICT20261121000162', 'assets/images/certificates/5g-basics.jpg', 'magenta', 5),
('Machine Learning Specialization', 'DeepLearning.AI / Coursera', '2024', 'DL-ML-89241', '#', 'emerald', 6);

-- 11. Services Offered
INSERT INTO services (title, short_desc, detailed_desc, icon_name, deliverables, sort_order) VALUES
(
    'Machine Learning & Deep Neural Models',
    'Custom end-to-end predictive modeling, regression, classification, and neural network fine-tuning.',
    'From data pre-processing and exploratory analysis to training state-of-the-art PyTorch and Scikit-Learn models, I build high-precision predictive solutions tailored to your business problems.',
    'brain',
    'Custom ML pipelines, Hyperparameter tuning, Cross-validation, Model deployment as REST API',
    1
),
(
    'Generative AI & Autonomous Agents',
    'LLM integration, RAG architectures with vector databases, and multi-agent workflow systems.',
    'Architecting autonomous agent workflows with CrewAI, LangChain, and LangGraph. Building high-accuracy RAG systems powered by vector databases (ChromaDB, FAISS) and tailored prompt engineering.',
    'sparkles',
    'RAG pipeline development, Agentic workflow automation, Vector store integration, Custom tool-calling',
    2
),
(
    'Computer Vision & Edge Inference',
    'Real-time object detection, face recognition, and landmark tracking optimized for edge devices.',
    'Deploying low-latency computer vision solutions using YOLOv8, OpenCV, and MediaPipe. Specializing in face verification, bounding box localization, and anti-spoofing security pipelines.',
    'camera',
    'YOLOv8 fine-tuning, Face verification & anti-spoofing, Real-time video processing, Embedded inference',
    3
),
(
    'Embedded IoT & Microcontroller Firmware',
    'ESP32 wireless mesh networks, sensor fusion, and hardware-to-cloud telemetry ecosystems.',
    'Developing firmware in C++ for ESP32, Arduino, and microcontrollers. Designing low-latency ESP-NOW mesh networks, telemetry dashboards, and industrial sensor data acquisition systems.',
    'cpu',
    'ESP32 C++ firmware, ESP-NOW mesh networking, Sensor telemetry (MQTT), Hardware prototyping',
    4
),
(
    'Full-Stack Web & API Architecture',
    'Modern responsive web platforms, secure REST APIs, and interactive management dashboards.',
    'Engineering fast, secure web applications with clean modular architecture, responsive glassmorphism interfaces, OAuth authentication, and database optimization.',
    'layout',
    'Modular web apps, RESTful API design, Database schema optimization, Glassmorphism UI systems',
    5
),
(
    'AI Consultation & Technical Training',
    'Hands-on technical workshops, corporate AI training, and engineering curriculum mentorship.',
    'Delivering structured training workshops on Python, Machine Learning, Computer Vision, and Generative AI for students, university cohorts, and corporate engineering teams.',
    'graduation-cap',
    'Corporate AI workshops, Hands-on code labs, Curriculum development, 1-on-1 engineering mentorship',
    6
);

-- 12. Social Media Links (STRICTLY NO KAGGLE)
INSERT INTO social_links (platform_name, platform_icon, url, sort_order) VALUES
('LinkedIn', 'linkedin', 'https://linkedin.com/in/muhammad-salman-ai', 1),
('GitHub', 'github', 'https://github.com/salmankhansherani7-lang', 2),
('Email', 'mail', 'mailto:contact@muhammadsalman.ai', 3),
('WhatsApp', 'message-circle', 'https://wa.me/923001234567', 4);

-- 13. General Website Settings
INSERT INTO site_settings (setting_key, setting_value, setting_group, description) VALUES
('site_name', 'Muhammad Salman | AI Engineer', 'general', 'Website title tag'),
('meta_description', 'Official portfolio of Muhammad Salman, AI Engineer specializing in Machine Learning, Generative AI Agents, Computer Vision, and Embedded IoT Systems.', 'seo', 'SEO Meta Description'),
('accent_color', '#8b5cf6', 'theme', 'Primary accent gradient color'),
('contact_email_target', 'contact@muhammadsalman.ai', 'contact', 'Recipient address for contact form submissions'),
('footer_tagline', 'Engineered with precision for intelligence, autonomy, and speed.', 'general', 'Footer quote'),
('enable_particles', '1', 'theme', 'Enable interactive neural network particles on hero');

-- 14. CV Modular Sections (STRICTLY STOPPING AT PROGRAMMING LANGUAGES)
INSERT INTO cv_sections (section_key, section_title, content_json, sort_order) VALUES
(
    'header',
    'Personal Header and Contact Details',
    '{"full_name": "MUHAMMAD SALMAN", "profession": "AI ENGINEER", "specialization": "Machine Learning • Generative AI & Autonomous Agents • Computer Vision", "location": "Islamabad & Rawalpindi, Pakistan", "status": "Remote Ready • UTC+5", "phone": "+92 300 1234567", "email": "contact@muhammadsalman.ai", "website": "salman.ai", "linkedin": "in/muhammad-salman-ai", "github": "github.com/salmankhansherani7-lang"}',
    1
),
(
    'summary',
    'Professional Summary',
    '{"text": "Results-driven AI Engineer with strong expertise in bridging deep neural architectures, autonomous multi-agent systems, and production web platforms. Proficient in developing high-accuracy computer vision pipelines (YOLOv8 + MediaPipe), RAG architectures with vector embeddings, and real-time edge telemetry microservices. Dedicated to engineering maintainable, scalable, and secure intelligent systems that solve real-world problems."}',
    2
),
(
    'comp_ai_ml_cv',
    'AI, Machine Learning & Computer Vision',
    '{"items": ["PyTorch, TensorFlow, Keras, Scikit-Learn, OpenCV, Ultralytics YOLOv8", "MediaPipe Face Mesh, CNNs, Facial Landmark Alignment, Liveness Detection", "Scipy, NumPy, Pandas, Exploratory Data Analysis, Hyperparameter Optimization"]}',
    3
),
(
    'comp_genai_agents',
    'Generative AI & Autonomous Multi-Agents',
    '{"items": ["CrewAI, LangChain, LangGraph Architecture, Multi-Agent Collaboration Workflows", "RAG (Retrieval-Augmented Generation) Architecture, Vector DBs (ChromaDB, FAISS)", "OpenAI & Claude API Tool-Use, Function Calling, Prompt Engineering, n8n Automation"]}',
    4
),
(
    'comp_robotics_iot',
    'Robotics & Embedded IoT Systems',
    '{"items": ["ESP32 Microcontrollers, ESP-NOW Mesh Protocol (Sub-20ms P2P Telemetry)", "Arduino C++, Raspberry Pi, Sensor Fusion (Ultrasonic HC-SR04, PIR, DHT22, LDR)", "Motor Actuation (L298N, Servos), Hardware Logic Simulation with Wokwi"]}',
    5
),
(
    'comp_web_api',
    'Full-Stack Web & API Architecture',
    '{"items": ["PHP & MySQL, Modern JavaScript (ES6+), React.js, Node.js, Tailwind CSS", "RESTful API Architecture, JSON, OAuth 2.0 Authentication, Session Security", "Figma UI/UX Prototyping, Glassmorphism Design Systems, Responsive Layouts"]}',
    6
),
(
    'comp_prog_languages',
    'Programming Languages',
    '{"items": ["Python (Advanced OOP, Asynchronous, Scientific Stack)", "C++ (Firmware, Pointers, Low-Level Optimization)", "JavaScript (Modern ES6+, DOM Manipulation, Async/Await)", "PHP (Object-Oriented, PDO, Security Architecture)", "SQL (PostgreSQL, MySQL, SQLite Query Optimization)"]}',
    7
);

