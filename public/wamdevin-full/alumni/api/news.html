<?php
/**
 * WAMDEVIN Alumni Portal - News API
 * Endpoints:
 *   GET  ?action=list
 *   GET  ?action=detail&news_id=
 *   POST ?action=admin_create
 *   POST ?action=admin_update
 *   POST ?action=admin_delete
 */
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/middleware.php';

$pdo = getAlumniDB();
$payload = getAuthPayload();
$action = (isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : ''));

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

if ($action === 'list' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $limit = max(1, min(100, (int)((isset($_GET['limit']) ? $_GET['limit'] : 20))));
    $page = max(1, (int)((isset($_GET['page']) ? $_GET['page'] : 1)));
    $offset = ($page - 1) * $limit;
    $status = trim((string)((isset($_GET['status']) ? $_GET['status'] : 'published')));
    $category = trim((string)((isset($_GET['category']) ? $_GET['category'] : '')));
    $search = trim((string)((isset($_GET['search']) ? $_GET['search'] : '')));

    $where = ['1=1'];
    $params = [];

    if ($status !== '') {
        $where[] = 'n.status = ?';
        $params[] = $status;
    }
    if ($category !== '') {
        $where[] = 'n.category = ?';
        $params[] = $category;
    }
    if ($search !== '') {
        $where[] = '(n.title LIKE ? OR n.excerpt LIKE ? OR n.content LIKE ?)';
        $like = '%' . $search . '%';
        array_push($params, $like, $like, $like);
    }

    $whereSql = implode(' AND ', $where);
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM alumni_news n WHERE {$whereSql}");
    $countStmt->execute($params);
    $total = (int)$countStmt->fetchColumn();

    $stmt = $pdo->prepare(
        "SELECT n.id, n.title, n.slug, n.excerpt, n.content, n.image, n.category, n.status, n.is_featured, n.views,
                n.published_at, n.created_at,
                a.first_name, a.last_name
           FROM alumni_news n
           LEFT JOIN alumni a ON a.id = n.author_id
          WHERE {$whereSql}
          ORDER BY COALESCE(n.published_at, n.created_at) DESC
          LIMIT {$limit} OFFSET {$offset}"
    );
    $stmt->execute($params);

    jsonOut([
        'news' => $stmt->fetchAll(),
        'page' => $page,
        'limit' => $limit,
        'total' => $total,
        'total_pages' => max(1, (int)ceil($total / $limit)),
    ]);
}

if ($action === 'detail' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $newsId = (int)((isset($_GET['news_id']) ? $_GET['news_id'] : 0));
    if ($newsId <= 0) jsonOut(['error' => 'news_id required.'], 422);

    $stmt = $pdo->prepare(
        'SELECT n.*, a.first_name, a.last_name
           FROM alumni_news n
      LEFT JOIN alumni a ON a.id = n.author_id
          WHERE n.id = ?
          LIMIT 1'
    );
    $stmt->execute([$newsId]);
    $row = $stmt->fetch();
    if (!$row) jsonOut(['error' => 'News not found.'], 404);

    if (apiColumnExists($pdo, 'alumni_news', 'views')) {
        $pdo->prepare('UPDATE alumni_news SET views = views + 1 WHERE id = ?')->execute([$newsId]);
    }

    jsonOut(['news' => $row]);
}

if (!$payload && !hasAlumniAdminPrivileges(null)) {
    jsonOut(['error' => 'Authentication required.'], 401);
}

$actorId = $payload ? (int)$payload['sub'] : 1;

