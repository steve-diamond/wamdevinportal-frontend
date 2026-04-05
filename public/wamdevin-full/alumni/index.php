<?php
/**
 * WAMDEVIN Alumni Portal - Dashboard (Home)
 *
 * Protected page – shows personalised stats, upcoming events,
 * recent jobs, news feed, pending network requests, etc.
 *
 * @version 1.0.0
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/middleware.php';

$authPayload = requireAlumniAuth();
$alumni      = getCurrentAlumni();
$pdo         = getAlumniDB();

// ─── Dashboard Data ────────────────────────────────────────────────────────
$stats = ['connections' => 0, 'pending_requests' => 0, 'events_registered' => 0, 'jobs_applied' => 0];

try {
    $id = (int)$authPayload['sub'];

    // Connection count
    $s = $pdo->prepare("SELECT COUNT(*) FROM alumni_connections WHERE (requester_id=? OR receiver_id=?) AND status='accepted'");
    $s->execute([$id, $id]);
    $stats['connections'] = (int)$s->fetchColumn();

    // Pending connection requests
    $s = $pdo->prepare("SELECT COUNT(*) FROM alumni_connections WHERE receiver_id=? AND status='pending'");
    $s->execute([$id]);
    $stats['pending_requests'] = (int)$s->fetchColumn();

    // Events registered
    $s = $pdo->prepare("SELECT COUNT(*) FROM alumni_event_registrations WHERE alumni_id=?");
    $s->execute([$id]);
    $stats['events_registered'] = (int)$s->fetchColumn();

    // Jobs applied
    $s = $pdo->prepare("SELECT COUNT(*) FROM alumni_job_applications WHERE alumni_id=?");
    $s->execute([$id]);
    $stats['jobs_applied'] = (int)$s->fetchColumn();

    // Upcoming events (next 3)
    $eventsStmt = $pdo->prepare("
        SELECT e.id, e.title, e.slug, e.event_type, e.location, e.is_virtual,
               e.start_datetime, e.end_datetime, e.image,
               (SELECT COUNT(*) FROM alumni_event_registrations r WHERE r.event_id=e.id AND r.alumni_id=?) as is_registered
          FROM alumni_events e
         WHERE e.status='published' AND e.start_datetime > NOW()
         ORDER BY e.start_datetime ASC
         LIMIT 3
    ");
    $eventsStmt->execute([$id]);
    $upcomingEvents = $eventsStmt->fetchAll();

    // Latest 4 jobs
    $jobsStmt = $pdo->query("
        SELECT id, title, slug, company, job_type, location, is_remote, created_at
          FROM alumni_jobs
         WHERE status='published' AND (expires_at IS NULL OR expires_at > NOW())
         ORDER BY created_at DESC
         LIMIT 4
    ");
    $latestJobs = $jobsStmt->fetchAll();

    // Recent news (3)
    $newsStmt = $pdo->query("
        SELECT id, title, slug, excerpt, image, category, published_at
          FROM alumni_news
         WHERE status='published'
         ORDER BY published_at DESC
         LIMIT 3
    ");
    $recentNews = $newsStmt->fetchAll();

    // Pending connection requests with names
    $pendingStmt = $pdo->prepare("
        SELECT c.id as conn_id, a.id, a.first_name, a.last_name, a.avatar, a.email,
               ap.current_title, ap.current_company, c.created_at
          FROM alumni_connections c
          JOIN alumni a ON a.id = c.requester_id
          LEFT JOIN alumni_profiles ap ON ap.alumni_id = a.id
         WHERE c.receiver_id=? AND c.status='pending'
         ORDER BY c.created_at DESC
         LIMIT 5
    ");
    $pendingStmt->execute([$id]);
    $pendingRequests = $pendingStmt->fetchAll();

    // People you may know (not connected, not self)
    $suggestStmt = $pdo->prepare("
        SELECT a.id, a.first_name, a.last_name, a.avatar, a.email,
               ap.current_title, ap.current_company, ap.country
          FROM alumni a
          LEFT JOIN alumni_profiles ap ON ap.alumni_id = a.id
         WHERE a.id != ?
           AND a.status='active'
           AND a.id NOT IN (
               SELECT CASE WHEN requester_id=? THEN receiver_id ELSE requester_id END
                 FROM alumni_connections
                WHERE (requester_id=? OR receiver_id=?) AND status IN ('accepted','pending','blocked')
           )
         ORDER BY RAND()
         LIMIT 4
    ");
    $suggestStmt->execute([$id, $id, $id, $id]);
    $suggestions = $suggestStmt->fetchAll();

} catch (PDOException $e) {
    error_log('Dashboard data error: ' . $e->getMessage());
    $upcomingEvents  = [];
    $latestJobs      = [];
    $recentNews      = [];
    $pendingRequests = [];
    $suggestions     = [];
}

$pageTitle   = 'My Dashboard';
$currentPage = 'dashboard';

include __DIR__ . '/includes/header.php';
?>

<!-- =====================================================================
     DASHBOARD CONTENT
====================================================================== -->

<!-- Welcome Banner -->
<div class="mb-8 bg-gradient-to-r from-wam-navy to-indigo-700 rounded-2xl p-6 sm:p-8 text-white relative overflow-hidden" style="background:linear-gradient(135deg,#1a3a5c 0%,#2d5a8e 100%)">
    <div class="relative z-10">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            <img src="<?= e(getAvatarUrl((isset($alumni['avatar']) ? $alumni['avatar'] : null), (isset($alumni['email']) ? $alumni['email'] : ''), 80)) ?>"
                 alt="<?= e((isset($alumni['first_name']) ? $alumni['first_name'] : '')) ?>"
                 class="w-16 h-16 rounded-2xl object-cover border-2 border-white/30">
            <div>
                <p class="text-indigo-200 text-sm font-medium">Welcome back,</p>
                <h1 class="text-2xl sm:text-3xl font-bold">
                    <?= e(((isset($alumni['first_name']) ? $alumni['first_name'] : '')) . ' ' . ((isset($alumni['last_name']) ? $alumni['last_name'] : ''))) ?>
                </h1>
                <?php if (!empty($alumni['current_title']) && !empty($alumni['current_company'])): ?>
                <p class="text-indigo-200 text-sm mt-1">
                    <?= e($alumni['current_title']) ?> at <?= e($alumni['current_company']) ?>
                </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Profile completion hint -->
        <?php
        $profileFields = ['bio', 'current_title', 'current_company', 'country', 'linkedin_url'];
        $filled = 0;
        foreach ($profileFields as $f) if (!empty($alumni[$f])) $filled++;
        $pct = (int)(($filled / count($profileFields)) * 100);
        ?>
        <?php if ($pct < 100): ?>
        <div class="mt-5 bg-white/10 rounded-xl p-4">
            <div class="flex items-center justify-between text-sm mb-2">
                <span class="font-medium">Complete your profile</span>
                <span class="font-bold"><?= $pct ?>%</span>
            </div>
            <div class="h-2 bg-white/20 rounded-full overflow-hidden">
                <div class="h-full bg-wam-gold rounded-full transition-all" style="width:<?= $pct ?>%"></div>
            </div>
            <a href="<?= ALUMNI_BASE_URL ?>/profile.php"
               class="mt-2 inline-block text-xs text-indigo-200 hover:text-white underline">
                Complete profile →
            </a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Decorative -->
    <div class="absolute -right-12 -top-12 w-48 h-48 rounded-full bg-white/5"></div>
    <div class="absolute -right-4 -bottom-8 w-32 h-32 rounded-full bg-white/5"></div>
</div>

<!-- Stats Row -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <?php
    $statCards = [
        ['icon' => 'fa-user-group',      'label' => 'Connections',         'value' => $stats['connections'],       'color' => 'indigo', 'link' => 'connections.php'],
        ['icon' => 'fa-bell',            'label' => 'Pending Requests',     'value' => $stats['pending_requests'],  'color' => 'orange', 'link' => 'connections.php?tab=requests'],
        ['icon' => 'fa-calendar-check',  'label' => 'Events Registered',    'value' => $stats['events_registered'], 'color' => 'green',  'link' => 'events.php'],
        ['icon' => 'fa-paper-plane',     'label' => 'Jobs Applied',          'value' => $stats['jobs_applied'],      'color' => 'blue',   'link' => 'jobs.php?tab=applied'],
    ];
    $colorMap = ['indigo' => '#6366f1', 'orange' => '#f97316', 'green' => '#22c55e', 'blue' => '#3b82f6'];
    foreach ($statCards as $card):
    ?>
    <a href="<?= ALUMNI_BASE_URL ?>/<?= $card['link'] ?>"
       class="bg-white rounded-xl p-4 sm:p-5 shadow-sm border border-gray-100 card-hover block">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                 style="background:<?= $colorMap[$card['color']] ?>20;">
                <i class="fa <?= $card['icon'] ?> text-base" style="color:<?= $colorMap[$card['color']] ?>;"></i>
            </div>
            <i class="fa fa-arrow-right text-gray-300 text-xs"></i>
        </div>
        <p class="text-2xl font-bold text-gray-900"><?= number_format($card['value']) ?></p>
        <p class="text-xs text-gray-500 mt-0.5"><?= $card['label'] ?></p>
    </a>
    <?php endforeach; ?>
</div>

<!-- Main Grid: 2/3 + 1/3 -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Left Column (2/3) -->
    <div class="lg:col-span-2 space-y-6">

        <!-- Upcoming Events -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 flex items-center justify-between border-b border-gray-100">
                <h2 class="font-bold text-gray-900 flex items-center gap-2">
                    <i class="fa fa-calendar text-indigo-500 text-sm"></i> Upcoming Events
                </h2>
                <a href="<?= ALUMNI_BASE_URL ?>/events.php" class="text-xs text-indigo-600 hover:underline font-medium">View all</a>
            </div>
            <div class="divide-y divide-gray-50">
                <?php if (empty($upcomingEvents)): ?>
                <div class="px-6 py-10 text-center text-gray-400">
                    <i class="fa fa-calendar-xmark text-3xl mb-2 block"></i>
                    <p class="text-sm">No upcoming events at the moment.</p>
                </div>
                <?php else: ?>
                <?php foreach ($upcomingEvents as $ev): ?>
                <div class="px-6 py-4 flex items-start gap-4 hover:bg-gray-50 transition-colors">
                    <!-- Date Badge -->
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-indigo-50 flex flex-col items-center justify-center">
                        <span class="text-xs font-bold text-indigo-600"><?= strtoupper(date('M', strtotime($ev['start_datetime']))) ?></span>
                        <span class="text-lg font-black text-indigo-700 leading-none"><?= date('d', strtotime($ev['start_datetime'])) ?></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-900 text-sm truncate">
                            <a href="<?= ALUMNI_BASE_URL ?>/events.php?id=<?= $ev['id'] ?>" class="hover:text-indigo-600"><?= e($ev['title']) ?></a>
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5 flex items-center gap-1">
                            <?php if ($ev['is_virtual']): ?>
                                <i class="fa fa-video text-green-500"></i> Online
                            <?php else: ?>
                                <i class="fa fa-map-pin text-red-400"></i> <?= e((isset($ev['location']) ? $ev['location'] : 'TBA')) ?>
                            <?php endif; ?>
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5"><?= date('D, g:i A', strtotime($ev['start_datetime'])) ?></p>
                    </div>
                    <div class="flex-shrink-0">
                        <?php if ($ev['is_registered']): ?>
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium">
                            <i class="fa fa-check text-xs"></i> Registered
                        </span>
                        <?php else: ?>
                        <a href="<?= ALUMNI_BASE_URL ?>/events.php?id=<?= $ev['id'] ?>"
                           class="inline-block px-3 py-1 bg-indigo-600 text-white rounded-full text-xs font-medium hover:bg-indigo-700 transition">RSVP</a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Latest Jobs -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 flex items-center justify-between border-b border-gray-100">
                <h2 class="font-bold text-gray-900 flex items-center gap-2">
                    <i class="fa fa-briefcase text-blue-500 text-sm"></i> Latest Job Postings
                </h2>
                <a href="<?= ALUMNI_BASE_URL ?>/jobs.php" class="text-xs text-indigo-600 hover:underline font-medium">View all</a>
            </div>
            <div class="divide-y divide-gray-50">
                <?php if (empty($latestJobs)): ?>
                <div class="px-6 py-10 text-center text-gray-400">
                    <i class="fa fa-briefcase text-3xl mb-2 block"></i>
                    <p class="text-sm">No job postings right now.</p>
                </div>
                <?php else: ?>
                <?php foreach ($latestJobs as $job): ?>
                <div class="px-6 py-4 flex items-center gap-4 hover:bg-gray-50 transition-colors">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                        <i class="fa fa-building text-blue-500 text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-medium text-gray-900 text-sm truncate">
                            <a href="<?= ALUMNI_BASE_URL ?>/jobs.php?id=<?= $job['id'] ?>" class="hover:text-blue-600"><?= e($job['title']) ?></a>
                        </h3>
                        <p class="text-xs text-gray-500"><?= e($job['company']) ?></p>
                    </div>
                    <div class="flex-shrink-0 text-right">
                        <span class="inline-block px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 text-xs">
                            <?= $job['is_remote'] ? 'Remote' : e((isset($job['location']) ? $job['location'] : 'Location TBA')) ?>
                        </span>
                        <p class="text-xs text-gray-400 mt-1"><?= date('M j', strtotime($job['created_at'])) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- News Feed -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 flex items-center justify-between border-b border-gray-100">
                <h2 class="font-bold text-gray-900 flex items-center gap-2">
                    <i class="fa fa-newspaper text-orange-500 text-sm"></i> News & Announcements
                </h2>
                <a href="<?= ALUMNI_BASE_URL ?>/news.php" class="text-xs text-indigo-600 hover:underline font-medium">View all</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-gray-100">
                <?php if (empty($recentNews)): ?>
                <div class="px-6 py-10 text-center text-gray-400 col-span-3">
                    <i class="fa fa-newspaper text-3xl mb-2 block"></i>
                    <p class="text-sm">No news articles yet.</p>
                </div>
                <?php else: ?>
                <?php foreach ($recentNews as $article): ?>
                <a href="<?= ALUMNI_BASE_URL ?>/news.php?id=<?= $article['id'] ?>"
                   class="block p-5 hover:bg-gray-50 transition-colors group">
                    <span class="text-xs font-medium text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full">
                        <?= e((isset($article['category']) ? $article['category'] : 'News')) ?>
                    </span>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-2">
                        <?= e($article['title']) ?>
                    </h3>
                    <p class="mt-1 text-xs text-gray-400"><?= date('M j, Y', strtotime($article['published_at'])) ?></p>
                </a>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div><!-- /left -->

    <!-- Right Column (1/3) -->
    <div class="space-y-6">

        <!-- Pending Connection Requests -->
        <?php if (!empty($pendingRequests)): ?>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                    <i class="fa fa-user-plus text-orange-500"></i>
                    Connection Requests
                    <span class="ml-1 inline-flex w-5 h-5 items-center justify-center rounded-full bg-orange-100 text-orange-700 text-xs font-bold">
                        <?= count($pendingRequests) ?>
                    </span>
                </h2>
                <a href="<?= ALUMNI_BASE_URL ?>/connections.php?tab=requests" class="text-xs text-indigo-600 hover:underline">See all</a>
            </div>
            <div class="divide-y divide-gray-50">
                <?php foreach ($pendingRequests as $req): ?>
                <div class="p-4" x-data="{ accepted: false, declined: false }">
                    <div class="flex items-center gap-3 mb-2">
                        <img src="<?= e(getAvatarUrl((isset($req['avatar']) ? $req['avatar'] : null), $req['email'], 40)) ?>"
                             class="w-9 h-9 rounded-full object-cover flex-shrink-0"
                             onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($req['first_name'].' '.$req['last_name']) ?>&background=6366f1&color=fff'">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate"><?= e($req['first_name'] . ' ' . $req['last_name']) ?></p>
                            <p class="text-xs text-gray-500 truncate"><?= e((isset($req['current_title']) ? $req['current_title'] : '')) ?><?= !empty($req['current_company']) ? ' · ' . e($req['current_company']) : '' ?></p>
                        </div>
                    </div>
                    <div class="flex gap-2" x-show="!accepted && !declined">
                        <button @click="fetch('<?= ALUMNI_BASE_URL ?>/api/connections.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({action:'accept',conn_id:<?= $req['conn_id'] ?>,csrf_token:'<?= generateCsrfToken() ?>'})}).then(()=>accepted=true)"
                                class="flex-1 py-1.5 bg-indigo-600 text-white rounded-lg text-xs font-medium hover:bg-indigo-700 transition">
                            Accept
                        </button>
                        <button @click="fetch('<?= ALUMNI_BASE_URL ?>/api/connections.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({action:'decline',conn_id:<?= $req['conn_id'] ?>,csrf_token:'<?= generateCsrfToken() ?>'})}).then(()=>declined=true)"
                                class="flex-1 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-xs font-medium hover:bg-gray-200 transition">
                            Decline
                        </button>
                    </div>
                    <p x-show="accepted" class="text-xs text-green-600 font-medium"><i class="fa fa-check mr-1"></i>Connected!</p>
                    <p x-show="declined" class="text-xs text-gray-400"><i class="fa fa-xmark mr-1"></i>Declined</p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- People You May Know -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                    <i class="fa fa-users text-green-500"></i> People You May Know
                </h2>
                <a href="<?= ALUMNI_BASE_URL ?>/directory.php" class="text-xs text-indigo-600 hover:underline">Browse</a>
            </div>
            <?php if (empty($suggestions)): ?>
            <div class="p-6 text-center text-gray-400 text-sm">
                <i class="fa fa-users text-2xl mb-2 block"></i>
                <p>No suggestions yet. <a href="<?= ALUMNI_BASE_URL ?>/directory.php" class="text-indigo-600 underline">Browse alumni</a></p>
            </div>
            <?php else: ?>
            <div class="divide-y divide-gray-50">
                <?php foreach ($suggestions as $s): ?>
                <div class="p-4 flex items-center gap-3" x-data="{ sent: false }">
                    <img src="<?= e(getAvatarUrl((isset($s['avatar']) ? $s['avatar'] : null), $s['email'], 40)) ?>"
                         class="w-9 h-9 rounded-full object-cover flex-shrink-0"
                         onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($s['first_name'].' '.$s['last_name']) ?>&background=22c55e&color=fff'">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            <a href="<?= ALUMNI_BASE_URL ?>/directory.php?id=<?= $s['id'] ?>"><?= e($s['first_name'] . ' ' . $s['last_name']) ?></a>
                        </p>
                        <p class="text-xs text-gray-500 truncate"><?= e((isset($s['current_title']) ? $s['current_title'] : '')) ?><?= !empty($s['country']) ? ', ' . e($s['country']) : '' ?></p>
                    </div>
                    <button x-show="!sent"
                            @click="fetch('<?= ALUMNI_BASE_URL ?>/api/connections.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({action:'request',receiver_id:<?= $s['id'] ?>,csrf_token:'<?= generateCsrfToken() ?>'})}).then(r=>r.ok&&(sent=true))"
                            class="flex-shrink-0 px-2.5 py-1 rounded-full border border-indigo-300 text-indigo-600 text-xs font-medium hover:bg-indigo-50 transition">
                        Connect
                    </button>
                    <span x-show="sent" class="flex-shrink-0 text-xs text-green-600 font-medium"><i class="fa fa-check mr-1"></i>Sent</span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Quick Actions -->
        <div class="bg-wam-navy rounded-2xl p-5" style="background:#1a3a5c;">
            <h2 class="font-bold text-white text-sm mb-4 flex items-center gap-2">
                <i class="fa fa-bolt text-wam-gold"></i> Quick Actions
            </h2>
            <div class="grid grid-cols-2 gap-2">
                <?php
                $actions = [
                    ['fa-user-pen',  'Edit Profile',      ALUMNI_BASE_URL . '/profile.php'],
                    ['fa-calendar',  'Browse Events',     ALUMNI_BASE_URL . '/events.php'],
                    ['fa-briefcase', 'Find Jobs',         ALUMNI_BASE_URL . '/jobs.php'],
                    ['fa-heart',     'Make a Donation',   ALUMNI_BASE_URL . '/donate.php'],
                    ['fa-users',     'Alumni Directory',  ALUMNI_BASE_URL . '/directory.php'],
                    ['fa-envelope',  'Messages',          ALUMNI_BASE_URL . '/messages.php'],
                ];
                foreach ($actions as $action):
                    $icon = $action[0];
                    $label = $action[1];
                    $link = $action[2];
                ?>
                <a href="<?= $link ?>"
                   class="flex items-center gap-2 p-2.5 rounded-xl bg-white/10 text-white text-xs font-medium hover:bg-white/20 transition group">
                    <i class="fa <?= $icon ?> text-wam-gold w-4 text-center"></i>
                    <span class="truncate"><?= $label ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

    </div><!-- /right -->
</div><!-- /grid -->

<?php include __DIR__ . '/includes/footer.php'; ?>
