<?php
/**
 * WAMDEVIN Contact Form Handler
 * Professional contact form processing with validation and security
 */

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

// CORS for AJAX requests
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Configuration
$config = [
    'recipient_email' => 'info@wamdevin.com',
    'cc_email' => 'partnerships@wamdevin.com',
    'from_email' => 'noreply@wamdevin.com',
    'from_name' => 'WAMDEVIN Contact Form',
    'max_message_length' => 5000,
    'allowed_countries' => [
        'Nigeria', 'Ghana', 'Senegal', 'Mali', 'Burkina Faso', 'Ivory Coast',
        'Guinea', 'Sierra Leone', 'Liberia', 'Gambia', 'Cape Verde',
        'Guinea-Bissau', 'Mauritania', 'Niger', 'Togo', 'Benin', 'Other'
    ],
    'allowed_inquiry_types' => [
        'Partnership', 'Training', 'Consultancy', 'Membership',
        'Research', 'Events', 'General'
    ]
];

// Validation function
function validateInput($data, $type = 'text', $required = false, $max_length = null) {
    $data = trim($data);
    
    if ($required && empty($data)) {
        return ['valid' => false, 'message' => 'This field is required'];
    }
    
    if (!empty($data)) {
        switch ($type) {
            case 'email':
                if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
                    return ['valid' => false, 'message' => 'Invalid email format'];
                }
                break;
            case 'phone':
                if (!preg_match('/^[\+]?[0-9\s\-\(\)]+$/', $data)) {
                    return ['valid' => false, 'message' => 'Invalid phone number format'];
                }
                break;
            case 'text':
                $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
                break;
        }
        
        if ($max_length && strlen($data) > $max_length) {
            return ['valid' => false, 'message' => "Text too long (max {$max_length} characters)"];
        }
    }
    
    return ['valid' => true, 'data' => $data];
}

// Rate limiting (simple file-based)
function checkRateLimit($ip) {
    $rate_file = sys_get_temp_dir() . '/wamdevin_contact_rate_' . md5($ip);
    $current_time = time();
    $rate_limit = 5; // 5 submissions per hour
    $time_window = 3600; // 1 hour
    
    if (file_exists($rate_file)) {
        $data = json_decode(file_get_contents($rate_file), true);
        $submissions = array_filter($data, function($timestamp) use ($current_time, $time_window) {
            return ($current_time - $timestamp) < $time_window;
        });
        
        if (count($submissions) >= $rate_limit) {
            return false;
        }
        
        $submissions[] = $current_time;
    } else {
        $submissions = [$current_time];
    }
    
    file_put_contents($rate_file, json_encode($submissions));
    return true;
}

