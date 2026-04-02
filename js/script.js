tailwind.config = {
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                "surface-container-high": "#e6ebf0",
                "primary": "#006da4",
                "on-surface-variant": "#414754",
                "on-secondary-fixed": "#03273c",
                "surface-container": "#edf1f5",
                "on-primary": "#ffffff",
                "on-primary-container": "#fefcff",
                "surface-variant": "#e0e3e5",
                "primary-fixed-dim": "#adc7ff",
                "on-tertiary-container": "#fffbff",
                "secondary-container": "#a4c1ff",
                "on-error-container": "#93000a",
                "on-tertiary": "#ffffff",
                "outline": "#717786",
                "on-background": "#051720",
                "error": "#ba1a1a",
                "tertiary": "#9e3d00",
                "on-primary-fixed": "#003554",
                "surface-container-low": "#f4f7f9",
                "secondary-fixed-dim": "#adc7ff",
                "on-tertiary-fixed-variant": "#7c2e00",
                "tertiary-fixed-dim": "#ffb695",
                "secondary-fixed": "#d8e2ff",
                "on-secondary-fixed-variant": "#004d74",
                "background": "#f0f4f8",
                "surface-container-lowest": "#ffffff",
                "on-tertiary-fixed": "#351000",
                "on-surface": "#051720",
                "inverse-primary": "#adc7ff",
                "on-secondary-container": "#03273c",
                "primary-fixed": "#d8e2ff",
                "surface-dim": "#d8dadc",
                "on-error": "#ffffff",
                "primary-container": "#004d74",
                "surface-tint": "#006da4",
                "tertiary-container": "#c64f00",
                "error-container": "#ffdad6",
                "surface": "#ffffff",
                "outline-variant": "#c1c6d7",
                "on-primary-fixed-variant": "#003554",
                "inverse-surface": "#051720",
                "surface-bright": "#ffffff",
                "on-secondary": "#ffffff",
                "inverse-on-surface": "#eff1f3",
                "secondary": "#004d74",
                "surface-container-highest": "#dfe4ea",
                "tertiary-fixed": "#ffdbcc"
            },
            fontFamily: {
                "headline": ["Manrope"],
                "body": ["Inter"],
                "label": ["Inter"]
            },
            borderRadius: { "full": "9999px" },
        },
    },
};

// ===== MODAL FUNCTIONS =====
function abrirModalProyecto() {
    document.getElementById('modalProyecto').classList.remove('hidden');
}

function cerrarModalProyecto() {
    document.getElementById('modalProyecto').classList.add('hidden');
}

function abrirModalCotizar() {
    document.getElementById('modalCotizar').classList.remove('hidden');
}

function cerrarModalCotizar() {
    document.getElementById('modalCotizar').classList.add('hidden');
}

function abrirModalContacto() {
    cerrarModalCotizar();
    abrirModalProyecto();
}

// ===== FORM VALIDATION =====
function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function validarFormProyecto(event) {
    event.preventDefault();
    
    const form = event.target;
    const nombre = form.nombre.value.trim();
    const email = form.email.value.trim();
    const descripcion = form.descripcion.value.trim();
    
    // Validación básica
    if (!nombre || nombre.length < 3) {
        alert('Por favor ingresa un nombre válido (mínimo 3 caracteres).');
        return;
    }
    
    if (!email || !validarEmail(email)) {
        alert('Por favor ingresa un email válido.');
        return;
    }
    
    if (!descripcion || descripcion.length < 10) {
        alert('Por favor describe brevemente tu proyecto (mínimo 10 caracteres).');
        return;
    }
    
    // Enviar formulario al servidor
    enviarFormProyecto(form);
}

function enviarFormProyecto(form) {
    const formData = new FormData(form);
    
    fetch('backend/contact-handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('¡Propuesta enviada! Te contactaremos pronto.');
            form.reset();
            cerrarModalProyecto();
        } else {
            alert('Error al enviar. Por favor intenta nuevamente.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error de conexión. Por favor intenta nuevamente.');
    });
}

