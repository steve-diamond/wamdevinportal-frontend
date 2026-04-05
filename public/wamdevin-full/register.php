<?php
// WAMDEVIN - Institution Portal Registration
// Professional Institutional Member Registration with Database Integration

session_start();

// Include database configuration
require_once 'includes/db-config.php';

// Redirect if already logged in
if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'member') {
    header('Location: portal.php');
    exit();
}

$page_title = "WAMDEVIN Institution Registration";
$reg_error = '';
$reg_success = '';
$reg_step = 'form'; // form, verification, complete

// Handle registration submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['institution_register'])) {
    $institution_name = trim(!empty($_POST['institution_name']) ? $_POST['institution_name'] : '');
    $country = trim(!empty($_POST['country']) ? $_POST['country'] : '');
    $email = trim(strtolower(!empty($_POST['email']) ? $_POST['email'] : ''));
    $contact_person = trim(!empty($_POST['contact_person']) ? $_POST['contact_person'] : '');
    $phone = trim(!empty($_POST['phone']) ? $_POST['phone'] : '');
    $password = !empty($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = !empty($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    
    // Step 1: Validate input
    if (empty($institution_name) || empty($country) || empty($email) || empty($password)) {
        $reg_error = '❌ Please fill in all required fields.';
    } elseif (!isValidEmail($email)) {
        $reg_error = '❌ Please enter a valid email address.';
    } elseif ($password !== $confirm_password) {
        $reg_error = '❌ Passwords do not match.';
    } elseif (strlen($password) < PASSWORD_MIN_LENGTH) {
        $reg_error = '❌ Password must be at least ' . PASSWORD_MIN_LENGTH . ' characters long.';
    } elseif (empty($contact_person) || empty($phone)) {
        $reg_error = '❌ Contact person name and phone are required.';
    } else {
        // Step 2: Check password strength
        $strength = validatePasswordStrength($password);
        if (!$strength['valid']) {
            $reg_error = '❌ ' . $strength['message'];
        } else {
            // Step 3: Check if email already exists
            if (!isEmailAvailable($email, 'member')) {
                $reg_error = '❌ This email is already registered. <a href="login.php">Click here to login</a>.';
            } else {
                // Step 4: Check if institution already exists
                try {
                    $db = getDBConnection();
                    $query = "SELECT id FROM institution_members WHERE institution_name = :name AND deleted_at IS NULL";
                    $stmt = $db->prepare($query);
                    $stmt->execute(array(':name' => $institution_name));
                    
                    if ($stmt->rowCount() > 0) {
                        $reg_error = '❌ This institution is already registered. <a href="login.php">Click here to login</a>.';
                    } else {
                        // Step 5: Hash password and prepare data
                        $password_hash = hashPassword($password);
                        $verification_token = bin2hex(random_bytes(32));
                        $token_expires = date('Y-m-d H:i:s', strtotime('+24 hours'));
                        $client_ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
                        
                        // Step 6: Insert into database
                        $insert_query = "INSERT INTO institution_members 
                            (institution_name, country, contact_person_name, email, phone, password_hash, 
                             verification_token, verification_token_expires, ip_address, status)
                            VALUES 
                            (:inst_name, :country, :contact_person, :email, :phone, :password_hash, 
                             :verification_token, :token_expires, :ip_address, 'pending')";
                        
                        $insert_params = array(
                            ':inst_name' => $institution_name,
                            ':country' => $country,
                            ':contact_person' => $contact_person,
                            ':email' => $email,
                            ':phone' => $phone,
                            ':password_hash' => $password_hash,
                            ':verification_token' => $verification_token,
                            ':token_expires' => $token_expires,
                            ':ip_address' => $client_ip
                        );
                        
                        $insert_stmt = $db->prepare($insert_query);
                        
                        if ($insert_stmt->execute($insert_params)) {
                            $member_id = $db->lastInsertId();
                            
                            // Log the registration activity
                            logActivity('registration', 'member', $member_id, 'New institution registered');
                            
                            // Step 7: Prepare verification email (will be sent in Phase 2)
                            $verification_link = APP_URL . '/verify-email.php?token=' . $verification_token;
                            
                            // Queue email for sending
                            $email_query = "INSERT INTO email_queue (to_email, to_name, subject, body, email_type, status)
                                          VALUES (:email, :name, :subject, :body, 'verification', 'pending')";
                            
                            $email_body = "Dear " . htmlspecialchars($contact_person) . ",\n\n" .
                                        "Thank you for registering " . htmlspecialchars($institution_name) . " with the WAMDEVIN Portal.\n\n" .
                                        "Please verify your email by clicking the link below:\n" .
                                        $verification_link . "\n\n" .
                                        "This link will expire in 24 hours.\n\n" .
                                        "Best regards,\nWAMDEVIN Portal System";
                            
                            $email_stmt = $db->prepare($email_query);
                            $email_stmt->execute(array(
                                ':email' => $email,
                                ':name' => $contact_person,
                                ':subject' => 'Email Verification - WAMDEVIN Institution Portal',
                                ':body' => $email_body
                            ));
                            
                            // Success!
                            $reg_step = 'verification';
                            $reg_success = '✓ Registration successful! A verification email has been sent to: <strong>' . htmlspecialchars($email) . '</strong>';
                        } else {
                            $reg_error = '❌ Registration failed. Please try again or contact support.';
                        }
                    }
                    
                } catch (PDOException $e) {
                    error_log("Registration Error: " . $e->getMessage());
                    $reg_error = '❌ A database error occurred. Please try again later.';
                }
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
    <meta name="description" content="WAMDEVIN Institution Portal - Register your management development institute">
    <title><?php echo $page_title; ?></title>
    
    <!-- Bootstrap & Styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
    :root {
        --wamdevin-primary: #1766a2;
        --wamdevin-secondary: #f39c12;
        --wamdevin-dark: #2c3e50;
        --wamdevin-light: #ecf0f1;
        --wamdevin-gradient: linear-gradient(135deg, #1766a2 0%, #0d47a1 100%);
        --wamdevin-gradient-warm: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
    }

    body {
        background: linear-gradient(135deg, rgba(255, 157, 18, 0.95), rgba(230, 126, 34, 0.95)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        background-attachment: fixed;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        margin: 0;
    }

    .register-container {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 25px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(15px);
        overflow: hidden;
        max-width: 900px;
        width: 100%;
    }

    .register-header {
        background: var(--wamdevin-gradient-warm);
        color: white;
        padding: 50px 40px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .register-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="15" fill="rgba(255,255,255,0.05)"/><circle cx="80" cy="80" r="20" fill="rgba(255,255,255,0.03)"/></svg>');
        opacity: 0.5;
    }

    .register-header h1 {
        font-size: 2.8rem;
        font-weight: 900;
        margin-bottom: 15px;
        position: relative;
        z-index: 2;
    }

    .register-header p {
        font-size: 1.1rem;
        opacity: 0.95;
        margin: 0;
        position: relative;
        z-index: 2;
        font-weight: 500;
    }

    .register-body {
        padding: 60px 40px;
    }

    .register-form-box {
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

    .btn-register {
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

    .btn-register:hover {
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

    .required-info {
        background: rgba(243, 156, 18, 0.05);
        border: 2px solid rgba(243, 156, 18, 0.1);
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 30px;
        font-size: 0.95rem;
        color: #555;
    }

    .form-group-title {
        color: var(--wamdevin-secondary);
        font-weight: 800;
        margin-bottom: 20px;
        margin-top: 30px;
        font-size: 1.2rem;
    }

    .form-group-title:first-of-type {
        margin-top: 0;
    }

    .login-link {
        text-align: center;
        margin-top: 30px;
        padding-top: 30px;
        border-top: 2px solid #e0e0e0;
    }

    .login-link a {
        color: var(--wamdevin-primary);
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .login-link a:hover {
        color: var(--wamdevin-secondary);
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .register-container {
            border-radius: 15px;
        }
        
        .register-header {
            padding: 35px 20px;
        }
        
        .register-header h1 {
            font-size: 2.2rem;
        }
        
        .register-body {
            padding: 30px 20px;
        }

        .register-form-box {
            padding: 25px;
        }
    }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1><i class="fas fa-university"></i> WAMDEVIN</h1>
            <p>Join Our Regional Network - Institution Registration</p>
        </div>
        
        <div class="register-body">
            <div class="register-form-box">
                <h3 class="mb-4" style="color: var(--wamdevin-secondary); font-weight: 800; text-align: center;">
                    <i class="fas fa-user-plus"></i> Register Your Institution
                </h3>
                
                <?php if (!empty($reg_error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?php echo $reg_error; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($reg_success)): ?>
                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle"></i>
                        <?php echo $reg_success; ?>
                    </div>
                <?php endif; ?>

                <div class="required-info">
                    <i class="fas fa-info-circle"></i> <strong>Welcome to WAMDEVIN!</strong><br>
                    Register your management development institute to access our collaborative network, training resources, research opportunities, and regional development initiatives.
                </div>
                
                <form method="POST" action="">
                    <!-- Institution Information -->
                    <div class="form-group-title">
                        <i class="fas fa-building"></i> Institution Information
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="institution_name" name="institution_name" 
                               placeholder="Institution Name" required>
                        <label for="institution_name">Institution Name *</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-control" id="country" name="country" required>
                            <option value="">Select Country *</option>
                            <option value="Ghana">Ghana</option>
                            <option value="Nigeria">Nigeria</option>
                            <option value="Senegal">Senegal</option>
                            <option value="Mali">Mali</option>
                            <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                            <option value="Benin">Benin</option>
                            <option value="Burkina Faso">Burkina Faso</option>
                            <option value="Cameroon">Cameroon</option>
                            <option value="Congo">Congo</option>
                            <option value="Kenya">Kenya</option>
                            <option value="Other">Other</option>
                        </select>
                        <label for="country">Country *</label>
                    </div>

                    <!-- Contact Information -->
                    <div class="form-group-title">
                        <i class="fas fa-address-card"></i> Contact Information
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="contact_person" name="contact_person" 
                               placeholder="Contact Person Name">
                        <label for="contact_person">Contact Person Name</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" 
                               placeholder="institution@email.com" required>
                        <label for="email">Institution Email *</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="tel" class="form-control" id="phone" name="phone" 
                               placeholder="Phone Number">
                        <label for="phone">Phone Number</label>
                    </div>

                    <!-- Account Security -->
                    <div class="form-group-title">
                        <i class="fas fa-lock"></i> Account Security
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Password (min. 8 characters)" required>
                        <label for="password">Password (min. 8 characters) *</label>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                               placeholder="Confirm Password" required>
                        <label for="confirm_password">Confirm Password *</label>
                    </div>

                    <button type="submit" name="institution_register" class="btn btn-register">
                        <i class="fas fa-user-plus"></i> Register Institution
                    </button>
                </form>

                <div class="login-link">
                    Already have an account? <a href="login.php"><i class="fas fa-sign-in-alt"></i> Login Here</a><br><br>
                    <small><a href="admin/login.php" style="color: var(--wamdevin-primary);">Admin Access</a></small>
                </div>
            </div>
        </div>
    </div>

    <!-- Professional Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        if (form) {
            const submitBtn = document.querySelector('.btn-register');
            form.addEventListener('submit', function() {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registering...';
                submitBtn.disabled = true;
            });
        }
        
        // Auto-focus on institution name field
        document.getElementById('institution_name').focus();
        
        // Show/hide password toggle
        const passwordField = document.getElementById('password');
        const confirmPasswordField = document.getElementById('confirm_password');
        
        function createPasswordToggle(field) {
            const container = field.parentElement;
            
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
            toggleBtn.style.cursor = 'pointer';
            toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
            
            container.style.position = 'relative';
            container.appendChild(toggleBtn);
            
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (field.type === 'password') {
                    field.type = 'text';
                    toggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    field.type = 'password';
                    toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
        }
        
        createPasswordToggle(passwordField);
        createPasswordToggle(confirmPasswordField);

        // Real-time password match validation
        confirmPasswordField.addEventListener('input', function() {
            if (passwordField.value !== confirmPasswordField.value) {
                confirmPasswordField.style.borderColor = '#dc3545';
            } else {
                confirmPasswordField.style.borderColor = '#28a745';
            }
        });
    });
    </script>
</body>
</html>

