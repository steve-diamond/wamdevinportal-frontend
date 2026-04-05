<?php
$pageTitle = 'Alumni News - WAMDEVIN Admin';
$pageDescription = 'Manage alumni news and announcements';
$currentPage = 'alumni-news';
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
    $excerpt = trim(isset($_POST['excerpt']) ? $_POST['excerpt'] : '');
    $content = trim(isset($_POST['content']) ? $_POST['content'] : '');
    $category = trim(isset($_POST['category']) ? $_POST['category'] : '');
    $status = isset($_POST['status']) ? $_POST['status'] : 'draft';
    $featured = isset($_POST['is_featured']) ? 1 : 0;

    if ($title !== '' && $content !== '') {
        try {
            $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $title), '-')) . '-' . time();
            $publishedAt = $status === 'published' ? date('Y-m-d H:i:s') : null;
            $stmt = $pdo->prepare("INSERT INTO alumni_news (title, slug, excerpt, content, category, status, is_featured, author_id, published_at) VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?)");
            $stmt->execute(array($title, $slug, $excerpt ?: null, $content, $category ?: null, $status, $featured, $publishedAt));
            $message = 'News article created successfully.';
        } catch (Exception $e) {
            $error = 'Could not create article: ' . $e->getMessage();
        }
    } else {
        $error = 'Title and content are required.';
    }
}

$news = array();
if ($pdo) {
    try {
        $news = $pdo->query("SELECT id, title, category, status, is_featured, published_at, created_at FROM alumni_news ORDER BY created_at DESC LIMIT 120")->fetchAll();
    } catch (Exception $e) {
        $error = 'Could not load news: ' . $e->getMessage();
    }
}
?>

<main class="ttr-wrapper" id="main-content" role="main">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Alumni News</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
                <li><a href="alumni-portal.php">Alumni Portal</a></li>
                <li>News</li>
            </ul>
        </div>

        <?php if ($message): ?><div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div><?php endif; ?>
        <?php if ($error): ?><div class="alert alert-warning"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>

        <div class="row">
            <div class="col-md-4">
                <div class="widget-box">
                    <div class="wc-title"><h4>Create News</h4></div>
                    <div class="widget-inner">
                        <form method="post">
                            <div class="form-group"><label>Title</label><input type="text" name="title" class="form-control" required></div>
                            <div class="form-group"><label>Category</label><input type="text" name="category" class="form-control"></div>
                            <div class="form-group"><label>Excerpt</label><textarea name="excerpt" rows="2" class="form-control"></textarea></div>
                            <div class="form-group"><label>Content</label><textarea name="content" rows="5" class="form-control" required></textarea></div>
                            <div class="form-group"><label><input type="checkbox" name="is_featured" value="1"> Featured article</label></div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <?php foreach (array('draft','published','archived') as $s): ?>
                                    <option value="<?php echo $s; ?>"><?php echo ucfirst($s); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button class="btn btn-primary">Publish</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="widget-box">
                    <div class="wc-title"><h4>Recent News</h4></div>
                    <div class="widget-inner table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead><tr><th>Title</th><th>Category</th><th>Status</th><th>Featured</th><th>Date</th></tr></thead>
                            <tbody>
                            <?php foreach ($news as $n): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($n['title']); ?></td>
                                <td><?php echo htmlspecialchars($n['category']); ?></td>
                                <td><?php echo htmlspecialchars($n['status']); ?></td>
                                <td><?php echo (int)$n['is_featured'] ? 'Yes' : 'No'; ?></td>
                                <td><?php echo $n['published_at'] ? date('M j, Y', strtotime($n['published_at'])) : date('M j, Y', strtotime($n['created_at'])); ?></td>
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
