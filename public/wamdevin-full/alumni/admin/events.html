<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/middleware.php';

$authPayload = requireAdminAuth();
$pdo = getAlumniDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken((isset($_POST['csrf_token']) ? $_POST['csrf_token'] : ''))) {
        setFlash('error', 'Invalid request token.');
        redirect(ALUMNI_BASE_URL . '/admin/events.php');
    }

    $id = (int)((isset($_POST['id']) ? $_POST['id'] : 0));
    $title = trim((isset($_POST['title']) ? $_POST['title'] : ''));
    $type = (isset($_POST['event_type']) ? $_POST['event_type'] : 'networking');
    $location = trim((isset($_POST['location']) ? $_POST['location'] : ''));
    $start = (isset($_POST['start_datetime']) ? $_POST['start_datetime'] : '');
    $end = (isset($_POST['end_datetime']) ? $_POST['end_datetime'] : '');
    $status = (isset($_POST['status']) ? $_POST['status'] : 'draft');

    $allowedType = ['networking','webinar','reunion','workshop','conference','social','other'];
    $allowedStatus = ['draft','published','cancelled','completed'];

    if ($title !== '' && in_array($type, $allowedType, true) && in_array($status, $allowedStatus, true)) {
        $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $title), '-'));
        if ($id > 0) {
            $pdo->prepare("UPDATE alumni_events SET title=?, event_type=?, location=?, start_datetime=?, end_datetime=?, status=?, updated_at=NOW() WHERE id=?")
                ->execute([$title, $type, $location ?: null, $start ?: date('Y-m-d H:i:s'), $end ?: date('Y-m-d H:i:s'), $status, $id]);
            setFlash('success', 'Event updated.');
        } else {
            $slug .= '-' . time();
            $pdo->prepare("INSERT INTO alumni_events (title, slug, event_type, location, start_datetime, end_datetime, status, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")
                ->execute([$title, $slug, $type, $location ?: null, $start ?: date('Y-m-d H:i:s'), $end ?: date('Y-m-d H:i:s'), $status, (int)$authPayload['sub']]);
            setFlash('success', 'Event created.');
        }
    }

    redirect(ALUMNI_BASE_URL . '/admin/events.php');
}

$events = $pdo->query("SELECT id, title, event_type, location, start_datetime, end_datetime, status, created_at
                       FROM alumni_events ORDER BY created_at DESC LIMIT 100")->fetchAll();

$pageTitle = 'Manage Events';
$currentPage = 'admin';
include __DIR__ . '/../includes/header.php';
$flash = getFlash();
?>

<div class="mb-5 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-900">Manage Events</h1>
    <a href="<?= ALUMNI_BASE_URL ?>/admin/index.php" class="text-sm text-indigo-600 hover:underline">Back to admin</a>
</div>
<?php if ($flash): ?><div class="mb-4 rounded-xl border px-4 py-3 text-sm <?= $flash['type']==='success' ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700' ?>"><?= e($flash['message']) ?></div><?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <div class="lg:col-span-1 bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <h2 class="font-semibold text-gray-900 mb-3">Create Event</h2>
        <form method="POST" class="space-y-3">
            <?= csrfField() ?>
            <input name="title" required placeholder="Event title" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
            <select name="event_type" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm"><?php foreach (['networking','webinar','reunion','workshop','conference','social','other'] as $t): ?><option value="<?= $t ?>"><?= ucfirst($t) ?></option><?php endforeach; ?></select>
            <input name="location" placeholder="Location or online" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
            <input type="datetime-local" name="start_datetime" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
            <input type="datetime-local" name="end_datetime" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
            <select name="status" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm"><?php foreach (['draft','published','cancelled','completed'] as $s): ?><option value="<?= $s ?>"><?= ucfirst($s) ?></option><?php endforeach; ?></select>
            <button class="w-full bg-indigo-600 text-white rounded-lg px-4 py-2.5 text-sm font-semibold">Create</button>
        </form>
    </div>

    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600"><tr><th class="px-4 py-3 text-left">Title</th><th class="px-4 py-3 text-left">Type</th><th class="px-4 py-3 text-left">Schedule</th><th class="px-4 py-3 text-left">Status</th></tr></thead>
            <tbody class="divide-y divide-gray-100">
            <?php foreach ($events as $e): ?>
            <tr>
                <td class="px-4 py-3"><p class="font-medium text-gray-900"><?= e($e['title']) ?></p><p class="text-xs text-gray-500"><?= e($e['location'] ?: 'N/A') ?></p></td>
                <td class="px-4 py-3"><?= e($e['event_type']) ?></td>
                <td class="px-4 py-3 text-xs text-gray-500"><?= date('M j, Y g:i A', strtotime($e['start_datetime'])) ?></td>
                <td class="px-4 py-3"><span class="px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-700"><?= e($e['status']) ?></span></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
