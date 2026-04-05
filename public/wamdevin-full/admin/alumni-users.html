<?php
$pageTitle = 'Alumni Users - WAMDEVIN Admin';
$pageDescription = 'Manage alumni users, roles, and statuses';
$currentPage = 'alumni-users';
$useCalendar = false;
$useCharts = false;
$useCounter = false;
$includeLegacyCSS = true;
$includeLegacyJS = true;

include('includes/admin-header.php');
include('includes/admin-sidebar.php');

$pdo = getDashboardConnection();
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo) {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';

    $allowedStatus = array('pending','active','suspended','banned');
    $allowedRole = array('alumni','moderator','admin');

    if ($id > 0 && in_array($status, $allowedStatus) && in_array($role, $allowedRole)) {
        try {
            $stmt = $pdo->prepare("UPDATE alumni SET status=?, role=? WHERE id=?");
            $stmt->execute(array($status, $role, $id));
            $message = 'Alumni user updated successfully.';
        } catch (Exception $e) {
            $error = 'Update failed: ' . $e->getMessage();
        }
    }
}

$users = array();
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT a.id, a.first_name, a.last_name, a.email, a.role, a.status, a.created_at,
                                    ap.current_title, ap.current_company
                               FROM alumni a
                          LEFT JOIN alumni_profiles ap ON ap.alumni_id=a.id
                              WHERE a.deleted_at IS NULL
                           ORDER BY a.created_at DESC LIMIT 250");
        $users = $stmt->fetchAll();
    } catch (Exception $e) {
        $error = 'Could not load users: ' . $e->getMessage();
    }
}
?>

<main class="ttr-wrapper" id="main-content" role="main">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Alumni Users</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                <li><a href="alumni-portal.php">Alumni Portal</a></li>
                <li>Users</li>
            </ul>
        </div>

        <?php if ($message): ?><div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div><?php endif; ?>
        <?php if ($error): ?><div class="alert alert-warning"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>

        <div class="widget-box">
            <div class="wc-title"><h4>Alumni User Management</h4></div>
            <div class="widget-inner">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Profile</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $u): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($u['first_name'] . ' ' . $u['last_name']); ?><br><small><?php echo date('M j, Y', strtotime($u['created_at'])); ?></small></td>
                                <td><?php echo htmlspecialchars($u['email']); ?></td>
                                <td><?php echo htmlspecialchars(($u['current_title'] ?: 'N/A') . ($u['current_company'] ? ' @ ' . $u['current_company'] : '')); ?></td>
                                <td><?php echo htmlspecialchars($u['role']); ?></td>
                                <td><?php echo htmlspecialchars($u['status']); ?></td>
                                <td>
                                    <form method="post" class="form-inline" style="display:flex;gap:6px;">
                                        <input type="hidden" name="id" value="<?php echo (int)$u['id']; ?>">
                                        <select name="role" class="form-control">
                                            <?php foreach (array('alumni','moderator','admin') as $r): ?>
                                            <option value="<?php echo $r; ?>" <?php echo $u['role'] === $r ? 'selected' : ''; ?>><?php echo ucfirst($r); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <select name="status" class="form-control">
                                            <?php foreach (array('pending','active','suspended','banned') as $s): ?>
                                            <option value="<?php echo $s; ?>" <?php echo $u['status'] === $s ? 'selected' : ''; ?>><?php echo ucfirst($s); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button class="btn btn-primary btn-sm">Save</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include('includes/admin-footer.php'); ?>
