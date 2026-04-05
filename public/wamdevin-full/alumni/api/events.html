<?php
/**
 * WAMDEVIN Alumni Portal - Events API
 * Endpoints:
 *   POST ?action=rsvp     – register/cancel RSVP for an event
 *   GET  ?action=status   – check RSVP status for an event
 *   GET  ?action=attendees – list attendees for an event (admin only)
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
$alumniId = (int)$payload['sub'];
$action   = (isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : ''));

function jsonOut( $d, $c = 200) { http_response_code($c); echo json_encode($d); exit; }
function apiSlug( $text) {
    $slug = strtolower(trim((string)$text));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    return trim((string)$slug, '-');
}
function apiColumnExists( $db, $table, $column) {
    try {
        $stmt = $db->prepare('SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = ? AND column_name = ?');
        $stmt->execute([$table, $column]);
        return (int)$stmt->fetchColumn() > 0;
    } catch (Exception $e) {
        return false;
    }
}

// ──────────────────────────────────────────────────────────────────────────
// EVENTS LIST
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'list' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $limit = max(1, min(100, (int)((isset($_GET['limit']) ? $_GET['limit'] : 20))));
    $page = max(1, (int)((isset($_GET['page']) ? $_GET['page'] : 1)));
    $offset = ($page - 1) * $limit;
    $status = trim((string)((isset($_GET['status']) ? $_GET['status'] : 'published')));
    $type = trim((string)((isset($_GET['type']) ? $_GET['type'] : '')));
    $search = trim((string)((isset($_GET['search']) ? $_GET['search'] : '')));

    $where = ['1=1'];
    $params = [];
    if ($status !== '') {
        $where[] = 'e.status = ?';
        $params[] = $status;
    }
    if ($type !== '') {
        $where[] = 'e.event_type = ?';
        $params[] = $type;
    }
    if ($search !== '') {
        $where[] = '(e.title LIKE ? OR e.location LIKE ? OR e.description LIKE ?)';
        $like = '%' . $search . '%';
        array_push($params, $like, $like, $like);
    }

    $whereSql = implode(' AND ', $where);
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM alumni_events e WHERE {$whereSql}");
    $countStmt->execute($params);
    $total = (int)$countStmt->fetchColumn();

    $stmt = $pdo->prepare(
        "SELECT e.id, e.title, e.slug, e.event_type, e.location, e.start_datetime, e.end_datetime, e.status,
                e.description, e.image,
                (SELECT status FROM alumni_event_registrations r WHERE r.event_id=e.id AND r.alumni_id=? LIMIT 1) AS my_status,
                (SELECT COUNT(*) FROM alumni_event_registrations r WHERE r.event_id=e.id AND r.status='registered') AS registered_count
           FROM alumni_events e
          WHERE {$whereSql}
          ORDER BY e.start_datetime ASC
          LIMIT {$limit} OFFSET {$offset}"
    );
    $stmt->execute(array_merge([$alumniId], $params));

    jsonOut([
        'events' => $stmt->fetchAll(),
        'page' => $page,
        'limit' => $limit,
        'total' => $total,
        'total_pages' => max(1, (int)ceil($total / $limit)),
    ]);
}

// ──────────────────────────────────────────────────────────────────────────
// EVENT DETAIL
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'detail' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $eventId = (int)((isset($_GET['event_id']) ? $_GET['event_id'] : 0));
    if ($eventId <= 0) jsonOut(['error' => 'event_id required.'], 422);

    $stmt = $pdo->prepare(
        "SELECT e.*, 
                (SELECT status FROM alumni_event_registrations r WHERE r.event_id=e.id AND r.alumni_id=? LIMIT 1) AS my_status,
                (SELECT COUNT(*) FROM alumni_event_registrations r WHERE r.event_id=e.id AND r.status='registered') AS registered_count
           FROM alumni_events e
          WHERE e.id=?
          LIMIT 1"
    );
    $stmt->execute([$alumniId, $eventId]);
    $event = $stmt->fetch();
    if (!$event) jsonOut(['error' => 'Event not found.'], 404);

    jsonOut(['event' => $event]);
}

// ──────────────────────────────────────────────────────────────────────────
// ADMIN CREATE EVENT
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'admin_create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hasAlumniAdminPrivileges($payload)) jsonOut(['error' => 'Forbidden.'], 403);

    $input = (is_array($__json = json_decode(file_get_contents('php://input'), true)) ? $__json : $_POST);
    $title = trim((string)((isset($input['title']) ? $input['title'] : '')));
    $eventType = trim((string)((isset($input['event_type']) ? $input['event_type'] : 'other')));
    $location = trim((string)((isset($input['location']) ? $input['location'] : '')));
    $start = trim((string)((isset($input['start_datetime']) ? $input['start_datetime'] : '')));
    $end = trim((string)((isset($input['end_datetime']) ? $input['end_datetime'] : '')));
    $status = trim((string)((isset($input['status']) ? $input['status'] : 'draft')));
    $description = trim((string)((isset($input['description']) ? $input['description'] : '')));
    $image = trim((string)((isset($input['image']) ? $input['image'] : '')));

    if ($title === '' || $start === '' || $end === '') {
        jsonOut(['error' => 'title, start_datetime and end_datetime are required.'], 422);
    }

    $slug = apiSlug($title) . '-' . time();
    $columns = ['title', 'slug', 'event_type', 'location', 'start_datetime', 'end_datetime', 'status', 'created_by'];
    $values = [':title', ':slug', ':event_type', ':location', ':start_datetime', ':end_datetime', ':status', ':created_by'];
    $params = [
        ':title' => $title,
        ':slug' => $slug,
        ':event_type' => $eventType,
        ':location' => $location !== '' ? $location : null,
        ':start_datetime' => $start,
        ':end_datetime' => $end,
        ':status' => $status,
        ':created_by' => $alumniId,
    ];

    if (apiColumnExists($pdo, 'alumni_events', 'description')) {
        $columns[] = 'description';
        $values[] = ':description';
        $params[':description'] = $description !== '' ? $description : null;
    }
    if (apiColumnExists($pdo, 'alumni_events', 'image')) {
        $columns[] = 'image';
        $values[] = ':image';
        $params[':image'] = $image !== '' ? $image : null;
    }

    $sql = 'INSERT INTO alumni_events (' . implode(', ', $columns) . ') VALUES (' . implode(', ', $values) . ')';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    jsonOut(['success' => true, 'event_id' => (int)$pdo->lastInsertId(), 'message' => 'Event created.']);
}

// ──────────────────────────────────────────────────────────────────────────
// ADMIN UPDATE EVENT
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'admin_update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hasAlumniAdminPrivileges($payload)) jsonOut(['error' => 'Forbidden.'], 403);

    $input = (is_array($__json = json_decode(file_get_contents('php://input'), true)) ? $__json : $_POST);
    $eventId = (int)((isset($input['event_id']) ? $input['event_id'] : 0));
    if ($eventId <= 0) jsonOut(['error' => 'event_id required.'], 422);

    $setParts = [];
    $params = [':id' => $eventId];

    $fieldMap = [
        'title' => 'title',
        'event_type' => 'event_type',
        'location' => 'location',
        'start_datetime' => 'start_datetime',
        'end_datetime' => 'end_datetime',
        'status' => 'status',
        'description' => 'description',
        'image' => 'image',
    ];

    foreach ($fieldMap as $inputKey => $columnName) {
        if (!array_key_exists($inputKey, $input)) {
            continue;
        }
        if (!apiColumnExists($pdo, 'alumni_events', $columnName)) {
            continue;
        }
        $setParts[] = $columnName . ' = :' . $inputKey;
        $value = trim((string)$input[$inputKey]);
        $params[':' . $inputKey] = $value === '' ? null : $value;
    }

    if (empty($setParts)) jsonOut(['error' => 'No updatable fields provided.'], 422);

    if (apiColumnExists($pdo, 'alumni_events', 'updated_at')) {
        $setParts[] = 'updated_at = NOW()';
    }

    $sql = 'UPDATE alumni_events SET ' . implode(', ', $setParts) . ' WHERE id = :id LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    jsonOut(['success' => true, 'message' => 'Event updated.']);
}

// ──────────────────────────────────────────────────────────────────────────
// ADMIN DELETE EVENT
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'admin_delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hasAlumniAdminPrivileges($payload)) jsonOut(['error' => 'Forbidden.'], 403);

    $input = (is_array($__json = json_decode(file_get_contents('php://input'), true)) ? $__json : $_POST);
    $eventId = (int)((isset($input['event_id']) ? $input['event_id'] : 0));
    if ($eventId <= 0) jsonOut(['error' => 'event_id required.'], 422);

    $pdo->prepare('DELETE FROM alumni_events WHERE id=? LIMIT 1')->execute([$eventId]);
    jsonOut(['success' => true, 'message' => 'Event deleted.']);
}

// ──────────────────────────────────────────────────────────────────────────
// RSVP STATUS CHECK
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'status' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $eventId = (int)((isset($_GET['event_id']) ? $_GET['event_id'] : 0));
    if (!$eventId) jsonOut(['error' => 'event_id required.'], 422);

    $stmt = $pdo->prepare("SELECT status, registered_at FROM alumni_event_registrations WHERE event_id=? AND alumni_id=?");
    $stmt->execute([$eventId, $alumniId]);
    $row = $stmt->fetch();

    // Count current registrants
    $cnt = $pdo->prepare("SELECT COUNT(*) FROM alumni_event_registrations WHERE event_id=? AND status='registered'");
    $cnt->execute([$eventId]);
    $count = (int)$cnt->fetchColumn();

    jsonOut(['registered' => (bool)$row && $row['status'] === 'registered', 'status' => (isset($row['status']) ? $row['status'] : null), 'registered_count' => $count]);
}

// ──────────────────────────────────────────────────────────────────────────
// RSVP / CANCEL
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'rsvp' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input   = (is_array($__json = json_decode(file_get_contents('php://input'), true)) ? $__json : $_POST);
    $eventId = (int)((isset($input['event_id']) ? $input['event_id'] : 0));

    if (!verifyCsrfToken((isset($input['csrf_token']) ? $input['csrf_token'] : ''))) jsonOut(['error' => 'Invalid CSRF token.'], 403);
    if (!$eventId) jsonOut(['error' => 'event_id required.'], 422);

    // Event check
    $ev = $pdo->prepare("SELECT id,title,max_attendees,registration_deadline,status FROM alumni_events WHERE id=? AND status='published'");
    $ev->execute([$eventId]);
    $event = $ev->fetch();
    if (!$event) jsonOut(['error' => 'Event not found.'], 404);

    // Deadline check
    if ($event['registration_deadline'] && strtotime($event['registration_deadline']) < time()) {
        jsonOut(['error' => 'Registration has closed for this event.'], 410);
    }

    // Existing registration
    $existStmt = $pdo->prepare("SELECT id,status FROM alumni_event_registrations WHERE event_id=? AND alumni_id=?");
    $existStmt->execute([$eventId, $alumniId]);
    $existing = $existStmt->fetch();

    if ($existing) {
        // Toggle: cancel if registered, re-register if cancelled
        if ($existing['status'] === 'registered') {
            $pdo->prepare("UPDATE alumni_event_registrations SET status='cancelled',updated_at=NOW() WHERE id=?")->execute([$existing['id']]);
            jsonOut(['success' => true, 'registered' => false, 'message' => 'Registration cancelled.']);
        } else {
            // Capacity check before re-register
            $cnt = $pdo->prepare("SELECT COUNT(*) FROM alumni_event_registrations WHERE event_id=? AND status='registered'");
            $cnt->execute([$eventId]);
            if ($event['max_attendees'] && (int)$cnt->fetchColumn() >= $event['max_attendees']) {
                jsonOut(['error' => 'Event is fully booked.'], 409);
            }
            $pdo->prepare("UPDATE alumni_event_registrations SET status='registered',updated_at=NOW() WHERE id=?")->execute([$existing['id']]);
            jsonOut(['success' => true, 'registered' => true, 'message' => 'You are now registered!']);
        }
    }

    // New registration — check capacity
    $cnt = $pdo->prepare("SELECT COUNT(*) FROM alumni_event_registrations WHERE event_id=? AND status='registered'");
    $cnt->execute([$eventId]);
    if ($event['max_attendees'] && (int)$cnt->fetchColumn() >= $event['max_attendees']) {
        jsonOut(['error' => 'Event is fully booked.'], 409);
    }

    $pdo->prepare("INSERT INTO alumni_event_registrations (event_id, alumni_id, status, payment_status) VALUES (?,?,'registered','free')")
        ->execute([$eventId, $alumniId]);

    // Notification
    $pdo->prepare("INSERT INTO alumni_notifications (alumni_id,type,title,body,action_url) VALUES (?,?,?,?,?)")
        ->execute([$alumniId, 'event_rsvp', 'RSVP Confirmed', 'You are registered for: ' . $event['title'], ALUMNI_BASE_URL . '/events.php']);

    jsonOut(['success' => true, 'registered' => true, 'message' => 'Successfully registered for this event!']);
}

// ──────────────────────────────────────────────────────────────────────────
// MARK ATTENDANCE (self)
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'attend' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = (is_array($__json = json_decode(file_get_contents('php://input'), true)) ? $__json : $_POST);
    $eventId = (int)((isset($input['event_id']) ? $input['event_id'] : 0));
    if ($eventId <= 0) jsonOut(['error' => 'event_id required.'], 422);

    $stmt = $pdo->prepare('SELECT id, status FROM alumni_event_registrations WHERE event_id=? AND alumni_id=? LIMIT 1');
    $stmt->execute([$eventId, $alumniId]);
    $reg = $stmt->fetch();
    if (!$reg) jsonOut(['error' => 'No registration found for this event.'], 404);
    if ($reg['status'] === 'attended') jsonOut(['success' => true, 'message' => 'Attendance already recorded.']);

    $pdo->prepare("UPDATE alumni_event_registrations SET status='attended', updated_at=NOW() WHERE id=? LIMIT 1")
        ->execute([$reg['id']]);

    jsonOut(['success' => true, 'message' => 'Attendance recorded.']);
}

// ──────────────────────────────────────────────────────────────────────────
// ATTENDEE LIST (admin/moderator only)
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'attendees' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!in_array((isset($payload['role']) ? $payload['role'] : ''), ['admin', 'moderator'])) jsonOut(['error' => 'Forbidden.'], 403);
    $eventId = (int)((isset($_GET['event_id']) ? $_GET['event_id'] : 0));
    if (!$eventId) jsonOut(['error' => 'event_id required.'], 422);

    $stmt = $pdo->prepare("
        SELECT a.first_name, a.last_name, a.email, r.status, r.registered_at
          FROM alumni_event_registrations r
          JOIN alumni a ON a.id = r.alumni_id
         WHERE r.event_id = ?
         ORDER BY r.registered_at ASC
    ");
    $stmt->execute([$eventId]);
    jsonOut(['attendees' => $stmt->fetchAll()]);
}

jsonOut(['error' => 'Invalid action or method.'], 400);
