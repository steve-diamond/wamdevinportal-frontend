<?php
// WAMDEVIN - West African Management Development Institute Network
// Professional Admin Portal Login with Database Authentication

session_start();

// Include database configuration
require_once '../includes/db-config.php';

// Redirect if already logged in
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'admin') {
    header('Location: index.php');
    exit();
}

// Initialize variables
$page_title = "WAMDEVIN Admin Portal - Login";
$login_error = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wamdevin_login'])) {
    // Validate CSRF token
    $csrf_token = !empty($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
    if (!verifyCSRFToken($csrf_token)) {
        $login_error = '? Invalid request. Please try again.';
    } else {
        $email = trim(strtolower(!empty($_POST['email']) ? $_POST['email'] : ''));
        $password = !empty($_POST['password']) ? $_POST['password'] : '';
        
        // Step 1: Basic validation
        if (empty($email) || empty($password)) {
            $login_error = '? Please enter both email and password.';
        } elseif (!isValidEmail($email)) {
            $login_error = '? Please enter a valid email address.';
        } else {
            // Step 2: Query database for admin
            try {
                $db = getDBConnection();
                
                $query = "SELECT id, email, password_hash, status, role, admin_name, login_attempts, locked_until, two_factor_enabled 
                          FROM admin_users 
                          WHERE email = :email AND deleted_at IS NULL";
                
                $stmt = $db->prepare($query);
                $stmt->execute(array(':email' => $email));
                $admin = $stmt->fetch();
                
                // Step 3: Check if admin exists
                if (!$admin) {
                    $login_error = '? Invalid email or password. Please try again.';
                    logActivity('failed_login', 'admin', 0, 'User not found: ' . $email);
                } else {
                    // Step 4: Check if account is locked (too many failed attempts)
                    if ($admin['locked_until'] && strtotime($admin['locked_until']) > time()) {
                        $locked_minutes = ceil((strtotime($admin['locked_until']) - time()) / 60);
                        $login_error = '? Account temporarily locked due to too many failed login attempts. Please try again in ' . $locked_minutes . ' minutes.';
                    } 
                    // Step 5: Check if account is active
                    elseif ($admin['status'] !== 'active') {
                        $login_error = '? Your admin account is ' . htmlspecialchars($admin['status']) . '. Please contact the super administrator.';
                        logActivity('failed_login', 'admin', $admin['id'], 'Account status: ' . $admin['status']);
                    }
                    // Step 6: Verify password
                    elseif (!verifyPassword($password, $admin['password_hash'])) {
                        // Increment failed login attempts
                        $new_attempts = $admin['login_attempts'] + 1;
                        $locked_until = null;
                        
                        // Lock account after 5 failed attempts for 30 minutes
                        if ($new_attempts >= 5) {
                            $locked_until = date('Y-m-d H:i:s', strtotime('+30 minutes'));
                        }
                        
                        $update_query = "UPDATE admin_users SET login_attempts = :attempts, locked_until = :locked WHERE id = :id";
                        $update_params = array(
                            ':attempts' => $new_attempts,
                            ':locked' => $locked_until,
                            ':id' => $admin['id']
                        );
                        
                        $update_stmt = $db->prepare($update_query);
                        $update_stmt->execute($update_params);
                        
                        logActivity('failed_login', 'admin', $admin['id'], 'Invalid password. Attempt ' . $new_attempts . '/5');
                        
                        $login_error = '? Invalid email or password. Please try again.';
                        if ($new_attempts >= 4) {
                            $login_error .= ' (Attempt ' . $new_attempts . '/5. Account will be locked after 5 failed attempts)';
                        }
                    } else {
                        // Step 7: SUCCESS - Authentication passed
                        
                        // Check if admin has 2FA enabled
                        if ($admin['two_factor_enabled']) {
                            // Store temporary session for 2FA verification
                            $_SESSION['temp_admin_id'] = $admin['id'];
                            $_SESSION['temp_admin_email'] = $email;
                            $_SESSION['temp_admin_name'] = $admin['admin_name'];
                            $_SESSION['temp_admin_created'] = time();
                            
                            // Redirect to 2FA verification page
                            header('Location: verify-2fa.php');
                            exit();
                        } else {
                            // Step 8: Reset login attempts and update last login
                            $update_query = "UPDATE admin_users 
                                            SET login_attempts = 0, locked_until = NULL, last_login = NOW(), last_ip_login = :ip 
                                            WHERE id = :id";
                            $update_stmt = $db->prepare($update_query);
                            $update_stmt->execute(array(
                                ':ip' => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0',
                                ':id' => $admin['id']
                            ));
                            
                            // Log successful login
                            logActivity('login', 'admin', $admin['id'], 'Successful login [' . $admin['role'] . ']');
                            
                            // Start secure session
                            startSecureSession('admin', $admin['id'], $email);
                            $_SESSION['admin_role'] = $admin['role'];
                            $_SESSION['admin_name'] = $admin['admin_name'];
                            
                            // Redirect to admin dashboard
                            header('Location: index.php');
                            exit();
                        }
                    }
                }
                
            } catch (PDOException $e) {
                error_log("Admin Login Error: " . $e->getMessage());
                $login_error = '? A database error occurred. Please try again later.';
            }
        }
    }
}

