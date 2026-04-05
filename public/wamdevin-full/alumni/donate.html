<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/middleware.php';

$authPayload = requireAlumniAuth();
$pdo = getAlumniDB();
$alumni = getCurrentAlumni();
$alumniId = (int)$authPayload['sub'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken((isset($_POST['csrf_token']) ? $_POST['csrf_token'] : ''))) {
        setFlash('error', 'Invalid request token.');
        redirect(ALUMNI_BASE_URL . '/donate.php');
    }

    $amount = (float)((isset($_POST['amount']) ? $_POST['amount'] : 0));
    $campaign = trim((isset($_POST['campaign']) ? $_POST['campaign'] : ''));
    $message = trim((isset($_POST['message']) ? $_POST['message'] : ''));
    $isAnonymous = !empty($_POST['is_anonymous']) ? 1 : 0;

    if ($amount < 1) {
        setFlash('error', 'Please enter a valid donation amount.');
        redirect(ALUMNI_BASE_URL . '/donate.php');
    }

    try {
        $name = trim(((isset($alumni['first_name']) ? $alumni['first_name'] : '')) . ' ' . ((isset($alumni['last_name']) ? $alumni['last_name'] : '')));
        $email = (isset($alumni['email']) ? $alumni['email'] : '');
        $reference = 'WAMDON-' . strtoupper(bin2hex(random_bytes(4))) . '-' . time();

        // Gateway integration point: mark as completed for now (manual/offline confirmation pattern)
        $stmt = $pdo->prepare("INSERT INTO alumni_donations
            (alumni_id, donor_name, donor_email, amount, currency, campaign, message, is_anonymous, payment_method, payment_reference, payment_status, payment_gateway)
            VALUES (?, ?, ?, ?, 'USD', ?, ?, ?, 'manual', ?, 'completed', 'internal')");
        $stmt->execute([$alumniId, $name, $email, $amount, $campaign ?: null, $message ?: null, $isAnonymous, $reference]);

        $pdo->prepare("INSERT INTO alumni_notifications (alumni_id, type, title, body, action_url) VALUES (?, 'donation_receipt', 'Thank you for your donation', ?, ?)")
            ->execute([$alumniId, 'Your donation of $' . number_format($amount, 2) . ' has been received. Ref: ' . $reference, ALUMNI_BASE_URL . '/donate.php']);

        setFlash('success', 'Thank you. Your donation was recorded successfully. Ref: ' . $reference);
    } catch (Exception $e) {
        error_log('donation error: ' . $e->getMessage());
        setFlash('error', 'Unable to process donation now. Please try again.');
    }

    redirect(ALUMNI_BASE_URL . '/donate.php');
}

$campaigns = $pdo->query("SELECT id, title, slug, description, goal_amount, currency
                         FROM donation_campaigns WHERE status='active' ORDER BY created_at DESC")->fetchAll();

$totals = $pdo->query("SELECT COALESCE(SUM(amount),0) as total FROM alumni_donations WHERE payment_status='completed'")->fetch();

$myHistoryStmt = $pdo->prepare("SELECT amount, campaign, payment_reference, created_at
                                FROM alumni_donations WHERE alumni_id=? AND payment_status='completed'
                                ORDER BY created_at DESC LIMIT 10");
$myHistoryStmt->execute([$alumniId]);
$myHistory = $myHistoryStmt->fetchAll();

$pageTitle = 'Give Back';
$currentPage = 'donate';
include __DIR__ . '/includes/header.php';
$flash = getFlash();
?>

<?php if ($flash): ?>
<div class="mb-4 rounded-xl border px-4 py-3 text-sm <?= $flash['type'] === 'success' ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700' ?>"><?= e($flash['message']) ?></div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-5">
        <div class="rounded-2xl p-6 text-white shadow-sm" style="background:linear-gradient(135deg,#1a3a5c,#2d5a8e)">
            <h1 class="text-2xl font-bold">Support WAMDEVIN Impact</h1>
            <p class="text-indigo-100 text-sm mt-2 max-w-2xl">Your donation strengthens leadership development, scholarships, and innovation across West Africa.</p>
            <p class="mt-4 text-xs text-indigo-200">Community total raised: <span class="font-semibold text-white">$<?= number_format((float)((isset($totals['total']) ? $totals['total'] : 0)), 2) ?></span></p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="font-semibold text-gray-900 mb-4">Make a Donation</h2>
            <form method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <?= csrfField() ?>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Amount (USD)</label>
                    <input type="number" step="0.01" min="1" name="amount" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Campaign</label>
                    <select name="campaign" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm">
                        <option value="">General Alumni Support</option>
                        <?php foreach ($campaigns as $c): ?>
                        <option value="<?= e($c['title']) ?>"><?= e($c['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm text-gray-600 mb-1">Message (optional)</label>
                    <textarea name="message" rows="3" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm"></textarea>
                </div>
                <label class="sm:col-span-2 inline-flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="is_anonymous" value="1" class="rounded border-gray-300"> Donate anonymously
                </label>
                <div class="sm:col-span-2 flex items-center gap-3">
                    <button class="bg-indigo-600 text-white rounded-lg px-5 py-2.5 text-sm font-semibold hover:bg-indigo-700">Donate Now</button>
                    <p class="text-xs text-gray-400">Secure payment gateway integration can be connected in this form handler.</p>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-semibold text-gray-900 mb-3">Active Campaigns</h3>
            <div class="space-y-3">
                <?php if (!$campaigns): ?><p class="text-sm text-gray-500">No active campaigns currently.</p><?php endif; ?>
                <?php foreach ($campaigns as $c): ?>
                <div class="border border-gray-100 rounded-xl p-4">
                    <p class="font-medium text-gray-900"><?= e($c['title']) ?></p>
                    <?php if (!empty($c['description'])): ?><p class="text-sm text-gray-600 mt-1"><?= e($c['description']) ?></p><?php endif; ?>
                    <p class="text-xs text-gray-500 mt-2">Goal: <?= e($c['currency']) ?> <?= number_format((float)$c['goal_amount'], 2) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 h-fit">
        <h3 class="font-semibold text-gray-900 text-sm mb-3">My Donation History</h3>
        <div class="space-y-3">
            <?php if (!$myHistory): ?><p class="text-sm text-gray-500">No donations yet.</p><?php endif; ?>
            <?php foreach ($myHistory as $d): ?>
            <div class="border border-gray-100 rounded-lg p-3">
                <p class="text-sm font-medium text-gray-900">$<?= number_format((float)$d['amount'], 2) ?></p>
                <p class="text-xs text-gray-500"><?= e($d['campaign'] ?: 'General support') ?></p>
                <p class="text-xs text-gray-400 mt-1">Ref: <?= e($d['payment_reference']) ?></p>
                <p class="text-xs text-gray-400"><?= date('M j, Y', strtotime($d['created_at'])) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
