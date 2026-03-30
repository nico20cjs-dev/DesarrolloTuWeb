# DesarrolloTuWeb - Quick Reference Card

## 🚀 QUICK START

### Development
```bash
# Serve locally (pick one)
python -m http.server 8000
php -S localhost:8000
npx http-server

# Access
http://localhost:8000
```

### Production Build
```bash
set APP_ENV=production          # Windows
export APP_ENV=production       # Linux/Mac

php backend/build.php
```

---

## 📂 KEY FILES

| File | Purpose | Notes |
|------|---------|-------|
| `index.html` | Main landing page | Contains modals & forms |
| `script.js` | Tailwind config + JS logic | Updated with modal functions |
| `styles.css` | Custom utility styles | 3 utility rules |
| `logo.svg` | Brand logo | Used in nav & footer |
| `backend/config.php` | Configuration | Development/production modes |
| `backend/contact-handler.php` | Form handler | Validates & processes submissions |
| `backend/build.php` | Build script | Generates minified assets |
| `sitemap.xml` | SEO sitemap | For search engines |
| `robots.txt` | Crawler rules | Block bad bots, allow good ones |
| `.htaccess` | Apache config | Security & caching headers |

---

## 🔧 BUILD COMMANDS

```bash
# Generate minified CSS & JS
php backend/build.php

# Watch files (regenerate on changes)
php backend/build.php --watch

# Show info & file sizes
php backend/build.php --info

# Remove minified files
php backend/build.php --clean
```

---

## 📋 FORM VALIDATION RULES

### Project Form (Modal)
```
Nombre:       3-100 chars, letters only (required)
Email:        Valid format (required)
Descripción:  10-5000 chars (required)
Presupuesto:  One of: 100-500, 500-1000, 1000-5000, 5000+ (optional)
```

### Contact Form (Footer)
```
Nombre:       3-100 chars (required)
Email:        Valid format (required)
Mensaje:      10-5000 chars (required)
```

---

## 🔐 SECURITY NOTES

- ✅ XSS prevention enabled
- ✅ CSRF basic protection
- ✅ Input validation enforced
- ✅ Backend files protected via .htaccess
- ✅ Logs directory protected
- ⚠️ Email sending: Not yet configured (ready for integration)
- ⚠️ reCAPTCHA v3: Framework ready, needs API keys

---

## 📊 MODAL FUNCTIONS

### Open Project Modal
```javascript
abrirModalProyecto();
```

### Open Pricing Modal  
```javascript
abrirModalCotizar();
```

### Close Project Modal
```javascript
cerrarModalProyecto();
```

### Close Pricing Modal
```javascript
cerrarModalCotizar();
```

### Select Plan
```javascript
seleccionarPlan('Empresarial', 300);
```

---

## 🌐 API ENDPOINT

### Form Submission
```
POST /backend/contact-handler.php

Request Headers:
X-Form-Type: project          # or: contact

Response:
{
  "success": true,
  "message": "Mensaje recibido correctamente",
  "timestamp": "2026-03-25 14:30:00"
}
```

---

## 📱 BROWSER SUPPORT

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile: iOS Safari, Chrome Mobile

---

## 📊 PERFORMANCE TARGET

| Asset | Dev Size | Min Size | Reduction |
|-------|----------|----------|-----------|
| CSS | 5-8 KB | 2-4 KB | ~40% |
| JS | 12-15 KB | 7-10 KB | ~40% |
| **Total** | **17-23 KB** | **9-14 KB** | **~40-50%** |

---

## ⚙️ ENVIRONMENT VARIABLES

```bash
APP_ENV = development    # Default (unminified assets)
APP_ENV = production     # Minified assets, limited errors
```

---

## 🔗 INTERNAL LINKS

| Link | Behavior |
|------|----------|
| Nav "Inicio" | Scrolls to #inicio |
| Nav "Nosotros" | Scrolls to #nosotros |
| Nav "Servicios" | Scrolls to #servicios |
| Nav "Portafolio" | Scrolls to #portafolio |
| Nav "Contacto" | Scrolls to #contacto |
| "Ver Portafolio" button | Scrolls to #portafolio |
| Logo | Scrolls to #inicio |
| "Empezá tu Proyecto" | Opens project modal |
| "Cotizar" nav | Opens pricing modal |
| "Cotizar" plan button | Opens project modal |

---

## 📞 FORM SUBMISSION FLOW

1. User fills form + validates
2. JavaScript prevents default submission
3. Fetch POST to `backend/contact-handler.php`
4. Backend validates again (server-side)
5. Backend logs submission to `logs/forms.log`
6. Response: `{success: true/false}`
7. Frontend shows alert & resets form

---

## 🚨 COMMON ISSUES & FIXES

### Forms not submitting?
```
✓ Check browser console (F12)
✓ Verify backend/contact-handler.php exists
✓ Check network tab for response status
✓ Ensure form field names match validation
```

### Minified files not generating?
```
✓ Check: php --version (need 7.0+)
✓ Run: php backend/build.php 2>&1 (show errors)
✓ Check: File permissions on root directory
✓ Verify: APP_ENV is set before running
```

### Email not sending?
```
✓ Email sending not configured yet
✓ See: backend/README.md for setup instructions
✓ Choose service: SMTP / Sendgrid / Mailgun
✓ Uncomment: sendEmail() in contact-handler.php
```

---

## 📚 DOCUMENTATION FILES

| File | Contains |
|------|----------|
| `README.md` | Project overview, quick start |
| `backend/README.md` | Complete backend documentation |
| `IMPLEMENTATION_SUMMARY.md` | Detailed feature list |
| `DESIGN.md` | Design system, tokens |
| `PLAN_IMPLEMENTACION.md` | Original requirements |

---

## ✅ DEPLOYMENT CHECKLIST

```
□ Set APP_ENV=production
□ Run: php backend/build.php
□ Update HTML: styles.css → styles.min.css
□ Update HTML: script.js → script.min.js
□ Configure ALLOWED_ORIGINS in config.php
□ Set up email service
□ Enable reCAPTCHA v3
□ Configure HTTPS in .htaccess
□ Set file permissions (755/644)
□ Test all forms
□ Monitor logs/forms.log
```

---

## 🔗 EXTERNAL RESOURCES

- **Tailwind CSS:** Already loaded via CDN
- **Google Fonts:** Manrope, Inter, Material Symbols
- **reCAPTCHA v3:** Ready to configure (need API keys)

---

## 💡 TIPS & TRICKS

```javascript
// Open modal programmatically
abrirModalProyecto();

// Check environment
console.log(document.querySelector('body').classList);

// View form logs
cat logs/forms.log      # Linux/Mac
type logs\forms.log     # Windows

// Quick minification test
php backend/build.php --info
```

---

**Last Updated:** March 25, 2026  
**Version:** 2.0  
**Status:** ✅ Production Ready
