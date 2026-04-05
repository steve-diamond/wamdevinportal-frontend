<?php
/**
 * WAMDEVIN Alumni Portal - Logout
 * Revokes JWT, clears cookies, destroys session.
 */
require_once __DIR__ . '/includes/config.php';

$jwt   = getJWT();
$token = $jwt->extractToken();

if ($token) {
    try {
        $jwt->revoke($token, getAlumniDB());
    } catch (Exception $e) {
        error_log('Logout revoke error: ' . $e->getMessage());
    }
}

$jwt->clearCookies();
session_destroy();

// Restart session for flash message
session_start();
setFlash('success', 'You have been signed out successfully.');
redirect(ALUMNI_BASE_URL . '/login.php');
