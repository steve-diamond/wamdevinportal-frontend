# Alumni Deployment Guide

## 1) Environment setup

- Set APP_URL and DB_* values in includes/db-config.php.
- Set environment variable WAMDEVIN_JWT_SECRET to a strong secret.
- Configure PHP timezone and ensure session storage is writable.

## 2) File permissions

- Ensure writable path for uploads:
  - assets/uploads/alumni

## 3) Web server

- Ensure Apache modules are enabled:
  - mod_rewrite
  - mod_headers
- Keep alumni/.htaccess active.

## 4) Database readiness

- Ensure MySQL/MariaDB service is running before checks.

Run:

php alumni/scripts/preflight.php

Resolve reported missing tables and columns before go-live.

## 5) Post-deploy smoke test

Run:

php alumni/scripts/post_deploy_smoke.php

Expected: PASS on core module checks.

Quick command on Windows PowerShell:

powershell -ExecutionPolicy Bypass -File alumni/scripts/run_deploy_checks.ps1

## 6) Production hardening

- Serve over HTTPS only.
- Rotate JWT secret periodically.
- Restrict DB user permissions to least privilege.
- Enable regular database backups.

## 7) Rollback plan

- Keep a snapshot backup before deployment.
- Restore previous code and DB snapshot if critical checks fail.
