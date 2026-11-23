const header = document.querySelector('[data-header]');
const nav = document.querySelector('[data-nav]');
const menuToggle = document.querySelector('[data-menu-toggle]');
const year = document.querySelector('[data-year]');

if (year) year.textContent = new Date().getFullYear();

const updateHeader = () => {
  if (header) header.classList.toggle('is-scrolled', window.scrollY > 24);
};

updateHeader();
window.addEventListener('scroll', updateHeader, { passive: true });

// Modo día / noche
const themeToggle = document.querySelector('[data-theme-toggle]');
const root = document.documentElement;
const systemLight = window.matchMedia ? window.matchMedia('(prefers-color-scheme: light)') : null;

const readStoredTheme = () => {
  try {
    return localStorage.getItem('theme');
  } catch (e) {
    return null;
  }
};

const applyTheme = (theme) => {
  root.setAttribute('data-theme', theme);
  if (themeToggle) {
    themeToggle.setAttribute('aria-label', theme === 'light' ? 'Cambiar a modo noche' : 'Cambiar a modo día');
  }
};

applyTheme(root.getAttribute('data-theme') === 'light' ? 'light' : 'dark');

const reducedMotion = window.matchMedia ? window.matchMedia('(prefers-reduced-motion: reduce)') : null;

if (themeToggle) {
  themeToggle.addEventListener('click', () => {
    const next = root.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
    try {
      localStorage.setItem('theme', next);
    } catch (e) {
      // Sin almacenamiento: el cambio dura solo esta visita.
    }

    // Sin soporte de View Transitions o con movimiento reducido: cambio directo.
    if (!document.startViewTransition || (reducedMotion && reducedMotion.matches)) {
      applyTheme(next);
      return;
    }

    // El modo nuevo se expande en círculo desde el botón.
    const rect = themeToggle.getBoundingClientRect();
    const x = rect.left + rect.width / 2;
    const y = rect.top + rect.height / 2;
    const radius = Math.hypot(Math.max(x, window.innerWidth - x), Math.max(y, window.innerHeight - y));
    const transition = document.startViewTransition(() => applyTheme(next));

    transition.ready
      .then(() => {
        root.animate(
          { clipPath: [`circle(0px at ${x}px ${y}px)`, `circle(${radius}px at ${x}px ${y}px)`] },
          { duration: 550, easing: 'cubic-bezier(0.16, 1, 0.3, 1)', pseudoElement: '::view-transition-new(root)' }
        );
      })
      .catch(() => {});
  });
}

// Pausar los bucles de la portada cuando sale de la pantalla
const hero = document.querySelector('.hero');

if (hero && 'IntersectionObserver' in window) {
  new IntersectionObserver(([entry]) => {
    hero.classList.toggle('is-paused', !entry.isIntersecting);
  }).observe(hero);
}

// Si el visitante no eligió un modo, seguir el del sistema cuando cambie
if (systemLight && systemLight.addEventListener) {
  systemLight.addEventListener('change', (e) => {
    const stored = readStoredTheme();
    if (stored !== 'light' && stored !== 'dark') applyTheme(e.matches ? 'light' : 'dark');
  });
}

// Menú móvil
const setMenu = (open) => {
  if (!menuToggle || !nav) return;
  nav.classList.toggle('is-open', open);
  menuToggle.setAttribute('aria-expanded', String(open));
  menuToggle.setAttribute('aria-label', open ? 'Cerrar menú' : 'Abrir menú');
};

if (menuToggle && nav) {
  menuToggle.addEventListener('click', () => setMenu(!nav.classList.contains('is-open')));

  nav.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => setMenu(false));
  });

  document.addEventListener('click', (e) => {
    if (nav.classList.contains('is-open') && !nav.contains(e.target) && !menuToggle.contains(e.target)) {
      setMenu(false);
    }
  });
}

// Aparición al hacer scroll
if ('IntersectionObserver' in window) {
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.16 }
  );

  document.querySelectorAll('.reveal').forEach((element) => observer.observe(element));
}

