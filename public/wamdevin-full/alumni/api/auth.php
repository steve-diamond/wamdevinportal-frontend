<?php
/**
 * WAMDEVIN Alumni Portal - Auth API
 * Endpoints: POST /api/auth.php?action=login|register|logout|refresh
 *
 * Returns JSON. Tokens are set in httpOnly cookies.
 */
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/middleware.php';

$action = (isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : ''));

function jsonOut( $data, $code = 200)
{
    http_response_code($code);
    echo json_encode($data);
    exit;
}

// ──────────────────────────────────────────────────────────────────────────
// LOGOUT
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'logout') {
    $token = getJWT()->extractToken();
    if ($token) {
        try { getJWT()->revoke($token, getAlumniDB()); } catch (Exception $e) {}
    }
    // Also revoke refresh token
    $refresh = (isset($_COOKIE['wam_refresh']) ? $_COOKIE['wam_refresh'] : null);
    if ($refresh) {
        try { getJWT()->revoke($refresh, getAlumniDB()); } catch (Exception $e) {}
    }
    getJWT()->clearCookies();
    session_destroy();
    jsonOut(['success' => true, 'message' => 'Logged out successfully.']);
}

// ──────────────────────────────────────────────────────────────────────────
// REFRESH
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'refresh') {
    $refresh = (isset($_COOKIE['wam_refresh']) ? $_COOKIE['wam_refresh'] : null);
    if (!$refresh) jsonOut(['error' => 'No refresh token.'], 401);
    try {
        $tokens = getJWT()->refresh($refresh, getAlumniDB());
        if (!$tokens) jsonOut(['error' => 'Refresh token invalid or expired.'], 401);
        getJWT()->setCookies($tokens);
        $payload = getJWT()->validate($tokens['access_token'], 'access');
        jsonOut([
            'success' => true,
            'expires_in' => $tokens['expires_in'],
            'token' => $tokens['access_token'],
            'role' => (isset($payload['role']) ? $payload['role'] : null),
            'user' => [
                'id' => isset($payload['sub']) ? (int)$payload['sub'] : null,
                'name' => (isset($payload['name']) ? $payload['name'] : null),
                'email' => (isset($payload['email']) ? $payload['email'] : null),
                'role' => (isset($payload['role']) ? $payload['role'] : null),
            ],
        ]);
    } catch (Exception $e) {
        error_log('Refresh error: ' . $e->getMessage());
        jsonOut(['error' => 'Server error.'], 500);
    }
}

// ──────────────────────────────────────────────────────────────────────────
// CURRENT AUTH STATE
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'me') {
    $payload = getAuthPayload();
    if (!$payload) {
        jsonOut(['authenticated' => false], 401);
    }

    jsonOut([
        'authenticated' => true,
        'token' => getJWT()->extractToken(),
        'role' => (isset($payload['role']) ? $payload['role'] : null),
        'user' => [
            'id' => isset($payload['sub']) ? (int)$payload['sub'] : null,
            'name' => (isset($payload['name']) ? $payload['name'] : null),
            'email' => (isset($payload['email']) ? $payload['email'] : null),
            'role' => (isset($payload['role']) ? $payload['role'] : null),
        ],
    ]);
}