try {
    // Rate limiting check
    $client_ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    if (!checkRateLimit($client_ip)) {
        throw new Exception('Rate limit exceeded. Please try again later.');
    }
    
    // Get and validate form data
    $name = validateInput($_POST['name'] ?? '', 'text', true, 100);
    if (!$name['valid']) throw new Exception('Name: ' . $name['message']);
    
    $email = validateInput($_POST['email'] ?? '', 'email', true);
    if (!$email['valid']) throw new Exception('Email: ' . $email['message']);
    
    $phone = validateInput($_POST['phone'] ?? '', 'phone', false, 20);
    if (!$phone['valid']) throw new Exception('Phone: ' . $phone['message']);
    
    $organization = validateInput($_POST['organization'] ?? '', 'text', false, 150);
    if (!$organization['valid']) throw new Exception('Organization: ' . $organization['message']);
    
    $country = validateInput($_POST['country'] ?? '', 'text', false, 50);
    if (!empty($country['data']) && !in_array($country['data'], $config['allowed_countries'])) {
        throw new Exception('Invalid country selection');
    }
    
    $inquiry_type = validateInput($_POST['inquiry_type'] ?? '', 'text', true, 50);
    if (!in_array($inquiry_type['data'], $config['allowed_inquiry_types'])) {
        throw new Exception('Invalid inquiry type');
    }
    
    $subject = validateInput($_POST['subject'] ?? '', 'text', true, 200);
    if (!$subject['valid']) throw new Exception('Subject: ' . $subject['message']);
    
    $message = validateInput($_POST['message'] ?? '', 'text', true, $config['max_message_length']);
    if (!$message['valid']) throw new Exception('Message: ' . $message['message']);
    
    $newsletter = isset($_POST['newsletter']) && $_POST['newsletter'] === '1';
    
    // Prepare email content
    $email_subject = "WAMDEVIN Contact: " . $subject['data'] . " [" . $inquiry_type['data'] . "]";
    
    $email_body = "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .header { background: linear-gradient(135deg, #1766a2, #f39c12); color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .field { margin-bottom: 15px; }
        .label { font-weight: bold; color: #1766a2; }
        .footer { background: #f8f9fa; padding: 15px; text-align: center; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class='header'>
        <h2>New Contact Inquiry - WAMDEVIN</h2>
        <p>West African Management Development Excellence Network</p>
    </div>
    
    <div class='content'>
        <div class='field'>
            <span class='label'>Full Name:</span><br>
            {$name['data']}
        </div>
        
        <div class='field'>
            <span class='label'>Email Address:</span><br>
            {$email['data']}
        </div>
        
        " . (!empty($phone['data']) ? "
        <div class='field'>
            <span class='label'>Phone Number:</span><br>
            {$phone['data']}
        </div>
        " : "") . "
        
        " . (!empty($organization['data']) ? "
        <div class='field'>
            <span class='label'>Organization:</span><br>
            {$organization['data']}
        </div>
        " : "") . "
        
        " . (!empty($country['data']) ? "
        <div class='field'>
            <span class='label'>Country:</span><br>
            {$country['data']}
        </div>
        " : "") . "
        
        <div class='field'>
            <span class='label'>Inquiry Type:</span><br>
            {$inquiry_type['data']}
        </div>
        
        <div class='field'>
            <span class='label'>Subject:</span><br>
            {$subject['data']}
        </div>
        
        <div class='field'>
            <span class='label'>Message:</span><br>
            " . nl2br(htmlspecialchars($message['data'])) . "
        </div>
        
        <div class='field'>
            <span class='label'>Newsletter Subscription:</span><br>
            " . ($newsletter ? 'Yes - Add to mailing list' : 'No') . "
        </div>
        
        <div class='field'>
            <span class='label'>Submitted:</span><br>
            " . date('Y-m-d H:i:s T') . "
        </div>
        
        <div class='field'>
            <span class='label'>IP Address:</span><br>
            {$client_ip}
        </div>
    </div>
    
    <div class='footer'>
        <p>This message was sent via the WAMDEVIN contact form.</p>
        <p>WAMDEVIN - Building Excellence in West African Management Development</p>
    </div>
</body>
</html>
    ";
    
    // Email headers
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: {$config['from_name']} <{$config['from_email']}>\r\n";
    $headers .= "Reply-To: {$name['data']} <{$email['data']}>\r\n";
    $headers .= "CC: {$config['cc_email']}\r\n";
    $headers .= "X-Mailer: WAMDEVIN Contact System\r\n";
    $headers .= "X-Priority: 3\r\n";
    
    // Send email
    if (mail($config['recipient_email'], $email_subject, $email_body, $headers)) {
        // Auto-reply to sender
        $auto_reply_subject = "Thank you for contacting WAMDEVIN";
        $auto_reply_body = "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .header { background: linear-gradient(135deg, #1766a2, #f39c12); color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .footer { background: #f8f9fa; padding: 15px; text-align: center; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class='header'>
        <h2>Thank You for Contacting WAMDEVIN</h2>
        <p>West African Management Development Excellence Network</p>
    </div>
    
    <div class='content'>
        <p>Dear {$name['data']},</p>
        
        <p>Thank you for reaching out to WAMDEVIN regarding <strong>{$subject['data']}</strong>.</p>
        
        <p>We have received your inquiry and our team will review it carefully. You can expect to hear back from us within 24 hours during business days.</p>
        
        <p>In the meantime, feel free to explore our website to learn more about our programs and initiatives across West Africa.</p>
        
        <p>Best regards,<br>
        The WAMDEVIN Team<br>
        West African Management Development Institutes Network</p>
        
        <hr>
        
        <p><strong>Contact Information:</strong><br>
        Email: info@wamdevin.com<br>
        Phone: +233 (0) 123 456 789<br>
        Location: Badagry, Lagos State, Nigeria</p>
    </div>
    
    <div class='footer'>
        <p>This is an automated response. Please do not reply to this email.</p>
        <p>© 2025 WAMDEVIN. All rights reserved.</p>
    </div>
</body>
</html>
        ";
        
        $auto_reply_headers = "MIME-Version: 1.0\r\n";
        $auto_reply_headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $auto_reply_headers .= "From: {$config['from_name']} <{$config['from_email']}>\r\n";
        
        mail($email['data'], $auto_reply_subject, $auto_reply_body, $auto_reply_headers);
        
        // Log successful submission
        error_log("WAMDEVIN Contact Form: Successful submission from {$email['data']} - {$subject['data']}");
        
        echo json_encode([
            'success' => true,
            'message' => 'Thank you for your message! We will get back to you within 24 hours.'
        ]);
    } else {
        throw new Exception('Failed to send email. Please try again later.');
    }
    
} catch (Exception $e) {
    error_log("WAMDEVIN Contact Form Error: " . $e->getMessage());
    
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>

