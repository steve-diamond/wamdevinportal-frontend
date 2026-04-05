<?php
/**
 * WAMDEVIN Email Service Class
 * 
 * Handles all email sending operations using PHPMailer
 * Supports Mailtrap for testing and Gmail/Custom SMTP for production
 * 
 * Version: 1.0
 * Date: February 20, 2026
 */

// Check if PHPMailer is available, otherwise use fallback
$phpmailer_available = false;

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
    $phpmailer_available = class_exists('PHPMailer\PHPMailer\PHPMailer');
}

class EmailService {
    
    private $smtp_host;
    private $smtp_port;
    private $smtp_user;
    private $smtp_pass;
    private $from_email;
    private $from_name;
    private $debug = false;
    
    /**
     * Initialize email service with SMTP credentials
     * 
     * @param string $from_email Sender email address
     * @param string $from_name Sender name
     */
    public function __construct($from_email = null, $from_name = null) {
        // Use provided email or from config
        $this->from_email = $from_email ?? MAIL_FROM;
        $this->from_name = $from_name ?? MAIL_FROM_NAME;
        
        // Set SMTP credentials from config
        $this->smtp_host = SMTP_HOST;
        $this->smtp_port = SMTP_PORT;
        $this->smtp_user = SMTP_USER;
        $this->smtp_pass = SMTP_PASS;
        
        // Enable debug in development
        $this->debug = (defined('ENV') && ENV === 'development');
    }
    
    /**
     * Send email using PHPMailer or fallback method
     * 
     * @param array $data Email data with keys:
     *                     - to: recipient email
     *                     - to_name: recipient name
     *                     - subject: email subject
     *                     - body: email body (HTML)
     *                     - reply_to: (optional) reply-to email
     * 
     * @return array Result with 'success' => bool and 'message' => string
     */
    public function send($data) {
        // Validate required fields
        if (empty($data['to']) || empty($data['subject']) || empty($data['body'])) {
            return array(
                'success' => false,
                'message' => 'Missing required email fields: to, subject, body'
            );
        }
        
        // Use PHPMailer if available
        global $phpmailer_available;
        
        if ($phpmailer_available && class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            return $this->sendViaPHPMailer($data);
        } else {
            return $this->sendViaFallback($data);
        }
    }
    
