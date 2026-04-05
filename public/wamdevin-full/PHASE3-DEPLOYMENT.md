# Phase 3 - Email System Implementation Guide

**Status:** Email Integration Complete  
**Date:** February 20, 2026  
**Version:** 3.0

---

## 🎯 Phase 3 Overview

Phase 3 adds a complete email system to the WAMDEVIN Portal, enabling:
- ✅ Email verification for new members
- ✅ Password reset functionality
- ✅ Welcome emails after verification
- ✅ Resend verification emails
- ✅ Email queue processing
- ✅ Activity logging of email events

---

## 📋 What's New in Phase 3

### New Files Created (Phase 3)

| File | Purpose | Status |
|------|---------|--------|
| `includes/EmailService.php` | Email sending class | ✅ Complete |
| `verify-email.php` | Email verification page | ✅ Complete |
| `forgot-password.php` | Password reset request | ✅ Complete |
| `reset-password.php` | Password reset form | ✅ Complete |
| `resend-verification.php` | Resend verification email | ✅ Complete |
| `process-email-queue.php` | Email queue processor | ✅ Complete |
| `composer.json` | PHP dependencies (PHPMailer) | ✅ Complete |
| `MAILTRAP-SETUP.md` | Mailtrap configuration guide | ✅ Complete |
| `PHASE3-DEPLOYMENT.md` | This file | ✅ Complete |

### Updated Files (Phase 3)

| File | Changes |
|------|---------|
| `includes/db-config.php` | Added email configuration section |
| `register.php` | Email service integration |
| `login.php` | Forgot password link added |

### Database Changes

New tables/features:
- ✅ `email_queue` table (already in schema)
- ✅ `password_reset_tokens` table (already in schema)
- ✅ Email verification fields in `institution_members`
- ✅ Email verification fields in `admin_users`

---

## 🚀 Quick Start (10 Minutes)

### Step 1: Install PHPMailer

Open PowerShell in `c:\xampp\htdocs\wamdevin\`:

```powershell
# Check if Composer is installed
composer --version

# If not installed, download from https://getcomposer.org/

# Install PHPMailer
cd c:\xampp\htdocs\wamdevin
composer update
```

### Step 2: Create Logs Directory

```powershell
New-Item -Type Directory -Path "c:\xampp\htdocs\wamdevin\logs\" -Force
```

### Step 3: Setup Mailtrap Account

1. Go to: https://mailtrap.io/
2. Sign up for free account
3. Create inbox: "WAMDEVIN Development"
4. Copy SMTP credentials

### Step 4: Configure WAMDEVIN

Edit `includes/db-config.php` - email section:

```php
define('SMTP_HOST', 'live.smtp.mailtrap.io');
define('SMTP_PORT', 587);
define('SMTP_USER', 'YOUR_MAILTRAP_TOKEN');
define('SMTP_PASS', 'YOUR_MAILTRAP_TOKEN');
```

### Step 5: Test It!

1. Visit: `http://localhost/wamdevin/register.php`
2. Register new institution
3. Check Mailtrap inbox for verification email
4. Click verification link
5. Done! Email system working!

---

## 📧 Email System Architecture

### System Flow

```
User Action
    ↓
[register.php / forgot-password.php]
    ↓
Email Data Created
    ↓
Inserted to email_queue Table
    ↓
process-email-queue.php Runs
    ↓
EmailService Class Sends
    ↓
SMTP (Mailtrap/Gmail/etc)
    ↓
Email Delivered/Tested
    ↓
Marked 'sent' in Database
```

### Email Queue Process

**Why Queue Emails?**
- Prevents timeout if email server slow
- Batch process multiple emails
- Automatic retry on failure
- Full audit trail in database

**Process:**
1. Email inserted to `email_queue` with status `pending`
2. Cron job (or manual) runs `process-email-queue.php`
3. Processor grabs up to 10 pending emails
4. Attempts to send each
5. Updates status: `sent` or `failed`
6. Logs all activity

---

## 📱 Email Pages Overview

### 1. verify-email.php
**Purpose:** Verify email addresses with token-based confirmation

