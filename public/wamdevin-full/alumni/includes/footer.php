<?php
/**
 * WAMDEVIN Alumni Portal - Footer Layout
 * Closes the main wrapper opened in header.php
 */
?>
</main><!-- /main content -->

<!-- =====================================================================
     FOOTER
====================================================================== -->
<footer class="bg-wam-navy text-indigo-200 mt-16" style="background:#1a3a5c;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">

            <!-- Brand -->
            <div class="md:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-lg" style="background:#d4a017;color:#1a3a5c;">W</div>
                    <div>
                        <span class="text-white font-bold text-lg block">WAMDEVIN Alumni</span>
                        <span class="text-indigo-300 text-xs">West African Management Development Network</span>
                    </div>
                </div>
                <p class="text-sm text-indigo-300 leading-relaxed max-w-xs">
                    Connecting over 10,000 management development leaders across West Africa and beyond.
                    Building futures through networking, knowledge, and giving back.
                </p>
                <div class="flex items-center gap-3 mt-4">
                    <a href="#" class="w-8 h-8 rounded-lg bg-indigo-800 flex items-center justify-center text-indigo-300 hover:bg-indigo-700 hover:text-white transition-colors">
                        <i class="fab fa-linkedin-in text-sm"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-indigo-800 flex items-center justify-center text-indigo-300 hover:bg-indigo-700 hover:text-white transition-colors">
                        <i class="fab fa-twitter text-sm"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-indigo-800 flex items-center justify-center text-indigo-300 hover:bg-indigo-700 hover:text-white transition-colors">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Portal</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?= ALUMNI_BASE_URL ?>/index.php"     class="hover:text-white transition-colors">Dashboard</a></li>
                    <li><a href="<?= ALUMNI_BASE_URL ?>/directory.php"  class="hover:text-white transition-colors">Alumni Directory</a></li>
                    <li><a href="<?= ALUMNI_BASE_URL ?>/events.php"     class="hover:text-white transition-colors">Events</a></li>
                    <li><a href="<?= ALUMNI_BASE_URL ?>/jobs.php"       class="hover:text-white transition-colors">Career Center</a></li>
                    <li><a href="<?= ALUMNI_BASE_URL ?>/news.php"       class="hover:text-white transition-colors">News & Announcements</a></li>
                    <li><a href="<?= ALUMNI_BASE_URL ?>/donate.php"     class="hover:text-white transition-colors">Give Back</a></li>
                </ul>
            </div>

            <!-- Account -->
            <div>
                <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Account</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?= ALUMNI_BASE_URL ?>/profile.php"            class="hover:text-white transition-colors">My Profile</a></li>
                    <li><a href="<?= ALUMNI_BASE_URL ?>/connections.php"        class="hover:text-white transition-colors">My Network</a></li>
                    <li><a href="<?= ALUMNI_BASE_URL ?>/messages.php"           class="hover:text-white transition-colors">Messages</a></li>
                    <li><a href="<?= ALUMNI_BASE_URL ?>/notifications.php"      class="hover:text-white transition-colors">Notifications</a></li>
                    <li><a href="<?= ALUMNI_BASE_URL ?>/profile.php?tab=settings" class="hover:text-white transition-colors">Settings</a></li>
                    <li><a href="<?= ALUMNI_BASE_URL ?>/logout.php"             class="hover:text-white transition-colors">Sign Out</a></li>
                </ul>
            </div>

        </div>

        <div class="border-t border-indigo-800 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-indigo-400">
            <p>&copy; <?= date('Y') ?> WAMDEVIN Alumni Portal. All rights reserved.</p>
            <div class="flex items-center gap-4">
                <a href="<?= rtrim(APP_URL,'/') ?>/about.php" class="hover:text-white transition-colors">About WAMDEVIN</a>
                <a href="<?= rtrim(APP_URL,'/') ?>/contact.php" class="hover:text-white transition-colors">Contact</a>
                <span class="text-indigo-600">v<?= ALUMNI_VERSION ?></span>
            </div>
        </div>
    </div>
</footer>

<!-- Notification loader script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const list = document.getElementById('notif-list');
    if (!list) return;
    fetch('<?= ALUMNI_BASE_URL ?>/api/notifications.php?limit=5')
        .then(r => r.ok ? r.json() : null)
        .then(data => {
            if (!data || !data.notifications || data.notifications.length === 0) {
                list.innerHTML = '<div class="px-4 py-8 text-center text-gray-400 text-sm"><i class="fa fa-bell-slash text-2xl mb-2 block"></i>No new notifications</div>';
                return;
            }
            list.innerHTML = data.notifications.map(n => `
                <a href="${n.action_url || '#'}" class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors ${n.is_read ? '' : 'bg-indigo-50/50'}">
                    <span class="w-2 h-2 rounded-full mt-2 flex-shrink-0 ${n.is_read ? 'bg-gray-300' : 'bg-indigo-500'}"></span>
                    <div>
                        <p class="text-sm font-medium text-gray-900">${n.title}</p>
                        <p class="text-xs text-gray-500 mt-0.5">${n.time_ago}</p>
                    </div>
                </a>
            `).join('');
        })
        .catch(() => {
            list.innerHTML = '<div class="px-4 py-8 text-center text-gray-400 text-sm">Could not load notifications</div>';
        });
});
</script>

<?php if (isset($extraScripts)) echo $extraScripts; ?>
</body>
</html>
