/**
 * Main Interactive Application Script
 * Muhammad Salman - AI Engineer Portfolio
 */

document.addEventListener('DOMContentLoaded', function () {
  // 1. Sticky Navigation on Scroll
  const header = document.querySelector('.site-header');
  window.addEventListener('scroll', function () {
    if (window.scrollY > 40) {
      header?.classList.add('scrolled');
    } else {
      header?.classList.remove('scrolled');
    }
  });

  // 2. Mobile Nav Toggle
  const navToggle = document.querySelector('.nav-toggle');
  const navMenu = document.querySelector('.nav-menu');

  if (navToggle && navMenu) {
    navToggle.addEventListener('click', function () {
      navMenu.classList.toggle('active');
    });

    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', () => {
        navMenu.classList.remove('active');
      });
    });
  }

  // 3. Animated Typing Effect
  const typedTarget = document.getElementById('hero-typed-text');
  if (typedTarget) {
    const phrases = [
      'AI Engineer',
      'Machine Learning Specialist',
      'Generative AI & Agent Architect',
      'Computer Vision Engineer',
      'Embedded IoT & Firmware Developer'
    ];
    let phraseIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    const typeSpeed = 90;
    const eraseSpeed = 45;
    const holdTime = 2000;

    function typeLoop() {
      const currentPhrase = phrases[phraseIndex];

      if (isDeleting) {
        typedTarget.textContent = currentPhrase.substring(0, charIndex - 1);
        charIndex--;
      } else {
        typedTarget.textContent = currentPhrase.substring(0, charIndex + 1);
        charIndex++;
      }

      let timeout = isDeleting ? eraseSpeed : typeSpeed;

      if (!isDeleting && charIndex === currentPhrase.length) {
        timeout = holdTime;
        isDeleting = true;
      } else if (isDeleting && charIndex === 0) {
        isDeleting = false;
        phraseIndex = (phraseIndex + 1) % phrases.length;
        timeout = 400;
      }

      setTimeout(typeLoop, timeout);
    }

    typeLoop();
  }

  // 4. Portfolio Category Filtering
  const filterBtns = document.querySelectorAll('.filter-btn');
  const projectCards = document.querySelectorAll('.project-card');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      filterBtns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');

      const filterValue = this.getAttribute('data-filter');

      projectCards.forEach(card => {
        const cardCategory = card.getAttribute('data-category');
        if (filterValue === 'all' || cardCategory === filterValue) {
          card.style.display = 'flex';
          setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
          }, 10);
        } else {
          card.style.opacity = '0';
          card.style.transform = 'translateY(15px)';
          setTimeout(() => {
            card.style.display = 'none';
          }, 200);
        }
      });
    });
  });

  // 5. Project Details Modal
  const modalOverlay = document.getElementById('project-modal');
  const modalCloseBtn = document.getElementById('modal-close-btn');
  const detailBtns = document.querySelectorAll('.project-details-btn');

  function openProjectModal(data) {
    if (!modalOverlay) return;

    document.getElementById('modal-project-img').src = data.img || '';
    document.getElementById('modal-project-badge').textContent = data.badge || 'PROJECT';
    document.getElementById('modal-project-title').textContent = data.title || '';
    document.getElementById('modal-project-desc').textContent = data.desc || '';
    document.getElementById('modal-project-domain').textContent = data.domain || '';

    // Render tags
    const tagsContainer = document.getElementById('modal-project-tags');
    tagsContainer.innerHTML = '';
    if (data.tags) {
      data.tags.split(',').forEach(tag => {
        const span = document.createElement('span');
        span.className = 'tag-pill';
        span.textContent = tag.trim();
        tagsContainer.appendChild(span);
      });
    }

    // Links
    const demoBtn = document.getElementById('modal-project-demo');
    if (data.demo && data.demo !== '#' && data.demo !== '') {
      demoBtn.href = data.demo;
      demoBtn.style.display = 'inline-flex';
    } else {
      demoBtn.style.display = 'none';
    }

    const githubBtn = document.getElementById('modal-project-github');
    if (data.github && data.github !== '') {
      githubBtn.href = data.github;
      githubBtn.style.display = 'inline-flex';
    } else {
      githubBtn.style.display = 'none';
    }

    modalOverlay.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeProjectModal() {
    if (!modalOverlay) return;
    modalOverlay.classList.remove('open');
    document.body.style.overflow = 'auto';
  }

  detailBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      const data = {
        title: this.getAttribute('data-title'),
        desc: this.getAttribute('data-desc'),
        img: this.getAttribute('data-img'),
        badge: this.getAttribute('data-badge'),
        domain: this.getAttribute('data-domain'),
        tags: this.getAttribute('data-tags'),
        demo: this.getAttribute('data-demo'),
        github: this.getAttribute('data-github')
      };
      openProjectModal(data);
    });
  });

  modalCloseBtn?.addEventListener('click', closeProjectModal);
  modalOverlay?.addEventListener('click', function (e) {
    if (e.target === modalOverlay) {
      closeProjectModal();
    }
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && modalOverlay?.classList.contains('open')) {
      closeProjectModal();
    }
  });

  // 6. Active Nav Link on Scroll Spy
  const sections = document.querySelectorAll('section[id]');
  window.addEventListener('scroll', function () {
    const scrollY = window.pageYOffset;
    sections.forEach(current => {
      const sectionHeight = current.offsetHeight;
      const sectionTop = current.offsetTop - 120;
      const sectionId = current.getAttribute('id');
      const targetNav = document.querySelector(`.nav-menu a[href*="#${sectionId}"]`);

      if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
        document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
        targetNav?.classList.add('active');
      }
    });
  });

  // 7. Back to Top Button
  const backToTopBtn = document.getElementById('back-to-top');
  backToTopBtn?.addEventListener('click', function () {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
});

