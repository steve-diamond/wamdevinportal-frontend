<?php
/**
 * Resend Verification Email
 * 
 * Allows users to request a new verification email
 */

session_start();
require_once 'includes/db-config.php';
require_once 'includes/EmailService.php';

$page_title = "Resend Verification Email - WAMDEVIN Portal";
$message = '';
$message_type = '';
$email = isset($_GET['email']) ? trim(strtolower($_GET['email'])) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resend_verification'])) {
    $email = trim(strtolower(!empty($_POST['email']) ? $_POST['email'] : ''));
    
    if (empty($email)) {
        $message = '❌ Please enter your email address.';
        $message_type = 'error';
    } elseif (!isValidEmail($email)) {
        $message = '❌ Please enter a valid email address.';
        $message_type = 'error';
    } else {
        try {
            $db = getDBConnection();
            
            // Find account by email
            $query = "SELECT id, contact_person_name, institution_name, email_verified, verification_token_expires 
                      FROM institution_members 
                      WHERE email = :email AND deleted_at IS NULL";
            
            $stmt = $db->prepare($query);
            $stmt->execute(array(':email' => $email));
            $member = $stmt->fetch();
            
            if (!$member) {
                // Don't reveal if account exists (security)
                $message = '✓ If this email is registered, a verification link has been sent.';
                $message_type = 'success';
                logActivity('resend_verification_requested', 'member', 0, 'Email not found: ' . $email);
            } elseif ($member['email_verified']) {
                $message = '✓ Your email is already verified. You can <a href="login.php">log in now</a>.';
                $message_type = 'success';
                logActivity('resend_verification_requested', 'member', $member['id'], 'Email already verified');
            } else {
                // Generate new verification token
                $verification_token = bin2hex(random_bytes(32));
                $token_expires = date('Y-m-d H:i:s', strtotime('+24 hours'));
                
                // Update token in database
                $update_query = "UPDATE institution_members 
                                SET verification_token = :token, verification_token_expires = :expires
                                WHERE id = :id";
                
                $update_stmt = $db->prepare($update_query);
                
                if ($update_stmt->execute(array(
                    ':token' => $verification_token,
                    ':expires' => $token_expires,
                    ':id' => $member['id']
                ))) {
                    // Send verification email
                    $email_service = new EmailService();
                    $verification_link = APP_URL . '/verify-email.php?token=' . urlencode($verification_token);
                    
                    $email_result = $email_service->sendVerificationEmail(
                        $member['email'],
                        $member['contact_person_name'],
                        $verification_token,
                        APP_URL
                    );
                    
                    if ($email_result['success']) {
                        $message = '✓ <strong>Verification email sent!</strong><br>Check your email inbox for the verification link. It will expire in 24 hours.';
                        $message_type = 'success';
                        logActivity('verification_email_resent', 'member', $member['id'], 'Verification email resent');
                    } else {
                        $message = '❌ Failed to send verification email. Please try again later.';
                        $message_type = 'error';
                        logActivity('verification_email_resend_failed', 'member', $member['id'], $email_result['message']);
                    }
                } else {
                    $message = '❌ An error occurred. Please try again.';
                    $message_type = 'error';
                }
            }
            
        } catch (PDOException $e) {
            error_log("Resend Verification Error: " . $e->getMessage());
            $message = '❌ A database error occurred. Please try again later.';
            $message_type = 'error';
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
        
        .resend-container {
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
        
        .btn-resend {
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
        
        .btn-resend:hover {
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
        
        .info-box {
            background: #e7f3ff;
            color: #0066cc;
            padding: 15px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="resend-container">
        <div class="header">
            <h1>Resend Verification</h1>
            <p>Didn't receive your verification email?</p>
        </div>
        
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <i class="fas fa-<?php echo $message_type === 'success' ? 'check-circle' : 'exclamation-triangle'; ?>"></i>
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($message_type !== 'success'): ?>
            <div class="info-box">
                <strong>📧 How it works:</strong><br>
                • Enter your email address<br>
                • We'll send a new verification link<br>
                • Link will be valid for 24 hours<br>
                • Check spam folder if not found
            </div>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i> Email Address
                    </label>
                    <input type="email" class="form-control" id="email" name="email" 
                           placeholder="your-email@institution.edu" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                
                <button type="submit" name="resend_verification" class="btn-resend">
                    <i class="fas fa-paper-plane"></i> Resend Verification Email
                </button>
            </form>
        <?php endif; ?>
        
        <div class="footer-links">
            <a href="login.php"><i class="fas fa-sign-in-alt"></i> Log In</a>
            <span>|</span>
            <a href="register.php"><i class="fas fa-user-plus"></i> Register</a>
            <span>|</span>
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
        </div>
    </div>
</body>
</html>
