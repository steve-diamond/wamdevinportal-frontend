<?php
/**
 * WAMDEVIN Alumni Portal - Donations API
 * Endpoints:
 *   POST ?action=initiate  – create a pending donation record, return reference
 *   POST ?action=verify    – mark donation complete (webhook / manual verify)
 *   GET  ?action=history   – alumni's own donation history
 *   GET  ?action=campaigns – list active campaigns
 */
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/middleware.php';

$pdo    = getAlumniDB();
$action = (isset($_GET['action']) ? $_GET['action'] : '');

function jsonOut( $d, $c = 200) { http_response_code($c); echo json_encode($d); exit; }

// ──────────────────────────────────────────────────────────────────────────
// CAMPAIGNS (public endpoint – no auth needed)
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'campaigns' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $campaigns = $pdo->query("
        SELECT c.id, c.title, c.slug, c.description, c.goal_amount, c.currency,
               c.start_date, c.end_date, c.image,
               COALESCE(SUM(d.amount),0) AS raised_amount,
               COUNT(d.id)              AS donor_count
          FROM donation_campaigns c
          LEFT JOIN alumni_donations d ON d.campaign = c.slug AND d.payment_status='completed'
         WHERE c.status='active'
         GROUP BY c.id
         ORDER BY c.created_at DESC
    ")->fetchAll();
    jsonOut(['campaigns' => $campaigns]);
}

// – authenticated endpoints below –
$payload = getAuthPayload();
if (!$payload && !hasAlumniAdminPrivileges(null) && !in_array($action, ['campaigns'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Authentication required.']);
    exit;
}

$alumniId = $payload ? (int)$payload['sub'] : null;

// ──────────────────────────────────────────────────────────────────────────
// INITIATE DONATION — create pending record
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'initiate' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = (is_array($__json = json_decode(file_get_contents('php://input'), true)) ? $__json : $_POST);

    if (!verifyCsrfToken((isset($input['csrf_token']) ? $input['csrf_token'] : ''))) jsonOut(['error' => 'Invalid CSRF token.'], 403);

    $amount      = round((float)((isset($input['amount']) ? $input['amount'] : 0)), 2);
    $currency    = strtoupper(trim((isset($input['currency']) ? $input['currency'] : 'USD')));
    $campaign    = trim((isset($input['campaign']) ? $input['campaign'] : ''));
    $message     = trim((isset($input['message']) ? $input['message'] : ''));
    $isAnonymous = !empty($input['is_anonymous']) ? 1 : 0;
    $isRecurring = !empty($input['is_recurring']) ? 1 : 0;
    $interval    = in_array((isset($input['recurring_interval']) ? $input['recurring_interval'] : ''), ['monthly','quarterly','annually'])
                   ? $input['recurring_interval'] : null;

    $allowedCurrencies = ['USD','NGN','GHS','EUR','GBP','XOF'];
    if ($amount < 1) jsonOut(['error' => 'Minimum donation is 1.'], 422);
    if ($amount > 1000000) jsonOut(['error' => 'Donation amount exceeds maximum.'], 422);
    if (!in_array($currency, $allowedCurrencies)) jsonOut(['error' => 'Invalid currency.'], 422);

    // Donor info
    if ($payload) {
        $dStmt = $pdo->prepare("SELECT first_name, last_name, email FROM alumni WHERE id=?");
        $dStmt->execute([$alumniId]);
        $donor = $dStmt->fetch();
        $donorName  = $donor['first_name'] . ' ' . $donor['last_name'];
        $donorEmail = $donor['email'];
    } else {
        $donorName  = trim((isset($input['donor_name']) ? $input['donor_name'] : 'Anonymous'));
        $donorEmail = trim((isset($input['donor_email']) ? $input['donor_email'] : ''));
        if (!filter_var($donorEmail, FILTER_VALIDATE_EMAIL)) jsonOut(['error' => 'Valid email required.'], 422);
    }

    // Unique payment reference
    $reference = 'WAM-' . strtoupper(bin2hex(random_bytes(8))) . '-' . time();

    $pdo->prepare("
        INSERT INTO alumni_donations
            (alumni_id, donor_name, donor_email, amount, currency, campaign, message,
             is_anonymous, is_recurring, recurring_interval, payment_reference,
             payment_status, payment_gateway)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,'pending','paystack')
    ")->execute([
        $alumniId, $donorName, $donorEmail, $amount, $currency,
        $campaign ?: null, $message ?: null,
        $isAnonymous, $isRecurring, $isRecurring ? $interval : null,
        $reference,
    ]);

    $donationId = (int)$pdo->lastInsertId();

    jsonOut([
        'success'    => true,
        'donation_id'=> $donationId,
        'reference'  => $reference,
        'amount'     => $amount,
        'currency'   => $currency,
    ]);
}

