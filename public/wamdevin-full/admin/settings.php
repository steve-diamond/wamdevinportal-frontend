<?php
$pageTitle = 'Settings - WAMDEVIN Admin';
$pageDescription = 'Set standards, governance, and system alignment for WAMDEVIN delivery';
$currentPage = 'settings';
$useCalendar = false;
$useCharts = false;
$useCounter = false;
$includeLegacyCSS = true;
$includeLegacyJS = true;

include('includes/admin-header.php');
include('includes/admin-sidebar.php');

$db = getDashboardConnection();
$settingsRows = [];
$hasSettingsTable = false;
$canWriteSettings = false;
$flashMessage = '';
$flashType = 'success';

$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 12;
$pagination = buildPagination(0, $page, $perPage);

if ($db && adminTableExists($db, 'admin_settings')) {
    $hasSettingsTable = true;

    $keyCol = adminColumnExists($db, 'admin_settings', 'setting_key') ? 'setting_key' : (adminColumnExists($db, 'admin_settings', 'key_name') ? 'key_name' : null);
    $valueCol = adminColumnExists($db, 'admin_settings', 'setting_value') ? 'setting_value' : (adminColumnExists($db, 'admin_settings', 'value') ? 'value' : null);
    $updatedCol = adminColumnExists($db, 'admin_settings', 'updated_at') ? 'updated_at' : (adminColumnExists($db, 'admin_settings', 'modified_at') ? 'modified_at' : null);

    if ($keyCol && $valueCol) {
        $canWriteSettings = true;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['settings']) && is_array($_POST['settings'])) {
            foreach ($_POST['settings'] as $settingKey => $settingValue) {
                $sql = "UPDATE admin_settings SET {$valueCol} = :value";
                if ($updatedCol) {
                    $sql .= ", {$updatedCol} = NOW()";
                }
                $sql .= " WHERE {$keyCol} = :setting_key";
                adminScalar($db, $sql, [':value' => (string)$settingValue, ':setting_key' => (string)$settingKey], null);
            }
            $flashMessage = 'Settings updated successfully.';
            $flashType = 'success';
        }

        $whereSql = '';
        $params = [];
        if ($search !== '') {
            $whereSql = " WHERE {$keyCol} LIKE :q";
            $params[':q'] = '%' . $search . '%';
        }

        $total = (int)adminScalar($db, "SELECT COUNT(*) FROM admin_settings{$whereSql}", $params, 0);
        $pagination = buildPagination($total, $page, $perPage);

        $updatedExpr = $updatedCol ? $updatedCol : 'NOW()';
        $settingsRows = adminRows(
            $db,
            "SELECT {$keyCol} AS setting_key, {$valueCol} AS setting_value, {$updatedExpr} AS updated_at FROM admin_settings{$whereSql} ORDER BY {$keyCol} ASC LIMIT {$pagination['offset']}, {$pagination['perPage']}",
            $params
        );
    }
}
?>

<main class="ttr-wrapper" id="main-content" role="main">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Settings</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                <li>Settings</li>
            </ul>
        </div>

        <?php include('includes/admin-page-intro.php'); ?>

        <?php if (!empty($flashMessage)): ?>
            <div class="alert alert-<?php echo $flashType === 'success' ? 'success' : 'warning'; ?> wam-alert" role="alert">
                <?php echo sanitizeOutput($flashMessage); ?>
            </div>
        <?php endif; ?>

        <div class="widget-box">
            <div class="wc-title">
                <h4>Administration Settings</h4>
            </div>
            <div class="widget-inner">
                <p>Set the standards that protect the network, align branding, and enable accountable delivery.</p>
                <ul>
                    <li>Brand identity and communication standards</li>
                    <li>Workflow, notifications, and approvals</li>
                    <li>Access controls, audit, and security policies</li>
                </ul>
            </div>
        </div>

        <div class="widget-box m-t20">
            <div class="wc-title">
                <h4>Live Configuration Registry</h4>
            </div>
            <div class="widget-inner">
                <?php if (!$hasSettingsTable): ?>
                    <p class="wam-empty-text">Table admin_settings was not found in the current database.</p>
                <?php elseif (!$canWriteSettings): ?>
                    <p class="wam-empty-text">admin_settings exists but key/value columns were not detected.</p>
                <?php elseif (empty($settingsRows)): ?>
                    <p class="wam-empty-text">No settings found yet.</p>
                <?php else: ?>
                    <form method="get" class="form-inline m-b15" style="gap: 10px;">
                        <input type="text" name="q" class="form-control" placeholder="Search setting key" value="<?php echo sanitizeOutput($search); ?>">
                        <button type="submit" class="btn button-sm green">Search</button>
                    </form>

                    <form method="post">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Setting Key</th>
                                        <th>Setting Value</th>
                                        <th>Updated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($settingsRows as $setting): ?>
                                    <tr>
                                        <td><?php echo sanitizeOutput($setting['setting_key']); ?></td>
                                        <td>
                                            <input type="text" class="form-control" name="settings[<?php echo sanitizeOutput($setting['setting_key']); ?>]" value="<?php echo sanitizeOutput($setting['setting_value']); ?>">
                                        </td>
                                        <td><?php echo sanitizeOutput(date('M d, Y H:i', strtotime($setting['updated_at']))); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn button-sm green">Save Settings</button>
                    </form>

                    <?php if ($pagination['totalPages'] > 1): ?>
                        <div class="m-t15">
                            <?php if ($pagination['hasPrev']): ?><a class="btn button-sm outline" href="?q=<?php echo urlencode($search); ?>&page=<?php echo $pagination['prevPage']; ?>">Prev</a><?php endif; ?>
                            <span class="m-l10 m-r10">Page <?php echo $pagination['currentPage']; ?> of <?php echo $pagination['totalPages']; ?></span>
                            <?php if ($pagination['hasNext']): ?><a class="btn button-sm outline" href="?q=<?php echo urlencode($search); ?>&page=<?php echo $pagination['nextPage']; ?>">Next</a><?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php include('includes/admin-footer.php'); ?>