// Generate CSRF token for the form
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    
    <!-- WAMDEVIN Professional Styling -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
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
        background: linear-gradient(135deg, rgba(23, 102, 162, 0.95), rgba(13, 71, 161, 0.95)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        background-attachment: fixed;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        padding: 20px;
    }

    .login-container {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 25px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(15px);
        overflow: hidden;
        max-width: 1000px;
        width: 100%;
    }

    .login-header {
        background: var(--wamdevin-gradient);
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
        text-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
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

    .login-header .vision-text {
        font-size: 0.95rem;
        opacity: 0.9;
        margin-top: 15px;
        line-height: 1.6;
        position: relative;
        z-index: 2;
        max-width: 560px;
        margin-left: auto;
        margin-right: auto;
    }

    .vision-points {
        display: flex;
        gap: 14px;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 18px;
    }

    .vision-pill {
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #ffffff;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.2px;
    }

    .login-header .accent-text {
        color: #f39c12;
        font-weight: 700;
    }

    .login-body {
        padding: 60px 40px;
    }

    .portal-intro {
        background: linear-gradient(135deg, rgba(23, 102, 162, 0.08), rgba(243, 156, 18, 0.05));
        border: 2px solid rgba(23, 102, 162, 0.1);
        border-radius: 18px;
        padding: 25px;
        margin-bottom: 40px;
        text-align: center;
    }

    .portal-intro h2 {
        color: var(--wamdevin-primary);
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .portal-intro p {
        color: #555;
        font-size: 1.05rem;
        margin: 0;
        line-height: 1.6;
    }

    .portal-options {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 40px;
    }

    .portal-card {
        border: 2px solid #e0e0e0;
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .portal-card:hover {
        border-color: var(--wamdevin-primary);
        box-shadow: 0 10px 30px rgba(23, 102, 162, 0.15);
        transform: translateY(-5px);
    }

    .portal-card.admin {
        background: linear-gradient(135deg, rgba(23, 102, 162, 0.05), rgba(23, 102, 162, 0.02));
    }

    .portal-card.institution {
        background: linear-gradient(135deg, rgba(243, 156, 18, 0.05), rgba(243, 156, 18, 0.02));
    }

    .portal-card i {
        font-size: 2.5rem;
        margin-bottom: 15px;
        display: block;
    }

    .portal-card.admin i {
        color: var(--wamdevin-primary);
    }

    .portal-card.institution i {
        color: var(--wamdevin-secondary);
    }

    .portal-card h4 {
        font-weight: 800;
        margin-bottom: 10px;
        font-size: 1.3rem;
    }

    .portal-card p {
        color: #666;
        font-size: 0.95rem;
        margin: 0;
    }

    .admin-login-form {
        border: 2px solid rgba(23, 102, 162, 0.1);
        border-radius: 15px;
        padding: 30px;
        background: rgba(23, 102, 162, 0.02);
        margin-bottom: 40px;
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
        border-color: var(--wamdevin-primary);
        box-shadow: 0 0 0 0.25rem rgba(23, 102, 162, 0.25);
    }

    .btn-admin-login {
        background: var(--wamdevin-gradient);
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

    .btn-admin-login:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(23, 102, 162, 0.4);
        color: white;
    }

    .btn-institution-portal {
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

    .btn-institution-portal:hover {
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

    .credentials-info {
        background: rgba(23, 102, 162, 0.05);
        border: 2px solid rgba(23, 102, 162, 0.1);
        border-radius: 15px;
        padding: 25px;
        margin-top: 30px;
    }

    .credentials-info h5 {
        color: var(--wamdevin-primary);
        font-weight: 800;
        margin-bottom: 18px;
        font-size: 1.2rem;
    }

    .credential-item {
        background: white;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 12px;
        border-left: 4px solid var(--wamdevin-primary);
    }

    .credential-item strong {
        color: var(--wamdevin-primary);
        font-weight: 700;
    }

    .credential-item small {
        color: #666;
    }

    .security-info {
        text-align: center;
        margin-top: 25px;
        color: #666;
        font-size: 0.95rem;
    }

    .security-info i {
        color: var(--wamdevin-accent);
        margin-right: 8px;
    }

    .institution-portal-section {
        background: linear-gradient(135deg, rgba(243, 156, 18, 0.08), rgba(56, 179, 28, 0.08));
        border: 2px solid rgba(243, 156, 18, 0.1);
        border-radius: 15px;
        padding: 30px;
        margin-top: 40px;
    }

    .institution-portal-section h3 {
        color: var(--wamdevin-secondary);
        font-weight: 800;
        margin-bottom: 15px;
        font-size: 1.5rem;
    }

    .institution-portal-section p {
        color: #555;
        margin-bottom: 15px;
        line-height: 1.7;
    }

    .portal-links {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 20px;
    }

    .portal-link-btn {
        padding: 14px 25px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        text-align: center;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .portal-link-btn.login {
        background: var(--wamdevin-gradient);
        color: white;
    }

    .portal-link-btn.login:hover {
        box-shadow: 0 10px 25px rgba(23, 102, 162, 0.3);
        transform: translateY(-2px);
        color: white;
    }

    .portal-link-btn.register {
        background: var(--wamdevin-gradient-warm);
        color: white;
    }

    .portal-link-btn.register:hover {
        box-shadow: 0 10px 25px rgba(243, 156, 18, 0.3);
        transform: translateY(-2px);
        color: white;
    }

    @media (max-width: 768px) {
        .login-container {
            margin: 10px;
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

        .portal-options {
            grid-template-columns: 1fr;
        }

        .portal-links {
            grid-template-columns: 1fr;
        }

        .login-header .vision-text {
            font-size: 0.9rem;
        }
    }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1><i class="fas fa-graduation-cap"></i> WAMDEVIN</h1>
            <p>West African Management Development Institutes Network</p>
            <div class="vision-text">
                Advancing public sector excellence through <span class="accent-text">evidence-led leadership</span>, institutional collaboration, and regional impact that strengthens governance and service delivery.
                <div class="vision-points">
                    <span class="vision-pill">Impact</span>
                    <span class="vision-pill">Methodology</span>
                    <span class="vision-pill">Opportunity</span>
                </div>
            </div>
        </div>
        
        <div class="login-body">
            <!-- Portal Introduction -->
            <div class="portal-intro">
                <h2><i class="fas fa-lock-open"></i> Administrative Access</h2>
                <p>Secure entry for WAMDEVIN leadership to oversee programmes, partnerships, and impact reporting across the regional network.</p>
            </div>

            <!-- Portal Options -->
            <div class="portal-options">
                <div class="portal-card admin">
                    <i class="fas fa-shield-alt"></i>
                    <h4>Admin Portal</h4>
                    <p>Strategic oversight, approvals, and network intelligence</p>
                </div>
                <div class="portal-card institution">
                    <i class="fas fa-university"></i>
                    <h4>Institution Portal</h4>
                    <p>Member coordination, programme delivery, collaboration</p>
                </div>
            </div>

            <!-- Admin Login Form -->
            <div class="admin-login-form">
                <h3 class="mb-4 wam-login-title">
                    <i class="fas fa-sign-in-alt"></i> Admin Portal Login
                </h3>
                
                <?php if (isset($login_error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?php echo $login_error; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" 
                               placeholder="admin@wamdevin.org" required>
                        <label for="email">
                            <i class="fas fa-envelope"></i> Email Address
                        </label>
                    </div>
                    
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Password" required>
                        <label for="password">
                            <i class="fas fa-lock"></i> Password
                        </label>
                    </div>
                    
                    <button type="submit" name="wamdevin_login" class="btn btn-admin-login">
                        <i class="fas fa-sign-in-alt"></i> Access Admin Portal
                    </button>
                </form>
                
                <div class="security-info">
                    <p>
                        <i class="fas fa-shield-alt"></i>
                        Secure authentication with session management
                    </p>
                    <p>
                        <i class="fas fa-clock"></i>
                        Session timeout: 1 hour of inactivity
                    </p>
                </div>

                <!-- Demo Credentials -->
                <div class="credentials-info">
                    <h5><i class="fas fa-info-circle"></i> Demo Credentials</h5>
                    
                    <div class="credential-item">
                        <strong>Administrator Access</strong><br>
                        <small>Email:</small> admin@wamdevin.org<br>
                        <small>Password:</small> WAMDEVIN2024!Admin<br>
                        <small class="text-muted">Full system access</small>
                    </div>
                    
                    <div class="credential-item">
                        <strong>Facilitator Access</strong><br>
                        <small>Email:</small> facilitator@wamdevin.org<br>
                        <small>Password:</small> WAMDEVIN2024!Facilitator<br>
                        <small class="text-muted">Course & profile management</small>
                    </div>
                    
                    <div class="credential-item">
                        <strong>Coordinator Access</strong><br>
                        <small>Email:</small> coordinator@wamdevin.org<br>
                        <small>Password:</small> WAMDEVIN2024!Coordinator<br>
                        <small class="text-muted">Program coordination tools</small>
                    </div>
                </div>
            </div>

            <!-- Institution Portal Section -->
            <div class="institution-portal-section">
                <h3><i class="fas fa-university"></i> Institution Portal Access</h3>
                <p>
                    Access the WAMDEVIN Institutional Member Portal to collaborate with peer institutes, manage programmes, and participate in regional research initiatives.
                </p>
                <p class="wam-portal-features">
                    <strong>Portal Features:</strong> Programme management, participant tracking, collaboration tools, resource sharing, event registration, research coordination
                </p>

                <div class="portal-links">
                    <a href="../login.php" class="portal-link-btn login">
                        <i class="fas fa-sign-in-alt"></i> Institutional Login
                    </a>
                    <a href="../register.php" class="portal-link-btn register">
                        <i class="fas fa-user-plus"></i> Register Institution
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Professional Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Enhanced login form functionality
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const submitBtn = document.querySelector('.btn-admin-login');
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
        toggleBtn.className = 'btn btn-outline-secondary';
        toggleBtn.style.position = 'absolute';
        toggleBtn.style.right = '12px';
        toggleBtn.style.top = '50%';
        toggleBtn.style.transform = 'translateY(-50%)';
        toggleBtn.style.border = 'none';
        toggleBtn.style.background = 'none';
        toggleBtn.style.zIndex = '10';
        toggleBtn.style.color = 'var(--wamdevin-primary)';
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

        // Enhanced portal card interactions
        const portalCards = document.querySelectorAll('.portal-card');
        portalCards.forEach(card => {
            card.addEventListener('click', function() {
                // Highlight selected card
                portalCards.forEach(c => c.style.opacity = '0.6');
                this.style.opacity = '1';
            });
            
            card.addEventListener('mouseenter', function() {
                portalCards.forEach(c => c.style.opacity = '1');
                this.style.opacity = '1';
            });
        });

        // Animate credential items on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        });
        
        document.querySelectorAll('.credential-item').forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = `all 0.5s ease ${index * 0.1}s`;
            observer.observe(item);
        });

        // Portal link button hover effects
        const portalLinkBtns = document.querySelectorAll('.portal-link-btn');
        portalLinkBtns.forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px)';
            });
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
    </script>
</body>
</html>
