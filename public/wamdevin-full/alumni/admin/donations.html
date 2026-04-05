<?php
/**
 * WAMDEVIN Alumni Portal - Admin: Donations Management
 */
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/middleware.php';

$authPayload = requireAdminAuth();
$pdo         = getAlumniDB();

// Handle status update (manual verify/refund)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken((isset($_POST['csrf_token']) ? $_POST['csrf_token'] : ''))) {
        setFlash('error', 'Invalid security token.');
        redirect(ALUMNI_BASE_URL . '/admin/donations.php');
    }
    $action = (isset($_POST['action']) ? $_POST['action'] : '');
    $donId  = (int)((isset($_POST['donation_id']) ? $_POST['donation_id'] : 0));
    $allowed = ['completed','refunded','failed'];
    if ($donId && in_array($action, $allowed)) {
        $pdo->prepare("UPDATE alumni_donations SET payment_status=?, updated_at=NOW() WHERE id=?")
            ->execute([$action, $donId]);
        setFlash('success', 'Donation status updated to ' . $action . '.');
    }
    redirect(ALUMNI_BASE_URL . '/admin/donations.php');
}

// Summary stats
$stats = [
    'total'     => (float)$pdo->query("SELECT COALESCE(SUM(amount),0) FROM alumni_donations WHERE payment_status='completed'")->fetchColumn(),
    'count'     => (int)$pdo->query("SELECT COUNT(*) FROM alumni_donations WHERE payment_status='completed'")->fetchColumn(),
    'pending'   => (int)$pdo->query("SELECT COUNT(*) FROM alumni_donations WHERE payment_status='pending'")->fetchColumn(),
    'recurring' => (int)$pdo->query("SELECT COUNT(*) FROM alumni_donations WHERE is_recurring=1 AND payment_status='completed'")->fetchColumn(),
];

