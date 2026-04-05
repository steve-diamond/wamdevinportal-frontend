<?php
/**
 * WAMDEVIN Alumni Portal - Header Layout
 *
 * Tailwind CSS + Alpine.js responsive header with:
 * - Collapsible mobile nav
 * - Notification badge
 * - User dropdown
 * - Active page highlight
 *
 * Variables expected from consuming page:
 *   $pageTitle   - page title string
 *   $currentPage - slug matching nav items
 *   $authPayload - alumni JWT payload array
 *
 * @version 1.0.0
 */

// These should already be set by middleware.php
$_notifCount   = function_exists('getUnreadNotificationCount') ? getUnreadNotificationCount() : 0;
$_msgCount     = function_exists('getUnreadMessageCount')      ? getUnreadMessageCount()      : 0;
$_alumni       = function_exists('getCurrentAlumni')           ? getCurrentAlumni()           : null;
$_avatarUrl    = function_exists('getAvatarUrl') && $_alumni
                    ? getAvatarUrl((isset($_alumni['avatar']) ? $_alumni['avatar'] : null), (isset($_alumni['email']) ? $_alumni['email'] : ''), 40)
                    : '';
$_displayName  = isset($_alumni) ? e(((isset($_alumni['first_name']) ? $_alumni['first_name'] : '')) . ' ' . ((isset($_alumni['last_name']) ? $_alumni['last_name'] : ''))) : 'Alumni';
$_role         = (isset($authPayload['role']) ? $authPayload['role'] : 'alumni');

function navLinkClass( $page, $current)
{
    $base   = 'inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-colors';
    $active = 'bg-indigo-700 text-white';
    $idle   = 'text-indigo-100 hover:bg-indigo-700/60 hover:text-white';
    return $base . ' ' . ($page === $current ? $active : $idle);
}

$_navBase  = ALUMNI_BASE_URL;
$_pageTitle = isset($pageTitle) ? e($pageTitle) : 'WAMDEVIN Alumni Portal';
$_navCurrent = (isset($currentPage) ? $currentPage : '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="WAMDEVIN Alumni Portal - Connecting West African Management Leaders">
    <meta name="robots" content="noindex, nofollow">
    <title><?= $_pageTitle ?> | WAMDEVIN Alumni Portal</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand': {
                            50:  '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        },
                        'wam-navy': '#1a3a5c',
                        'wam-gold': '#d4a017',
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Favicon -->
    <link rel="icon" href="<?= rtrim(APP_URL, '/') ?>/assets/images/favicon.ico" type="image/x-icon">

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', system-ui, sans-serif; }
        .sidebar-transition { transition: transform 0.3s cubic-bezier(0.4,0,0.2,1); }
        .overlay { backdrop-filter: blur(2px); }
        .card-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 10px 25px -5px rgba(0,0,0,.1); }
        .notification-dot { animation: pulse 2s infinite; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.6} }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    </style>

    <?php if (isset($extraHead)) echo $extraHead; ?>
</head>
<body class="bg-gray-50 text-gray-900 antialiased" x-data="{ mobileOpen: false, notifOpen: false, userOpen: false }">

<!-- =====================================================================
     TOP NAVIGATION BAR
