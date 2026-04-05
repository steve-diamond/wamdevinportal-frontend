<?php
$pageTitle = 'Events & Programmes - WAMDEVIN Admin';
$pageDescription = 'Coordinate regional programmes and leadership events with measurable impact';
$currentPage = 'events';
$useCalendar = true;
$useCharts = false;
$useCounter = false;
$includeLegacyCSS = true;
$includeLegacyJS = true;

include('includes/admin-header.php');
include('includes/admin-sidebar.php');

$db = getDashboardConnection();
$eventRows = [];
$hasEventsTable = false;
$hasEventId = false;
$canManageEvents = false;
$canInsertEvents = false;
$notice = isset($_GET['notice']) ? trim($_GET['notice']) : '';
$error = isset($_GET['error']) ? trim($_GET['error']) : '';
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$statusFilter = isset($_GET['status']) ? trim($_GET['status']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$editId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$perPage = 10;
$pagination = buildPagination(0, $page, $perPage);
if ($db && adminTableExists($db, 'events')) {
    $hasEventsTable = true;
    $hasEventId = adminColumnExists($db, 'events', 'id');
    $hasTitle = adminColumnExists($db, 'events', 'title');
    $hasStartDate = adminColumnExists($db, 'events', 'start_date');
    $hasEndDate = adminColumnExists($db, 'events', 'end_date');
    $hasStatus = adminColumnExists($db, 'events', 'status');
    $canManageEvents = $hasEventId && $hasTitle;
    $canInsertEvents = $hasTitle;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = isset($_POST['action']) ? trim($_POST['action']) : '';
        $redirectParams = [
            'q' => $search,
            'status' => $statusFilter,
            'page' => $page
        ];

        try {
            if ($action === 'create' && $canInsertEvents) {
                $title = isset($_POST['title']) ? trim($_POST['title']) : '';
                $startDate = isset($_POST['start_date']) ? trim($_POST['start_date']) : '';
                $endDate = isset($_POST['end_date']) ? trim($_POST['end_date']) : '';
                $status = isset($_POST['status']) ? trim($_POST['status']) : '';

                if ($title === '') {
                    $redirectParams['error'] = 'Event title is required.';
                } else {
                    $columns = ['title'];
                    $placeholders = [':title'];
                    $params = [':title' => $title];

                    if ($hasStartDate) {
                        $columns[] = 'start_date';
                        $placeholders[] = ':start_date';
                        $params[':start_date'] = $startDate !== '' ? $startDate : date('Y-m-d');
                    }
                    if ($hasEndDate) {
                        $columns[] = 'end_date';
                        $placeholders[] = ':end_date';
                        $params[':end_date'] = $endDate !== '' ? $endDate : null;
                    }
                    if ($hasStatus) {
                        $columns[] = 'status';
                        $placeholders[] = ':status';
                        $params[':status'] = $status === '' ? 'planned' : $status;
                    }

                    $sql = 'INSERT INTO events (' . implode(', ', $columns) . ') VALUES (' . implode(', ', $placeholders) . ')';
                    $stmt = $db->prepare($sql);
                    $stmt->execute($params);
                    $redirectParams['notice'] = 'Event created successfully.';
                }
            } elseif ($action === 'update' && $canManageEvents) {
                $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                $title = isset($_POST['title']) ? trim($_POST['title']) : '';
                $startDate = isset($_POST['start_date']) ? trim($_POST['start_date']) : '';
                $endDate = isset($_POST['end_date']) ? trim($_POST['end_date']) : '';
                $status = isset($_POST['status']) ? trim($_POST['status']) : '';

                if ($id <= 0) {
                    $redirectParams['error'] = 'Invalid event selected.';
                } elseif ($title === '') {
                    $redirectParams['error'] = 'Event title is required.';
                    $redirectParams['edit'] = $id;
                } else {
                    $setParts = ['title = :title'];
                    $params = [':title' => $title, ':id' => $id];

                    if ($hasStartDate) {
                        $setParts[] = 'start_date = :start_date';
                        $params[':start_date'] = $startDate !== '' ? $startDate : date('Y-m-d');
                    }
                    if ($hasEndDate) {
                        $setParts[] = 'end_date = :end_date';
                        $params[':end_date'] = $endDate !== '' ? $endDate : null;
                    }
                    if ($hasStatus) {
                        $setParts[] = 'status = :status';
                        $params[':status'] = $status === '' ? 'planned' : $status;
                    }

                    $sql = 'UPDATE events SET ' . implode(', ', $setParts) . ' WHERE id = :id LIMIT 1';
                    $stmt = $db->prepare($sql);
                    $stmt->execute($params);
                    $redirectParams['notice'] = 'Event updated.';
                }
            } elseif ($action === 'delete' && $canManageEvents) {
                $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                if ($id <= 0) {
                    $redirectParams['error'] = 'Invalid event selected.';
                } else {
                    $stmt = $db->prepare('DELETE FROM events WHERE id = :id LIMIT 1');
                    $stmt->execute([':id' => $id]);
                    $redirectParams['notice'] = 'Event deleted.';
                }
            } else {
                $redirectParams['error'] = 'Requested action is not available for this table schema.';
            }
        } catch (Exception $e) {
            $redirectParams['error'] = 'Unable to save changes. Check table constraints and try again.';
            error_log('Events CRUD error: ' . $e->getMessage());
        }

        header('Location: events.php?' . http_build_query($redirectParams));
        exit;
    }

    $where = [];
    $params = [];
    $titleExpr = $hasTitle ? 'title' : "CONCAT('Event #', id)";
    $startExpr = $hasStartDate ? 'start_date' : 'NULL';
    $endExpr = $hasEndDate ? 'end_date' : 'NULL';
    $statusExpr = $hasStatus ? 'status' : "'planned'";
    $orderExpr = $hasStartDate ? 'start_date' : ($hasEventId ? 'id' : 'title');

    if ($search !== '') {
        $where[] = "{$titleExpr} LIKE :q";
        $params[':q'] = '%' . $search . '%';
    }
    if ($statusFilter !== '' && $hasStatus) {
        $where[] = "status = :status";
        $params[':status'] = $statusFilter;
    }
    $whereSql = empty($where) ? '' : (' WHERE ' . implode(' AND ', $where));
    $total = (int)adminScalar($db, "SELECT COUNT(*) FROM events{$whereSql}", $params, 0);
    $pagination = buildPagination($total, $page, $perPage);
    $eventRows = adminRows($db, "SELECT " . ($hasEventId ? 'id AS row_id, ' : 'NULL AS row_id, ') . "{$titleExpr} AS title, {$startExpr} AS start_date, {$endExpr} AS end_date, {$statusExpr} AS status FROM events{$whereSql} ORDER BY {$orderExpr} DESC LIMIT {$pagination['offset']}, {$pagination['perPage']}", $params);
}
?>

