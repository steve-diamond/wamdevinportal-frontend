-- ========================================================================
-- WAMDEVIN Portal System - Database Schema
-- 
-- This file creates all necessary tables for the Portal System
-- Database: wamdevin_portal
-- Created: February 20, 2026
-- ========================================================================

-- ========================================================================
-- 1. CREATE DATABASE
-- ========================================================================

CREATE DATABASE IF NOT EXISTS `wamdevin_portal` 
  CHARACTER SET utf8mb4 
  COLLATE utf8mb4_unicode_ci;

USE `wamdevin_portal`;

-- ========================================================================
-- 2. INSTITUTION MEMBERS TABLE
-- ========================================================================

CREATE TABLE IF NOT EXISTS `institution_members` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  
  -- Institution Information
  `institution_name` VARCHAR(255) NOT NULL UNIQUE,
  `country` VARCHAR(100) NOT NULL,
  
  -- Contact Information
  `contact_person_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `phone` VARCHAR(20) NOT NULL,
  
  -- Account Security
  `password_hash` VARCHAR(255) NOT NULL,
  
  -- Account Status
  `status` ENUM('pending', 'verified', 'suspended') DEFAULT 'pending',
  `email_verified` TINYINT(1) DEFAULT 0,
  `email_verified_at` DATETIME NULL,
  `verification_token` VARCHAR(255) NULL,
  `verification_token_expires` DATETIME NULL,
  
  -- Password Reset
  `reset_token` VARCHAR(255) NULL,
  `reset_token_expires` DATETIME NULL,
  
  -- Login Information
  `last_login` DATETIME NULL,
  `login_attempts` INT DEFAULT 0,
  `locked_until` DATETIME NULL,
  
  -- System Fields
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME NULL,
  `ip_address` VARCHAR(45) NULL,
  
  -- Indexes for performance
  INDEX idx_email (email),
  INDEX idx_institution (institution_name),
  INDEX idx_status (status),
  INDEX idx_created (created_at)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 3. ADMIN USERS TABLE
-- ========================================================================

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  
  -- Admin Information
  `admin_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `role` ENUM('superadmin', 'admin', 'facilitator', 'coordinator') DEFAULT 'admin',
  
  -- Account Security
  `password_hash` VARCHAR(255) NOT NULL,
  
  -- Account Status
  `status` ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
  `two_factor_enabled` TINYINT(1) DEFAULT 0,
  `two_factor_secret` VARCHAR(255) NULL,
  
  -- Login Information
  `last_login` DATETIME NULL,
  `login_attempts` INT DEFAULT 0,
  `locked_until` DATETIME NULL,
  `last_ip_login` VARCHAR(45) NULL,
  
  -- Permissions
  `can_manage_members` TINYINT(1) DEFAULT 1,
  `can_manage_admins` TINYINT(1) DEFAULT 0,
  `can_view_reports` TINYINT(1) DEFAULT 1,
  `can_export_data` TINYINT(1) DEFAULT 0,
  
  -- System Fields
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME NULL,
  
  -- Indexes
  INDEX idx_email (email),
  INDEX idx_role (role),
  INDEX idx_status (status),
  INDEX idx_created (created_at)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 4. ACTIVITY LOGS TABLE
-- ========================================================================

CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  
  -- Log Information
  `action` VARCHAR(100) NOT NULL,
  `user_type` ENUM('member', 'admin') NOT NULL,
  `user_id` INT NOT NULL,
  `details` TEXT NULL,
  
  -- Request Information
  `ip_address` VARCHAR(45) NULL,
  `user_agent` TEXT NULL,
  
  -- Timestamps
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  
  -- Indexes for fast queries
  INDEX idx_user (user_type, user_id),
  INDEX idx_action (action),
  INDEX idx_created (created_at)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 5. EMAIL VERIFICATION QUEUE TABLE (Optional - for delayed email sending)
-- ========================================================================

