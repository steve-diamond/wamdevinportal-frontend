<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/middleware.php';

$authPayload = requireAlumniAuth();
$pdo = getAlumniDB();
$alumniId = (int)$authPayload['sub'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ((isset($_POST['action']) ? $_POST['action'] : '')) === 'apply') {
    if (!verifyCsrfToken((isset($_POST['csrf_token']) ? $_POST['csrf_token'] : ''))) {
        setFlash('error', 'Invalid request token.');
        redirect(ALUMNI_BASE_URL . '/jobs.php');
    }

    $jobId = (int)((isset($_POST['job_id']) ? $_POST['job_id'] : 0));
    $cover = trim((isset($_POST['cover_letter']) ? $_POST['cover_letter'] : ''));

    try {
        $exists = $pdo->prepare("SELECT id FROM alumni_job_applications WHERE job_id=? AND alumni_id=?");
        $exists->execute([$jobId, $alumniId]);
        if ($exists->fetch()) {
            setFlash('error', 'You already applied for this job.');
        } else {
            $stmt = $pdo->prepare("INSERT INTO alumni_job_applications (job_id, alumni_id, cover_letter, status) VALUES (?, ?, ?, 'applied')");
            $stmt->execute([$jobId, $alumniId, $cover ?: null]);
            setFlash('success', 'Application submitted successfully.');
        }
    } catch (PDOException $e) {
        error_log('job apply error: ' . $e->getMessage());
        setFlash('error', 'Could not submit application.');
    }
    redirect(ALUMNI_BASE_URL . '/jobs.php' . (!empty($_GET['id']) ? '?id=' . (int)$_GET['id'] : ''));
}

$jobId = (int)((isset($_GET['id']) ? $_GET['id'] : 0));
$search = trim((isset($_GET['search']) ? $_GET['search'] : ''));
$type = trim((isset($_GET['type']) ? $_GET['type'] : ''));