// ──────────────────────────────────────────────────────────────────────────
// VERIFY / COMPLETE DONATION (called after payment gateway callback)
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'verify' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $input     = (is_array($__json = json_decode(file_get_contents('php://input'), true)) ? $__json : $_POST);
    $reference = trim((isset($input['reference']) ? $input['reference'] : ''));
    $gateway   = trim((isset($input['gateway']) ? $input['gateway'] : 'paystack'));

    if (!$reference) jsonOut(['error' => 'Payment reference required.'], 422);

    $stmt = $pdo->prepare("SELECT id, payment_status, alumni_id FROM alumni_donations WHERE payment_reference=?");
    $stmt->execute([$reference]);
    $donation = $stmt->fetch();

    if (!$donation) jsonOut(['error' => 'Donation record not found.'], 404);
    if ($donation['payment_status'] === 'completed') jsonOut(['success' => true, 'message' => 'Already verified.']);

    // In production: call Paystack/Flutterwave verify endpoint here before updating
    $pdo->prepare("UPDATE alumni_donations SET payment_status='completed', payment_gateway=?, updated_at=NOW() WHERE payment_reference=?")
        ->execute([$gateway, $reference]);

    // Notify donor if logged in
    if ($donation['alumni_id']) {
        $pdo->prepare("INSERT INTO alumni_notifications (alumni_id,type,title,body,action_url) VALUES (?,?,?,?,?)")
            ->execute([
                $donation['alumni_id'], 'donation_received',
                'Donation Confirmed', 'Thank you! Your donation has been received and processed.',
                ALUMNI_BASE_URL . '/donate.php',
            ]);
    }

    jsonOut(['success' => true, 'message' => 'Donation verified and recorded.']);
}

// ──────────────────────────────────────────────────────────────────────────
// DONATION HISTORY (current alumni)
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'history' && $_SERVER['REQUEST_METHOD'] === 'GET' && $alumniId) {
    $stmt = $pdo->prepare("
        SELECT id, amount, currency, campaign, message, is_anonymous, is_recurring,
               payment_status, payment_reference, created_at
          FROM alumni_donations
         WHERE alumni_id = ?
         ORDER BY created_at DESC
         LIMIT 50
    ");
    $stmt->execute([$alumniId]);
    jsonOut(['donations' => $stmt->fetchAll()]);
}

// ──────────────────────────────────────────────────────────────────────────
// ADMIN DONATION REPORT
// ──────────────────────────────────────────────────────────────────────────
if ($action === 'admin_report' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!hasAlumniAdminPrivileges($payload)) jsonOut(['error' => 'Forbidden.'], 403);

    $status = trim((string)((isset($_GET['status']) ? $_GET['status'] : '')));
    $limit = max(1, min(200, (int)((isset($_GET['limit']) ? $_GET['limit'] : 50))));
    $page = max(1, (int)((isset($_GET['page']) ? $_GET['page'] : 1)));
    $offset = ($page - 1) * $limit;

    $where = ['1=1'];
    $params = [];
    if ($status !== '') {
        $where[] = 'd.payment_status = ?';
        $params[] = $status;
    }
    $whereSql = implode(' AND ', $where);

    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM alumni_donations d WHERE {$whereSql}");
    $countStmt->execute($params);
    $totalRows = (int)$countStmt->fetchColumn();

    $stmt = $pdo->prepare(
        "SELECT d.id, d.alumni_id, d.donor_name, d.donor_email, d.amount, d.currency, d.campaign, d.payment_reference,
                d.payment_status, d.created_at,
                a.first_name, a.last_name
           FROM alumni_donations d
           LEFT JOIN alumni a ON a.id = d.alumni_id
          WHERE {$whereSql}
          ORDER BY d.created_at DESC
          LIMIT {$limit} OFFSET {$offset}"
    );
    $stmt->execute($params);
    $rows = $stmt->fetchAll();

    $stats = [
        'completed_total' => (float)$pdo->query("SELECT COALESCE(SUM(amount),0) FROM alumni_donations WHERE payment_status='completed'")->fetchColumn(),
        'completed_count' => (int)$pdo->query("SELECT COUNT(*) FROM alumni_donations WHERE payment_status='completed'")->fetchColumn(),
        'pending_count' => (int)$pdo->query("SELECT COUNT(*) FROM alumni_donations WHERE payment_status='pending'")->fetchColumn(),
    ];

    jsonOut([
        'stats' => $stats,
        'rows' => $rows,
        'page' => $page,
        'limit' => $limit,
        'total' => $totalRows,
        'total_pages' => max(1, (int)ceil($totalRows / $limit)),
    ]);
}

jsonOut(['error' => 'Invalid action or method.'], 400);
