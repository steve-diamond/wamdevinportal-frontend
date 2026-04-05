<?php
/**
 * WAMDEVIN Alumni Portal - Email Verification
 * Verifies the token and activates the alumni account.
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/middleware.php';

$token   = trim((isset($_GET['token']) ? $_GET['token'] : ''));
$message = '';
$type    = 'error';

if (empty($token) || strlen($token) !== 64 || !ctype_xdigit($token)) {
    $message = 'Invalid or missing verification token.';
} else {
    try {
        $pdo  = getAlumniDB();
        $stmt = $pdo->prepare("
            SELECT id, first_name, email_verified, verification_expires
              FROM alumni
             WHERE verification_token = ? AND deleted_at IS NULL
             LIMIT 1
        ");
        $stmt->execute([$token]);
        $alumni = $stmt->fetch();

        if (!$alumni) {
            $message = 'Verification link is invalid.';
        } elseif ($alumni['email_verified']) {
            $message = 'Your email is already verified. You can sign in.';
            $type    = 'info';
        } elseif (strtotime($alumni['verification_expires']) < time()) {
            $message = 'This verification link has expired. Please <a href="' . ALUMNI_BASE_URL . '/resend-verification.php" class="underline">request a new one</a>.';
        } else {
            $pdo->prepare("
                UPDATE alumni
                   SET email_verified=1, email_verified_at=NOW(), status='active',
                       verification_token=NULL, verification_expires=NULL
                 WHERE id=?
            ")->execute([$alumni['id']]);

            $message = 'Your email has been verified! You can now sign in to your WAMDEVIN Alumni account.';
            $type    = 'success';
        }
    } catch (PDOException $e) {
        error_log('verify-email error: ' . $e->getMessage());
        $message = 'A server error occurred. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification | WAMDEVIN Alumni</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={theme:{extend:{colors:{'wam-navy':'#1a3a5c','wam-gold':'#d4a017'}}}}</script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center p-6">
    <div class="bg-white rounded-2xl shadow-xl p-10 max-w-md w-full text-center">
        <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-5 
            <?= $type === 'success' ? 'bg-green-100' : ($type === 'info' ? 'bg-blue-100' : 'bg-red-100') ?>">
            <i class="fa <?= $type === 'success' ? 'fa-circle-check text-green-600' : ($type === 'info' ? 'fa-info-circle text-blue-600' : 'fa-circle-xmark text-red-600') ?> text-3xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">
            <?= $type === 'success' ? 'Email Verified!' : ($type === 'info' ? 'Already Verified' : 'Verification Failed') ?>
        </h1>
        <p class="text-gray-500 text-sm mb-6 leading-relaxed"><?= $message ?></p>
        <a href="<?= ALUMNI_BASE_URL ?>/login.php"
           class="inline-block bg-wam-navy text-white px-8 py-2.5 rounded-lg text-sm font-semibold hover:opacity-90 transition">
            <?= $type === 'success' ? 'Sign In Now' : 'Back to Login' ?>
        </a>
    </div>
</body>
</html>
