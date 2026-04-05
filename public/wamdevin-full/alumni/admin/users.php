<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/middleware.php';

$authPayload = requireAdminAuth();
$pdo = getAlumniDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken((isset($_POST['csrf_token']) ? $_POST['csrf_token'] : ''))) {
        setFlash('error', 'Invalid request token.');
        redirect(ALUMNI_BASE_URL . '/admin/users.php');
    }

    $id = (int)((isset($_POST['id']) ? $_POST['id'] : 0));
    $status = (isset($_POST['status']) ? $_POST['status'] : '');
    $role = (isset($_POST['role']) ? $_POST['role'] : '');

    if ($id > 0) {
        $allowedStatus = ['pending','active','suspended','banned'];
        $allowedRole = ['alumni','moderator','admin'];
        if (in_array($status, $allowedStatus, true) && in_array($role, $allowedRole, true)) {
            $pdo->prepare("UPDATE alumni SET status=?, role=? WHERE id=?")->execute([$status, $role, $id]);
            setFlash('success', 'User updated successfully.');
        }
    }

    redirect(ALUMNI_BASE_URL . '/admin/users.php');
}

$users = $pdo->query("SELECT a.id, a.first_name, a.last_name, a.email, a.role, a.status, a.created_at,
                             ap.graduation_year, ap.current_title, ap.current_company
                      FROM alumni a
                 LEFT JOIN alumni_profiles ap ON ap.alumni_id=a.id
                      WHERE a.deleted_at IS NULL
                      ORDER BY a.created_at DESC LIMIT 200")->fetchAll();

$pageTitle = 'Manage Alumni Users';
$currentPage = 'admin';
include __DIR__ . '/../includes/header.php';
$flash = getFlash();
?>

<div class="mb-5 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-gray-900">Manage Alumni Users</h1>
    <a href="<?= ALUMNI_BASE_URL ?>/admin/index.php" class="text-sm text-indigo-600 hover:underline">Back to admin</a>
</div>

<?php if ($flash): ?><div class="mb-4 rounded-xl border px-4 py-3 text-sm <?= $flash['type']==='success' ? 'bg-green-50 border-green-200 text-green-700' : 'bg-red-50 border-red-200 text-red-700' ?>"><?= e($flash['message']) ?></div><?php endif; ?>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="text-left px-4 py-3">User</th>
                <th class="text-left px-4 py-3">Role</th>
                <th class="text-left px-4 py-3">Status</th>
                <th class="text-left px-4 py-3">Profile</th>
                <th class="text-left px-4 py-3">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php foreach ($users as $u): ?>
            <tr>
                <td class="px-4 py-3">
                    <p class="font-semibold text-gray-900"><?= e($u['first_name'] . ' ' . $u['last_name']) ?></p>
                    <p class="text-xs text-gray-500"><?= e($u['email']) ?></p>
                    <p class="text-xs text-gray-400">Joined <?= date('M j, Y', strtotime($u['created_at'])) ?></p>
                </td>
                <td class="px-4 py-3"><?= e($u['role']) ?></td>
                <td class="px-4 py-3"><?= e($u['status']) ?></td>
                <td class="px-4 py-3 text-xs text-gray-500"><?= e(($u['current_title'] ?: 'N/A') . ($u['current_company'] ? ' @ ' . $u['current_company'] : '')) ?></td>
                <td class="px-4 py-3">
                    <form method="POST" class="flex items-center gap-2">
                        <?= csrfField() ?>
                        <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                        <select name="role" class="border border-gray-200 rounded-lg px-2 py-1 text-xs">
                            <?php foreach (['alumni','moderator','admin'] as $r): ?>
                            <option value="<?= $r ?>" <?= $u['role'] === $r ? 'selected' : '' ?>><?= $r ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="status" class="border border-gray-200 rounded-lg px-2 py-1 text-xs">
                            <?php foreach (['pending','active','suspended','banned'] as $s): ?>
                            <option value="<?= $s ?>" <?= $u['status'] === $s ? 'selected' : '' ?>><?= $s ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button class="bg-indigo-600 text-white rounded-lg px-2.5 py-1 text-xs">Save</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
