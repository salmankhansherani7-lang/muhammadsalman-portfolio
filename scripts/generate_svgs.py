import os

projects = {
    'laptop-price-prediction.svg': '''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 360" width="100%" height="100%">
  <defs>
    <linearGradient id="bg1" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#0b1021"/>
      <stop offset="100%" stop-color="#161d36"/>
    </linearGradient>
    <linearGradient id="lineGrad" x1="0%" y1="100%" x2="100%" y2="0%">
      <stop offset="0%" stop-color="#8b5cf6"/>
      <stop offset="100%" stop-color="#06b6d4"/>
    </linearGradient>
  </defs>
  <rect width="600" height="360" fill="url(#bg1)"/>
  <g opacity="0.15" stroke="#38bdf8" stroke-width="1">
    <line x1="50" y1="60" x2="550" y2="60" stroke-dasharray="4,4"/>
    <line x1="50" y1="120" x2="550" y2="120" stroke-dasharray="4,4"/>
    <line x1="50" y1="180" x2="550" y2="180" stroke-dasharray="4,4"/>
    <line x1="50" y1="240" x2="550" y2="240" stroke-dasharray="4,4"/>
    <line x1="50" y1="300" x2="550" y2="300"/>
    <line x1="50" y1="60" x2="50" y2="300"/>
  </g>
  <g fill="#a855f7" opacity="0.75">
    <circle cx="80" cy="280" r="4"/><circle cx="110" cy="270" r="3.5"/><circle cx="140" cy="250" r="5"/>
    <circle cx="165" cy="230" r="4"/><circle cx="190" cy="225" r="4.5"/><circle cx="210" cy="210" r="4"/>
    <circle cx="240" cy="195" r="5"/><circle cx="270" cy="180" r="4"/><circle cx="300" cy="175" r="5.5"/>
    <circle cx="330" cy="150" r="4"/><circle cx="360" cy="140" r="4.5"/><circle cx="390" cy="130" r="4"/>
    <circle cx="420" cy="110" r="5"/><circle cx="450" cy="95" r="4"/><circle cx="490" cy="80" r="5"/>
    <circle cx="520" cy="70" r="4.5"/>
  </g>
  <line x1="60" y1="290" x2="540" y2="65" stroke="url(#lineGrad)" stroke-width="3.5" stroke-linecap="round"/>
  <text x="70" y="45" fill="#38bdf8" font-family="monospace" font-size="14" font-weight="bold">R² Score: 0.942 | MSE: 0.018</text>
  <rect x="390" y="260" width="160" height="50" rx="8" fill="#0f172a" stroke="#8b5cf6" stroke-width="1"/>
  <text x="405" y="285" fill="#e2e8f0" font-family="sans-serif" font-size="12" font-weight="bold">Gradient Boosting</text>
  <text x="405" y="300" fill="#94a3b8" font-family="sans-serif" font-size="10">Feature-Weighted Regressor</text>
</svg>''',

    'classroom-attendance.svg': '''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 360" width="100%" height="100%">
  <defs>
    <linearGradient id="bg2" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#080e1e"/>
      <stop offset="100%" stop-color="#111936"/>
    </linearGradient>
  </defs>
  <rect width="600" height="360" fill="url(#bg2)"/>
  <circle cx="300" cy="170" r="100" fill="none" stroke="rgba(56,189,248,0.2)" stroke-width="1" stroke-dasharray="6,6"/>
  <circle cx="300" cy="170" r="65" fill="none" stroke="rgba(139,92,246,0.3)" stroke-width="1"/>
  <path d="M260,130 C270,110 330,110 340,130 C355,160 350,210 300,235 C250,210 245,160 260,130 Z" fill="rgba(139,92,246,0.12)" stroke="#a855f7" stroke-width="2"/>
  <circle cx="280" cy="155" r="4" fill="#06b6d4"/><circle cx="320" cy="155" r="4" fill="#06b6d4"/>
  <path d="M290,175 L300,185 L310,175" fill="none" stroke="#38bdf8" stroke-width="2"/>
  <path d="M285,205 Q300,218 315,205" fill="none" stroke="#10b981" stroke-width="2.5"/>
  <path d="M230,110 L230,90 L250,90" fill="none" stroke="#10b981" stroke-width="3"/>
  <path d="M370,110 L370,90 L350,90" fill="none" stroke="#10b981" stroke-width="3"/>
  <path d="M230,230 L230,250 L250,250" fill="none" stroke="#10b981" stroke-width="3"/>
  <path d="M370,230 L370,250 L350,250" fill="none" stroke="#10b981" stroke-width="3"/>
  <rect x="230" y="60" width="140" height="24" rx="4" fill="#10b981"/>
  <text x="240" y="76" fill="#022c22" font-family="monospace" font-size="12" font-weight="bold">ID: CONFIRMED 99.4%</text>
  <text x="40" y="325" fill="#06b6d4" font-family="monospace" font-size="12">YOLOv8-Face + MediaPipe 468 Landmark Mesh • Liveness: Active</text>
</svg>''',

    'whatsapp-analysis.svg': '''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 360" width="100%" height="100%">
  <defs>
    <linearGradient id="bg3" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#06131c"/>
      <stop offset="100%" stop-color="#0e2736"/>
    </linearGradient>
    <linearGradient id="barGrad" x1="0%" y1="0%" x2="0%" y2="100%">
      <stop offset="0%" stop-color="#10b981"/>
      <stop offset="100%" stop-color="#047857"/>
    </linearGradient>
  </defs>
  <rect width="600" height="360" fill="url(#bg3)"/>
  <rect x="80" y="180" width="35" height="120" rx="4" fill="url(#barGrad)"/>
  <rect x="130" y="140" width="35" height="160" rx="4" fill="url(#barGrad)"/>
  <rect x="180" y="90" width="35" height="210" rx="4" fill="url(#barGrad)"/>
  <rect x="230" y="60" width="35" height="240" rx="4" fill="#22c55e"/>
  <rect x="280" y="120" width="35" height="180" rx="4" fill="url(#barGrad)"/>
  <rect x="330" y="160" width="35" height="140" rx="4" fill="url(#barGrad)"/>
  <path d="M97,165 Q180,70 247,45 T347,145 T450,110 T520,70" fill="none" stroke="#38bdf8" stroke-width="3" stroke-linecap="round"/>
  <circle cx="247" cy="45" r="6" fill="#38bdf8"/>
  <rect x="390" y="190" width="170" height="90" rx="8" fill="#06131c" stroke="#10b981" stroke-width="1"/>
  <text x="405" y="215" fill="#10b981" font-family="monospace" font-size="13" font-weight="bold">NLP Sentiment</text>
  <text x="405" y="238" fill="#e2e8f0" font-family="sans-serif" font-size="11">+78.4% Positive Vibe</text>
  <text x="405" y="258" fill="#94a3b8" font-family="sans-serif" font-size="10">Peak Activity: 21:00 UTC</text>
</svg>''',

    'autonomous-rover.svg': '''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 360" width="100%" height="100%">
  <defs>
    <linearGradient id="bg4" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#110e1b"/>
      <stop offset="100%" stop-color="#22163b"/>
    </linearGradient>
  </defs>
  <rect width="600" height="360" fill="url(#bg4)"/>
  <path d="M300,260 L180,90 A180,180 0 0,1 420,90 Z" fill="rgba(245,158,11,0.08)" stroke="rgba(245,158,11,0.3)" stroke-width="1"/>
  <circle cx="300" cy="260" r="50" fill="none" stroke="#f59e0b" stroke-width="1" stroke-dasharray="4,4"/>
  <circle cx="300" cy="260" r="110" fill="none" stroke="#f59e0b" stroke-width="1" stroke-dasharray="4,4"/>
  <circle cx="300" cy="260" r="170" fill="none" stroke="#f59e0b" stroke-width="1" stroke-dasharray="4,4"/>
  <rect x="265" y="240" width="70" height="80" rx="10" fill="#1e1b4b" stroke="#ec4899" stroke-width="2"/>
  <rect x="250" y="250" width="12" height="30" rx="3" fill="#6366f1"/>
  <rect x="338" y="250" width="12" height="30" rx="3" fill="#6366f1"/>
  <circle cx="285" cy="230" r="8" fill="#06b6d4"/><circle cx="315" cy="230" r="8" fill="#06b6d4"/>
  <text x="50" y="50" fill="#f59e0b" font-family="monospace" font-size="14" font-weight="bold">RADAR TELEMETRY: CLEARANCE 42cm</text>
  <text x="50" y="72" fill="#94a3b8" font-family="monospace" font-size="11">ESP32 Core 0: Echo Pulse • Core 1: Motor PWM</text>
</svg>''',

    'rag-agent-research.svg': '''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 360" width="100%" height="100%">
  <defs>
    <linearGradient id="bg5" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#0f0c29"/>
      <stop offset="100%" stop-color="#241442"/>
    </linearGradient>
  </defs>
  <rect width="600" height="360" fill="url(#bg5)"/>
  <line x1="150" y1="180" x2="300" y2="110" stroke="#8b5cf6" stroke-width="2" stroke-dasharray="5,5"/>
  <line x1="150" y1="180" x2="300" y2="250" stroke="#8b5cf6" stroke-width="2" stroke-dasharray="5,5"/>
  <line x1="300" y1="110" x2="450" y2="180" stroke="#ec4899" stroke-width="2"/>
  <line x1="300" y1="250" x2="450" y2="180" stroke="#06b6d4" stroke-width="2"/>
  <circle cx="150" cy="180" r="36" fill="#1e1b4b" stroke="#a855f7" stroke-width="2"/>
  <text x="150" y="184" fill="#e2e8f0" font-family="sans-serif" font-size="11" font-weight="bold" text-anchor="middle">Orchestrator</text>
  <circle cx="300" cy="110" r="34" fill="#1e1b4b" stroke="#ec4899" stroke-width="2"/>
  <text x="300" y="114" fill="#fbcfe8" font-family="sans-serif" font-size="11" font-weight="bold" text-anchor="middle">ChromaDB</text>
  <circle cx="300" cy="250" r="34" fill="#1e1b4b" stroke="#06b6d4" stroke-width="2"/>
  <text x="300" y="254" fill="#cffafe" font-family="sans-serif" font-size="11" font-weight="bold" text-anchor="middle">Fact-Checker</text>
  <circle cx="450" cy="180" r="36" fill="#1e1b4b" stroke="#10b981" stroke-width="2"/>
  <text x="450" y="184" fill="#a7f3d0" font-family="sans-serif" font-size="11" font-weight="bold" text-anchor="middle">Synthesis</text>
  <text x="50" y="45" fill="#ec4899" font-family="monospace" font-size="14" font-weight="bold">LangGraph Multi-Agent RAG Architecture</text>
</svg>''',

    'enterprise-web.svg': '''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 360" width="100%" height="100%">
  <defs>
    <linearGradient id="bg6" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#090d16"/>
      <stop offset="100%" stop-color="#131c31"/>
    </linearGradient>
  </defs>
  <rect width="600" height="360" fill="url(#bg6)"/>
  <rect x="50" y="50" width="500" height="260" rx="10" fill="rgba(15,23,42,0.7)" stroke="rgba(255,255,255,0.1)" stroke-width="1.5"/>
  <circle cx="75" cy="70" r="4" fill="#ef4444"/><circle cx="90" cy="70" r="4" fill="#f59e0b"/><circle cx="105" cy="70" r="4" fill="#10b981"/>
  <line x1="50" y1="90" x2="550" y2="90" stroke="rgba(255,255,255,0.08)"/>
  <rect x="75" y="110" width="130" height="70" rx="6" fill="rgba(30,41,59,0.6)" stroke="#6366f1" stroke-width="1"/>
  <text x="90" y="135" fill="#94a3b8" font-family="sans-serif" font-size="10">Telemetry Line 01</text>
  <text x="90" y="160" fill="#38bdf8" font-family="monospace" font-size="16" font-weight="bold">142.8 PSI</text>
  <rect x="220" y="110" width="130" height="70" rx="6" fill="rgba(30,41,59,0.6)" stroke="#10b981" stroke-width="1"/>
  <text x="235" y="135" fill="#94a3b8" font-family="sans-serif" font-size="10">Status</text>
  <text x="235" y="160" fill="#10b981" font-family="monospace" font-size="16" font-weight="bold">NOMINAL</text>
  <rect x="365" y="110" width="160" height="70" rx="6" fill="rgba(30,41,59,0.6)" stroke="#ec4899" stroke-width="1"/>
  <text x="380" y="135" fill="#94a3b8" font-family="sans-serif" font-size="10">Modbus RTU Latency</text>
  <text x="380" y="160" fill="#ec4899" font-family="monospace" font-size="16" font-weight="bold">8.4 ms</text>
  <path d="M75,270 L130,230 L190,245 L250,210 L310,225 L380,195 L450,215 L525,190" fill="none" stroke="#38bdf8" stroke-width="2.5"/>
</svg>''',

    'iot-mesh.svg': '''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 360" width="100%" height="100%">
  <defs>
    <linearGradient id="bg7" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#08101a"/>
      <stop offset="100%" stop-color="#132438"/>
    </linearGradient>
  </defs>
  <rect width="600" height="360" fill="url(#bg7)"/>
  <rect x="250" y="130" width="100" height="100" rx="8" fill="#0f172a" stroke="#06b6d4" stroke-width="2"/>
  <text x="300" y="185" fill="#38bdf8" font-family="monospace" font-size="13" font-weight="bold" text-anchor="middle">ESP32 ROOT</text>
  <circle cx="120" cy="90" r="24" fill="#0f172a" stroke="#10b981" stroke-width="2"/>
  <text x="120" y="94" fill="#a7f3d0" font-family="sans-serif" font-size="9" text-anchor="middle">Node A</text>
  <circle cx="480" cy="90" r="24" fill="#0f172a" stroke="#10b981" stroke-width="2"/>
  <text x="480" y="94" fill="#a7f3d0" font-family="sans-serif" font-size="9" text-anchor="middle">Node B</text>
  <circle cx="120" cy="270" r="24" fill="#0f172a" stroke="#10b981" stroke-width="2"/>
  <text x="120" y="274" fill="#a7f3d0" font-family="sans-serif" font-size="9" text-anchor="middle">Node C</text>
  <circle cx="480" cy="270" r="24" fill="#0f172a" stroke="#10b981" stroke-width="2"/>
  <text x="480" y="274" fill="#a7f3d0" font-family="sans-serif" font-size="9" text-anchor="middle">Node D</text>
  <line x1="250" y1="150" x2="140" y2="100" stroke="#06b6d4" stroke-width="1.5" stroke-dasharray="4,4"/>
  <line x1="350" y1="150" x2="460" y2="100" stroke="#06b6d4" stroke-width="1.5" stroke-dasharray="4,4"/>
  <line x1="250" y1="210" x2="140" y2="260" stroke="#06b6d4" stroke-width="1.5" stroke-dasharray="4,4"/>
  <line x1="350" y1="210" x2="460" y2="260" stroke="#06b6d4" stroke-width="1.5" stroke-dasharray="4,4"/>
  <text x="50" y="45" fill="#06b6d4" font-family="monospace" font-size="14" font-weight="bold">ESP-NOW Peer-to-Peer Protocol (&lt;20ms)</text>
</svg>''',

    'certifai-vector.svg': '''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 360" width="100%" height="100%">
  <defs>
    <linearGradient id="bg8" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#150e24"/>
      <stop offset="100%" stop-color="#2e1045"/>
    </linearGradient>
  </defs>
  <rect width="600" height="360" fill="url(#bg8)"/>
  <path d="M300,70 L390,110 V190 C390,240 300,285 300,285 C300,285 210,240 210,190 V110 Z" fill="rgba(139,92,246,0.15)" stroke="#c084fc" stroke-width="2.5"/>
  <circle cx="300" cy="170" r="35" fill="rgba(236,72,153,0.2)" stroke="#ec4899" stroke-width="2"/>
  <path d="M285,170 L295,180 L315,160" fill="none" stroke="#38bdf8" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
  <rect x="440" y="200" width="80" height="80" rx="6" fill="#ffffff" opacity="0.9"/>
  <rect x="450" y="210" width="20" height="20" fill="#0f172a"/>
  <rect x="490" y="210" width="20" height="20" fill="#0f172a"/>
  <rect x="450" y="250" width="20" height="20" fill="#0f172a"/>
  <circle cx="485" cy="245" r="4" fill="#0f172a"/>
  <text x="50" y="45" fill="#c084fc" font-family="monospace" font-size="14" font-weight="bold">CertifAI — Automated Vector Cryptoseals</text>
  <text x="50" y="68" fill="#94a3b8" font-family="sans-serif" font-size="11">Animated SMIL SVG + Dynamic Public Key Verification</text>
</svg>'''
}

out_dir = r'a:\My Portfolio\assets\images\projects'
os.makedirs(out_dir, exist_ok=True)
for fname, content in projects.items():
    with open(os.path.join(out_dir, fname), 'w', encoding='utf-8') as f:
        f.write(content.strip())
print(f"Generated {len(projects)} project thumbnails successfully!")

