<?php
/**
 * Alumni deployment preflight checker
 * Usage: php alumni/scripts/preflight.php
 */

$root = dirname(__DIR__);
$projectRoot = dirname($root);

require_once $root . '/includes/config.php';

$results = [];

function addResult(&$results, $name, $ok, $detail)
{
    $results[] = [
        'name' => $name,
        'ok' => (bool)$ok,
        'detail' => $detail,
    ];
}

function tableExists($pdo, $table)
{
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = ?");
    $stmt->execute([$table]);
    return (int)$stmt->fetchColumn() > 0;
}

function columnExists($pdo, $table, $column)
{
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = ? AND column_name = ?");
    $stmt->execute([$table, $column]);
    return (int)$stmt->fetchColumn() > 0;
}

function connectForChecks()
{
    try {
        $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO(
            $dsn,
            DB_USER,
            DB_PASS,
            array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            )
        );
        return array($pdo, null);
    } catch (Exception $e) {
        return array(null, $e->getMessage());
    }
}

// PHP version
addResult(
    $results,
    'PHP version',
    version_compare(PHP_VERSION, '5.6.0', '>='),
    'Detected ' . PHP_VERSION . ' (recommended >= 7.4)'
);

// Extensions
$requiredExt = ['pdo', 'pdo_mysql', 'mbstring', 'openssl', 'json'];
foreach ($requiredExt as $ext) {
    addResult($results, 'Extension: ' . $ext, extension_loaded($ext), extension_loaded($ext) ? 'Loaded' : 'Missing');
}

// Required files
$requiredFiles = [
    $root . '/includes/config.php',
    $root . '/includes/middleware.php',
    $root . '/includes/JWTAuth.php',
    $root . '/api/auth.php',
    $root . '/api/events.php',
    $root . '/api/jobs.php',
    $root . '/api/news.php',
    $root . '/api/donations.php',
    $root . '/admin/index.php',
    $root . '/index.php',
];
foreach ($requiredFiles as $file) {
    addResult($results, 'File exists: ' . str_replace($projectRoot . DIRECTORY_SEPARATOR, '', $file), file_exists($file), file_exists($file) ? 'OK' : 'Missing');
}

// Upload directory
$uploadDir = $projectRoot . '/assets/uploads/alumni';
$uploadExists = is_dir($uploadDir);
$uploadWritable = $uploadExists ? is_writable($uploadDir) : false;
addResult($results, 'Upload directory exists', $uploadExists, $uploadDir);
addResult($results, 'Upload directory writable', $uploadWritable, $uploadDir);

// DB connection and table checks
list($pdo, $dbError) = connectForChecks();
if ($pdo) {
    addResult($results, 'Database connection', true, 'Connected to ' . DB_NAME);

    $requiredTables = [
        'alumni',
        'alumni_profiles',
        'alumni_events',
        'alumni_event_registrations',
        'alumni_jobs',
        'alumni_job_applications',
        'alumni_news',
        'alumni_donations',
        'donation_campaigns',
        'alumni_notifications',
        'alumni_messages',
        'alumni_connections',
        'jwt_blacklist',
    ];

    foreach ($requiredTables as $table) {
        addResult($results, 'Table: ' . $table, tableExists($pdo, $table), tableExists($pdo, $table) ? 'Present' : 'Missing');
    }

    $columnChecks = [
        ['alumni', 'email'],
        ['alumni', 'password_hash'],
        ['alumni', 'role'],
        ['alumni_profiles', 'graduation_year'],
        ['alumni_profiles', 'degree'],
        ['alumni_events', 'title'],
        ['alumni_events', 'start_datetime'],
        ['alumni_jobs', 'title'],
        ['alumni_jobs', 'company'],
        ['alumni_news', 'title'],
        ['alumni_donations', 'amount'],
        ['alumni_donations', 'payment_status'],
    ];

    foreach ($columnChecks as $check) {
        $table = $check[0];
        $column = $check[1];
        addResult($results, 'Column: ' . $table . '.' . $column, columnExists($pdo, $table, $column), columnExists($pdo, $table, $column) ? 'Present' : 'Missing');
    }
} else {
    addResult($results, 'Database connection', false, $dbError ?: 'Connection failed');
}

$passed = 0;
$failed = 0;
foreach ($results as $r) {
    if ($r['ok']) {
        $passed++;
    } else {
        $failed++;
    }
}

echo "WAMDEVIN Alumni Preflight\n";
echo "========================\n";
foreach ($results as $r) {
    $state = $r['ok'] ? 'PASS' : 'FAIL';
    echo '[' . $state . '] ' . $r['name'] . ' - ' . $r['detail'] . "\n";
}
echo "------------------------\n";
echo 'Summary: ' . $passed . ' passed, ' . $failed . " failed\n";

exit($failed > 0 ? 1 : 0);
