import './bootstrap';

/* ─────────────────────────────────────────────────────────────
   app.js  –  Digital Future Labs
   Global JavaScript for all pages
───────────────────────────────────────────────────────────── */

document.addEventListener('DOMContentLoaded', () => {

    /* ── Mobile menu toggle ──────────────────────────────────── */
    const menuBtn  = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('open');
            const icon = menuBtn.querySelector('.material-symbols-outlined');
            if (icon) {
                icon.textContent = mobileMenu.classList.contains('open') ? 'close' : 'menu';
            }
        });

        // Close on nav link click
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('open');
                const icon = menuBtn.querySelector('.material-symbols-outlined');
                if (icon) icon.textContent = 'menu';
            });
        });
    }

    /* ── Scroll-spy: active nav link ─────────────────────────── */
    const sections = document.querySelectorAll('section[id]');
    const navLinks  = document.querySelectorAll('.nav-link[href^="#"]');

    const observerOptions = {
        root:       null,
        rootMargin: '-40% 0px -55% 0px',
        threshold:  0,
    };

    const sectionObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${entry.target.id}`) {
                        link.classList.add('active');
                    }
                });
            }
        });
    }, observerOptions);

    sections.forEach(s => sectionObserver.observe(s));

    /* ── Sticky nav shadow on scroll ─────────────────────────── */
    const nav = document.getElementById('main-nav');
    if (nav) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        }, { passive: true });
    }

    /* ── Entrance animations via IntersectionObserver ────────── */
    const animTargets = document.querySelectorAll('[data-animate]');

    if (animTargets.length) {
        const animObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-up');
                    entry.target.style.opacity = '1';
                    animObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        animTargets.forEach(el => {
            el.style.opacity = '0';
            animObserver.observe(el);
        });
    }

    /* ── Counter animation for stats ─────────────────────────── */
    const counters = document.querySelectorAll('[data-counter]');

    if (counters.length) {
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(el => counterObserver.observe(el));
    }

    function animateCounter(el) {
        const raw    = el.textContent.trim();
        const match  = raw.match(/^(\d[\d,]*)([^/\d]*)$/);
        if (!match) return;
        const suffix = match[2];
        const target = parseInt(match[1].replace(/,/g, ''), 10);
        if (isNaN(target)) return;

        const duration = 1600;
        const start    = performance.now();

        const step = (now) => {
            const elapsed  = now - start;
            const progress = Math.min(elapsed / duration, 1);
            const eased    = 1 - Math.pow(1 - progress, 3); // easeOutCubic
            el.textContent = Math.floor(eased * target).toLocaleString() + suffix;
            if (progress < 1) requestAnimationFrame(step);
        };

        requestAnimationFrame(step);
    }

    /* ── Smooth scroll for anchor links ──────────────────────── */
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                const offset = 80; // nav height
                const top    = target.getBoundingClientRect().top + window.scrollY - offset;
                window.scrollTo({ top, behavior: 'smooth' });
            }
        });
    });

    /* ── Contact form (basic client-side feedback) ───────────── */
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = this.querySelector('[type="submit"]');
            const originalText = btn.textContent;
            btn.textContent    = 'Sending…';
            btn.disabled       = true;

            // Replace with real AJAX / Laravel route as needed
            setTimeout(() => {
                btn.textContent = '✓ Message Sent!';
                btn.style.backgroundColor = 'var(--color-green)';
                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.style.backgroundColor = '';
                    btn.disabled = false;
                    contactForm.reset();
                }, 3000);
            }, 1200);
        });
    }

});
