<?php
/**
 * Email Queue Processor
 * 
 * Processes and sends queued emails from the email_queue table
 * Can be run as a cron job or called from command line
 * 
 * Usage:
 * - Cron: 0 * * * * php /path/to/process-email-queue.php
 * - CLI: php process-email-queue.php
 * 
 * Version: 1.0
 * Date: February 20, 2026
 */

// Don't output HTML headers for CLI/cron
define('ENV', php_sapi_name() === 'cli' ? 'cli' : 'web');

require_once __DIR__ . '/includes/db-config.php';
require_once __DIR__ . '/includes/EmailService.php';

// Logging function
function log_process($message) {
    $timestamp = date('Y-m-d H:i:s');
    $log_message = "[{$timestamp}] {$message}\n";
    
    if (ENV === 'cli') {
        echo $log_message;
    }
    
    // Also log to file
    error_log($log_message, 3, __DIR__ . '/logs/email-queue.log');
}

// Check if running from CLI
$is_cli = php_sapi_name() === 'cli';

if (!$is_cli && ENV === 'web') {
    // Protect from direct web access
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(array('error' => 'Direct access not allowed'));
    exit;
}

log_process("Starting email queue processor");

try {
    $db = getDBConnection();
    
    // Get pending emails (limit to prevent overload)
    $query = "SELECT id, to_email, to_name, subject, body, email_type, attempts, max_attempts 
              FROM email_queue 
              WHERE status = 'pending' AND attempts < max_attempts
              ORDER BY created_at ASC
              LIMIT " . EMAIL_QUEUE_BATCH_SIZE;
    
    $stmt = $db->prepare($query);
    $stmt->execute();
    $pending_emails = $stmt->fetchAll();
    
    $total = count($pending_emails);
    log_process("Found {$total} pending emails");
    
    if ($total === 0) {
        log_process("No pending emails to process");
        if (!$is_cli) {
            header('Content-Type: application/json');
            echo json_encode(array(
                'success' => true,
                'message' => 'No pending emails',
                'total_processed' => 0
            ));
        }
        exit;
    }
    
    $sent = 0;
    $failed = 0;
    $email_service = new EmailService();
    
    // Process each email
    foreach ($pending_emails as $email) {
        try {
            log_process("Processing email: {$email['email_type']} to {$email['to_email']}");
            
            // Send email
            $result = $email_service->send(array(
                'to' => $email['to_email'],
                'to_name' => $email['to_name'],
                'subject' => $email['subject'],
                'body' => $email['body']
            ));
            
            if ($result['success']) {
                // Mark as sent
                $update_query = "UPDATE email_queue 
                                SET status = 'sent', sent_at = NOW(), attempts = attempts + 1
                                WHERE id = :id";
                
                $update_stmt = $db->prepare($update_query);
                $update_stmt->execute(array(':id' => $email['id']));
                
                log_process("✓ Sent: {$email['to_email']} - {$email['email_type']}");
                $sent++;
            } else {
                // Mark as failed or retry
                $update_query = "UPDATE email_queue 
                                SET status = 'failed', attempts = attempts + 1, error_message = :error
                                WHERE id = :id";
                
                $update_stmt = $db->prepare($update_query);
                $update_stmt->execute(array(
                    ':error' => $result['message'],
                    ':id' => $email['id']
                ));
                
                log_process("✗ Failed: {$email['to_email']} - {$result['message']}");
                $failed++;
            }
        } catch (Exception $e) {
            log_process("Error processing email {$email['id']}: " . $e->getMessage());
            $failed++;
        }
    }
    
    log_process("Email processing complete: {$sent} sent, {$failed} failed");
    
    if (!$is_cli) {
        header('Content-Type: application/json');
        echo json_encode(array(
            'success' => true,
            'message' => 'Email queue processed',
            'total_processed' => $total,
            'sent' => $sent,
            'failed' => $failed
        ));
    }
    
} catch (Exception $e) {
    log_process("ERROR: " . $e->getMessage());
    
    if (!$is_cli) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(array(
            'success' => false,
            'error' => $e->getMessage()
        ));
    }
    exit(1);
}

?>