if ($action === 'admin_create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hasAlumniAdminPrivileges($payload)) jsonOut(['error' => 'Forbidden.'], 403);

    $input = (is_array($__json = json_decode(file_get_contents('php://input'), true)) ? $__json : $_POST);
    $title = trim((string)((isset($input['title']) ? $input['title'] : '')));
    $content = trim((string)((isset($input['content']) ? $input['content'] : '')));
    if ($title === '' || $content === '') jsonOut(['error' => 'title and content are required.'], 422);

    $slug = apiSlug($title) . '-' . time();
    $status = trim((string)((isset($input['status']) ? $input['status'] : 'draft')));
    $publishedAt = $status === 'published' ? date('Y-m-d H:i:s') : null;

    $columns = ['title', 'slug', 'content', 'status', 'author_id'];
    $values = [':title', ':slug', ':content', ':status', ':author_id'];
    $params = [
        ':title' => $title,
        ':slug' => $slug,
        ':content' => $content,
        ':status' => $status,
        ':author_id' => $actorId,
    ];

    $optional = ['excerpt', 'category', 'image', 'is_featured'];
    foreach ($optional as $field) {
        if (!array_key_exists($field, $input) || !apiColumnExists($pdo, 'alumni_news', $field)) {
            continue;
        }
        $columns[] = $field;
        $values[] = ':' . $field;
        if ($field === 'is_featured') {
            $params[':' . $field] = (int)!empty($input[$field]);
        } else {
            $value = trim((string)$input[$field]);
            $params[':' . $field] = $value === '' ? null : $value;
        }
    }

    if (apiColumnExists($pdo, 'alumni_news', 'published_at')) {
        $columns[] = 'published_at';
        $values[] = ':published_at';
        $params[':published_at'] = $publishedAt;
    }

    $sql = 'INSERT INTO alumni_news (' . implode(', ', $columns) . ') VALUES (' . implode(', ', $values) . ')';
    $pdo->prepare($sql)->execute($params);

    jsonOut(['success' => true, 'news_id' => (int)$pdo->lastInsertId(), 'message' => 'News created.']);
}

if ($action === 'admin_update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hasAlumniAdminPrivileges($payload)) jsonOut(['error' => 'Forbidden.'], 403);

    $input = (is_array($__json = json_decode(file_get_contents('php://input'), true)) ? $__json : $_POST);
    $newsId = (int)((isset($input['news_id']) ? $input['news_id'] : 0));
    if ($newsId <= 0) jsonOut(['error' => 'news_id required.'], 422);

    $allowed = ['title', 'excerpt', 'content', 'category', 'image', 'status', 'is_featured'];
    $setParts = [];
    $params = [':id' => $newsId];

    foreach ($allowed as $field) {
        if (!array_key_exists($field, $input) || !apiColumnExists($pdo, 'alumni_news', $field)) {
            continue;
        }
        $setParts[] = $field . ' = :' . $field;
        if ($field === 'is_featured') {
            $params[':' . $field] = (int)!empty($input[$field]);
        } else {
            $value = trim((string)$input[$field]);
            $params[':' . $field] = $value === '' ? null : $value;
        }
    }

    if (array_key_exists('status', $input) && $input['status'] === 'published' && apiColumnExists($pdo, 'alumni_news', 'published_at')) {
        $setParts[] = 'published_at = COALESCE(published_at, NOW())';
    }

    if (apiColumnExists($pdo, 'alumni_news', 'updated_at')) {
        $setParts[] = 'updated_at = NOW()';
    }

    if (empty($setParts)) jsonOut(['error' => 'No updatable fields provided.'], 422);

    $sql = 'UPDATE alumni_news SET ' . implode(', ', $setParts) . ' WHERE id = :id LIMIT 1';
    $pdo->prepare($sql)->execute($params);

    jsonOut(['success' => true, 'message' => 'News updated.']);
}

if ($action === 'admin_delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hasAlumniAdminPrivileges($payload)) jsonOut(['error' => 'Forbidden.'], 403);

    $input = (is_array($__json = json_decode(file_get_contents('php://input'), true)) ? $__json : $_POST);
    $newsId = (int)((isset($input['news_id']) ? $input['news_id'] : 0));
    if ($newsId <= 0) jsonOut(['error' => 'news_id required.'], 422);

    $pdo->prepare('DELETE FROM alumni_news WHERE id = ? LIMIT 1')->execute([$newsId]);
    jsonOut(['success' => true, 'message' => 'News deleted.']);
}

jsonOut(['error' => 'Invalid action or method.'], 400);