// ===== CONTACT FORM VALIDATION (Footer) =====
document.addEventListener('DOMContentLoaded', function() {
    // Contact form handler
    const contactForm = document.querySelector('#contacto form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            validarFormContacto(this);
        });
    }
    
    // Button click handlers
    document.querySelectorAll('button').forEach(button => {
        const text = button.textContent.trim();
        if (text === 'Empezá tu Proyecto') {
            button.addEventListener('click', abrirModalProyecto);
        } else if (text === 'Cotizar') {
            button.addEventListener('click', abrirModalCotizar);
        }
    });
});

function validarFormContacto(form) {
    const nombre = form.nombre.value.trim();
    const email = form.email.value.trim();
    const mensaje = form.message.value.trim();
    
    let isValid = true;
    
    // Validar cada campo y mostrar errores
    if (!nombre || nombre.length < 3) {
        mostrarError(form.nombre, 'Mínimo 3 caracteres requeridos');
        isValid = false;
    } else {
        limpiarErrorCampo(form.nombre);
    }
    
    if (!email || !validarEmail(email)) {
        mostrarError(form.email, 'Email inválido');
        isValid = false;
    } else {
        limpiarErrorCampo(form.email);
    }
    
    if (!mensaje || mensaje.length < 10) {
        mostrarError(form.message, 'Mínimo 10 caracteres requeridos');
        isValid = false;
    } else {
        limpiarErrorCampo(form.message);
    }
    
    if (!isValid) {
        return;
    }
    
    enviarFormContacto(form);
}

function enviarFormContacto(form) {
    const formData = new FormData(form);
    
    fetch('backend/contact-handler.php', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Form-Type': 'contact'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarExito(form, '¡Mensaje enviado! Te responderemos pronto.');
            form.reset();
            limpiarErroresFormulario(form);
        } else {
            alert('Error al enviar. Por favor intenta nuevamente.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error de conexión. Por favor intenta nuevamente.');
    });
}

// ===== FORM VALIDATION WITH INLINE MESSAGES =====
function validarCampoContacto(campo) {
    const nombre = campo.form.nombre.value.trim();
    const email = campo.form.email.value.trim();
    const mensaje = campo.form.message.value.trim();
    
    limpiarErrorCampo(campo);
    
    if (campo.name === 'nombre') {
        if (!nombre || nombre.length < 3) {
            mostrarError(campo, 'Mínimo 3 caracteres requeridos');
            return false;
        }
    } else if (campo.name === 'email') {
        if (!email || !validarEmail(email)) {
            mostrarError(campo, 'Email inválido');
            return false;
        }
    } else if (campo.name === 'message') {
        if (!mensaje || mensaje.length < 10) {
            mostrarError(campo, 'Mínimo 10 caracteres requeridos');
            return false;
        }
    }
    return true;
}

function mostrarError(campo, mensaje) {
    campo.classList.add('!border-red-500', 'focus:!border-red-500', 'focus:!ring-red-500/20', 'error-field');
    
    // remove if exists
    const existente = campo.parentElement.querySelector('.error-message');
    if (existente) existente.remove();
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message text-red-500 text-xs mt-2 font-medium flex items-center gap-1';
    errorDiv.innerHTML = '<span class="material-symbols-outlined text-sm">error</span> ' + mensaje;
    campo.parentElement.appendChild(errorDiv);
}

function limpiarErrorCampo(campo) {
    campo.classList.remove('!border-red-500', 'focus:!border-red-500', 'focus:!ring-red-500/20', 'error-field');
    const errorDiv = campo.parentElement.querySelector('.error-message');
    if (errorDiv) errorDiv.remove();
}

function limpiarErroresFormulario(form) {
    form.querySelectorAll('input, textarea').forEach(campo => {
        limpiarErrorCampo(campo);
    });
}

function mostrarExito(form, mensaje) {
    alert(mensaje);
}

