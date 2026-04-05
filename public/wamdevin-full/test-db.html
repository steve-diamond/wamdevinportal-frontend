<?php
/**
 * Database Connection Test
 * 
 * This file tests the database connection and displays status
 * Delete this file after testing for security
 */

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection Test - WAMDEVIN Portal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1766a2 0%, #0d47a1 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 600px;
            width: 100%;
            padding: 40px;
        }
        
        h1 {
            color: #1766a2;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
        }
        
        .test-section {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ecf0f1;
        }
        
        .test-section:last-child {
            border-bottom: none;
        }
        
        .test-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .result {
            padding: 12px 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            line-height: 1.6;
            overflow-x: auto;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        .warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
        
        .status-icon {
            display: inline-block;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            margin-right: 8px;
            vertical-align: middle;
        }
        
        .success .status-icon {
            background: #28a745;
        }
        
        .error .status-icon {
            background: #dc3545;
        }
        
        .info .status-icon {
            background: #17a2b8;
        }
        
        .warning .status-icon {
            background: #ffc107;
        }
        
        .summary {
            background: #f8f9fa;
            border: 2px solid #1766a2;
            border-radius: 10px;
            padding: 20px;
            margin: 30px 0;
        }
        
        .summary h2 {
            color: #1766a2;
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .summary p {
            color: #2c3e50;
            line-height: 1.6;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 30px;
            justify-content: center;
        }
        
        .btn {
            padding: 12px 24px;
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
            background: #1766a2;
            color: white;
        }
        
        .btn-primary:hover {
            background: #0d47a1;
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
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 13px;
        }
        
        table th {
            background: #f8f9fa;
            color: #2c3e50;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
        }
        
        table td {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        
        table tr:hover {
            background: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔌 Database Connection Test</h1>
        
        <div class="test-section">
            <div class="test-title">PHP Version</div>
            <div class="result success">
                <span class="status-icon"></span>
                <?php echo PHP_VERSION; ?>
            </div>
        </div>
        
        <div class="test-section">
            <div class="test-title">Required PHP Extensions</div>
            <?php
            $extensions = array(
                'PDO' => extension_loaded('pdo'),
                'PDO MySQL' => extension_loaded('pdo_mysql'),
                'JSON' => extension_loaded('json'),
                'mbstring' => extension_loaded('mbstring'),
                'filter' => extension_loaded('filter')
            );
            
            foreach ($extensions as $name => $loaded) {
                $class = $loaded ? 'success' : 'error';
                $icon = $loaded ? '✓' : '✗';
                echo "<div class='result $class' style='margin-bottom: 8px;'>";
                echo "<span class='status-icon'></span>";
                echo "$name: <strong>$icon</strong> " . ($loaded ? 'Loaded' : 'Not Loaded');
                echo "</div>";
            }
            ?>
        </div>
        
        <div class="test-section">
            <div class="test-title">Database Configuration</div>
            <?php
            // Check if config file exists
            $config_exists = file_exists('../includes/db-config.php');
            
            if ($config_exists) {
                echo "<div class='result success'>";
                echo "<span class='status-icon'></span>";
                echo "Configuration file found at: <strong>includes/db-config.php</strong>";
                echo "</div>";
            } else {
                echo "<div class='result error'>";
                echo "<span class='status-icon'></span>";
                echo "Configuration file NOT found at includes/db-config.php";
                echo "</div>";
            }
            ?>
        </div>
        
        <div class="test-section">
            <div class="test-title">Database Connection</div>
            <?php
            if ($config_exists) {
                require_once '../includes/db-config.php';
                
                try {
                    $db = getDBConnection();
                    
                    echo "<div class='result success'>";
                    echo "<span class='status-icon'></span>";
                    echo "Connected to database: <strong>" . DB_NAME . "</strong><br>";
                    echo "Host: " . DB_HOST . ":" . DB_PORT . "<br>";
                    echo "User: " . DB_USER;
                    echo "</div>";
                    
                    // Check tables
                    $tables = array('institution_members', 'admin_users', 'activity_logs');
                    echo "<div style='margin-top: 15px;'><strong>Table Status:</strong></div>";
                    
                    foreach ($tables as $table) {
                        $query = "SELECT COUNT(*) as count FROM information_schema.tables 
                                  WHERE table_schema = :db AND table_name = :table";
                        $stmt = $db->prepare($query);
                        $stmt->execute(array(':db' => DB_NAME, ':table' => $table));
                        $result = $stmt->fetch();
                        
                        $exists = $result['count'] > 0;
                        $class = $exists ? 'success' : 'warning';
                        $icon = $exists ? '✓' : '⚠';
                        
                        echo "<div class='result $class' style='margin-bottom: 8px;'>";
                        echo "<span class='status-icon'></span>";
                        echo "$table: <strong>$icon</strong> " . ($exists ? 'Exists' : 'Not Found');
                        echo "</div>";
                    }
                    
                } catch (Exception $e) {
                    echo "<div class='result error'>";
                    echo "<span class='status-icon'></span>";
                    echo "Connection Failed:<br>";
                    echo htmlspecialchars($e->getMessage());
                    echo "</div>";
                }
            } else {
                echo "<div class='result error'>";
                echo "<span class='status-icon'></span>";
                echo "Cannot test database: Configuration file not found";
                echo "</div>";
            }
            ?>
        </div>
        
        <?php if ($config_exists && isset($db)): ?>
        <div class="test-section">
            <div class="test-title">Sample Data Check</div>
            <?php
            try {
                $query = "SELECT COUNT(*) as count FROM institution_members WHERE deleted_at IS NULL";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $result = $stmt->fetch();
                $member_count = $result['count'] ?? 0;
                
                $query = "SELECT COUNT(*) as count FROM admin_users WHERE deleted_at IS NULL";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $result = $stmt->fetch();
                $admin_count = $result['count'] ?? 0;
                
                $class = ($member_count > 0 && $admin_count > 0) ? 'success' : 'info';
                
                echo "<div class='result $class'>";
                echo "<span class='status-icon'></span>";
                echo "Institution Members: <strong>$member_count</strong><br>";
                echo "Admin Users: <strong>$admin_count</strong>";
                echo "</div>";
                
            } catch (Exception $e) {
                echo "<div class='result warning'>";
                echo "<span class='status-icon'></span>";
                echo "Could not fetch data: " . htmlspecialchars($e->getMessage());
                echo "</div>";
            }
            ?>
        </div>
        <?php endif; ?>
        
        <div class="summary">
            <h2>Next Steps</h2>
            <p>
                <strong>1. Database Setup:</strong><br>
                • Open phpMyAdmin at http://localhost/phpmyadmin<br>
                • Create a new database: <code>wamdevin_portal</code><br>
                • Import the schema from: <code>database/schema.sql</code><br><br>
                
                <strong>2. Configuration:</strong><br>
                • Verify database credentials in <code>includes/db-config.php</code><br>
                • Update MySQL password if different from default<br><br>
                
                <strong>3. Testing:</strong><br>
                • Test connection with this file<br>
                • Clear session and reload to refresh tests<br><br>
                
                <strong>4. Security:</strong><br>
                • <strong>Delete this file (test-db.php) after testing</strong><br>
                • Never commit test files to production<br><br>
                
                <strong>5. Production:</strong><br>
                • Update admin user password hash in schema.sql<br>
                • Configure email settings in db-config.php<br>
                • Test registration and login flows
            </p>
        </div>
        
        <div class="action-buttons">
            <button class="btn btn-primary" onclick="location.reload()">🔄 Refresh Test</button>
            <a href="../index.php" class="btn btn-secondary">← Back to Portal</a>
        </div>
    </div>
</body>
</html>
