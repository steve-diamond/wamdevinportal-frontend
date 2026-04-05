<?php
/**
 * Modern Header Component
 * WAMDEVIN Website - Version 2.0.0
 * 
 * This component provides a semantic, accessible header with:
 * - Language switching
 * - Responsive navigation
 * - Search functionality
 * - Social media links
 */

// Ensure language system is loaded
if (!class_exists('WamdevinLanguage')) {
    require_once __DIR__ . '/language.php';
}
?>
<!DOCTYPE html>
<html lang="<?php echo WamdevinLanguage::getLanguageCode(); ?>">
<head>
    <!-- Essential Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- SEO Meta Tags -->
    <meta name="keywords" content="<?php echo isset($pageKeywords) ? $pageKeywords : 'WAMDEVIN, West African Management Development, Public Administration Training, Capacity Building, Regional Collaboration, Management Development Institutes, West Africa'; ?>">
    <meta name="author" content="WAMDEVIN - West African Management Development Institutes Network">
    <meta name="robots" content="index, follow">
    <meta name="description" content="<?php echo isset($pageDescription) ? $pageDescription : 'WAMDEVIN - West African Management Development Institutes Network. Enhancing public sector excellence through training, research, consultancy, and regional collaboration across West Africa since 1987.'; ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="WAMDEVIN">
    <meta property="og:title" content="<?php echo isset($pageTitle) ? $pageTitle : 'WAMDEVIN - West African Management Development Institutes Network'; ?>">
    <meta property="og:description" content="<?php echo isset($pageDescription) ? $pageDescription : 'Enhancing public sector excellence through training, research, consultancy, and regional collaboration across West Africa since 1987.'; ?>">
    <meta property="og:image" content="<?php echo isset($pageImage) ? $pageImage : 'assets/images/logo-white.png'; ?>">
    <meta property="og:url" content="<?php echo isset($pageUrl) ? $pageUrl : ''; ?>">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo isset($pageTitle) ? $pageTitle : 'WAMDEVIN - West African Management Development Institutes Network'; ?>">
    <meta name="twitter:description" content="<?php echo isset($pageDescription) ? $pageDescription : 'Enhancing public sector excellence across West Africa since 1987.'; ?>">
    <meta name="twitter:image" content="<?php echo isset($pageImage) ? $pageImage : 'assets/images/logo-white.png'; ?>">
    
    <!-- Favicon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    
    <!-- Page Title -->
    <title><?php echo isset($pageTitle) ? $pageTitle : 'WAMDEVIN - West African Management Development Institutes Network | Public Sector Excellence'; ?></title>
    
    <!-- Preconnect to External Domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://flagcdn.com">
    
    <!-- Critical CSS (Inline for performance) -->
    <style>
        /* Critical above-the-fold styles */
        body { margin: 0; font-family: system-ui, -apple-system, sans-serif; }
        .loading { position: fixed; inset: 0; background: #fff; display: flex; align-items: center; justify-content: center; z-index: 9999; }
        .spinner { width: 60px; height: 60px; border: 4px solid #eee; border-top-color: #1766a2; border-radius: 50%; animation: spin 0.8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700;800&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer">
    
    <!-- Modern Unified CSS -->
    <link rel="stylesheet" href="css/modern.css">
    
    <!-- Legacy CSS (for backward compatibility - will be phased out) -->
    <?php if (isset($includeLegacyCSS) && $includeLegacyCSS): ?>
    <link rel="stylesheet" href="assets/css/assets.css">
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/shortcodes/shortcodes.css">
    <link rel="stylesheet" href="assets/css/color/color-1.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <?php endif; ?>
    
    <!-- Page-Specific CSS -->
    <?php if (isset($pageCSS)): ?>
        <?php foreach ((array)$pageCSS as $css): ?>
            <link rel="stylesheet" href="<?php echo $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Revolution Slider CSS (if needed) -->
    <?php if (isset($useRevolutionSlider) && $useRevolutionSlider): ?>
    <link rel="stylesheet" href="assets/vendors/revolution/css/layers.css">
    <link rel="stylesheet" href="assets/vendors/revolution/css/settings.css">
    <link rel="stylesheet" href="assets/vendors/revolution/css/navigation.css">
    <?php endif; ?>
    
    <!-- Owl Carousel (if needed) -->
    <?php if (isset($useOwlCarousel) && $useOwlCarousel): ?>
    <link rel="stylesheet" href="lib/owlcarousel/assets/owl.carousel.min.css">
    <?php endif; ?>
</head>
<body id="bg" class="<?php echo isset($bodyClass) ? $bodyClass : ''; ?>">
    
    <!-- Skip to Main Content (Accessibility) -->
    <a href="#main-content" class="skip-to-main">Skip to main content</a>
    
    <!-- Loading Screen -->
    <div id="loading-icon-bx" class="loading" aria-hidden="true">
        <div class="spinner" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    
    <!-- Page Wrapper -->
    <div class="page-wraper">
        
        <!-- Header -->
        <header class="header <?php echo isset($headerClass) ? $headerClass : 'header-transparent'; ?>" role="banner">
            
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="container">
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="topbar-left">
                            <!-- Optional: Contact info, hours, etc. -->
                        </div>
                        <div class="topbar-right">
                            <ul>
                                <!-- Language Switcher -->
                                <li>
                                    <div class="custom-dropdown" role="navigation" aria-label="Language Selector">
                                        <button class="dropbtn" aria-haspopup="true" aria-expanded="false">
                                            <img src="https://flagcdn.com/gb.svg" alt="English (UK)" class="flag-icon" width="20" height="15"> 
                                            <span class="dropdown-text">English UK</span>
                                            <span class="arrow" aria-hidden="true">▼</span>
                                        </button>
                                        <ul class="dropdown-content" role="menu">
                                            <li role="menuitem" data-value="en-uk">
                                                <img src="https://flagcdn.com/gb.svg" alt="English (UK)" class="flag-icon" width="20" height="15"> English UK
                                            </li>
                                            <li role="menuitem" data-value="en-us">
                                                <img src="https://flagcdn.com/us.svg" alt="English (US)" class="flag-icon" width="20" height="15"> English US
                                            </li>
                                            <li role="menuitem" data-value="fr">
                                                <img src="https://flagcdn.com/fr.svg" alt="French" class="flag-icon" width="20" height="15"> French
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li><a href="login.php" data-translate="header.loginAlumni">Login Alumni</a></li>
                                <li><a href="register.php" data-translate="header.registerAlumni">Register Alumni</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Navigation -->
            <div class="sticky-header navbar-expand-lg">
                <div class="menu-bar">
                    <div class="container">
                        
                        <!-- Logo -->
                        <div class="menu-logo">
                            <a href="index.php" aria-label="WAMDEVIN Home">
                                <img src="assets/images/logo-white.png" alt="WAMDEVIN Logo" width="160" height="50" loading="eager">
                            </a>
                        </div>
                        
                        <!-- Mobile Menu Toggle -->
                        <button class="navbar-toggler collapsed menuicon" 
                                type="button" 
                                data-toggle="collapse" 
                                data-target="#menuDropdown" 
                                aria-controls="menuDropdown" 
                                aria-expanded="false" 
                                aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                        
                        <!-- Secondary Actions (Search, Social) -->
                        <div class="secondary-menu">
                            <div class="secondary-inner">
                                <ul>
                                    <li>
                                        <a href="https://facebook.com/wamdevin" 
                                           class="btn-link" 
                                           target="_blank" 
                                           rel="noopener noreferrer" 
                                           aria-label="Follow us on Facebook">
                                            <i class="fab fa-facebook" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/wamdevin" 
                                           class="btn-link" 
                                           target="_blank" 
                                           rel="noopener noreferrer" 
                                           aria-label="Follow us on Twitter">
                                            <i class="fab fa-twitter" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://linkedin.com/company/wamdevin" 
                                           class="btn-link" 
                                           target="_blank" 
                                           rel="noopener noreferrer" 
                                           aria-label="Follow us on LinkedIn">
                                            <i class="fab fa-linkedin" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li class="search-btn">
                                        <button id="quik-search-btn" 
                                                type="button" 
                                                class="btn-link" 
                                                aria-label="Open search">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Search Box -->
                        <div class="nav-search-bar">
                            <form action="search.php" method="GET" role="search">
                                <label for="search-input" class="visually-hidden">Search</label>
                                <input id="search-input" 
                                       name="q" 
                                       type="search" 
                                       class="form-control" 
                                       placeholder="Type to search..." 
                                       autocomplete="off">
                                <button type="submit" aria-label="Submit search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </form>
                            <button id="search-remove" aria-label="Close search">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </div>
                        
                        <!-- Main Navigation Menu -->
                        <nav class="menu-links navbar-collapse collapse" id="menuDropdown" role="navigation" aria-label="Main navigation">
                            <div class="menu-logo">
                                <a href="index.php" aria-label="WAMDEVIN Home">
                                    <img src="assets/images/logo.png" alt="WAMDEVIN Logo" width="160" height="50" loading="lazy">
                                </a>
                            </div>
                            
                            <ul class="nav navbar-nav">
                                <li class="<?php echo (isset($currentPage) ? $currentPage : '') === 'home' ? 'active' : ''; ?>">
                                    <a href="index.php" data-translate="nav.home" <?php echo (isset($currentPage) ? $currentPage : '') === 'home' ? 'aria-current="page"' : ''; ?>>Home</a>
                                </li>
                                
                                <li class="<?php echo (isset($currentPage) ? $currentPage : '') === 'about' ? 'active' : ''; ?>">
                                    <a href="about.php" data-translate="nav.about">
                                        About <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                    </a>
                                    <ul class="sub-menu">
                                        <li><a href="membership.php" data-translate="nav.membership">Membership</a></li>
                                        <li><a href="partners.php" data-translate="nav.partners">Partners</a></li>
                                        <li><a href="projects.php" data-translate="nav.projects">Projects</a></li>
                                    </ul>
                                </li>
                                
                                <li class="<?php echo (isset($currentPage) ? $currentPage : '') === 'leadership' ? 'active' : ''; ?>">
                                    <a href="leadership.php" data-translate="nav.leadership">Leadership</a>
                                </li>
                                
                                <li class="<?php echo (isset($currentPage) ? $currentPage : '') === 'services' ? 'active' : ''; ?>">
                                    <a href="service.php" data-translate="nav.services">
                                        Services <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                    </a>
                                    <ul class="sub-menu">
                                        <li><a href="trainners.php" data-translate="nav.training">Training</a></li>
                                        <li><a href="research.php" data-translate="nav.research">Research</a></li>
                                        <li><a href="publication.php" data-translate="nav.publication">Publication</a></li>
                                        <li><a href="consultancy.php" data-translate="nav.consultancy">Consultancy</a></li>
                                    </ul>
                                </li>
                                
                                <li class="<?php echo (isset($currentPage) ? $currentPage : '') === 'blog' ? 'active' : ''; ?>">
                                    <a href="blog.php" data-translate="nav.blogs">Blogs</a>
                                </li>
                                
                                <li class="<?php echo (isset($currentPage) ? $currentPage : '') === 'gallery' ? 'active' : ''; ?>">
                                    <a href="gallery.php" data-translate="nav.gallery">Gallery</a>
                                </li>
                                
                                <li class="nav-dashboard">
                                    <a href="javascript:void(0);" data-translate="nav.portal">
                                        Portal <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                    </a>
                                    <ul class="sub-menu">
                                        <li><a href="login.php" data-translate="nav.login">Login</a></li>
                                        <li><a href="register.php" data-translate="nav.register">Register</a></li>
                                    </ul>
                                </li>
                                
                                <li class="<?php echo (isset($currentPage) ? $currentPage : '') === 'contact' ? 'active' : ''; ?>">
                                    <a href="contact.php" data-translate="nav.contact">Contact</a>
                                </li>
                            </ul>
                            
                            <!-- Mobile Social Links -->
                            <div class="nav-social-link">
                                <a href="https://facebook.com/wamdevin" target="_blank" rel="noopener" aria-label="Facebook">
                                    <i class="fab fa-facebook" aria-hidden="true"></i>
                                </a>
                                <a href="https://twitter.com/wamdevin" target="_blank" rel="noopener" aria-label="Twitter">
                                    <i class="fab fa-twitter" aria-hidden="true"></i>
                                </a>
                                <a href="https://linkedin.com/company/wamdevin" target="_blank" rel="noopener" aria-label="LinkedIn">
                                    <i class="fab fa-linkedin" aria-hidden="true"></i>
                                </a>
                            </div>
                        </nav>
                        
                    </div>
                </div>
            </div>
        </header>
        <!-- Header End -->

