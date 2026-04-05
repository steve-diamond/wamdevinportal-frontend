# WAMDEVIN Portal System - Phase 2 Database Implementation Guide

**Status:** Phase 2 - Database Integration  
**Date:** February 20, 2026  
**Version:** 2.0

---

## 📋 Table of Contents

1. [Quick Start](#quick-start)
2. [Prerequisites](#prerequisites)
3. [Database Setup](#database-setup)
4. [Configuration](#configuration)
5. [Testing](#testing)
6. [Registration Flow](#registration-flow)
7. [Login Flow](#login-flow)
8. [Security Features](#security-features)
9. [Troubleshooting](#troubleshooting)
10. [Next Steps](#next-steps)

---

## 🚀 Quick Start

**5-Minute Setup:**

1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Create database: `wamdevin_portal`
3. Go to SQL tab, paste and execute contents of `database/schema.sql`
4. Visit test page: `http://localhost/wamdevin/test-db.php`
5. Verify green checkmarks

**Done!** Registration and login now work with the database.

---

## ✅ Prerequisites

### Minimum Requirements
- **PHP:** 5.6+ (tested on 7.x, 8.x)
- **MySQL:** 5.5+ (or MariaDB 10+)
- **XAMPP:** Current version with PHP and MySQL
- **Python:** Not required (only for asset optimization)

### Required PHP Extensions
- ✅ PDO (PHP Data Objects)
- ✅ PDO MySQL Driver
- ✅ JSON Extension
- ✅ mbstring Extension
- ✅ filter Extension

**Check Your Installation:**
Visit `http://localhost/wamdevin/test-db.php` - all extensions should show ✓

---

## 🗄️ Database Setup

### Step 1: Create Database via phpMyAdmin

```
1. Open http://localhost/phpmyadmin in your browser
2. Look for "New" or database creation section
3. Create database named: wamdevin_portal
4. Charset: utf8mb4
5. Collation: utf8mb4_unicode_ci
```

### Step 2: Import Database Schema

**Method A: Using phpMyAdmin (Recommended)**

```
1. Select the wamdevin_portal database
2. Click "Import" tab
3. Choose file: database/schema.sql
4. Click "Go"
5. Wait for success message
```

**Method B: Using MySQL Command Line**

```bash
mysql -u root -p < database/schema.sql
```

(If running in XAMPP on Windows):
```powershell
cd c:\xampp\mysql\bin
mysql -u root < c:\xampp\htdocs\wamdevin\database\schema.sql
```

### Step 3: Verify Tables Created

Visit `http://localhost/wamdevin/test-db.php` and verify:
- ✅ institution_members table exists
- ✅ admin_users table exists
- ✅ activity_logs table exists

---

## ⚙️ Configuration

### Database Connection File

**Location:** `includes/db-config.php`

This file contains all database configuration. Modify these lines if needed:

```php
define('DB_HOST', 'localhost');      // MySQL server hostname
define('DB_USER', 'root');           // MySQL username
define('DB_PASS', '');               // MySQL password (empty for XAMPP default)
define('DB_NAME', 'wamdevin_portal'); // Database name
define('DB_PORT', 3306);             // MySQL port (default: 3306)
```

### Session & Security Settings

```php
define('SESSION_TIMEOUT_ADMIN', 3600);    // 1 hour - admin sessions
define('SESSION_TIMEOUT_MEMBER', 7200);   // 2 hours - member sessions
define('PASSWORD_MIN_LENGTH', 8);         // Minimum password characters
```

### Email Settings (For Phase 3)

```php
define('MAIL_FROM', 'noreply@wamdevin.org');
define('SMTP_HOST', 'smtp.gmail.com');     // Configure when ready
define('SMTP_USER', '');                   // Add your email
define('SMTP_PASS', '');                   // Add app password
```

---

## 🧪 Testing

### Test 1: Database Connection

**URL:** `http://localhost/wamdevin/test-db.php`

**Checks:**
- ✅ PHP version compatible
- ✅ Required extensions loaded
- ✅ Database connected
- ✅ Tables exist
- ✅ Sample data loaded

**Expected Result:** All items should show green ✓

### Test 2: User Registration

**URL:** `http://localhost/wamdevin/register.php`

**Test Data:**
```
Institution Name: Test University
Country: Nigeria
Contact Person: Test Manager
Email: test@testuniversity.edu
Phone: +234 123 456 7890
Password: SecurePass123!
Confirm: SecurePass123!
```

**Expected Result:**
```
✓ Registration successful! 
✓ Verification email queued
✓ Account created with 'pending' status
```

### Test 3: Admin Login

**URL:** `http://localhost/wamdevin/admin/login.php`

**Demo Credentials** (from schema.sql):
```
Email: admin@wamdevin.org
Password: [Use one from schema.sql sample data]
```

**Note:** Sample admin password hash is included in schema.sql. 
To set a custom password:

```sql
UPDATE admin_users 
SET password_hash = '$2y$12$[HASH]'
WHERE email = 'admin@wamdevin.org';
```

To generate bcrypt hash in PHP:
```php
<?php
echo password_hash('YourPassword123!', PASSWORD_BCRYPT);
?>
```

### Test 4: Member Login

**URL:** `http://localhost/wamdevin/login.php`

**Test Data** (from sample data in schema.sql):
```
Email: admin@unilag.edu.ng
Password: password123 (matches hash in sample)
```

---

## 📝 Registration Flow

### Step-by-Step Process

1. **User visits** `register.php`

2. **Form validation** occurs:
   - Required fields check
   - Email format validation
   - Password strength check (8+ chars, mixed case, numbers, symbols)
   - Password confirmation match

3. **Database checks**:
   - Email uniqueness (prevent duplicates)
   - Institution name uniqueness

4. **Password hashing**:
   - Uses bcrypt with cost factor 12
   - Secure against rainbow tables

5. **Data insertion**:
   - Creates record in `institution_members` table
   - Status: `pending` (awaiting email verification)
   - Generates verification token

6. **Email queue**:
   - Queues verification email to `email_queue` table
   - Email sent in Phase 3 with cron job

7. **Success page**:
   - Shows confirmation message
   - Instructs user to check email

### Database Record Created

```sql
-- New record in institution_members:
INSERT INTO institution_members (
  institution_name,           -- Provided by user
  country,                    -- Provided by user
  contact_person_name,        -- Provided by user
  email,                      -- Provided by user
  phone,                      -- Provided by user
  password_hash,              -- Bcrypt hash of password
  verification_token,         -- Random 64-char hex
  verification_token_expires, -- NOW() + 24 hours
  status,                     -- 'pending'
  ip_address,                 -- User's IP
  created_at                  -- Current timestamp
) VALUES (...);
```

---

## 🔐 Login Flow

### Institution Member Login (login.php)

1. **User provides** email and password
2. **Email validation** (format check)
3. **Database lookup** by email
4. **Account checks**:
   - Account not locked? (5 failed attempts = 30 min lock)
   - Email verified? (requires verification)
   - Account status = verified? (not suspended)
5. **Password verification** using bcrypt
6. **Success**:
   - Reset failed login attempts
   - Update `last_login` timestamp
   - Log activity: "login"
   - Start secure session
   - Redirect to `portal.php`

### Error Handling

```
❌ Invalid email or password       → Generic (security)
❌ Email not verified              → Shows resend link
❌ Account temporarily locked      → Shows countdown
❌ Account suspended               → Contact support message
```

### Admin Login (admin/login.php)

1. **User provides** email and password
2. **CSRF token validation** (protect against attacks)
3. **Database lookup** by email
4. **Same checks as member** (lock status, account active, etc.)
5. **2FA Support**:
   - If enabled: redirect to 2FA verification page
   - If disabled: proceed to step 6
6. **Success**:
   - Record admin role, name, IP
   - Log activity with role: "login [superadmin]"
   - Start secure admin session
   - Redirect to `admin/index.php`

---

## 🛡️ Security Features Implemented

### Password Security

```php
// Bcrypt hashing with cost factor 12
$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

// Verification
$valid = password_verify($input, $stored_hash);
```

**Why bcrypt?**
- Slow by design (prevents brute force)
- Automatic salt generation
- Cost factor allows increasing difficulty over time

### Account Protection

| Feature | Details |
|---------|---------|
| Failed Login Attempts | 5 attempts → 30 minute lock |
| Email Verification | Required before account use |
| Password Requirements | Min 8 chars, mixed case, numbers, symbols |
| Session Timeout | 1 hour (admin), 2 hours (member) |
| IP Address Tracking | Detect session hijacking |
| CSRF Protection | Token validation on forms |
| Activity Logging | All logins/failures logged |

### Input Validation

```php
// Sanitization
$email = strtolower(trim($email));          // Normalize email
$institution = sanitize($institution_name); // HTML escape

// Validation
isValidEmail($email);                       // Format check
validatePasswordStrength($password);        // Strength check
isEmailAvailable($email, 'member');        // Uniqueness check
```

### Database Security

```php
// Prepared statements prevent SQL injection
$stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute([':email' => $email]);

// NO string concatenation in queries!
// Always use :placeholders instead
```

---

## 🔧 Troubleshooting

### "Database connection failed"

**Possible causes:**

1. **MySQL not running**
   ```powershell
   # XAMPP Control Panel
   # Click "Start" next to MySQL
   ```

2. **Wrong credentials in db-config.php**
   ```php
   // Verify these match your MySQL setup:
   define('DB_USER', 'root');  // Often 'root' in XAMPP
   define('DB_PASS', '');      // Often empty in XAMPP
   ```

3. **Database doesn't exist**
   ```php
   // Create via phpMyAdmin or:
   mysql -u root -e "CREATE DATABASE wamdevin_portal CHARACTER SET utf8mb4;"
   ```

### "Table not found" error

**Solution:**
1. Open phpMyAdmin
2. Select `wamdevin_portal` database
3. Go to SQL tab
4. Paste contents of `database/schema.sql`
5. Click Go

### "Password hash mismatch" in admin login

**Issue:** Sample admin account doesn't work

**Solution:**
```sql
-- Generate new hash in PHP first:
-- echo password_hash('YourPassword123!', PASSWORD_BCRYPT);

-- Then update:
UPDATE admin_users 
SET password_hash = '$2y$12$[PASTE_YOUR_HASH_HERE]'
WHERE email = 'admin@wamdevin.org';
```

### Registration email not queued

**Verify:**
1. Check `email_queue` table has a pending entry
2. Check `activity_logs` for 'registration' entry
3. See Phase 3 for email sending setup

### Session not persisting

**Check:**
1. `test-db.php` shows session support
2. Browser accepts cookies
3. File permissions allow temporary files
4. Session timeout hasn't expired

---

## 📧 Email Verification Setup (Phase 3)

### Current State

- ✅ Verification tokens generated and stored
- ✅ Tokens expire after 24 hours
- ✅ Email queued to `email_queue` table
- ⏳ Email sending not yet implemented

### What's Queued

```sql
SELECT * FROM email_queue WHERE status = 'pending';
-- Shows all unsent verification emails
```

### Phase 3 Tasks

1. **Configure SMTP** in db-config.php
2. **Create email sender** script
3. **Create verification page** (verify-email.php)
4. **Setup cron job** to process email queue
5. **Implement email resend** functionality

---

## 🎯 Dashboard & Portal Pages

### Member Portal (Not yet created - Phase 2b)

**URL:** `portal.php` - Create this file for logged-in member features:
- Dashboard with institution info
- Member directory search
- Training requests
- Profile management
- Collaboration opportunities

### Admin Dashboard (Exists but uses demo data - Phase 2b)

**URL:** `admin/index.php` - Currently shows demo UI:
- Member management
- Report generation
- System settings
- Activity monitoring

---

## 📊 Database Schema Overview

### institution_members Table

```
✓ id (PRIMARY KEY)
✓ institution_name (UNIQUE, name of institution)
✓ country (Country of institution)
✓ contact_person_name (Primary contact)
✓ email (UNIQUE, for login)
✓ phone (Contact number)
✓ password_hash (Bcrypt encrypted)
✓ status (pending|verified|suspended)
✓ email_verified (0=no, 1=yes)
✓ verification_token (64-char hex, expires in 24h)
✓ login_attempts (Track failed login attempts)
✓ locked_until (Account lockout timestamp)
✓ last_login (Last successful login time)
✓ created_at / updated_at (Audit timestamps)
```

### admin_users Table

```
✓ id (PRIMARY KEY)
✓ admin_name (Full name of admin)
✓ email (UNIQUE, for login)
✓ role (superadmin|admin|facilitator|coordinator)
✓ password_hash (Bcrypt encrypted)
✓ status (active|inactive|suspended)
✓ two_factor_enabled (0=no, 1=yes, ready for Phase 4)
✓ login_attempts (Track failed attempts)
✓ locked_until (30-min lockout after 5 failures)
✓ last_login (Timestamp)
✓ last_ip_login (IP address of last login)
✓ Permissions (manage_members, manage_admins, etc.)
✓ created_at / updated_at (Audit)
```

### activity_logs Table

```
✓ id (PRIMARY KEY)
✓ action (login, logout, registration, failed_login)
✓ user_type (member|admin)
✓ user_id (Reference to member/admin)
✓ details (Additional info)
✓ ip_address (User's IP)
✓ user_agent (Browser info)
✓ created_at (When it happened)
```

---

## 🔄 Function Reference

### Core Database Functions (in db-config.php)

#### Connection Management
```php
getDBConnection()              // Get PDO connection
```

#### Query Execution
```php
executeDatabaseQuery($sql, $params)  // Run query
getDBRecord($sql, $params)           // Get one row
getDBRecords($sql, $params)          // Get all rows
```

#### Security Functions
```php
hashPassword($password)              // Hash password (bcrypt)
verifyPassword($input, $hash)        // Check password
isEmailAvailable($email, $type)      // Check if email in use
isValidEmail($email)                 // Validate format
validatePasswordStrength($password)  // Check password quality
sanitize($data)                      // HTML escape
generateCSRFToken()                  // Create CSRF token
verifyCSRFToken($token)              // Validate CSRF
```

#### Session Management
```php
startSecureSession($type, $id, $email)  // Start login session
isSessionValid()                         // Check if session valid
logoutUser()                             // Destroy session
```

#### Activity Logging
```php
logActivity($action, $type, $id, $details)  // Log user action
```

---

## 📈 Testing Checklist

### Before Production Deployment

- [ ] Database connection test passes
- [ ] User can register with all validations working
- [ ] Admin can login with correct credentials
- [ ] Member can login with correct credentials
- [ ] Failed login attempts properly tracked
- [ ] Account lockout after 5 failures works
- [ ] Activity logs record all actions
- [ ] Emails queue to email_queue table (Phase 3)
- [ ] Session timeout works correctly
- [ ] CSRF tokens validate properly
- [ ] Password hashing uses bcrypt
- [ ] All form inputs sanitized
- [ ] Error messages don't leak sensitive info

---

## 🚀 Next Steps

### Immediate (Phase 2b - Admin/Member Dashboards)

```
1. Create portal.php for member dashboard
   - Show institution info
   - Allow profile editing
   - Display member directory

2. Enhance admin/index.php functionality
   - Member management interface
   - Report generation
   - System status dashboard
```

### Short Term (Phase 3 - Email System)

```
1. Configure SMTP settings
2. Create email sending service
3. Build verify-email.php page
4. Create forgot-password flow
5. Setup email queue processor (cron job)
```

### Medium Term (Phase 4 - Advanced Features)

```
1. Implement 2FA for admin accounts
2. Add social login (Google, LinkedIn)
3. Create member collaboration features
4. Build REST API for mobile apps
5. Implement activity dashboard
```

### Long Term (Phase 5 - Scale)

```
1. Single Sign-On (SSO) for institutions
2. Integration with university systems
3. Mobile native apps
4. Advanced analytics
5. Multi-language support
```

---

## 📞 Support & Maintenance

### Error Logging

All errors logged to:
- PHP Error Log: System logs (check with server admin)
- Activity Logs: Table `activity_logs` (query with SQL)
- Database Errors: Check MySQL error log

### Regular Maintenance

**Weekly:**
- Check `email_queue` table for stuck emails
- Review `activity_logs` for suspicious patterns
- Monitor failed login attempts

**Monthly:**
- Clean up old password reset tokens (> 1 day old)
- Review admin accounts (remove inactive)
- Backup `wamdevin_portal` database

**Security:**
- Update password hash cost if needed (currently 12)
- Review CORS settings if using API
- Audit file permissions
- Update PHP and MySQL when security patches released

---

## 📚 Files Summary

### New Files Created (Phase 2)

| File | Purpose |
|------|---------|
| `includes/db-config.php` | Database configuration & helper functions |
| `database/schema.sql` | Database schema and sample data |
| `test-db.php` | Connection testing interface |
| `PHASE2-DEPLOYMENT.md` | This guide |

### Updated Files (Phase 2)

| File | Changes |
|------|---------|
| `register.php` | Added database registration logic |
| `login.php` | Added member authentication |
| `admin/login.php` | Added admin authentication |

### Unchanged (To Create in Phase 2b)

| File | Purpose |
|------|---------|
| `portal.php` | Member dashboard (TBD) |
| `admin/index.php` | Admin dashboard (exists, needs enhancement) |
| `verify-email.php` | Email verification (Phase 3) |
| `forgot-password.php` | Password recovery (Phase 3) |

---

## 📞 Questions?

**Common Issues:**
- Database connection: See [Troubleshooting](#troubleshooting) section
- Registration not working: Run test-db.php first
- Login failing: Verify email verified in database
- Email not sending: Email configuration in Phase 3

**Need Help:**
- Check error messages in alert boxes (usually show solution)
- Review server logs
- Contact system administrator

---

## ✅ Completion Checklist

- [x] Database configuration created
- [x] Database schema defined
- [x] Registration form integrated with database
- [x] Member login implemented
- [x] Admin login implemented
- [x] Password hashing (bcrypt) configured
- [x] Account lockout protection enabled
- [x] Activity logging system ready
- [x] Session management implemented
- [x] CSRF protection added
- [x] Email queue system ready (pending SMTP config)
- [x] Test page created
- [x] Documentation complete

**Status:** ✅ Phase 2 Database Implementation Complete

**Ready for:** Phase 3 Email System Integration

---

**Last Updated:** February 20, 2026  
**Version:** 2.0  
**Created by:** WAMDEVIN Development Team
