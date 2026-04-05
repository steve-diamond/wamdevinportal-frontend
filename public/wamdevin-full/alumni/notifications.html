<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/middleware.php';

$authPayload = requireAlumniAuth();
$pdo = getAlumniDB();
$alumniId = (int)$authPayload['sub'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken((isset($_POST['csrf_token']) ? $_POST['csrf_token'] : ''))) {
        setFlash('error', 'Invalid token.');
        redirect(ALUMNI_BASE_URL . '/notifications.php');
    }

    if (!empty($_POST['mark_all'])) {
        $pdo->prepare("UPDATE alumni_notifications SET is_read=1, read_at=NOW() WHERE alumni_id=? AND is_read=0")
            ->execute([$alumniId]);
        setFlash('success', 'All notifications marked as read.');
        redirect(ALUMNI_BASE_URL . '/notifications.php');
    }

    if (!empty($_POST['id'])) {
        $pdo->prepare("UPDATE alumni_notifications SET is_read=1, read_at=NOW() WHERE id=? AND alumni_id=?")
            ->execute([(int)$_POST['id'], $alumniId]);
        redirect(ALUMNI_BASE_URL . '/notifications.php');
    }
}

$stmt = $pdo->prepare("SELECT id, type, title, body, action_url, is_read, created_at
                       FROM alumni_notifications WHERE alumni_id=? ORDER BY created_at DESC LIMIT 100");
$stmt->execute([$alumniId]);
$notifications = $stmt->fetchAll();

$unread = 0;
foreach ($notifications as $n) {
    if (!(int)$n['is_read']) $unread++;
}

$pageTitle = 'Notifications';
$currentPage = 'notifications';
include __DIR__ . '/includes/header.php';
$flash = getFlash();
?>

<div class="flex items-center justify-between mb-5 gap-3 flex-wrap">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Notifications</h1>
        <p class="text-sm text-gray-500 mt-1"><?= $unread ?> unread</p>
    </div>
    <form method="POST">
        <?= csrfField() ?>
        <input type="hidden" name="mark_all" value="1">
        <button class="px-4 py-2 rounded-lg border border-gray-200 text-sm text-gray-700 hover:bg-gray-50">Mark all read</button>
    </form>
</div>

<?php if ($flash): ?>
<div class="mb-4 rounded-xl border px-4 py-3 text-sm <?= $flash['type'] === 'success' ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700' ?>"><?= e($flash['message']) ?></div>
<?php endif; ?>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm divide-y divide-gray-100">
<?php if (!$notifications): ?>
<div class="p-10 text-center text-gray-400"><i class="fa fa-bell-slash text-3xl mb-2 block"></i>No notifications yet.</div>
<?php endif; ?>
<?php foreach ($notifications as $n): ?>
<div class="p-4 flex items-start justify-between gap-4 <?= (int)$n['is_read'] ? '' : 'bg-indigo-50/40' ?>">
    <div class="min-w-0">
        <p class="text-sm font-semibold text-gray-900"><?= e($n['title']) ?></p>
        <?php if (!empty($n['body'])): ?><p class="text-sm text-gray-600 mt-1"><?= e($n['body']) ?></p><?php endif; ?>
        <p class="text-xs text-gray-400 mt-1"><?= date('M j, Y g:i A', strtotime($n['created_at'])) ?></p>
        <?php if (!empty($n['action_url'])): ?><a href="<?= e($n['action_url']) ?>" class="text-xs text-indigo-600 hover:underline mt-1 inline-block">Open</a><?php endif; ?>
    </div>
    <?php if (!(int)$n['is_read']): ?>
    <form method="POST">
        <?= csrfField() ?>
        <input type="hidden" name="id" value="<?= (int)$n['id'] ?>">
        <button class="px-3 py-1.5 rounded-lg border border-gray-200 text-xs text-gray-700 hover:bg-gray-50">Mark read</button>
    </form>
    <?php else: ?>
    <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-500">Read</span>
    <?php endif; ?>
</div>
<?php endforeach; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
