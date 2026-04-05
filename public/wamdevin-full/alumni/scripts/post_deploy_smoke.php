<?php
/**
 * Alumni post-deploy smoke checker
 * Usage: php alumni/scripts/post_deploy_smoke.php
 */

$root = dirname(__DIR__);
require_once $root . '/includes/config.php';

$checks = [];

function addCheck(&$checks, $name, $ok, $detail)
{
    $checks[] = [
        'name' => $name,
        'ok' => (bool)$ok,
        'detail' => $detail,
    ];
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

list($pdo, $dbError) = connectForChecks();
if ($pdo) {
    addCheck($checks, 'DB connect', true, 'Connected');

    $counts = [
        'alumni' => 'SELECT COUNT(*) FROM alumni',
        'events' => 'SELECT COUNT(*) FROM alumni_events',
        'jobs' => 'SELECT COUNT(*) FROM alumni_jobs',
        'news' => 'SELECT COUNT(*) FROM alumni_news',
        'donations' => 'SELECT COUNT(*) FROM alumni_donations',
    ];

    foreach ($counts as $label => $sql) {
        $count = (int)$pdo->query($sql)->fetchColumn();
        addCheck($checks, 'Row count: ' . $label, true, (string)$count);
    }
} else {
    addCheck($checks, 'DB connect', false, $dbError ?: 'Connection failed');
}

$routeFiles = [
    $root . '/landing.php',
    $root . '/login.php',
    $root . '/register.php',
    $root . '/index.php',
    $root . '/profile.php',
    $root . '/events.php',
    $root . '/jobs.php',
    $root . '/news.php',
    $root . '/donate.php',
    $root . '/attendance.php',
    $root . '/admin/index.php',
    $root . '/admin/users.php',
    $root . '/admin/events.php',
    $root . '/admin/jobs.php',
    $root . '/admin/news.php',
    $root . '/admin/donations.php',
];

foreach ($routeFiles as $file) {
    addCheck($checks, 'Route file', file_exists($file), basename($file));
}

$passed = 0;
$failed = 0;
foreach ($checks as $c) {
    if ($c['ok']) {
        $passed++;
    } else {
        $failed++;
    }
}

echo "WAMDEVIN Alumni Post-Deploy Smoke\n";
echo "=================================\n";
foreach ($checks as $c) {
    echo '[' . ($c['ok'] ? 'PASS' : 'FAIL') . '] ' . $c['name'] . ' - ' . $c['detail'] . "\n";
}
echo "---------------------------------\n";
echo 'Summary: ' . $passed . ' passed, ' . $failed . " failed\n";

exit($failed > 0 ? 1 : 0);
