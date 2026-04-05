# WAMDEVIN Website - Deployment Guide

## 📋 Table of Contents

1. [Pre-Deployment Checklist](#pre-deployment-checklist)
2. [Asset Optimization](#asset-optimization)
3. [Configuration Changes](#configuration-changes)
4. [Server Requirements](#server-requirements)
5. [Deployment Steps](#deployment-steps)
6. [Post-Deployment Testing](#post-deployment-testing)
7. [Rollback Procedure](#rollback-procedure)
8. [Performance Monitoring](#performance-monitoring)
9. [Troubleshooting](#troubleshooting)

---

## 🔍 Pre-Deployment Checklist

### Development Testing (Complete ALL before deployment)

- [ ] **All Pages Tested**
  - [ ] Homepage (index.php)
  - [ ] About (about.php)
  - [ ] Services (service.php)
  - [ ] Membership (membership.php)
  - [ ] Leadership (leadership.php)
  - [ ] Research (research.php)
  - [ ] Publications (publication.php)
  - [ ] Consultancy (consultancy.php)
  - [ ] Gallery (gallery.php)
  - [ ] Contact (contact.php)
  - [ ] Training (trainners.php)

- [ ] **Cross-Browser Testing**
  - [ ] Chrome (latest 2 versions)
  - [ ] Firefox (latest 2 versions)
  - [ ] Safari (latest 2 versions)
  - [ ] Edge (latest 2 versions)
  - [ ] Mobile Chrome (Android)
  - [ ] Mobile Safari (iOS)

- [ ] **Responsive Testing**
  - [ ] Mobile (320px - 480px)
  - [ ] Tablet (481px - 768px)
  - [ ] Desktop (769px - 1024px)
  - [ ] Large Desktop (1025px+)
  - [ ] 4K/Retina displays

- [ ] **Functionality Testing**
  - [ ] Navigation menu (desktop & mobile)
  - [ ] Search functionality
  - [ ] Language switcher (EN-UK, EN-US, FR)
  - [ ] Contact forms
  - [ ] Membership application
  - [ ] Gallery lightbox
  - [ ] Revolution Slider
  - [ ] Owl Carousel
  - [ ] Back-to-top button
  - [ ] Smooth scrolling
  - [ ] Counter animations
  - [ ] Modal popups
  - [ ] Dropdown menus

- [ ] **Performance Testing**
  - [ ] PageSpeed Insights (Desktop: 90+, Mobile: 80+)
  - [ ] GTmetrix (Grade: A, Performance: 90+)
  - [ ] Lighthouse (Performance: 90+)
  - [ ] WebPageTest (First Contentful Paint < 1.5s)
  - [ ] Load time < 3 seconds on 4G connection
  - [ ] Time to Interactive < 3.5 seconds

- [ ] **Accessibility Testing**
  - [ ] WAVE Web Accessibility Evaluation (0 errors)
  - [ ] axe DevTools (0 critical issues)
  - [ ] Keyboard navigation works
  - [ ] Screen reader tested (NVDA/JAWS)
  - [ ] Color contrast ratio ≥ 4.5:1
  - [ ] Focus indicators visible
  - [ ] ARIA labels present
  - [ ] Alt text on all images
  - [ ] Semantic HTML used

- [ ] **SEO Validation**
  - [ ] Meta titles (50-60 characters)
  - [ ] Meta descriptions (150-160 characters)
  - [ ] Open Graph tags
  - [ ] Twitter Card tags
  - [ ] Canonical URLs
  - [ ] Structured data (JSON-LD)
  - [ ] robots.txt configured
  - [ ] XML sitemap generated
  - [ ] 404 page exists
  - [ ] No broken links

- [ ] **Security Checks**
  - [ ] HTTPS enabled
  - [ ] SSL certificate valid
  - [ ] Security headers configured
  - [ ] SQL injection protection
  - [ ] XSS protection
  - [ ] CSRF tokens in forms
  - [ ] File upload validation
  - [ ] Input sanitization
  - [ ] Password hashing (if applicable)
  - [ ] Session security

- [ ] **Code Quality**
  - [ ] No console.log() statements
  - [ ] No debug code
  - [ ] Comments removed/cleaned
  - [ ] CSS validated (W3C)
  - [ ] HTML validated (W3C)
  - [ ] JavaScript linted (no errors)
  - [ ] PHP error_reporting off
  - [ ] No sensitive data in code

---

## ⚡ Asset Optimization

### 1. Install Python Dependencies

```bash
# Install required Python packages
pip install csscompressor jsmin pillow
```

### 2. Run Asset Optimizer

```bash
# Navigate to tools directory
cd c:\xampp\htdocs\wamdevin\tools

# Run optimizer (all assets)
python optimize_assets.py --all

# Or optimize specific asset types
python optimize_assets.py --css-only
python optimize_assets.py --js-only
python optimize_assets.py --images-only
```

### 3. Manual Image Optimization (Optional)

Use online tools for additional compression:

- **TinyPNG**: <https://tinypng.com/> (PNG/JPEG)
- **Squoosh**: <https://squoosh.app/> (All formats + WebP conversion)
- **ImageOptim**: <https://imageoptim.com/> (Mac only)

### 4. WebP Conversion

Convert images to WebP format for better compression:

```bash
# Using cwebp (install from Google)
cwebp -q 85 input.jpg -o output.webp

# Batch conversion (PowerShell)
Get-ChildItem -Path "assets\images" -Recurse -Include *.jpg,*.png | ForEach-Object {
    $output = $_.FullName -replace '\.(jpg|png)$', '.webp'
    cwebp -q 85 $_.FullName -o $output
}
```

### 5. Update HTML References

After optimization, update file references:

```html
<!-- Before -->
<link rel="stylesheet" href="css/modern.css">
<script src="js/modern.js"></script>

<!-- After -->
<link rel="stylesheet" href="css/modern.min.css">
<script src="js/modern.min.js"></script>
```

For images with WebP:

```html
<picture>
    <source srcset="assets/images/banner/banner-1.webp" type="image/webp">
    <img src="assets/images/banner/banner-1.jpg" alt="Banner">
</picture>
```

---

## ⚙️ Configuration Changes

### 1. Update .htaccess

- [ ] Enable HTTPS redirect (uncomment lines)
- [ ] Configure WWW vs non-WWW (choose one)
- [ ] Update error page paths
- [ ] Set correct PHP error log path
- [ ] Update Content-Security-Policy domains
- [ ] Enable HSTS (after testing HTTPS)

```apache
# Enable HTTPS redirect
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Enable HSTS
Header set Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"
```

### 2. Update PHP Configuration

Create or edit `php.ini` (or `.user.ini`):

```ini
; Production settings
display_errors = Off
log_errors = On
error_log = /path/to/php-errors.log

; Performance
max_execution_time = 300
memory_limit = 256M
upload_max_filesize = 10M
post_max_size = 12M

; Security
session.cookie_httponly = 1
session.cookie_secure = 1
session.use_strict_mode = 1
```

### 3. Database Configuration

If using database:

- [ ] Change database credentials
- [ ] Create database backup
- [ ] Update connection strings
- [ ] Set production database name
- [ ] Configure connection pooling
- [ ] Enable query caching

### 4. Environment Variables

Create `.env` file (or configure server):

```env
# Production environment
APP_ENV=production
APP_DEBUG=false
APP_URL=https://www.wamdevin.org

# Database (if applicable)
DB_HOST=localhost
DB_NAME=wamdevin_db
DB_USER=wamdevin_user
DB_PASS=***

# Mail (if applicable)
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USER=noreply@wamdevin.org
MAIL_PASS=***

# Analytics
GA_TRACKING_ID=UA-XXXXXXXXX-X

# reCAPTCHA (if applicable)
RECAPTCHA_SITE_KEY=***
RECAPTCHA_SECRET_KEY=***
```

### 5. Update Google Analytics

In `includes/modern-footer.php`:

```php
// Replace with your actual tracking ID
Google Analytics ID: UA-XXXXXXXXX-X
or
Google Tag Manager ID: GTM-XXXXXXX
```

---

## 🖥️ Server Requirements

### Minimum Requirements

- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **PHP**: 7.4+ (8.0+ recommended)
- **MySQL**: 5.7+ or MariaDB 10.3+ (if using database)
- **SSL Certificate**: Valid certificate from Let's Encrypt, DigiCert, etc.
- **Disk Space**: 500 MB minimum
- **Memory**: 256 MB minimum
- **Bandwidth**: Unlimited recommended

### Required Apache Modules

```bash
# Check enabled modules
apache2ctl -M

# Required modules
mod_rewrite
mod_headers
mod_expires
mod_deflate (or mod_gzip)
mod_mime
mod_ssl
```

### Required PHP Extensions

```bash
# Check installed extensions
php -m

# Required extensions
gd or imagick
mbstring
mysqli (if using database)
curl
openssl
xml
json
zip
```

### Server Performance Tuning

#### Apache Configuration

```apache
# /etc/apache2/apache2.conf or httpd.conf

# Increase MaxKeepAliveRequests
MaxKeepAliveRequests 100

# Set KeepAliveTimeout
KeepAliveTimeout 5

# Configure MPM worker
<IfModule mpm_worker_module>
    StartServers             2
    MinSpareThreads         25
    MaxSpareThreads         75
    ThreadLimit             64
    ThreadsPerChild         25
    MaxRequestWorkers      150
    MaxConnectionsPerChild   0
</IfModule>
```

#### PHP-FPM Configuration

```ini
# /etc/php/7.4/fpm/pool.d/www.conf

pm = dynamic
pm.max_children = 50
pm.start_servers = 5
pm.min_spare_servers = 5
pm.max_spare_servers = 35
pm.max_requests = 200
```

---

## 🚀 Deployment Steps

### Method 1: FTP/SFTP Deployment

#### Step 1: Create Backup

```bash
# On server, create backup
tar -czf wamdevin-backup-$(date +%Y%m%d).tar.gz /path/to/wamdevin

# Download backup to local
# Use FileZilla, WinSCP, or FTP client
```

#### Step 2: Upload Files

```bash
# Upload via FTP/SFTP
# Use FileZilla, WinSCP, or command line

# Command line example (SFTP)
sftp user@server.com
put -r c:/xampp/htdocs/wamdevin/* /var/www/html/wamdevin/
```

#### Step 3: Set Permissions

```bash
# SSH into server
ssh user@server.com

# Set directory permissions
find /var/www/html/wamdevin -type d -exec chmod 755 {} \;

# Set file permissions
find /var/www/html/wamdevin -type f -exec chmod 644 {} \;

# Make specific directories writable
chmod -R 775 /var/www/html/wamdevin/uploads
chmod -R 775 /var/www/html/wamdevin/logs

# Set ownership
chown -R www-data:www-data /var/www/html/wamdevin
```

### Method 2: Git Deployment

#### Step 1: Initialize Git Repository

```bash
# In local project
cd c:\xampp\htdocs\wamdevin
git init
git add .
git commit -m "Initial commit - Modernized WAMDEVIN website"
```

#### Step 2: Push to Remote Repository

```bash
# Add remote (GitHub, GitLab, Bitbucket)
git remote add origin https://github.com/yourusername/wamdevin.git
git branch -M main
git push -u origin main
```

#### Step 3: Deploy to Server

```bash
# SSH into server
ssh user@server.com

# Clone repository
cd /var/www/html
git clone https://github.com/yourusername/wamdevin.git

# Or pull updates if already cloned
cd /var/www/html/wamdevin
git pull origin main
```

### Method 3: cPanel Deployment

1. **Login to cPanel**
2. **Navigate to File Manager**
3. **Upload ZIP file** of project
4. **Extract files** to public_html
5. **Set permissions** (folders: 755, files: 644)
6. **Configure .htaccess**
7. **Test website**

---

## ✅ Post-Deployment Testing

### 1. Smoke Testing (Critical)

- [ ] Homepage loads successfully
- [ ] Navigation works (all links)
- [ ] Forms submit correctly
- [ ] Images display properly
- [ ] CSS loads (no broken styles)
- [ ] JavaScript works (no console errors)
- [ ] HTTPS enabled and working
- [ ] Mobile responsive

### 2. Performance Testing

```bash
# Run PageSpeed Insights
https://pagespeed.web.dev/
Target: Desktop 90+, Mobile 80+

# Run GTmetrix
https://gtmetrix.com/
Target: Grade A, Performance 90+

# Run WebPageTest
https://www.webpagetest.org/
Target: First Contentful Paint < 1.5s
```

### 3. Security Testing

```bash
# Run SSL Labs test
https://www.ssllabs.com/ssltest/
Target: A+ rating

# Run Security Headers test
https://securityheaders.com/
Target: A+ rating

# Check for vulnerabilities
https://observatory.mozilla.org/
Target: B+ or higher
```

### 4. SEO Testing

```bash
# Google Search Console
- Submit sitemap
- Check coverage
- Fix any errors

# Verify meta tags
- Check titles
- Check descriptions
- Verify Open Graph
```

### 5. Accessibility Testing

```bash
# WAVE Tool
https://wave.webaim.org/
Target: 0 errors

# Lighthouse Accessibility
Run in Chrome DevTools
Target: 90+ score
```

### 6. Monitoring Setup

- [ ] Install Google Analytics
- [ ] Configure Google Tag Manager (optional)
- [ ] Set up uptime monitoring (UptimeRobot, Pingdom)
- [ ] Configure error logging
- [ ] Set up performance monitoring (New Relic, etc.)

---

## ⏮️ Rollback Procedure

### If Issues Occur After Deployment

#### Quick Rollback (FTP Method)

```bash
# 1. Rename current directory
mv /var/www/html/wamdevin /var/www/html/wamdevin-broken

# 2. Restore from backup
tar -xzf wamdevin-backup-YYYYMMDD.tar.gz -C /var/www/html/

# 3. Verify restoration
# Check website in browser

# 4. If working, remove broken version
rm -rf /var/www/html/wamdevin-broken
```

#### Git Rollback

```bash
# View commit history
git log --oneline

# Revert to previous commit
git revert HEAD

# Or reset to specific commit (destructive)
git reset --hard <commit-hash>
git push -f origin main
```

#### Database Rollback (if applicable)

```bash
# Restore database from backup
mysql -u username -p database_name < backup.sql
```

---

## 📊 Performance Monitoring

### Tools to Monitor

1. **Google Analytics**
   - Page load times
   - Bounce rates
   - User behavior

2. **Google Search Console**
   - Search performance
   - Core Web Vitals
   - Coverage issues

3. **UptimeRobot** (<https://uptimerobot.com/>)
   - 99.9% uptime monitoring
   - Email alerts

4. **New Relic** (Optional)
   - Real-time performance monitoring
   - Error tracking

### Performance Benchmarks

| Metric | Target | Good | Poor |
|--------|--------|------|------|
| PageSpeed (Desktop) | 90+ | 80-90 | <80 |
| PageSpeed (Mobile) | 80+ | 70-80 | <70 |
| First Contentful Paint | <1.5s | 1.5-2.5s | >2.5s |
| Largest Contentful Paint | <2.5s | 2.5-4s | >4s |
| Time to Interactive | <3.5s | 3.5-7.3s | >7.3s |
| Total Blocking Time | <200ms | 200-600ms | >600ms |
| Cumulative Layout Shift | <0.1 | 0.1-0.25 | >0.25 |

---

## 🔧 Troubleshooting

### Common Issues and Solutions

#### Issue: CSS/JS Not Loading

**Symptoms**: Broken layout, no JavaScript functionality

**Solutions**:

1. Check file paths (relative vs absolute)
2. Verify file permissions (644 for files)
3. Check .htaccess rules
4. Clear browser cache
5. Check server error logs

```bash
# Check Apache error log
tail -f /var/log/apache2/error.log

# Check PHP error log
tail -f /var/log/php-errors.log
```

#### Issue: White Screen of Death (PHP)

**Symptoms**: Blank white page

**Solutions**:

1. Enable error reporting temporarily

```php
// Add to top of index.php (temporarily)
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

1. Check PHP error log
2. Verify PHP version compatibility
3. Check for missing PHP extensions

#### Issue: 500 Internal Server Error

**Symptoms**: Generic server error

**Solutions**:

1. Check .htaccess syntax
2. Verify PHP syntax errors
3. Check file permissions
4. Review Apache error log
5. Disable .htaccess rules one by one

#### Issue: Slow Page Load

**Symptoms**: Page takes >3 seconds to load

**Solutions**:

1. Enable Gzip compression
2. Minify CSS/JS
3. Optimize images
4. Enable browser caching
5. Use CDN for static assets
6. Reduce HTTP requests

#### Issue: Mobile Layout Broken

**Symptoms**: Desktop layout on mobile

**Solutions**:

1. Check viewport meta tag
2. Verify responsive CSS
3. Test media queries
4. Check mobile breakpoints
5. Clear mobile browser cache

#### Issue: Forms Not Submitting

**Symptoms**: Form submission fails

**Solutions**:

1. Check form action URL
2. Verify CSRF tokens
3. Check PHP mail() function
4. Verify form input names
5. Check browser console for errors

---

## 📞 Support Resources

### Documentation

- **WAMDEVIN Modernization**: README-MODERNIZATION.md
- **Refactoring Summary**: REFACTORING-SUMMARY.md
- **Project Structure**: README-MODERNIZATION.md (Section 3)

### External Resources

- **Apache Documentation**: <https://httpd.apache.org/docs/>
- **PHP Manual**: <https://www.php.net/manual/>
- **MDN Web Docs**: <https://developer.mozilla.org/>
- **W3C Validator**: <https://validator.w3.org/>
- **Can I Use**: <https://caniuse.com/>

### Testing Tools

- **PageSpeed Insights**: <https://pagespeed.web.dev/>
- **GTmetrix**: <https://gtmetrix.com/>
- **Lighthouse**: Chrome DevTools
- **WAVE**: <https://wave.webaim.org/>
- **SSL Labs**: <https://www.ssllabs.com/ssltest/>

---

## 📝 Deployment History

Keep a log of all deployments:

```
| Date       | Version | Deployed By | Changes                    | Status  |
|------------|---------|-------------|----------------------------|---------|
| 2026-02-15 | 2.0.0   | Admin       | Full modernization         | Success |
| 2026-01-20 | 1.5.0   | Admin       | Updated homepage           | Success |
```

---

## ✅ Final Checklist

Before marking deployment complete:

- [ ] All critical pages tested
- [ ] Performance targets met
- [ ] Security headers configured
- [ ] HTTPS enabled and forced
- [ ] Google Analytics installed
- [ ] Sitemap submitted
- [ ] Backups created
- [ ] Monitoring configured
- [ ] Documentation updated
- [ ] Team notified
- [ ] Stakeholders informed

---

**Deployment Completed**: ___________

**Deployed By**: ___________

**Notes**: ___________

---

*Last Updated: February 2026*
*Version: 1.0.0*
