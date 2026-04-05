<?php
// WAMDEVIN - West African Management Development Institute Network
// Professional Authentication System
// Enhanced Security and Access Control

session_start();

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// WAMDEVIN Authentication Configuration
define('WAMDEVIN_AUTH_SECRET', 'wamdevin_2024_secure_key_management_development');
define('WAMDEVIN_SESSION_TIMEOUT', 3600); // 1 hour

// Professional User Credentials (In production, use database)
$wamdevin_users = [
    'admin@wamdevin.org' => [
        'password' => password_hash('WAMDEVIN2024!Admin', PASSWORD_DEFAULT),
        'role' => 'admin',
        'name' => 'WAMDEVIN Administrator',
        'permissions' => ['all']
    ],
    'facilitator@wamdevin.org' => [
        'password' => password_hash('WAMDEVIN2024!Facilitator', PASSWORD_DEFAULT),
        'role' => 'facilitator',
        'name' => 'Professional Facilitator',
        'permissions' => ['courses', 'calendar', 'profile', 'reviews']
    ],
    'coordinator@wamdevin.org' => [
        'password' => password_hash('WAMDEVIN2024!Coordinator', PASSWORD_DEFAULT),
        'role' => 'coordinator',
        'name' => 'Program Coordinator',
        'permissions' => ['courses', 'calendar', 'mailbox', 'bookmarks']
    ]
];

// Authentication Functions
function authenticateUser($email, $password) {
    global $wamdevin_users;
    
    if (isset($wamdevin_users[$email])) {
        if (password_verify($password, $wamdevin_users[$email]['password'])) {
            return $wamdevin_users[$email];
        }
    }
    return false;
}

function isLoggedIn() {
    return isset($_SESSION['wamdevin_user']) && 
           isset($_SESSION['wamdevin_login_time']) &&
           (time() - $_SESSION['wamdevin_login_time']) < WAMDEVIN_SESSION_TIMEOUT;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
    
    // Update last activity time
    $_SESSION['wamdevin_last_activity'] = time();
}

function hasPermission($permission) {
    if (!isLoggedIn()) {
        return false;
    }
    
    $permissions = $_SESSION['wamdevin_user']['permissions'];
    return in_array('all', $permissions) || in_array($permission, $permissions);
}

function getUserRole() {
    return isLoggedIn() ? $_SESSION['wamdevin_user']['role'] : 'guest';
}

function getUserName() {
    return isLoggedIn() ? $_SESSION['wamdevin_user']['name'] : 'Guest';
}

function loginUser($email, $password) {
    $user = authenticateUser($email, $password);
    if ($user) {
        $_SESSION['wamdevin_user'] = $user;
        $_SESSION['wamdevin_login_time'] = time();
        $_SESSION['wamdevin_last_activity'] = time();
        $_SESSION['wamdevin_user_email'] = $email;
        
        // Log successful login
        error_log("WAMDEVIN Login: {$email} - " . date('Y-m-d H:i:s'));
        return true;
    }
    
    // Log failed login attempt
    error_log("WAMDEVIN Failed Login: {$email} - " . date('Y-m-d H:i:s'));
    return false;
}

function logoutUser() {
    $email = $_SESSION['wamdevin_user_email'] ?? 'unknown';
    
    // Clear all session data
    $_SESSION = array();
    
    // Destroy session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destroy session
    session_destroy();
    
    // Log logout
    error_log("WAMDEVIN Logout: {$email} - " . date('Y-m-d H:i:s'));
}

// CSRF Protection
function generateCSRFToken() {
    if (!isset($_SESSION['wamdevin_csrf_token'])) {
        $_SESSION['wamdevin_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['wamdevin_csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['wamdevin_csrf_token']) && 
           hash_equals($_SESSION['wamdevin_csrf_token'], $token);
}

// Handle login request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wamdevin_login'])) {
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    $csrf_token = $_POST['csrf_token'] ?? '';
    
    // Debug logging
    error_log("WAMDEVIN Login attempt: $email at " . date('Y-m-d H:i:s'));
    
    if (validateCSRFToken($csrf_token)) {
        if (loginUser($email, $password)) {
            // Successful login - redirect
            header('Location: index.php');
            exit();
        } else {
            $GLOBALS['login_error'] = 'Invalid credentials. Please check your email and password.';
            error_log("WAMDEVIN Login failed for: $email");
        }
    } else {
        $GLOBALS['login_error'] = 'Security token validation failed. Please try again.';
        error_log("WAMDEVIN CSRF validation failed for: $email");
    }
}

// Handle logout request
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    logoutUser();
    header('Location: login.php');
    exit();
}
?>
