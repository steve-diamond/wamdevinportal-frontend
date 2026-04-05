<?php
/**
 * WAMDEVIN Database Configuration
 * 
 * Database Connection Setup for Portal System
 * Version: 2.0
 * Date: February 20, 2026
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'wamdevin_portal');
define('DB_PORT', 3306);

// Application Settings
define('APP_TIMEZONE', 'Africa/Lagos');
define('SESSION_TIMEOUT_ADMIN', 3600);           // 1 hour in seconds
define('SESSION_TIMEOUT_MEMBER', 7200);          // 2 hours in seconds
define('PASSWORD_MIN_LENGTH', 8);
define('PASSWORD_HASH_ALGO', PASSWORD_BCRYPT);

// Email Settings - Configure for your email service
define('MAIL_FROM', 'noreply@wamdevin.org');
define('MAIL_FROM_NAME', 'WAMDEVIN Portal System');

// Mailtrap Settings (Testing Environment)
// Sign up free: https://mailtrap.io/
// Copy credentials from Mailtrap Settings → SMTP Credentials
define('SMTP_HOST', 'live.smtp.mailtrap.io');   // Mailtrap live domain
define('SMTP_PORT', 587);                        // TLS port (or 25 for non-TLS)
define('SMTP_USER', '');                         // Paste API token from Mailtrap
define('SMTP_PASS', '');                         // Paste API token from Mailtrap (same as user for live)

// Email Features
define('EMAIL_VERIFICATION_REQUIRED', true);     // Require email before login
define('EMAIL_VERIFICATION_TIMEOUT', 86400);    // 24 hours in seconds
define('PASSWORD_RESET_TIMEOUT', 3600);         // 1 hour in seconds
define('ENABLE_EMAIL_QUEUE', true);             // Queue emails for batch sending
define('EMAIL_QUEUE_BATCH_SIZE', 10);           // Send 10 emails per cron job run

// Alternative: Gmail SMTP (requires setting up App Password)
// define('SMTP_HOST', 'smtp.gmail.com');
// define('SMTP_PORT', 587);
// define('SMTP_USER', 'your-gmail@gmail.com');
// define('SMTP_PASS', 'your-app-password-16-chars');  // From https://myaccount.google.com/apppasswords

// Application Base URLs
define('APP_URL', 'http://localhost/wamdevin');
define('ADMIN_URL', 'http://localhost/wamdevin/admin');

// Set timezone
date_default_timezone_set(APP_TIMEZONE);

// ============================================================================
// DATABASE CONNECTION FUNCTION
// ============================================================================

function getDBConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        
        $pdo = new PDO(
            $dsn,
            DB_USER,
            DB_PASS,
            array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            )
        );
        
        return $pdo;
        
    } catch (PDOException $e) {
        // Log error securely (don't display to users)
        error_log("Database Connection Error: " . $e->getMessage());
        die("Database connection failed. Please contact support.");
    }
}

// ============================================================================
// HELPER FUNCTIONS
// ============================================================================

/**
 * Execute a database query
 * 
 * @param string $query SQL query with placeholders
 * @param array $params Bind parameters
 * @return mixed Query result or false on failure
 */
function executeDatabaseQuery($query, $params = array()) {
    try {
        $db = getDBConnection();
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        error_log("Query Error: " . $e->getMessage());
        return false;
    }
}

/**
 * Get a single record from database
 * 
 * @param string $query SQL query with placeholders
 * @param array $params Bind parameters
 * @return array Record data or null if not found
 */
function getDBRecord($query, $params = array()) {
    $stmt = executeDatabaseQuery($query, $params);
    return $stmt ? $stmt->fetch() : null;
}

/**
 * Get all records from database
 * 
 * @param string $query SQL query with placeholders
 * @param array $params Bind parameters
 * @return array Array of records or empty array
 */
function getDBRecords($query, $params = array()) {
    $stmt = executeDatabaseQuery($query, $params);
    return $stmt ? $stmt->fetchAll() : array();
}

/**
 * Hash a password securely
 * 
 * @param string $password Plain text password
 * @return string Hashed password
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
}

/**
 * Verify a password against its hash
 * 
 * @param string $password Plain text password
 * @param string $hash Password hash from database
 * @return bool True if password matches
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Check if email is valid and unique
 * 
 * @param string $email Email address to check
 * @param string $type 'member' or 'admin'
 * @param int $excludeId Optional ID to exclude (for updates)
 * @return bool True if email is available
 */
function isEmailAvailable($email, $type = 'member', $excludeId = null) {
    try {
        $db = getDBConnection();
        
        if ($type === 'member') {
            $table = 'institution_members';
        } else {
            $table = 'admin_users';
        }
        
        $query = "SELECT id FROM " . $table . " WHERE email = :email";
        $params = array(':email' => strtolower(trim($email)));
        
        if ($excludeId) {
            $query .= " AND id != :id";
            $params[':id'] = $excludeId;
        }
        
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        
        return $stmt->rowCount() === 0;
        
    } catch (PDOException $e) {
        error_log("Email Check Error: " . $e->getMessage());
        return false;
    }
}

