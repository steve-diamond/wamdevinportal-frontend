<?php
/**
 * Forgot Password Page
 * 
 * Allows users to request password reset
 * Sends reset token via email
 */

session_start();
require_once 'includes/db-config.php';
require_once 'includes/EmailService.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: portal.php');
    exit();
}

$page_title = "Forgot Password - WAMDEVIN Portal";
$reset_message = '';
$reset_error = '';
$step = 'request'; // request or link_sent

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['forgot_password'])) {
    $email = trim(strtolower(!empty($_POST['email']) ? $_POST['email'] : ''));
    
    // Validate email format
    if (empty($email)) {
        $reset_error = '❌ Please enter your email address.';
    } elseif (!isValidEmail($email)) {
        $reset_error = '❌ Please enter a valid email address.';
    } else {
        try {
            $db = getDBConnection();
            
            // Find user by email (checking both members and admins)
            $user_type = null;
            $user_id = null;
            $user_name = null;
            
            // Check members first
            $query = "SELECT id, contact_person_name FROM institution_members WHERE email = :email AND deleted_at IS NULL";
            $stmt = $db->prepare($query);
            $stmt->execute(array(':email' => $email));
            $member = $stmt->fetch();
            
            if ($member) {
                $user_type = 'member';
                $user_id = $member['id'];
                $user_name = $member['contact_person_name'];
            } else {
                // Check admins
                $query = "SELECT id, admin_name FROM admin_users WHERE email = :email AND deleted_at IS NULL";
                $stmt = $db->prepare($query);
                $stmt->execute(array(':email' => $email));
                $admin = $stmt->fetch();
                
                if ($admin) {
                    $user_type = 'admin';
                    $user_id = $admin['id'];
                    $user_name = $admin['admin_name'];
                }
            }
            
            if (!$user_type) {
                // Don't reveal if account exists (security)
                $step = 'link_sent';
                $reset_message = '✓ If this email is registered, a password reset link has been sent. Check your email inbox.';
                logActivity('forgot_password_request', 'unknown', 0, 'Email not found: ' . $email);
            } else {
                // Generate reset token (valid for 1 hour)
                $reset_token = bin2hex(random_bytes(32));
                $token_expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
                
                // Store token in database
                $token_query = "INSERT INTO password_reset_tokens (token, user_type, user_id, email, expires_at) 
                               VALUES (:token, :user_type, :user_id, :email, :expires)";
                
                $token_stmt = $db->prepare($token_query);
                $token_stmt->execute(array(
                    ':token' => $reset_token,
                    ':user_type' => $user_type,
                    ':user_id' => $user_id,
                    ':email' => $email,
                    ':expires' => $token_expires
                ));
                
                // Send reset email
                $email_service = new EmailService();
                $reset_link = APP_URL . '/reset-password.php?token=' . urlencode($reset_token);
                $email_result = $email_service->sendPasswordResetEmail(
                    $email,
                    $user_name,
                    $reset_token,
                    APP_URL
                );
                
                if ($email_result['success']) {
                    $step = 'link_sent';
                    $reset_message = '✓ <strong>Password reset email sent!</strong><br>Check your email for a link to reset your password. The link will expire in 1 hour.';
                    logActivity('forgot_password_email_sent', $user_type, $user_id, 'Password reset email sent');
                } else {
                    $reset_error = '❌ Failed to send reset email. Please try again later.';
                    logActivity('forgot_password_email_failed', $user_type, $user_id, 'Email sending failed: ' . $email_result['message']);
                }
            }
            
        } catch (PDOException $e) {
            error_log("Password Reset Error: " . $e->getMessage());
            $reset_error = '❌ A database error occurred. Please try again later.';
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
        
        .form-control {
            border: 2px solid #ecf0f1;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--wamdevin-primary);
            box-shadow: 0 0 0 3px rgba(23, 102, 162, 0.1);
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
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left-color: #dc3545;
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
        <?php if ($step === 'link_sent'): ?>
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            
            <div class="header">
                <h1>Password Reset</h1>
            </div>
            
            <div class="alert alert-success">
                <?php echo $reset_message; ?>
            </div>
            
            <div class="security-info">
                <strong>🔒 Security Tips:</strong><br>
                • Never share reset links<br>
                • Links expire after 1 hour<br>
                • Check spam folder if email not found
            </div>
            
            <div class="footer-links">
                <a href="index.php"><i class="fas fa-home"></i> Home</a>
                <span>|</span>
                <a href="login.php"><i class="fas fa-sign-in-alt"></i> Log In</a>
            </div>
        
        <?php else: ?>
            <div class="header">
                <h1>Reset Password</h1>
                <p>Enter your email address and we'll send you a link to reset your password.</p>
            </div>
            
            <?php if (!empty($reset_error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo $reset_error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i> Email Address
                    </label>
                    <input type="email" class="form-control" id="email" name="email" 
                           placeholder="your-email@institution.edu" required>
                </div>
                
                <div class="security-info">
                    <strong>🔒 We'll send you a secure link to:</strong><br>
                    • Reset your password<br>
                    • Link valid for 1 hour<br>
                    • Only accessible from your email
                </div>
                
                <button type="submit" name="forgot_password" class="btn-reset">
                    <i class="fas fa-paper-plane"></i> Send Reset Link
                </button>
            </form>
            
            <div class="footer-links">
                <a href="login.php"><i class="fas fa-sign-in-alt"></i> Back to Login</a>
                <span>|</span>
                <a href="register.php"><i class="fas fa-user-plus"></i> Register</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