<main class="ttr-wrapper" id="main-content" role="main">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Events & Programmes</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                <li>Events & Programmes</li>
            </ul>
        </div>

        <?php include('includes/admin-page-intro.php'); ?>

        <div class="widget-box">
            <div class="wc-title">
                <h4>Programme Calendar & Milestones</h4>
            </div>
            <div class="widget-inner">
                <p>Plan, approve, and track regional events and flagship programmes that advance the WAMDEVIN agenda.</p>
                <div id="calendar" aria-label="Events calendar"></div>
            </div>
        </div>

        <div class="widget-box m-t20">
            <div class="wc-title">
                <h4>Recent Events & Programmes</h4>
            </div>
            <div class="widget-inner">
                <?php if ($notice !== ''): ?>
                    <div class="alert alert-success"><?php echo sanitizeOutput($notice); ?></div>
                <?php endif; ?>
                <?php if ($error !== ''): ?>
                    <div class="alert alert-danger"><?php echo sanitizeOutput($error); ?></div>
                <?php endif; ?>

                <?php if ($hasEventsTable && $canInsertEvents): ?>
                    <form method="post" class="m-b20" style="border: 1px solid #e0e0e0; padding: 15px; border-radius: 6px;">
                        <h5 class="m-b10">Add New Event</h5>
                        <input type="hidden" name="action" value="create">
                        <div class="form-row" style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <div style="flex: 2 1 250px;">
                                <label class="m-b5">Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div style="flex: 1 1 180px;">
                                <label class="m-b5">Start Date</label>
                                <input type="date" name="start_date" class="form-control">
                            </div>
                            <div style="flex: 1 1 180px;">
                                <label class="m-b5">End Date</label>
                                <input type="date" name="end_date" class="form-control">
                            </div>
                            <div style="flex: 1 1 170px;">
                                <label class="m-b5">Status</label>
                                <select name="status" class="form-control">
                                    <option value="planned">Planned</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn button-sm green m-t10">Create Event</button>
                    </form>
                <?php endif; ?>

                <form method="get" class="form-inline m-b15" style="gap: 10px;">
                    <input type="text" name="q" class="form-control" placeholder="Search event" value="<?php echo sanitizeOutput($search); ?>">
                    <select name="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="planned" <?php echo $statusFilter === 'planned' ? 'selected' : ''; ?>>Planned</option>
                        <option value="confirmed" <?php echo $statusFilter === 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                        <option value="completed" <?php echo $statusFilter === 'completed' ? 'selected' : ''; ?>>Completed</option>
                        <option value="cancelled" <?php echo $statusFilter === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                    <button type="submit" class="btn button-sm green">Filter</button>
                </form>
                <?php if (!$hasEventsTable): ?>
                    <p class="wam-empty-text">Table events was not found in the current database.</p>
                <?php elseif (empty($eventRows)): ?>
                    <p class="wam-empty-text">No events found yet.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($eventRows as $event): ?>
                                <tr>
                                    <?php if ($canManageEvents && (int)$event['row_id'] === $editId): ?>
                                        <form method="post">
                                            <input type="hidden" name="action" value="update">
                                            <input type="hidden" name="id" value="<?php echo (int)$event['row_id']; ?>">
                                            <td><input type="text" name="title" class="form-control" value="<?php echo sanitizeOutput($event['title']); ?>" required></td>
                                            <td><input type="date" name="start_date" class="form-control" value="<?php echo !empty($event['start_date']) ? sanitizeOutput(date('Y-m-d', strtotime($event['start_date']))) : ''; ?>"></td>
                                            <td><input type="date" name="end_date" class="form-control" value="<?php echo !empty($event['end_date']) ? sanitizeOutput(date('Y-m-d', strtotime($event['end_date']))) : ''; ?>"></td>
                                            <td>
                                                <select name="status" class="form-control">
                                                    <option value="planned" <?php echo strtolower((string)$event['status']) === 'planned' ? 'selected' : ''; ?>>Planned</option>
                                                    <option value="confirmed" <?php echo strtolower((string)$event['status']) === 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                                    <option value="completed" <?php echo strtolower((string)$event['status']) === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                                    <option value="cancelled" <?php echo strtolower((string)$event['status']) === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="submit" class="btn button-sm green">Save</button>
                                                <a class="btn button-sm outline" href="?q=<?php echo urlencode($search); ?>&status=<?php echo urlencode($statusFilter); ?>&page=<?php echo $pagination['currentPage']; ?>">Cancel</a>
                                            </td>
                                        </form>
                                    <?php else: ?>
                                        <td><?php echo sanitizeOutput($event['title']); ?></td>
                                        <td><?php echo !empty($event['start_date']) ? sanitizeOutput(date('M d, Y', strtotime($event['start_date']))) : 'N/A'; ?></td>
                                        <td><?php echo !empty($event['end_date']) ? sanitizeOutput(date('M d, Y', strtotime($event['end_date']))) : 'N/A'; ?></td>
                                        <td><span class="btn button-sm <?php echo getStatusButtonClass($event['status']); ?>"><?php echo sanitizeOutput($event['status']); ?></span></td>
                                        <td>
                                            <?php if ($canManageEvents): ?>
                                                <a class="btn button-sm blue" href="?q=<?php echo urlencode($search); ?>&status=<?php echo urlencode($statusFilter); ?>&page=<?php echo $pagination['currentPage']; ?>&edit=<?php echo (int)$event['row_id']; ?>">Edit</a>
                                                <form method="post" style="display: inline;" onsubmit="return confirm('Delete this event?');">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?php echo (int)$event['row_id']; ?>">
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
                            <?php if ($pagination['hasPrev']): ?><a class="btn button-sm outline" href="?q=<?php echo urlencode($search); ?>&status=<?php echo urlencode($statusFilter); ?>&page=<?php echo $pagination['prevPage']; ?>">Prev</a><?php endif; ?>
                            <span class="m-l10 m-r10">Page <?php echo $pagination['currentPage']; ?> of <?php echo $pagination['totalPages']; ?></span>
                            <?php if ($pagination['hasNext']): ?><a class="btn button-sm outline" href="?q=<?php echo urlencode($search); ?>&status=<?php echo urlencode($statusFilter); ?>&page=<?php echo $pagination['nextPage']; ?>">Next</a><?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php
$dashboardData = getDashboardData();
$calendarEvents = json_encode($dashboardData['events'], JSON_UNESCAPED_SLASHES);
$inlineScript = <<<JAVASCRIPT
(function() {
    'use strict';
    if (typeof jQuery !== 'undefined' && jQuery.fn.fullCalendar) {
        jQuery(document).ready(function($) {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listWeek'
                },
                defaultDate: new Date(),
                navLinks: true,
                editable: false,
                eventLimit: true,
                events: $calendarEvents
            });
        });
    }
})();
JAVASCRIPT;
include('includes/admin-footer.php');
?>
