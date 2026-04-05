<?php
/**
 * WAMDEVIN Main Admin - Alumni Donations Management
 */

$pageTitle       = 'Alumni Donations';
$pageDescription = 'View and manage alumni donations and campaigns';
$currentPage     = 'alumni-donations';
$includeLegacyCSS = true;
$includeLegacyJS  = true;

include('includes/admin-header.php');
include('includes/admin-sidebar.php');

$pdo = getDashboardConnection();
$message = '';
$error   = '';

// Handle manual verify / refund actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo) {
    $donationId = (int)($_POST['donation_id'] ?? 0);
    $action     = $_POST['action'] ?? '';

    try {
        if ($action === 'verify' && $donationId) {
            $pdo->prepare("UPDATE alumni_donations SET payment_status='completed', updated_at=NOW() WHERE id=?")
                ->execute([$donationId]);
            $message = 'Donation marked as completed.';
        } elseif ($action === 'fail' && $donationId) {
            $pdo->prepare("UPDATE alumni_donations SET payment_status='failed', updated_at=NOW() WHERE id=?")
                ->execute([$donationId]);
            $message = 'Donation marked as failed.';
        } elseif ($action === 'refund' && $donationId) {
            $pdo->prepare("UPDATE alumni_donations SET payment_status='refunded', updated_at=NOW() WHERE id=?")
                ->execute([$donationId]);
            $message = 'Donation marked as refunded.';
        }
    } catch (Exception $e) {
        $error = 'Action failed: ' . htmlspecialchars($e->getMessage());
    }
}

// Filters
$statusFilter   = in_array($_GET['status'] ?? '', ['completed','pending','failed','refunded']) ? $_GET['status'] : '';
$campaignFilter = (int)($_GET['campaign_id'] ?? 0);
$page           = max(1, (int)($_GET['page'] ?? 1));
$perPage        = 25;
$offset         = ($page - 1) * $perPage;

$donations  = [];
$campaigns  = [];
$stats      = ['total'=>0,'count'=>0,'pending'=>0,'campaigns'=>0];
$totalRows  = 0;

