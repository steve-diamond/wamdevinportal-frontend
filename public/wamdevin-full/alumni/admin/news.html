<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/middleware.php';

$authPayload = requireAdminAuth();
$pdo = getAlumniDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken((isset($_POST['csrf_token']) ? $_POST['csrf_token'] : ''))) {
        setFlash('error', 'Invalid request token.');
        redirect(ALUMNI_BASE_URL . '/admin/news.php');
    }

    $title = trim((isset($_POST['title']) ? $_POST['title'] : ''));
    $excerpt = trim((isset($_POST['excerpt']) ? $_POST['excerpt'] : ''));
    $content = trim((isset($_POST['content']) ? $_POST['content'] : ''));
    $category = trim((isset($_POST['category']) ? $_POST['category'] : ''));
    $status = (isset($_POST['status']) ? $_POST['status'] : 'draft');
    $isFeatured = !empty($_POST['is_featured']) ? 1 : 0;

    if ($title !== '' && $content !== '') {
        $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $title), '-')) . '-' . time();
        $stmt = $pdo->prepare("INSERT INTO alumni_news (title, slug, excerpt, content, category, status, is_featured, author_id, published_at)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $publishedAt = $status === 'published' ? date('Y-m-d H:i:s') : null;
        $stmt->execute([$title, $slug, $excerpt ?: null, $content, $category ?: null, $status, $isFeatured, (int)$authPayload['sub'], $publishedAt]);
        setFlash('success', 'News item created.');
    } else {
        setFlash('error', 'Title and content are required.');
    }

    redirect(ALUMNI_BASE_URL . '/admin/news.php');
}

$news = $pdo->query("SELECT id, title, category, status, is_featured, published_at, created_at FROM alumni_news ORDER BY created_at DESC LIMIT 120")->fetchAll();

$pageTitle = 'Manage News';
$currentPage = 'admin';
include __DIR__ . '/../includes/header.php';
$flash = getFlash();
?>

<div class="mb-5 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-900">Manage News</h1>
    <a href="<?= ALUMNI_BASE_URL ?>/admin/index.php" class="text-sm text-indigo-600 hover:underline">Back to admin</a>
</div>
<?php if ($flash): ?><div class="mb-4 rounded-xl border px-4 py-3 text-sm <?= $flash['type']==='success' ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700' ?>"><?= e($flash['message']) ?></div><?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <h2 class="font-semibold text-gray-900 mb-3">Create News</h2>
        <form method="POST" class="space-y-3">
            <?= csrfField() ?>
            <input name="title" required placeholder="Title" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
            <input name="category" placeholder="Category" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
            <textarea name="excerpt" rows="2" placeholder="Excerpt" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm"></textarea>
            <textarea name="content" rows="6" required placeholder="News content" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm"></textarea>
            <label class="inline-flex items-center gap-2 text-sm text-gray-600"><input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300"> Featured</label>
            <select name="status" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm"><?php foreach (['draft','published','archived'] as $s): ?><option value="<?= $s ?>"><?= ucfirst($s) ?></option><?php endforeach; ?></select>
            <button class="w-full bg-indigo-600 text-white rounded-lg px-4 py-2.5 text-sm font-semibold">Save News</button>
        </form>
    </div>

    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600"><tr><th class="text-left px-4 py-3">Title</th><th class="text-left px-4 py-3">Category</th><th class="text-left px-4 py-3">Status</th><th class="text-left px-4 py-3">Published</th></tr></thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach ($news as $n): ?>
                <tr>
                    <td class="px-4 py-3"><p class="font-medium text-gray-900"><?= e($n['title']) ?></p><?php if ((int)$n['is_featured']): ?><span class="text-xs px-2 py-0.5 rounded-full bg-amber-50 text-amber-700">Featured</span><?php endif; ?></td>
                    <td class="px-4 py-3"><?= e($n['category'] ?: 'N/A') ?></td>
                    <td class="px-4 py-3"><span class="px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-700"><?= e($n['status']) ?></span></td>
                    <td class="px-4 py-3 text-xs text-gray-500"><?= $n['published_at'] ? date('M j, Y', strtotime($n['published_at'])) : '-' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
