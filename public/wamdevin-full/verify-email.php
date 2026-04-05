<?php
/**
 * Email Verification Page
 * 
 * Verifies institutional member email addresses
 * Handles verification tokens and marks accounts as verified
 */

session_start();
require_once 'includes/db-config.php';
require_once 'includes/EmailService.php';

$page_title = "Email Verification - WAMDEVIN Portal";
$verification_status = null;
$message = '';

// Get verification token from URL
$token = isset($_GET['token']) ? trim($_GET['token']) : '';

if (empty($token)) {
    $verification_status = 'error';
    $message = '❌ Verification token is missing. Please check your email for the correct link.';
} else {
    // Verify token format
    if (!preg_match('/^[a-f0-9]{64}$/', $token)) {
        $verification_status = 'error';
        $message = '❌ Invalid verification token format. Please check your email link.';
    } else {
        try {
            $db = getDBConnection();
            
            // Find account with this token
            $query = "SELECT id, email, institution_name, contact_person_name, verification_token_expires 
                      FROM institution_members 
                      WHERE verification_token = :token AND deleted_at IS NULL AND email_verified = 0";
            
            $stmt = $db->prepare($query);
            $stmt->execute(array(':token' => $token));
            $member = $stmt->fetch();
            
            if (!$member) {
                $verification_status = 'error';
                $message = '❌ Verification token not found or already used. <a href="register.php">Register again</a>';
                logActivity('failed_verification', 'member', 0, 'Invalid or used token');
            } else {
                // Check if token has expired
                if (strtotime($member['verification_token_expires']) < time()) {
                    $verification_status = 'error';
                    $message = '⏰ Verification link has expired (24 hour limit). <a href="resend-verification.php?email=' . urlencode($member['email']) . '">Resend verification email</a>';
                    logActivity('failed_verification', 'member', $member['id'], 'Token expired');
                } else {
                    // Token is valid - mark email as verified
                    $update_query = "UPDATE institution_members 
                                    SET email_verified = 1, 
                                        verification_token = NULL,
                                        verification_token_expires = NULL,
                                        status = 'verified'
                                    WHERE id = :id";
                    
                    $update_stmt = $db->prepare($update_query);
                    
                    if ($update_stmt->execute(array(':id' => $member['id']))) {
                        // Log verification
                        logActivity('email_verified', 'member', $member['id'], 'Email verification successful');
                        
                        // Send welcome email
                        $email_service = new EmailService();
                        $welcome_result = $email_service->sendWelcomeEmail(
                            $member['email'],
                            $member['contact_person_name'],
                            $member['institution_name'],
                            APP_URL . '/login.php'
                        );
                        
                        $verification_status = 'success';
                        $message = '✅ <strong>Email verified successfully!</strong><br>Your account is now active. You can now <a href="login.php">log in to the portal</a> with your email and password.';
                    } else {
                        $verification_status = 'error';
                        $message = '❌ An error occurred while verifying your email. Please try again.';
                        logActivity('failed_verification', 'member', $member['id'], 'Database update failed');
                    }
                }
            }
            
        } catch (PDOException $e) {
            error_log("Verification Error: " . $e->getMessage());
            $verification_status = 'error';
            $message = '❌ A database error occurred. Please contact support.';
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
        
        .verification-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 600px;
            width: 100%;
            padding: 50px 40px;
            text-align: center;
        }
        
        .verification-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }
        
        .success .verification-icon {
            color: #27ae60;
            animation: scaleIn 0.6s ease;
        }
        
        .error .verification-icon {
            color: #e74c3c;
            animation: shake 0.5s ease;
        }
        
        .loading .verification-icon {
            color: var(--wamdevin-primary);
            animation: spin 1s linear infinite;
        }
        
        @keyframes scaleIn {
            0% { transform: scale(0); }
            100% { transform: scale(1); }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        h1 {
            color: var(--wamdevin-primary);
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .message {
            font-size: 16px;
            line-height: 1.8;
            margin: 20px 0;
            padding: 20px;
            border-radius: 8px;
        }
        
        .success .message {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error .message {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .message a {
            color: inherit;
            font-weight: 600;
            text-decoration: underline;
        }
        
        .action-buttons {
            margin-top: 30px;
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--wamdevin-primary), #0d47a1);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(23, 102, 162, 0.3);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .loading-spinner {
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--wamdevin-primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 20px 0;
        }
        
        .status-info {
            background: #ecf0f1;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 13px;
            color: #7f8c8d;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="verification-container <?php echo $verification_status; ?>">
        <div class="verification-icon">
            <?php if ($verification_status === 'success'): ?>
                <i class="fas fa-check-circle"></i>
            <?php elseif ($verification_status === 'error'): ?>
                <i class="fas fa-times-circle"></i>
            <?php else: ?>
                <i class="fas fa-hourglass-half"></i>
            <?php endif; ?>
        </div>
        
        <h1>Email Verification</h1>
        
        <div class="message">
            <?php echo $message; ?>
        </div>
        
        <div class="action-buttons">
            <?php if ($verification_status === 'success'): ?>
                <a href="login.php" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Log In to Portal
                </a>
            <?php else: ?>
                <a href="register.php" class="btn btn-secondary">
                    <i class="fas fa-user-plus"></i> Back to Registration
                </a>
            <?php endif; ?>
            <a href="index.php" class="btn btn-secondary">
                <i class="fas fa-home"></i> Home
            </a>
        </div>
        
        <div class="status-info">
            <strong>What happens next:</strong><br>
            <?php if ($verification_status === 'success'): ?>
                ✓ Your account is now active<br>
                ✓ You can log in with your email and password<br>
                ✓ Complete your institution profile after login
            <?php else: ?>
                • Check your email for the verification link<br>
                • Links are valid for 24 hours<br>
                • Contact support if you need help
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
