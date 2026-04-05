<?php
// WAMDEVIN - Institution Portal Login
// Professional Institutional Members Portal with Database Authentication

session_start();

// Include database configuration
require_once 'includes/db-config.php';

// Redirect if already logged in
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'member') {
    header('Location: portal.php');
    exit();
}

$page_title = "WAMDEVIN Institution Portal - Login";
$login_error = '';
$login_success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['institution_login'])) {
    $email = trim(strtolower(!empty($_POST['email']) ? $_POST['email'] : ''));
    $password = !empty($_POST['password']) ? $_POST['password'] : '';
    
    // Step 1: Basic validation
    if (empty($email) || empty($password)) {
        $login_error = '❌ Please enter both email and password.';
    } elseif (!isValidEmail($email)) {
        $login_error = '❌ Please enter a valid email address.';
    } else {
        // Step 2: Query database for member
        try {
            $db = getDBConnection();
            
            $query = "SELECT id, email, password_hash, status, email_verified, institution_name, login_attempts, locked_until 
                      FROM institution_members 
                      WHERE email = :email AND deleted_at IS NULL";
            
            $stmt = $db->prepare($query);
            $stmt->execute(array(':email' => $email));
            $member = $stmt->fetch();
            
            // Step 3: Check if member exists
            if (!$member) {
                $login_error = '❌ Invalid email or password. Please try again.';
                logActivity('failed_login', 'member', 0, 'User not found: ' . $email);
            } else {
                // Step 4: Check if account is locked (too many failed attempts)
                if ($member['locked_until'] && strtotime($member['locked_until']) > time()) {
                    $locked_minutes = ceil((strtotime($member['locked_until']) - time()) / 60);
                    $login_error = '❌ Account temporarily locked due to too many failed login attempts. Please try again in ' . $locked_minutes . ' minutes.';
                } 
                // Step 5: Check if email is verified
                elseif (!$member['email_verified']) {
                    $login_error = '⚠️ Email not verified. Please check your email for the verification link. <a href="resend-verification.php?email=' . urlencode($email) . '">Resend verification email</a>';
                    logActivity('failed_login', 'member', $member['id'], 'Email not verified');
                }
                // Step 6: Check if account is suspended
                elseif ($member['status'] !== 'verified') {
                    $login_error = '❌ Your account is ' . htmlspecialchars($member['status']) . '. Please contact support for assistance.';
                    logActivity('failed_login', 'member', $member['id'], 'Account status: ' . $member['status']);
                }
                // Step 7: Verify password
                elseif (!verifyPassword($password, $member['password_hash'])) {
                    // Increment failed login attempts
                    $new_attempts = $member['login_attempts'] + 1;
                    $locked_until = null;
                    
                    // Lock account after 5 failed attempts for 30 minutes
                    if ($new_attempts >= 5) {
                        $locked_until = date('Y-m-d H:i:s', strtotime('+30 minutes'));
                    }
                    
                    $update_query = "UPDATE institution_members SET login_attempts = :attempts, locked_until = :locked WHERE id = :id";
                    $update_params = array(
                        ':attempts' => $new_attempts,
                        ':locked' => $locked_until,
                        ':id' => $member['id']
                    );
                    
                    $update_stmt = $db->prepare($update_query);
                    $update_stmt->execute($update_params);
                    
                    logActivity('failed_login', 'member', $member['id'], 'Invalid password. Attempt ' . $new_attempts . '/5');
                    
                    $login_error = '❌ Invalid email or password. Please try again.';
                    if ($new_attempts >= 4) {
                        $login_error .= ' (Attempt ' . $new_attempts . '/5. Account will be locked after 5 failed attempts)';
                    }
                } else {
                    // Step 8: SUCCESS - Authentication passed
                    
                    // Reset login attempts
                    $update_query = "UPDATE institution_members 
                                    SET login_attempts = 0, locked_until = NULL, last_login = NOW() 
                                    WHERE id = :id";
                    $update_stmt = $db->prepare($update_query);
                    $update_stmt->execute(array(':id' => $member['id']));
                    
                    // Log successful login
                    logActivity('login', 'member', $member['id'], 'Successful login');
                    
                    // Start secure session
                    startSecureSession('member', $member['id'], $email);
                    
                    // Redirect to portal dashboard
                    header('Location: portal.php');
                    exit();
                }
            }
            
        } catch (PDOException $e) {
            error_log("Login Error: " . $e->getMessage());
            $login_error = '❌ A database error occurred. Please try again later. Contact support if the problem persists.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="WAMDEVIN Institution Portal - Secure login for institutional members and collaborators">
    <title><?php echo $page_title; ?></title>
    
    <!-- Bootstrap & Styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <style>
    :root {
        --wamdevin-primary: #1766a2;
        --wamdevin-secondary: #f39c12;
        --wamdevin-accent: #27ae60;
        --wamdevin-dark: #2c3e50;
        --wamdevin-light: #ecf0f1;
        --wamdevin-gradient: linear-gradient(135deg, #1766a2 0%, #0d47a1 100%);
        --wamdevin-gradient-warm: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
    }

    body {
        background: linear-gradient(135deg, rgba(243, 156, 18, 0.95), rgba(230, 126, 34, 0.95)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        background-attachment: fixed;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        margin: 0;
    }

    .login-container {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 25px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(15px);
        overflow: hidden;
        max-width: 900px;
        width: 100%;
    }

    .login-header {
        background: var(--wamdevin-gradient-warm);
        color: white;
        padding: 50px 40px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .login-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="15" fill="rgba(255,255,255,0.05)"/><circle cx="80" cy="80" r="20" fill="rgba(255,255,255,0.03)"/></svg>');
        opacity: 0.5;
    }

    .login-header h1 {
        font-size: 3rem;
        font-weight: 900;
        margin-bottom: 15px;
        position: relative;
        z-index: 2;
    }

    .login-header p {
        font-size: 1.1rem;
        opacity: 0.95;
        margin: 8px 0 0 0;
        position: relative;
        z-index: 2;
        font-weight: 500;
    }

    .login-header .portal-type {
        font-size: 0.95rem;
        opacity: 0.9;
        margin-top: 15px;
        position: relative;
        z-index: 2;
        background: rgba(255,255,255,0.15);
        padding: 10px 25px;
        border-radius: 50px;
        display: inline-block;
        backdrop-filter: blur(10px);
    }

    .login-body {
        padding: 60px 40px;
    }

    .login-form-box {
        border: 2px solid rgba(243, 156, 18, 0.1);
        border-radius: 15px;
        padding: 40px;
        background: rgba(243, 156, 18, 0.02);
    }

    .form-floating {
        margin-bottom: 20px;
    }

    .form-control {
        border: 2px solid #e0e0e0;
        border-radius: 15px;
        padding: 15px 20px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--wamdevin-secondary);
        box-shadow: 0 0 0 0.25rem rgba(243, 156, 18, 0.25);
    }

    .btn-institution-login {
        background: var(--wamdevin-gradient-warm);
        border: none;
        color: white;
        padding: 16px 30px;
        border-radius: 15px;
        font-size: 18px;
        font-weight: 700;
        width: 100%;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-institution-login:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(243, 156, 18, 0.4);
        color: white;
    }

    .alert {
        border-radius: 15px;
        border: none;
        padding: 15px 20px;
        margin-bottom: 25px;
    }

    .security-info {
        text-align: center;
        margin-top: 25px;
        color: #666;
        font-size: 0.95rem;
    }

    .security-info i {
        color: var(--wamdevin-secondary);
        margin-right: 8px;
    }

    .additional-links {
        text-align: center;
        margin-top: 30px;
        padding-top: 30px;
        border-top: 2px solid #e0e0e0;
    }

    .additional-links a {
        color: var(--wamdevin-secondary);
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
        margin: 0 10px;
    }

    .additional-links a:hover {
        color: var(--wamdevin-primary);
        text-decoration: underline;
    }

    .admin-link-box {
        background: linear-gradient(135deg, rgba(23, 102, 162, 0.08), rgba(23, 102, 162, 0.05));
        border: 2px solid rgba(23, 102, 162, 0.1);
        border-radius: 15px;
        padding: 25px;
        margin-top: 40px;
        text-align: center;
    }

    .admin-link-box h5 {
        color: var(--wamdevin-primary);
        font-weight: 800;
        margin-bottom: 12px;
    }

    .admin-link-box p {
        color: #666;
        margin-bottom: 15px;
        font-size: 0.95rem;
    }

    .admin-link-box a {
        background: var(--wamdevin-gradient);
        color: white;
        padding: 12px 30px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .admin-link-box a:hover {
        box-shadow: 0 10px 25px rgba(23, 102, 162, 0.3);
        transform: translateY(-2px);
        color: white;
    }

    @media (max-width: 768px) {
        .login-container {
            border-radius: 15px;
        }
        
        .login-header {
            padding: 35px 20px;
        }
        
        .login-header h1 {
            font-size: 2.2rem;
        }
        
        .login-body {
            padding: 30px 20px;
        }

        .login-form-box {
            padding: 25px;
        }
    }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1><i class="fas fa-university"></i> WAMDEVIN</h1>
            <p>Institution Portal - Member Access</p>
            <div class="portal-type">
                <i class="fas fa-lock"></i> Secure Institutional Access
            </div>
        </div>
        
        <div class="login-body">
            <div class="login-form-box">
                <h3 class="mb-4" style="color: var(--wamdevin-secondary); font-weight: 800; text-align: center;">
                    <i class="fas fa-sign-in-alt"></i> Institution Portal Login
                </h3>
                
                <?php if (!empty($login_error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?php echo $login_error; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" 
                               placeholder="institution@email.com" required>
                        <label for="email">
                            <i class="fas fa-envelope"></i> Institution Email
                        </label>
                    </div>
                    
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Password" required>
                        <label for="password">
                            <i class="fas fa-lock"></i> Password
                        </label>
                    </div>
                    
                    <button type="submit" name="institution_login" class="btn btn-institution-login">
                        <i class="fas fa-sign-in-alt"></i> Access Institution Portal
                    </button>
                </form>
                
                <div class="security-info">
                    <p>
                        <i class="fas fa-shield-alt"></i>
                        End-to-end encrypted communication
                    </p>
                    <p>
                        <i class="fas fa-clock"></i>
                        Session timeout: 2 hours of inactivity
                    </p>
                </div>

                <div class="additional-links">
                    <a href="register.php"><i class="fas fa-user-plus"></i> Register Institution</a>
                    <a href="contact.php"><i class="fas fa-headset"></i> Support</a>
                </div>
            </div>

            <!-- Admin Portal Link -->
            <div class="admin-link-box">
                <h5><i class="fas fa-shield-alt"></i> Admin Access?</h5>
                <p>System administrators and institutional leaders should access the secure admin portal</p>
                <a href="admin/login.php">
                    <i class="fas fa-lock"></i> Admin Portal Login
                </a>
            </div>
        </div>
    </div>

    <!-- Professional Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const submitBtn = document.querySelector('.btn-institution-login');
        const originalText = submitBtn.innerHTML;
        
        form.addEventListener('submit', function() {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Authenticating...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                if (!form.querySelector('.alert-danger')) {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            }, 3000);
        });
        
        // Auto-focus on email field
        document.getElementById('email').focus();
        
        // Show/hide password toggle
        const passwordField = document.getElementById('password');
        const passwordContainer = passwordField.parentElement;
        
        const toggleBtn = document.createElement('button');
        toggleBtn.type = 'button';
        toggleBtn.style.position = 'absolute';
        toggleBtn.style.right = '12px';
        toggleBtn.style.top = '50%';
        toggleBtn.style.transform = 'translateY(-50%)';
        toggleBtn.style.border = 'none';
        toggleBtn.style.background = 'none';
        toggleBtn.style.zIndex = '10';
        toggleBtn.style.color = 'var(--wamdevin-secondary)';
        toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
        
        passwordContainer.style.position = 'relative';
        passwordContainer.appendChild(toggleBtn);
        
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordField.type = 'password';
                toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });
    });
    </script>
</body>
</html>