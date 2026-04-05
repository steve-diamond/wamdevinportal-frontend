<?php
/**
 * Reset Password Page
 * 
 * Handles password reset using token from email
 * Updates user password in database
 */

session_start();
require_once 'includes/db-config.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: portal.php');
    exit();
}

$page_title = "Reset Password - WAMDEVIN Portal";
$reset_status = null;
$message = '';
$token = isset($_GET['token']) ? trim($_GET['token']) : '';

// Step 1: Validate token from URL
if (!empty($token) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $db = getDBConnection();
        
        // Check if token is valid and not expired
        $query = "SELECT id, user_type, user_id, email, is_used, expires_at 
                  FROM password_reset_tokens 
                  WHERE token = :token AND is_used = 0";
        
        $stmt = $db->prepare($query);
        $stmt->execute(array(':token' => $token));
        $reset_token = $stmt->fetch();
        
        if (!$reset_token) {
            $reset_status = 'error';
            $message = '❌ Invalid reset token. Please request a new password reset.';
        } elseif (strtotime($reset_token['expires_at']) < time()) {
            $reset_status = 'error';
            $message = '⏰ Reset link has expired (1 hour limit). <a href="forgot-password.php">Request a new reset link</a>';
        }
    } catch (PDOException $e) {
        error_log("Token Validation Error: " . $e->getMessage());
        $reset_status = 'error';
        $message = '❌ An error occurred. Please try again.';
    }
}

