<?php
$pageTitle = 'Member Institutions - WAMDEVIN Admin';
$pageDescription = 'Maintain the institutional registry that anchors regional collaboration';
$currentPage = 'member-institutions';
$useCalendar = false;
$useCharts = false;
$useCounter = false;
$includeLegacyCSS = true;
$includeLegacyJS = true;

include('includes/admin-header.php');
include('includes/admin-sidebar.php');

$db = getDashboardConnection();
$institutions = [];
$hasInstitutionTable = false;
$hasInstitutionId = false;
$canManageInstitutions = false;
$canInsertInstitution = false;
$notice = isset($_GET['notice']) ? trim($_GET['notice']) : '';
$error = isset($_GET['error']) ? trim($_GET['error']) : '';
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$statusFilter = isset($_GET['status']) ? trim($_GET['status']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$editId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$perPage = 10;
$pagination = buildPagination(0, $page, $perPage);
if ($db && adminTableExists($db, 'institution_members')) {
    $hasInstitutionTable = true;
    $hasInstitutionId = adminColumnExists($db, 'institution_members', 'id');
    $hasName = adminColumnExists($db, 'institution_members', 'institution_name');
    $hasCountry = adminColumnExists($db, 'institution_members', 'country');
    $hasStatus = adminColumnExists($db, 'institution_members', 'status');
    $hasCreatedAt = adminColumnExists($db, 'institution_members', 'created_at');
    $canManageInstitutions = $hasInstitutionId && $hasName;
    $canInsertInstitution = $hasName;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = isset($_POST['action']) ? trim($_POST['action']) : '';
        $redirectParams = [
            'q' => $search,
            'status' => $statusFilter,
            'page' => $page
        ];

        try {
            if ($action === 'create' && $canInsertInstitution) {
                $institutionName = isset($_POST['institution_name']) ? trim($_POST['institution_name']) : '';
                $country = isset($_POST['country']) ? trim($_POST['country']) : '';
                $status = isset($_POST['status']) ? trim($_POST['status']) : '';

                if ($institutionName === '') {
                    $redirectParams['error'] = 'Institution name is required.';
                } else {
                    $columns = ['institution_name'];
                    $placeholders = [':institution_name'];
                    $params = [':institution_name' => $institutionName];

                    if ($hasCountry) {
                        $columns[] = 'country';
                        $placeholders[] = ':country';
                        $params[':country'] = $country;
                    }
                    if ($hasStatus) {
                        $columns[] = 'status';
                        $placeholders[] = ':status';
                        $params[':status'] = $status === '' ? 'pending' : $status;
                    }

                    $sql = 'INSERT INTO institution_members (' . implode(', ', $columns) . ') VALUES (' . implode(', ', $placeholders) . ')';
                    $stmt = $db->prepare($sql);
                    $stmt->execute($params);
                    $redirectParams['notice'] = 'Institution record created successfully.';
                }
            } elseif ($action === 'update' && $canManageInstitutions) {
                $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                $institutionName = isset($_POST['institution_name']) ? trim($_POST['institution_name']) : '';
                $country = isset($_POST['country']) ? trim($_POST['country']) : '';
                $status = isset($_POST['status']) ? trim($_POST['status']) : '';

                if ($id <= 0) {
                    $redirectParams['error'] = 'Invalid institution record selected.';
                } elseif ($institutionName === '') {
                    $redirectParams['error'] = 'Institution name is required.';
                    $redirectParams['edit'] = $id;
                } else {
                    $setParts = ['institution_name = :institution_name'];
                    $params = [':institution_name' => $institutionName, ':id' => $id];

                    if ($hasCountry) {
                        $setParts[] = 'country = :country';
                        $params[':country'] = $country;
                    }
                    if ($hasStatus) {
                        $setParts[] = 'status = :status';
                        $params[':status'] = $status === '' ? 'pending' : $status;
                    }

                    $sql = 'UPDATE institution_members SET ' . implode(', ', $setParts) . ' WHERE id = :id LIMIT 1';
                    $stmt = $db->prepare($sql);
                    $stmt->execute($params);
                    $redirectParams['notice'] = 'Institution record updated.';
                }
            } elseif ($action === 'delete' && $canManageInstitutions) {
                $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                if ($id <= 0) {
                    $redirectParams['error'] = 'Invalid institution record selected.';
                } else {
                    $stmt = $db->prepare('DELETE FROM institution_members WHERE id = :id LIMIT 1');
                    $stmt->execute([':id' => $id]);
                    $redirectParams['notice'] = 'Institution record deleted.';
                }
            } else {
                $redirectParams['error'] = 'Requested action is not available for this table schema.';
            }
        } catch (Exception $e) {
            $redirectParams['error'] = 'Unable to save changes. Check table constraints and try again.';
            error_log('Member institutions CRUD error: ' . $e->getMessage());
        }

        header('Location: member-institutions.php?' . http_build_query($redirectParams));
        exit;
    }

    $where = [];
    $params = [];
    $nameExpr = $hasName ? 'institution_name' : "CONCAT('Institution #', id)";
    $countryExpr = $hasCountry ? 'country' : "'N/A'";
    $statusExpr = $hasStatus ? 'status' : "'active'";
    $createdExpr = $hasCreatedAt ? 'created_at' : 'NULL';
    $orderExpr = $hasCreatedAt ? 'created_at' : ($hasInstitutionId ? 'id' : 'institution_name');

    if ($search !== '') {
        $where[] = "{$nameExpr} LIKE :q";
        $params[':q'] = '%' . $search . '%';
    }
    if ($statusFilter !== '' && $hasStatus) {
        $where[] = "status = :status";
        $params[':status'] = $statusFilter;
    }
    $whereSql = empty($where) ? '' : (' WHERE ' . implode(' AND ', $where));

    $total = (int)adminScalar($db, "SELECT COUNT(*) FROM institution_members{$whereSql}", $params, 0);
    $pagination = buildPagination($total, $page, $perPage);

    $institutions = adminRows(
        $db,
        "SELECT " . ($hasInstitutionId ? 'id AS row_id, ' : 'NULL AS row_id, ') . "{$nameExpr} AS institution_name, {$countryExpr} AS country, {$statusExpr} AS status, {$createdExpr} AS created_at FROM institution_members{$whereSql} ORDER BY {$orderExpr} DESC LIMIT {$pagination['offset']}, {$pagination['perPage']}",
        $params
    );
}
?>