CREATE TABLE IF NOT EXISTS `email_queue` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  
  -- Email Details
  `to_email` VARCHAR(255) NOT NULL,
  `to_name` VARCHAR(255) NULL,
  `subject` VARCHAR(255) NOT NULL,
  `body` LONGTEXT NOT NULL,
  `email_type` ENUM('verification', 'password_reset', 'notification', 'welcome') DEFAULT 'notification',
  
  -- Status
  `status` ENUM('pending', 'sent', 'failed') DEFAULT 'pending',
  `attempts` INT DEFAULT 0,
  `max_attempts` INT DEFAULT 3,
  
  -- System Fields
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `sent_at` DATETIME NULL,
  `error_message` TEXT NULL,
  
  -- Indexes
  INDEX idx_status (status),
  INDEX idx_email (to_email),
  INDEX idx_type (email_type),
  INDEX idx_created (created_at)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 6. PASSWORD RESET TOKENS TABLE
-- ========================================================================

CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  
  -- Token Information
  `token` VARCHAR(255) NOT NULL UNIQUE,
  `user_type` ENUM('member', 'admin') NOT NULL,
  `user_id` INT NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  
  -- Status
  `is_used` TINYINT(1) DEFAULT 0,
  `used_at` DATETIME NULL,
  
  -- Expiration
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `expires_at` DATETIME NOT NULL,
  
  -- Indexes
  INDEX idx_token (token),
  INDEX idx_user (user_type, user_id),
  INDEX idx_expires (expires_at),
  INDEX idx_used (is_used)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 7. EVENTS TABLE
-- ========================================================================

CREATE TABLE IF NOT EXISTS `events` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `location` VARCHAR(255) NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NULL,
  `status` ENUM('planned', 'confirmed', 'completed', 'cancelled') DEFAULT 'planned',
  `description` TEXT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  INDEX idx_status (status),
  INDEX idx_start_date (start_date)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 8. TRAININGS TABLE
-- ========================================================================

