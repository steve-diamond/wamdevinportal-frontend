# Mailtrap Setup Guide for WAMDEVIN Portal

**Status:** Testing Email Service Configuration  
**Date:** February 20, 2026  
**Service:** Mailtrap.io

---

## 🎯 What is Mailtrap?

Mailtrap is a free email testing service perfect for development and testing. It intercepts all emails sent from your application and displays them in a web interface without actually sending them.

**Benefits:**
- ✅ Free for development (50 emails/day free tier)
- ✅ No real emails sent (safe for testing)
- ✅ Easy integration (SMTP)
- ✅ Email preview and inspection
- ✅ Perfect for Phase 3 development

---

## 📋 Sign Up for Mailtrap (5 Minutes)

### Step 1: Create Account
1. Visit: https://mailtrap.io/
2. Click "Sign Up for Free"
3. Enter email and create password
4. Click confirmation link in email

### Step 2: Create Inbox
1. Log in to Mailtrap
2. Go to "Inboxes" on left sidebar
3. Click "+ Create Inbox"
4. Name it: `WAMDEVIN Development`
5. Click "Create Inbox"

### Step 3: Get SMTP Credentials
1. In your new inbox, click "Settings" (gear icon)
2. Click "SMTP Credentials" tab
3. You'll see credentials like:

```
Host: live.smtp.mailtrap.io
Port: 587
Username: YOUR_API_TOKEN
Password: YOUR_API_TOKEN
```

💾 **Copy these credentials - you'll need them next!**

---

## 🔧 Configure WAMDEVIN for Mailtrap

### Step 1: Update Database Configuration

Edit: `includes/db-config.php`

Replace the email settings section:

```php
// Mailtrap Settings (Testing Environment)
define('SMTP_HOST', 'live.smtp.mailtrap.io');   // Mailtrap live domain
define('SMTP_PORT', 587);                        // TLS port
define('SMTP_USER', 'YOUR_API_TOKEN');          // Paste your token here
define('SMTP_PASS', 'YOUR_API_TOKEN');          // Same token (for Mailtrap)

// Email Features
define('EMAIL_VERIFICATION_REQUIRED', true);
define('EMAIL_VERIFICATION_TIMEOUT', 86400);    // 24 hours
define('PASSWORD_RESET_TIMEOUT', 3600);         // 1 hour
define('ENABLE_EMAIL_QUEUE', true);
define('EMAIL_QUEUE_BATCH_SIZE', 10);
```

### Step 2: Replace with Your Token

Use these exact values from Mailtrap:
- `SMTP_HOST`: Always `live.smtp.mailtrap.io`
- `SMTP_PORT`: Always `587`
- `SMTP_USER`: Your API token from Mailtrap
- `SMTP_PASS`: Same API token (Mailtrap uses same for both)

**Example:**
```php
define('SMTP_USER', 'abc123def456ghi789');
define('SMTP_PASS', 'abc123def456ghi789');
```

### Step 3: Create Logs Directory

Create this folder for email queue logs:
```
c:\xampp\htdocs\wamdevin\logs\
```

Windows PowerShell:
```powershell
New-Item -Type Directory -Path "c:\xampp\htdocs\wamdevin\logs\" -Force
```

---

## ✅ Test Connection

### Test 1: Verify SMTP Settings

Visit: `http://localhost/wamdevin/test-db.php`

Should show email configuration details.

### Test 2: Send Test Email

Method A - Via registration:
1. Visit: `http://localhost/wamdevin/register.php`
2. Fill form with test data
3. Submit registration
4. Check Mailtrap inbox

Method B - Via forgot password:
1. Visit: `http://localhost/wamdevin/forgot-password.php`
2. Enter test email
3. Check Mailtrap inbox

### Test 3: Check Mailtrap Inbox

1. Go to Mailtrap.io
2. Open your `WAMDEVIN Development` inbox
3. You should see test emails:
   - "Email Verification - WAMDEVIN Institution Portal"
   - "Password Reset Request - WAMDEVIN Portal"
   - etc.

---

## 🚀 Full Email System Testing

### Test 1: Registration with Verification

**Steps:**
1. Visit `http://localhost/wamdevin/register.php`
2. Fill entire form:
   ```
   Institution: Test Academy
   Country: Ghana
   Contact: John Doe
   Email: test@academy.org
   Phone: +233 123 456 7890
   Password: TestPassword123!
   ```
3. Click Submit
4. Check Mailtrap for verification email

**Expected:**
- ✅ Email arrives in Mailtrap
- ✅ Subject: "Email Verification - WAMDEVIN Institution Portal"
- ✅ Contains verification link
- ✅ Database shows `status = pending`

### Test 2: Email Verification

**Steps:**
1. Open verification email in Mailtrap
2. Click the verification link
3. Should redirect to `verify-email.php`

**Expected:**
- ✅ Shows success message
- ✅ Database: `email_verified = 1`, `status = verified`
- ✅ Welcome email sent

### Test 3: Member Login

**Steps:**
1. After email verified, visit `http://localhost/wamdevin/login.php`
2. Enter email and password from registration
3. Click Login

**Expected:**
- ✅ Login succeeds
- ✅ Session created
- ✅ Redirects to portal

### Test 4: Forgot Password

**Steps:**
1. Visit `http://localhost/wamdevin/forgot-password.php`
2. Enter test email
3. Check Mailtrap

**Expected:**
- ✅ Password reset email arrives
- ✅ Subject: "Password Reset Request - WAMDEVIN Portal"
- ✅ Contains reset link (1-hour expiry)

