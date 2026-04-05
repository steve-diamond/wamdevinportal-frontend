<?php
/**
 * WAMDEVIN Alumni Portal - Jobs API
 * Endpoints:
 *   POST ?action=apply   – apply to a job (with optional cover letter)
 *   POST ?action=save    – save/unsave a job bookmark
 *   GET  ?action=status  – check application status for a job
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
// JOB LIST
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'list' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $limit = max(1, min(100, (int)((isset($_GET['limit']) ? $_GET['limit'] : 20))));
    $page = max(1, (int)((isset($_GET['page']) ? $_GET['page'] : 1)));
    $offset = ($page - 1) * $limit;
    $status = trim((string)((isset($_GET['status']) ? $_GET['status'] : 'published')));
    $type = trim((string)((isset($_GET['job_type']) ? $_GET['job_type'] : '')));
    $search = trim((string)((isset($_GET['search']) ? $_GET['search'] : '')));

    $where = ['1=1'];
    $params = [];
    if ($status !== '') {
        $where[] = 'j.status = ?';
        $params[] = $status;
    }
    if ($type !== '') {
        $where[] = 'j.job_type = ?';
        $params[] = $type;
    }
    if ($search !== '') {
        $where[] = '(j.title LIKE ? OR j.company LIKE ? OR j.description LIKE ? OR j.location LIKE ?)';
        $like = '%' . $search . '%';
        array_push($params, $like, $like, $like, $like);
    }
    $whereSql = implode(' AND ', $where);

    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM alumni_jobs j WHERE {$whereSql}");
    $countStmt->execute($params);
    $total = (int)$countStmt->fetchColumn();

    $stmt = $pdo->prepare(
        "SELECT j.id, j.title, j.slug, j.company, j.description, j.job_type, j.location, j.status, j.expires_at, j.application_url,
                (SELECT status FROM alumni_job_applications a WHERE a.job_id=j.id AND a.alumni_id=? LIMIT 1) AS my_status,
                (SELECT COUNT(*) FROM alumni_job_applications a WHERE a.job_id=j.id) AS applicants
           FROM alumni_jobs j
          WHERE {$whereSql}
          ORDER BY j.created_at DESC
          LIMIT {$limit} OFFSET {$offset}"
    );
    $stmt->execute(array_merge([$alumniId], $params));

    jsonOut([
        'jobs' => $stmt->fetchAll(),
        'page' => $page,
        'limit' => $limit,
        'total' => $total,
        'total_pages' => max(1, (int)ceil($total / $limit)),
    ]);
}

// ──────────────────────────────────────────────────────────────────────────
// JOB DETAIL
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'detail' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $jobId = (int)((isset($_GET['job_id']) ? $_GET['job_id'] : 0));
    if ($jobId <= 0) jsonOut(['error' => 'job_id required.'], 422);

    $stmt = $pdo->prepare(
        "SELECT j.*,
                (SELECT status FROM alumni_job_applications a WHERE a.job_id=j.id AND a.alumni_id=? LIMIT 1) AS my_status,
                (SELECT COUNT(*) FROM alumni_job_applications a WHERE a.job_id=j.id) AS applicants
           FROM alumni_jobs j
          WHERE j.id=?
          LIMIT 1"
    );
    $stmt->execute([$alumniId, $jobId]);
    $job = $stmt->fetch();
    if (!$job) jsonOut(['error' => 'Job not found.'], 404);

    jsonOut(['job' => $job]);
}

// ──────────────────────────────────────────────────────────────────────────
// SAVE / UNSAVE JOB
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'save' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = (is_array($__json = json_decode(file_get_contents('php://input'), true)) ? $__json : $_POST);
    $jobId = (int)((isset($input['job_id']) ? $input['job_id'] : 0));
    if ($jobId <= 0) jsonOut(['error' => 'job_id required.'], 422);

    if (!apiColumnExists($pdo, 'alumni_job_applications', 'is_saved')) {
        jsonOut(['error' => 'Save feature is not enabled in current schema.'], 501);
    }

    $stmt = $pdo->prepare('SELECT id, is_saved FROM alumni_job_applications WHERE job_id=? AND alumni_id=? LIMIT 1');
    $stmt->execute([$jobId, $alumniId]);
    $row = $stmt->fetch();

    if ($row) {
        $next = ((int)$row['is_saved'] === 1) ? 0 : 1;
        $pdo->prepare('UPDATE alumni_job_applications SET is_saved=?, updated_at=NOW() WHERE id=? LIMIT 1')
            ->execute([$next, $row['id']]);
        jsonOut(['success' => true, 'saved' => $next === 1]);
    }

    $pdo->prepare("INSERT INTO alumni_job_applications (job_id, alumni_id, status, is_saved) VALUES (?, ?, 'saved', 1)")
        ->execute([$jobId, $alumniId]);
    jsonOut(['success' => true, 'saved' => true]);
}

// ──────────────────────────────────────────────────────────────────────────
// ADMIN CREATE JOB
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'admin_create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hasAlumniAdminPrivileges($payload)) jsonOut(['error' => 'Forbidden.'], 403);

    $input = (is_array($__json = json_decode(file_get_contents('php://input'), true)) ? $__json : $_POST);
    $title = trim((string)((isset($input['title']) ? $input['title'] : '')));
    $company = trim((string)((isset($input['company']) ? $input['company'] : '')));
    $description = trim((string)((isset($input['description']) ? $input['description'] : '')));
    $jobType = trim((string)((isset($input['job_type']) ? $input['job_type'] : 'full-time')));
    $status = trim((string)((isset($input['status']) ? $input['status'] : 'draft')));

    if ($title === '' || $company === '' || $description === '') {
        jsonOut(['error' => 'title, company and description are required.'], 422);
    }

    $slug = apiSlug($title) . '-' . time();
    $columns = ['title', 'slug', 'company', 'description', 'job_type', 'status', 'posted_by', 'posted_by_type'];
    $values = [':title', ':slug', ':company', ':description', ':job_type', ':status', ':posted_by', ':posted_by_type'];
    $params = [
        ':title' => $title,
        ':slug' => $slug,
        ':company' => $company,
        ':description' => $description,
        ':job_type' => $jobType,
        ':status' => $status,
        ':posted_by' => $alumniId,
        ':posted_by_type' => 'admin',
    ];

    $optionalFields = ['location', 'requirements', 'salary_min', 'salary_max', 'application_email', 'application_url', 'expires_at'];
    foreach ($optionalFields as $field) {
        if (!apiColumnExists($pdo, 'alumni_jobs', $field) || !array_key_exists($field, $input)) {
            continue;
        }
        $columns[] = $field;
        $values[] = ':' . $field;
        $value = trim((string)$input[$field]);
        $params[':' . $field] = $value === '' ? null : $value;
    }

    $sql = 'INSERT INTO alumni_jobs (' . implode(', ', $columns) . ') VALUES (' . implode(', ', $values) . ')';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    jsonOut(['success' => true, 'job_id' => (int)$pdo->lastInsertId(), 'message' => 'Job created.']);
}

// ──────────────────────────────────────────────────────────────────────────
// ADMIN UPDATE JOB
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'admin_update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hasAlumniAdminPrivileges($payload)) jsonOut(['error' => 'Forbidden.'], 403);

    $input = (is_array($__json = json_decode(file_get_contents('php://input'), true)) ? $__json : $_POST);
    $jobId = (int)((isset($input['job_id']) ? $input['job_id'] : 0));
    if ($jobId <= 0) jsonOut(['error' => 'job_id required.'], 422);

    $allowed = ['title', 'company', 'description', 'job_type', 'status', 'location', 'requirements', 'salary_min', 'salary_max', 'application_email', 'application_url', 'expires_at'];
    $setParts = [];
    $params = [':id' => $jobId];

    foreach ($allowed as $field) {
        if (!array_key_exists($field, $input) || !apiColumnExists($pdo, 'alumni_jobs', $field)) {
            continue;
        }
        $setParts[] = $field . ' = :' . $field;
        $value = trim((string)$input[$field]);
        $params[':' . $field] = $value === '' ? null : $value;
    }
    if (empty($setParts)) jsonOut(['error' => 'No updatable fields provided.'], 422);
    if (apiColumnExists($pdo, 'alumni_jobs', 'updated_at')) {
        $setParts[] = 'updated_at = NOW()';
    }

    $sql = 'UPDATE alumni_jobs SET ' . implode(', ', $setParts) . ' WHERE id = :id LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    jsonOut(['success' => true, 'message' => 'Job updated.']);
}

// ──────────────────────────────────────────────────────────────────────────
// ADMIN DELETE JOB
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'admin_delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hasAlumniAdminPrivileges($payload)) jsonOut(['error' => 'Forbidden.'], 403);

    $input = (is_array($__json = json_decode(file_get_contents('php://input'), true)) ? $__json : $_POST);
    $jobId = (int)((isset($input['job_id']) ? $input['job_id'] : 0));
    if ($jobId <= 0) jsonOut(['error' => 'job_id required.'], 422);

    $pdo->prepare('DELETE FROM alumni_jobs WHERE id=? LIMIT 1')->execute([$jobId]);
    jsonOut(['success' => true, 'message' => 'Job deleted.']);
}

// ──────────────────────────────────────────────────────────────────────────
// CHECK APPLICATION STATUS
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'status' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $jobId = (int)((isset($_GET['job_id']) ? $_GET['job_id'] : 0));
    if (!$jobId) jsonOut(['error' => 'job_id required.'], 422);

    $stmt = $pdo->prepare("SELECT status, applied_at FROM alumni_job_applications WHERE job_id=? AND alumni_id=?");
    $stmt->execute([$jobId, $alumniId]);
    $row = $stmt->fetch();

    jsonOut(['applied' => (bool)$row, 'status' => (isset($row['status']) ? $row['status'] : null), 'applied_at' => (isset($row['applied_at']) ? $row['applied_at'] : null)]);
}

// ──────────────────────────────────────────────────────────────────────────
// APPLY TO JOB
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'apply' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = (is_array($__json = json_decode(file_get_contents('php://input'), true)) ? $__json : $_POST);

    if (!verifyCsrfToken((isset($input['csrf_token']) ? $input['csrf_token'] : ''))) jsonOut(['error' => 'Invalid CSRF token.'], 403);

    $jobId       = (int)((isset($input['job_id']) ? $input['job_id'] : 0));
    $coverLetter = trim((isset($input['cover_letter']) ? $input['cover_letter'] : ''));

    if (!$jobId) jsonOut(['error' => 'job_id required.'], 422);

    // Check job exists and is published
    $jStmt = $pdo->prepare("SELECT id, title FROM alumni_jobs WHERE id=? AND status='published' AND (expires_at IS NULL OR expires_at > NOW())");
    $jStmt->execute([$jobId]);
    $job = $jStmt->fetch();
    if (!$job) jsonOut(['error' => 'Job not found or no longer accepting applications.'], 404);

    // Check for duplicate
    $dup = $pdo->prepare("SELECT id FROM alumni_job_applications WHERE job_id=? AND alumni_id=?");
    $dup->execute([$jobId, $alumniId]);
    if ($dup->fetch()) jsonOut(['error' => 'You have already applied for this position.'], 409);

    // Insert application
    $pdo->prepare("INSERT INTO alumni_job_applications (job_id, alumni_id, cover_letter, status) VALUES (?,?,?,'applied')")
        ->execute([$jobId, $alumniId, $coverLetter ?: null]);

    // Notify applicant
    $pdo->prepare("INSERT INTO alumni_notifications (alumni_id, type, title, body, action_url) VALUES (?,?,?,?,?)")
        ->execute([
            $alumniId, 'job_applied',
            'Application Submitted',
            'You successfully applied for: ' . $job['title'],
            ALUMNI_BASE_URL . '/jobs.php',
        ]);

    // Increment job views handled separately; log application
    $pdo->prepare("UPDATE alumni_jobs SET views = views + 1 WHERE id=?")->execute([$jobId]);

    jsonOut(['success' => true, 'message' => 'Application submitted successfully.']);
}

// ──────────────────────────────────────────────────────────────────────────
// INCREMENT JOB VIEW
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'view' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $viewInput = json_decode(file_get_contents('php://input'), true);
    $jobId = (int)(is_array($viewInput) && isset($viewInput['job_id']) ? $viewInput['job_id'] : 0);
    if ($jobId) $pdo->prepare("UPDATE alumni_jobs SET views=views+1 WHERE id=?")->execute([$jobId]);
    jsonOut(['success' => true]);
}

jsonOut(['error' => 'Invalid action or method.'], 400);
