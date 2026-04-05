<?php
/**
 * Alumni API - Connections
 *
 * Actions:
 *  - POST action=request (receiver_id)
 *  - POST action=accept  (connection_id)
 *  - POST action=decline (connection_id)
 *  - GET  action=list
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/middleware.php';

header('Content-Type: application/json; charset=utf-8');

function jsonResponse( $payload, $code = 200) {
    http_response_code($code);
    echo json_encode($payload);
    exit;
}

$auth = getAuthPayload();
if (!$auth) {
    jsonResponse(['success' => false, 'message' => 'Unauthorized'], 401);
}

$pdo      = getAlumniDB();
$alumniId = (int)$auth['sub'];
$method   = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $action = (isset($_GET['action']) ? $_GET['action'] : 'list');
    if ($action !== 'list') {
        jsonResponse(['success' => false, 'message' => 'Invalid action'], 400);
    }

    try {
        $stmt = $pdo->prepare("SELECT c.id, c.status, c.created_at,
                        a.id as alumni_id, a.first_name, a.last_name, a.email, a.avatar,
                        ap.current_title, ap.current_company
                   FROM alumni_connections c
                   JOIN alumni a ON a.id = CASE WHEN c.requester_id=? THEN c.receiver_id ELSE c.requester_id END
              LEFT JOIN alumni_profiles ap ON ap.alumni_id = a.id
                  WHERE (c.requester_id=? OR c.receiver_id=?)
               ORDER BY c.updated_at DESC");
        $stmt->execute([$alumniId, $alumniId, $alumniId]);
        $rows = $stmt->fetchAll();
        jsonResponse(['success' => true, 'connections' => $rows]);
    } catch (Exception $e) {
        error_log('connections list error: ' . $e->getMessage());
        jsonResponse(['success' => false, 'message' => 'Could not load connections'], 500);
    }
}

if ($method !== 'POST') {
    jsonResponse(['success' => false, 'message' => 'Method not allowed'], 405);
}

$body = json_decode(file_get_contents('php://input'), true);
if (!is_array($body)) {
    $body = $_POST;
}

if (!verifyCsrfToken((string)((isset($body['csrf_token']) ? $body['csrf_token'] : '')))) {
    jsonResponse(['success' => false, 'message' => 'Invalid CSRF token'], 419);
}

$action = (isset($body['action']) ? $body['action'] : '');

try {
    if ($action === 'request') {
        $receiverId = (int)((isset($body['receiver_id']) ? $body['receiver_id'] : 0));
        if ($receiverId <= 0 || $receiverId === $alumniId) {
            jsonResponse(['success' => false, 'message' => 'Invalid receiver'], 400);
        }

        $checkUser = $pdo->prepare("SELECT id FROM alumni WHERE id=? AND status='active' AND deleted_at IS NULL");
        $checkUser->execute([$receiverId]);
        if (!$checkUser->fetch()) {
            jsonResponse(['success' => false, 'message' => 'Alumni not found'], 404);
        }

        $exists = $pdo->prepare("SELECT id, status FROM alumni_connections
                                  WHERE (requester_id=? AND receiver_id=?)
                                     OR (requester_id=? AND receiver_id=?)
                                  LIMIT 1");
        $exists->execute([$alumniId, $receiverId, $receiverId, $alumniId]);
        $existing = $exists->fetch();

        if ($existing) {
            jsonResponse(['success' => false, 'message' => 'Connection already exists']);
        }

        $stmt = $pdo->prepare("INSERT INTO alumni_connections (requester_id, receiver_id, status) VALUES (?, ?, 'pending')");
        $stmt->execute([$alumniId, $receiverId]);

        // Notify receiver
        $n = $pdo->prepare("INSERT INTO alumni_notifications (alumni_id, type, title, body, action_url)
                            VALUES (?, 'connection_request', 'New connection request', 'You have a new connection request from another alumni member.', ?)");
        $n->execute([$receiverId, ALUMNI_BASE_URL . '/connections.php?tab=requests']);

        jsonResponse(['success' => true, 'message' => 'Connection request sent']);
    }

    if ($action === 'accept' || $action === 'decline') {
        $connectionId = (int)((isset($body['connection_id']) ? $body['connection_id'] : 0));
        if ($connectionId <= 0) {
            jsonResponse(['success' => false, 'message' => 'Invalid connection id'], 400);
        }

        $find = $pdo->prepare("SELECT * FROM alumni_connections WHERE id=? AND receiver_id=? AND status='pending'");
        $find->execute([$connectionId, $alumniId]);
        $conn = $find->fetch();
        if (!$conn) {
            jsonResponse(['success' => false, 'message' => 'Request not found'], 404);
        }

        $newStatus = $action === 'accept' ? 'accepted' : 'declined';
        $upd = $pdo->prepare("UPDATE alumni_connections SET status=?, updated_at=NOW() WHERE id=?");
        $upd->execute([$newStatus, $connectionId]);

        $notifyTitle = $action === 'accept' ? 'Connection accepted' : 'Connection request declined';
        $notifyBody  = $action === 'accept'
            ? 'Your alumni connection request was accepted.'
            : 'Your alumni connection request was declined.';

        $n = $pdo->prepare("INSERT INTO alumni_notifications (alumni_id, type, title, body, action_url)
                            VALUES (?, 'connection_update', ?, ?, ?)");
        $n->execute([(int)$conn['requester_id'], $notifyTitle, $notifyBody, ALUMNI_BASE_URL . '/directory.php?id=' . $alumniId]);

        jsonResponse(['success' => true, 'message' => 'Request updated', 'status' => $newStatus]);
    }

    jsonResponse(['success' => false, 'message' => 'Unknown action'], 400);
} catch (Exception $e) {
    error_log('connections API error: ' . $e->getMessage());
    jsonResponse(['success' => false, 'message' => 'Server error'], 500);
}