// ──────────────────────────────────────────────────────────────────────────
// LOGIN
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = (is_array($__json = json_decode(file_get_contents('php://input'), true)) ? $__json : $_POST);

    if (!checkRateLimit('login_' . ((isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown')))) {
        jsonOut(['error' => 'Too many attempts. Please wait 15 minutes.'], 429);
    }

    $email    = strtolower(trim((isset($input['email']) ? $input['email'] : '')));
    $password = (isset($input['password']) ? $input['password'] : '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 1) {
        jsonOut(['error' => 'Email and password are required.'], 422);
    }

    try {
        $pdo  = getAlumniDB();
        $stmt = $pdo->prepare("SELECT id,first_name,last_name,email,password_hash,role,status,email_verified,login_attempts,locked_until FROM alumni WHERE email=? AND deleted_at IS NULL LIMIT 1");
        $stmt->execute([$email]);
        $alumni = $stmt->fetch();

        if (!$alumni) {
            password_verify($password, '$2y$12$dummy_for_timing_safety_xxxxxxxx');
            jsonOut(['error' => 'Invalid email or password.'], 401);
        }
        if (in_array($alumni['status'], ['banned','suspended'])) {
            jsonOut(['error' => 'Account is suspended. Contact support.'], 403);
        }
        if ($alumni['locked_until'] && strtotime($alumni['locked_until']) > time()) {
            $m = ceil((strtotime($alumni['locked_until']) - time()) / 60);
            jsonOut(['error' => "Account locked. Try again in {$m} min."], 423);
        }
        if (!password_verify($password, $alumni['password_hash'])) {
            $attempts = (int)$alumni['login_attempts'] + 1;
            $lockedUntil = $attempts >= 5 ? date('Y-m-d H:i:s', time() + 900) : null;
            $pdo->prepare("UPDATE alumni SET login_attempts=?, locked_until=? WHERE id=?")->execute([$attempts, $lockedUntil, $alumni['id']]);
            jsonOut(['error' => 'Invalid email or password.'], 401);
        }
        if (!$alumni['email_verified']) {
            jsonOut(['error' => 'Please verify your email address before logging in.', 'code' => 'EMAIL_UNVERIFIED'], 403);
        }

        // Reset attempts, update last_login
        $pdo->prepare("UPDATE alumni SET login_attempts=0, locked_until=NULL, last_login=NOW(), last_login_ip=? WHERE id=?")
            ->execute([(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null), $alumni['id']]);

        $tokens = getJWT()->issueTokens([
            'sub'   => (string)$alumni['id'],
            'email' => $alumni['email'],
            'role'  => $alumni['role'],
            'name'  => $alumni['first_name'] . ' ' . $alumni['last_name'],
        ]);
        getJWT()->setCookies($tokens);

        jsonOut([
            'success'    => true,
            'expires_in' => $tokens['expires_in'],
            'token'      => $tokens['access_token'],
            'role'       => $alumni['role'],
            'user'       => ['id' => $alumni['id'], 'name' => $alumni['first_name'] . ' ' . $alumni['last_name'], 'role' => $alumni['role']],
        ]);
    } catch (Exception $e) {
        error_log('Login API error: ' . $e->getMessage());
        jsonOut(['error' => 'Server error. Please try again.'], 500);
    }
}

// ──────────────────────────────────────────────────────────────────────────
// REGISTER
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = (is_array($__json = json_decode(file_get_contents('php://input'), true)) ? $__json : $_POST);

    if (!checkRateLimit('register_' . ((isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown')))) {
        jsonOut(['error' => 'Too many registration attempts.'], 429);
    }

    $firstName = trim((isset($input['first_name']) ? $input['first_name'] : ''));
    $lastName  = trim((isset($input['last_name']) ? $input['last_name'] : ''));
    $email     = strtolower(trim((isset($input['email']) ? $input['email'] : '')));
    $password  = (isset($input['password']) ? $input['password'] : '');

    $errors = [];
    if (strlen($firstName) < 2) $errors[] = 'First name is required.';
    if (strlen($lastName)  < 2) $errors[] = 'Last name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email required.';
    if (strlen($password) < 8)  $errors[] = 'Password must be at least 8 characters.';
    if (!preg_match('/[A-Z]/', $password)) $errors[] = 'Password needs an uppercase letter.';
    if (!preg_match('/[0-9]/', $password)) $errors[] = 'Password needs a number.';
    if ($errors) jsonOut(['errors' => $errors], 422);

    try {
        $pdo  = getAlumniDB();
        $check = $pdo->prepare("SELECT id FROM alumni WHERE email=?");
        $check->execute([$email]);
        if ($check->fetch()) jsonOut(['error' => 'An account with this email already exists.'], 409);

        $hash    = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        $token   = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', time() + EMAIL_VERIFICATION_TIMEOUT);

        $pdo->beginTransaction();
        $pdo->prepare("INSERT INTO alumni (first_name,last_name,email,password_hash,status,email_verified,verification_token,verification_expires) VALUES(?,?,?,?,'pending',0,?,?)")
            ->execute([$firstName, $lastName, $email, $hash, $token, $expires]);
        $aid = (int)$pdo->lastInsertId();
        $pdo->prepare("INSERT INTO alumni_profiles (alumni_id) VALUES(?)")->execute([$aid]);
        $pdo->commit();

        jsonOut(['success' => true, 'message' => 'Account created. Please check your email to verify.']);
    } catch (Exception $e) {
        if (isset($pdo) && $pdo->inTransaction()) $pdo->rollBack();
        error_log('Register API error: ' . $e->getMessage());
        jsonOut(['error' => 'Server error. Please try again.'], 500);
    }
}

jsonOut(['error' => 'Invalid action or method.'], 400);