// Step 2: Handle password reset submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $token = isset($_POST['token']) ? trim($_POST['token']) : '';
    $new_password = !empty($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirm_password = !empty($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    
    // Validate form
    if (empty($token)) {
        $reset_status = 'error';
        $message = '❌ Reset token is missing.';
    } elseif (empty($new_password) || empty($confirm_password)) {
        $reset_status = 'error';
        $message = '❌ Please enter and confirm your new password.';
    } elseif ($new_password !== $confirm_password) {
        $reset_status = 'error';
        $message = '❌ Passwords do not match.';
    } elseif (strlen($new_password) < PASSWORD_MIN_LENGTH) {
        $reset_status = 'error';
        $message = '❌ Password must be at least ' . PASSWORD_MIN_LENGTH . ' characters.';
    } else {
        // Validate password strength
        $strength = validatePasswordStrength($new_password);
        if (!$strength['valid']) {
            $reset_status = 'error';
            $message = '❌ ' . $strength['message'];
        } else {
            try {
                $db = getDBConnection();
                
                // Verify token is still valid
                $query = "SELECT id, user_type, user_id, email, expires_at 
                          FROM password_reset_tokens 
                          WHERE token = :token AND is_used = 0";
                
                $stmt = $db->prepare($query);
                $stmt->execute(array(':token' => $token));
                $reset_token = $stmt->fetch();
                
                if (!$reset_token) {
                    $reset_status = 'error';
                    $message = '❌ Invalid reset token.';
                } elseif (strtotime($reset_token['expires_at']) < time()) {
                    $reset_status = 'error';
                    $message = '⏰ Reset link has expired.';
                } else {
                    // Token is valid - update password
                    $password_hash = hashPassword($new_password);
                    
                    // Determine table to update
                    $table = ($reset_token['user_type'] === 'admin') ? 'admin_users' : 'institution_members';
                    $id_column = ($reset_token['user_type'] === 'admin') ? 'id' : 'id';
                    
                    // Update password
                    $update_query = "UPDATE " . $table . " 
                                    SET password_hash = :hash, updated_at = NOW() 
                                    WHERE id = :id";
                    
                    $update_stmt = $db->prepare($update_query);
                    
                    if ($update_stmt->execute(array(':hash' => $password_hash, ':id' => $reset_token['user_id']))) {
                        // Mark token as used
                        $mark_used = "UPDATE password_reset_tokens SET is_used = 1, used_at = NOW() WHERE id = :id";
                        $used_stmt = $db->prepare($mark_used);
                        $used_stmt->execute(array(':id' => $reset_token['id']));
                        
                        // Clear any login locks
                        $clear_lock = "UPDATE " . $table . " SET login_attempts = 0, locked_until = NULL WHERE id = :id";
                        $lock_stmt = $db->prepare($clear_lock);
                        $lock_stmt->execute(array(':id' => $reset_token['user_id']));
                        
                        // Log activity
                        logActivity('password_reset', $reset_token['user_type'], $reset_token['user_id'], 'Password reset successful');
                        
                        $reset_status = 'success';
                        $message = '✅ <strong>Password reset successfully!</strong><br>You can now <a href="' . ($reset_token['user_type'] === 'admin' ? 'admin/login.php' : 'login.php') . '">log in with your new password</a>.';
                    } else {
                        $reset_status = 'error';
                        $message = '❌ Failed to update password. Please try again.';
                        logActivity('password_reset_failed', $reset_token['user_type'], $reset_token['user_id'], 'Password update failed');
                    }
                }
                
            } catch (PDOException $e) {
                error_log("Password Reset Error: " . $e->getMessage());
                $reset_status = 'error';
                $message = '❌ A database error occurred.';
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
    <title><?php echo $page_title; ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <style>
        :root {
            --wamdevin-primary: #1766a2;
            --wamdevin-secondary: #f39c12;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, rgba(23, 102, 162, 0.95), rgba(13, 71, 161, 0.95)), 
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .reset-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 500px;
            width: 100%;
            padding: 40px;
            animation: slideUp 0.5s ease;
        }
        
        @keyframes slideUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: var(--wamdevin-primary);
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .header p {
            color: #7f8c8d;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            color: var(--wamdevin-primary);
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
        }
        
        .password-wrapper {
            position: relative;
        }
        
        .form-control {
            border: 2px solid #ecf0f1;
            border-radius: 8px;
            padding: 12px 40px 12px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--wamdevin-primary);
            box-shadow: 0 0 0 3px rgba(23, 102, 162, 0.1);
        }
        
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #7f8c8d;
            transition: color 0.3s ease;
        }
        
        .password-toggle:hover {
            color: var(--wamdevin-primary);
        }
        
        .password-strength {
            margin-top: 8px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .strength-weak {
            color: #e74c3c;
        }
        
        .strength-medium {
            color: #f39c12;
        }
        
        .strength-strong {
            color: #27ae60;
        }
        
        .btn-reset {
            background: linear-gradient(135deg, var(--wamdevin-primary), #0d47a1);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(23, 102, 162, 0.3);
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left-color: #28a745;
        }
        
        .alert-success a {
            color: #155724;
            font-weight: 600;
            text-decoration: underline;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left-color: #dc3545;
        }
        
        .alert-error a {
            color: #721c24;
            font-weight: 600;
            text-decoration: underline;
        }
        
        .footer-links {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        
        .footer-links a {
            color: var(--wamdevin-primary);
            text-decoration: none;
            font-weight: 600;
            margin: 0 5px;
        }
        
        .footer-links a:hover {
            text-decoration: underline;
        }
        
        .security-info {
            background: #d1ecf1;
            color: #0c5460;
            padding: 12px;
            border-radius: 8px;
            font-size: 12px;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .success-icon {
            text-align: center;
            font-size: 48px;
            color: #27ae60;
            margin-bottom: 20px;
            animation: scaleIn 0.6s ease;
        }
        
        @keyframes scaleIn {
            0% { transform: scale(0); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <?php if ($reset_status === 'success'): ?>
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            
            <div class="header">
                <h1>Password Reset</h1>
            </div>
            
            <div class="alert alert-success">
                <?php echo $message; ?>
            </div>
            
            <div class="footer-links">
                <a href="index.php"><i class="fas fa-home"></i> Home</a>
            </div>
        
        <?php elseif ($reset_status === 'error' && empty($token)): ?>
            <div class="header">
                <h1>Reset Not Available</h1>
            </div>
            
            <div class="alert alert-error">
                <?php echo $message; ?>
            </div>
            
            <div class="footer-links">
                <a href="forgot-password.php"><i class="fas fa-key"></i> Request New Link</a>
                <span>|</span>
                <a href="login.php"><i class="fas fa-sign-in-alt"></i> Log In</a>
            </div>
        
        <?php else: ?>
            <div class="header">
                <h1>Create New Password</h1>
                <p>Please enter a new password for your account.</p>
            </div>
            
            <?php if (!empty($message)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                
                <div class="form-group">
                    <label for="new_password">
                        <i class="fas fa-lock"></i> New Password
                    </label>
                    <div class="password-wrapper">
                        <input type="password" class="form-control" id="new_password" name="new_password" 
                               placeholder="Minimum 8 characters" required>
                        <span class="password-toggle" onclick="togglePassword('new_password', this)">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <div class="password-strength">
                        Password requirements: 8+ characters, uppercase, lowercase, numbers, symbols
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">
                        <i class="fas fa-lock"></i> Confirm Password
                    </label>
                    <div class="password-wrapper">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                               placeholder="Re-enter password" required>
                        <span class="password-toggle" onclick="togglePassword('confirm_password', this)">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>
                
                <div class="security-info">
                    <strong>🔒 Security Tips:</strong><br>
                    • Use a unique password<br>
                    • Include numbers and symbols<br>
                    • Don't use personal information
                </div>
                
                <button type="submit" name="reset_password" class="btn-reset">
                    <i class="fas fa-check"></i> Reset Password
                </button>
            </form>
            
            <div class="footer-links">
                <a href="login.php"><i class="fas fa-sign-in-alt"></i> Back to Login</a>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        function togglePassword(fieldId, toggleIcon) {
            const field = document.getElementById(fieldId);
            const icon = toggleIcon.querySelector('i');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
