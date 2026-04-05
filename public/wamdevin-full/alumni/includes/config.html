<?php
/**
 * WAMDEVIN Alumni Portal - Core Configuration
 *
 * Loads DB config, defines constants, instantiates JWTAuth,
 * sets security headers, and wires CSRF protection.
 *
 * @version 1.0.0
 */

// ------------------------------------------------------------------
// Bootstrap
// ------------------------------------------------------------------
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_secure'   => isset($_SERVER['HTTPS']),
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
        'use_strict_mode' => true,
    ]);
}

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; img-src 'self' data: https:;");

// Shared DB config
require_once __DIR__ . '/../../includes/db-config.php';

// JWT Auth class
require_once __DIR__ . '/JWTAuth.php';

// Compatibility helper for older PHP runtimes
if (!function_exists('random_bytes')) {
    function random_bytes($length)
    {
        $length = (int)$length;
        if ($length < 1) {
            throw new Exception('random_bytes length must be greater than 0');
        }

        if (function_exists('openssl_random_pseudo_bytes')) {
            $bytes = openssl_random_pseudo_bytes($length, $strong);
            if ($bytes !== false && strlen($bytes) === $length) {
                return $bytes;
            }
        }

        $bytes = '';
        for ($i = 0; $i < $length; $i++) {
            $bytes .= chr(mt_rand(0, 255));
        }
        return $bytes;
    }
}

// ------------------------------------------------------------------
// Constants
// ------------------------------------------------------------------
define('ALUMNI_VERSION',   '1.0.0');
define('ALUMNI_BASE_URL',  rtrim(APP_URL, '/') . '/alumni');
define('ALUMNI_UPLOADS',   __DIR__ . '/../../assets/uploads/alumni');
define('ALUMNI_UPLOAD_URL', rtrim(APP_URL, '/') . '/assets/uploads/alumni');

// JWT secret – override in production via environment variable
define('JWT_SECRET', getenv('WAMDEVIN_JWT_SECRET') ?: 'wamdevin_alumni_jwt_secret_change_in_production_2026!');

// Rate-limiting window (seconds) and max attempts
define('AUTH_RATE_LIMIT_WINDOW',   900);   // 15 minutes
define('AUTH_RATE_LIMIT_ATTEMPTS', 10);    // max attempts

// Max avatar upload size (bytes)
define('AVATAR_MAX_SIZE', 2 * 1024 * 1024); // 2 MB

// ------------------------------------------------------------------
// Global PDO instance
// ------------------------------------------------------------------
function getAlumniDB()
{
    static $pdo = null;
    if ($pdo === null) {
        $pdo = getDBConnection();
    }
    return $pdo;
}

// ------------------------------------------------------------------
// Global JWT instance
// ------------------------------------------------------------------
function getJWT()
{
    static $jwt = null;
    if ($jwt === null) {
        $jwt = new JWTAuth(JWT_SECRET);
    }
    return $jwt;
}

// ------------------------------------------------------------------
// CSRF protection
// ------------------------------------------------------------------
if (!function_exists('generateCsrfToken')) {
    function generateCsrfToken()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('verifyCsrfToken')) {
    function verifyCsrfToken($token)
    {
        return isset($_SESSION['csrf_token']) &&
               hash_equals($_SESSION['csrf_token'], $token);
    }
}

if (!function_exists('csrfField')) {
    function csrfField()
    {
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(generateCsrfToken()) . '">';
    }
}

// ------------------------------------------------------------------
// Output sanitisation
// ------------------------------------------------------------------
function e( $str)
{
    return htmlspecialchars($str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// ------------------------------------------------------------------
// Redirect helper
// ------------------------------------------------------------------
function redirect( $url)
{
    header('Location: ' . $url);
    exit;
}

// ------------------------------------------------------------------
// Flash messages (stored in session)
// ------------------------------------------------------------------
function setFlash( $type, $message)
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash()
{
    $flash = (isset($_SESSION['flash']) ? $_SESSION['flash'] : null);
    unset($_SESSION['flash']);
    return $flash;
}

// ------------------------------------------------------------------
// Rate limiting (session-based)
// ------------------------------------------------------------------
function checkRateLimit( $key)
{
    $now = time();
    $rk  = 'rl_' . md5($key);

    if (!isset($_SESSION[$rk])) {
        $_SESSION[$rk] = ['count' => 0, 'window_start' => $now];
    }

    $rl = &$_SESSION[$rk];

    // Reset window if expired
    if (($now - $rl['window_start']) > AUTH_RATE_LIMIT_WINDOW) {
        $rl = ['count' => 0, 'window_start' => $now];
    }

    $rl['count']++;
    return $rl['count'] <= AUTH_RATE_LIMIT_ATTEMPTS;
}

// ------------------------------------------------------------------
// Gravatar / avatar helper
// ------------------------------------------------------------------
function getAvatarUrl( $avatar, $email, $size = 80)
{
    if ($avatar && file_exists(ALUMNI_UPLOADS . '/' . $avatar)) {
        return ALUMNI_UPLOAD_URL . '/' . $avatar;
    }
    return 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . "?s={$size}&d=identicon";
}

// Ensure upload directory exists
if (!is_dir(ALUMNI_UPLOADS)) {
    mkdir(ALUMNI_UPLOADS, 0755, true);
}

// Set timezone
date_default_timezone_set(APP_TIMEZONE);