CREATE TABLE IF NOT EXISTS `trainings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `location` VARCHAR(255) NULL,
  `delivery_mode` ENUM('in_person', 'virtual', 'hybrid') DEFAULT 'in_person',
  `start_date` DATE NOT NULL,
  `end_date` DATE NULL,
  `status` ENUM('planned', 'active', 'completed', 'cancelled') DEFAULT 'planned',
  `description` TEXT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  INDEX idx_status (status),
  INDEX idx_start_date (start_date)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 9. PUBLICATIONS TABLE
-- ========================================================================

CREATE TABLE IF NOT EXISTS `publications` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `category` VARCHAR(120) NULL,
  `status` ENUM('draft', 'under_review', 'published', 'archived') DEFAULT 'draft',
  `published_at` DATE NULL,
  `description` TEXT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  INDEX idx_status (status),
  INDEX idx_published_at (published_at)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 10. CREATE TRIGGERS FOR AUTOMATIC TIMESTAMP UPDATES
-- ========================================================================

-- Trigger for institution_members updated_at
DELIMITER //
CREATE TRIGGER institution_members_update_trigger
BEFORE UPDATE ON institution_members
FOR EACH ROW
SET NEW.updated_at = CURRENT_TIMESTAMP;
//
DELIMITER ;

-- Trigger for admin_users updated_at
DELIMITER //
CREATE TRIGGER admin_users_update_trigger
BEFORE UPDATE ON admin_users
FOR EACH ROW
SET NEW.updated_at = CURRENT_TIMESTAMP;
//
DELIMITER ;

-- ========================================================================
-- 11. CREATE DEFAULT ADMIN USER (Optional - comment out for production)
-- ========================================================================

-- Password: Admin@12345 (bcrypt hash)
-- Note: Generate actual hash with PHP: password_hash('Admin@12345', PASSWORD_BCRYPT)
-- For testing, use: $2y$12$s6LSs0pzCWAXoLx2vXhCJe3oZZlZxN0A/xZZlZxN0A... (full hash)

INSERT INTO `admin_users` (
  `admin_name`,
  `email`,
  `role`,
  `password_hash`,
  `status`,
  `can_manage_members`,
  `can_manage_admins`,
  `can_view_reports`,
  `can_export_data`
) VALUES (
  'Super Administrator',
  'admin@wamdevin.org',
  'superadmin',
  '$2y$12$8dGIlZrPa8O2nQvQvQvQva1aZ1aZ1aZ1aZ1aZ1aZ1aZ1aZ1aZ1', -- CHANGE THIS!
  'active',
  1,
  1,
  1,
  1
);

-- ========================================================================
-- 12. CREATE VIEWS FOR COMMON QUERIES
-- ========================================================================

-- View: Active Members Summary
CREATE OR REPLACE VIEW active_members_summary AS
SELECT 
  id,
  institution_name,
  email,
  country,
  status,
  created_at,
  last_login,
  DATEDIFF(CURDATE(), DATE(created_at)) as days_registered
FROM institution_members
WHERE deleted_at IS NULL AND status = 'verified';

-- View: Admin Activity Summary
CREATE OR REPLACE VIEW admin_activity_summary AS
SELECT 
  au.id,
  au.admin_name,
  au.role,
  au.status,
  COUNT(al.id) as total_actions,
  MAX(al.created_at) as last_action
FROM admin_users au
LEFT JOIN activity_logs al ON al.user_id = au.id AND al.user_type = 'admin'
WHERE au.deleted_at IS NULL
GROUP BY au.id;

-- View: Recent Login Activity
CREATE OR REPLACE VIEW recent_login_activity AS
SELECT 
  action,
  user_type,
  user_id,
  created_at,
  ip_address,
  CASE 
    WHEN action = 'login' THEN 'Success'
    WHEN action = 'failed_login' THEN 'Failed'
    ELSE action
  END as status
FROM activity_logs
WHERE action IN ('login', 'failed_login')
ORDER BY created_at DESC
LIMIT 100;

-- ========================================================================
-- 13. SAMPLE DATA FOR TESTING (Optional - comment out for production)
-- ========================================================================

-- Sample Member 1
INSERT INTO `institution_members` (
  `institution_name`,
  `country`,
  `contact_person_name`,
  `email`,
  `phone`,
  `password_hash`,
  `status`,
  `email_verified`,
  `email_verified_at`
) VALUES (
  'University of Lagos',
  'Nigeria',
  'Dr. John Smith',
  'admin@unilag.edu.ng',
  '+234 812 345 6789',
  '$2y$12$8dGIlZrPa8O2nQvQvQvQva1aZ1aZ1aZ1aZ1aZ1aZ1aZ1aZ1aZ1', -- password123
  'verified',
  1,
  NOW()
);

-- Sample Member 2
INSERT INTO `institution_members` (
  `institution_name`,
  `country`,
  `contact_person_name`,
  `email`,
  `phone`,
  `password_hash`,
  `status`,
  `email_verified`,
  `email_verified_at`
) VALUES (
  'Accra Business School',
  'Ghana',
  'Prof. Jane Doe',
  'contact@accrabusiness.edu.gh',
  '+233 20 345 6789',
  '$2y$12$8dGIlZrPa8O2nQvQvQvQva1aZ1aZ1aZ1aZ1aZ1aZ1aZ1aZ1aZ1', -- password123
  'verified',
  1,
  NOW()
);

-- ========================================================================
-- SCHEMA COMPLETION
-- ========================================================================
-- 
-- Database setup complete. Next steps:
--
-- 1. Update XAMPP/MySQL password hash for admin user above with actual bcrypt
-- 2. Configure db-config.php with your database credentials if different
-- 3. Test database connection with test.php
-- 4. Run member and admin portal login tests
-- 5. Configure email settings when ready
--
-- ========================================================================
