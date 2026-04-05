<?php
/**
 * WAMDEVIN Alumni Portal - Messages API
 * Endpoints:
 *   GET  ?action=thread&with={id}      – load message thread with a user
 *   POST ?action=send                  – send a message
 *   POST ?action=read&thread_id={id}   – mark thread messages as read
 *   GET  ?action=inbox                 – list inbox threads (latest per thread)
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

$pdo      = getAlumniDB();
$self     = (int)$payload['sub'];
$action   = (isset($_GET['action']) ? $_GET['action'] : '');

function jsonOut( $d, $c = 200) { http_response_code($c); echo json_encode($d); exit; }

function makeThreadId( $a, $b)
{
    return min($a, $b) . '_' . max($a, $b);
}

// ──────────────────────────────────────────────────────────────────────────
// INBOX — list all threads, showing latest message per thread
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'inbox' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $page  = max(1, (int)((isset($_GET['page']) ? $_GET['page'] : 1)));
    $limit = 20;
    $off   = ($page - 1) * $limit;

    $stmt = $pdo->prepare("
        SELECT m.thread_id, m.body, m.created_at, m.is_read,
               CASE WHEN m.sender_id = :self THEN m.receiver_id ELSE m.sender_id END AS partner_id,
               a.first_name, a.last_name, a.avatar, a.email,
               (SELECT COUNT(*) FROM alumni_messages um WHERE um.thread_id=m.thread_id AND um.receiver_id=:self2 AND um.is_read=0) AS unread_count
          FROM alumni_messages m
          JOIN alumni a ON a.id = (CASE WHEN m.sender_id = :self3 THEN m.receiver_id ELSE m.sender_id END)
         WHERE (m.sender_id = :self4 AND m.deleted_by_sender = 0)
            OR (m.receiver_id = :self5 AND m.deleted_by_receiver = 0)
         GROUP BY m.thread_id
         HAVING m.id = (SELECT MAX(id) FROM alumni_messages sm WHERE sm.thread_id=m.thread_id)
         ORDER BY m.created_at DESC
         LIMIT :lim OFFSET :off
    ");
    $stmt->bindValue(':self',  $self, PDO::PARAM_INT);
    $stmt->bindValue(':self2', $self, PDO::PARAM_INT);
    $stmt->bindValue(':self3', $self, PDO::PARAM_INT);
    $stmt->bindValue(':self4', $self, PDO::PARAM_INT);
    $stmt->bindValue(':self5', $self, PDO::PARAM_INT);
    $stmt->bindValue(':lim',   $limit, PDO::PARAM_INT);
    $stmt->bindValue(':off',   $off,   PDO::PARAM_INT);
    $stmt->execute();
    $threads = $stmt->fetchAll();

    // Attach avatar URLs
    foreach ($threads as &$t) {
        $t['avatar_url'] = getAvatarUrl($t['avatar'], $t['email'], 40);
    }

    jsonOut(['threads' => $threads, 'page' => $page]);
}

// ──────────────────────────────────────────────────────────────────────────
// THREAD — load full conversation with another user
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'thread' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $withId   = (int)((isset($_GET['with']) ? $_GET['with'] : 0));
    if (!$withId || $withId === $self) jsonOut(['error' => 'Invalid user.'], 422);

    // Verify connection (must be connected)
    $connStmt = $pdo->prepare("
        SELECT id FROM alumni_connections
         WHERE ((requester_id=? AND receiver_id=?) OR (requester_id=? AND receiver_id=?))
           AND status='accepted'
        LIMIT 1
    ");
    $connStmt->execute([$self, $withId, $withId, $self]);
    if (!$connStmt->fetch()) jsonOut(['error' => 'You are not connected with this alumni.'], 403);

    $threadId = makeThreadId($self, $withId);
    $page     = max(1, (int)((isset($_GET['page']) ? $_GET['page'] : 1)));
    $limit    = 30;
    $off      = ($page - 1) * $limit;

    $stmt = $pdo->prepare("
        SELECT m.id, m.sender_id, m.body, m.created_at, m.is_read,
               a.first_name, a.last_name, a.avatar, a.email
          FROM alumni_messages m
          JOIN alumni a ON a.id = m.sender_id
         WHERE m.thread_id = ?
           AND (
                (m.sender_id   = ? AND m.deleted_by_sender   = 0)
             OR (m.receiver_id = ? AND m.deleted_by_receiver = 0)
           )
         ORDER BY m.created_at DESC
         LIMIT ? OFFSET ?
    ");
    $stmt->execute([$threadId, $self, $self, $limit, $off]);
    $messages = array_reverse($stmt->fetchAll());

    // Mark as read
    $pdo->prepare("UPDATE alumni_messages SET is_read=1, read_at=NOW() WHERE thread_id=? AND receiver_id=? AND is_read=0")
        ->execute([$threadId, $self]);

    // Partner info
    $pStmt = $pdo->prepare("SELECT id,first_name,last_name,avatar,email FROM alumni WHERE id=?");
    $pStmt->execute([$withId]);
    $partner = $pStmt->fetch();
    $partner['avatar_url'] = getAvatarUrl($partner['avatar'], $partner['email'], 60);

    foreach ($messages as &$m) {
        $m['avatar_url'] = getAvatarUrl($m['avatar'], $m['email'], 36);
        $m['is_mine']    = (int)$m['sender_id'] === $self;
    }

    jsonOut(['messages' => $messages, 'partner' => $partner, 'thread_id' => $threadId, 'page' => $page]);
}

// ──────────────────────────────────────────────────────────────────────────
// SEND MESSAGE
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'send' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = (is_array($__json = json_decode(file_get_contents('php://input'), true)) ? $__json : $_POST);

    if (!verifyCsrfToken((isset($input['csrf_token']) ? $input['csrf_token'] : ''))) jsonOut(['error' => 'Invalid CSRF token.'], 403);

    $receiverId = (int)((isset($input['receiver_id']) ? $input['receiver_id'] : 0));
    $body       = trim((isset($input['body']) ? $input['body'] : ''));

    if (!$receiverId || $receiverId === $self) jsonOut(['error' => 'Invalid recipient.'], 422);
    if (strlen($body) < 1)   jsonOut(['error' => 'Message body is required.'], 422);
    if (strlen($body) > 5000) jsonOut(['error' => 'Message too long (max 5000 chars).'], 422);

    // Verify connection
    $connStmt = $pdo->prepare("
        SELECT id FROM alumni_connections
         WHERE ((requester_id=? AND receiver_id=?) OR (requester_id=? AND receiver_id=?))
           AND status='accepted'
        LIMIT 1
    ");
    $connStmt->execute([$self, $receiverId, $receiverId, $self]);
    if (!$connStmt->fetch()) jsonOut(['error' => 'You must connect with this alumni before messaging.'], 403);

    $threadId = makeThreadId($self, $receiverId);

    $pdo->prepare("INSERT INTO alumni_messages (thread_id, sender_id, receiver_id, body) VALUES (?,?,?,?)")
        ->execute([$threadId, $self, $receiverId, $body]);
    $msgId = (int)$pdo->lastInsertId();

    // Notification for receiver
    $senderStmt = $pdo->prepare("SELECT first_name, last_name FROM alumni WHERE id=?");
    $senderStmt->execute([$self]);
    $sender = $senderStmt->fetch();
    $senderName = $sender['first_name'] . ' ' . $sender['last_name'];

    $pdo->prepare("INSERT INTO alumni_notifications (alumni_id,type,title,body,action_url) VALUES (?,?,?,?,?)")
        ->execute([
            $receiverId, 'new_message',
            "New message from {$senderName}",
            substr($body, 0, 100) . (strlen($body) > 100 ? '…' : ''),
            ALUMNI_BASE_URL . '/messages.php?with=' . $self,
        ]);

    jsonOut(['success' => true, 'message_id' => $msgId, 'thread_id' => $threadId]);
}

// ──────────────────────────────────────────────────────────────────────────
// MARK THREAD AS READ
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'read' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input    = (is_array($__json = json_decode(file_get_contents('php://input'), true)) ? $__json : $_POST);
    $threadId = preg_replace('/[^0-9_]/', '', (isset($input['thread_id']) ? $input['thread_id'] : ''));
    if (!$threadId) jsonOut(['error' => 'thread_id required.'], 422);

    $pdo->prepare("UPDATE alumni_messages SET is_read=1, read_at=NOW() WHERE thread_id=? AND receiver_id=? AND is_read=0")
        ->execute([$threadId, $self]);

    jsonOut(['success' => true]);
}

jsonOut(['error' => 'Invalid action or method.'], 400);
