<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/middleware.php';

$authPayload = requireAdminAuth();
$pdo = getAlumniDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken((isset($_POST['csrf_token']) ? $_POST['csrf_token'] : ''))) {
        setFlash('error', 'Invalid request token.');
        redirect(ALUMNI_BASE_URL . '/admin/jobs.php');
    }

    $title = trim((isset($_POST['title']) ? $_POST['title'] : ''));
    $company = trim((isset($_POST['company']) ? $_POST['company'] : ''));
    $description = trim((isset($_POST['description']) ? $_POST['description'] : ''));
    $type = (isset($_POST['job_type']) ? $_POST['job_type'] : 'full-time');
    $location = trim((isset($_POST['location']) ? $_POST['location'] : ''));
    $status = (isset($_POST['status']) ? $_POST['status'] : 'draft');

    $allowedType = ['full-time','part-time','contract','internship','remote','freelance'];
    $allowedStatus = ['draft','published','expired','closed'];

    if ($title !== '' && $company !== '' && $description !== '' && in_array($type, $allowedType, true) && in_array($status, $allowedStatus, true)) {
        $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $title), '-')) . '-' . time();
        $stmt = $pdo->prepare("INSERT INTO alumni_jobs (title, slug, company, description, job_type, location, status, posted_by, posted_by_type)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'admin')");
        $stmt->execute([$title, $slug, $company, $description, $type, $location ?: null, $status, (int)$authPayload['sub']]);
        setFlash('success', 'Job posted successfully.');
    } else {
        setFlash('error', 'Please complete required job fields.');
    }

    redirect(ALUMNI_BASE_URL . '/admin/jobs.php');
}

$jobs = $pdo->query("SELECT id, title, company, job_type, location, status, created_at FROM alumni_jobs ORDER BY created_at DESC LIMIT 120")->fetchAll();

$pageTitle = 'Manage Jobs';
$currentPage = 'admin';
include __DIR__ . '/../includes/header.php';
$flash = getFlash();
?>

<div class="mb-5 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-900">Manage Jobs</h1>
    <a href="<?= ALUMNI_BASE_URL ?>/admin/index.php" class="text-sm text-indigo-600 hover:underline">Back to admin</a>
</div>
<?php if ($flash): ?><div class="mb-4 rounded-xl border px-4 py-3 text-sm <?= $flash['type']==='success' ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700' ?>"><?= e($flash['message']) ?></div><?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <h2 class="font-semibold text-gray-900 mb-3">Post Job</h2>
        <form method="POST" class="space-y-3">
            <?= csrfField() ?>
            <input name="title" required placeholder="Job title" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
            <input name="company" required placeholder="Company" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
            <textarea name="description" rows="4" required placeholder="Description" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm"></textarea>
            <select name="job_type" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm"><?php foreach (['full-time','part-time','contract','internship','remote','freelance'] as $t): ?><option value="<?= $t ?>"><?= ucwords(str_replace('-', ' ', $t)) ?></option><?php endforeach; ?></select>
            <input name="location" placeholder="Location" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
            <select name="status" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm"><?php foreach (['draft','published','expired','closed'] as $s): ?><option value="<?= $s ?>"><?= ucfirst($s) ?></option><?php endforeach; ?></select>
            <button class="w-full bg-indigo-600 text-white rounded-lg px-4 py-2.5 text-sm font-semibold">Publish Job</button>
        </form>
    </div>

    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600"><tr><th class="text-left px-4 py-3">Job</th><th class="text-left px-4 py-3">Type</th><th class="text-left px-4 py-3">Status</th><th class="text-left px-4 py-3">Date</th></tr></thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach ($jobs as $j): ?>
                <tr>
                    <td class="px-4 py-3"><p class="font-medium text-gray-900"><?= e($j['title']) ?></p><p class="text-xs text-gray-500"><?= e($j['company']) ?><?= $j['location'] ? ' · ' . e($j['location']) : '' ?></p></td>
                    <td class="px-4 py-3"><?= e($j['job_type']) ?></td>
                    <td class="px-4 py-3"><span class="px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-700"><?= e($j['status']) ?></span></td>
                    <td class="px-4 py-3 text-xs text-gray-500"><?= date('M j, Y', strtotime($j['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
