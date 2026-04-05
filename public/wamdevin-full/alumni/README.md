# WAMDEVIN Alumni Platform

This module provides the WAMDEVIN alumni experience and admin operations for:

- Alumni authentication and profile management
- Events and RSVP attendance
- Jobs and applications
- Donations and reporting
- News publication and readership
- Messaging, notifications, and networking

## Structure

- admin/: Alumni admin management pages
- api/: Alumni API endpoints
- includes/: Shared runtime config, middleware, header/footer, auth utilities
- scripts/: Deployment and operations scripts
- sql/: SQL notes for deployment checks

## Runtime requirements

- PHP: 5.6+ (7.4+ recommended)
- MySQL/MariaDB with utf8mb4 support
- Apache with mod_rewrite + mod_headers
- PHP extensions: pdo, pdo_mysql, mbstring, openssl, json, session

## First deployment

1. Confirm global DB settings in includes/db-config.php.
1. Ensure APP_URL points to deployment host.
1. Run preflight: php alumni/scripts/preflight.php
1. Fix any reported missing tables/permissions.
1. Run post-deploy checks: php alumni/scripts/post_deploy_smoke.php

## Access

- Alumni landing: /alumni/landing.php
- Alumni portal: /alumni/index.php
- Alumni admin: /alumni/admin/index.php

## Security notes

- Keep WAMDEVIN_JWT_SECRET set in server environment for production.
- Disable public exposure of logs/backups in web root.
- Enforce HTTPS for production traffic.
