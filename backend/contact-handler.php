<?php
/**
 * Contact Form Handler
 * Validates and processes form submissions
 * Currently logs to file, ready for email integration
 */

require_once 'config.php';
require_once 'minify.php';

class FormHandler {
    
    private static $errors = [];
    private static $data = [];
    
    /**
     * Handle form submission
     */
    public static function processForm() {
        // Get form type
        $formType = $_SERVER['HTTP_X_FORM_TYPE'] ?? 'project';
        
        // Validate CSRF token (basic protection)
        if (IS_PRODUCTION && !self::validateRequest()) {
            return self::error('Solicitud inválida');
        }
        
        // Get form data
        self::$data = $_POST;
        
        // Validate based on form type
        if ($formType === 'contact') {
            self::validateContactForm();
        } else {
            self::validateProjectForm();
        }
        
        // Return errors if validation failed
        if (!empty(self::$errors)) {
            return self::error('Validación fallida: ' . implode(', ', self::$errors));
        }
        
        // Log submission
        self::logSubmission($formType);
        
        // TODO: Send email here when email service is configured
        // self::sendEmail($formType);
        
        return self::success('Mensaje recibido correctamente');
    }
    
    /**
     * Validate contact form
     */
    private static function validateContactForm() {
        self::validateName($_POST['nombre'] ?? '');
        self::validateEmail($_POST['email'] ?? '');
        self::validateMessage($_POST['message'] ?? '');
    }
    
    /**
     * Validate project form
     */
    private static function validateProjectForm() {
        self::validateName($_POST['nombre'] ?? '');
        self::validateEmail($_POST['email'] ?? '');
        self::validateMessage($_POST['descripcion'] ?? '', 'descripción del proyecto', 20);
        
        // Budget is optional
        if (isset($_POST['presupuesto']) && !empty($_POST['presupuesto'])) {
            self::validateBudget($_POST['presupuesto']);
        }
    }
    
    /**
     * Validate name field
     */
    private static function validateName($name) {
        $name = trim($name);
        if (empty($name)) {
            self::$errors[] = 'El nombre es requerido';
        } elseif (strlen($name) < 3) {
            self::$errors[] = 'El nombre debe tener al menos 3 caracteres';
        } elseif (strlen($name) > 100) {
            self::$errors[] = 'El nombre no puede exceder 100 caracteres';
        } elseif (!preg_match('/^[a-záéíóúñ\s\'-]+$/i', $name)) {
            self::$errors[] = 'El nombre contiene caracteres inválidos';
        }
        self::$data['nombre'] = $name;
    }
    
    /**
     * Validate email field
     */
    private static function validateEmail($email) {
        $email = trim(strtolower($email));
        if (empty($email)) {
            self::$errors[] = 'El email es requerido';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            self::$errors[] = 'El email no es válido';
        } elseif (strlen($email) > 254) {
            self::$errors[] = 'El email es demasiado largo';
        }
        self::$data['email'] = $email;
    }
    
    /**
     * Validate message field
     */
    private static function validateMessage($message, $fieldName = 'mensaje', $minLength = 10) {
        $message = trim($message);
        if (empty($message)) {
            self::$errors[] = 'El ' . $fieldName . ' es requerido';
        } elseif (strlen($message) < $minLength) {
            self::$errors[] = 'El ' . $fieldName . ' debe tener al menos ' . $minLength . ' caracteres';
        } elseif (strlen($message) > MAX_MESSAGE_LENGTH) {
            self::$errors[] = 'El ' . $fieldName . ' no puede exceder ' . MAX_MESSAGE_LENGTH . ' caracteres';
        } elseif (self::containsMaliciousContent($message)) {
            self::$errors[] = 'El mensaje contiene contenido no permitido';
        }
        self::$data['message'] = $message;
    }
    
    /**
     * Validate budget field
     */
    private static function validateBudget($budget) {
        $validBudgets = ['100-500', '500-1000', '1000-5000', '5000+'];
        if (!in_array($budget, $validBudgets)) {
            self::$errors[] = 'Presupuesto inválido';
        }
        self::$data['presupuesto'] = $budget;
    }
    
    /**
     * Check for malicious content (basic XSS prevention)
     */
    private static function containsMaliciousContent($text) {
        $dangerous = ['<script', 'javascript:', 'onclick', 'onerror', 'eval('];
        foreach ($dangerous as $pattern) {
            if (stripos($text, $pattern) !== false) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Validate request origin
     */
    private static function validateRequest() {
        // Basic CSRF protection - can be enhanced with tokens
        $origin = $_SERVER['HTTP_ORIGIN'] ?? $_SERVER['HTTP_REFERER'] ?? '';
        $host = $_SERVER['HTTP_HOST'] ?? '';
        
        return (stripos($origin, $host) !== false || stripos($_SERVER['HTTP_REFERER'], $host) !== false);
    }
    
    /**
     * Log form submission
     */
    private static function logSubmission($formType) {
        $timestamp = date('Y-m-d H:i:s');
        $ipAddress = self::getClientIP();
        $logMessage = "[{$timestamp}] Form Type: {$formType} | IP: {$ipAddress} | Data: " . json_encode(self::$data) . "\n";
        
        if (LOG_SUBMISSIONS && IS_DEVELOPMENT) {
            error_log($logMessage, 3, LOG_FILE);
        }
    }
    
    /**
     * Send email (placeholder for future implementation)
     */
    private static function sendEmail($formType) {
        // TODO: Implement email sending when configured
        // Use a proper mail class or mailer library in production
        
        /*
        $subject = $formType === 'contact' ? 'Nuevo mensaje de contacto' : 'Nueva propuesta de proyecto';
        $to = SITE_EMAIL;
        $headers = "From: " . self::$data['email'] . "\r\n";
        $headers .= "Reply-To: " . self::$data['email'] . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        $body = "Nuevo mensaje de " . SITE_NAME . "\n\n";
        $body .= "Nombre: " . self::$data['nombre'] . "\n";
        $body .= "Email: " . self::$data['email'] . "\n";
        $body .= "Mensaje:\n" . self::$data['message'] . "\n";
        
        if (isset(self::$data['presupuesto'])) {
            $body .= "Presupuesto: " . self::$data['presupuesto'] . "\n";
        }
        
        return mail($to, $subject, $body, $headers);
        */
    }
    
    /**
     * Get client IP address
     */
    private static function getClientIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        }
        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : 'invalid';
    }
    
    /**
     * Success response
     */
    private static function success($message = 'Success') {
        echo json_encode([
            'success' => true,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ]);
        exit;
    }
    
    /**
     * Error response
     */
    private static function error($message = 'Error') {
        echo json_encode([
            'success' => false,
            'error' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ]);
        exit;
    }
}

// Process the form
FormHandler::processForm();
?>