// ===== MOBILE MENU =====
function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const btn = document.getElementById('mobileMenuBtn');
    const isOpen = !menu.classList.contains('hidden');
    if (isOpen) {
        menu.classList.add('hidden');
        btn.querySelector('.material-symbols-outlined').textContent = 'menu';
    } else {
        menu.classList.remove('hidden');
        btn.querySelector('.material-symbols-outlined').textContent = 'close';
    }
}

function closeMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const btn = document.getElementById('mobileMenuBtn');
    if (menu) menu.classList.add('hidden');
    if (btn) btn.querySelector('.material-symbols-outlined').textContent = 'menu';
}

function abrirModalTerminos() {
    document.getElementById('modalTerminos').classList.remove('hidden');
}

// ===== PLAN SELECTION =====
function seleccionarPlan(planName, price) {
    console.log('Plan seleccionado:', planName, 'Precio: $' + price);
    alert('Plan ' + planName + ' seleccionado. Te contactaremos para más detalles.');
    cerrarModalCotizar();
}

// ===== DARK MODE TOGGLE =====
function toggleDarkMode() {
    const html = document.documentElement;
    const isDark = html.classList.contains('dark');
    
    if (isDark) {
        html.classList.remove('dark');
        html.classList.add('light');
        localStorage.setItem('theme', 'light');
    } else {
        html.classList.add('dark');
        html.classList.remove('light');
        localStorage.setItem('theme', 'dark');
    }
    
    // Trigger a custom event for any third-party integrations
    window.dispatchEvent(new CustomEvent('themeChange', { detail: { isDark: !isDark } }));
}

// Initialize dark mode from localStorage and setup click-outside handlers
document.addEventListener('DOMContentLoaded', function() {
    // Dark mode initialization with OS preference fallback
    const savedTheme = localStorage.getItem('theme');
    const systemPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isDarkTheme = savedTheme === 'dark' || (!savedTheme && systemPrefersDark);
    
    const html = document.documentElement;
    
    if (isDarkTheme) {
        html.classList.add('dark');
        html.classList.remove('light');
    } else {
        html.classList.add('light');
        html.classList.remove('dark');
    }
    
    // Click outside modal handlers
    const modals = ['modalProyecto', 'modalCotizar', 'modalTerminos'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.addEventListener('click', function(event) {
                // Only close if clicked on the outer container, not the inner content
                if (event.target === this) {
                    this.classList.add('hidden');
                }
            });
        }
    });
    
    // Contact form handler
    const contactForm = document.querySelector('#contacto form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            validarFormContacto(this);
        });
        
        // Add real-time validation feedback
        const inputs = contactForm.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validarCampoContacto(this);
            });
            input.addEventListener('focus', function() {
                limpiarErrorCampo(this);
            });
        });
    }
    
    // Button click handlers
    document.querySelectorAll('button').forEach(button => {
        const text = button.textContent.trim();
        if (text === 'Empezá tu Proyecto') {
            button.addEventListener('click', abrirModalProyecto);
        } else if (text === 'Cotizar') {
            button.addEventListener('click', abrirModalCotizar);
        }
    });

    // Intersection Observer for Navbar Links Active State
    const sections = document.querySelectorAll("section[id]");
    const navLinks = document.querySelectorAll(".nav-link");

    const observerOptions = {
        root: null,
        rootMargin: "0px",
        threshold: 0.3
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.getAttribute("id");
                navLinks.forEach(link => {
                    link.classList.remove("active");
                    if (link.getAttribute("href") === "#" + id) {
                        link.classList.add("active");
                    }
                });
            }
        });
    }, observerOptions);

    sections.forEach(section => {
        observer.observe(section);
    });

    // Close mobile menu on scroll
    window.addEventListener('scroll', () => {
        closeMobileMenu();
    }, { passive: true });

    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
        const menu = document.getElementById('mobileMenu');
        const btn = document.getElementById('mobileMenuBtn');
        if (menu && btn && !menu.classList.contains('hidden')) {
            if (!menu.contains(e.target) && !btn.contains(e.target)) {
                closeMobileMenu();
            }
        }
    });
});


