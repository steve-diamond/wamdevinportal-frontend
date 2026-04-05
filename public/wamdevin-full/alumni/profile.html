<?php
/**
 * WAMDEVIN Alumni Portal - Profile & Settings Page
 * Handles view, edit profile, and account settings tabs.
 * Avatar upload, social links, education, work experience.
 *
 * @version 1.0.0
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/middleware.php';

$authPayload = requireAlumniAuth();
$pdo         = getAlumniDB();
$alumniId    = (int)$authPayload['sub'];

$activeTab  = (isset($_GET['tab']) ? $_GET['tab'] : 'profile');
$errors     = [];
$success    = '';

// ─── Process Profile Update ───────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    if (!verifyCsrfToken((isset($_POST['csrf_token']) ? $_POST['csrf_token'] : ''))) {
        $errors[] = 'Invalid security token. Please try again.';
    } else {
        $action = $_POST['action'];

        if ($action === 'update_profile') {
            $bio             = trim((isset($_POST['bio']) ? $_POST['bio'] : ''));
            $currentTitle    = trim((isset($_POST['current_title']) ? $_POST['current_title'] : ''));
            $currentCompany  = trim((isset($_POST['current_company']) ? $_POST['current_company'] : ''));
            $industry        = trim((isset($_POST['industry']) ? $_POST['industry'] : ''));
            $country         = trim((isset($_POST['country']) ? $_POST['country'] : ''));
            $city            = trim((isset($_POST['city']) ? $_POST['city'] : ''));
            $phone           = trim((isset($_POST['phone']) ? $_POST['phone'] : ''));
            $linkedinUrl     = trim((isset($_POST['linkedin_url']) ? $_POST['linkedin_url'] : ''));
            $twitterUrl      = trim((isset($_POST['twitter_url']) ? $_POST['twitter_url'] : ''));
            $websiteUrl      = trim((isset($_POST['website_url']) ? $_POST['website_url'] : ''));
            $gradYear        = (int)((isset($_POST['graduation_year']) ? $_POST['graduation_year'] : 0));
            $degree          = trim((isset($_POST['degree']) ? $_POST['degree'] : ''));
            $department      = trim((isset($_POST['department']) ? $_POST['department'] : ''));
            $isPublic        = !empty($_POST['is_public']) ? 1 : 0;
            $skills          = trim((isset($_POST['skills']) ? $_POST['skills'] : ''));
            $interests       = trim((isset($_POST['interests']) ? $_POST['interests'] : ''));
            $firstName       = trim((isset($_POST['first_name']) ? $_POST['first_name'] : ''));
            $lastName        = trim((isset($_POST['last_name']) ? $_POST['last_name'] : ''));

            // Validate URLs
            foreach (['linkedin_url' => $linkedinUrl, 'twitter_url' => $twitterUrl, 'website_url' => $websiteUrl] as $field => $url) {
                if ($url && !filter_var($url, FILTER_VALIDATE_URL)) {
                    $errors[] = ucfirst(str_replace('_', ' ', $field)) . ' is not a valid URL.';
                }
            }
            if (strlen($firstName) < 2) $errors[] = 'First name is too short.';
            if (strlen($lastName)  < 2) $errors[] = 'Last name is too short.';

            if (empty($errors)) {
                // Avatar upload
                $avatarFilename = null;
                if (!empty($_FILES['avatar']['name'])) {
                    $file      = $_FILES['avatar'];
                    $allowed   = ['image/jpeg', 'image/png', 'image/webp'];
                    $finfo     = finfo_open(FILEINFO_MIME_TYPE);
                    $mimeType  = finfo_file($finfo, $file['tmp_name']);
                    finfo_close($finfo);

                    if (!in_array($mimeType, $allowed)) {
                        $errors[] = 'Avatar must be a JPEG, PNG, or WebP image.';
                    } elseif ($file['size'] > AVATAR_MAX_SIZE) {
                        $errors[] = 'Avatar must be smaller than 2 MB.';
                    } else {
                        $ext             = pathinfo($file['name'], PATHINFO_EXTENSION);
                        $avatarFilename  = 'avatar_' . $alumniId . '_' . time() . '.' . strtolower($ext);
                        $destPath        = ALUMNI_UPLOADS . '/' . $avatarFilename;
                        if (!move_uploaded_file($file['tmp_name'], $destPath)) {
                            $errors[] = 'Failed to upload avatar. Please try again.';
                            $avatarFilename = null;
                        }
                    }
                }

                if (empty($errors)) {
                    try {
                        $pdo->beginTransaction();

                        // Update alumni base
                        $updateFields = "first_name=?, last_name=?";
                        $params       = [$firstName, $lastName];
                        if ($avatarFilename) {
                            $updateFields .= ", avatar=?";
                            $params[]      = $avatarFilename;
                        }
                        $params[] = $alumniId;
                        $pdo->prepare("UPDATE alumni SET {$updateFields} WHERE id=?")->execute($params);

                        // Upsert profile
                        $pdo->prepare("
                            INSERT INTO alumni_profiles
                                (alumni_id, graduation_year, degree, department, current_title,
                                 current_company, industry, country, city, phone, bio,
                                 linkedin_url, twitter_url, website_url, is_public, skills, interests)
                            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
                            ON DUPLICATE KEY UPDATE
                                graduation_year=VALUES(graduation_year),
                                degree=VALUES(degree),
                                department=VALUES(department),
                                current_title=VALUES(current_title),
                                current_company=VALUES(current_company),
                                industry=VALUES(industry),
                                country=VALUES(country),
                                city=VALUES(city),
                                phone=VALUES(phone),
                                bio=VALUES(bio),
                                linkedin_url=VALUES(linkedin_url),
                                twitter_url=VALUES(twitter_url),
                                website_url=VALUES(website_url),
                                is_public=VALUES(is_public),
                                skills=VALUES(skills),
                                interests=VALUES(interests)
                        ")->execute([
                            $alumniId, $gradYear ?: null, $degree ?: null, $department ?: null,
                            $currentTitle ?: null, $currentCompany ?: null, $industry ?: null,
                            $country ?: null, $city ?: null, $phone ?: null, $bio ?: null,
                            $linkedinUrl ?: null, $twitterUrl ?: null, $websiteUrl ?: null,
                            $isPublic, $skills ?: null, $interests ?: null
                        ]);

                        $pdo->commit();
                        $success = 'Profile updated successfully!';
                        $activeTab = 'profile';
                    } catch (PDOException $e) {
                        $pdo->rollback();
                        error_log('Profile update error: ' . $e->getMessage());
                        $errors[] = 'A server error occurred. Please try again.';
                    }
                }
            }

        } elseif ($action === 'change_password') {
            $currentPass = (isset($_POST['current_password']) ? $_POST['current_password'] : '');
            $newPass     = (isset($_POST['new_password']) ? $_POST['new_password'] : '');
            $confirmPass = (isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '');

            if (strlen($newPass) < 8) $errors[] = 'New password must be at least 8 characters.';
            if (!preg_match('/[A-Z]/', $newPass)) $errors[] = 'Password must include an uppercase letter.';
            if (!preg_match('/[0-9]/', $newPass)) $errors[] = 'Password must include a number.';
            if ($newPass !== $confirmPass) $errors[] = 'New passwords do not match.';

            if (empty($errors)) {
                try {
                    $stmt = $pdo->prepare("SELECT password_hash FROM alumni WHERE id=?");
                    $stmt->execute([$alumniId]);
                    $row = $stmt->fetch();

                    if (!$row || !password_verify($currentPass, $row['password_hash'])) {
                        $errors[] = 'Current password is incorrect.';
                    } else {
                        $hash = password_hash($newPass, PASSWORD_BCRYPT, ['cost' => 12]);
                        $pdo->prepare("UPDATE alumni SET password_hash=? WHERE id=?")->execute([$hash, $alumniId]);
                        $success   = 'Password changed successfully!';
                        $activeTab = 'settings';
                    }
                } catch (PDOException $e) {
                    error_log('Password change error: ' . $e->getMessage());
                    $errors[] = 'A server error occurred.';
                }
            }
        }
    }
}

// ─── Load fresh profile data ──────────────────────────────────────────────
$alumni = getCurrentAlumni();

// Education
$eduStmt = $pdo->prepare("SELECT * FROM alumni_education WHERE alumni_id=? ORDER BY end_year DESC, id DESC");
$eduStmt->execute([$alumniId]);
$education = $eduStmt->fetchAll();

// Work experience
$workStmt = $pdo->prepare("SELECT * FROM alumni_work_experience WHERE alumni_id=? ORDER BY is_current DESC, start_date DESC");
$workStmt->execute([$alumniId]);
$workExp = $workStmt->fetchAll();

$pageTitle   = 'My Profile';
$currentPage = 'profile';
include __DIR__ . '/includes/header.php';
?>

<!-- Profile Page -->
<div class="flex items-center gap-2 text-sm text-gray-400 mb-6">
    <a href="<?= ALUMNI_BASE_URL ?>/index.php" class="hover:text-gray-600">Dashboard</a>
    <i class="fa fa-chevron-right text-xs"></i>
    <span class="text-gray-600 font-medium">My Profile</span>
</div>

<!-- Profile Header Card -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <!-- Cover -->
    <div class="h-24 sm:h-36 bg-gradient-to-r from-wam-navy to-indigo-700" style="background:linear-gradient(135deg,#1a3a5c,#2d5a8e)"></div>
    <div class="px-6 pb-6">
        <div class="flex flex-col sm:flex-row sm:items-end gap-4 -mt-10 mb-4">
            <div class="relative w-20 h-20 flex-shrink-0">
                <img id="avatar-preview"
                     src="<?= e(getAvatarUrl((isset($alumni['avatar']) ? $alumni['avatar'] : null), (isset($alumni['email']) ? $alumni['email'] : ''), 80)) ?>"
                     alt="<?= e((isset($alumni['first_name']) ? $alumni['first_name'] : '')) ?>"
                     class="w-20 h-20 rounded-2xl object-cover border-4 border-white shadow-md">
                <label for="avatar-input"
                       class="absolute -bottom-1 -right-1 w-7 h-7 rounded-full bg-indigo-600 flex items-center justify-center cursor-pointer hover:bg-indigo-700 transition shadow-sm"
                       title="Change avatar">
                    <i class="fa fa-camera text-white text-xs"></i>
                </label>
            </div>
            <div class="flex-1 sm:mb-2">
                <h1 class="text-xl font-bold text-gray-900">
                    <?= e(((isset($alumni['first_name']) ? $alumni['first_name'] : '')) . ' ' . ((isset($alumni['last_name']) ? $alumni['last_name'] : ''))) ?>
                </h1>
                <?php if (!empty($alumni['current_title'])): ?>
                <p class="text-gray-600 text-sm"><?= e($alumni['current_title']) ?><?= !empty($alumni['current_company']) ? ' at ' . e($alumni['current_company']) : '' ?></p>
                <?php endif; ?>
                <div class="flex flex-wrap items-center gap-3 mt-1 text-xs text-gray-400">
                    <?php if (!empty($alumni['country'])): ?>
                    <span><i class="fa fa-map-pin mr-1"></i><?= e($alumni['country']) ?><?= !empty($alumni['city']) ? ', ' . e($alumni['city']) : '' ?></span>
                    <?php endif; ?>
                    <?php if (!empty($alumni['graduation_year'])): ?>
                    <span><i class="fa fa-graduation-cap mr-1"></i>Class of <?= e($alumni['graduation_year']) ?></span>
                    <?php endif; ?>
                    <span class="capitalize"><i class="fa fa-circle-check mr-1 text-green-500"></i><?= e((isset($alumni['role']) ? $alumni['role'] : 'alumni')) ?></span>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <?php if (!empty($alumni['linkedin_url'])): ?>
                <a href="<?= e($alumni['linkedin_url']) ?>" target="_blank" rel="noopener noreferrer"
                   class="w-8 h-8 rounded-lg bg-blue-700 flex items-center justify-center text-white hover:opacity-90 transition">
                    <i class="fab fa-linkedin-in text-sm"></i>
                </a>
                <?php endif; ?>
                <?php if (!empty($alumni['twitter_url'])): ?>
                <a href="<?= e($alumni['twitter_url']) ?>" target="_blank" rel="noopener noreferrer"
                   class="w-8 h-8 rounded-lg bg-sky-500 flex items-center justify-center text-white hover:opacity-90 transition">
                    <i class="fab fa-twitter text-sm"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex gap-1 border-b border-gray-100 -mx-6 px-6 mt-2">
            <?php
            $tabs = ['profile' => 'Edit Profile', 'settings' => 'Account Settings'];
            foreach ($tabs as $slug => $label):
            ?>
            <a href="?tab=<?= $slug ?>"
               class="px-4 py-2 text-sm font-medium transition-colors border-b-2 -mb-px
                      <?= $activeTab === $slug ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700' ?>">
                <?= $label ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Alerts -->
<?php if (!empty($errors)): ?>
<div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700 space-y-1">
    <p class="font-semibold flex items-center gap-2"><i class="fa fa-circle-exclamation"></i> Please fix the following:</p>
    <?php foreach ($errors as $err): ?><p class="ml-5">• <?= e($err) ?></p><?php endforeach; ?>
</div>
<?php endif; ?>
<?php if ($success): ?>
<div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 flex items-center gap-2">
    <i class="fa fa-circle-check"></i> <?= e($success) ?>
</div>
<?php endif; ?>

<!-- ===== EDIT PROFILE TAB ===== -->
<?php if ($activeTab === 'profile'): ?>
<form method="POST" enctype="multipart/form-data" novalidate>
    <?= csrfField() ?>
    <input type="hidden" name="action" value="update_profile">
    <!-- Hidden file input for avatar -->
    <input type="file" id="avatar-input" name="avatar" accept="image/jpeg,image/png,image/webp" class="hidden"
           onchange="const r=new FileReader();r.onload=(e)=>document.getElementById('avatar-preview').src=e.target.result;r.readAsDataURL(this.files[0])">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Basic Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fa fa-user text-indigo-500 text-sm"></i> Basic Information
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">First Name *</label>
                        <input type="text" name="first_name" value="<?= e((isset($alumni['first_name']) ? $alumni['first_name'] : '')) ?>" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Last Name *</label>
                        <input type="text" name="last_name" value="<?= e((isset($alumni['last_name']) ? $alumni['last_name'] : '')) ?>" required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Current Title</label>
                        <input type="text" name="current_title" value="<?= e((isset($alumni['current_title']) ? $alumni['current_title'] : '')) ?>" placeholder="e.g. Senior Manager"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Current Company</label>
                        <input type="text" name="current_company" value="<?= e((isset($alumni['current_company']) ? $alumni['current_company'] : '')) ?>" placeholder="e.g. Access Bank"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Industry</label>
                        <input type="text" name="industry" value="<?= e((isset($alumni['industry']) ? $alumni['industry'] : '')) ?>" placeholder="e.g. Banking, Technology"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone</label>
                        <input type="tel" name="phone" value="<?= e((isset($alumni['phone']) ? $alumni['phone'] : '')) ?>" placeholder="+234 xxx xxx xxxx"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Country</label>
                        <input type="text" name="country" value="<?= e((isset($alumni['country']) ? $alumni['country'] : '')) ?>" placeholder="e.g. Nigeria"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">City</label>
                        <input type="text" name="city" value="<?= e((isset($alumni['city']) ? $alumni['city'] : '')) ?>" placeholder="e.g. Lagos"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition">
                    </div>
                </div>
                <!-- Bio -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Bio / About Me</label>
                    <textarea name="bio" rows="4" placeholder="Tell your alumni community about yourself..." maxlength="1000"
                              class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition resize-none"><?= e((isset($alumni['bio']) ? $alumni['bio'] : '')) ?></textarea>
                    <p class="text-xs text-gray-400 mt-1">Max 1000 characters</p>
                </div>
            </div>

            <!-- Academic Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fa fa-graduation-cap text-indigo-500 text-sm"></i> Academic Background
                </h3>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Graduation Year</label>
                        <select name="graduation_year"
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 bg-white">
                            <option value="">Select</option>
                            <?php for ($y = (int)date('Y'); $y >= 1960; $y--): ?>
                            <option value="<?= $y ?>" <?= ($y == ((isset($alumni['graduation_year']) ? $alumni['graduation_year'] : ''))) ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Degree</label>
                        <input type="text" name="degree" value="<?= e((isset($alumni['degree']) ? $alumni['degree'] : '')) ?>" placeholder="e.g. MBA"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Department</label>
                        <input type="text" name="department" value="<?= e((isset($alumni['department']) ? $alumni['department'] : '')) ?>" placeholder="e.g. Management"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition">
                    </div>
                </div>
            </div>

            <!-- Social Links -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fa fa-link text-indigo-500 text-sm"></i> Social Links
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-blue-700 flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-linkedin-in text-white text-sm"></i>
                        </div>
                        <input type="url" name="linkedin_url" value="<?= e((isset($alumni['linkedin_url']) ? $alumni['linkedin_url'] : '')) ?>"
                               placeholder="https://linkedin.com/in/yourname"
                               class="flex-1 px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition">
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-sky-500 flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-twitter text-white text-sm"></i>
                        </div>
                        <input type="url" name="twitter_url" value="<?= e((isset($alumni['twitter_url']) ? $alumni['twitter_url'] : '')) ?>"
                               placeholder="https://twitter.com/yourhandle"
                               class="flex-1 px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition">
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg bg-gray-600 flex items-center justify-center flex-shrink-0">
                            <i class="fa fa-globe text-white text-sm"></i>
                        </div>
                        <input type="url" name="website_url" value="<?= e((isset($alumni['website_url']) ? $alumni['website_url'] : '')) ?>"
                               placeholder="https://yourwebsite.com"
                               class="flex-1 px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition">
                    </div>
                </div>
            </div>
        </div>

        <!-- Right sidebar options -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2 text-sm">
                    <i class="fa fa-eye text-indigo-500"></i> Privacy
                </h3>
                <label class="flex items-center gap-3 cursor-pointer">
                    <div class="relative" x-data>
                        <input type="checkbox" name="is_public" value="1" id="is_public"
                               <?= ((isset($alumni['is_public']) ? $alumni['is_public'] : 1)) ? 'checked' : '' ?>
                               class="sr-only peer">
                        <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-indigo-600 transition-colors cursor-pointer"></div>
                        <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-4 shadow-sm cursor-pointer"></div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Public Profile</p>
                        <p class="text-xs text-gray-400">Visible in alumni directory</p>
                    </div>
                </label>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-bold text-gray-900 mb-3 text-sm flex items-center gap-2">
                    <i class="fa fa-tags text-indigo-500"></i> Skills
                </h3>
                <textarea name="skills" rows="3"
                          placeholder="e.g. Leadership, Strategic Planning, Data Analysis (comma-separated)"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 resize-none"><?= e((isset($alumni['skills']) ? $alumni['skills'] : '')) ?></textarea>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-bold text-gray-900 mb-3 text-sm flex items-center gap-2">
                    <i class="fa fa-heart text-indigo-500"></i> Interests
                </h3>
                <textarea name="interests" rows="3"
                          placeholder="e.g. Innovation, Mentorship, African Development (comma-separated)"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 resize-none"><?= e((isset($alumni['interests']) ? $alumni['interests'] : '')) ?></textarea>
            </div>

            <button type="submit"
                    class="w-full py-2.5 px-4 bg-wam-navy text-white rounded-xl text-sm font-semibold hover:opacity-90 transition active:scale-[.98]" style="background:#1a3a5c;">
                <i class="fa fa-floppy-disk mr-2"></i> Save Changes
            </button>
        </div>
    </div>
</form>

<!-- ===== SETTINGS TAB ===== -->
<?php else: ?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">

        <!-- Change Password -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa fa-lock text-indigo-500 text-sm"></i> Change Password
            </h3>
            <form method="POST" novalidate x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
                <?= csrfField() ?>
                <input type="hidden" name="action" value="change_password">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Current Password</label>
                        <div class="relative">
                            <input :type="showCurrent ? 'text' : 'password'" name="current_password" required
                                   class="w-full pl-9 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500">
                            <i class="fa fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <button type="button" @click="showCurrent=!showCurrent" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <i :class="showCurrent ? 'fa fa-eye-slash' : 'fa fa-eye'" class="text-sm"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">New Password</label>
                        <div class="relative">
                            <input :type="showNew ? 'text' : 'password'" name="new_password" required
                                   class="w-full pl-9 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500">
                            <i class="fa fa-key absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <button type="button" @click="showNew=!showNew" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <i :class="showNew ? 'fa fa-eye-slash' : 'fa fa-eye'" class="text-sm"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirm New Password</label>
                        <div class="relative">
                            <input :type="showConfirm ? 'text' : 'password'" name="confirm_password" required
                                   class="w-full pl-9 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500">
                            <i class="fa fa-key absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <button type="button" @click="showConfirm=!showConfirm" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <i :class="showConfirm ? 'fa fa-eye-slash' : 'fa fa-eye'" class="text-sm"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="px-6 py-2.5 bg-wam-navy text-white rounded-xl text-sm font-semibold hover:opacity-90 transition" style="background:#1a3a5c;">
                        Update Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Account Info (read-only) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa fa-circle-info text-indigo-500 text-sm"></i> Account Information
            </h3>
            <div class="space-y-3 text-sm">
                <div class="flex items-center justify-between py-2 border-b border-gray-50">
                    <span class="text-gray-500">Email</span>
                    <span class="font-medium"><?= e((isset($alumni['email']) ? $alumni['email'] : '')) ?></span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-50">
                    <span class="text-gray-500">Status</span>
                    <span class="capitalize inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                        <i class="fa fa-circle text-xs"></i> <?= e((isset($alumni['status']) ? $alumni['status'] : 'active')) ?>
                    </span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-50">
                    <span class="text-gray-500">Role</span>
                    <span class="capitalize font-medium"><?= e((isset($alumni['role']) ? $alumni['role'] : 'alumni')) ?></span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-50">
                    <span class="text-gray-500">Member since</span>
                    <span class="font-medium"><?= date('F j, Y', strtotime((isset($alumni['created_at']) ? $alumni['created_at'] : 'now'))) ?></span>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-gray-500">Last login</span>
                    <span class="font-medium"><?= $alumni['last_login'] ? date('M j, Y g:i A', strtotime($alumni['last_login'])) : 'N/A' ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-4">
        <div class="bg-red-50 border border-red-200 rounded-2xl p-5">
            <h3 class="font-bold text-red-800 mb-2 text-sm flex items-center gap-2">
                <i class="fa fa-triangle-exclamation"></i> Danger Zone
            </h3>
            <p class="text-xs text-red-600 mb-3">Permanently delete your account and all associated data. This action is irreversible.</p>
            <button class="px-4 py-2 bg-red-600 text-white rounded-lg text-xs font-semibold hover:bg-red-700 transition" disabled title="Contact admin to delete your account">
                Delete Account
            </button>
            <p class="text-xs text-red-400 mt-1">Contact alumni.admin@wamdevin.org</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-bold text-gray-900 mb-3 text-sm"><i class="fa fa-right-from-bracket mr-1 text-indigo-500"></i> Sessions</h3>
            <p class="text-xs text-gray-500 mb-3">Sign out from all devices by revoking your session.</p>
            <a href="<?= ALUMNI_BASE_URL ?>/logout.php"
               class="block w-full text-center px-4 py-2 border border-red-200 text-red-600 rounded-lg text-xs font-medium hover:bg-red-50 transition">
                Sign Out
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