**Flow:**
1. User clicks link from verification email
2. Page validates token (format, expiry)
3. Marks email as verified in database
4. Sends welcome email
5. Shows success message
6. User can now log in

**Security:**
- Tokens expire after 24 hours
- One-time use tokens
- Format validation
- Database lookup validation

### 2. forgot-password.php
**Purpose:** Request password reset link

**Flow:**
1. User enters email address
2. Check if account exists (don't reveal Yes/No)
3. Create password reset token
4. Send reset email
5. Show confirmation message

**Security:**
- Generic "email sent" message (prevent user enumeration)
- Tokens expire after 1 hour
- One-time use tokens
- Activity logged for security audit

### 3. reset-password.php
**Purpose:** Actually reset password using token

**Flow:**
1. User clicks reset link
2. Page validates token
3. Shows password reset form
4. User enters new password
5. Password hashed and stored
6. Token marked as used
7. Login attempts reset
8. Redirect to login

**Validation:**
- Password strength check
- Confirmation password match
- Minimum 8 characters
- Mixed case + numbers + symbols recommended

### 4. resend-verification.php
**Purpose:** Re-send failed verification email

**Flow:**
1. User provides email (from registration page link or manual)
2. Find unverified account
3. Generate new verification token
4. Send verification email
5. Show confirmation

**Security:**
- Generic message if email not found
- Token has 24-hour expiry
- Previous token invalidated

---

## 🔐 Security Features

### Token Security

**Format:**
- 64-character hex string (random_bytes(32))
- Cryptographically secure
- Database-validated

**Lifecycle:**
```
Generated → Stored in DB → Sent via Email → User Clicks → Validated → Marked Used → Expires
```

**Expiration:**
- Verification tokens: 24 hours
- Password reset tokens: 1 hour
- One-time use only

### Password Security

**Hashing:**
- Algorithm: Bcrypt
- Cost factor: 12 (computationally expensive)
- Salting: Automatic
- Verification: password_verify()

**Requirements:**
- Minimum: 8 characters
- Recommended: Uppercase + lowercase + numbers + symbols
- Real-time strength validation

### Account Protection

**Account Lockout:**
- Triggers after 5 failed login attempts
- Locks for 30 minutes
- Attempt counter reset on successful login

**Session Management:**
- IP address validation
- User agent tracking
- Timeout: 1 hour (admin), 2 hours (member)
- Automatic timeout extension

### Input Validation

**Email Validation:**
- Format check (RFC 5322)
- Uniqueness check (database)
- Normalization (lowercase)

**Form Validation:**
- Required field checks
- Length validation
- Type validation (email, string, etc)
- Sanitization for HTML/SQL

---

## 📊 Database Integration

### email_queue Table

```sql
CREATE TABLE email_queue (
  id INT AUTO_INCREMENT PRIMARY KEY,
  to_email VARCHAR(255) NOT NULL,
  to_name VARCHAR(255) NULL,
  subject VARCHAR(255) NOT NULL,
  body LONGTEXT NOT NULL,
  email_type ENUM('verification', 'password_reset', 'notification', 'welcome'),
  status ENUM('pending', 'sent', 'failed'),
  attempts INT DEFAULT 0,
  max_attempts INT DEFAULT 3,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  sent_at DATETIME NULL,
  error_message TEXT NULL
);
```

**Query Examples:**

View pending emails:
```sql
SELECT * FROM email_queue WHERE status = 'pending';
```

View sent emails today:
```sql
SELECT * FROM email_queue 
WHERE status = 'sent' AND DATE(sent_at) = CURDATE();
```

View failed emails:
```sql
SELECT * FROM email_queue WHERE status = 'failed';
```

### password_reset_tokens Table

```sql
CREATE TABLE password_reset_tokens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  token VARCHAR(255) NOT NULL UNIQUE,
  user_type ENUM('member', 'admin'),
  user_id INT NOT NULL,
  email VARCHAR(255) NOT NULL,
  is_used TINYINT(1) DEFAULT 0,
  used_at DATETIME NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  expires_at DATETIME NOT NULL
);
```

### institution_members Updates

New fields for email verification:
- `email_verified` - TINYINT(1) - 0/1 flag
- `email_verified_at` - DATETIME - when verified
- `verification_token` - VARCHAR(255) - token sent in email
- `verification_token_expires` - DATETIME - when it expires

---

## 🚀 Installation Steps

### Step 1: Install PHPMailer

```powershell
cd c:\xampp\htdocs\wamdevin

# Install composer packages
composer install

# Or update existing
composer update
```

### Step 2: Configure Email Settings

Edit `includes/db-config.php`:

```php
// Option A: Mailtrap (Testing)
define('SMTP_HOST', 'live.smtp.mailtrap.io');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-mailtrap-token');
define('SMTP_PASS', 'your-mailtrap-token');

// Option B: Gmail
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASS', 'your-app-password');

// Option C: Custom SMTP
define('SMTP_HOST', 'mail.yourdomain.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'no-reply@yourdomain.com');
define('SMTP_PASS', 'your-smtp-password');
```

### Step 3: Create Logs Directory

```powershell
New-Item -Type Directory -Path "c:\xampp\htdocs\wamdevin\logs\" -Force
chmod 755 logs/
```

### Step 4: Test Connection

Visit: `http://localhost/wamdevin/test-db.php`

Should show email configuration details.

### Step 5: Database Check

Ensure tables exist:
```sql
SELECT COUNT(*) FROM email_queue;
SELECT COUNT(*) FROM password_reset_tokens;
```

Both should return 0 (empty, but tables exist).

---

## 🧪 Testing Phase 3

### Test 1: Registration with Email

1. Visit: `http://localhost/wamdevin/register.php`
2. Fill form completely:
   - Institution: Test University
   - Country: Nigeria
   - Contact Person: John Doe
   - Email: john@testuniv.edu
   - Phone: +234 123 456 7890
   - Password: TestPass123!
3. Click Submit

**Expected:**
- ✅ Success message displayed
- ✅ Email queued to `email_queue` table
- ✅ Account created with `status = pending`
- ✅ Email sent via configured SMTP (check Mailtrap)

### Test 2: Email Verification

1. Check Mailtrap/email for verification message
2. Click verification link
3. Should redirect to `verify-email.php`

**Expected:**
- ✅ Success message
- ✅ Database: `email_verified = 1`
- ✅ Account status changed to `verified`
- ✅ Welcome email sent

### Test 3: Member Login

1. Visit: `http://localhost/wamdevin/login.php`
2. Enter verified email and password

**Expected:**
- ✅ Successful authentication
- ✅ Session created with user data
- ✅ Last login timestamp updated
- ✅ Activity logged

###  Test 4: Forgot Password

1. Visit: `http://localhost/wamdevin/forgot-password.php`
2. Enter registered email

**Expected:**
- ✅ Generic "email sent" message
- ✅ Reset token generated
- ✅ Password reset email sent
- ✅ Email in Mailtrap

### Test 5: Reset Password

1. Click password reset link from email
2. Validate token works
3. Enter new password
4.  Confirm password
5. Submit

**Expected:**
- ✅ Password updated in database
- ✅ Token marked as used
- ✅ Can login with new password
- ✅ Activity logged

### Test 6: Email Queue Processing

**Manual:**
```powershell
cd c:\xampp\htdocs\wamdevin
php process-email-queue.php
```

**Expected Output:**
```
[2026-02-20 14:30:15] Starting email queue processor
[2026-02-20 14:30:15] Found 3 pending emails
[2026-02-20 14:30:16] Processing email: verification to john@testuniv.edu
[2026-02-20 14:30:17] ✓ Sent: john@testuniv.edu - verification
```

---

## 🔧 Configuration Options

### Email Features Settings

Edit `includes/db-config.php`:

```php
// Email Features
define('EMAIL_VERIFICATION_REQUIRED', true);    // Require verification before login
define('EMAIL_VERIFICATION_TIMEOUT', 86400);    // 24 hours
define('PASSWORD_RESET_TIMEOUT', 3600);         // 1 hour
define('ENABLE_EMAIL_QUEUE', true);            // Use email queue system
define('EMAIL_QUEUE_BATCH_SIZE', 10);          // Process 10 at a time
```

### Email Service Levels

**Option 1: Development (Mailtrap)**
- Perfect for testing
- Free 50 emails/day
- No actual delivery
- See in web interface

**Option 2: Production (Gmail)**
- Free for WAMDEVIN
- Real email sending
- Needs app password
- Professional reputation

**Option 3: Enterprise (SendGrid)**
- High volume
- Advanced features
- Better deliverability
- Paid but scalable

---

## 📈 Monitoring & Maintenance

### Check Email Queue Status

```sql
-- Pending emails
SELECT COUNT(*) as pending FROM email_queue WHERE status = 'pending';

-- Today's sent emails
SELECT COUNT(*) as today_sent FROM email_queue 
WHERE status = 'sent' AND DATE(sent_at) = CURDATE();

-- Failed emails needing retry
SELECT * FROM email_queue WHERE status = 'failed' AND attempts < max_attempts;

-- Recently verified members
SELECT institution_name, email, email_verified_at FROM institution_members 
WHERE email_verified = 1 ORDER BY email_verified_at DESC LIMIT 10;
```

### Review Activity Logs

```sql
-- Email verification events
SELECT * FROM activity_logs WHERE action = 'email_verified' ORDER BY created_at DESC LIMIT 10;

-- Failed verification attempts
SELECT * FROM activity_logs WHERE action = 'failed_verification' ORDER BY created_at DESC;

-- Password resets
SELECT * FROM activity_logs WHERE action IN ('forgot_password_request', 'password_reset') 
ORDER BY created_at DESC LIMIT 10;
```

### Clean Up Expired Tokens

```sql
-- Delete expired verification tokens (older than 24 hours)
DELETE FROM password_reset_tokens 
WHERE created_at < DATE_SUB(NOW(), INTERVAL 24 HOUR);

-- Verify no old tokens remain
SELECT COUNT(*) FROM password_reset_tokens 
WHERE created_at < DATE_SUB(NOW(), INTERVAL 24 HOUR);
```

---

## 🐛 Troubleshooting

### "Email not sending"

**Check Steps:**
1. Is SMTP configured in `db-config.php`?
2. Are SMTP credentials correct?
3. Are emails in `email_queue` table with status 'pending'?
4. Check logs: `logs/email-queue.log`

**Solution:**
```powershell
# Test manually
php c:\xampp\htdocs\wamdevin\process-email-queue.php

# Check for error messages
Get-Content c:\xampp\htdocs\wamdevin\logs\email-queue.log -Tail 20
```

### "SMTP connection error"

**Possible Issues:**
- Firewall blocking port 587
- SMTP server down
- Wrong credentials

**Solution:**
- Try different port (25, 465, 587)
- Check internet connection
- Verify credentials in Mailtrap/Gmail
- Restart MySQL

### "Token validation fails"

**Check:**
1. Is token in correct email?
2. Has 24 hours passed?
3. Token in URL matches database?

**Solution:**
- Regenerate new token via resend-verification.php
- Check URL encoding (spaces vs %20)
- Clear browser cache

### "Email queue stuck"

**Check:**
```sql
SELECT * FROM email_queue WHERE status = 'pending' AND created_at < DATE_SUB(NOW(), INTERVAL 1 HOUR);
```

**Solution:**
- Run processor manually: `php process-email-queue.php`
- Check logs for error reason
- Verify SMTP still working
- Manually mark as failed if needed

---

## ⚙️ Cron Job Setup

### Automatic Email Processing

**For Linux/Mac Servers:**

Add to crontab:
```bash
# Process emails every hour
0 * * * * php /var/www/wamdevin/process-email-queue.php

# Or every 15 minutes (better for high volume)
*/15 * * * * php /var/www/wamdevin/process-email-queue.php
```

**For Windows Servers:**

Use Task Scheduler:
1. Open Task Scheduler
2. Create Basic Task
3. Name: "WAMDEVIN Email Queue"
4. Trigger: Hourly
5. Action: `php.exe c:\xampp\htdocs\wamdevin\process-email-queue.php`

---

## 🎓 Complete User Flow Examples

### Example 1: New Member Registration

```
1. User visits register.php
2. Fills form with institution details
3. Submits → register.php validates
4. Database INSERT to institution_members
5. EMAILService queues verification email
6. Email → email_queue table (pending)
7. User sees success message
8. process-email-queue.php sends email
9. User clicks link in email
10. verify-email.php marks email verified
11. welcome_email sent
12. User can now login
```

### Example 2: Password Reset

```
1. User visits forgot-password.php
2. Enters email address
3. Form submits → checks database
4. Creates reset token (valid 1 hour)
5. Sends password reset email
6. User clicks link from email
7. reset-password.php validates token
8. User enters new password
9. Password hashed and stored
10. Token marked as used
11. Login attempts reset
12. User can login with new password
```

### Example 3: Email Verification Failure

```
1. User registers on register.php
2. Doesn't receive email
3. Clicks "Resend verification" link in login
4. Visits resend-verification.php
5. Enters email address
6. New token generated and sent
7. Link valid for 24 hours again
8. User clicks new verification link
9. Account verified and activated
```

---

## 📚 API Reference

### EmailService Class

```php
// Send custom email
$service = new EmailService();
$result = $service->send(array(
    'to' => 'user@email.com',
    'to_name' => 'User Name',
    'subject' => 'Email Subject',
    'body' => '<h1>HTML Content</h1>',
    'reply_to' => 'support@wamdevin.org'
));

// Get email template
$html = EmailService::getTemplate(
    'Title',
    'Content HTML',
    'Button Text',      // optional
    'Button URL'        // optional
);

// Send verification email
$service->sendVerificationEmail($email, $name, $token, $app_url);

// Send password reset email
$service->sendPasswordResetEmail($email, $name, $token, $app_url);

// Send welcome email
$service->sendWelcomeEmail($email, $name, $institution, $login_url);

// Send suspension notice
$service->sendAccountSuspendedEmail($email, $name, $reason);
```

---

## ✅ Completion Checklist

Phase 3 is complete when:

- [ ] PHPMailer installed via Composer
- [ ] Mailtrap account created and configured
- [ ] SMTP credentials in `db-config.php`
- [ ] `logs/` directory created with write permissions
- [ ] Database tables exist (verify via phpMyAdmin)
- [ ] Registration sends verification email
- [ ] Verification email verifies account
- [ ] Forgot password sends reset email
- [ ] Password reset changes password
- [ ] Resend verification works
- [ ] Email queue processes correctly
- [ ] All emails appear in Mailtrap
- [ ] Member can login after verification
- [ ] Activity logs record all events

---

## 🎯 Success Criteria

✅ Email verification system functional  
✅ Password reset system working  
✅ Email queue processing correctly  
✅ All emails sent and logged  
✅ Security tokens (24h verification, 1h reset)  
✅ Account lockout still functional  
✅ Activity audit trail complete  
✅ Production-ready SMTP configuration  

**Phase 3 Status:** ✅ COMPLETE

---

## 🚀 Next Phase: Phase 4

When ready, Phase 4 will add:
- Two-factor authentication (2FA)
- Social login (Google, LinkedIn)
- Advanced account management
- Admin dashboard enhancements
- Member collaboration features
- REST API for mobile apps

---

## 📞 Support

**Common Issues:**
- See **Troubleshooting** section above
- Check error logs: `logs/email-queue.log`
- Review database tables for sync issues
- Test with `MAILTRAP-SETUP.md` guide

**Mailtrap Support:**
- https://mailtrap.io/docs/
- https://mailtrap.io/support

---

**Created:** February 20, 2026  
**Version:** 3.0  
**Status:** ✅ Production Ready

System is ready for Phase 3a or can proceed to Phase 4 advanced features.

For Mailtrap configuration: See **MAILTRAP-SETUP.md**
