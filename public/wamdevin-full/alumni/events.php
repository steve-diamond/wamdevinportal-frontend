<?php
/**
 * WAMDEVIN Alumni Portal - Events
 * List, detail view, and RSVP functionality for alumni events.
 *
 * @version 1.0.0
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/middleware.php';

$authPayload = requireAlumniAuth();
$pdo         = getAlumniDB();
$alumniId    = (int)$authPayload['sub'];

// ─── RSVP handler ─────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'rsvp') {
    if (!verifyCsrfToken((isset($_POST['csrf_token']) ? $_POST['csrf_token'] : ''))) {
        setFlash('error', 'Invalid CSRF token. Please try again.');
        redirect(ALUMNI_BASE_URL . '/events.php');
    }
    $eventId = (int)((isset($_POST['event_id']) ? $_POST['event_id'] : 0));
    // Check event exists and registration is open
    $ev = $pdo->prepare("SELECT id, max_attendees, registration_deadline, status FROM alumni_events WHERE id=? AND status='published'");
    $ev->execute([$eventId]);
    $event = $ev->fetch();
    if (!$event) { setFlash('error', 'Event not found.'); redirect(ALUMNI_BASE_URL . '/events.php'); }
    if ($event['registration_deadline'] && strtotime($event['registration_deadline']) < time()) {
        setFlash('error', 'Registration has closed for this event.'); redirect(ALUMNI_BASE_URL . '/events.php?id=' . $eventId);
    }
    // Count current registrations
    $cs = $pdo->prepare("SELECT COUNT(*) FROM alumni_event_registrations WHERE event_id=? AND status='registered'");
    $cs->execute([$eventId]);
    $regCount = (int)$cs->fetchColumn();
    if ($event['max_attendees'] && $regCount >= $event['max_attendees']) {
        setFlash('error', 'Sorry, this event is fully booked.'); redirect(ALUMNI_BASE_URL . '/events.php?id=' . $eventId);
    }
    // Existing registration?
    $existS = $pdo->prepare("SELECT id, status FROM alumni_event_registrations WHERE event_id=? AND alumni_id=?"); $existS->execute([$eventId, $alumniId]);
    $existing = $existS->fetch();
    if ($existing) {
        if ($existing['status'] === 'registered') {
            // Cancel
            $pdo->prepare("UPDATE alumni_event_registrations SET status='cancelled',updated_at=NOW() WHERE id=?")->execute([$existing['id']]);
            setFlash('success', 'Your registration has been cancelled.');
        } else {
            // Re-register
            $pdo->prepare("UPDATE alumni_event_registrations SET status='registered',updated_at=NOW() WHERE id=?")->execute([$existing['id']]);
            setFlash('success', 'You have re-registered for this event!');
        }
    } else {
        $pdo->prepare("INSERT INTO alumni_event_registrations (event_id,alumni_id,status,registered_at) VALUES(?,?,'registered',NOW())")->execute([$eventId, $alumniId]);
        setFlash('success', 'Successfully registered for the event!');
    }
    redirect(ALUMNI_BASE_URL . '/events.php?id=' . $eventId);
}

// ─── Single event detail ───────────────────────────────────────────────────
$eventId = (int)((isset($_GET['id']) ? $_GET['id'] : 0));
if ($eventId) {
    $stmt = $pdo->prepare("SELECT e.*, a.first_name, a.last_name,
           (SELECT COUNT(*) FROM alumni_event_registrations r WHERE r.event_id=e.id AND r.status='registered') as reg_count,
           (SELECT status FROM alumni_event_registrations r WHERE r.event_id=e.id AND r.alumni_id=? LIMIT 1) as my_status
           FROM alumni_events e
           LEFT JOIN alumni a ON a.id=e.created_by
           WHERE e.id=? AND e.status='published'");
    $stmt->execute([$alumniId, $eventId]);
    $detail = $stmt->fetch();

    // Attendees (public, limited to 12 avatars)
    $attStmt = $pdo->prepare("
        SELECT a.first_name, a.last_name, a.avatar, a.email
          FROM alumni_event_registrations r
          JOIN alumni a ON a.id=r.alumni_id
         WHERE r.event_id=? AND r.status='registered'
         ORDER BY r.registered_at ASC LIMIT 12
    ");
    $attStmt->execute([$eventId]);
    $attendees = $attStmt->fetchAll();
}

// ─── Events listing ────────────────────────────────────────────────────────
$filterType = trim((isset($_GET['type']) ? $_GET['type'] : ''));
$filterMonth = trim((isset($_GET['month']) ? $_GET['month'] : ''));
$page    = max(1, (int)((isset($_GET['p']) ? $_GET['p'] : 1)));
$perPage = 9;
$offset  = ($page - 1) * $perPage;

$where  = ["e.status='published'"];
$params = [];
if ($filterType) { $where[] = "e.event_type=?"; $params[] = $filterType; }
if ($filterMonth) { $where[] = "DATE_FORMAT(e.start_datetime,'%Y-%m')=?"; $params[] = $filterMonth; }
$whereSql = implode(' AND ', $where);

$countStmt = $pdo->prepare("SELECT COUNT(*) FROM alumni_events e WHERE {$whereSql}"); $countStmt->execute($params);
$total     = (int)$countStmt->fetchColumn();
$totalPages = (int)ceil($total / $perPage);

$listStmt = $pdo->prepare("
    SELECT e.*,
           (SELECT COUNT(*) FROM alumni_event_registrations r WHERE r.event_id=e.id AND r.status='registered') as reg_count,
           (SELECT status FROM alumni_event_registrations r WHERE r.event_id=e.id AND r.alumni_id=? LIMIT 1) as my_status
      FROM alumni_events e
     WHERE {$whereSql}
    ORDER BY e.start_datetime ASC
     LIMIT {$perPage} OFFSET {$offset}
");
$listStmt->execute(array_merge([$alumniId], $params));
$eventsList = $listStmt->fetchAll();

// Upcoming count for filter badge
$upcoming = $pdo->query("SELECT COUNT(*) FROM alumni_events WHERE status='published' AND start_datetime >= NOW()")->fetchColumn();

$pageTitle   = isset($detail) ? e($detail['title']) : 'Events';
$currentPage = 'events';
include __DIR__ . '/includes/header.php';

function eventTypeLabel($type) {
    switch ($type) {
        case 'conference':
            return 'Conference';
        case 'webinar':
            return 'Webinar';
        case 'workshop':
            return 'Workshop';
        case 'networking':
            return 'Networking';
        case 'reunion':
            return 'Reunion';
        default:
            return ucfirst($type);
    }
}
function eventTypeBadge($type) {
    switch ($type) {
        case 'conference':
            return 'bg-blue-100 text-blue-700';
        case 'webinar':
            return 'bg-purple-100 text-purple-700';
        case 'workshop':
            return 'bg-yellow-100 text-yellow-700';
        case 'networking':
            return 'bg-green-100 text-green-700';
        case 'reunion':
            return 'bg-pink-100 text-pink-700';
        default:
            return 'bg-gray-100 text-gray-700';
    }
}
?>

<?php if (isset($detail)): ?>
<!-- ===================== SINGLE EVENT DETAIL ===================== -->
<div class="mb-4">
    <a href="<?= ALUMNI_BASE_URL ?>/events.php" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700">
        <i class="fa fa-arrow-left text-xs"></i> Back to Events
    </a>
</div>

<?php if (!$detail): ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center text-gray-400">
    <i class="fa fa-calendar-xmark text-4xl mb-3 block"></i>
    <p class="font-medium text-gray-700">Event not found.</p>
</div>
<?php else: ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <?php if (!empty($detail['image'])): ?>
            <img src="<?= e($detail['image']) ?>" class="w-full h-52 object-cover" alt="">
            <?php else: ?>
            <div class="h-32 bg-gradient-to-r from-wam-navy to-indigo-600 flex items-center justify-center">
                <i class="fa fa-calendar-days text-5xl text-white/40"></i>
            </div>
            <?php endif; ?>
            <div class="p-6">
                <div class="flex flex-wrap gap-2 mb-3">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold <?= eventTypeBadge($detail['event_type']) ?>"><?= eventTypeLabel($detail['event_type']) ?></span>
                    <?php if (!empty($detail['is_virtual'])): ?>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-cyan-100 text-cyan-700">Virtual</span>
                    <?php endif; ?>
                    <?php if ($detail['my_status'] === 'registered'): ?>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700"><i class="fa fa-check mr-1"></i>Registered</span>
                    <?php endif; ?>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2"><?= e($detail['title']) ?></h1>
                <?php if (!empty($detail['description'])): ?>
                <div class="prose prose-sm text-gray-600 max-w-none leading-relaxed"><?= nl2br(e($detail['description'])) ?></div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Attendees -->
        <?php if (!empty($attendees)): ?>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h2 class="font-bold text-gray-900 text-sm mb-3 flex items-center gap-2">
                <i class="fa fa-users text-indigo-500"></i> Attendees (<?= $detail['reg_count'] ?>)
            </h2>
            <div class="flex flex-wrap gap-2">
                <?php foreach ($attendees as $att): ?>
                <div class="flex items-center gap-2 bg-gray-50 rounded-lg px-2 py-1.5">
                    <img src="<?= e(getAvatarUrl((isset($att['avatar']) ? $att['avatar'] : null), $att['email'], 32)) ?>"
                         class="w-7 h-7 rounded-full object-cover border border-gray-200"
                         onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($att['first_name'].' '.$att['last_name']) ?>&size=32&background=6366f1&color=fff'">
                    <span class="text-xs text-gray-700"><?= e($att['first_name'] . ' ' . $att['last_name']) ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar -->
    <div class="space-y-4">
        <!-- RSVP Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h2 class="font-bold text-gray-900 text-sm mb-4">Event Details</h2>
            <div class="space-y-3 text-sm mb-5">
                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center flex-shrink-0">
                        <i class="fa fa-calendar text-indigo-500 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Date</p>
                        <p class="font-medium text-gray-800"><?= date('D, M j Y', strtotime($detail['start_datetime'])) ?></p>
                        <?php if ($detail['end_datetime'] && $detail['end_datetime'] !== $detail['start_datetime']): ?>
                        <p class="text-gray-500 text-xs">to <?= date('D, M j Y', strtotime($detail['end_datetime'])) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if (!empty($detail['location'])): ?>
                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-lg bg-pink-50 flex items-center justify-center flex-shrink-0">
                        <i class="fa fa-map-pin text-pink-500 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Location</p>
                        <p class="font-medium text-gray-800"><?= e($detail['location']) ?></p>
                        <?php if (!empty($detail['is_virtual']) && !empty($detail['virtual_link'])): ?>
                        <a href="<?= e($detail['virtual_link']) ?>" target="_blank" rel="noopener noreferrer" class="text-xs text-indigo-600 hover:underline">Join Online</a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php if (!empty($detail['price'])): ?>
                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0">
                        <i class="fa fa-ticket text-green-500 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Fee</p>
                        <p class="font-medium text-gray-800">$<?= number_format($detail['price'], 2) ?></p>
                    </div>
                </div>
                <?php else: ?>
                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0">
                        <i class="fa fa-ticket text-green-500 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Registration</p>
                        <p class="font-medium text-green-700">Free</p>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($detail['max_attendees']): ?>
                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-lg bg-yellow-50 flex items-center justify-center flex-shrink-0">
                        <i class="fa fa-users text-yellow-500 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Capacity</p>
                        <p class="font-medium text-gray-800"><?= $detail['reg_count'] ?>/<?= $detail['max_attendees'] ?> registered</p>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1.5">
                            <div class="bg-indigo-500 h-1.5 rounded-full" style="width:<?= min(100, round($detail['reg_count'] / $detail['max_attendees'] * 100)) ?>%"></div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- RSVP button -->
            <?php
            $regDeadlinePassed = $detail['registration_deadline'] && strtotime($detail['registration_deadline']) < time();
            $evenStarted = strtotime($detail['start_datetime']) < time();
            $isFull = $detail['max_attendees'] && $detail['reg_count'] >= $detail['max_attendees'] && $detail['my_status'] !== 'registered';
            ?>
            <?php if ($evenStarted): ?>
            <p class="text-xs text-center text-gray-400">This event has already started.</p>
            <?php elseif ($regDeadlinePassed): ?>
            <p class="text-xs text-center text-gray-400">Registration has closed.</p>
            <?php elseif ($isFull): ?>
            <p class="text-xs text-center text-orange-600 font-medium">This event is fully booked.</p>
            <?php else: ?>
            <form method="POST">
                <?= csrfField() ?>
                <input type="hidden" name="action" value="rsvp">
                <input type="hidden" name="event_id" value="<?= $detail['id'] ?>">
                <button type="submit" class="w-full py-2.5 rounded-xl text-sm font-semibold transition
                    <?= $detail['my_status'] === 'registered'
                        ? 'bg-red-50 text-red-700 hover:bg-red-100 border border-red-200'
                        : 'bg-indigo-600 text-white hover:bg-indigo-700' ?>">
                    <?= $detail['my_status'] === 'registered' ? 'Cancel Registration' : 'Register Now' ?>
                </button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php else: ?>
<!-- ===================== EVENTS LISTING ===================== -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Events</h1>
        <p class="text-gray-500 text-sm mt-0.5"><?= $upcoming ?> upcoming event<?= $upcoming != 1 ? 's' : '' ?></p>
    </div>
</div>

<!-- Filter Bar -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6 flex flex-wrap gap-3 items-center">
    <?php
    $types = ['conference','webinar','workshop','networking','reunion','other'];
    ?>
    <span class="text-sm text-gray-500 font-medium">Filter:</span>
    <a href="?" class="px-3 py-1.5 rounded-xl text-sm font-medium transition
        <?= !$filterType ? 'bg-indigo-600 text-white' : 'border border-gray-200 text-gray-600 hover:bg-gray-50' ?>">All</a>
    <?php foreach ($types as $t): ?>
    <a href="?type=<?= $t ?>" class="px-3 py-1.5 rounded-xl text-sm font-medium transition
        <?= $filterType === $t ? 'bg-indigo-600 text-white' : 'border border-gray-200 text-gray-600 hover:bg-gray-50' ?>">
        <?= eventTypeLabel($t) ?>
    </a>
    <?php endforeach; ?>
</div>

<?php if (empty($eventsList)): ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center text-gray-400">
    <i class="fa fa-calendar-xmark text-4xl mb-3 block"></i>
    <p class="font-medium text-gray-700">No events found.</p>
</div>
<?php else: ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-6">
    <?php foreach ($eventsList as $ev): ?>
    <?php
    $isPast = strtotime($ev['start_datetime']) < time();
    $isFull = $ev['max_attendees'] && $ev['reg_count'] >= $ev['max_attendees'];
    ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col overflow-hidden card-hover">
        <?php if (!empty($ev['image'])): ?>
        <img src="<?= e($ev['image']) ?>" class="w-full h-36 object-cover" alt="">
        <?php else: ?>
        <div class="h-20 bg-gradient-to-r from-wam-navy to-indigo-600 relative">
            <div class="absolute bottom-3 left-4 flex gap-2">
                <span class="px-2 py-0.5 rounded-full text-xs font-semibold <?= eventTypeBadge($ev['event_type']) ?>"><?= eventTypeLabel($ev['event_type']) ?></span>
                <?php if (!empty($ev['is_virtual'])): ?>
                <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-cyan-100 text-cyan-700">Virtual</span>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        <div class="p-5 flex flex-col flex-1">
            <!-- Date badge -->
            <div class="flex items-start justify-between mb-3">
                <div class="bg-indigo-50 rounded-xl p-2 text-center w-12 flex-shrink-0">
                    <p class="text-indigo-600 font-bold text-lg leading-none"><?= date('d', strtotime($ev['start_datetime'])) ?></p>
                    <p class="text-indigo-400 text-xs font-medium"><?= date('M', strtotime($ev['start_datetime'])) ?></p>
                </div>
                <div class="flex gap-1.5">
                    <?php if ($ev['my_status'] === 'registered'): ?>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">Going</span>
                    <?php elseif ($isPast): ?>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-400">Past</span>
                    <?php elseif ($isFull): ?>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-600">Full</span>
                    <?php endif; ?>
                </div>
            </div>
            <a href="?id=<?= $ev['id'] ?>">
                <h3 class="font-bold text-gray-900 mb-1 hover:text-indigo-600 transition"><?= e($ev['title']) ?></h3>
            </a>
            <?php if (!empty($ev['location'])): ?>
            <p class="text-xs text-gray-400 mb-2"><i class="fa fa-map-pin mr-1"></i><?= e($ev['location']) ?></p>
            <?php endif; ?>
            <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-100">
                <span class="text-xs text-gray-400">
                    <i class="fa fa-users mr-1"></i><?= $ev['reg_count'] ?><?= $ev['max_attendees'] ? '/'.$ev['max_attendees'] : '' ?> registered
                </span>
                <a href="?id=<?= $ev['id'] ?>"
                   class="text-xs font-medium text-indigo-600 hover:text-indigo-800 transition">View &rarr;</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Pagination -->
<?php if ($totalPages > 1): ?>
<div class="flex items-center justify-center gap-2">
    <?php if ($page > 1): ?><a href="?<?= http_build_query(array_merge($_GET,['p'=>$page-1])) ?>" class="px-4 py-2 rounded-xl border border-gray-200 text-sm text-gray-600 hover:bg-gray-50"><i class="fa fa-chevron-left mr-1"></i>Prev</a><?php endif; ?>
    <?php for($p=max(1,$page-2);$p<=min($totalPages,$page+2);$p++): ?><a href="?<?= http_build_query(array_merge($_GET,['p'=>$p])) ?>" class="px-4 py-2 rounded-xl text-sm font-medium <?= $p===$page?'bg-indigo-600 text-white':'border border-gray-200 text-gray-600 hover:bg-gray-50' ?>"><?= $p ?></a><?php endfor; ?>
    <?php if ($page < $totalPages): ?><a href="?<?= http_build_query(array_merge($_GET,['p'=>$page+1])) ?>" class="px-4 py-2 rounded-xl border border-gray-200 text-sm text-gray-600 hover:bg-gray-50">Next <i class="fa fa-chevron-right ml-1"></i></a><?php endif; ?>
</div>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
