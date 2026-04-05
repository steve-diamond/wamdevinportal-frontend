<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/middleware.php';

redirectIfLoggedIn();
$pdo = getAlumniDB();

$mode = isset($_GET['token']) ? 'reset' : 'request';
$error = '';
$success = '';
$token = trim((isset($_GET['token']) ? $_GET['token'] : (isset($_POST['token']) ? $_POST['token'] : '')));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $mode === 'request') {
    if (!verifyCsrfToken((isset($_POST['csrf_token']) ? $_POST['csrf_token'] : ''))) {
        $error = 'Invalid request token.';
    } elseif (!checkRateLimit('alumni_pw_reset_' . ((isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '')))) {
        $error = 'Too many attempts. Please wait and try again.';
    } else {
        $email = strtolower(trim((isset($_POST['email']) ? $_POST['email'] : '')));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Enter a valid email address.';
        } else {
            $stmt = $pdo->prepare("SELECT id, first_name, last_name FROM alumni WHERE email=? AND deleted_at IS NULL LIMIT 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user) {
                $resetToken = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', time() + PASSWORD_RESET_TIMEOUT);

                $pdo->prepare("UPDATE alumni SET reset_token=?, reset_token_expires=? WHERE id=?")
                    ->execute([$resetToken, $expires, (int)$user['id']]);

                $resetLink = ALUMNI_BASE_URL . '/forgot-password.php?token=' . $resetToken;
                $name = trim($user['first_name'] . ' ' . $user['last_name']);
                $body = '<div style="font-family:Arial,sans-serif;max-width:520px">'
                    . '<h2 style="color:#1a3a5c">Reset your WAMDEVIN Alumni password</h2>'
                    . '<p>Hello ' . e($name) . ',</p>'
                    . '<p>Click the button below to reset your password. This link expires in 1 hour.</p>'
                    . '<p><a href="' . $resetLink . '" style="display:inline-block;padding:10px 18px;background:#1a3a5c;color:#fff;text-decoration:none;border-radius:6px">Reset Password</a></p>'
                    . '<p>If you did not request this, please ignore this message.</p>'
                    . '</div>';

                $pdo->prepare("INSERT INTO email_queue (to_email, to_name, subject, body, email_type) VALUES (?, ?, ?, ?, 'password_reset')")
                    ->execute([$email, $name, 'Reset your WAMDEVIN Alumni password', $body]);
            }

            // Always show same response to prevent account enumeration
            $success = 'If an account exists with that email, a reset link has been sent.';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $mode === 'reset') {
    if (!verifyCsrfToken((isset($_POST['csrf_token']) ? $_POST['csrf_token'] : ''))) {
        $error = 'Invalid request token.';
    } else {
        $password = (isset($_POST['password']) ? $_POST['password'] : '');
        $confirm = (isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '');

        if (strlen($password) < 8) {
            $error = 'Password must be at least 8 characters.';
        } elseif (!preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
            $error = 'Password must include at least one uppercase letter and one number.';
        } elseif ($password !== $confirm) {
            $error = 'Passwords do not match.';
        } else {
            $stmt = $pdo->prepare("SELECT id FROM alumni WHERE reset_token=? AND reset_token_expires > NOW() AND deleted_at IS NULL LIMIT 1");
            $stmt->execute([$token]);
            $user = $stmt->fetch();

            if (!$user) {
                $error = 'Invalid or expired token. Request a new reset link.';
            } else {
                $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                $pdo->prepare("UPDATE alumni SET password_hash=?, reset_token=NULL, reset_token_expires=NULL WHERE id=?")
                    ->execute([$hash, (int)$user['id']]);
                setFlash('success', 'Password reset successfully. Please sign in.');
                redirect(ALUMNI_BASE_URL . '/login.php');
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $mode === 'reset' ? 'Reset Password' : 'Forgot Password' ?> | WAMDEVIN Alumni</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body{font-family:Inter,sans-serif}</style>
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-1"><?= $mode === 'reset' ? 'Set New Password' : 'Forgot Password' ?></h1>
        <p class="text-sm text-gray-500 mb-6"><?= $mode === 'reset' ? 'Enter a secure new password for your account.' : 'Enter your email to receive a reset link.' ?></p>

        <?php if ($error): ?><div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-3 py-2 text-sm"><?= e($error) ?></div><?php endif; ?>
        <?php if ($success): ?><div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-700 px-3 py-2 text-sm"><?= e($success) ?></div><?php endif; ?>

        <?php if ($mode === 'request'): ?>
        <form method="POST" class="space-y-4">
            <?= csrfField() ?>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Email address</label>
                <input type="email" name="email" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm">
            </div>
            <button class="w-full bg-indigo-600 text-white rounded-lg px-4 py-2.5 text-sm font-semibold hover:bg-indigo-700">Send Reset Link</button>
        </form>
        <?php else: ?>
        <form method="POST" class="space-y-4">
            <?= csrfField() ?>
            <input type="hidden" name="token" value="<?= e($token) ?>">
            <div>
                <label class="block text-sm text-gray-600 mb-1">New password</label>
                <input type="password" name="password" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Confirm password</label>
                <input type="password" name="confirm_password" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm">
            </div>
            <button class="w-full bg-indigo-600 text-white rounded-lg px-4 py-2.5 text-sm font-semibold hover:bg-indigo-700">Reset Password</button>
        </form>
        <?php endif; ?>

        <p class="mt-6 text-xs text-gray-500 text-center"><a href="<?= ALUMNI_BASE_URL ?>/login.php" class="text-indigo-600 hover:underline">Back to sign in</a></p>
    </div>
</body>
</html>