if ($pdo) {
    try {
        $stats['total']     = (float)$pdo->query("SELECT COALESCE(SUM(amount),0) FROM alumni_donations WHERE payment_status='completed'")->fetchColumn();
        $stats['count']     = (int)  $pdo->query("SELECT COUNT(*) FROM alumni_donations WHERE payment_status='completed'")->fetchColumn();
        $stats['pending']   = (int)  $pdo->query("SELECT COUNT(*) FROM alumni_donations WHERE payment_status='pending'")->fetchColumn();
        $stats['campaigns'] = (int)  $pdo->query("SELECT COUNT(*) FROM donation_campaigns WHERE status='active'")->fetchColumn();

        $campaigns = $pdo->query("SELECT id, title FROM donation_campaigns ORDER BY title")->fetchAll();

        // Build filter query
        $conditions = ['1=1'];
        $params     = [];

        if ($statusFilter !== '') {
            $conditions[] = 'd.payment_status = ?';
            $params[] = $statusFilter;
        }
        if ($campaignFilter > 0) {
            $conditions[] = 'd.campaign_id = ?';
            $params[] = $campaignFilter;
        }

        $where = implode(' AND ', $conditions);

        $countStmt = $pdo->prepare("SELECT COUNT(*) FROM alumni_donations d WHERE $where");
        $countStmt->execute($params);
        $totalRows = (int)$countStmt->fetchColumn();

        $stmt = $pdo->prepare("
            SELECT d.id, d.amount, d.currency, d.payment_status, d.payment_reference,
                   d.is_recurring, d.message, d.created_at,
                   CONCAT(a.first_name,' ',a.last_name) AS alumni_name, a.email,
                   dc.title AS campaign_title
              FROM alumni_donations d
              JOIN alumni a ON a.id = d.alumni_id
              LEFT JOIN donation_campaigns dc ON dc.id = d.campaign_id
             WHERE $where
             ORDER BY d.created_at DESC
             LIMIT $perPage OFFSET $offset
        ");
        $stmt->execute($params);
        $donations = $stmt->fetchAll();
    } catch (Exception $e) {
        $error = 'Could not load donations: ' . htmlspecialchars($e->getMessage());
    }
}

$totalPages = max(1, ceil($totalRows / $perPage));
?>

<main class="ttr-wrapper" id="main-content" role="main">
<div class="container-fluid">

    <div class="db-breadcrumb">
        <h4 class="breadcrumb-title">Alumni Donations</h4>
        <ul class="db-breadcrumb-list">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="alumni-portal.php">Alumni Portal</a></li>
            <li>Donations</li>
        </ul>
    </div>

    <?php if ($message): ?>
    <div class="alert alert-success" style="margin-bottom:16px;"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
    <div class="alert alert-danger" style="margin-bottom:16px;"><?= $error ?></div>
    <?php endif; ?>

    <!-- Stats Row -->
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:16px;margin-bottom:24px;">
        <?php
        $statCards = [
            ['Total Raised',    '$'.number_format($stats['total'],2), 'ti-money',   '#059669'],
            ['Completed',        number_format($stats['count']),       'ti-check',   '#3b82f6'],
            ['Pending',          number_format($stats['pending']),     'ti-timer',   '#d97706'],
            ['Active Campaigns', number_format($stats['campaigns']),   'ti-target',  '#8b5cf6'],
        ];
        foreach ($statCards as $sc):
        ?>
        <div class="widget-stat" style="background:#fff;border-radius:14px;border:1px solid #e5e7eb;padding:18px 16px;box-shadow:0 1px 4px rgba(0,0,0,.04);">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                <div style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:<?= $sc[3] ?>18;">
                    <i class="<?= $sc[2] ?>" style="color:<?= $sc[3] ?>;font-size:1rem;"></i>
                </div>
                <span style="font-size:.75rem;color:#64748b;"><?= $sc[0] ?></span>
            </div>
            <p style="font-size:1.5rem;font-weight:700;color:#111827;margin:0;"><?= $sc[1] ?></p>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Active Campaigns -->
    <?php if (!empty($campaigns) && $pdo): ?>
    <div style="background:#fff;border-radius:14px;border:1px solid #e5e7eb;padding:20px;margin-bottom:24px;box-shadow:0 1px 4px rgba(0,0,0,.04);">
        <h3 class="widget-title" style="font-size:1rem;font-weight:600;margin:0 0 16px;color:#111827;">Campaign Progress</h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px;">
        <?php
        try {
            $campaignDetails = $pdo->query("
                SELECT dc.title, dc.goal_amount, dc.currency, dc.status,
                       COALESCE(SUM(d.amount),0) AS raised,
                       COUNT(d.id) AS donors
                  FROM donation_campaigns dc
                  LEFT JOIN alumni_donations d ON d.campaign_id = dc.id AND d.payment_status='completed'
                 GROUP BY dc.id
                 ORDER BY dc.status='active' DESC, dc.created_at DESC
                 LIMIT 8
            ")->fetchAll();
        } catch (Exception $e) { $campaignDetails = []; }
        foreach ($campaignDetails as $c):
            $pct = $c['goal_amount'] > 0 ? min(100, round(($c['raised'] / $c['goal_amount']) * 100)) : 0;
            $barColor = $c['status'] === 'active' ? '#059669' : '#9ca3af';
        ?>
        <div style="padding:14px;background:#f9fafb;border-radius:12px;border:1px solid #f3f4f6;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:8px;">
                <span style="font-weight:600;font-size:.875rem;color:#111827;"><?= htmlspecialchars($c['title']) ?></span>
                <span style="font-size:.75rem;color:#6b7280;"><?= $c['donors'] ?> donors</span>
            </div>
            <div style="background:#e5e7eb;border-radius:99px;height:8px;margin-bottom:6px;">
                <div style="background:<?= $barColor ?>;border-radius:99px;height:8px;width:<?= $pct ?>%;"></div>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:.8125rem;color:#6b7280;">
                <span>$<?= number_format($c['raised'],0) ?> raised</span>
                <span>Goal: $<?= number_format($c['goal_amount'],0) ?> (<?= $pct ?>%)</span>
            </div>
        </div>
        <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Filter & Table -->
    <div style="background:#fff;border-radius:16px;border:1px solid #e5e7eb;box-shadow:0 1px 4px rgba(0,0,0,.04);overflow:hidden;">
        <div style="padding:16px 20px;border-bottom:1px solid #f3f4f6;">
            <form method="GET" style="display:flex;flex-wrap:wrap;gap:12px;align-items:flex-end;">
                <div>
                    <label style="display:block;font-size:.75rem;font-weight:600;color:#374151;margin-bottom:4px;">Status</label>
                    <select name="status" style="padding:8px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:.875rem;">
                        <option value="">All Statuses</option>
                        <?php foreach (['completed','pending','failed','refunded'] as $s): ?>
                        <option value="<?= $s ?>" <?= $s===$statusFilter?'selected':'' ?>><?= ucfirst($s) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label style="display:block;font-size:.75rem;font-weight:600;color:#374151;margin-bottom:4px;">Campaign</label>
                    <select name="campaign_id" style="padding:8px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:.875rem;">
                        <option value="">All Campaigns</option>
                        <?php foreach ($campaigns as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= $c['id']==$campaignFilter?'selected':'' ?>>
                            <?= htmlspecialchars($c['title']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="display:flex;gap:8px;">
                    <button type="submit"
                            style="padding:8px 18px;background:#1a3a5c;color:#fff;border:none;border-radius:8px;font-size:.875rem;font-weight:600;cursor:pointer;">
                        <i class="ti-search"></i> Filter
                    </button>
                    <a href="alumni-donations.php"
                       style="padding:8px 14px;background:#f3f4f6;color:#374151;border-radius:8px;font-size:.875rem;text-decoration:none;display:inline-flex;align-items:center;">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:.875rem;">
                <thead>
                    <tr style="background:#f9fafb;color:#6b7280;font-size:.75rem;text-transform:uppercase;letter-spacing:.05em;">
                        <th style="text-align:left;padding:10px 20px;">#</th>
                        <th style="text-align:left;padding:10px 16px;">Donor</th>
                        <th style="text-align:left;padding:10px 16px;">Campaign</th>
                        <th style="text-align:left;padding:10px 16px;">Amount</th>
                        <th style="text-align:left;padding:10px 16px;">Reference</th>
                        <th style="text-align:left;padding:10px 16px;">Recurring</th>
                        <th style="text-align:left;padding:10px 16px;">Status</th>
                        <th style="text-align:left;padding:10px 16px;">Date</th>
                        <th style="text-align:left;padding:10px 16px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($donations)): ?>
                    <tr><td colspan="9" style="padding:36px;text-align:center;color:#9ca3af;">No donations found.</td></tr>
                    <?php else: foreach ($donations as $d):
                        $statusColor = [
                            'completed'=>'#059669','pending'=>'#d97706',
                            'failed'=>'#dc2626','refunded'=>'#6b7280'
                        ][$d['payment_status']] ?? '#6b7280';
                    ?>
                    <tr style="border-top:1px solid #f3f4f6;">
                        <td style="padding:12px 20px;color:#9ca3af;font-size:.75rem;">#<?= $d['id'] ?></td>
                        <td style="padding:12px 16px;">
                            <div style="font-weight:600;color:#111827;"><?= htmlspecialchars($d['alumni_name']) ?></div>
                            <div style="font-size:.75rem;color:#9ca3af;"><?= htmlspecialchars($d['email']) ?></div>
                        </td>
                        <td style="padding:12px 16px;color:#6b7280;font-size:.8125rem;">
                            <?= $d['campaign_title'] ? htmlspecialchars($d['campaign_title']) : '<span style="color:#d1d5db;">—</span>' ?>
                        </td>
                        <td style="padding:12px 16px;font-weight:700;color:#059669;">
                            $<?= number_format($d['amount'],2) ?>
                            <span style="font-size:.75rem;color:#9ca3af;font-weight:400;"><?= htmlspecialchars($d['currency']) ?></span>
                        </td>
                        <td style="padding:12px 16px;font-size:.8125rem;color:#6b7280;font-family:monospace;">
                            <?= htmlspecialchars($d['payment_reference'] ?? '—') ?>
                        </td>
                        <td style="padding:12px 16px;text-align:center;">
                            <?= $d['is_recurring'] ? '<span style="color:#8b5cf6;">✓ Yes</span>' : '<span style="color:#d1d5db;">No</span>' ?>
                        </td>
                        <td style="padding:12px 16px;">
                            <span style="padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;background:<?= $statusColor ?>18;color:<?= $statusColor ?>;">
                                <?= ucfirst($d['payment_status']) ?>
                            </span>
                        </td>
                        <td style="padding:12px 16px;color:#9ca3af;font-size:.8125rem;">
                            <?= date('M j, Y', strtotime($d['created_at'])) ?>
                        </td>
                        <td style="padding:12px 16px;">
                            <div style="display:flex;gap:4px;flex-wrap:wrap;">
                                <?php if ($d['payment_status'] === 'pending'): ?>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="donation_id" value="<?= $d['id'] ?>">
                                    <input type="hidden" name="action" value="verify">
                                    <button type="submit"
                                            style="padding:4px 10px;background:#dcfce7;color:#166534;border:none;border-radius:6px;font-size:.75rem;cursor:pointer;">
                                        ✓ Verify
                                    </button>
                                </form>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="donation_id" value="<?= $d['id'] ?>">
                                    <input type="hidden" name="action" value="fail">
                                    <button type="submit"
                                            style="padding:4px 10px;background:#fee2e2;color:#dc2626;border:none;border-radius:6px;font-size:.75rem;cursor:pointer;">
                                        ✗ Fail
                                    </button>
                                </form>
                                <?php endif; ?>
                                <?php if ($d['payment_status'] === 'completed'): ?>
                                <form method="POST" style="display:inline;"
                                      onsubmit="return confirm('Issue a refund for this donation?')">
                                    <input type="hidden" name="donation_id" value="<?= $d['id'] ?>">
                                    <input type="hidden" name="action" value="refund">
                                    <button type="submit"
                                            style="padding:4px 10px;background:#fef3c7;color:#92400e;border:none;border-radius:6px;font-size:.75rem;cursor:pointer;">
                                        ↩ Refund
                                    </button>
                                </form>
                                <?php endif; ?>
                                <?php if (!in_array($d['payment_status'], ['pending','completed'])): ?>
                                <span style="color:#d1d5db;font-size:.75rem;">—</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
        <div style="padding:14px 20px;border-top:1px solid #f3f4f6;display:flex;justify-content:center;gap:6px;flex-wrap:wrap;">
            <?php for ($p = 1; $p <= $totalPages; $p++):
                $qs = http_build_query(array_merge($_GET, ['page' => $p]));
            ?>
            <a href="?<?= $qs ?>"
               style="padding:6px 12px;border-radius:8px;text-decoration:none;font-size:.875rem;
                      background:<?= $p===$page ? '#1a3a5c' : '#f3f4f6' ?>;
                      color:<?= $p===$page ? '#fff' : '#374151' ?>;">
                <?= $p ?>
            </a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>

</div>
</main>

<?php include 'includes/admin-footer.php'; ?>