/**
 * Sanitize output for HTML display
 * 
 * @param string $data String to sanitize
 * @return string Sanitized string
 */
function sanitize($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/**
 * Validate email format
 * 
 * @param string $email Email to validate
 * @return bool True if valid email format
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate password strength
 * 
 * @param string $password Password to validate
 * @return array Array with 'valid' => bool and 'message' => string
 */
function validatePasswordStrength($password) {
    $response = array(
        'valid' => false,
        'message' => '',
        'strength' => 'weak'
    );
    
    if (strlen($password) < PASSWORD_MIN_LENGTH) {
        $response['message'] = 'Password must be at least ' . PASSWORD_MIN_LENGTH . ' characters';
        return $response;
    }
    
    $hasUpper = preg_match('/[A-Z]/', $password);
    $hasLower = preg_match('/[a-z]/', $password);
    $hasNum = preg_match('/[0-9]/', $password);
    $hasSpecial = preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password);
    
    $strengthCount = $hasUpper + $hasLower + $hasNum + $hasSpecial;
    
    if ($strengthCount >= 3) {
        $response['strength'] = 'strong';
        $response['valid'] = true;
        $response['message'] = 'Password strength: Strong';
    } elseif ($strengthCount >= 2) {
        $response['strength'] = 'medium';
        $response['valid'] = true;
        $response['message'] = 'Password strength: Medium (recommended: add uppercase, numbers, or symbols)';
    } else {
        $response['strength'] = 'weak';
        $response['message'] = 'Password is too weak. Mix uppercase, numbers, and symbols.';
    }
    
    return $response;
}

/**
 * Generate CSRF token for form protection
 * 
 * @return string CSRF token
 */
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 * 
 * @param string $token Token to verify
 * @return bool True if token is valid
 */
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Log user activity for audit trail
 * 
 * @param string $action Action performed
 * @param string $user_type 'member' or 'admin'
 * @param int $user_id User ID
 * @param string $details Additional details
 * @return bool Success or failure
 */
function logActivity($action, $user_type, $user_id, $details = '') {
    try {
        $db = getDBConnection();
        
        $query = "INSERT INTO activity_logs (action, user_type, user_id, details, ip_address, user_agent, created_at) 
                  VALUES (:action, :user_type, :user_id, :details, :ip, :agent, NOW())";
        
        $params = array(
            ':action' => $action,
            ':user_type' => $user_type,
            ':user_id' => $user_id,
            ':details' => $details,
            ':ip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
            ':agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ''
        );
        
        $stmt = $db->prepare($query);
        return $stmt->execute($params);
        
    } catch (PDOException $e) {
        error_log("Activity Log Error: " . $e->getMessage());
        return false;
    }
}

/**
 * Start a secure session
 * 
 * @param string $user_type 'member' or 'admin'
 * @param int $user_id User ID
 * @param string $email User email
 */
function startSecureSession($user_type, $user_id, $email) {
    // Regenerate session ID to prevent fixation
    session_regenerate_id(true);
    
    // Set session data
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_type'] = $user_type;
    $_SESSION['email'] = $email;
    $_SESSION['login_time'] = time();
    $_SESSION['ip_address'] = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
    $_SESSION['user_agent'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    
    // Set session timeout based on user type
    $timeout = ($user_type === 'admin') ? SESSION_TIMEOUT_ADMIN : SESSION_TIMEOUT_MEMBER;
    $_SESSION['session_timeout'] = time() + $timeout;
}

/**
 * Check if session is valid and not expired
 * 
 * @return bool True if session is valid
 */
function isSessionValid() {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        return false;
    }
    
    // Check IP address hasn't changed (security)
    if ($_SESSION['ip_address'] !== (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '')) {
        session_destroy();
        return false;
    }
    
    // Check session timeout
    if (isset($_SESSION['session_timeout']) && time() > $_SESSION['session_timeout']) {
        session_destroy();
        return false;
    }
    
    // Refresh session timeout
    $timeout = ($_SESSION['user_type'] === 'admin') ? SESSION_TIMEOUT_ADMIN : SESSION_TIMEOUT_MEMBER;
    $_SESSION['session_timeout'] = time() + $timeout;
    
    return true;
}

/**
 * Logout user and destroy session
 * 
 * @return void
 */
function logoutUser() {
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
    $user_type = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : 'unknown';
    
    // Log the logout activity
    if ($user_id) {
        logActivity('logout', $user_type, $user_id);
    }
    
    // Destroy session
    session_destroy();
}

?>
