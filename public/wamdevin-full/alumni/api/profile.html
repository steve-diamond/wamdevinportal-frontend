<?php
/**
 * WAMDEVIN Alumni Portal - Profile API
 * Endpoints:
 *   GET  ?action=me
 *   POST ?action=update
 */
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/middleware.php';

$payload = getAuthPayload();
if (!$payload) {
    http_response_code(401);
    echo json_encode(['error' => 'Authentication required.']);
    exit;
}

$pdo = getAlumniDB();
$alumniId = (int)$payload['sub'];
$action = (isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : ''));

function jsonOut( $d, $c = 200) { http_response_code($c); echo json_encode($d); exit; }

if ($action === 'me' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->prepare(
        "SELECT a.id, a.first_name, a.last_name, a.email, a.role, a.status, a.avatar,
                ap.graduation_year, ap.degree, ap.department, ap.current_title, ap.current_company,
                ap.country, ap.city, ap.bio, ap.linkedin_url, ap.twitter_url, ap.website_url,
                ap.skills, ap.interests, ap.is_public
           FROM alumni a
      LEFT JOIN alumni_profiles ap ON ap.alumni_id = a.id
          WHERE a.id = ? AND a.deleted_at IS NULL
          LIMIT 1"
    );
    $stmt->execute([$alumniId]);
    $profile = $stmt->fetch();

    if (!$profile) {
        jsonOut(['error' => 'Profile not found.'], 404);
    }

    jsonOut(['profile' => $profile]);
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = (is_array($__json = json_decode(file_get_contents('php://input'), true)) ? $__json : $_POST);

    if (!verifyCsrfToken((isset($input['csrf_token']) ? $input['csrf_token'] : ''))) {
        jsonOut(['error' => 'Invalid CSRF token.'], 403);
    }

    $firstName = trim((string)((isset($input['first_name']) ? $input['first_name'] : '')));
    $lastName = trim((string)((isset($input['last_name']) ? $input['last_name'] : '')));

    if ($firstName !== '' || $lastName !== '') {
        if (strlen($firstName) < 2 || strlen($lastName) < 2) {
            jsonOut(['error' => 'first_name and last_name must be at least 2 characters.'], 422);
        }
        $pdo->prepare('UPDATE alumni SET first_name=?, last_name=?, updated_at=NOW() WHERE id=? LIMIT 1')
            ->execute([$firstName, $lastName, $alumniId]);
    }

    $existsStmt = $pdo->prepare('SELECT id FROM alumni_profiles WHERE alumni_id=? LIMIT 1');
    $existsStmt->execute([$alumniId]);
    $profileExists = (bool)$existsStmt->fetch();

    if (!$profileExists) {
        $pdo->prepare('INSERT INTO alumni_profiles (alumni_id) VALUES (?)')->execute([$alumniId]);
    }

    $allowedProfileFields = [
        'graduation_year', 'degree', 'department', 'current_title', 'current_company',
        'country', 'city', 'bio', 'linkedin_url', 'twitter_url', 'website_url',
        'skills', 'interests', 'is_public'
    ];

    $setParts = [];
    $params = [':alumni_id' => $alumniId];
    foreach ($allowedProfileFields as $field) {
        if (!array_key_exists($field, $input)) {
            continue;
        }
        $setParts[] = $field . ' = :' . $field;
        if ($field === 'is_public') {
            $params[':' . $field] = (int)!empty($input[$field]);
            continue;
        }
        if ($field === 'graduation_year') {
            $year = (int)$input[$field];
            $params[':' . $field] = ($year > 1900 && $year <= (int)date('Y') + 1) ? $year : null;
            continue;
        }
        $value = trim((string)$input[$field]);
        $params[':' . $field] = $value === '' ? null : $value;
    }

    if (!empty($setParts)) {
        $setParts[] = 'updated_at = NOW()';
        $sql = 'UPDATE alumni_profiles SET ' . implode(', ', $setParts) . ' WHERE alumni_id = :alumni_id LIMIT 1';
        $pdo->prepare($sql)->execute($params);
    }

    jsonOut(['success' => true, 'message' => 'Profile updated successfully.']);
}

jsonOut(['error' => 'Invalid action or method.'], 400);
