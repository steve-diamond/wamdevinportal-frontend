<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/middleware.php';

$authPayload = requireAdminAuth();
$pdo = getAlumniDB();

$stats = [
    'alumni' => (int)$pdo->query("SELECT COUNT(*) FROM alumni WHERE deleted_at IS NULL")->fetchColumn(),
    'events' => (int)$pdo->query("SELECT COUNT(*) FROM alumni_events")->fetchColumn(),
    'jobs' => (int)$pdo->query("SELECT COUNT(*) FROM alumni_jobs")->fetchColumn(),
    'news' => (int)$pdo->query("SELECT COUNT(*) FROM alumni_news")->fetchColumn(),
    'donations' => (float)$pdo->query("SELECT COALESCE(SUM(amount),0) FROM alumni_donations WHERE payment_status='completed'")->fetchColumn(),
];

$pageTitle = 'Alumni Admin';
$currentPage = 'admin';
include __DIR__ . '/../includes/header.php';
?>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Alumni Admin Console</h1>
    <p class="text-sm text-gray-500 mt-1">Manage alumni users, events, jobs, and news.</p>
</div>

<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-100 p-4"><p class="text-xs text-gray-500">Alumni</p><p class="text-2xl font-bold text-gray-900"><?= number_format($stats['alumni']) ?></p></div>
    <div class="bg-white rounded-xl border border-gray-100 p-4"><p class="text-xs text-gray-500">Events</p><p class="text-2xl font-bold text-gray-900"><?= number_format($stats['events']) ?></p></div>
    <div class="bg-white rounded-xl border border-gray-100 p-4"><p class="text-xs text-gray-500">Jobs</p><p class="text-2xl font-bold text-gray-900"><?= number_format($stats['jobs']) ?></p></div>
    <div class="bg-white rounded-xl border border-gray-100 p-4"><p class="text-xs text-gray-500">News</p><p class="text-2xl font-bold text-gray-900"><?= number_format($stats['news']) ?></p></div>
    <div class="bg-white rounded-xl border border-gray-100 p-4"><p class="text-xs text-gray-500">Donations</p><p class="text-2xl font-bold text-gray-900">$<?= number_format($stats['donations'],2) ?></p></div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <a href="<?= ALUMNI_BASE_URL ?>/admin/users.php" class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition block">
        <h2 class="font-semibold text-gray-900">Manage Alumni Users</h2>
        <p class="text-sm text-gray-600 mt-1">Approve, suspend, and update roles.</p>
    </a>
    <a href="<?= ALUMNI_BASE_URL ?>/admin/events.php" class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition block">
        <h2 class="font-semibold text-gray-900">Manage Events</h2>
        <p class="text-sm text-gray-600 mt-1">Create and publish alumni events.</p>
    </a>
    <a href="<?= ALUMNI_BASE_URL ?>/admin/jobs.php" class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition block">
        <h2 class="font-semibold text-gray-900">Manage Jobs</h2>
        <p class="text-sm text-gray-600 mt-1">Post and moderate jobs.</p>
    </a>
    <a href="<?= ALUMNI_BASE_URL ?>/admin/news.php" class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition block">
        <h2 class="font-semibold text-gray-900">Manage News</h2>
        <p class="text-sm text-gray-600 mt-1">Publish announcements and stories.</p>
    </a>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