<main class="ttr-wrapper" id="main-content" role="main">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Member Institutions</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                <li>Member Institutions</li>
            </ul>
        </div>

        <?php include('includes/admin-page-intro.php'); ?>

        <div class="widget-box">
            <div class="wc-title">
                <h4>Institution Registry</h4>
            </div>
            <div class="widget-inner">
                <p>Maintain the registry that anchors regional collaboration and institutional excellence.</p>
                <ul>
                    <li>Review membership applications and compliance</li>
                    <li>Update profiles, leadership contacts, and accreditation</li>
                    <li>Track status, renewals, and engagement health</li>
                </ul>
            </div>
        </div>

        <div class="widget-box m-t20">
            <div class="wc-title">
                <h4>Latest Institution Records</h4>
            </div>
            <div class="widget-inner">
                <?php if ($notice !== ''): ?>
                    <div class="alert alert-success"><?php echo sanitizeOutput($notice); ?></div>
                <?php endif; ?>
                <?php if ($error !== ''): ?>
                    <div class="alert alert-danger"><?php echo sanitizeOutput($error); ?></div>
                <?php endif; ?>

                <?php if ($hasInstitutionTable && $canInsertInstitution): ?>
                    <form method="post" class="m-b20" style="border: 1px solid #e0e0e0; padding: 15px; border-radius: 6px;">
                        <h5 class="m-b10">Add New Institution</h5>
                        <input type="hidden" name="action" value="create">
                        <div class="form-row" style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <div style="flex: 2 1 250px;">
                                <label class="m-b5">Institution Name</label>
                                <input type="text" name="institution_name" class="form-control" required>
                            </div>
                            <div style="flex: 1 1 200px;">
                                <label class="m-b5">Country</label>
                                <input type="text" name="country" class="form-control" placeholder="Optional">
                            </div>
                            <div style="flex: 1 1 180px;">
                                <label class="m-b5">Status</label>
                                <select name="status" class="form-control">
                                    <option value="pending">Pending</option>
                                    <option value="verified">Verified</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn button-sm green m-t10">Create Institution</button>
                    </form>
                <?php endif; ?>

                <form method="get" class="form-inline m-b15" style="gap: 10px;">
                    <input type="text" name="q" class="form-control" placeholder="Search institution" value="<?php echo sanitizeOutput($search); ?>">
                    <select name="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="verified" <?php echo $statusFilter === 'verified' ? 'selected' : ''; ?>>Verified</option>
                        <option value="pending" <?php echo $statusFilter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="rejected" <?php echo $statusFilter === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                    </select>
                    <button type="submit" class="btn button-sm green">Filter</button>
                </form>
                <?php if (!$hasInstitutionTable): ?>
                    <p class="wam-empty-text">Table institution_members was not found in the current database.</p>
                <?php elseif (empty($institutions)): ?>
                    <p class="wam-empty-text">No institution records found yet.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Institution</th>
                                    <th>Country</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($institutions as $row): ?>
                                <tr>
                                    <?php if ($canManageInstitutions && (int)$row['row_id'] === $editId): ?>
                                        <form method="post">
                                            <input type="hidden" name="action" value="update">
                                            <input type="hidden" name="id" value="<?php echo (int)$row['row_id']; ?>">
                                            <td><input type="text" name="institution_name" class="form-control" value="<?php echo sanitizeOutput($row['institution_name']); ?>" required></td>
                                            <td><input type="text" name="country" class="form-control" value="<?php echo sanitizeOutput($row['country']); ?>"></td>
                                            <td>
                                                <select name="status" class="form-control">
                                                    <option value="verified" <?php echo strtolower((string)$row['status']) === 'verified' ? 'selected' : ''; ?>>Verified</option>
                                                    <option value="pending" <?php echo strtolower((string)$row['status']) === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                    <option value="rejected" <?php echo strtolower((string)$row['status']) === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                                </select>
                                            </td>
                                            <td><?php echo !empty($row['created_at']) ? sanitizeOutput(date('M d, Y', strtotime($row['created_at']))) : 'N/A'; ?></td>
                                            <td>
                                                <button type="submit" class="btn button-sm green">Save</button>
                                                <a class="btn button-sm outline" href="?q=<?php echo urlencode($search); ?>&status=<?php echo urlencode($statusFilter); ?>&page=<?php echo $pagination['currentPage']; ?>">Cancel</a>
                                            </td>
                                        </form>
                                    <?php else: ?>
                                        <td><?php echo sanitizeOutput($row['institution_name']); ?></td>
                                        <td><?php echo sanitizeOutput($row['country']); ?></td>
                                        <td><span class="btn button-sm <?php echo getStatusButtonClass($row['status']); ?>"><?php echo sanitizeOutput($row['status']); ?></span></td>
                                        <td><?php echo !empty($row['created_at']) ? sanitizeOutput(date('M d, Y', strtotime($row['created_at']))) : 'N/A'; ?></td>
                                        <td>
                                            <?php if ($canManageInstitutions): ?>
                                                <a class="btn button-sm blue" href="?q=<?php echo urlencode($search); ?>&status=<?php echo urlencode($statusFilter); ?>&page=<?php echo $pagination['currentPage']; ?>&edit=<?php echo (int)$row['row_id']; ?>">Edit</a>
                                                <form method="post" style="display: inline;" onsubmit="return confirm('Delete this institution record?');">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?php echo (int)$row['row_id']; ?>">
                                                    <button type="submit" class="btn button-sm red">Delete</button>
                                                </form>
                                            <?php else: ?>
                                                <span class="wam-empty-text">Read only</span>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($pagination['totalPages'] > 1): ?>
                        <div class="m-t15">
                            <?php if ($pagination['hasPrev']): ?>
                                <a class="btn button-sm outline" href="?q=<?php echo urlencode($search); ?>&status=<?php echo urlencode($statusFilter); ?>&page=<?php echo $pagination['prevPage']; ?>">Prev</a>
                            <?php endif; ?>
                            <span class="m-l10 m-r10">Page <?php echo $pagination['currentPage']; ?> of <?php echo $pagination['totalPages']; ?></span>
                            <?php if ($pagination['hasNext']): ?>
                                <a class="btn button-sm outline" href="?q=<?php echo urlencode($search); ?>&status=<?php echo urlencode($statusFilter); ?>&page=<?php echo $pagination['nextPage']; ?>">Next</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php include('includes/admin-footer.php'); ?>
