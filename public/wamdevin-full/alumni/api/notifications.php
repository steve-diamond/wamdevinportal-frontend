<?php
/**
 * Alumni API - Notifications
 *
 * GET:
 *  - ?limit=5
 *  - ?mark_read=1&id=10
 *  - ?mark_all=1
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

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $body = json_decode(file_get_contents('php://input'), true);
        if (!is_array($body)) {
            $body = $_POST;
        }

        if (!verifyCsrfToken((string)((isset($body['csrf_token']) ? $body['csrf_token'] : '')))) {
            jsonResponse(['success' => false, 'message' => 'Invalid CSRF token'], 419);
        }

        if (!empty($body['mark_all'])) {
            $stmt = $pdo->prepare("UPDATE alumni_notifications SET is_read=1, read_at=NOW() WHERE alumni_id=? AND is_read=0");
            $stmt->execute([$alumniId]);
            jsonResponse(['success' => true, 'message' => 'All notifications marked as read']);
        }

        if (!empty($body['id'])) {
            $stmt = $pdo->prepare("UPDATE alumni_notifications SET is_read=1, read_at=NOW() WHERE id=? AND alumni_id=?");
            $stmt->execute([(int)$body['id'], $alumniId]);
            jsonResponse(['success' => true, 'message' => 'Notification updated']);
        }

        jsonResponse(['success' => false, 'message' => 'No action specified'], 400);
    }

    if (!empty($_GET['mark_read']) && !empty($_GET['id'])) {
        $stmt = $pdo->prepare("UPDATE alumni_notifications SET is_read=1, read_at=NOW() WHERE id=? AND alumni_id=?");
        $stmt->execute([(int)$_GET['id'], $alumniId]);
    }

    if (!empty($_GET['mark_all'])) {
        $stmt = $pdo->prepare("UPDATE alumni_notifications SET is_read=1, read_at=NOW() WHERE alumni_id=? AND is_read=0");
        $stmt->execute([$alumniId]);
    }

    $limit = min(50, max(1, (int)((isset($_GET['limit']) ? $_GET['limit'] : 20))));

    $stmt = $pdo->prepare("SELECT id, type, title, body, action_url, is_read, created_at,
                                  TIMESTAMPDIFF(MINUTE, created_at, NOW()) as mins_ago
                             FROM alumni_notifications
                            WHERE alumni_id=?
                            ORDER BY created_at DESC
                            LIMIT {$limit}");
    $stmt->execute([$alumniId]);
    $rows = $stmt->fetchAll();

    foreach ($rows as &$r) {
        $m = (int)$r['mins_ago'];
        if ($m < 1) $r['time_ago'] = 'Just now';
        elseif ($m < 60) $r['time_ago'] = $m . ' min ago';
        elseif ($m < 1440) $r['time_ago'] = floor($m / 60) . ' hr ago';
        else $r['time_ago'] = floor($m / 1440) . ' day(s) ago';
        unset($r['mins_ago']);
    }

    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM alumni_notifications WHERE alumni_id=? AND is_read=0");
    $countStmt->execute([$alumniId]);
    $unread = (int)$countStmt->fetchColumn();

    jsonResponse(['success' => true, 'unread' => $unread, 'notifications' => $rows]);
} catch (Exception $e) {
    error_log('notifications API error: ' . $e->getMessage());
    jsonResponse(['success' => false, 'message' => 'Server error'], 500);
}
