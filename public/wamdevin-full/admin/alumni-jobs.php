<?php
$pageTitle = 'Alumni Jobs - WAMDEVIN Admin';
$pageDescription = 'Manage alumni job postings';
$currentPage = 'alumni-jobs';
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
    $title = trim(isset($_POST['title']) ? $_POST['title'] : '');
    $company = trim(isset($_POST['company']) ? $_POST['company'] : '');
    $description = trim(isset($_POST['description']) ? $_POST['description'] : '');
    $type = isset($_POST['job_type']) ? $_POST['job_type'] : 'full-time';
    $status = isset($_POST['status']) ? $_POST['status'] : 'draft';

    if ($title !== '' && $company !== '' && $description !== '') {
        try {
            $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $title), '-')) . '-' . time();
            $stmt = $pdo->prepare("INSERT INTO alumni_jobs (title, slug, company, description, job_type, status, posted_by, posted_by_type) VALUES (?, ?, ?, ?, ?, ?, 1, 'admin')");
            $stmt->execute(array($title, $slug, $company, $description, $type, $status));
            $message = 'Job added successfully.';
        } catch (Exception $e) {
            $error = 'Failed to add job: ' . $e->getMessage();
        }
    } else {
        $error = 'Please fill all required job fields.';
    }
}

$jobs = array();
if ($pdo) {
    try {
        $jobs = $pdo->query("SELECT id, title, company, job_type, status, created_at FROM alumni_jobs ORDER BY created_at DESC LIMIT 120")->fetchAll();
    } catch (Exception $e) {
        $error = 'Could not load jobs: ' . $e->getMessage();
    }
}
?>

<main class="ttr-wrapper" id="main-content" role="main">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Alumni Jobs</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                <li><a href="alumni-portal.php">Alumni Portal</a></li>
                <li>Jobs</li>
            </ul>
        </div>

        <?php if ($message): ?><div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div><?php endif; ?>
        <?php if ($error): ?><div class="alert alert-warning"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>

        <div class="row">
            <div class="col-md-4">
                <div class="widget-box">
                    <div class="wc-title"><h4>Post Job</h4></div>
                    <div class="widget-inner">
                        <form method="post">
                            <div class="form-group"><label>Title</label><input type="text" name="title" class="form-control" required></div>
                            <div class="form-group"><label>Company</label><input type="text" name="company" class="form-control" required></div>
                            <div class="form-group"><label>Description</label><textarea name="description" class="form-control" rows="4" required></textarea></div>
                            <div class="form-group">
                                <label>Type</label>
                                <select name="job_type" class="form-control">
                                    <?php foreach (array('full-time','part-time','contract','internship','remote','freelance') as $t): ?>
                                    <option value="<?php echo $t; ?>"><?php echo ucwords(str_replace('-', ' ', $t)); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <?php foreach (array('draft','published','expired','closed') as $s): ?>
                                    <option value="<?php echo $s; ?>"><?php echo ucfirst($s); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button class="btn btn-primary">Post Job</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="widget-box">
                    <div class="wc-title"><h4>Recent Jobs</h4></div>
                    <div class="widget-inner table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead><tr><th>Title</th><th>Company</th><th>Type</th><th>Status</th><th>Date</th></tr></thead>
                            <tbody>
                            <?php foreach ($jobs as $j): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($j['title']); ?></td>
                                <td><?php echo htmlspecialchars($j['company']); ?></td>
                                <td><?php echo htmlspecialchars($j['job_type']); ?></td>
                                <td><?php echo htmlspecialchars($j['status']); ?></td>
                                <td><?php echo date('M j, Y', strtotime($j['created_at'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include('includes/admin-footer.php'); ?>