// Modal de detalle de proyectos
const modal = document.querySelector('[data-project-modal]');
const modalBox = modal ? modal.querySelector('[role="dialog"]') : null;
const modalMedia = modal ? modal.querySelector('[data-project-media]') : null;
const modalImage = document.getElementById('pm-image');
const modalCategory = document.getElementById('pm-category');
const modalTitle = document.getElementById('pm-title');
const modalDescription = document.getElementById('pm-description');
let lastTrigger = null;

const focusableIn = (root) =>
  [...root.querySelectorAll('a[href], button:not([disabled]), input, textarea, select, [tabindex]:not([tabindex="-1"])')]
    .filter((el) => !el.hidden && el.offsetParent !== null);

const openProjectModal = (card, trigger) => {
  if (!modal) return;
  const image = card.dataset.image || '';

  modalMedia.hidden = !image;
  if (image) {
    modalImage.src = image;
  } else {
    modalImage.removeAttribute('src');
  }
  modalCategory.textContent = card.dataset.category || '';
  modalTitle.textContent = card.dataset.title || '';
  modalDescription.textContent = card.dataset.description || '';

  lastTrigger = trigger || card.querySelector('[data-project-open]');
  modal.classList.add('active');
  modal.setAttribute('aria-hidden', 'false');
  document.body.style.overflow = 'hidden';
  modal.querySelector('[data-project-close]').focus();
};

const closeProjectModal = () => {
  if (!modal || !modal.classList.contains('active')) return;
  modal.classList.remove('active');
  modal.setAttribute('aria-hidden', 'true');
  document.body.style.overflow = '';
  if (lastTrigger) lastTrigger.focus();
  lastTrigger = null;
};

document.addEventListener('click', (e) => {
  if (e.target.closest('[data-project-close]') || e.target === modal) {
    closeProjectModal();
    return;
  }

  const card = e.target.closest('[data-project-card]');
  if (card && !e.target.closest('a')) {
    openProjectModal(card, e.target.closest('[data-project-open]'));
  }
});

document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    if (modal && modal.classList.contains('active')) {
      closeProjectModal();
    } else if (nav && nav.classList.contains('is-open')) {
      setMenu(false);
      menuToggle.focus();
    }
    return;
  }

  // Mantener el foco dentro del modal abierto
  if (e.key === 'Tab' && modal && modal.classList.contains('active')) {
    const items = focusableIn(modalBox);
    if (!items.length) return;
    const first = items[0];
    const last = items[items.length - 1];
    if (e.shiftKey && document.activeElement === first) {
      e.preventDefault();
      last.focus();
    } else if (!e.shiftKey && document.activeElement === last) {
      e.preventDefault();
      first.focus();
    }
  }
});

// Formulario de contacto: estado de envío y evitar doble envío
const contactForm = document.querySelector('[data-contact-form]');

if (contactForm) {
  contactForm.addEventListener('submit', () => {
    const submit = contactForm.querySelector('[data-submit]');
    if (!submit) return;
    submit.disabled = true;
    submit.setAttribute('aria-busy', 'true');
    submit.dataset.idleLabel = submit.textContent;
    submit.textContent = submit.dataset.sendingLabel || 'Enviando…';
  });

  // Si el navegador restaura la página desde caché (botón Atrás), reactivar el botón
  window.addEventListener('pageshow', (e) => {
    const submit = contactForm.querySelector('[data-submit]');
    if (!e.persisted || !submit || !submit.dataset.idleLabel) return;
    submit.disabled = false;
    submit.removeAttribute('aria-busy');
    submit.textContent = submit.dataset.idleLabel;
  });
}

// Tras enviar (éxito o error) llevar al usuario al aviso del formulario
const formNotice = document.querySelector('[data-focus-on-load]');

if (formNotice) {
  formNotice.focus({ preventScroll: true });
  formNotice.scrollIntoView({ block: 'center' });
}