// Campaign progress
$campaigns = $pdo->query("
    SELECT c.*, COALESCE(SUM(d.amount),0) AS raised, COUNT(d.id) AS donors
      FROM donation_campaigns c
      LEFT JOIN alumni_donations d ON d.campaign=c.slug AND d.payment_status='completed'
     WHERE c.status='active'
     GROUP BY c.id
")->fetchAll();

// Donations list
$filter = (isset($_GET['status']) ? $_GET['status'] : '');
$search = trim((isset($_GET['q']) ? $_GET['q'] : ''));
$page   = max(1, (int)((isset($_GET['page']) ? $_GET['page'] : 1)));
$limit  = 30;
$off    = ($page - 1) * $limit;

$where  = [];
$params = [];
if ($filter && in_array($filter, ['pending','completed','failed','refunded'])) {
    $where[] = 'd.payment_status=?'; $params[] = $filter;
}
if ($search) {
    $where[] = '(d.donor_name LIKE ? OR d.donor_email LIKE ? OR d.payment_reference LIKE ?)';
    $like = '%' . $search . '%';
    $params = array_merge($params, [$like, $like, $like]);
}
$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$donations = $pdo->prepare("
    SELECT d.*, a.first_name, a.last_name
      FROM alumni_donations d
      LEFT JOIN alumni a ON a.id = d.alumni_id
    {$whereSQL}
     ORDER BY d.created_at DESC
     LIMIT {$limit} OFFSET {$off}
");
$donations->execute($params);
$donations = $donations->fetchAll();

$pageTitle   = 'Donations Management';
$currentPage = 'admin';
include __DIR__ . '/../includes/header.php';
$flash = getFlash();
?>

<div class="mb-5 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Donations Management</h1>
        <p class="text-sm text-gray-500 mt-0.5">Track, verify and manage alumni donations.</p>
    </div>
    <div class="flex gap-2">
        <a href="<?= ALUMNI_BASE_URL ?>/admin/index.php" class="text-sm text-indigo-600 hover:underline">← Admin</a>
    </div>
</div>

<?php if ($flash): ?>
<div class="mb-4 rounded-xl border px-4 py-3 text-sm <?= $flash['type']==='success' ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700' ?>">
    <?= e($flash['message']) ?>
</div>
<?php endif; ?>

<!-- Stats -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Total Raised</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">$<?= number_format($stats['total'], 2) ?></p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Donations</p>
        <p class="text-2xl font-bold text-gray-900 mt-1"><?= number_format($stats['count']) ?></p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Pending</p>
        <p class="text-2xl font-bold text-amber-600 mt-1"><?= number_format($stats['pending']) ?></p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Recurring</p>
        <p class="text-2xl font-bold text-green-600 mt-1"><?= number_format($stats['recurring']) ?></p>
    </div>
</div>

<!-- Campaign Progress -->
<?php if ($campaigns): ?>
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6">
    <h2 class="font-semibold text-gray-900 mb-4">Active Campaigns</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <?php foreach ($campaigns as $c):
            $pct = $c['goal_amount'] > 0 ? min(100, round(($c['raised'] / $c['goal_amount']) * 100)) : 0;
        ?>
        <div class="border border-gray-100 rounded-xl p-4">
            <div class="flex items-start justify-between mb-2">
                <p class="font-medium text-gray-900 text-sm"><?= e($c['title']) ?></p>
                <span class="text-xs font-medium text-indigo-600"><?= $pct ?>%</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2 mb-2">
                <div class="bg-indigo-600 h-2 rounded-full transition-all" style="width:<?= $pct ?>%"></div>
            </div>
            <p class="text-xs text-gray-500">
                $<?= number_format($c['raised'], 2) ?> raised of $<?= number_format($c['goal_amount'], 2) ?>
                &nbsp;·&nbsp; <?= number_format($c['donors']) ?> donors
            </p>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- Filter Bar -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-4">
    <form method="GET" class="flex flex-wrap gap-3 items-center">
        <input type="text" name="q" value="<?= e($search) ?>" placeholder="Search donor, email, reference…"
               class="border border-gray-200 rounded-lg px-3 py-2 text-sm flex-1 min-w-48">
        <select name="status" class="border border-gray-200 rounded-lg px-3 py-2 text-sm">
            <option value="">All Statuses</option>
            <?php foreach (['pending','completed','failed','refunded'] as $s): ?>
            <option value="<?= $s ?>" <?= $filter === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
            <?php endforeach; ?>
        </select>
        <button class="bg-indigo-600 text-white rounded-lg px-4 py-2 text-sm font-semibold">Filter</button>
        <?php if ($search || $filter): ?>
        <a href="?" class="text-sm text-gray-500 hover:text-gray-700">Clear</a>
        <?php endif; ?>
    </form>
</div>

<!-- Donations Table -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50">
            <tr class="text-left text-gray-600">
                <th class="px-4 py-3">Donor</th>
                <th class="px-4 py-3">Amount</th>
                <th class="px-4 py-3">Campaign</th>
                <th class="px-4 py-3">Reference</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php if (empty($donations)): ?>
            <tr><td colspan="7" class="px-4 py-10 text-center text-gray-400">No donations found.</td></tr>
            <?php else: foreach ($donations as $d): ?>
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-4 py-3">
                    <p class="font-medium text-gray-900">
                        <?= $d['is_anonymous'] ? '<em class="text-gray-400">Anonymous</em>' : e($d['donor_name']) ?>
                    </p>
                    <p class="text-xs text-gray-500"><?= e($d['donor_email']) ?></p>
                    <?php if ($d['is_recurring']): ?>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-purple-50 text-purple-600 mt-1">Recurring</span>
                    <?php endif; ?>
                </td>
                <td class="px-4 py-3 font-semibold text-gray-900">
                    <?= e($d['currency']) ?> <?= number_format($d['amount'], 2) ?>
                </td>
                <td class="px-4 py-3 text-gray-600"><?= e($d['campaign'] ?: '—') ?></td>
                <td class="px-4 py-3">
                    <code class="text-xs bg-gray-100 px-1.5 py-0.5 rounded"><?= e((isset($d['payment_reference']) ? $d['payment_reference'] : '—')) ?></code>
                </td>
                <td class="px-4 py-3">
                    <?php
                    $statusColors = [
                        'pending'   => 'bg-amber-50 text-amber-700',
                        'completed' => 'bg-green-50 text-green-700',
                        'failed'    => 'bg-red-50 text-red-700',
                        'refunded'  => 'bg-gray-100 text-gray-600',
                    ];
                    $sc = isset($statusColors[$d['payment_status']]) ? $statusColors[$d['payment_status']] : 'bg-gray-100 text-gray-600';
                    ?>
                    <span class="px-2 py-1 rounded-full text-xs font-medium <?= $sc ?>">
                        <?= ucfirst($d['payment_status']) ?>
                    </span>
                </td>
                <td class="px-4 py-3 text-xs text-gray-500"><?= date('M j, Y', strtotime($d['created_at'])) ?></td>
                <td class="px-4 py-3">
                    <?php if ($d['payment_status'] === 'pending'): ?>
                    <form method="POST" class="inline">
                        <?= csrfField() ?>
                        <input type="hidden" name="donation_id" value="<?= $d['id'] ?>">
                        <input type="hidden" name="action" value="completed">
                        <button class="text-xs text-green-600 hover:underline font-medium">Verify</button>
                    </form>
                    &nbsp;|&nbsp;
                    <form method="POST" class="inline">
                        <?= csrfField() ?>
                        <input type="hidden" name="donation_id" value="<?= $d['id'] ?>">
                        <input type="hidden" name="action" value="failed">
                        <button class="text-xs text-red-500 hover:underline">Fail</button>
                    </form>
                    <?php elseif ($d['payment_status'] === 'completed'): ?>
                    <form method="POST" class="inline">
                        <?= csrfField() ?>
                        <input type="hidden" name="donation_id" value="<?= $d['id'] ?>">
                        <input type="hidden" name="action" value="refunded">
                        <button class="text-xs text-gray-500 hover:underline">Refund</button>
                    </form>
                    <?php else: ?>
                    <span class="text-xs text-gray-400">—</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <?php if ($page > 1 || count($donations) === $limit): ?>
    <div class="flex items-center justify-between px-4 py-3 border-t border-gray-100">
        <p class="text-sm text-gray-500">Page <?= $page ?></p>
        <div class="flex gap-2">
            <?php if ($page > 1): ?>
            <a href="?page=<?= $page-1 ?>&status=<?= urlencode($filter) ?>&q=<?= urlencode($search) ?>"
               class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm hover:bg-gray-50">Previous</a>
            <?php endif; ?>
            <?php if (count($donations) === $limit): ?>
            <a href="?page=<?= $page+1 ?>&status=<?= urlencode($filter) ?>&q=<?= urlencode($search) ?>"
               class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm hover:bg-gray-50">Next</a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
