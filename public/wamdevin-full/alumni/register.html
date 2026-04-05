<?php
/**
 * WAMDEVIN Alumni Portal - Registration Page
 *
 * POST: first_name, last_name, email, password, confirm_password,
 *       graduation_year, degree, country, csrf_token
 *
 * Creates alumni record (status=pending until email verified).
 *
 * @version 1.0.0
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/middleware.php';

redirectIfLoggedIn();

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!verifyCsrfToken((isset($_POST['csrf_token']) ? $_POST['csrf_token'] : ''))) {
        $error = 'Invalid request. Please refresh and try again.';
    } elseif (!checkRateLimit('register_' . ((isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '')))) {
        $error = 'Too many registration attempts. Please wait 15 minutes.';
    } else {
        // Collect & sanitize
        $firstName       = trim((isset($_POST['first_name']) ? $_POST['first_name'] : ''));
        $lastName        = trim((isset($_POST['last_name']) ? $_POST['last_name'] : ''));
        $email           = strtolower(trim((isset($_POST['email']) ? $_POST['email'] : '')));
        $password        = (isset($_POST['password']) ? $_POST['password'] : '');
        $confirmPassword = (isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '');
        $gradYear        = (int)((isset($_POST['graduation_year']) ? $_POST['graduation_year'] : 0));
        $degree          = trim((isset($_POST['degree']) ? $_POST['degree'] : ''));
        $country         = trim((isset($_POST['country']) ? $_POST['country'] : ''));
        $termsAccepted   = !empty($_POST['terms']);

        // Validation
        $errors = [];
        if (strlen($firstName) < 2)    $errors[] = 'First name must be at least 2 characters.';
        if (strlen($lastName)  < 2)    $errors[] = 'Last name must be at least 2 characters.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';
        if (strlen($password) < 8)     $errors[] = 'Password must be at least 8 characters.';
        if (!preg_match('/[A-Z]/', $password)) $errors[] = 'Password must contain at least one uppercase letter.';
        if (!preg_match('/[0-9]/', $password)) $errors[] = 'Password must contain at least one number.';
        if ($password !== $confirmPassword) $errors[] = 'Passwords do not match.';
        if (!$termsAccepted) $errors[] = 'You must accept the Terms & Conditions.';
        if ($gradYear && ($gradYear < 1960 || $gradYear > (int)date('Y') + 1)) $errors[] = 'Enter a valid graduation year.';

        if ($errors) {
            $error = implode('<br>', $errors);
        } else {
            try {
                $pdo = getAlumniDB();

                // Check duplicate email
                $stmt = $pdo->prepare("SELECT id FROM alumni WHERE email = ?");
                $stmt->execute([$email]);
                if ($stmt->fetch()) {
                    $error = 'An account with that email already exists. <a href="' . ALUMNI_BASE_URL . '/login.php" class="underline font-medium">Sign in instead</a>';
                } else {
                    $passwordHash       = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                    $verificationToken  = bin2hex(random_bytes(32));
                    $verificationExpiry = date('Y-m-d H:i:s', time() + EMAIL_VERIFICATION_TIMEOUT);

                    $pdo->beginTransaction();

                    // Insert alumni
                    $stmt = $pdo->prepare("
                        INSERT INTO alumni
                            (first_name, last_name, email, password_hash, status, email_verified,
                             verification_token, verification_expires)
                        VALUES (?, ?, ?, ?, 'pending', 0, ?, ?)
                    ");
                    $stmt->execute([
                        $firstName, $lastName, $email, $passwordHash,
                        $verificationToken, $verificationExpiry
                    ]);
                    $alumniId = (int)$pdo->lastInsertId();

                    // Insert blank profile
                    $stmt = $pdo->prepare("
                        INSERT INTO alumni_profiles (alumni_id, graduation_year, degree, country)
                        VALUES (?, ?, ?, ?)
                    ");
                    $stmt->execute([
                        $alumniId,
                        $gradYear ?: null,
                        $degree   ?: null,
                        $country  ?: null
                    ]);

                    // Queue verification email
                    $verifyLink = ALUMNI_BASE_URL . '/verify-email.php?token=' . $verificationToken;
                    $emailBody  = "
                        <div style='font-family:Inter,sans-serif;max-width:520px;margin:auto;'>
                            <div style='background:#1a3a5c;padding:24px;border-radius:12px 12px 0 0;text-align:center;'>
                                <h1 style='color:#fff;font-size:22px;'>Welcome to WAMDEVIN Alumni!</h1>
                            </div>
                            <div style='background:#fff;padding:32px;border-radius:0 0 12px 12px;border:1px solid #e5e7eb;'>
                                <p style='color:#374151;'>Hi {$firstName},</p>
                                <p style='color:#374151;'>Thank you for joining the WAMDEVIN Alumni Network. Please verify your email to activate your account.</p>
                                <div style='text-align:center;margin:28px 0;'>
                                    <a href='{$verifyLink}' style='background:#1a3a5c;color:#fff;padding:12px 28px;border-radius:8px;text-decoration:none;font-weight:600;'>Verify Email Address</a>
                                </div>
                                <p style='color:#6b7280;font-size:13px;'>This link expires in 24 hours. If you did not register, please ignore this email.</p>
                            </div>
                        </div>
                    ";

                    $pdo->prepare("
                        INSERT INTO email_queue (to_email, to_name, subject, body, email_type)
                        VALUES (?, ?, ?, ?, 'verification')
                    ")->execute([$email, $firstName . ' ' . $lastName, 'Verify Your WAMDEVIN Alumni Account', $emailBody]);

                    $pdo->commit();

                    $success = true;
                }
            } catch (PDOException $e) {
                if ($pdo->inTransaction()) $pdo->rollback();
                error_log('Alumni register error: ' . $e->getMessage());
                $error = 'A server error occurred. Please try again.';
            }
        }
    }
}

$csrfToken = generateCsrfToken();
$currentYear = (int)date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | WAMDEVIN Alumni Portal</title>
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
<body class="min-h-screen flex bg-gray-50" x-data="{ showPass: false, showConfirm: false, passwordStrength: 0 }">

<!-- Left Panel -->
<div class="hidden lg:flex lg:w-5/12 bg-wam-navy flex-col justify-between p-12 relative bg-pattern sticky top-0 h-screen">
    <div>
        <div class="flex items-center gap-3 mb-10">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center font-black text-2xl text-wam-navy" style="background:#d4a017;">W</div>
            <div>
                <span class="text-white font-bold text-xl block">WAMDEVIN Alumni</span>
                <span class="text-indigo-300 text-sm">Management Excellence Network</span>
            </div>
        </div>
        <h1 class="text-3xl font-bold text-white leading-tight mb-4">Join Our Global Alumni Community</h1>
        <p class="text-indigo-300 leading-relaxed">
            Register to access exclusive networking opportunities, career resources, events, and more.
        </p>

        <ul class="mt-8 space-y-3">
            <?php foreach ([
                'fa-users'    => 'Connect with 10,000+ alumni worldwide',
                'fa-briefcase'=> 'Access exclusive job postings',
                'fa-calendar' => 'RSVP to alumni events & reunions',
                'fa-newspaper'=> 'Stay updated with WAMDEVIN news',
                'fa-heart'    => 'Give back through the scholarship fund',
            ] as $icon => $text): ?>
            <li class="flex items-center gap-3 text-indigo-200 text-sm">
                <span class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                    <i class="fa <?= $icon ?> text-wam-gold text-xs"></i>
                </span>
                <?= $text ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <p class="text-indigo-400 text-xs">
        Already have an account? <a href="<?= ALUMNI_BASE_URL ?>/login.php" class="text-white underline">Sign in</a>
    </p>
</div>

<!-- Right Panel -->
<div class="w-full lg:w-7/12 flex items-start justify-center p-6 sm:p-10 overflow-y-auto">
    <div class="w-full max-w-lg">

        <!-- Mobile logo -->
        <div class="flex lg:hidden items-center gap-3 mb-6 justify-center">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-lg text-wam-navy" style="background:#d4a017;">W</div>
            <span class="text-wam-navy font-bold text-xl">WAMDEVIN Alumni</span>
        </div>

        <?php if ($success): ?>
        <div class="bg-white rounded-2xl shadow-xl p-10 text-center">
            <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                <i class="fa fa-envelope-circle-check text-green-600 text-3xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Check Your Email!</h2>
            <p class="text-gray-500 text-sm leading-relaxed">
                We've sent a verification link to <strong><?= e($email) ?></strong>.
                Please verify your email to activate your WAMDEVIN Alumni account.
            </p>
            <p class="text-gray-400 text-xs mt-4">Didn't receive it? Check your spam folder or <a href="<?= ALUMNI_BASE_URL ?>/resend-verification.php?email=<?= urlencode((isset($email) ? $email : '')) ?>" class="text-wam-navy underline">resend the email</a>.</p>
            <a href="<?= ALUMNI_BASE_URL ?>/login.php" class="mt-6 inline-block bg-wam-navy text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:opacity-90 transition">
                Back to Sign In
            </a>
        </div>

        <?php else: ?>
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-1">Create your account</h2>
            <p class="text-gray-500 text-sm mb-6">Join the WAMDEVIN Alumni Network</p>

            <?php if ($error): ?>
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm flex items-start gap-2">
                <i class="fa fa-circle-exclamation mt-0.5 flex-shrink-0"></i>
                <span><?= $error ?></span>
            </div>
            <?php endif; ?>

            <form method="POST" action="" novalidate>
                <?= csrfField() ?>

                <!-- Name Row -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">First Name *</label>
                        <input type="text" name="first_name"
                               value="<?= e((isset($_POST['first_name']) ? $_POST['first_name'] : '')) ?>"
                               placeholder="Kwame" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-wam-navy/30 focus:border-wam-navy transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Last Name *</label>
                        <input type="text" name="last_name"
                               value="<?= e((isset($_POST['last_name']) ? $_POST['last_name'] : '')) ?>"
                               placeholder="Mensah" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-wam-navy/30 focus:border-wam-navy transition">
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email Address *</label>
                    <div class="relative">
                        <i class="fa fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="email" name="email"
                               value="<?= e((isset($_POST['email']) ? $_POST['email'] : '')) ?>"
                               placeholder="your@email.com" required
                               class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-wam-navy/30 focus:border-wam-navy transition">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password *</label>
                    <div class="relative">
                        <i class="fa fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input :type="showPass ? 'text' : 'password'"
                               name="password" placeholder="Min. 8 chars, with uppercase & number"
                               required
                               @input="
                                   const v = $event.target.value;
                                   let s = 0;
                                   if (v.length >= 8) s++;
                                   if (/[A-Z]/.test(v)) s++;
                                   if (/[0-9]/.test(v)) s++;
                                   if (/[^A-Za-z0-9]/.test(v)) s++;
                                   passwordStrength = s;
                               "
                               class="w-full pl-9 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-wam-navy/30 focus:border-wam-navy transition">
                        <button type="button" @click="showPass = !showPass"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i :class="showPass ? 'fa fa-eye-slash' : 'fa fa-eye'" class="text-sm"></i>
                        </button>
                    </div>
                    <!-- Strength bar -->
                    <div class="flex gap-1 mt-1.5">
                        <div :class="passwordStrength >= 1 ? (passwordStrength <= 2 ? 'bg-red-400' : (passwordStrength === 3 ? 'bg-yellow-400' : 'bg-green-400')) : 'bg-gray-200'" class="h-1 flex-1 rounded-full transition-colors"></div>
                        <div :class="passwordStrength >= 2 ? (passwordStrength <= 2 ? 'bg-red-400' : (passwordStrength === 3 ? 'bg-yellow-400' : 'bg-green-400')) : 'bg-gray-200'" class="h-1 flex-1 rounded-full transition-colors"></div>
                        <div :class="passwordStrength >= 3 ? (passwordStrength === 3 ? 'bg-yellow-400' : 'bg-green-400') : 'bg-gray-200'" class="h-1 flex-1 rounded-full transition-colors"></div>
                        <div :class="passwordStrength >= 4 ? 'bg-green-400' : 'bg-gray-200'" class="h-1 flex-1 rounded-full transition-colors"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1" x-text="['','Weak','Fair','Good','Strong'][passwordStrength] || ''"></p>
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm Password *</label>
                    <div class="relative">
                        <i class="fa fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input :type="showConfirm ? 'text' : 'password'"
                               name="confirm_password" placeholder="Repeat your password" required
                               class="w-full pl-9 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-wam-navy/30 focus:border-wam-navy transition">
                        <button type="button" @click="showConfirm = !showConfirm" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i :class="showConfirm ? 'fa fa-eye-slash' : 'fa fa-eye'" class="text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Academic Info -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Graduation Year</label>
                        <select name="graduation_year"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-wam-navy/30 focus:border-wam-navy transition bg-white">
                            <option value="">Select year</option>
                            <?php for ($y = $currentYear; $y >= 1960; $y--): ?>
                            <option value="<?= $y ?>" <?= ($y == ((isset($_POST['graduation_year']) ? $_POST['graduation_year'] : ''))) ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Degree / Programme</label>
                        <input type="text" name="degree"
                               value="<?= e((isset($_POST['degree']) ? $_POST['degree'] : '')) ?>"
                               placeholder="e.g. MBA, DBA"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-wam-navy/30 focus:border-wam-navy transition">
                    </div>
                </div>

                <!-- Country -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Country</label>
                    <div class="relative">
                        <i class="fa fa-globe absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" name="country"
                               value="<?= e((isset($_POST['country']) ? $_POST['country'] : '')) ?>"
                               placeholder="e.g. Nigeria, Ghana, Senegal"
                               class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-wam-navy/30 focus:border-wam-navy transition">
                    </div>
                </div>

                <!-- Terms -->
                <div class="mb-6">
                    <label class="flex items-start gap-2 cursor-pointer">
                        <input type="checkbox" name="terms" value="1"
                               class="w-4 h-4 mt-0.5 rounded border-gray-300 text-wam-navy focus:ring-wam-navy/30"
                               <?= !empty($_POST['terms']) ? 'checked' : '' ?>>
                        <span class="text-sm text-gray-600">
                            I agree to the <a href="#" class="text-wam-navy underline">Terms of Service</a> and
                            <a href="#" class="text-wam-navy underline">Privacy Policy</a>
                        </span>
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit"
                        class="w-full py-2.5 px-4 bg-wam-navy text-white rounded-lg text-sm font-semibold hover:opacity-90 transition focus:outline-none focus:ring-2 focus:ring-wam-navy/50 active:scale-[.98]">
                    Create Account <i class="fa fa-arrow-right ml-1 text-xs"></i>
                </button>
            </form>

            <p class="text-center mt-5 text-sm text-gray-600">
                Already have an account?
                <a href="<?= ALUMNI_BASE_URL ?>/login.php" class="font-semibold text-wam-navy hover:underline">Sign in</a>
            </p>
        </div>
        <?php endif; ?>

        <p class="text-center mt-6 text-xs text-gray-400">
            <a href="<?= rtrim(APP_URL,'/') ?>/index.php" class="hover:text-gray-600 transition-colors">
                <i class="fa fa-arrow-left mr-1"></i> Back to WAMDEVIN.org
            </a>
        </p>
    </div>
</div>

</body>
</html>