====================================================================== -->
<nav class="bg-wam-navy shadow-lg sticky top-0 z-50" style="background:#1a3a5c;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- Brand -->
            <div class="flex items-center gap-3">
                <!-- Mobile hamburger -->
                <button @click="mobileOpen = !mobileOpen"
                        class="md:hidden p-2 rounded-lg text-indigo-200 hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-white"
                        :aria-expanded="mobileOpen" aria-label="Toggle navigation">
                    <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileOpen" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <a href="<?= $_navBase ?>/index.php" class="flex items-center gap-2 text-white font-bold text-lg">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-black" style="background:#d4a017;">W</div>
                    <span class="hidden sm:block">WAMDEVIN <span class="font-light text-indigo-200">Alumni</span></span>
                </a>
            </div>

            <!-- Desktop Nav Links -->
            <div class="hidden md:flex items-center gap-1">
                <a href="<?= $_navBase ?>/index.php"
                   class="<?= navLinkClass('dashboard', $_navCurrent) ?>">
                    <i class="fa fa-home text-xs"></i> Dashboard
                </a>
                <a href="<?= $_navBase ?>/directory.php"
                   class="<?= navLinkClass('directory', $_navCurrent) ?>">
                    <i class="fa fa-users text-xs"></i> Directory
                </a>
                <a href="<?= $_navBase ?>/events.php"
                   class="<?= navLinkClass('events', $_navCurrent) ?>">
                    <i class="fa fa-calendar text-xs"></i> Events
                </a>
                <a href="<?= $_navBase ?>/attendance.php"
                   class="<?= navLinkClass('attendance', $_navCurrent) ?>">
                    <i class="fa fa-user-check text-xs"></i> Attendance
                </a>
                <a href="<?= $_navBase ?>/jobs.php"
                   class="<?= navLinkClass('jobs', $_navCurrent) ?>">
                    <i class="fa fa-briefcase text-xs"></i> Jobs
                </a>
                <a href="<?= $_navBase ?>/news.php"
                   class="<?= navLinkClass('news', $_navCurrent) ?>">
                    <i class="fa fa-newspaper text-xs"></i> News
                </a>
                <a href="<?= $_navBase ?>/donate.php"
                   class="<?= navLinkClass('donate', $_navCurrent) ?>">
                    <i class="fa fa-heart text-xs"></i> Give
                </a>
                <?php if (in_array($_role, ['admin', 'moderator'])): ?>
                <a href="<?= $_navBase ?>/admin/index.php"
                   class="<?= navLinkClass('admin', $_navCurrent) ?> border border-yellow-400/50">
                    <i class="fa fa-shield-halved text-xs"></i> Admin
                </a>
                <?php endif; ?>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-2">

                <!-- Messages -->
                <a href="<?= $_navBase ?>/messages.php"
                   class="relative p-2 rounded-lg text-indigo-200 hover:bg-indigo-800 hover:text-white transition-colors"
                   title="Messages">
                    <i class="fa fa-envelope text-base"></i>
                    <?php if ($_msgCount > 0): ?>
                    <span class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-white text-xs font-bold notification-dot">
                        <?= min($_msgCount, 9) ?>
                    </span>
                    <?php endif; ?>
                </a>

                <!-- Notifications -->
                <div class="relative" @click.away="notifOpen=false">
                    <button @click="notifOpen = !notifOpen"
                            class="relative p-2 rounded-lg text-indigo-200 hover:bg-indigo-800 hover:text-white transition-colors"
                            title="Notifications">
                        <i class="fa fa-bell text-base"></i>
                        <?php if ($_notifCount > 0): ?>
                        <span class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-yellow-400 text-gray-900 text-xs font-bold notification-dot">
                            <?= min($_notifCount, 9) ?>
                        </span>
                        <?php endif; ?>
                    </button>

                    <!-- Notification Dropdown -->
                    <div x-show="notifOpen" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden">
                        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="font-semibold text-gray-900 text-sm">Notifications</h3>
                            <a href="<?= $_navBase ?>/notifications.php" class="text-xs text-indigo-600 hover:underline">View all</a>
                        </div>
                        <div class="max-h-72 overflow-y-auto divide-y divide-gray-50" id="notif-list">
                            <div class="px-4 py-8 text-center text-gray-400 text-sm">
                                <i class="fa fa-bell-slash text-2xl mb-2 block"></i>
                                Loading notifications...
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="relative" @click.away="userOpen=false">
                    <button @click="userOpen = !userOpen"
                            class="flex items-center gap-2 p-1 pl-2 rounded-lg text-indigo-100 hover:bg-indigo-800 transition-colors"
                            :aria-expanded="userOpen">
                        <img src="<?= e($_avatarUrl) ?>" alt="<?= $_displayName ?>"
                             class="w-8 h-8 rounded-full object-cover border-2 border-indigo-400"
                             onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($_displayName) ?>&background=4f46e5&color=fff'">
                        <span class="hidden sm:block text-sm font-medium max-w-[100px] truncate"><?= $_displayName ?></span>
                        <i class="fa fa-chevron-down text-xs opacity-60"></i>
                    </button>

                    <!-- User Dropdown -->
                    <div x-show="userOpen" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden py-1">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="font-semibold text-gray-900 text-sm truncate"><?= $_displayName ?></p>
                            <p class="text-xs text-gray-500 capitalize"><?= e($_role) ?> Member</p>
                        </div>
                        <a href="<?= $_navBase ?>/profile.php"
                           class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fa fa-user w-4"></i> My Profile
                        </a>
                        <a href="<?= $_navBase ?>/profile.php?tab=settings"
                           class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fa fa-gear w-4"></i> Settings
                        </a>
                        <a href="<?= $_navBase ?>/connections.php"
                           class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <i class="fa fa-user-group w-4"></i> My Network
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <a href="<?= $_navBase ?>/logout.php"
                           class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                            <i class="fa fa-right-from-bracket w-4"></i> Sign Out
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Mobile Nav -->
        <div x-show="mobileOpen" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="md:hidden pb-3 pt-2 space-y-1">
            <a href="<?= $_navBase ?>/index.php"    class="block px-3 py-2 rounded-lg text-sm font-medium text-indigo-100 hover:bg-indigo-800"><i class="fa fa-home mr-2"></i>Dashboard</a>
            <a href="<?= $_navBase ?>/directory.php" class="block px-3 py-2 rounded-lg text-sm font-medium text-indigo-100 hover:bg-indigo-800"><i class="fa fa-users mr-2"></i>Directory</a>
            <a href="<?= $_navBase ?>/events.php"    class="block px-3 py-2 rounded-lg text-sm font-medium text-indigo-100 hover:bg-indigo-800"><i class="fa fa-calendar mr-2"></i>Events</a>
            <a href="<?= $_navBase ?>/attendance.php" class="block px-3 py-2 rounded-lg text-sm font-medium text-indigo-100 hover:bg-indigo-800"><i class="fa fa-user-check mr-2"></i>Attendance</a>
            <a href="<?= $_navBase ?>/jobs.php"      class="block px-3 py-2 rounded-lg text-sm font-medium text-indigo-100 hover:bg-indigo-800"><i class="fa fa-briefcase mr-2"></i>Jobs</a>
            <a href="<?= $_navBase ?>/news.php"      class="block px-3 py-2 rounded-lg text-sm font-medium text-indigo-100 hover:bg-indigo-800"><i class="fa fa-newspaper mr-2"></i>News</a>
            <a href="<?= $_navBase ?>/donate.php"    class="block px-3 py-2 rounded-lg text-sm font-medium text-indigo-100 hover:bg-indigo-800"><i class="fa fa-heart mr-2"></i>Give Back</a>
            <a href="<?= $_navBase ?>/messages.php"  class="block px-3 py-2 rounded-lg text-sm font-medium text-indigo-100 hover:bg-indigo-800"><i class="fa fa-envelope mr-2"></i>Messages <?= $_msgCount > 0 ? "<span class='ml-1 bg-red-500 text-white text-xs rounded-full px-1.5'>{$_msgCount}</span>" : '' ?></a>
            <a href="<?= $_navBase ?>/profile.php"   class="block px-3 py-2 rounded-lg text-sm font-medium text-indigo-100 hover:bg-indigo-800"><i class="fa fa-user mr-2"></i>My Profile</a>
            <?php if (in_array($_role, ['admin', 'moderator'])): ?>
            <a href="<?= $_navBase ?>/admin/index.php" class="block px-3 py-2 rounded-lg text-sm font-medium text-yellow-300 hover:bg-indigo-800"><i class="fa fa-shield-halved mr-2"></i>Admin Panel</a>
            <?php endif; ?>
            <a href="<?= $_navBase ?>/logout.php"    class="block px-3 py-2 rounded-lg text-sm font-medium text-red-300 hover:bg-red-900/30"><i class="fa fa-right-from-bracket mr-2"></i>Sign Out</a>
        </div>
    </div>
</nav>

<!-- Flash Message -->
<?php $flash = function_exists('getFlash') ? getFlash() : null; ?>
<?php if ($flash): ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4"
     x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="rounded-lg px-4 py-3 flex items-center gap-3 text-sm
        <?= $flash['type'] === 'success' ? 'bg-green-50 text-green-800 border border-green-200' : 
           ($flash['type'] === 'error'   ? 'bg-red-50 text-red-800 border border-red-200' : 
                                           'bg-blue-50 text-blue-800 border border-blue-200') ?>">
        <i class="fa <?= $flash['type'] === 'success' ? 'fa-check-circle' : ($flash['type'] === 'error' ? 'fa-circle-exclamation' : 'fa-info-circle') ?>"></i>
        <span><?= e($flash['message']) ?></span>
        <button @click="show = false" class="ml-auto opacity-60 hover:opacity-100"><i class="fa fa-xmark"></i></button>
    </div>
</div>
<?php endif; ?>

<!-- Main content wrapper starts here, closed in footer.php -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-screen">
