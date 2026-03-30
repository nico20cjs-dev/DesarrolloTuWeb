# DesarrolloTuWeb Backend

## Overview

This backend provides a PHP infrastructure for DesarrolloTuWeb with:
- CSS and JavaScript minification (development & production modes)
- Contact form validation and handling
- Security measures (CSRF protection, input validation, XSS prevention)
- Logging system for form submissions
- Email integration framework (ready for implementation)

## Directory Structure

```
backend/
├── config.php              # Configuration and environment settings
├── minify.php              # Asset minification utilities
├── contact-handler.php     # Form submission handler
├── build.php               # Build script for minification
└── README.md               # This file
```

## Configuration

### Environment Setup

The backend automatically detects the environment. Set `APP_ENV` to control behavior:

**Development Mode (Default)**
```bash
# Windows PowerShell
$env:APP_ENV = "development"
php backend/build.php

# Linux/Mac
export APP_ENV=development
php backend/build.php
```

**Production Mode**
```bash
# Windows PowerShell
$env:APP_ENV = "production"
php backend/build.php

# Linux/Mac
export APP_ENV=production
php backend/build.php
```

### Configuration File (config.php)

Edit `backend/config.php` to customize:
- Email addresses (SITE_EMAIL, SUPPORT_EMAIL)
- Asset paths
- Logging configuration
- CORS allowed origins
- Maximum message length

```php
define('SITE_EMAIL', 'proyectos@desarrollotuweb.com');
define('SUPPORT_EMAIL', 'soporte@desarrollotuweb.com');
define('LOG_SUBMISSIONS', true);
define('ALLOWED_ORIGINS', ['https://desarrollotuweb.com', ...]);
```

## Asset Minification

### Development Workflow

In development, use unminified assets for debugging:

```html
<!-- Development -->
<link href="styles.css" rel="stylesheet" />
<script src="script.js"></script>
```

Assets remain readable and errors are easy to debug.

### Production Build

When deploying to production:

```bash
php backend/build.php
```

This generates:
- `styles.min.css`
- `script.min.js`

Update HTML references to minified files:

```html
<!-- Production -->
<link href="styles.min.css" rel="stylesheet" />
<script src="script.min.js"></script>
```

### Minification Details

**CSS Minification:**
- Removes comments (`/* ... */`)
- Removes unnecessary whitespace
- Removes spaces around special characters
- Reduces file size by ~30-50%

**JavaScript Minification:**
- Removes single-line (`//`) and multi-line (`/* ... */`) comments
- Removes unnecessary whitespace
- Basic variable name optimization possible with UglifyJS
- Reduces file size by ~20-40%

### Build Script Commands

```bash
# Generate minified assets
php backend/build.php

# Watch mode (regenerates on file changes)
php backend/build.php --watch

# Remove minified files
php backend/build.php --clean

# Show build information
php backend/build.php --info
```

## Contact Form Handler

### Usage

The form handler processes submissions from:
1. **Project Inquiry Modal** (modalProyecto)
2. **Contact Section** (contacto form)

### Form Validation

**Implemented Validations:**
- Name: 3-100 characters, letters only
- Email: Valid email format, max 254 characters
- Message: 10-5000 characters
- Budget: Must be one of predefined values
- XSS Prevention: Blocks `<script>`, `javascript:`, `onclick`, etc.
- CSRF Protection: Basic origin validation

### Form Structure

**Project Form (modalProyecto):**
```html
<form id="formProyecto" onsubmit="validarFormProyecto(event)">
    <input name="nombre" type="text" required />
    <input name="email" type="email" required />
    <textarea name="descripcion" required></textarea>
    <select name="presupuesto">...</select>
</form>
```

**Contact Form (contacto):**
```html
<form method="POST">
    <input name="nombre" type="text" required />
    <input name="email" type="email" required />
    <textarea name="message" required></textarea>
</form>
```

### Handling Submissions

JavaScript validates and sends to backend:

```javascript
fetch('backend/contact-handler.php', {
    method: 'POST',
    body: formData,
    headers: { 'X-Form-Type': 'contact' }
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        alert('Mensaje enviado');
    } else {
        alert(data.error);
    }
})
```

### Response Format

**Success:**
```json
{
    "success": true,
    "message": "Mensaje recibido correctamente",
    "timestamp": "2026-03-25 14:30:00"
}
```

