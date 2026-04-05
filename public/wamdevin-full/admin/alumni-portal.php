<?php
/**
 * WAMDEVIN Main Admin - Alumni Portal Overview Dashboard
 * Integrated into existing admin panel to give admins full alumni visibility.
 */

$pageTitle   = 'Alumni Portal - Admin Overview';
$currentPage = 'alumni-portal';

require_once __DIR__ . '/includes/admin-config.php';
require_once __DIR__ . '/../includes/db-config.php';

// Auth check from existing admin system
require_once __DIR__ . '/auth.php';
requireLogin();

$pdo = getDashboardConnection();

$stats = ['alumni'=>0,'events'=>0,'jobs'=>0,'news'=>0,'donations'=>0,'pending'=>0,'connections'=>0,'messages'=>0];
$recentActivity = [];
$topLocations = [];

if ($pdo) {
    try {
        $stats['alumni']      = (int)$pdo->query("SELECT COUNT(*) FROM alumni WHERE deleted_at IS NULL")->fetchColumn();
        $stats['active']      = (int)$pdo->query("SELECT COUNT(*) FROM alumni WHERE status='active' AND deleted_at IS NULL")->fetchColumn();
        $stats['pending']     = (int)$pdo->query("SELECT COUNT(*) FROM alumni WHERE status='pending' AND deleted_at IS NULL")->fetchColumn();
        $stats['events']      = (int)$pdo->query("SELECT COUNT(*) FROM alumni_events WHERE status='published'")->fetchColumn();
        $stats['jobs']        = (int)$pdo->query("SELECT COUNT(*) FROM alumni_jobs WHERE status='published'")->fetchColumn();
        $stats['news']        = (int)$pdo->query("SELECT COUNT(*) FROM alumni_news WHERE status='published'")->fetchColumn();
        $stats['donations']   = (float)$pdo->query("SELECT COALESCE(SUM(amount),0) FROM alumni_donations WHERE payment_status='completed'")->fetchColumn();
        $stats['connections'] = (int)$pdo->query("SELECT COUNT(*) FROM alumni_connections WHERE status='accepted'")->fetchColumn();

        // Recent registrations
        $recentActivity = $pdo->query("
            SELECT first_name, last_name, email, status, created_at
              FROM alumni WHERE deleted_at IS NULL
             ORDER BY created_at DESC LIMIT 8
        ")->fetchAll();

        // Monthly donations (last 6 months)
        $monthlyDonations = $pdo->query("
            SELECT DATE_FORMAT(created_at,'%b %Y') AS month,
                   COUNT(*) AS count, SUM(amount) AS total
              FROM alumni_donations WHERE payment_status='completed'
                   AND created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
             GROUP BY DATE_FORMAT(created_at,'%Y-%m')
             ORDER BY MIN(created_at) ASC
        ")->fetchAll();

        // Top countries
        $topLocations = $pdo->query("
            SELECT country, COUNT(*) AS count
              FROM alumni_profiles WHERE country IS NOT NULL AND country != ''
             GROUP BY country ORDER BY count DESC LIMIT 5
        ")->fetchAll();
    } catch (Exception $e) {
        error_log('Alumni admin overview error: ' . $e->getMessage());
    }
}

include 'includes/admin-header.php';
include 'includes/admin-sidebar.php';
?>

<main class="ttr-wrapper" id="main-content" role="main">
<div class="container-fluid">

    <div class="db-breadcrumb">
        <h4 class="breadcrumb-title">Alumni Portal Management</h4>
        <ul class="db-breadcrumb-list">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li>Alumni Portal</li>
        </ul>
    </div>

    <!-- Header row -->
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">
        <div>
            <h2 style="font-size:1.5rem;font-weight:700;color:#1a3a5c;margin:0;">Alumni Portal Overview</h2>
            <p style="color:#64748b;font-size:.875rem;margin-top:4px;">Real-time metrics from the alumni portal database.</p>
        </div>
        <a href="<?= defined('APP_URL') ? APP_URL : '../' ?>alumni/admin/index.php"
           style="display:inline-flex;align-items:center;gap:6px;padding:8px 18px;background:#1a3a5c;color:#fff;border-radius:10px;text-decoration:none;font-size:.875rem;font-weight:600;">
            <i class="ti-external-link"></i> Open Alumni Admin
        </a>
    </div>

    <!-- Stat Cards -->
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:16px;margin-bottom:28px;">
        <?php
        $cards = [
            ['label'=>'Total Alumni',    'value'=>number_format($stats['alumni']),      'icon'=>'ti-user',       'color'=>'#6366f1'],
            ['label'=>'Active Members',  'value'=>number_format($stats['active']??0),   'icon'=>'ti-check',      'color'=>'#059669'],
            ['label'=>'Pending Approval','value'=>number_format($stats['pending']),      'icon'=>'ti-timer',      'color'=>'#d97706'],
            ['label'=>'Published Events','value'=>number_format($stats['events']),       'icon'=>'ti-calendar',   'color'=>'#3b82f6'],
            ['label'=>'Active Jobs',     'value'=>number_format($stats['jobs']),         'icon'=>'ti-briefcase',  'color'=>'#8b5cf6'],
            ['label'=>'News Articles',   'value'=>number_format($stats['news']),         'icon'=>'ti-files',      'color'=>'#ef4444'],
            ['label'=>'Total Raised',    'value'=>'$'.number_format($stats['donations'],0), 'icon'=>'ti-heart',  'color'=>'#db2777'],
            ['label'=>'Connections',     'value'=>number_format($stats['connections']),  'icon'=>'ti-link',       'color'=>'#0ea5e9'],
        ];
        foreach ($cards as $c):
        ?>
        <div style="background:#fff;border-radius:14px;border:1px solid #e5e7eb;padding:18px 16px;box-shadow:0 1px 4px rgba(0,0,0,.04);">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;background:<?= $c['color'] ?>18;">
                    <i class="<?= $c['icon'] ?>" style="color:<?= $c['color'] ?>;font-size:1rem;"></i>
                </div>
                <span style="font-size:.75rem;color:#64748b;"><?= $c['label'] ?></span>
            </div>
            <p style="font-size:1.625rem;font-weight:700;color:#111827;margin:0;"><?= $c['value'] ?></p>
        </div>
        <?php endforeach; ?>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:28px;">

        <!-- Quick Links -->
        <div style="background:#fff;border-radius:16px;border:1px solid #e5e7eb;padding:20px;box-shadow:0 1px 4px rgba(0,0,0,.04);">
            <h3 style="font-size:1rem;font-weight:600;color:#111827;margin:0 0 16px;">Quick Management Links</h3>
            <?php
            $links = [
                ['Alumni Users',  'alumni-users.php',     'ti-user',      '#6366f1'],
                ['Events',        'alumni-events.php',    'ti-calendar',  '#3b82f6'],
                ['Jobs',          'alumni-jobs.php',      'ti-briefcase', '#8b5cf6'],
                ['News',          'alumni-news.php',      'ti-files',     '#ef4444'],
                ['Donations',     'alumni-donations.php', 'ti-heart',     '#db2777'],
            ];
            foreach ($links as $l):
            ?>
            <a href="<?= $l[1] ?>"
               style="display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:12px;text-decoration:none;color:#374151;margin-bottom:6px;transition:background .15s;"
               onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                <div style="width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;background:<?= $l[3] ?>18;flex-shrink:0;">
                    <i class="<?= $l[2] ?>" style="color:<?= $l[3] ?>;font-size:.875rem;"></i>
                </div>
                <span style="font-size:.9rem;font-weight:500;">Manage <?= $l[0] ?></span>
                <i class="ti-angle-right" style="margin-left:auto;color:#9ca3af;font-size:.75rem;"></i>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Top Countries -->
        <div style="background:#fff;border-radius:16px;border:1px solid #e5e7eb;padding:20px;box-shadow:0 1px 4px rgba(0,0,0,.04);">
            <h3 style="font-size:1rem;font-weight:600;color:#111827;margin:0 0 16px;">Top Alumni Countries</h3>
            <?php if ($topLocations): ?>
            <?php foreach ($topLocations as $loc):
                $pct = $stats['alumni'] > 0 ? round(($loc['count'] / $stats['alumni']) * 100) : 0;
            ?>
            <div style="margin-bottom:14px;">
                <div style="display:flex;justify-content:space-between;font-size:.8125rem;margin-bottom:5px;">
                    <span style="color:#374151;font-weight:500;"><?= htmlspecialchars($loc['country']) ?></span>
                    <span style="color:#6b7280;"><?= number_format($loc['count']) ?>&nbsp;(<?= $pct ?>%)</span>
                </div>
                <div style="background:#f3f4f6;border-radius:99px;height:7px;">
                    <div style="background:#6366f1;border-radius:99px;height:7px;width:<?= $pct ?>%;transition:width .6s ease;"></div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p style="color:#9ca3af;font-size:.875rem;">No location data yet.</p>
            <?php endif; ?>
        </div>

    </div>

    <!-- Recent Registrations -->
    <div style="background:#fff;border-radius:16px;border:1px solid #e5e7eb;box-shadow:0 1px 4px rgba(0,0,0,.04);overflow:hidden;margin-bottom:28px;">
        <div style="padding:18px 20px;border-bottom:1px solid #f3f4f6;display:flex;justify-content:space-between;align-items:center;">
            <h3 style="font-size:1rem;font-weight:600;color:#111827;margin:0;">Recent Registrations</h3>
            <a href="alumni-users.php" style="font-size:.8125rem;color:#6366f1;text-decoration:none;font-weight:500;">View all →</a>
        </div>
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:.875rem;">
                <thead>
                    <tr style="background:#f9fafb;color:#6b7280;font-size:.75rem;text-transform:uppercase;letter-spacing:.05em;">
                        <th style="text-align:left;padding:10px 20px;">Name</th>
                        <th style="text-align:left;padding:10px 16px;">Email</th>
                        <th style="text-align:left;padding:10px 16px;">Status</th>
                        <th style="text-align:left;padding:10px 16px;">Registered</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentActivity)): ?>
                    <tr><td colspan="4" style="padding:28px;text-align:center;color:#9ca3af;">No registrations yet.</td></tr>
                    <?php else: foreach ($recentActivity as $r):
                        $statusColor = ['active'=>'#059669','pending'=>'#d97706','suspended'=>'#dc2626','banned'=>'#6b7280'][$r['status']] ?? '#6b7280';
                    ?>
                    <tr style="border-top:1px solid #f3f4f6;">
                        <td style="padding:12px 20px;font-weight:500;color:#111827;">
                            <?= htmlspecialchars($r['first_name'] . ' ' . $r['last_name']) ?>
                        </td>
                        <td style="padding:12px 16px;color:#6b7280;"><?= htmlspecialchars($r['email']) ?></td>
                        <td style="padding:12px 16px;">
                            <span style="padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;background:<?= $statusColor ?>18;color:<?= $statusColor ?>;">
                                <?= ucfirst($r['status']) ?>
                            </span>
                        </td>
                        <td style="padding:12px 16px;color:#9ca3af;font-size:.8125rem;">
                            <?= date('M j, Y', strtotime($r['created_at'])) ?>
                        </td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
</main>

<?php include 'includes/admin-footer.php'; ?>
