<?php
$pageTitle = 'Alumni Events - WAMDEVIN Admin';
$pageDescription = 'Create and manage alumni events';
$currentPage = 'alumni-events';
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
    $eventType = isset($_POST['event_type']) ? $_POST['event_type'] : 'networking';
    $location = trim(isset($_POST['location']) ? $_POST['location'] : '');
    $start = isset($_POST['start_datetime']) ? $_POST['start_datetime'] : '';
    $end = isset($_POST['end_datetime']) ? $_POST['end_datetime'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : 'draft';

    if ($title !== '' && $start !== '' && $end !== '') {
        try {
            $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $title), '-')) . '-' . time();
            $stmt = $pdo->prepare("INSERT INTO alumni_events (title, slug, event_type, location, start_datetime, end_datetime, status, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
            $stmt->execute(array($title, $slug, $eventType, $location ?: null, $start, $end, $status));
            $message = 'Event created successfully.';
        } catch (Exception $e) {
            $error = 'Could not create event: ' . $e->getMessage();
        }
    } else {
        $error = 'Please fill in title, start, and end date/time.';
    }
}

$events = array();
if ($pdo) {
    try {
        $events = $pdo->query("SELECT id, title, event_type, location, start_datetime, end_datetime, status FROM alumni_events ORDER BY created_at DESC LIMIT 120")->fetchAll();
    } catch (Exception $e) {
        $error = 'Could not load events: ' . $e->getMessage();
    }
}
?>

<main class="ttr-wrapper" id="main-content" role="main">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Alumni Events</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                <li><a href="alumni-portal.php">Alumni Portal</a></li>
                <li>Events</li>
            </ul>
        </div>

        <?php if ($message): ?><div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div><?php endif; ?>
        <?php if ($error): ?><div class="alert alert-warning"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>

        <div class="row">
            <div class="col-md-4">
                <div class="widget-box">
                    <div class="wc-title"><h4>Create Event</h4></div>
                    <div class="widget-inner">
                        <form method="post">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <select name="event_type" class="form-control">
                                    <?php foreach (array('networking','webinar','reunion','workshop','conference','social','other') as $t): ?>
                                    <option value="<?php echo $t; ?>"><?php echo ucfirst($t); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Location</label>
                                <input type="text" name="location" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Start</label>
                                <input type="datetime-local" name="start_datetime" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>End</label>
                                <input type="datetime-local" name="end_datetime" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <?php foreach (array('draft','published','cancelled','completed') as $s): ?>
                                    <option value="<?php echo $s; ?>"><?php echo ucfirst($s); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button class="btn btn-primary">Create Event</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="widget-box">
                    <div class="wc-title"><h4>Recent Events</h4></div>
                    <div class="widget-inner table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead><tr><th>Title</th><th>Type</th><th>Schedule</th><th>Status</th></tr></thead>
                            <tbody>
                            <?php foreach ($events as $e): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($e['title']); ?><br><small><?php echo htmlspecialchars($e['location']); ?></small></td>
                                <td><?php echo htmlspecialchars($e['event_type']); ?></td>
                                <td><?php echo date('M j, Y g:i A', strtotime($e['start_datetime'])); ?></td>
                                <td><?php echo htmlspecialchars($e['status']); ?></td>
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
