-- ========================================================================
-- WAMDEVIN Alumni Portal - Database Schema
-- 
-- Full-Stack Alumni Management System
-- Database: wamdevin_portal (extends existing schema)
-- Created: March 18, 2026
-- ========================================================================

USE `wamdevin_portal`;

-- ========================================================================
-- 1. ALUMNI USERS TABLE
-- ========================================================================
CREATE TABLE IF NOT EXISTS `alumni` (
  `id`                     INT AUTO_INCREMENT PRIMARY KEY,
  `first_name`             VARCHAR(100) NOT NULL,
  `last_name`              VARCHAR(100) NOT NULL,
  `email`                  VARCHAR(255) NOT NULL UNIQUE,
  `password_hash`          VARCHAR(255) NOT NULL,
  `role`                   ENUM('alumni','moderator','admin') DEFAULT 'alumni',
  `status`                 ENUM('pending','active','suspended','banned') DEFAULT 'pending',
  `avatar`                 VARCHAR(500) NULL,

  -- Email verification
  `email_verified`         TINYINT(1) DEFAULT 0,
  `email_verified_at`      DATETIME NULL,
  `verification_token`     VARCHAR(255) NULL,
  `verification_expires`   DATETIME NULL,

  -- Password reset
  `reset_token`            VARCHAR(255) NULL,
  `reset_token_expires`    DATETIME NULL,

  -- Security
  `login_attempts`         INT DEFAULT 0,
  `locked_until`           DATETIME NULL,
  `last_login`             DATETIME NULL,
  `last_login_ip`          VARCHAR(45) NULL,
  `two_factor_secret`      VARCHAR(255) NULL,
  `two_factor_enabled`     TINYINT(1) DEFAULT 0,

  -- Timestamps
  `created_at`             DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at`             DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at`             DATETIME NULL,

  INDEX idx_email           (email),
  INDEX idx_status          (status),
  INDEX idx_role            (role),
  INDEX idx_verification    (verification_token),
  INDEX idx_reset           (reset_token),
  FULLTEXT idx_name_search  (first_name, last_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 2. ALUMNI PROFILES TABLE
-- ========================================================================
CREATE TABLE IF NOT EXISTS `alumni_profiles` (
  `id`                     INT AUTO_INCREMENT PRIMARY KEY,
  `alumni_id`              INT NOT NULL UNIQUE,
  `graduation_year`        YEAR NULL,
  `degree`                 VARCHAR(200) NULL,
  `department`             VARCHAR(200) NULL,
  `current_title`          VARCHAR(200) NULL,
  `current_company`        VARCHAR(200) NULL,
  `industry`               VARCHAR(150) NULL,
  `country`                VARCHAR(100) NULL,
  `city`                   VARCHAR(100) NULL,
  `phone`                  VARCHAR(30) NULL,
  `bio`                    TEXT NULL,
  `linkedin_url`           VARCHAR(500) NULL,
  `twitter_url`            VARCHAR(500) NULL,
  `website_url`            VARCHAR(500) NULL,
  `skills`                 TEXT NULL COMMENT 'JSON array of skills',
  `interests`              TEXT NULL COMMENT 'JSON array of interests',
  `is_public`              TINYINT(1) DEFAULT 1,
  `created_at`             DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at`             DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  FOREIGN KEY (alumni_id) REFERENCES alumni(id) ON DELETE CASCADE,
  INDEX idx_year            (graduation_year),
  INDEX idx_industry        (industry),
  INDEX idx_country         (country),
  FULLTEXT idx_profile_search (current_title, current_company, bio)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 3. ALUMNI EDUCATION TABLE
-- ========================================================================
CREATE TABLE IF NOT EXISTS `alumni_education` (
  `id`            INT AUTO_INCREMENT PRIMARY KEY,
  `alumni_id`     INT NOT NULL,
  `institution`   VARCHAR(255) NOT NULL,
  `degree`        VARCHAR(200) NOT NULL,
  `field_of_study` VARCHAR(200) NULL,
  `start_year`    YEAR NULL,
  `end_year`      YEAR NULL,
  `is_current`    TINYINT(1) DEFAULT 0,
  `description`   TEXT NULL,
  `created_at`    DATETIME DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (alumni_id) REFERENCES alumni(id) ON DELETE CASCADE,
  INDEX idx_alumni (alumni_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 4. ALUMNI WORK EXPERIENCE TABLE
-- ========================================================================
CREATE TABLE IF NOT EXISTS `alumni_work_experience` (
  `id`            INT AUTO_INCREMENT PRIMARY KEY,
  `alumni_id`     INT NOT NULL,
  `company`       VARCHAR(255) NOT NULL,
  `title`         VARCHAR(200) NOT NULL,
  `location`      VARCHAR(200) NULL,
  `start_date`    DATE NULL,
  `end_date`      DATE NULL,
  `is_current`    TINYINT(1) DEFAULT 0,
  `description`   TEXT NULL,
  `created_at`    DATETIME DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (alumni_id) REFERENCES alumni(id) ON DELETE CASCADE,
  INDEX idx_alumni (alumni_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 5. ALUMNI CONNECTIONS TABLE (Network / Friends)
-- ========================================================================
CREATE TABLE IF NOT EXISTS `alumni_connections` (
  `id`            INT AUTO_INCREMENT PRIMARY KEY,
  `requester_id`  INT NOT NULL,
  `receiver_id`   INT NOT NULL,
  `status`        ENUM('pending','accepted','declined','blocked') DEFAULT 'pending',
  `created_at`    DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at`    DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  UNIQUE KEY uq_connection (requester_id, receiver_id),
  FOREIGN KEY (requester_id) REFERENCES alumni(id) ON DELETE CASCADE,
  FOREIGN KEY (receiver_id)  REFERENCES alumni(id) ON DELETE CASCADE,
  INDEX idx_requester (requester_id),
  INDEX idx_receiver  (receiver_id),
  INDEX idx_status    (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 6. ALUMNI EVENTS TABLE
-- ========================================================================
CREATE TABLE IF NOT EXISTS `alumni_events` (
  `id`              INT AUTO_INCREMENT PRIMARY KEY,
  `title`           VARCHAR(300) NOT NULL,
  `slug`            VARCHAR(350) NOT NULL UNIQUE,
  `description`     LONGTEXT NULL,
  `event_type`      ENUM('networking','webinar','reunion','workshop','conference','social','other') DEFAULT 'networking',
  `location`        VARCHAR(500) NULL,
  `is_virtual`      TINYINT(1) DEFAULT 0,
  `virtual_link`    VARCHAR(500) NULL,
  `image`           VARCHAR(500) NULL,
  `start_datetime`  DATETIME NOT NULL,
  `end_datetime`    DATETIME NOT NULL,
  `registration_deadline` DATETIME NULL,
  `max_attendees`   INT NULL,
  `price`           DECIMAL(10,2) DEFAULT 0.00,
  `currency`        VARCHAR(10) DEFAULT 'USD',
  `status`          ENUM('draft','published','cancelled','completed') DEFAULT 'draft',
  `created_by`      INT NOT NULL COMMENT 'admin_users.id',
  `created_at`      DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at`      DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  INDEX idx_status     (status),
  INDEX idx_start      (start_datetime),
  INDEX idx_type       (event_type),
  FULLTEXT idx_search  (title, description)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 7. EVENT REGISTRATIONS TABLE
-- ========================================================================
CREATE TABLE IF NOT EXISTS `alumni_event_registrations` (
  `id`              INT AUTO_INCREMENT PRIMARY KEY,
  `event_id`        INT NOT NULL,
  `alumni_id`       INT NOT NULL,
  `status`          ENUM('registered','waitlisted','cancelled','attended') DEFAULT 'registered',
  `payment_status`  ENUM('free','paid','pending','refunded') DEFAULT 'free',
  `amount_paid`     DECIMAL(10,2) DEFAULT 0.00,
  `registered_at`   DATETIME DEFAULT CURRENT_TIMESTAMP,
  `notes`           TEXT NULL,

  UNIQUE KEY uq_reg (event_id, alumni_id),
  FOREIGN KEY (event_id)   REFERENCES alumni_events(id) ON DELETE CASCADE,
  FOREIGN KEY (alumni_id)  REFERENCES alumni(id) ON DELETE CASCADE,
  INDEX idx_event   (event_id),
  INDEX idx_alumni  (alumni_id),
  INDEX idx_status  (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 8. JOB POSTINGS TABLE
-- ========================================================================
CREATE TABLE IF NOT EXISTS `alumni_jobs` (
  `id`              INT AUTO_INCREMENT PRIMARY KEY,
  `title`           VARCHAR(300) NOT NULL,
  `slug`            VARCHAR(350) NOT NULL UNIQUE,
  `company`         VARCHAR(255) NOT NULL,
  `company_logo`    VARCHAR(500) NULL,
  `description`     LONGTEXT NOT NULL,
  `requirements`    TEXT NULL,
  `job_type`        ENUM('full-time','part-time','contract','internship','remote','freelance') DEFAULT 'full-time',
  `location`        VARCHAR(300) NULL,
  `is_remote`       TINYINT(1) DEFAULT 0,
  `salary_min`      DECIMAL(12,2) NULL,
  `salary_max`      DECIMAL(12,2) NULL,
  `salary_currency` VARCHAR(10) DEFAULT 'USD',
  `industry`        VARCHAR(150) NULL,
  `category`        VARCHAR(150) NULL,
  `application_url` VARCHAR(500) NULL,
  `contact_email`   VARCHAR(255) NULL,
  `expires_at`      DATETIME NULL,
  `status`          ENUM('draft','published','expired','closed') DEFAULT 'draft',
  `posted_by`       INT NOT NULL COMMENT 'alumni.id or admin',
  `posted_by_type`  ENUM('alumni','admin') DEFAULT 'admin',
  `views`           INT DEFAULT 0,
  `created_at`      DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at`      DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  INDEX idx_status   (status),
  INDEX idx_type     (job_type),
  INDEX idx_industry (industry),
  INDEX idx_expires  (expires_at),
  FULLTEXT idx_search (title, company, description)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 9. JOB APPLICATIONS TABLE
-- ========================================================================
CREATE TABLE IF NOT EXISTS `alumni_job_applications` (
  `id`            INT AUTO_INCREMENT PRIMARY KEY,
  `job_id`        INT NOT NULL,
  `alumni_id`     INT NOT NULL,
  `cover_letter`  TEXT NULL,
  `resume_path`   VARCHAR(500) NULL,
  `status`        ENUM('applied','reviewing','shortlisted','rejected','hired') DEFAULT 'applied',
  `applied_at`    DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at`    DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `notes`         TEXT NULL,

  UNIQUE KEY uq_app (job_id, alumni_id),
  FOREIGN KEY (job_id)    REFERENCES alumni_jobs(id) ON DELETE CASCADE,
  FOREIGN KEY (alumni_id) REFERENCES alumni(id) ON DELETE CASCADE,
  INDEX idx_job     (job_id),
  INDEX idx_alumni  (alumni_id),
  INDEX idx_status  (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 10. DONATIONS TABLE
-- ========================================================================
CREATE TABLE IF NOT EXISTS `alumni_donations` (
  `id`                INT AUTO_INCREMENT PRIMARY KEY,
  `alumni_id`         INT NULL COMMENT 'NULL for anonymous',
  `donor_name`        VARCHAR(255) NOT NULL,
  `donor_email`       VARCHAR(255) NOT NULL,
  `amount`            DECIMAL(12,2) NOT NULL,
  `currency`          VARCHAR(10) DEFAULT 'USD',
  `campaign`          VARCHAR(200) NULL,
  `message`           TEXT NULL,
  `is_anonymous`      TINYINT(1) DEFAULT 0,
  `is_recurring`      TINYINT(1) DEFAULT 0,
  `recurring_interval` ENUM('monthly','quarterly','annually') NULL,
  `payment_method`    VARCHAR(100) NULL,
  `payment_reference` VARCHAR(255) NULL UNIQUE,
  `payment_status`    ENUM('pending','completed','failed','refunded') DEFAULT 'pending',
  `payment_gateway`   VARCHAR(100) NULL,
  `receipt_sent`      TINYINT(1) DEFAULT 0,
  `created_at`        DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at`        DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  FOREIGN KEY (alumni_id) REFERENCES alumni(id) ON DELETE SET NULL,
  INDEX idx_alumni    (alumni_id),
  INDEX idx_status    (payment_status),
  INDEX idx_campaign  (campaign),
  INDEX idx_date      (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 11. ALUMNI NEWS / ANNOUNCEMENTS TABLE
-- ========================================================================
CREATE TABLE IF NOT EXISTS `alumni_news` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `title`       VARCHAR(300) NOT NULL,
  `slug`        VARCHAR(350) NOT NULL UNIQUE,
  `excerpt`     VARCHAR(500) NULL,
  `content`     LONGTEXT NOT NULL,
  `image`       VARCHAR(500) NULL,
  `category`    VARCHAR(100) NULL,
  `tags`        TEXT NULL COMMENT 'JSON array',
  `status`      ENUM('draft','published','archived') DEFAULT 'draft',
  `is_featured` TINYINT(1) DEFAULT 0,
  `views`       INT DEFAULT 0,
  `author_id`   INT NOT NULL,
  `published_at` DATETIME NULL,
  `created_at`  DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at`  DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  INDEX idx_status    (status),
  INDEX idx_featured  (is_featured),
  INDEX idx_category  (category),
  INDEX idx_published (published_at),
  FULLTEXT idx_search (title, excerpt, content)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 12. PRIVATE MESSAGES TABLE
-- ========================================================================
CREATE TABLE IF NOT EXISTS `alumni_messages` (
  `id`            INT AUTO_INCREMENT PRIMARY KEY,
  `thread_id`     VARCHAR(100) NOT NULL COMMENT 'Composite: min(s,r)_max(s,r)',
  `sender_id`     INT NOT NULL,
  `receiver_id`   INT NOT NULL,
  `body`          TEXT NOT NULL,
  `is_read`       TINYINT(1) DEFAULT 0,
  `read_at`       DATETIME NULL,
  `deleted_by_sender`   TINYINT(1) DEFAULT 0,
  `deleted_by_receiver` TINYINT(1) DEFAULT 0,
  `created_at`    DATETIME DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (sender_id)   REFERENCES alumni(id) ON DELETE CASCADE,
  FOREIGN KEY (receiver_id) REFERENCES alumni(id) ON DELETE CASCADE,
  INDEX idx_thread   (thread_id),
  INDEX idx_sender   (sender_id),
  INDEX idx_receiver (receiver_id),
  INDEX idx_read     (is_read)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 13. NOTIFICATIONS TABLE
-- ========================================================================
CREATE TABLE IF NOT EXISTS `alumni_notifications` (
  `id`            INT AUTO_INCREMENT PRIMARY KEY,
  `alumni_id`     INT NOT NULL,
  `type`          VARCHAR(100) NOT NULL COMMENT 'connection_request, event_reminder, job_match, message, etc.',
  `title`         VARCHAR(300) NOT NULL,
  `body`          TEXT NULL,
  `action_url`    VARCHAR(500) NULL,
  `is_read`       TINYINT(1) DEFAULT 0,
  `read_at`       DATETIME NULL,
  `created_at`    DATETIME DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (alumni_id) REFERENCES alumni(id) ON DELETE CASCADE,
  INDEX idx_alumni (alumni_id),
  INDEX idx_read   (is_read),
  INDEX idx_type   (type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 14. JWT TOKEN BLACKLIST (for secure logout)
-- ========================================================================
CREATE TABLE IF NOT EXISTS `jwt_blacklist` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `token_hash`  VARCHAR(255) NOT NULL UNIQUE COMMENT 'SHA256 hash of token',
  `alumni_id`   INT NOT NULL,
  `revoked_at`  DATETIME DEFAULT CURRENT_TIMESTAMP,
  `expires_at`  DATETIME NOT NULL,

  INDEX idx_hash    (token_hash),
  INDEX idx_expires (expires_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- 15. DONATION CAMPAIGNS TABLE
-- ========================================================================
CREATE TABLE IF NOT EXISTS `donation_campaigns` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `title`       VARCHAR(300) NOT NULL,
  `slug`        VARCHAR(350) NOT NULL UNIQUE,
  `description` TEXT NULL,
  `goal_amount` DECIMAL(12,2) NOT NULL,
  `currency`    VARCHAR(10) DEFAULT 'USD',
  `image`       VARCHAR(500) NULL,
  `status`      ENUM('active','completed','paused') DEFAULT 'active',
  `start_date`  DATE NULL,
  `end_date`    DATE NULL,
  `created_at`  DATETIME DEFAULT CURRENT_TIMESTAMP,

  INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- SEED DATA
-- ========================================================================

-- Default admin alumni account (password: Alumni@2026!)
INSERT IGNORE INTO `alumni` 
  (first_name, last_name, email, password_hash, role, status, email_verified)
VALUES
  ('WAMDEVIN', 'Alumni-Admin', 'alumni.admin@wamdevin.org', 
   '$2y$12$KxQlMp2GJF7VLH3W9PZBaOV7kI9JmPdGW1LsyeXXhbkTbG2MKqFCa',
   'admin', 'active', 1);

-- Sample donation campaign
INSERT IGNORE INTO `donation_campaigns` 
  (title, slug, description, goal_amount, currency, status, start_date, end_date)
VALUES
  ('WAMDEVIN Scholarship Fund 2026', 'scholarship-fund-2026',
   'Support the next generation of management development leaders across West Africa.',
   50000.00, 'USD', 'active', '2026-01-01', '2026-12-31'),
  ('Campus Development Initiative', 'campus-development-2026',
   'Help us build state-of-the-art facilities for our trainees and alumni.',
   100000.00, 'USD', 'active', '2026-01-01', '2026-12-31');

-- Sample news
INSERT IGNORE INTO `alumni_news` 
  (title, slug, excerpt, content, category, status, is_featured, author_id, published_at)
VALUES
  ('WAMDEVIN Alumni Network Launches New Digital Portal', 
   'alumni-network-launches-digital-portal',
   'The WAMDEVIN Alumni Network is proud to announce the launch of its new comprehensive digital alumni portal.',
   '<p>The WAMDEVIN Alumni Network is proud to announce the launch of its new comprehensive digital alumni portal, designed to connect over 10,000 alumni across West Africa and beyond.</p><p>The portal features advanced networking tools, job boards, event management, and donation capabilities — all designed with the alumni community in mind.</p>',
   'Announcement', 'published', 1, 1, NOW()),
  ('Annual Alumni Reunion 2026 — Registration Now Open',
   'annual-alumni-reunion-2026',
   'Join us for the prestigious WAMDEVIN Annual Alumni Reunion 2026 — a celebration of excellence and achievement.',
   '<p>We are excited to announce that registration is now open for the WAMDEVIN Annual Alumni Reunion 2026. This prestigious event will bring together our distinguished alumni from across the globe for three days of networking, learning, and celebration.</p>',
   'Events', 'published', 1, 1, NOW());

-- Sample events
INSERT IGNORE INTO `alumni_events`
  (title, slug, description, event_type, location, start_datetime, end_datetime, status, created_by)
VALUES
  ('WAMDEVIN Annual Alumni Reunion 2026',
   'annual-alumni-reunion-2026',
   'Join us for the prestigious WAMDEVIN Annual Alumni Reunion 2026. Three days of networking, panel discussions, and celebrations with distinguished alumni from across West Africa.',
   'reunion', 'WAMDEVIN Main Campus, Lagos, Nigeria',
   '2026-06-15 09:00:00', '2026-06-17 18:00:00', 'published', 1),
  ('Leadership Masterclass: Digital Transformation in Africa',
   'leadership-masterclass-digital-transformation',
   'An exclusive masterclass for WAMDEVIN alumni on navigating digital transformation in African markets.',
   'workshop', 'Online (Zoom)', 
   '2026-04-25 10:00:00', '2026-04-25 14:00:00', 'published', 1);

-- Update events to virtual for online ones
UPDATE `alumni_events` SET is_virtual=1, virtual_link='https://zoom.us/j/placeholder' 
WHERE slug='leadership-masterclass-digital-transformation';

-- Sample job
INSERT IGNORE INTO `alumni_jobs`
  (title, slug, company, description, requirements, job_type, location, industry, status, posted_by, posted_by_type)
VALUES
  ('Senior Management Consultant',
   'senior-management-consultant-2026',
   'McKinsey & Company',
   '<p>We are seeking a Senior Management Consultant to join our growing West Africa practice. The ideal candidate will have strong analytical skills and experience in organizational transformation.</p>',
   '<ul><li>MBA or equivalent from a top institution</li><li>5+ years management consulting experience</li><li>Strong analytical and communication skills</li></ul>',
   'full-time', 'Lagos, Nigeria', 'Consulting', 'published', 1, 'admin');