    /**
     * Send email using PHPMailer
     * 
     * @param array $data Email data
     * @return array Result array
     */
    private function sendViaPHPMailer($data) {
        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            
            // Server settings
            $mail->SMTPDebug = $this->debug ? 2 : 0;
            $mail->isSMTP();
            $mail->Host = $this->smtp_host;
            $mail->Port = $this->smtp_port;
            $mail->SMTPAuth = true;
            $mail->Username = $this->smtp_user;
            $mail->Password = $this->smtp_pass;
            $mail->SMTPSecure = 'tls';
            
            // Recipients
            $mail->setFrom($this->from_email, $this->from_name);
            $mail->addAddress($data['to'], $data['to_name'] ?? '');
            
            if (isset($data['reply_to'])) {
                $mail->addReplyTo($data['reply_to']);
            }
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = $data['subject'];
            $mail->Body = $data['body'];
            
            // Plain text alternative
            if (isset($data['body_plain'])) {
                $mail->AltBody = $data['body_plain'];
            }
            
            // Send
            $result = $mail->send();
            
            return array(
                'success' => true,
                'message' => 'Email sent successfully to ' . $data['to']
            );
            
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            error_log("PHPMailer Error: " . $e->errorMessage());
            return array(
                'success' => false,
                'message' => 'Email sending failed: ' . $e->errorMessage()
            );
        } catch (Exception $e) {
            error_log("Email Error: " . $e->getMessage());
            return array(
                'success' => false,
                'message' => 'Email sending failed: ' . $e->getMessage()
            );
        }
    }
    
    /**
     * Fallback email method using PHP mail() function
     * Less reliable but doesn't require PHPMailer
     * 
     * @param array $data Email data
     * @return array Result array
     */
    private function sendViaFallback($data) {
        $to = $data['to'];
        $subject = $data['subject'];
        $message = $data['body'];
        
        // Headers
        $headers = array(
            'From: ' . $this->from_email,
            'Reply-To: ' . (isset($data['reply_to']) ? $data['reply_to'] : $this->from_email),
            'Content-Type: text/html; charset=UTF-8',
            'X-Mailer: PHP/' . phpversion()
        );
        
        // Send
        $result = mail($to, $subject, $message, implode("\r\n", $headers));
        
        if ($result) {
            return array(
                'success' => true,
                'message' => 'Email sent successfully to ' . $to . ' (using fallback method)'
            );
        } else {
            return array(
                'success' => false,
                'message' => 'Email sending failed (using fallback method)'
            );
        }
    }
    
    /**
     * Generate HTML email template
     * 
     * @param string $title Email title
     * @param string $content Email content
     * @param string $cta_text Call-to-action button text
     * @param string $cta_link Call-to-action button link
     * @return string HTML email template
     */
    public static function getTemplate($title, $content, $cta_text = null, $cta_link = null) {
        $html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #2c3e50;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .email-header {
            background: linear-gradient(135deg, #1766a2 0%, #0d47a1 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .email-body {
            padding: 40px 20px;
        }
        .email-body p {
            margin: 15px 0;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
        }
        .cta-button:hover {
            opacity: 0.9;
        }
        .email-footer {
            background: #f5f5f5;
            color: #7f8c8d;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            border-top: 1px solid #ecf0f1;
        }
        .security-note {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>WAMDEVIN Portal</h1>
        </div>
        <div class="email-body">
            <p><strong>{$title}</strong></p>
            {$content}
HTML;
        
        if ($cta_text && $cta_link) {
            $html .= '<p><a href="' . htmlspecialchars($cta_link) . '" class="cta-button">' . htmlspecialchars($cta_text) . '</a></p>';
        }
        
        $html .= <<<HTML
            <div class="security-note">
                <strong>🔒 Security Note:</strong> If you did not request this email, please ignore it. Never share verification links or tokens with anyone.
            </div>
        </div>
        <div class="email-footer">
            <p>&copy; 2026 WAMDEVIN - West African Management Development Institute Network</p>
            <p>This is an automated email. Please do not reply to this address.</p>
        </div>
    </div>
</body>
</html>
HTML;
        
        return $html;
    }
    
    /**
     * Send verification email
     * 
     * @param string $email Recipient email
     * @param string $name Recipient name
     * @param string $token Verification token
     * @param string $app_url Application base URL
     * @return array Result array
     */
    public function sendVerificationEmail($email, $name, $token, $app_url) {
        $verification_link = $app_url . '/verify-email.php?token=' . urlencode($token);
        
        $content = <<<HTML
<p>Welcome to WAMDEVIN Portal!</p>
<p>Thank you for registering your institution. Please verify your email address to activate your account.</p>
<p>Click the button below to verify your email:</p>
HTML;
        
        $body = self::getTemplate(
            'Email Verification Required',
            $content,
            'Verify Email Address',
            $verification_link
        );
        
        return $this->send(array(
            'to' => $email,
            'to_name' => $name,
            'subject' => 'Email Verification - WAMDEVIN Institution Portal',
            'body' => $body
        ));
    }
    
    /**
     * Send password reset email
     * 
     * @param string $email Recipient email
     * @param string $name Recipient name
     * @param string $token Reset token
     * @param string $app_url Application base URL
     * @return array Result array
     */
    public function sendPasswordResetEmail($email, $name, $token, $app_url) {
        $reset_link = $app_url . '/reset-password.php?token=' . urlencode($token);
        
        $content = <<<HTML
<p>Hello {$name},</p>
<p>You have requested to reset your password for your WAMDEVIN account.</p>
<p>Click the button below to reset your password:</p>
<p><strong>This link will expire in 1 hour.</strong></p>
HTML;
        
        $body = self::getTemplate(
            'Password Reset Request',
            $content,
            'Reset Password',
            $reset_link
        );
        
        return $this->send(array(
            'to' => $email,
            'to_name' => $name,
            'subject' => 'Password Reset Request - WAMDEVIN Portal',
            'body' => $body
        ));
    }
    
    /**
     * Send welcome email (after verification)
     * 
     * @param string $email Recipient email
     * @param string $name Recipient name
     * @param string $institution Institution name
     * @param string $login_url Login URL
     * @return array Result array
     */
    public function sendWelcomeEmail($email, $name, $institution, $login_url) {
        $content = <<<HTML
<p>Hello {$name},</p>
<p>Your email has been verified and your account for <strong>{$institution}</strong> is now active!</p>
<p>You can now log in to access the WAMDEVIN Portal and explore our network of management development institutes.</p>
<p>Next steps:</p>
<ul>
    <li>Complete your institution profile</li>
    <li>Browse available training programs</li>
    <li>Connect with other member institutions</li>
    <li>Access research and collaboration opportunities</li>
</ul>
HTML;
        
        $body = self::getTemplate(
            'Account Activated',
            $content,
            'Log In to Portal',
            $login_url
        );
        
        return $this->send(array(
            'to' => $email,
            'to_name' => $name,
            'subject' => 'Welcome to WAMDEVIN Portal - Account Activated',
            'body' => $body
        ));
    }
    
    /**
     * Send account suspended notification
     * 
     * @param string $email Recipient email
     * @param string $name Recipient name
     * @param string $reason Reason for suspension
     * @return array Result array
     */
    public function sendAccountSuspendedEmail($email, $name, $reason) {
        $content = <<<HTML
<p>Hello {$name},</p>
<p>Your WAMDEVIN account has been suspended.</p>
<p><strong>Reason:</strong> {$reason}</p>
<p>If you believe this is an error, please contact our support team.</p>
HTML;
        
        $body = self::getTemplate(
            'Account Suspended',
            $content
        );
        
        return $this->send(array(
            'to' => $email,
            'to_name' => $name,
            'subject' => 'Account Suspended - WAMDEVIN Portal',
            'body' => $body
        ));
    }
}

?>
