<?php
/**
 * WAMDEVIN Alumni Portal - Alumni Directory
 * Searchable, filterable alumni directory with connect functionality.
 *
 * @version 1.0.0
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/middleware.php';

$authPayload = requireAlumniAuth();
$pdo         = getAlumniDB();
$alumniId    = (int)$authPayload['sub'];

// ─── View a single alumni profile ─────────────────────────────────────────
$viewId = (int)((isset($_GET['id']) ? $_GET['id'] : 0));

if ($viewId && $viewId !== $alumniId) {
    // Single profile view
    $stmt = $pdo->prepare("
        SELECT a.id, a.first_name, a.last_name, a.email, a.avatar, a.role, a.created_at,
               ap.graduation_year, ap.degree, ap.department, ap.current_title, ap.current_company,
               ap.industry, ap.country, ap.city, ap.bio, ap.linkedin_url, ap.twitter_url,
               ap.website_url, ap.skills, ap.interests, ap.is_public
          FROM alumni a
          LEFT JOIN alumni_profiles ap ON ap.alumni_id = a.id
         WHERE a.id=? AND a.status='active' AND a.deleted_at IS NULL
    ");
    $stmt->execute([$viewId]);
    $viewAlumni = $stmt->fetch();

    // Connection status
    $connStmt = $pdo->prepare("
        SELECT id, status, requester_id FROM alumni_connections
         WHERE (requester_id=? AND receiver_id=?) OR (requester_id=? AND receiver_id=?)
         LIMIT 1
    ");
    $connStmt->execute([$alumniId, $viewId, $viewId, $alumniId]);
    $connection = $connStmt->fetch();

    // Education & work
    $edu  = $pdo->prepare("SELECT * FROM alumni_education WHERE alumni_id=? ORDER BY end_year DESC")->execute([$viewId]) ? [] : [];
    $eduS = $pdo->prepare("SELECT * FROM alumni_education WHERE alumni_id=? ORDER BY end_year DESC"); $eduS->execute([$viewId]);
    $viewEdu  = $eduS->fetchAll();
    $workS    = $pdo->prepare("SELECT * FROM alumni_work_experience WHERE alumni_id=? ORDER BY is_current DESC, start_date DESC"); $workS->execute([$viewId]);
    $viewWork = $workS->fetchAll();
}

// ─── Directory Listing ─────────────────────────────────────────────────────
$search     = trim((isset($_GET['search']) ? $_GET['search'] : ''));
$filterYear = (int)((isset($_GET['year']) ? $_GET['year'] : 0));
$filterCountry = trim((isset($_GET['country']) ? $_GET['country'] : ''));
$filterIndustry = trim((isset($_GET['industry']) ? $_GET['industry'] : ''));
$page       = max(1, (int)((isset($_GET['p']) ? $_GET['p'] : 1)));
$perPage    = 12;
$offset     = ($page - 1) * $perPage;

$where  = ["a.status='active'", "a.deleted_at IS NULL", "ap.is_public=1", "a.id != ?"];
$params = [$alumniId];

if ($search) {
    $where[] = "(a.first_name LIKE ? OR a.last_name LIKE ? OR ap.current_title LIKE ? OR ap.current_company LIKE ? OR ap.bio LIKE ?)";
    $like = '%' . $search . '%';
    array_push($params, $like, $like, $like, $like, $like);
}
if ($filterYear) { $where[] = "ap.graduation_year=?"; $params[] = $filterYear; }
if ($filterCountry) { $where[] = "ap.country LIKE ?"; $params[] = '%' . $filterCountry . '%'; }
if ($filterIndustry) { $where[] = "ap.industry LIKE ?"; $params[] = '%' . $filterIndustry . '%'; }

$whereSql = implode(' AND ', $where);

// Count
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM alumni a LEFT JOIN alumni_profiles ap ON ap.alumni_id=a.id WHERE {$whereSql}");
$countStmt->execute($params);
$total     = (int)$countStmt->fetchColumn();
$totalPages = (int)ceil($total / $perPage);

// Fetch
$listStmt = $pdo->prepare("
    SELECT a.id, a.first_name, a.last_name, a.avatar, a.email,
           ap.graduation_year, ap.degree, ap.current_title, ap.current_company,
           ap.country, ap.city, ap.industry,
           (SELECT status FROM alumni_connections c
             WHERE (c.requester_id=? AND c.receiver_id=a.id) OR (c.requester_id=a.id AND c.receiver_id=?)
             LIMIT 1) as conn_status
      FROM alumni a
      LEFT JOIN alumni_profiles ap ON ap.alumni_id=a.id
     WHERE {$whereSql}
     ORDER BY a.first_name ASC
     LIMIT {$perPage} OFFSET {$offset}
");
$listStmt->execute(array_merge([$alumniId, $alumniId], $params));
$alumniList = $listStmt->fetchAll();

// Distinct filter values
$countries  = $pdo->query("SELECT DISTINCT country FROM alumni_profiles WHERE country IS NOT NULL ORDER BY country")->fetchAll(PDO::FETCH_COLUMN);
$industries = $pdo->query("SELECT DISTINCT industry FROM alumni_profiles WHERE industry IS NOT NULL ORDER BY industry")->fetchAll(PDO::FETCH_COLUMN);

$pageTitle   = 'Alumni Directory';
$currentPage = 'directory';
include __DIR__ . '/includes/header.php';
?>

<?php if (isset($viewAlumni)): ?>
<!-- ===================== SINGLE PROFILE VIEW ===================== -->
<div class="mb-4">
    <a href="<?= ALUMNI_BASE_URL ?>/directory.php" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700">
        <i class="fa fa-arrow-left text-xs"></i> Back to Directory
    </a>
</div>

<?php if (!$viewAlumni || ($viewAlumni['is_public'] == 0 && $authPayload['role'] === 'alumni')): ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center text-gray-400">
    <i class="fa fa-lock text-4xl mb-3 block text-gray-300"></i>
    <h2 class="text-lg font-bold text-gray-800 mb-1">Profile Not Found</h2>
    <p class="text-sm">This profile is private or does not exist.</p>
</div>
<?php else: ?>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Cover -->
    <div class="h-28 sm:h-40 bg-gradient-to-r from-wam-navy to-indigo-700" style="background:linear-gradient(135deg,#1a3a5c,#2d5a8e)"></div>
    <div class="px-6 pb-6">
        <div class="flex flex-col sm:flex-row sm:items-end gap-4 -mt-12 mb-4">
            <img src="<?= e(getAvatarUrl((isset($viewAlumni['avatar']) ? $viewAlumni['avatar'] : null), $viewAlumni['email'], 96)) ?>"
                 class="w-24 h-24 rounded-2xl object-cover border-4 border-white shadow-md flex-shrink-0"
                 onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($viewAlumni['first_name'].' '.$viewAlumni['last_name']) ?>&background=4f46e5&color=fff&size=96'">
            <div class="sm:mb-2 flex-1">
                <h1 class="text-2xl font-bold text-gray-900"><?= e($viewAlumni['first_name'] . ' ' . $viewAlumni['last_name']) ?></h1>
                <?php if (!empty($viewAlumni['current_title'])): ?>
                <p class="text-gray-600"><?= e($viewAlumni['current_title']) ?><?= !empty($viewAlumni['current_company']) ? ' · ' . e($viewAlumni['current_company']) : '' ?></p>
                <?php endif; ?>
                <div class="flex flex-wrap gap-3 mt-2 text-sm text-gray-400">
                    <?php if (!empty($viewAlumni['country'])): ?>
                    <span><i class="fa fa-map-pin mr-1"></i><?= e($viewAlumni['country']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($viewAlumni['graduation_year'])): ?>
                    <span><i class="fa fa-graduation-cap mr-1"></i>Class of <?= $viewAlumni['graduation_year'] ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Actions -->
            <div class="flex gap-2 sm:mb-2">
                <?php if ($connection && $connection['status'] === 'accepted'): ?>
                <span class="inline-flex items-center gap-1 px-4 py-2 rounded-xl bg-green-100 text-green-700 text-sm font-medium">
                    <i class="fa fa-check"></i> Connected
                </span>
                <a href="<?= ALUMNI_BASE_URL ?>/messages.php?to=<?= $viewId ?>"
                   class="inline-flex items-center gap-1 px-4 py-2 rounded-xl border border-gray-200 text-gray-700 text-sm font-medium hover:bg-gray-50 transition">
                    <i class="fa fa-envelope"></i> Message
                </a>
                <?php elseif ($connection && $connection['status'] === 'pending'): ?>
                <span class="inline-flex items-center gap-1 px-4 py-2 rounded-xl bg-yellow-50 text-yellow-700 text-sm font-medium border border-yellow-200">
                    <i class="fa fa-clock"></i>
                    <?= $connection['requester_id'] == $alumniId ? 'Request Sent' : 'Request Received' ?>
                </span>
                <?php else: ?>
                <button onclick="connectAlumni(<?= $viewId ?>)"
                        class="inline-flex items-center gap-1 px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition">
                    <i class="fa fa-user-plus"></i> Connect
                </button>
                <?php endif; ?>
                <?php if (!empty($viewAlumni['linkedin_url'])): ?>
                <a href="<?= e($viewAlumni['linkedin_url']) ?>" target="_blank" rel="noopener noreferrer"
                   class="w-10 h-10 rounded-xl bg-blue-700 flex items-center justify-center text-white hover:opacity-90 transition">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Profile Body -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-4">
            <div class="lg:col-span-2 space-y-6">
                <?php if (!empty($viewAlumni['bio'])): ?>
                <div>
                    <h2 class="font-bold text-gray-900 mb-2 text-sm flex items-center gap-2"><i class="fa fa-user text-indigo-500"></i> About</h2>
                    <p class="text-gray-600 text-sm leading-relaxed"><?= nl2br(e($viewAlumni['bio'])) ?></p>
                </div>
                <?php endif; ?>

                <?php if (!empty($viewWork)): ?>
                <div>
                    <h2 class="font-bold text-gray-900 mb-3 text-sm flex items-center gap-2"><i class="fa fa-briefcase text-indigo-500"></i> Experience</h2>
                    <div class="space-y-3">
                        <?php foreach ($viewWork as $w): ?>
                        <div class="flex gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                                <i class="fa fa-building text-gray-400 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm"><?= e($w['title']) ?></p>
                                <p class="text-gray-500 text-xs"><?= e($w['company']) ?><?= !empty($w['location']) ? ' · ' . e($w['location']) : '' ?></p>
                                <p class="text-gray-400 text-xs">
                                    <?= $w['start_date'] ? date('M Y', strtotime($w['start_date'])) : '' ?>
                                    <?= $w['is_current'] ? ' – Present' : ($w['end_date'] ? ' – ' . date('M Y', strtotime($w['end_date'])) : '') ?>
                                </p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($viewEdu)): ?>
                <div>
                    <h2 class="font-bold text-gray-900 mb-3 text-sm flex items-center gap-2"><i class="fa fa-graduation-cap text-indigo-500"></i> Education</h2>
                    <div class="space-y-3">
                        <?php foreach ($viewEdu as $edu): ?>
                        <div class="flex gap-3">
                            <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center flex-shrink-0">
                                <i class="fa fa-school text-indigo-400 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm"><?= e($edu['institution']) ?></p>
                                <p class="text-gray-500 text-xs"><?= e($edu['degree']) ?><?= !empty($edu['field_of_study']) ? ' · ' . e($edu['field_of_study']) : '' ?></p>
                                <p class="text-gray-400 text-xs"><?= $edu['start_year'] ? $edu['start_year'] : '' ?><?= $edu['end_year'] ? ' – ' . $edu['end_year'] : '' ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="space-y-4">
                <?php if (!empty($viewAlumni['skills'])): ?>
                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="font-bold text-gray-900 text-sm mb-2">Skills</h3>
                    <div class="flex flex-wrap gap-1.5">
                        <?php foreach (array_filter(array_map('trim', explode(',', $viewAlumni['skills']))) as $skill): ?>
                        <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded-full text-xs font-medium"><?= e($skill) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="bg-gray-50 rounded-xl p-4 text-sm space-y-2">
                    <h3 class="font-bold text-gray-900 mb-2">Details</h3>
                    <?php if ($viewAlumni['industry']): ?>
                    <div class="flex items-center gap-2 text-gray-600"><i class="fa fa-industry w-4 text-gray-400"></i><?= e($viewAlumni['industry']) ?></div>
                    <?php endif; ?>
                    <?php if ($viewAlumni['degree']): ?>
                    <div class="flex items-center gap-2 text-gray-600"><i class="fa fa-graduation-cap w-4 text-gray-400"></i><?= e($viewAlumni['degree']) ?></div>
                    <?php endif; ?>
                    <div class="flex items-center gap-2 text-gray-400"><i class="fa fa-calendar w-4"></i>Joined <?= date('Y', strtotime($viewAlumni['created_at'])) ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function connectAlumni(receiverId) {
    fetch('<?= ALUMNI_BASE_URL ?>/api/connections.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({action: 'request', receiver_id: receiverId, csrf_token: '<?= generateCsrfToken() ?>'})
    }).then(r => r.json()).then(d => {
        if (d.success) location.reload();
        else alert(d.message || 'Error sending request');
    }).catch(() => alert('Network error. Please try again.'));
}
</script>

<?php endif; ?>

<?php else: ?>
<!-- ===================== DIRECTORY LISTING ===================== -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Alumni Directory</h1>
        <p class="text-gray-500 text-sm mt-0.5"><?= number_format($total) ?> <?= $total === 1 ? 'alumni' : 'alumni' ?> found</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
    <form method="GET" class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <i class="fa fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" name="search" value="<?= e($search) ?>"
                   placeholder="Search by name, title, company..."
                   class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500">
        </div>
        <select name="year" class="px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none bg-white">
            <option value="">All Years</option>
            <?php for ($y = (int)date('Y'); $y >= 1960; $y--): ?>
            <option value="<?= $y ?>" <?= $filterYear == $y ? 'selected' : '' ?>><?= $y ?></option>
            <?php endfor; ?>
        </select>
        <select name="country" class="px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none bg-white">
            <option value="">All Countries</option>
            <?php foreach ($countries as $c): ?>
            <option value="<?= e($c) ?>" <?= $filterCountry === $c ? 'selected' : '' ?>><?= e($c) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="industry" class="px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none bg-white">
            <option value="">All Industries</option>
            <?php foreach ($industries as $ind): ?>
            <option value="<?= e($ind) ?>" <?= $filterIndustry === $ind ? 'selected' : '' ?>><?= e($ind) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-medium hover:bg-indigo-700 transition">
            Search
        </button>
        <?php if ($search || $filterYear || $filterCountry || $filterIndustry): ?>
        <a href="?" class="px-4 py-2.5 border border-gray-200 text-gray-600 rounded-xl text-sm hover:bg-gray-50 transition">Clear</a>
        <?php endif; ?>
    </form>
</div>

<?php if (empty($alumniList)): ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center text-gray-400">
    <i class="fa fa-users-slash text-4xl mb-3 block"></i>
    <p class="font-medium text-gray-700">No alumni found</p>
    <p class="text-sm mt-1">Try adjusting your search filters.</p>
</div>
<?php else: ?>

<!-- Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-6">
    <?php foreach ($alumniList as $al): ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 card-hover flex flex-col" x-data="{ sent: false, connected: '<?= e((isset($al['conn_status']) ? $al['conn_status'] : '')) ?>' }">
        <a href="?id=<?= $al['id'] ?>" class="flex flex-col items-center text-center mb-4">
            <img src="<?= e(getAvatarUrl((isset($al['avatar']) ? $al['avatar'] : null), $al['email'], 64)) ?>"
                 class="w-16 h-16 rounded-2xl object-cover mb-3 border-2 border-gray-100"
                 onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($al['first_name'].' '.$al['last_name']) ?>&background=6366f1&color=fff&size=64'">
            <h3 class="font-bold text-gray-900 text-sm"><?= e($al['first_name'] . ' ' . $al['last_name']) ?></h3>
            <?php if (!empty($al['current_title'])): ?>
            <p class="text-xs text-gray-500 mt-0.5 truncate max-w-full"><?= e($al['current_title']) ?></p>
            <?php endif; ?>
            <?php if (!empty($al['current_company'])): ?>
            <p class="text-xs text-indigo-600 truncate max-w-full"><?= e($al['current_company']) ?></p>
            <?php endif; ?>
        </a>

        <!-- Meta chips -->
        <div class="flex flex-wrap justify-center gap-1 mb-4">
            <?php if (!empty($al['country'])): ?>
            <span class="text-xs px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full">
                <i class="fa fa-map-pin text-xs mr-0.5"></i><?= e($al['country']) ?>
            </span>
            <?php endif; ?>
            <?php if (!empty($al['graduation_year'])): ?>
            <span class="text-xs px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded-full">
                <?= $al['graduation_year'] ?>
            </span>
            <?php endif; ?>
        </div>

        <!-- Action -->
        <div class="mt-auto flex gap-2">
            <a href="?id=<?= $al['id'] ?>" class="flex-1 py-1.5 text-center border border-gray-200 text-gray-600 rounded-lg text-xs font-medium hover:bg-gray-50 transition">View</a>
            <template x-if="connected === 'accepted'">
                <span class="flex-1 py-1.5 text-center bg-green-50 text-green-700 rounded-lg text-xs font-medium">Connected</span>
            </template>
            <template x-if="connected === 'pending'">
                <span class="flex-1 py-1.5 text-center bg-yellow-50 text-yellow-700 rounded-lg text-xs font-medium">Pending</span>
            </template>
            <template x-if="!connected && !sent">
                <button @click="
                    fetch('<?= ALUMNI_BASE_URL ?>/api/connections.php',{
                        method:'POST',headers:{'Content-Type':'application/json'},
                        body:JSON.stringify({action:'request',receiver_id:<?= $al['id'] ?>,csrf_token:'<?= generateCsrfToken() ?>'})
                    }).then(r=>r.json()).then(d=>{if(d.success)sent=true;})
                " class="flex-1 py-1.5 text-center bg-indigo-600 text-white rounded-lg text-xs font-medium hover:bg-indigo-700 transition">
                    Connect
                </button>
            </template>
            <template x-if="!connected && sent">
                <span class="flex-1 py-1.5 text-center bg-indigo-50 text-indigo-700 rounded-lg text-xs font-medium">Sent!</span>
            </template>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Pagination -->
<?php if ($totalPages > 1): ?>
<div class="flex items-center justify-center gap-2">
    <?php if ($page > 1): ?>
    <a href="?<?= http_build_query(array_merge($_GET, ['p' => $page - 1])) ?>"
       class="px-4 py-2 rounded-xl border border-gray-200 text-sm text-gray-600 hover:bg-gray-50 transition">
        <i class="fa fa-chevron-left mr-1"></i> Prev
    </a>
    <?php endif; ?>
    <?php for ($p = max(1, $page - 2); $p <= min($totalPages, $page + 2); $p++): ?>
    <a href="?<?= http_build_query(array_merge($_GET, ['p' => $p])) ?>"
       class="px-4 py-2 rounded-xl text-sm font-medium transition
              <?= $p === $page ? 'bg-indigo-600 text-white' : 'border border-gray-200 text-gray-600 hover:bg-gray-50' ?>">
        <?= $p ?>
    </a>
    <?php endfor; ?>
    <?php if ($page < $totalPages): ?>
    <a href="?<?= http_build_query(array_merge($_GET, ['p' => $page + 1])) ?>"
       class="px-4 py-2 rounded-xl border border-gray-200 text-sm text-gray-600 hover:bg-gray-50 transition">
        Next <i class="fa fa-chevron-right ml-1"></i>
    </a>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php endif; ?>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