if ($jobId > 0) {
    $detailStmt = $pdo->prepare("SELECT j.*,
        (SELECT COUNT(*) FROM alumni_job_applications a WHERE a.job_id=j.id) as applicants,
        (SELECT status FROM alumni_job_applications a WHERE a.job_id=j.id AND a.alumni_id=? LIMIT 1) as my_status
        FROM alumni_jobs j WHERE j.id=? AND j.status='published' LIMIT 1");
    $detailStmt->execute([$alumniId, $jobId]);
    $job = $detailStmt->fetch();
} else {
    $job = null;
}

$where = ["status='published'", "(expires_at IS NULL OR expires_at > NOW())"];
$params = [];
if ($search !== '') {
    $where[] = "(title LIKE ? OR company LIKE ? OR description LIKE ? OR location LIKE ?)";
    $like = '%' . $search . '%';
    array_push($params, $like, $like, $like, $like);
}
if ($type !== '') {
    $where[] = "job_type=?";
    $params[] = $type;
}
$whereSql = implode(' AND ', $where);

$list = $pdo->prepare("SELECT id, title, company, job_type, location, is_remote, created_at, expires_at,
        (SELECT status FROM alumni_job_applications a WHERE a.job_id=alumni_jobs.id AND a.alumni_id=? LIMIT 1) as my_status
        FROM alumni_jobs WHERE {$whereSql} ORDER BY created_at DESC LIMIT 40");
$list->execute(array_merge([$alumniId], $params));
$jobs = $list->fetchAll();

$myAppsStmt = $pdo->prepare("SELECT a.status, a.applied_at, j.id, j.title, j.company
                             FROM alumni_job_applications a JOIN alumni_jobs j ON j.id=a.job_id
                             WHERE a.alumni_id=? ORDER BY a.applied_at DESC LIMIT 8");
$myAppsStmt->execute([$alumniId]);
$myApps = $myAppsStmt->fetchAll();

$pageTitle = $job ? $job['title'] : 'Jobs';
$currentPage = 'jobs';
include __DIR__ . '/includes/header.php';
$flash = getFlash();
?>

<?php if ($flash): ?>
<div class="mb-4 rounded-xl border px-4 py-3 text-sm <?= $flash['type'] === 'success' ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700' ?>">
    <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<?php if ($job): ?>
<div class="mb-4"><a href="<?= ALUMNI_BASE_URL ?>/jobs.php" class="text-sm text-gray-500 hover:text-gray-700"><i class="fa fa-arrow-left mr-1"></i>Back to Jobs</a></div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h1 class="text-2xl font-bold text-gray-900"><?= e($job['title']) ?></h1>
        <p class="text-indigo-600 font-medium mt-1"><?= e($job['company']) ?></p>
        <div class="flex flex-wrap gap-2 mt-3 text-xs">
            <span class="px-2 py-1 rounded-full bg-indigo-50 text-indigo-700"><?= e($job['job_type']) ?></span>
            <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-700"><?= e($job['location'] ?: 'Location not specified') ?></span>
            <?php if (!empty($job['is_remote'])): ?><span class="px-2 py-1 rounded-full bg-emerald-50 text-emerald-700">Remote</span><?php endif; ?>
        </div>
        <div class="prose max-w-none mt-6 text-sm text-gray-700"><?= nl2br(e(strip_tags((string)$job['description']))) ?></div>
        <?php if (!empty($job['requirements'])): ?>
        <h3 class="font-semibold text-gray-900 mt-6 mb-2">Requirements</h3>
        <p class="text-sm text-gray-700 leading-relaxed"><?= nl2br(e(strip_tags((string)$job['requirements']))) ?></p>
        <?php endif; ?>
    </div>
    <div class="space-y-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h2 class="font-semibold text-gray-900 text-sm mb-3">Application</h2>
            <?php if ($job['my_status']): ?>
            <p class="text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-3 py-2">You already applied. Status: <?= e($job['my_status']) ?></p>
            <?php elseif (!empty($job['application_url'])): ?>
            <a href="<?= e($job['application_url']) ?>" target="_blank" rel="noopener" class="inline-flex w-full justify-center bg-indigo-600 text-white rounded-lg px-4 py-2 text-sm font-semibold hover:bg-indigo-700">Apply on Company Site</a>
            <?php else: ?>
            <form method="POST" class="space-y-3">
                <?= csrfField() ?>
                <input type="hidden" name="action" value="apply">
                <input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>">
                <textarea name="cover_letter" rows="4" placeholder="Optional cover letter" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200"></textarea>
                <button class="w-full bg-indigo-600 text-white rounded-lg px-4 py-2 text-sm font-semibold hover:bg-indigo-700">Submit Application</button>
            </form>
            <?php endif; ?>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-sm text-gray-600 space-y-2">
            <p><i class="fa fa-users mr-2 text-gray-400"></i><?= (int)$job['applicants'] ?> applicant(s)</p>
            <p><i class="fa fa-clock mr-2 text-gray-400"></i>Posted <?= date('M j, Y', strtotime($job['created_at'])) ?></p>
            <?php if (!empty($job['expires_at'])): ?><p><i class="fa fa-hourglass-end mr-2 text-gray-400"></i>Expires <?= date('M j, Y', strtotime($job['expires_at'])) ?></p><?php endif; ?>
        </div>
    </div>
</div>
<?php else: ?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-5">
            <form class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="search" value="<?= e($search) ?>" placeholder="Search jobs, companies, locations" class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200">
                <select name="type" class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm">
                    <option value="">All Types</option>
                    <?php foreach (['full-time','part-time','contract','internship','remote','freelance'] as $jt): ?>
                    <option value="<?= e($jt) ?>" <?= $type === $jt ? 'selected' : '' ?>><?= e(ucwords(str_replace('-', ' ', $jt))) ?></option>
                    <?php endforeach; ?>
                </select>
                <button class="bg-indigo-600 text-white rounded-xl px-4 py-2.5 text-sm font-semibold">Search</button>
            </form>
        </div>
        <div class="space-y-3">
            <?php if (!$jobs): ?>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-10 text-center text-gray-400"><i class="fa fa-briefcase text-3xl mb-2 block"></i>No jobs found.</div>
            <?php endif; ?>
            <?php foreach ($jobs as $j): ?>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <a href="<?= ALUMNI_BASE_URL ?>/jobs.php?id=<?= (int)$j['id'] ?>" class="font-semibold text-gray-900 hover:text-indigo-600"><?= e($j['title']) ?></a>
                        <p class="text-sm text-indigo-600 mt-0.5"><?= e($j['company']) ?></p>
                        <p class="text-xs text-gray-500 mt-1"><i class="fa fa-map-pin mr-1"></i><?= e($j['location'] ?: 'Flexible') ?><?= !empty($j['is_remote']) ? ' · Remote' : '' ?> · <?= e($j['job_type']) ?></p>
                    </div>
                    <div class="text-right text-xs">
                        <?php if ($j['my_status']): ?><span class="px-2 py-1 rounded-full bg-green-50 text-green-700">Applied</span><?php endif; ?>
                        <p class="text-gray-400 mt-1"><?= date('M j, Y', strtotime($j['created_at'])) ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <h2 class="font-semibold text-gray-900 text-sm mb-3">My Applications</h2>
            <div class="space-y-3">
                <?php if (!$myApps): ?><p class="text-sm text-gray-500">No applications yet.</p><?php endif; ?>
                <?php foreach ($myApps as $app): ?>
                <a href="<?= ALUMNI_BASE_URL ?>/jobs.php?id=<?= (int)$app['id'] ?>" class="block border border-gray-100 rounded-lg p-3 hover:bg-gray-50">
                    <p class="text-sm font-medium text-gray-900"><?= e($app['title']) ?></p>
                    <p class="text-xs text-gray-500"><?= e($app['company']) ?></p>
                    <span class="inline-block mt-1 text-xs px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700"><?= e($app['status']) ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
