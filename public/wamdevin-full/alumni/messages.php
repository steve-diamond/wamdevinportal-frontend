<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/middleware.php';

$authPayload = requireAlumniAuth();
$pdo = getAlumniDB();
$alumniId = (int)$authPayload['sub'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken((isset($_POST['csrf_token']) ? $_POST['csrf_token'] : ''))) {
        setFlash('error', 'Invalid token.');
        redirect(ALUMNI_BASE_URL . '/messages.php');
    }

    $receiverId = (int)((isset($_POST['receiver_id']) ? $_POST['receiver_id'] : 0));
    $body = trim((isset($_POST['body']) ? $_POST['body'] : ''));

    if ($receiverId > 0 && $body !== '' && $receiverId !== $alumniId) {
        $threadA = min($alumniId, $receiverId);
        $threadB = max($alumniId, $receiverId);
        $thread = $threadA . '_' . $threadB;

        $stmt = $pdo->prepare("INSERT INTO alumni_messages (thread_id, sender_id, receiver_id, body) VALUES (?, ?, ?, ?)");
        $stmt->execute([$thread, $alumniId, $receiverId, $body]);

        $pdo->prepare("INSERT INTO alumni_notifications (alumni_id, type, title, body, action_url)
                       VALUES (?, 'message', 'New message received', ?, ?)")
            ->execute([$receiverId, mb_substr($body, 0, 120), ALUMNI_BASE_URL . '/messages.php?to=' . $alumniId]);

        redirect(ALUMNI_BASE_URL . '/messages.php?to=' . $receiverId);
    }

    setFlash('error', 'Please select a recipient and enter a message.');
    redirect(ALUMNI_BASE_URL . '/messages.php');
}

