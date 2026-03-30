<?php
/**
 * Configuration file for DesarrolloTuWeb
 * Handles development vs production environment settings
 */

// Determine environment (dev by default)
define('ENVIRONMENT', getenv('APP_ENV') ?: 'development');
define('IS_PRODUCTION', ENVIRONMENT === 'production');
define('IS_DEVELOPMENT', !IS_PRODUCTION);

// Base paths
define('ROOT_PATH', dirname(dirname(__FILE__)) . '/');
define('BACKEND_PATH', ROOT_PATH . 'backend/');
define('PUBLIC_PATH', ROOT_PATH . 'public/');
define('LOGS_PATH', ROOT_PATH . 'logs/');

// Asset paths
define('CSS_PATH', ROOT_PATH . 'styles.css');
define('CSS_MIN_PATH', ROOT_PATH . 'styles.min.css');
define('JS_PATH', ROOT_PATH . 'script.js');
define('JS_MIN_PATH', ROOT_PATH . 'script.min.js');

// Email configuration (prepared for future implementation)
define('SITE_EMAIL', 'info.desarrollotuweb@gmail.com');
define('SITE_NAME', 'DesarrolloTuWeb');
define('SUPPORT_EMAIL', 'info.desarrollotuweb@gmail.com');

// CORS and security
define('ALLOWED_ORIGINS', ['https://desarrollotuweb.com', 'http://localhost', 'http://localhost:3000', 'http://127.0.0.1:5500']);
define('MAX_MESSAGE_LENGTH', 5000);
define('MIN_MESSAGE_LENGTH', 10);

// Logging
define('LOG_FILE', LOGS_PATH . 'forms.log');
define('LOG_SUBMISSIONS', true);

// Error handling
if (IS_DEVELOPMENT) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Ensure logs directory exists
if (!is_dir(LOGS_PATH)) {
    mkdir(LOGS_PATH, 0755, true);
}

// Set response headers
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');

// CORS headers
if (IS_DEVELOPMENT) {
    header('Access-Control-Allow-Origin: *');
} else {
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
    if (in_array($origin, ALLOWED_ORIGINS)) {
        header('Access-Control-Allow-Origin: ' . $origin);
    }
}

header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
?>
