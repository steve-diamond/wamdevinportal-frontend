<?php
/**
 * WAMDEVIN Alumni Portal - Authentication Middleware
 *
 * Call requireAlumniAuth() at the top of any protected page.
 * Call requireAdminAuth() for admin-only alumni portal pages.
 *
 * @version 1.0.0
 */

require_once __DIR__ . '/config.php';

/**
 * Returns the currently authenticated alumni payload, or null.
 */
function getAuthPayload()
{
    $jwt   = getJWT();
    $token = $jwt->extractToken();
    if (!$token) return null;

    $payload = $jwt->validate($token, 'access');
    if (!$payload) {
        // Try to auto-refresh via refresh cookie
        $refresh = (isset($_COOKIE['wam_refresh']) ? $_COOKIE['wam_refresh'] : null);
        if ($refresh) {
            try {
                $pdo    = getAlumniDB();
                $tokens = $jwt->refresh($refresh, $pdo);
                if ($tokens) {
                    $jwt->setCookies($tokens);
                    $payload = $jwt->validate($tokens['access_token'], 'access');
                }
            } catch (Exception $e) {
                error_log('JWT refresh error: ' . $e->getMessage());
            }
        }
    }

    return $payload;
}

/**
 * Require a logged-in alumni. Redirects to login if not authenticated.
 */
function requireAlumniAuth()
{
    $payload = getAuthPayload();
    if (!$payload) {
        setFlash('error', 'Please log in to access this page.');
        redirect(ALUMNI_BASE_URL . '/login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
    }

    // Check account is still active in DB
    try {
        $pdo  = getAlumniDB();
        $stmt = $pdo->prepare("SELECT status FROM alumni WHERE id = ? AND deleted_at IS NULL");
        $stmt->execute([(int)$payload['sub']]);
        $row  = $stmt->fetch();

        if (!$row || $row['status'] !== 'active') {
            getJWT()->clearCookies();
            session_destroy();
            redirect(ALUMNI_BASE_URL . '/login.php?msg=account_inactive');
        }
    } catch (Exception $e) {
        error_log('Middleware DB error: ' . $e->getMessage());
    }

    // Store in session for easy access in views
    $_SESSION['alumni'] = $payload;
    return $payload;
}

/**
 * Require admin or moderator role.
 */
function requireAdminAuth()
{
    $payload = requireAlumniAuth();
    if (!in_array((isset($payload['role']) ? $payload['role'] : ''), ['admin', 'moderator'])) {
        setFlash('error', 'You do not have permission to access that page.');
        redirect(ALUMNI_BASE_URL . '/index.php');
    }
    return $payload;
}

/**
 * Check if current request has alumni-admin privileges.
 * Supports both alumni JWT roles and legacy main-admin session auth.
 */
function hasAlumniAdminPrivileges( $payload = null)
{
    $payload = $payload ?: getAuthPayload();
    if ($payload && in_array((isset($payload['role']) ? $payload['role'] : ''), ['admin', 'moderator'], true)) {
        return true;
    }

    if (!empty($_SESSION['wamdevin_user']) && is_array($_SESSION['wamdevin_user'])) {
        $legacyRole = (isset($_SESSION['wamdevin_user']['role']) ? $_SESSION['wamdevin_user']['role'] : '');
        if (in_array($legacyRole, ['admin', 'coordinator', 'facilitator'], true)) {
            return true;
        }
    }

    return false;
}

/**
 * Redirect already-logged-in users away from login/register pages.
 */
function redirectIfLoggedIn()
{
    if (getAuthPayload()) {
        redirect(ALUMNI_BASE_URL . '/index.php');
    }
}

/**
 * Get the full alumni row from DB for the current user.
 */
function getCurrentAlumni()
{
    $payload = getAuthPayload();
    if (!$payload) return null;

    try {
        $pdo  = getAlumniDB();
        $stmt = $pdo->prepare("
            SELECT a.*, ap.graduation_year, ap.degree, ap.department,
                   ap.current_title, ap.current_company, ap.country, ap.city,
                   ap.bio, ap.linkedin_url, ap.twitter_url, ap.website_url,
                   ap.skills, ap.interests, ap.is_public
              FROM alumni a
              LEFT JOIN alumni_profiles ap ON ap.alumni_id = a.id
             WHERE a.id = ? AND a.deleted_at IS NULL
        ");
        $stmt->execute([(int)$payload['sub']]);
        return $stmt->fetch() ?: null;
    } catch (Exception $e) {
        error_log('getCurrentAlumni error: ' . $e->getMessage());
        return null;
    }
}

/**
 * Count unread notifications for the current user.
 */
function getUnreadNotificationCount()
{
    $payload = getAuthPayload();
    if (!$payload) return 0;

    try {
        $pdo  = getAlumniDB();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM alumni_notifications WHERE alumni_id=? AND is_read=0");
        $stmt->execute([(int)$payload['sub']]);
        return (int)$stmt->fetchColumn();
    } catch (Exception $e) {
        return 0;
    }
}

/**
 * Count unread messages for the current user.
 */
function getUnreadMessageCount()
{
    $payload = getAuthPayload();
    if (!$payload) return 0;

    try {
        $pdo  = getAlumniDB();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM alumni_messages WHERE receiver_id=? AND is_read=0");
        $stmt->execute([(int)$payload['sub']]);
        return (int)$stmt->fetchColumn();
    } catch (Exception $e) {
        return 0;
    }
}