$threadsStmt = $pdo->prepare("SELECT m.thread_id, MAX(m.created_at) as last_at,
                     SUBSTRING_INDEX(GROUP_CONCAT(m.body ORDER BY m.created_at DESC SEPARATOR '||'), '||', 1) as last_message,
                     CASE WHEN MAX(CASE WHEN m.sender_id=? THEN 1 ELSE 0 END)=1
                          THEN SUBSTRING_INDEX(MAX(CASE WHEN m.sender_id=? THEN CONCAT('S:',m.receiver_id) ELSE CONCAT('R:',m.sender_id) END),':',-1)
                          ELSE SUBSTRING_INDEX(MAX(CASE WHEN m.sender_id=? THEN CONCAT('S:',m.receiver_id) ELSE CONCAT('R:',m.sender_id) END),':',-1)
                     END as other_id
                FROM alumni_messages m
               WHERE m.sender_id=? OR m.receiver_id=?
            GROUP BY m.thread_id
            ORDER BY last_at DESC");
$threadsStmt->execute([$alumniId, $alumniId, $alumniId, $alumniId, $alumniId]);
$threadsRaw = $threadsStmt->fetchAll();

$threads = [];
foreach ($threadsRaw as $t) {
    $otherId = (int)$t['other_id'];
    if ($otherId <= 0) continue;
    $u = $pdo->prepare("SELECT a.id,a.first_name,a.last_name,a.email,a.avatar,ap.current_title
                        FROM alumni a LEFT JOIN alumni_profiles ap ON ap.alumni_id=a.id WHERE a.id=? LIMIT 1");
    $u->execute([$otherId]);
    $person = $u->fetch();
    if ($person) {
        $threads[] = ['thread_id' => $t['thread_id'], 'last_at' => $t['last_at'], 'last_message' => $t['last_message'], 'person' => $person];
    }
}

$to = (int)((isset($_GET['to']) ? $_GET['to'] : 0));
$selectedUser = null;
$messages = [];
if ($to > 0 && $to !== $alumniId) {
    $u = $pdo->prepare("SELECT a.id,a.first_name,a.last_name,a.email,a.avatar,ap.current_title,ap.current_company
                        FROM alumni a LEFT JOIN alumni_profiles ap ON ap.alumni_id=a.id
                        WHERE a.id=? AND a.status='active' LIMIT 1");
    $u->execute([$to]);
    $selectedUser = $u->fetch();

    if ($selectedUser) {
        $thread = min($alumniId, $to) . '_' . max($alumniId, $to);
        $m = $pdo->prepare("SELECT * FROM alumni_messages WHERE thread_id=? ORDER BY created_at ASC LIMIT 200");
        $m->execute([$thread]);
        $messages = $m->fetchAll();

        $pdo->prepare("UPDATE alumni_messages SET is_read=1, read_at=NOW() WHERE thread_id=? AND receiver_id=? AND is_read=0")
            ->execute([$thread, $alumniId]);
    }
}

$pageTitle = 'Messages';
$currentPage = 'messages';
include __DIR__ . '/includes/header.php';
$flash = getFlash();
?>

<?php if ($flash): ?>
<div class="mb-4 rounded-xl border px-4 py-3 text-sm <?= $flash['type'] === 'success' ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700' ?>"><?= e($flash['message']) ?></div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900">Conversations</h2>
        </div>
        <div class="max-h-[70vh] overflow-y-auto divide-y divide-gray-100">
            <?php if (!$threads): ?><div class="p-6 text-sm text-gray-500">No conversations yet. Start one from the directory.</div><?php endif; ?>
            <?php foreach ($threads as $t): ?>
            <a href="<?= ALUMNI_BASE_URL ?>/messages.php?to=<?= (int)$t['person']['id'] ?>" class="flex items-start gap-3 p-4 hover:bg-gray-50 <?= $to === (int)$t['person']['id'] ? 'bg-indigo-50/50' : '' ?>">
                <img src="<?= e(getAvatarUrl((isset($t['person']['avatar']) ? $t['person']['avatar'] : null), (isset($t['person']['email']) ? $t['person']['email'] : ''), 42)) ?>" class="w-10 h-10 rounded-xl object-cover border border-gray-200">
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate"><?= e($t['person']['first_name'] . ' ' . $t['person']['last_name']) ?></p>
                    <p class="text-xs text-gray-500 truncate"><?= e($t['last_message']) ?></p>
                    <p class="text-xs text-gray-400 mt-0.5"><?= date('M j, g:i A', strtotime($t['last_at'])) ?></p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col" style="min-height:70vh;">
        <?php if (!$selectedUser): ?>
        <div class="flex-1 p-10 text-center text-gray-400 flex flex-col justify-center">
            <i class="fa fa-envelope-open-text text-4xl mb-3"></i>
            <p>Select a conversation to start messaging.</p>
        </div>
        <?php else: ?>
        <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-3">
            <img src="<?= e(getAvatarUrl((isset($selectedUser['avatar']) ? $selectedUser['avatar'] : null), (isset($selectedUser['email']) ? $selectedUser['email'] : ''), 42)) ?>" class="w-10 h-10 rounded-xl object-cover border border-gray-200">
            <div>
                <p class="font-semibold text-gray-900"><?= e($selectedUser['first_name'] . ' ' . $selectedUser['last_name']) ?></p>
                <p class="text-xs text-gray-500"><?= e($selectedUser['current_title'] ?: 'Alumni Member') ?></p>
            </div>
        </div>

        <div class="flex-1 p-5 space-y-3 overflow-y-auto bg-gray-50" style="max-height:52vh;">
            <?php if (!$messages): ?><p class="text-sm text-gray-500">No messages yet. Say hello.</p><?php endif; ?>
            <?php foreach ($messages as $m): ?>
            <?php $mine = (int)$m['sender_id'] === $alumniId; ?>
            <div class="flex <?= $mine ? 'justify-end' : 'justify-start' ?>">
                <div class="max-w-[80%] rounded-2xl px-4 py-2.5 text-sm <?= $mine ? 'bg-indigo-600 text-white' : 'bg-white border border-gray-200 text-gray-800' ?>">
                    <p><?= nl2br(e($m['body'])) ?></p>
                    <p class="text-[10px] mt-1 <?= $mine ? 'text-indigo-100' : 'text-gray-400' ?>"><?= date('M j, g:i A', strtotime($m['created_at'])) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <form method="POST" class="p-4 border-t border-gray-100 flex items-end gap-2">
            <?= csrfField() ?>
            <input type="hidden" name="receiver_id" value="<?= (int)$selectedUser['id'] ?>">
            <textarea name="body" rows="2" required placeholder="Write a message..." class="flex-1 border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200"></textarea>
            <button class="bg-indigo-600 text-white rounded-xl px-4 py-2.5 text-sm font-semibold hover:bg-indigo-700"><i class="fa fa-paper-plane"></i></button>
        </form>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
