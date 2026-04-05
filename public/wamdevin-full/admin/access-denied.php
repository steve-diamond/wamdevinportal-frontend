<?php
// WAMDEVIN - West African Management Development Institute Network
// Access Control - Permission Check
require_once 'auth.php';

// Require user authentication
requireLogin();

// Get user information
$user_name = getUserName();
$user_role = getUserRole();
$error_type = $_GET['error'] ?? 'general';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Restricted - WAMDEVIN Admin Portal</title>
    
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
        --wamdevin-gradient: linear-gradient(135deg, var(--wamdevin-primary), var(--wamdevin-accent));
    }

    body {
        background: var(--wamdevin-gradient);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
    }

    .access-container {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        padding: 50px 40px;
        text-align: center;
        max-width: 600px;
        width: 100%;
        margin: 20px;
    }

    .access-icon {
        font-size: 4rem;
        color: var(--wamdevin-primary);
        margin-bottom: 30px;
    }

    .access-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--wamdevin-dark);
        margin-bottom: 20px;
    }

    .access-message {
        font-size: 1.2rem;
        color: #666;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .btn-wamdevin {
        background: var(--wamdevin-gradient);
        border: none;
        color: white;
        padding: 15px 30px;
        border-radius: 15px;
        font-size: 16px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        margin: 10px;
    }

    .btn-wamdevin:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(23, 102, 162, 0.3);
        color: white;
        text-decoration: none;
    }

    .user-info {
        background: rgba(23, 102, 162, 0.1);
        border-radius: 15px;
        padding: 20px;
        margin: 30px 0;
    }

    .user-info h5 {
        color: var(--wamdevin-primary);
        font-weight: 700;
        margin-bottom: 10px;
    }
    </style>
</head>
<body>
    <div class="access-container">
        <div class="access-icon">
            <i class="fas fa-shield-alt"></i>
        </div>
        
        <h1 class="access-title">Access Restricted</h1>
        
        <?php if ($error_type === 'access_denied'): ?>
            <div class="access-message">
                Your current role does not have permission to access this section of the WAMDEVIN admin portal.
            </div>
        <?php else: ?>
            <div class="access-message">
                You do not have the required permissions to access this resource.
            </div>
        <?php endif; ?>
        
        <div class="user-info">
            <h5><i class="fas fa-user"></i> Current Session</h5>
            <p class="mb-1"><strong>User:</strong> <?php echo htmlspecialchars($user_name); ?></p>
            <p class="mb-0"><strong>Role:</strong> <?php echo ucfirst($user_role); ?></p>
        </div>
        
        <div class="access-message">
            Please contact your WAMDEVIN administrator to request additional permissions, or return to your dashboard to access available features.
        </div>
        
        <div class="mt-4">
            <a href="index.php" class="btn btn-wamdevin">
                <i class="fas fa-dashboard"></i> Return to Dashboard
            </a>
            <a href="?logout=true" class="btn btn-outline-secondary">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
        
        <div class="mt-4 text-muted">
            <small>
                <i class="fas fa-envelope"></i> Need help? Contact 
                <a href="mailto:admin@wamdevin.org">admin@wamdevin.org</a>
            </small>
        </div>
    </div>
</body>
</html>
