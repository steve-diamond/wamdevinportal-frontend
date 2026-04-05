<?php
/**
 * WAMDEVIN Alumni Portal - Attendance
 *
 * Shows a member's event attendance history and allows marking attendance
 * for past events they registered for.
 *
 * @version 1.0.0
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/middleware.php';

$authPayload = requireAlumniAuth();
$pdo         = getAlumniDB();
$alumniId    = isset($authPayload['sub']) ? (int)$authPayload['sub'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['action']) ? $_POST['action'] : '') === 'mark_attended') {
    if (!verifyCsrfToken(isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '')) {
        setFlash('error', 'Invalid CSRF token. Please try again.');
        redirect(ALUMNI_BASE_URL . '/attendance.php');
    }

    $eventId = isset($_POST['event_id']) ? (int)$_POST['event_id'] : 0;
    if ($eventId <= 0) {
        setFlash('error', 'Invalid event selected.');
        redirect(ALUMNI_BASE_URL . '/attendance.php');
    }

    $stmt = $pdo->prepare("SELECT r.id, r.status, e.start_datetime
                             FROM alumni_event_registrations r
                             JOIN alumni_events e ON e.id = r.event_id
                            WHERE r.event_id = ?
                              AND r.alumni_id = ?
                            LIMIT 1");
    $stmt->execute([$eventId, $alumniId]);
    $registration = $stmt->fetch();

    if (!$registration) {
        setFlash('error', 'Registration record not found for this event.');
        redirect(ALUMNI_BASE_URL . '/attendance.php');
    }

    if ($registration['status'] === 'attended') {
        setFlash('success', 'Attendance already recorded for this event.');
        redirect(ALUMNI_BASE_URL . '/attendance.php');
    }

    if ($registration['status'] !== 'registered') {
        setFlash('error', 'Only active registrations can be marked as attended.');
        redirect(ALUMNI_BASE_URL . '/attendance.php');
    }

    if (strtotime((string)$registration['start_datetime']) > time()) {
        setFlash('error', 'You can only mark attendance after the event starts.');
        redirect(ALUMNI_BASE_URL . '/attendance.php');
    }

    $upd = $pdo->prepare("UPDATE alumni_event_registrations
                             SET status = 'attended', updated_at = NOW()
                           WHERE id = ?
                           LIMIT 1");
    $upd->execute([(int)$registration['id']]);

    setFlash('success', 'Attendance marked successfully.');
    redirect(ALUMNI_BASE_URL . '/attendance.php');
}

$listStmt = $pdo->prepare("SELECT
        e.id,
        e.title,
        e.location,
        e.start_datetime,
        e.end_datetime,
        e.event_type,
        r.status,
        r.registered_at,
        r.updated_at
    FROM alumni_event_registrations r
    INNER JOIN alumni_events e ON e.id = r.event_id
    WHERE r.alumni_id = ?
    ORDER BY e.start_datetime DESC, r.registered_at DESC");
$listStmt->execute([$alumniId]);
$records = $listStmt->fetchAll() ?: [];

$stats = [
    'registered' => 0,
    'attended' => 0,
    'cancelled' => 0,
];

foreach ($records as $rec) {
    $status = isset($rec['status']) ? strtolower((string)$rec['status']) : '';
    if (array_key_exists($status, $stats)) {
        $stats[$status]++;
    }
}

$pageTitle   = 'Attendance';
$currentPage = 'attendance';
include __DIR__ . '/includes/header.php';

function attendanceBadgeClass($status)
{
    if ($status === 'registered') return 'bg-blue-100 text-blue-700';
    if ($status === 'attended') return 'bg-green-100 text-green-700';
    if ($status === 'cancelled') return 'bg-red-100 text-red-700';
    return 'bg-gray-100 text-gray-700';
}
?>

<div class="mb-7">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">My Attendance</h1>
    <p class="text-gray-500 text-sm mt-1">Track your event participation and mark attended events.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <p class="text-xs uppercase tracking-wide text-gray-400">Registered</p>
        <p class="text-2xl font-bold text-blue-600 mt-1"><?= (int)$stats['registered'] ?></p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <p class="text-xs uppercase tracking-wide text-gray-400">Attended</p>
        <p class="text-2xl font-bold text-green-600 mt-1"><?= (int)$stats['attended'] ?></p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <p class="text-xs uppercase tracking-wide text-gray-400">Cancelled</p>
        <p class="text-2xl font-bold text-red-600 mt-1"><?= (int)$stats['cancelled'] ?></p>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="font-semibold text-gray-900 text-sm">Attendance History</h2>
        <a href="<?= ALUMNI_BASE_URL ?>/events.php" class="text-sm text-indigo-600 hover:underline">
            Browse Events
        </a>
    </div>

    <?php if (empty($records)): ?>
    <div class="p-10 text-center text-gray-400">
        <i class="fa fa-calendar-xmark text-4xl mb-2 block"></i>
        <p class="text-gray-700 font-medium">No attendance records yet.</p>
        <p class="text-sm mt-1">Register for an event to see it here.</p>
    </div>
    <?php else: ?>
    <div class="divide-y divide-gray-100">
        <?php foreach ($records as $row): ?>
        <?php
            $startTs = strtotime((string)$row['start_datetime']);
            $isPast = $startTs !== false ? $startTs <= time() : false;
            $canMarkAttended = $isPast && $row['status'] === 'registered';
            $statusLabel = ucfirst((string)$row['status']);
        ?>
        <div class="p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="min-w-0">
                <a href="<?= ALUMNI_BASE_URL ?>/events.php?id=<?= (int)$row['id'] ?>" class="font-semibold text-gray-900 hover:text-indigo-600 transition-colors block truncate">
                    <?= e($row['title']) ?>
                </a>
                <div class="mt-1 text-sm text-gray-500 flex flex-wrap gap-x-4 gap-y-1">
                    <span><i class="fa fa-calendar mr-1"></i><?= date('M j, Y g:i A', $startTs ?: time()) ?></span>
                    <?php if (!empty($row['location'])): ?>
                    <span><i class="fa fa-map-pin mr-1"></i><?= e($row['location']) ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <span class="px-3 py-1 rounded-full text-xs font-semibold <?= attendanceBadgeClass((string)$row['status']) ?>">
                    <?= e($statusLabel) ?>
                </span>

                <?php if ($canMarkAttended): ?>
                <form method="post" class="inline-flex">
                    <?= csrfField() ?>
                    <input type="hidden" name="action" value="mark_attended">
                    <input type="hidden" name="event_id" value="<?= (int)$row['id'] ?>">
                    <button type="submit" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-green-600 text-white text-xs font-semibold hover:bg-green-700 transition-colors">
                        <i class="fa fa-check"></i> Mark Attended
                    </button>
                </form>
                <?php elseif ($row['status'] === 'registered' && !$isPast): ?>
                <span class="text-xs text-gray-500">Awaiting event day</span>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
