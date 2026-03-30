# DesarrolloTuWeb | Boutique Web Development

## Project Structure

```
DesarrolloTuWeb - landing/
├── index.html                     # Main landing page
├── script.js                      # Tailwind config + JavaScript logic
├── styles.css                     # Utility styles
├── logo.svg                       # Brand logo
├── style.min.css                  # Minified CSS (production)
├── script.min.js                  # Minified JavaScript (production)
├── sitemap.xml                    # SEO sitemap
├── robots.txt                     # Search engine rules
├── .htaccess                      # Apache configuration
│
├── backend/                       # PHP backend (DO NOT modify path)
│   ├── config.php                 # Environment & security config
│   ├── minify.php                 # Asset minification utilities
│   ├── contact-handler.php        # Form submission endpoint
│   ├── build.php                  # Minification build script
│   └── README.md                  # Backend documentation
│
├── logs/                          # Form submission logs (auto-created)
│   └── forms.log                  # Submission records
│
├── PLAN_IMPLEMENTACION.md         # Project roadmap
├── DESIGN.md                      # Design system documentation
└── README.md                      # This file
```

## Quick Start

### Development Mode

1. **No build required** - use assets as-is
   - `styles.css` loads unminified for debugging
   - `script.js` contains full Tailwind configuration
   - Browser console shows helpful error messages

2. **Test locally:**
   ```bash
   # Python 3
   python -m http.server 8000
   
   # Node.js
   npx http-server
   
   # PHP
   php -S localhost:8000
   ```

3. **Access in browser:**
   ```
   http://localhost:8000
   ```

4. **Test forms:**
   - Click "Empezá tu Proyecto" button → Opens project modal
   - Click "Cotizar" button → Opens pricing modal
   - Contact section at bottom with form validation

### Production Build

When ready to deploy:

```bash
# Set production environment
set APP_ENV=production    # Windows
export APP_ENV=production # Linux/Mac

# Generate minified assets
php backend/build.php
```

This creates:
- `styles.min.css` (~30-50% smaller)
- `script.min.js` (~20-40% smaller)

Then update `index.html` references:
```html
<!-- Change from: -->
<link href="styles.css" rel="stylesheet" />
<script src="script.js"></script>

<!-- To: -->
<link href="styles.min.css" rel="stylesheet" />
<script src="script.min.js"></script>
```

## Features Implemented

### Frontend
✅ Responsive design with Tailwind CSS  
✅ Professional logo (SVG) in nav & footer  
✅ Enhanced SEO metadata in `<head>`  
✅ "Empezá tu Proyecto" modal with form  
✅ "Cotizar" pricing modal (3 tiers)  
✅ Form validation (client-side)  
✅ Smooth animations & transitions  
✅ Dark mode support  

### Backend
✅ PHP form handler with validation  
✅ CSS & JS minification pipeline  
✅ Development vs Production modes  
✅ Form submission logging  
✅ XSS & CSRF protection  
✅ Email integration framework (ready)  
✅ reCAPTCHA v3 preparation  

### SEO
✅ Professional `<head>` with meta tags  
✅ Open Graph tags for social sharing  
✅ Twitter Card tags  
✅ Canonical URL  
✅ Favicon setup  
✅ `sitemap.xml` for search engines  
✅ `robots.txt` with crawl rules  
✅ `.htaccess` with security headers  

## API Endpoints

### Contact Form Handler
```
POST /backend/contact-handler.php
```

**Request (from "Empezá tu Proyecto" modal):**
```javascript
fetch('backend/contact-handler.php', {
    method: 'POST',
    body: new FormData(formElement),
    headers: {
        'X-Form-Type': 'project'
    }
})
```

**Request (from contact section):**
```javascript
fetch('backend/contact-handler.php', {
    method: 'POST',
    body: new FormData(formElement),
    headers: {
        'X-Form-Type': 'contact'
    }
})
```

**Response:**
```json
{
    "success": true,
    "message": "Mensaje recibido correctamente",
    "timestamp": "2026-03-25 14:30:00"
}
```

## Form Validation Rules

### Project Form
- **Nombre:** 3-100 characters, letters only
- **Email:** Valid email format
- **Descripción:** 10-5000 characters
- **Presupuesto:** Optional, predefined values

### Contact Form
- **Nombre:** 3-100 characters
- **Email:** Valid email format
- **Mensaje:** 10-5000 characters

## Configuration

Edit `backend/config.php` to customize:

```php
// Email settings
define('SITE_EMAIL', 'proyectos@desarrollotuweb.com');
define('SITE_NAME', 'DesarrolloTuWeb');
define('SUPPORT_EMAIL', 'soporte@desarrollotuweb.com');

// CORS (development vs production)
define('ALLOWED_ORIGINS', [
    'https://desarrollotuweb.com',
    'http://localhost',
    'http://localhost:3000'
]);

// Logging
define('LOG_SUBMISSIONS', true);
define('LOG_FILE', LOGS_PATH . 'forms.log');
```

## Browser Support

Tested and working on:
- ✅ Chrome 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+
- ✅ Mobile browsers (iOS Safari, Chrome Mobile)

## Performance Metrics

**Unminified (Development):**
- CSS: ~5-8 KB
- JS: ~12-15 KB
- Total: ~17-23 KB

**Minified (Production):**
- CSS: ~2-4 KB
- JS: ~7-10 KB
- Total: ~9-14 KB

**Reduction:** ~40-50% smaller footprint

## Next Steps / Future Enhancements

### Immediate
- [ ] Enable email sending (choose service: SMTP, Sendgrid, Mailgun)
- [ ] Configure reCAPTCHA v3
- [ ] Set up HTTPS/SSL certificate
- [ ] Deploy to production server

### Short Term
- [ ] Add admin dashboard for viewing submissions
- [ ] Implement email templates
- [ ] Add analytics tracking (Google Tag Manager)
- [ ] Set up automated backups

### Long Term
- [ ] Database for submissions (MySQL/PostgreSQL)
- [ ] CMS for blog/case studies
- [ ] Client portal for project tracking
- [ ] API for third-party integrations

## Troubleshooting

### Forms Not Submitting
1. Check browser console (F12) for JavaScript errors
2. Verify `backend/contact-handler.php` file exists
3. Check network tab for response status
4. Ensure form field names match validation rules

### Minified Files Not Generating
1. Verify `APP_ENV` is set correctly
2. Run: `php backend/build.php` directly
3. Check file permissions on root directory
4. Verify PHP version is 7.0 or higher

### Email Not Sending (after setup)
1. Check PHP `mail()` function is enabled
2. Verify email configuration in `config.php`
3. Check server mail logs
4. Consider using SMTP service instead

## Support & Maintenance

- **Backend Questions:** See `backend/README.md`
- **Design System:** See `DESIGN.md`  
- **Implementation Plan:** See `PLAN_IMPLEMENTACION.md`

---

**Project Type:** Boutique Web Development Landing Page  
**Created:** 2024  
**Updated:** March 2026  
**Version:** 2.0 (Backend + Enhanced Frontend)  
**Developers:** Nicolás & Martín
