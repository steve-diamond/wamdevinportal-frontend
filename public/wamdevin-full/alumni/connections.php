<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/middleware.php';

$authPayload = requireAlumniAuth();
$pdo = getAlumniDB();
$alumniId = (int)$authPayload['sub'];
$tab = (isset($_GET['tab']) ? $_GET['tab'] : 'all');

$allStmt = $pdo->prepare("SELECT c.id, c.status, c.created_at,
                    CASE WHEN c.requester_id=? THEN r.id ELSE q.id END as person_id,
                    CASE WHEN c.requester_id=? THEN r.first_name ELSE q.first_name END as first_name,
                    CASE WHEN c.requester_id=? THEN r.last_name ELSE q.last_name END as last_name,
                    CASE WHEN c.requester_id=? THEN r.email ELSE q.email END as email,
                    CASE WHEN c.requester_id=? THEN r.avatar ELSE q.avatar END as avatar,
                    CASE WHEN c.requester_id=? THEN pr.current_title ELSE pq.current_title END as current_title,
                    CASE WHEN c.requester_id=? THEN pr.current_company ELSE pq.current_company END as current_company,
                    c.requester_id, c.receiver_id
               FROM alumni_connections c
          LEFT JOIN alumni q ON q.id=c.requester_id
          LEFT JOIN alumni r ON r.id=c.receiver_id
          LEFT JOIN alumni_profiles pq ON pq.alumni_id=q.id
          LEFT JOIN alumni_profiles pr ON pr.alumni_id=r.id
              WHERE (c.requester_id=? OR c.receiver_id=?)
           ORDER BY c.updated_at DESC");
$allStmt->execute([$alumniId,$alumniId,$alumniId,$alumniId,$alumniId,$alumniId,$alumniId,$alumniId,$alumniId]);
$allConnections = $allStmt->fetchAll();

$accepted = array_values(array_filter($allConnections, function ($c) {
    return $c['status'] === 'accepted';
}));
$requests = array_values(array_filter($allConnections, function ($c) use ($alumniId) {
    return $c['status'] === 'pending' && (int)$c['receiver_id'] === $alumniId;
}));
$sent = array_values(array_filter($allConnections, function ($c) use ($alumniId) {
    return $c['status'] === 'pending' && (int)$c['requester_id'] === $alumniId;
}));

$pageTitle = 'My Network';
$currentPage = 'connections';
include __DIR__ . '/includes/header.php';
?>

<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">My Alumni Network</h1>
        <p class="text-sm text-gray-500 mt-1"><?= count($accepted) ?> connection(s) · <?= count($requests) ?> pending request(s)</p>
    </div>
    <a href="<?= ALUMNI_BASE_URL ?>/directory.php" class="bg-indigo-600 text-white rounded-lg px-4 py-2 text-sm font-semibold hover:bg-indigo-700">Find Alumni</a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-2 mb-5 inline-flex gap-1">
    <?php foreach (['all' => 'All', 'requests' => 'Requests', 'sent' => 'Sent', 'connected' => 'Connected'] as $k => $label): ?>
    <a href="?tab=<?= $k ?>" class="px-4 py-2 rounded-xl text-sm font-medium <?= $tab === $k ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-50' ?>"><?= $label ?></a>
    <?php endforeach; ?>
</div>

<div class="space-y-3" id="connections-list">
<?php
$rows = $allConnections;
if ($tab === 'requests') $rows = $requests;
if ($tab === 'sent') $rows = $sent;
if ($tab === 'connected') $rows = $accepted;
?>
<?php if (!$rows): ?>
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-10 text-center text-gray-400">
    <i class="fa fa-user-group text-3xl mb-2 block"></i>No records in this tab.
</div>
<?php endif; ?>
<?php foreach ($rows as $r): ?>
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center justify-between gap-4" id="conn-<?= (int)$r['id'] ?>">
    <div class="flex items-center gap-3 min-w-0">
        <img src="<?= e(getAvatarUrl((isset($r['avatar']) ? $r['avatar'] : null), (isset($r['email']) ? $r['email'] : ''), 48)) ?>" class="w-12 h-12 rounded-xl object-cover border border-gray-200">
        <div class="min-w-0">
            <a href="<?= ALUMNI_BASE_URL ?>/directory.php?id=<?= (int)$r['person_id'] ?>" class="font-semibold text-gray-900 hover:text-indigo-600"><?= e($r['first_name'] . ' ' . $r['last_name']) ?></a>
            <p class="text-xs text-gray-500 truncate"><?= e(($r['current_title'] ?: 'Alumni Member') . ($r['current_company'] ? ' at ' . $r['current_company'] : '')) ?></p>
            <p class="text-xs text-gray-400"><?= date('M j, Y', strtotime($r['created_at'])) ?></p>
        </div>
    </div>
    <div class="flex items-center gap-2">
        <?php if ($r['status'] === 'accepted'): ?>
        <span class="px-2 py-1 rounded-full text-xs bg-green-50 text-green-700">Connected</span>
        <a href="<?= ALUMNI_BASE_URL ?>/messages.php?to=<?= (int)$r['person_id'] ?>" class="px-3 py-1.5 rounded-lg border border-gray-200 text-sm text-gray-700 hover:bg-gray-50">Message</a>
        <?php elseif ($r['status'] === 'pending' && (int)$r['receiver_id'] === $alumniId): ?>
        <button onclick="updateConn(<?= (int)$r['id'] ?>,'accept')" class="px-3 py-1.5 rounded-lg bg-indigo-600 text-white text-sm hover:bg-indigo-700">Accept</button>
        <button onclick="updateConn(<?= (int)$r['id'] ?>,'decline')" class="px-3 py-1.5 rounded-lg border border-gray-200 text-sm text-gray-700 hover:bg-gray-50">Decline</button>
        <?php else: ?>
        <span class="px-2 py-1 rounded-full text-xs bg-yellow-50 text-yellow-700">Pending</span>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; ?>
</div>

<script>
function updateConn(connectionId, action) {
    fetch('<?= ALUMNI_BASE_URL ?>/api/connections.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({action: action, connection_id: connectionId, csrf_token: '<?= generateCsrfToken() ?>'})
    }).then(r => r.json()).then(d => {
        if (d.success) {
            const row = document.getElementById('conn-' + connectionId);
            if (row) row.remove();
            window.location.reload();
        } else {
            alert(d.message || 'Could not update request');
        }
    }).catch(() => alert('Network error'));
}
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
