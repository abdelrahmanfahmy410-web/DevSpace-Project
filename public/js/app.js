
  // Mobile nav toggle
  const toggle = document.getElementById('mobileToggle');
  const links  = document.getElementById('navLinks');
  toggle.addEventListener('click', () => {
    toggle.classList.toggle('is-open');
    links.classList.toggle('is-open');
  });

  // Filter pills
  document.querySelectorAll('.btn-pill').forEach(btn => {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.btn-pill').forEach(b => b.classList.remove('is-active'));
      this.classList.add('is-active');
    });
  });

  // Scroll reveal animation
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });

  document.querySelectorAll('.project-card, .step-card, .mentor-card, .testimonial-card').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
    observer.observe(el);
  });