**Error:**
```json
{
    "success": false,
    "error": "Validación fallida: El email no es válido",
    "timestamp": "2026-03-25 14:30:00"
}
```

## Logging

Form submissions are logged in development mode to `logs/forms.log`:

```
[2026-03-25 14:30:00] Form Type: project | IP: 192.168.1.1 | Data: {"nombre":"Juan","email":"juan@example.com",...}
```

To disable logging, set in `config.php`:
```php
define('LOG_SUBMISSIONS', false);
```

## Email Integration (Future Implementation)

### Setup Email Service

The contact handler is prepared for email sending. To enable:

1. Choose an email service:
   - Built-in PHP `mail()` (requires server configuration)
   - SMTP service (Sendgrid, Mailgun, AWS SES)
   - PHP email library (PHPMailer, SwiftMailer)

2. Uncomment and implement `sendEmail()` method in `contact-handler.php`:

```php
private static function sendEmail($formType) {
    // Example with PHP mail()
    $subject = $formType === 'contact' ? 'Nuevo mensaje' : 'Nueva propuesta';
    $to = SITE_EMAIL;
    $headers = "From: " . self::$data['email'] . "\r\n";
    
    $body = "Nuevo mensaje:\n";
    $body .= "Nombre: " . self::$data['nombre'] . "\n";
    $body .= "Email: " . self::$data['email'] . "\n";
    $body .= "Mensaje:\n" . self::$data['message'] . "\n";
    
    return mail($to, $subject, $body, $headers);
}
```

3. Or use a library:

```php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer();
$mail->setFrom(SITE_EMAIL);
$mail->addAddress(SITE_EMAIL);
$mail->Subject = 'Nuevo mensaje';
$mail->Body = '...';
$mail->send();
```

## Security Best Practices

### Current Protections
- ✅ Input validation (length, type, format)
- ✅ XSS prevention (malicious content blocking)
- ✅ CSRF basic protection (origin validation)
- ✅ No SQL injection risk (no database usage)
- ✅ Response header security (X-Content-Type-Options, etc.)

### Recommended Enhancements

1. **Rate Limiting:** Prevent spam
```php
// Add Redis or file-based rate limiting
if (!rateLimitCheck($_SERVER['REMOTE_ADDR'])) {
    return error('Too many requests');
}
```

2. **reCAPTCHA v3:**  Already prepared in frontend
```javascript
// Backend will receive token
if (!validateRecaptcha($token)) {
    return error('reCAPTCHA validation failed');
}
```

3. **Email Verification:** Send confirmation emails
4. **Content Security Policy:** Configure in `.htaccess`

## File Permissions

For production, set proper permissions:

```bash
# Development
chmod 755 backend/
chmod 755 logs/
chmod 644 *.php *.html

# Production  
chmod 750 backend/
chmod 750 logs/
chmod 644 contact-handler.php
chmod 000 config.php  # Only readable by PHP
```

## Troubleshooting

### Build Script Not Working

1. Check PHP version (requires 7.0+):
```bash
php -v
```

2. Verify file permissions:
```bash
ls -la backend/
```

3. Run with error output:
```bash
php backend/build.php 2>&1
```

### Forms Not Submitting

1. Check browser console for JavaScript errors
2. Verify form field names match backend validation
3. Check that `backend/contact-handler.php` is accessible
4. Verify CORS settings in `config.php` (development mode)

### Email Not Sending

1. Verify `mail()` function is enabled: `php -i | grep sendmail`
2. Check server mail configuration
3. Implement alternative mail service when ready

## Deployment Checklist

- [ ] Set `APP_ENV=production`
- [ ] Run `php backend/build.php` to generate minified assets
- [ ] Update HTML to use `*.min.css` and `*.min.js`
- [ ] Configure `.htaccess` for HTTPS redirect
- [ ] Update `ALLOWED_ORIGINS` in config.php
- [ ] Test all form submissions
- [ ] Set up email service and uncomment `sendEmail()`
- [ ] Enable reCAPTCHA v3 in frontend
- [ ] Set proper file permissions
- [ ] Test in production environment
- [ ] Monitor logs for form submissions

## Support

For questions or issues with the backend infrastructure, refer to the inline code comments or contact the development team.

---

**Last Updated:** 2026-03-25  
**Version:** 1.0.0
