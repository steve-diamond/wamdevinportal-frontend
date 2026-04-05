<?php
/**
 * WAMDEVIN Alumni Portal - Public Landing Page
 *
 * Shown to non-logged-in visitors. Showcases the portal:
 * featured stats, news preview, events preview, and a CTA.
 *
 * @version 1.0.0
 */
require_once __DIR__ . '/includes/config.php';
// Don't force auth – this is the public entry point
// But redirect if already logged in
if (getAuthPayload()) {
    redirect(ALUMNI_BASE_URL . '/index.php');
}

$pdo = getAlumniDB();

// Fetch public stats from DB, fall back to zeros
try {
    $alumniCount   = (int)$pdo->query("SELECT COUNT(*) FROM alumni WHERE status='active'")->fetchColumn();
    $eventsCount   = (int)$pdo->query("SELECT COUNT(*) FROM alumni_events WHERE status='published'")->fetchColumn();
    $jobsCount     = (int)$pdo->query("SELECT COUNT(*) FROM alumni_jobs WHERE status='published'")->fetchColumn();
    $donationsTotal= (float)$pdo->query("SELECT COALESCE(SUM(amount),0) FROM alumni_donations WHERE payment_status='completed'")->fetchColumn();

    // Latest 3 published news
    $latestNews = $pdo->query("
        SELECT title, slug, excerpt, image, category, published_at
          FROM alumni_news WHERE status='published'
         ORDER BY published_at DESC LIMIT 3
    ")->fetchAll();

    // Upcoming 3 events
    $upcomingEvents = $pdo->query("
        SELECT id, title, event_type, location, is_virtual, start_datetime, image
          FROM alumni_events WHERE status='published' AND start_datetime > NOW()
         ORDER BY start_datetime ASC LIMIT 3
    ")->fetchAll();
} catch (PDOException $e) {
    $alumniCount = 0; $eventsCount = 0; $jobsCount = 0; $donationsTotal = 0;
    $latestNews = []; $upcomingEvents = [];
}

$flashMsg = '';
if (isset($_GET['msg'])) {
    $messages = [
        'verified'        => 'Your email has been verified. Welcome to WAMDEVIN Alumni!',
        'account_inactive'=> 'Your account is inactive. Please contact support.',
        'logged_out'      => 'You have been logged out successfully.',
    ];
    $flashMsg = isset($messages[$_GET['msg']]) ? $messages[$_GET['msg']] : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="WAMDEVIN Alumni Portal – Connecting West African Management Leaders. Network, find jobs, attend events, and give back.">
    <title>WAMDEVIN Alumni Portal — Connecting West African Leaders</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'wam-navy': '#1a3a5c',
                        'wam-gold': '#d4a017',
                    },
                    fontFamily: { sans: ['Inter','system-ui','sans-serif'] },
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome + Google Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-white">

<!-- =========================================================
     NAV
========================================================= -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-sm border-b border-gray-100" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="<?= ALUMNI_BASE_URL ?>/landing.php" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center font-black text-base shadow-sm group-hover:scale-105 transition-transform" style="background:#d4a017;color:#1a3a5c;">W</div>
                <div class="hidden sm:block">
                    <span class="text-wam-navy font-bold text-base leading-tight block">WAMDEVIN Alumni</span>
                    <span class="text-gray-500 text-xs">West Africa Management Network</span>
                </div>
            </a>

            <!-- Desktop links -->
            <div class="hidden md:flex items-center gap-6">
                <a href="#about"  class="text-sm text-gray-600 hover:text-wam-navy transition-colors">About</a>
                <a href="#events" class="text-sm text-gray-600 hover:text-wam-navy transition-colors">Events</a>
                <a href="#news"   class="text-sm text-gray-600 hover:text-wam-navy transition-colors">News</a>
                <a href="<?= ALUMNI_BASE_URL ?>/login.php"
                   class="text-sm font-medium text-wam-navy border border-wam-navy rounded-lg px-4 py-2 hover:bg-wam-navy hover:text-white transition-all">
                    Sign In
                </a>
                <a href="<?= ALUMNI_BASE_URL ?>/register.php"
                   class="text-sm font-semibold text-white rounded-lg px-4 py-2 shadow-sm hover:opacity-90 transition-opacity" style="background:#1a3a5c;">
                    Join Now
                </a>
            </div>

            <!-- Mobile toggle -->
            <button @click="open = !open" class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                <i :class="open ? 'fa-times' : 'fa-bars'" class="fas text-lg"></i>
            </button>
        </div>

        <!-- Mobile menu -->
        <div x-show="open" x-transition class="md:hidden pb-4 space-y-2">
            <a href="#about"  class="block px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-50">About</a>
            <a href="#events" class="block px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Events</a>
            <a href="#news"   class="block px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-50">News</a>
            <hr>
            <a href="<?= ALUMNI_BASE_URL ?>/login.php"    class="block px-3 py-2 text-sm font-medium text-wam-navy">Sign In</a>
            <a href="<?= ALUMNI_BASE_URL ?>/register.php" class="block px-3 py-2 text-sm font-semibold text-white rounded-lg text-center" style="background:#1a3a5c;">Join Now</a>
        </div>
    </div>
</nav>

<!-- =========================================================
     HERO
========================================================= -->
<section class="pt-16 min-h-screen flex flex-col justify-center relative overflow-hidden" style="background: linear-gradient(135deg, #1a3a5c 0%, #1e4d78 40%, #0f2940 100%);">
    <!-- Background decoration -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full opacity-10" style="background:#d4a017;"></div>
        <div class="absolute -bottom-32 -left-32 w-80 h-80 rounded-full opacity-5" style="background:#d4a017;"></div>
    </div>

    <?php if ($flashMsg): ?>
    <div class="fixed top-20 left-1/2 -translate-x-1/2 z-50 bg-green-500 text-white px-6 py-3 rounded-2xl shadow-lg text-sm font-medium">
        <i class="fas fa-check-circle mr-2"></i><?= e($flashMsg) ?>
    </div>
    <?php endif; ?>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-2 text-sm text-white/80 mb-8">
            <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
            Portal Now Live — Join <?= number_format($alumniCount) ?>+ Alumni
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold text-white leading-tight mb-6">
            Where West Africa's<br>
            <span style="color:#d4a017;">Management Leaders</span><br>
            Connect &amp; Grow
        </h1>

        <p class="text-lg sm:text-xl text-white/70 max-w-2xl mx-auto mb-10 leading-relaxed">
            The exclusive WAMDEVIN Alumni Portal — your gateway to a powerful network,
            career opportunities, world-class events, and making a lasting impact across West Africa.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?= ALUMNI_BASE_URL ?>/register.php"
               class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl text-base font-bold shadow-xl hover:opacity-90 transition-all"
               style="background:#d4a017;color:#1a3a5c;">
                <i class="fas fa-user-plus"></i> Join the Network
            </a>
            <a href="<?= ALUMNI_BASE_URL ?>/login.php"
               class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl text-base font-semibold border-2 border-white/30 text-white hover:bg-white/10 transition-all">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </a>
        </div>

        <!-- Stats -->
        <div class="mt-16 grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-3xl mx-auto">
            <?php
            $heroStats = [
                ['value' => number_format($alumniCount ?: 10000) . '+', 'label' => 'Alumni Members'],
                ['value' => number_format($eventsCount ?: 120) . '+', 'label' => 'Events Hosted'],
                ['value' => number_format($jobsCount ?: 500) . '+', 'label' => 'Jobs Posted'],
                ['value' => '$' . number_format($donationsTotal ?: 250000), 'label' => 'Raised for Scholarships'],
            ];
            foreach ($heroStats as $hs):
            ?>
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/10">
                <p class="text-2xl sm:text-3xl font-extrabold text-white"><?= $hs['value'] ?></p>
                <p class="text-xs text-white/60 mt-1"><?= $hs['label'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- =========================================================
     FEATURES
========================================================= -->
<section id="about" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">Everything You Need in One Portal</h2>
            <p class="text-gray-500 mt-4 max-w-xl mx-auto">A powerful, secure platform built exclusively for the WAMDEVIN alumni community.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $features = [
                ['icon'=>'fa-users', 'color'=>'#6366f1', 'title'=>'Alumni Directory', 'desc'=>'Find and connect with over 10,000 alumni across West Africa and beyond. Filter by industry, country, or graduation year.'],
                ['icon'=>'fa-briefcase', 'color'=>'#059669', 'title'=>'Career Center', 'desc'=>'Access exclusive job postings from top employers, post opportunities, and advance your career with the WAMDEVIN network.'],
                ['icon'=>'fa-calendar-alt', 'color'=>'#d97706', 'title'=>'Events & Reunions', 'desc'=>'Register for reunions, workshops, webinars, and networking events. Stay connected with the WAMDEVIN community.'],
                ['icon'=>'fa-newspaper', 'color'=>'#dc2626', 'title'=>'News & Insights', 'desc'=>'Stay up to date with alumni achievements, institutional announcements, and management development insights.'],
                ['icon'=>'fa-comments', 'color'=>'#7c3aed', 'title'=>'Secure Messaging', 'desc'=>'Send private messages to connected alumni. Build relationships and collaborate on opportunities seamlessly.'],
                ['icon'=>'fa-heart', 'color'=>'#db2777', 'title'=>'Give Back', 'desc'=>'Make a meaningful contribution through scholarships, campus development, or research initiatives. Every gift matters.'],
            ];
            foreach ($features as $f):
            ?>
            <div class="bg-white rounded-2xl border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background:<?= $f['color'] ?>18;">
                    <i class="fas <?= $f['icon'] ?> text-xl" style="color:<?= $f['color'] ?>;"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2"><?= $f['title'] ?></h3>
                <p class="text-sm text-gray-500 leading-relaxed"><?= $f['desc'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- =========================================================
     UPCOMING EVENTS
========================================================= -->
<?php if ($upcomingEvents): ?>
<section id="events" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">Upcoming Events</h2>
                <p class="text-gray-500 mt-2">Join fellow alumni at these exclusive events.</p>
            </div>
            <a href="<?= ALUMNI_BASE_URL ?>/login.php" class="text-sm text-indigo-600 hover:underline font-medium hidden md:block">View all →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php foreach ($upcomingEvents as $ev):
                $dt = new DateTime($ev['start_datetime']);
            ?>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                <div class="h-36 flex items-center justify-center text-4xl" style="background:linear-gradient(135deg,#1a3a5c,#1e4d78);">
                    <i class="fas fa-calendar-star text-white/30 text-5xl"></i>
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                            <?= ucfirst(str_replace('-',' ',$ev['event_type'])) ?>
                        </span>
                        <?php if ($ev['is_virtual']): ?>
                        <span class="px-2.5 py-1 rounded-full text-xs bg-green-50 text-green-700">Online</span>
                        <?php endif; ?>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2 line-clamp-2"><?= e($ev['title']) ?></h3>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i class="fas fa-calendar"></i>
                        <span><?= $dt->format('F j, Y') ?></span>
                    </div>
                    <?php if ($ev['location']): ?>
                    <div class="flex items-center gap-2 text-xs text-gray-500 mt-1">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?= e($ev['location']) ?></span>
                    </div>
                    <?php endif; ?>
                    <a href="<?= ALUMNI_BASE_URL ?>/login.php"
                       class="mt-4 block w-full text-center text-sm font-semibold text-white py-2.5 rounded-xl hover:opacity-90 transition-opacity"
                       style="background:#1a3a5c;">
                        Register →
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- =========================================================
     LATEST NEWS
========================================================= -->
<?php if ($latestNews): ?>
<section id="news" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">Alumni News</h2>
                <p class="text-gray-500 mt-2">Stay informed with the latest from WAMDEVIN.</p>
            </div>
            <a href="<?= ALUMNI_BASE_URL ?>/login.php" class="text-sm text-indigo-600 hover:underline font-medium hidden md:block">All news →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php foreach ($latestNews as $n): ?>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                <div class="h-40 flex items-center justify-center" style="background:linear-gradient(135deg,#f0f4ff,#e0e7ff);">
                    <i class="fas fa-newspaper text-5xl text-indigo-200"></i>
                </div>
                <div class="p-5">
                    <?php if ($n['category']): ?>
                    <span class="inline-flex px-2 py-1 rounded text-xs font-medium bg-indigo-50 text-indigo-700 mb-3"><?= e($n['category']) ?></span>
                    <?php endif; ?>
                    <h3 class="font-bold text-gray-900 mb-2 line-clamp-2"><?= e($n['title']) ?></h3>
                    <p class="text-sm text-gray-500 line-clamp-3"><?= e((isset($n['excerpt']) ? $n['excerpt'] : '')) ?></p>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-xs text-gray-400"><?= $n['published_at'] ? date('M j, Y', strtotime($n['published_at'])) : '' ?></span>
                        <a href="<?= ALUMNI_BASE_URL ?>/login.php" class="text-xs font-medium text-indigo-600 hover:underline">Read more →</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- =========================================================
     CTA
========================================================= -->
<section class="py-24" style="background:linear-gradient(135deg,#1a3a5c,#0f2940);">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 font-black text-2xl shadow-xl" style="background:#d4a017;color:#1a3a5c;">W</div>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">Ready to Reconnect?</h2>
        <p class="text-white/70 text-lg mb-10 max-w-xl mx-auto">
            Join thousands of WAMDEVIN alumni who are already networking, growing their careers,
            and giving back to the community.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?= ALUMNI_BASE_URL ?>/register.php"
               class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl font-bold text-base shadow-xl hover:opacity-90 transition-opacity"
               style="background:#d4a017;color:#1a3a5c;">
                <i class="fas fa-user-plus"></i> Create Free Account
            </a>
            <a href="<?= ALUMNI_BASE_URL ?>/login.php"
               class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl font-semibold text-white border-2 border-white/30 hover:bg-white/10 transition-all">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </a>
        </div>
    </div>
</section>

<!-- =========================================================
     FOOTER
========================================================= -->
<footer class="py-8 border-t border-gray-100 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-7 h-7 rounded-lg flex items-center justify-center font-black text-xs" style="background:#d4a017;color:#1a3a5c;">W</div>
            <span class="text-sm text-gray-500">© <?= date('Y') ?> WAMDEVIN Alumni Portal. All rights reserved.</span>
        </div>
        <div class="flex items-center gap-6 text-sm text-gray-400">
            <a href="<?= rtrim(APP_URL, '/') ?>" class="hover:text-gray-600">Main Site</a>
            <a href="<?= ALUMNI_BASE_URL ?>/login.php" class="hover:text-gray-600">Sign In</a>
            <a href="<?= ALUMNI_BASE_URL ?>/register.php" class="hover:text-gray-600">Register</a>
        </div>
    </div>
</footer>

</body>
</html>
