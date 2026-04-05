<?php
/**
 * WAMDEVIN Alumni Portal - Login Page
 *
 * POST: email, password, remember, csrf_token
 * Issues JWT tokens via cookies on success.
 *
 * @version 1.0.0
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/middleware.php';

redirectIfLoggedIn();

$error   = '';
$success = '';

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CSRF
    if (!verifyCsrfToken((isset($_POST['csrf_token']) ? $_POST['csrf_token'] : ''))) {
        $error = 'Invalid request. Please try again.';
    } elseif (!checkRateLimit('login_' . ((isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '')))) {
        $error = 'Too many login attempts. Please wait 15 minutes and try again.';
    } else {
        $email    = strtolower(trim((isset($_POST['email']) ? $_POST['email'] : '')));
        $password = (isset($_POST['password']) ? $_POST['password'] : '');

        // Basic validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } elseif (strlen($password) < 1) {
            $error = 'Password is required.';
        } else {
            try {
                $pdo  = getAlumniDB();
                $stmt = $pdo->prepare(
                    "SELECT id, first_name, last_name, email, password_hash, role, status,
                            email_verified, login_attempts, locked_until, avatar
                       FROM alumni
                      WHERE email = ? AND deleted_at IS NULL
                      LIMIT 1"
                );
                $stmt->execute([$email]);
                $alumni = $stmt->fetch();

                if (!$alumni) {
                    // Timing-safe: run a dummy verification
                    password_verify($password, '$2y$12$invalid_hash_for_timing_safety');
                    $error = 'Invalid email or password.';
                } elseif ($alumni['status'] === 'banned') {
                    $error = 'Your account has been permanently suspended.';
                } elseif ($alumni['status'] === 'suspended') {
                    $error = 'Your account is currently suspended. Please contact support.';
                } elseif ($alumni['locked_until'] && strtotime($alumni['locked_until']) > time()) {
                    $minutes = ceil((strtotime($alumni['locked_until']) - time()) / 60);
                    $error   = "Account locked. Try again in {$minutes} minute(s).";
                } elseif (!password_verify($password, $alumni['password_hash'])) {
                    // Increment attempts
                    $attempts = (int)$alumni['login_attempts'] + 1;
                    $lockSql  = '';
                    if ($attempts >= 10) {
                        $lockSql = ", locked_until = DATE_ADD(NOW(), INTERVAL 30 MINUTE)";
                    }
                    $pdo->prepare("UPDATE alumni SET login_attempts = ?{$lockSql} WHERE id = ?")
                        ->execute([$attempts, $alumni['id']]);
                    $error = 'Invalid email or password.';
                } elseif (!$alumni['email_verified']) {
                    $error = 'Please verify your email before logging in. <a href="' . ALUMNI_BASE_URL . '/resend-verification.php?email=' . urlencode($email) . '" class="underline font-medium">Resend verification email</a>';
                } elseif ($alumni['status'] === 'pending') {
                    $error = 'Your account is pending approval. You will be notified once approved.';
                } else {
                    // SUCCESS – issue JWT
                    $jwtPayload = [
                        'sub'   => $alumni['id'],
                        'email' => $alumni['email'],
                        'role'  => $alumni['role'],
                        'name'  => $alumni['first_name'] . ' ' . $alumni['last_name'],
                    ];

                    $tokens = getJWT()->issueTokens($jwtPayload);
                    getJWT()->setCookies($tokens);

                    // Reset login attempts, update last_login
                    $pdo->prepare("UPDATE alumni SET login_attempts=0, locked_until=NULL, last_login=NOW(), last_login_ip=? WHERE id=?")
                        ->execute([(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null), $alumni['id']]);

                    // Activity log
                    $pdo->prepare("INSERT INTO activity_logs (action, user_type, user_id, ip_address, user_agent) VALUES (?,?,?,?,?)")
                        ->execute(['alumni_login', 'member', $alumni['id'],
                                   (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null),
                                   (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null)]);

                    $redirect = (isset($_GET['redirect']) ? $_GET['redirect'] : (ALUMNI_BASE_URL . '/index.php'));
                    // Prevent open redirect
                    if (!str_starts_with($redirect, '/' ) && !str_starts_with($redirect, ALUMNI_BASE_URL)) {
                        $redirect = ALUMNI_BASE_URL . '/index.php';
                    }

                    setFlash('success', 'Welcome back, ' . $alumni['first_name'] . '!');
                    redirect($redirect);
                }
            } catch (PDOException $e) {
                error_log('Alumni login error: ' . $e->getMessage());
                $error = 'A server error occurred. Please try again.';
            }
        }
    }
}

$csrfToken = generateCsrfToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | WAMDEVIN Alumni Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { 'wam-navy': '#1a3a5c', 'wam-gold': '#d4a017' } } } }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-pattern { background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
    </style>
</head>
<body class="min-h-screen flex" x-data="{ showPass: false }">

<!-- Left Panel -->
<div class="hidden lg:flex lg:w-1/2 bg-wam-navy flex-col justify-between p-12 relative bg-pattern">
    <div>
        <div class="flex items-center gap-3 mb-12">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center font-black text-2xl text-wam-navy" style="background:#d4a017;">W</div>
            <div>
                <span class="text-white font-bold text-xl block">WAMDEVIN Alumni</span>
                <span class="text-indigo-300 text-sm">Management Excellence Network</span>
            </div>
        </div>
        <h1 class="text-4xl font-bold text-white leading-tight mb-4">
            Connect, Grow &<br>Give Back
        </h1>
        <p class="text-indigo-300 text-lg leading-relaxed">
            Join over 10,000 alumni across West Africa and beyond.
            Access exclusive events, career opportunities, and a powerful professional network.
        </p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white/10 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-wam-gold">10K+</div>
            <div class="text-indigo-300 text-xs mt-1">Alumni</div>
        </div>
        <div class="bg-white/10 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-wam-gold">25+</div>
            <div class="text-indigo-300 text-xs mt-1">Countries</div>
        </div>
        <div class="bg-white/10 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-wam-gold">500+</div>
            <div class="text-indigo-300 text-xs mt-1">Jobs Posted</div>
        </div>
    </div>

    <!-- Testimonial -->
    <div class="bg-white/10 rounded-xl p-5 mt-6">
        <p class="text-indigo-200 text-sm italic leading-relaxed">
            "The WAMDEVIN Alumni Network opened doors I never thought possible. 
            The connections I've made here have transformed my career."
        </p>
        <div class="flex items-center gap-3 mt-3">
            <div class="w-8 h-8 rounded-full bg-wam-gold flex items-center justify-center text-xs font-bold text-wam-navy">AK</div>
            <div>
                <p class="text-white text-xs font-medium">Adaeze Kemi</p>
                <p class="text-indigo-400 text-xs">Class of 2019, Lagos</p>
            </div>
        </div>
    </div>
</div>

<!-- Right Panel – Login Form -->
<div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 bg-gray-50">
    <div class="w-full max-w-md">

        <!-- Mobile logo -->
        <div class="flex lg:hidden items-center gap-3 mb-8 justify-center">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-lg text-wam-navy" style="background:#d4a017;">W</div>
            <span class="text-wam-navy font-bold text-xl">WAMDEVIN Alumni</span>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-1">Welcome back</h2>
            <p class="text-gray-500 text-sm mb-6">Sign in to your alumni account</p>

            <?php if ($error): ?>
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm flex items-start gap-2">
                <i class="fa fa-circle-exclamation mt-0.5 flex-shrink-0"></i>
                <span><?= $error ?></span>
            </div>
            <?php endif; ?>

            <form method="POST" action="" novalidate>
                <?= csrfField() ?>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                    <div class="relative">
                        <i class="fa fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="email" id="email" name="email"
                               value="<?= e((isset($_POST['email']) ? $_POST['email'] : '')) ?>"
                               placeholder="your@email.com"
                               autocomplete="email"
                               required
                               class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-wam-navy/30 focus:border-wam-navy transition">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <i class="fa fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input :type="showPass ? 'text' : 'password'"
                               id="password" name="password"
                               placeholder="••••••••"
                               autocomplete="current-password"
                               required
                               class="w-full pl-9 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-wam-navy/30 focus:border-wam-navy transition">
                        <button type="button" @click="showPass = !showPass"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i :class="showPass ? 'fa fa-eye-slash' : 'fa fa-eye'" class="text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Row: Remember + Forgot -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" value="1"
                               class="w-4 h-4 rounded border-gray-300 text-wam-navy focus:ring-wam-navy/30">
                        <span class="text-sm text-gray-600">Remember me</span>
                    </label>
                    <a href="<?= ALUMNI_BASE_URL ?>/forgot-password.php"
                       class="text-sm font-medium text-wam-navy hover:underline">Forgot password?</a>
                </div>

                <!-- Submit -->
                <button type="submit"
                        class="w-full py-2.5 px-4 bg-wam-navy text-white rounded-lg text-sm font-semibold hover:opacity-90 transition focus:outline-none focus:ring-2 focus:ring-wam-navy/50 active:scale-[.98]">
                    Sign In <i class="fa fa-arrow-right ml-1 text-xs"></i>
                </button>
            </form>

            <!-- Divider -->
            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 border-t border-gray-200"></div>
                <span class="text-xs text-gray-400">OR</span>
                <div class="flex-1 border-t border-gray-200"></div>
            </div>

            <!-- Register Link -->
            <p class="text-center text-sm text-gray-600">
                Don't have an account?
                <a href="<?= ALUMNI_BASE_URL ?>/register.php"
                   class="font-semibold text-wam-navy hover:underline">Create Account</a>
            </p>
        </div>

        <!-- Back to main site -->
        <p class="text-center mt-6 text-xs text-gray-400">
            <a href="<?= rtrim(APP_URL,'/') ?>/index.php" class="hover:text-gray-600 transition-colors">
                <i class="fa fa-arrow-left mr-1"></i> Back to WAMDEVIN.org
            </a>
        </p>
    </div>
</div>

</body>
</html>
