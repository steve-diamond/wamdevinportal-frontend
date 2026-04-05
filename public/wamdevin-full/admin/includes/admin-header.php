<?php
/**
 * WAMDEVIN Admin Dashboard - Modern Header Component
 * 
 * Provides a responsive, accessible admin header with:
 * - Sidebar toggle
 * - Navigation menu
 * - Search functionality
 * - Notifications
 * - User profile dropdown
 * 
 * @version 2.0.0
 * @since February 2026
 */

// Load configuration
if (!defined('ADMIN_INIT')) {
    require_once __DIR__ . '/admin-config.php';
}

// Page defaults if not set
$pageTitle = isset($pageTitle) ? $pageTitle : ADMIN_TITLE;
$pageDescription = isset($pageDescription) ? $pageDescription : 'WAMDEVIN Admin Dashboard - Manage your institutional website';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Essential Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo sanitizeOutput($pageDescription); ?>">
    <meta name="author" content="WAMDEVIN">
    <meta name="robots" content="noindex, nofollow">
    
    <!-- Favicons -->
    <link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/images/favicon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/apple-touch-icon.png">
    
    <!-- Page Title -->
    <title><?php echo sanitizeOutput($pageTitle); ?></title>
    
    <!-- Critical CSS (Inline for performance) -->
    <style>
        /* Loading spinner */
        .admin-loader {
            position: fixed;
            inset: 0;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.3s ease;
        }
        .admin-loader-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f4f6;
            border-top-color: #1766a2;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
    
    <!-- Admin CSS Bundle -->
    <link rel="stylesheet" href="assets/css/admin.css">
    
    <!-- FullCalendar CSS (if needed) -->
    <?php if (isset($useCalendar) && $useCalendar): ?>
    <link rel="stylesheet" href="assets/vendors/calendar/fullcalendar.css">
    <?php endif; ?>
    
    <!-- Page-Specific CSS -->
    <?php if (isset($pageCSS)): ?>
        <?php foreach ((array)$pageCSS as $css): ?>
            <link rel="stylesheet" href="<?php echo $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body class="ttr-opened-sidebar ttr-pinned-sidebar">
    
    <!-- Loading Screen -->
    <div class="admin-loader" id="admin-loader">
        <div class="admin-loader-spinner"></div>
    </div>

    <!-- Accessibility Skip Link -->
    <a href="#main-content" class="skip-to-content">Skip to main content</a>

    <!-- Header Start -->
    <header class="ttr-header" role="banner">
        <div class="ttr-header-wrapper">
            
            <!-- Sidebar Toggler -->
            <div class="ttr-toggle-sidebar ttr-material-button" 
                 role="button" 
                 aria-label="Toggle sidebar navigation"
                 aria-expanded="true"
                 aria-controls="admin-sidebar">
                <i class="ti-close ttr-open-icon" aria-hidden="true"></i>
                <i class="ti-menu ttr-close-icon" aria-hidden="true"></i>
            </div>
            
            <!-- Logo -->
            <div class="ttr-logo-box">
                <div>
                    <a href="index.php" class="ttr-logo" aria-label="<?php echo SITE_NAME; ?> Home">
                        <img class="ttr-logo-mobile" 
                             alt="<?php echo SITE_NAME; ?> Logo" 
                             src="<?php echo ADMIN_LOGO_MOBILE; ?>" 
                             width="30" 
                             height="30">
                        <img class="ttr-logo-desktop" 
                             alt="<?php echo SITE_NAME; ?>" 
                             src="<?php echo ADMIN_LOGO_DESKTOP; ?>" 
                             width="160" 
                             height="27">
                    </a>
                </div>
            </div>
            
            <!-- Header Left Menu -->
            <nav class="ttr-header-menu" role="navigation" aria-label="Quick navigation">
                <ul class="ttr-header-navigation">
                    <li>
                        <a href="<?php echo SITE_URL; ?>index.php" 
                           class="ttr-material-button"
                           aria-label="View public website">
                            <i class="fa fa-home" aria-hidden="true"></i> HOME
                        </a>
                    </li>
                    <li>
                        <a href="#" 
                           class="ttr-material-button ttr-submenu-toggle"
                           aria-haspopup="true"
                           aria-expanded="false">
                            QUICK MENU <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </a>
                        <div class="ttr-header-submenu" role="menu">
                            <ul>
                                <li role="menuitem"><a href="member-institutions.php">Member Institutions</a></li>
                                <li role="menuitem"><a href="events.php">Events & Programmes</a></li>
                                <li role="menuitem"><a href="trainings.php">Trainings</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
            
            <!-- Header Right Menu -->
            <div class="ttr-header-right ttr-with-seperator">
                <ul class="ttr-header-navigation">
                    
                    <!-- Search -->
                    <li>
                        <a href="#" 
                           class="ttr-material-button ttr-search-toggle"
                           aria-label="Search dashboard">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </a>
                    </li>
                    
                    <!-- Notifications -->
                    <li>
                        <a href="#" 
                           class="ttr-material-button ttr-submenu-toggle"
                           aria-label="View notifications"
                           aria-haspopup="true">
                            <i class="fa fa-bell" aria-hidden="true"></i>
                            <span class="notification-badge" aria-label="5 unread notifications">5</span>
                        </a>
                        <div class="ttr-header-submenu noti-menu" role="menu">
                            <div class="ttr-notify-header">
                                <span class="ttr-notify-text-top">5 New</span>
                                <span class="ttr-notify-text">Notifications</span>
                            </div>
                            <div class="noti-box-list">
                                <ul>
                                    <li role="menuitem">
                                        <span class="notification-icon dashbg-gray">
                                            <i class="fa fa-user-plus" aria-hidden="true"></i>
                                        </span>
                                        <span class="notification-text">
                                            <strong>New membership request</strong>
                                            <span class="notification-detail">National School of Governance (Liberia)</span>
                                        </span>
                                        <span class="notification-time">
                                            <button class="fa fa-close" aria-label="Dismiss notification"></button>
                                            <time datetime="<?php echo date('Y-m-d\TH:i'); ?>">2 min</time>
                                        </span>
                                    </li>
                                    <li role="menuitem">
                                        <span class="notification-icon dashbg-green">
                                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                                        </span>
                                        <span class="notification-text">
                                            <strong>Event registration</strong>
                                            <span class="notification-detail">EXCO Retreat - 12 new delegates confirmed</span>
                                        </span>
                                        <span class="notification-time">
                                            <button class="fa fa-close" aria-label="Dismiss notification"></button>
                                            <time datetime="<?php echo date('Y-m-d\TH:i'); ?>">15 min</time>
                                        </span>
                                    </li>
                                    <li role="menuitem">
                                        <span class="notification-icon dashbg-primary">
                                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                        </span>
                                        <span class="notification-text">
                                            <strong>Publication review</strong>
                                            <span class="notification-detail">Leadership Insight Brief ready for approval</span>
                                        </span>
                                        <span class="notification-time">
                                            <button class="fa fa-close" aria-label="Dismiss notification"></button>
                                            <time datetime="<?php echo date('Y-m-d\TH:i'); ?>">1 hour</time>
                                        </span>
                                    </li>
                                    <li role="menuitem">
                                        <span class="notification-icon dashbg-yellow">
                                            <i class="fa fa-comments-o" aria-hidden="true"></i>
                                        </span>
                                        <span class="notification-text">
                                            <strong>Training feedback</strong>
                                            <span class="notification-detail">Train-the-Trainers workshop feedback received</span>
                                        </span>
                                        <span class="notification-time">
                                            <button class="fa fa-close" aria-label="Dismiss notification"></button>
                                            <time datetime="<?php echo date('Y-m-d\TH:i'); ?>">3 hours</time>
                                        </span>
                                    </li>
                                    <li role="menuitem">
                                        <span class="notification-icon dashbg-red">
                                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                        </span>
                                        <span class="notification-text">
                                            <strong>Pending application</strong>
                                            <span class="notification-detail">2 membership applications awaiting review</span>
                                        </span>
                                        <span class="notification-time">
                                            <button class="fa fa-close" aria-label="Dismiss notification"></button>
                                            <time datetime="<?php echo date('Y-m-d\TH:i'); ?>">Today</time>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="noti-footer">
                                <a href="notifications.php" class="btn-view-all">View All Notifications</a>
                            </div>
                        </div>
                    </li>
                    
                    <!-- User Profile -->
                    <li>
                        <a href="#" 
                           class="ttr-material-button ttr-submenu-toggle"
                           aria-label="User menu"
                           aria-haspopup="true">
                            <span class="ttr-user-avatar">
                                <img alt="Admin User" 
                                     src="assets/images/testimonials/pic3.jpg" 
                                     width="32" 
                                     height="32">
                            </span>
                        </a>
                        <div class="ttr-header-submenu" role="menu">
                            <ul>
                                <li role="menuitem"><a href="user-profile.php">My Profile</a></li>
                                <li role="menuitem"><a href="settings.php">Settings</a></li>
                                <li role="menuitem"><a href="mailbox.php">Messages</a></li>
                                <li role="separator"></li>
                                <li role="menuitem"><a href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            
            <!-- Search Panel -->
            <div class="ttr-search-bar" role="search">
                <form class="ttr-search-form" action="search.php" method="GET">
                    <label for="admin-search" class="sr-only">Search dashboard</label>
                    <div class="ttr-search-input-wrapper">
                        <input type="search" 
                               id="admin-search"
                               name="q" 
                               placeholder="Search dashboard..." 
                               class="ttr-search-input"
                               aria-label="Search">
                        <button type="submit" 
                                class="ttr-search-submit"
                                aria-label="Submit search">
                            <i class="ti-arrow-right" aria-hidden="true"></i>
                        </button>
                    </div>
                    <button type="button" 
                            class="ttr-search-close ttr-search-toggle"
                            aria-label="Close search">
                        <i class="ti-close" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
            
        </div>
    </header>
    <!-- Header End -->