### Test 5: Reset Password

**Steps:**
1. Open password reset email in Mailtrap
2. Click reset link
3. Enter new password
4. Submit

**Expected:**
- ✅ Password updated
- ✅ Can login with new password
- ✅ Activity logged

---

## 📧 Email Types Generated

The system automatically sends these emails:

| Email Type | Trigger | Status | Content |
|------------|---------|--------|---------|
| Verification | User registers | ✅ Working | Verification link + instructions |
| Welcome | Email verified | ✅ Working | Account activated message |
| Password Reset | Forgot password | ✅ Working | Reset link (1hr expiry) |
| Account Suspended | Admin action | ✅ Ready | Suspension notice |

---

## 🔍 Inspecting Emails in Mailtrap

### How to View Sent Emails:

1. Login to Mailtrap.io
2. Click inbox
3. Click email to view:
   - HTML version (what users see)
   - Plain text version
   - Raw headers
   - Links tested for validity

### Check Email Details:
- From address
- Reply-to address
- Subject line
- HTML rendering
- Links (clickable)
- Sender information

---

## 🐛 Troubleshooting

### "Email not appearing in Mailtrap"

**Check:**
1. Credentials correct in `db-config.php`?
2. SMTP_HOST exactly: `live.smtp.mailtrap.io`
3. SMTP_PORT exactly: `587`
4. Inbox is active in Mailtrap dashboard?

**Solution:**
- Verify token in Mailtrap (might have multiple inboxes)
- Check `logs/email-queue.log` for errors
- Test with manual registration

### "SMTP connection refused"

**Possible:**
- Internet connection issue
- Mailtrap server down (rare)
- Firewall blocking port 587

**Solution:**
- Check internet connection
- Try port 25 instead of 587 (slower but works)
- Check firewall settings
- Restart MySQL and PHP

### "Token invalid"

**Solution:**
1. Go to Mailtrap.io
2. Settings → SMTP Credentials
3. Copy exact token
4. Paste into `db-config.php` (both USER and PASS)
5. Re-test

### "Emails in queue but not sent"

Check if processor is running:
```powershell
cd c:\xampp\htdocs\wamdevin
php process-email-queue.php
```

Should output:
```
[2026-02-20 14:30:15] Starting email queue processor
[2026-02-20 14:30:15] Found 3 pending emails
[2026-02-20 14:30:16] ✓ Sent: test@edu.org - verification
...
```

---

## 🔄 Email Queue Processing

### What is It?

Emails are queued (stored in database) then sent in batches to prevent server overload.

### Manual Processing

Run anytime:
```powershell
php c:\xampp\htdocs\wamdevin\process-email-queue.php
```

### Automatic Processing (Cron)

Add to server cron (runs every hour):
```bash
0 * * * * php /var/www/wamdevin/process-email-queue.php
```

### Check Queue Status

In PhpMyAdmin:
```sql
SELECT * FROM email_queue ORDER BY created_at DESC LIMIT 10;
```

Shows:
- `status`: pending, sent, or failed
- `attempts`: how many times tried
- `error_message`: why it failed (if any)

---

## 🎓 Phase 3 Integration Checklist

- [ ] Mailtrap account created
- [ ] SMTP credentials obtained
- [ ] `db-config.php` updated with Mailtrap token
- [ ] `logs/` directory created
- [ ] PHPMailer installed (or fallback working)
- [ ] Test registration completed
- [ ] Verification email verified in Mailtrap
- [ ] Member login successful
- [ ] Forgot password tested
- [ ] Password reset completed
- [ ] Error emails properly logged

---

## 📊 Monitoring Emails

### View Statistics in Mailtrap:

Dashboard shows:
- Total emails received
- Success rate
- Failed deliveries (if any)
- Email types breakdown

### Export Email History:

Download CSV of all emails sent for records.

---

## 🔐 Security Notes

**MailTrap is for TESTING ONLY!**

### For Production:

Change to real email service:
- **Gmail:** Use app password
- **SendGrid:** Enterprise SMTP
- **AWS SES:** High volume production
- **Custom:** Your own mail server

### Update Credentials:

```php
// Production:
define('SMTP_HOST', 'smtp.gmail.com');        // or other service
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-real-email@gmail.com');
define('SMTP_PASS', 'app-password-token');
```

---

## 📚 Next Steps

1. ✅ Mailtrap configured
2. ✅ All emails tested
3. Next: Production deployment
   - Switch to real email service
   - Setup cron job for email queue
   - Configure server SMTP
   - Test end-to-end

---

## 📞 Support

**Mailtrap Help:**
- https://mailtrap.io/docs/
- Community forums: https://mailtrap.io/

**WAMDEVIN Issues:**
- Check `logs/email-queue.log`
- Review `activity_logs` table
- Check `email_queue` table status

---

## 💡 Tips & Tricks

### Reset Mailtrap Inbox
Clear all test emails to start fresh:
1. Click inbox
2. Select all emails
3. Click delete
4. Confirms deletion

### Multiple Test Emails
Create multiple inboxes for different purposes:
- `WAMDEVIN Development`
- `WAMDEVIN Testing`
- `WAMDEVIN Staging`

### Email Forwarding
Mailtrap can forward to real email (premium feature).

### Team Sharing
Invite team members to view emails (premium feature).

---

**Created:** February 20, 2026  
**Service:** Mailtrap.io  
**Status:** ✅ Ready for Testing

For full Phase 3 documentation, see: **PHASE3-DEPLOYMENT.md**
