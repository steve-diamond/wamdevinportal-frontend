<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/middleware.php';

$authPayload = requireAlumniAuth();
$pdo = getAlumniDB();

$newsId = (int)((isset($_GET['id']) ? $_GET['id'] : 0));
$category = trim((isset($_GET['category']) ? $_GET['category'] : ''));

if ($newsId > 0) {
    $stmt = $pdo->prepare("SELECT * FROM alumni_news WHERE id=? AND status='published' LIMIT 1");
    $stmt->execute([$newsId]);
    $article = $stmt->fetch();
    if ($article) {
        $pdo->prepare("UPDATE alumni_news SET views=views+1 WHERE id=?")->execute([$newsId]);
    }
} else {
    $article = null;
}

$where = ["status='published'"];
$params = [];
if ($category !== '') {
    $where[] = 'category=?';
    $params[] = $category;
}
$whereSql = implode(' AND ', $where);

$listStmt = $pdo->prepare("SELECT id, title, excerpt, category, image, is_featured, views, published_at
                           FROM alumni_news WHERE {$whereSql}
                           ORDER BY is_featured DESC, published_at DESC LIMIT 30");
$listStmt->execute($params);
$newsList = $listStmt->fetchAll();

$catStmt = $pdo->query("SELECT DISTINCT category FROM alumni_news WHERE category IS NOT NULL AND category<>'' ORDER BY category");
$categories = $catStmt->fetchAll(PDO::FETCH_COLUMN);

$pageTitle = $article ? $article['title'] : 'News';
$currentPage = 'news';
include __DIR__ . '/includes/header.php';
?>

<?php if ($article): ?>
<div class="mb-4"><a href="<?= ALUMNI_BASE_URL ?>/news.php" class="text-sm text-gray-500 hover:text-gray-700"><i class="fa fa-arrow-left mr-1"></i>Back to News</a></div>
<article class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <?php if (!empty($article['image'])): ?>
    <img src="<?= e($article['image']) ?>" alt="" class="w-full h-64 object-cover">
    <?php else: ?>
    <div class="h-40 bg-gradient-to-r from-wam-navy to-indigo-600"></div>
    <?php endif; ?>
    <div class="p-6 sm:p-8">
        <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
            <?php if (!empty($article['category'])): ?><span class="px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700"><?= e($article['category']) ?></span><?php endif; ?>
            <span><?= $article['published_at'] ? date('M j, Y', strtotime($article['published_at'])) : date('M j, Y') ?></span>
            <span>·</span>
            <span><?= (int)$article['views'] ?> views</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 leading-tight"><?= e($article['title']) ?></h1>
        <?php if (!empty($article['excerpt'])): ?><p class="mt-4 text-gray-600"><?= e($article['excerpt']) ?></p><?php endif; ?>
        <div class="mt-6 text-gray-700 leading-relaxed space-y-4"><?= nl2br(e(strip_tags((string)$article['content']))) ?></div>
    </div>
</article>
<?php else: ?>
<div class="flex items-center justify-between mb-5">
    <h1 class="text-2xl font-bold text-gray-900">News & Announcements</h1>
    <form method="GET">
        <select name="category" onchange="this.form.submit()" class="border border-gray-200 rounded-lg px-3 py-2 text-sm">
            <option value="">All Categories</option>
            <?php foreach ($categories as $c): ?>
            <option value="<?= e($c) ?>" <?= $category === $c ? 'selected' : '' ?>><?= e($c) ?></option>
            <?php endforeach; ?>
        </select>
    </form>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
    <?php if (!$newsList): ?>
    <div class="md:col-span-2 xl:col-span-3 bg-white rounded-2xl border border-gray-100 shadow-sm p-10 text-center text-gray-400">
        <i class="fa fa-newspaper text-3xl mb-2 block"></i>No published news yet.
    </div>
    <?php endif; ?>
    <?php foreach ($newsList as $n): ?>
    <a href="<?= ALUMNI_BASE_URL ?>/news.php?id=<?= (int)$n['id'] ?>" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden card-hover block">
        <?php if (!empty($n['image'])): ?><img src="<?= e($n['image']) ?>" alt="" class="w-full h-40 object-cover"><?php else: ?><div class="h-24 bg-gradient-to-r from-indigo-500 to-cyan-500"></div><?php endif; ?>
        <div class="p-5">
            <div class="flex items-center gap-2 mb-2 text-xs">
                <?php if (!empty($n['category'])): ?><span class="px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-700"><?= e($n['category']) ?></span><?php endif; ?>
                <?php if (!empty($n['is_featured'])): ?><span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-700">Featured</span><?php endif; ?>
            </div>
            <h2 class="font-semibold text-gray-900 leading-snug"><?= e($n['title']) ?></h2>
            <?php if (!empty($n['excerpt'])): ?><p class="text-sm text-gray-600 mt-2 line-clamp-3"><?= e($n['excerpt']) ?></p><?php endif; ?>
            <p class="text-xs text-gray-400 mt-3"><?= $n['published_at'] ? date('M j, Y', strtotime($n['published_at'])) : '-' ?></p>
        </div>
    </a>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
