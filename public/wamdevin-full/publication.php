<!DOCTYPE html>
<html lang="en">

<head>

	<!-- META ============================================= -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="WAMDEVIN publications, MDI research papers, West African management development journals, academic publications, management research, training materials, educational resources, WAMDEVIN studies, faculty publications, research journals" />
	<meta name="author" content="West African Management Development Institutes Network (WAMDEVIN)" />
	<meta name="robots" content="index, follow" />
	
	<!-- DESCRIPTION -->
	<meta name="description" content="WAMDEVIN Publications Hub - Access comprehensive research papers, academic journals, training materials, and educational resources from West African Management Development Institutes." />
	
	<!-- OG -->
	<meta property="og:title" content="WAMDEVIN Publications Hub - Academic Research & Training Materials" />
	<meta property="og:description" content="Explore WAMDEVIN's extensive collection of research papers, academic journals, and training materials from leading Management Development Institutes across West Africa." />
	<meta property="og:image" content="assets/images/logo-white.png" />
	<meta property="og:url" content="https://www.wamdevin.com/publication.php" />
	<meta property="og:type" content="website" />
	<meta property="og:site_name" content="WAMDEVIN - West African Management Development Institutes Network" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- TWITTER CARD -->
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:title" content="WAMDEVIN Publications - Academic Research Hub" />
	<meta name="twitter:description" content="Access comprehensive academic publications, research papers, and training materials from West African Management Development Institutes." />
	<meta name="twitter:image" content="assets/images/logo-white.png" />
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>WAMDEVIN Publications Hub - Academic Research & Training Materials</title>
	
	<!-- MOBILE SPECIFIC ============================================= -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!--[if lt IE 9]>
	<script src="assets/js/php5shiv.min.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
	
	<!-- All PLUGINS CSS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/assets.css">
	
	<!-- FONT AWESOME -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	
	<!-- TYPOGRAPHY ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/typography.css">
	
	<!-- SHORTCODES ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/shortcodes/shortcodes.css">
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">
	<link rel="stylesheet" type="text/css" href="assets/css/index-enhancements.css">
	
	<!-- AOS Animation Library -->
	<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
	
	<!-- PUBLICATION PAGE SPECIFIC STYLES -->
	<style>
		/* Professional Publication Page Styles */
		body { 
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
			line-height: 1.6; 
		}
		
		/* Enhanced Publication Hero Banner */
		.page-banner {
			background: linear-gradient(135deg, rgba(23, 102, 162, 0.95), rgba(243, 156, 18, 0.9)), url('assets/images/banner/banner2.jpg');
			background-size: cover;
			background-position: center;
			min-height: 70vh;
			display: flex;
			align-items: center;
			position: relative;
		}
		
		.page-banner::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background: rgba(0,0,0,0.3);
			z-index: 1;
		}
		
		.page-banner-entry {
			position: relative;
			z-index: 2;
			text-align: center;
		}
		
		.page-banner h1 {
			font-size: 3.8rem;
			font-weight: 800;
			color: white;
			margin-bottom: 20px;
			text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
		}
		
		/* Professional Publication Content Styling */
		.content-block {
			background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
		}
		
		/* Publication Cards */
		.publication-card {
			background: white;
			border-radius: 20px;
			box-shadow: 0 15px 35px rgba(0,0,0,0.12);
			padding: 30px;
			margin-bottom: 30px;
			border-left: 5px solid #1766a2;
			transition: all 0.3s ease;
			position: relative;
			overflow: hidden;
		}
		
		.publication-card::before {
			content: '';
			position: absolute;
			top: 0;
			right: 0;
			width: 100px;
			height: 100px;
			background: linear-gradient(135deg, rgba(243, 156, 18, 0.1), rgba(243, 156, 18, 0.05));
			border-radius: 50%;
			transform: translate(30px, -30px);
		}
		
		.publication-card:hover {
			transform: translateY(-8px);
			box-shadow: 0 25px 50px rgba(0,0,0,0.18);
			border-left-color: #f39c12;
		}
		
		.publication-meta {
			background: linear-gradient(135deg, rgba(23, 102, 162, 0.06), rgba(243, 156, 18, 0.06));
			padding: 15px;
			border-radius: 12px;
			margin-bottom: 20px;
			border: 1px solid rgba(243, 156, 18, 0.15);
		}
		
		.publication-meta ul {
			list-style: none;
			padding: 0;
			margin: 0;
			display: flex;
			gap: 20px;
			flex-wrap: wrap;
		}
		
		.publication-meta li {
			color: #666;
			font-size: 0.9rem;
		}
		
		.publication-meta i {
			color: #f39c12;
			margin-right: 8px;
		}
		
		.publication-title {
			color: #1766a2;
			font-weight: 700;
			margin-bottom: 15px;
			font-size: 1.4rem;
		}
		
		.publication-title a {
			color: #1766a2;
			text-decoration: none;
			transition: color 0.3s ease;
		}
		
		.publication-title a:hover {
			color: #f39c12;
		}
		
		.publication-excerpt {
			color: #666;
			line-height: 1.7;
			margin-bottom: 20px;
			text-align: justify;
		}
		
		.publication-actions {
			display: flex;
			justify-content: space-between;
			align-items: center;
			flex-wrap: wrap;
			gap: 15px;
		}
		
		.btn-read-more {
			background: linear-gradient(135deg, #1766a2, #2980b9);
			color: white;
			padding: 12px 25px;
			border-radius: 25px;
			text-decoration: none;
			font-weight: 600;
			transition: all 0.3s ease;
			border: none;
		}
		
		.btn-read-more:hover {
			background: linear-gradient(135deg, #f39c12, #e67e22);
			color: white;
			transform: translateY(-2px);
			box-shadow: 0 8px 20px rgba(243, 156, 18, 0.3);
		}
		
		.btn-download {
			background: linear-gradient(135deg, #27ae60, #2ecc71);
			color: white;
			padding: 10px 20px;
			border-radius: 20px;
			text-decoration: none;
			font-weight: 600;
			font-size: 0.9rem;
			transition: all 0.3s ease;
		}
		
		.btn-download:hover {
			background: linear-gradient(135deg, #e74c3c, #c0392b);
			color: white;
			transform: translateY(-2px);
		}
		
		.publication-stats {
			color: #666;
			font-size: 0.9rem;
		}
		
		.publication-stats i {
			color: #f39c12;
			margin-right: 5px;
		}
		
		/* Enhanced Sidebar */
		.sidebar-widget {
			background: white;
			border-radius: 15px;
			box-shadow: 0 8px 25px rgba(0,0,0,0.08);
			padding: 30px;
			margin-bottom: 30px;
			border-left: 4px solid #1766a2;
		}
		
		.sidebar-widget h6 {
			color: #1766a2;
			font-weight: 700;
			margin-bottom: 20px;
			border-bottom: 2px solid #f39c12;
			padding-bottom: 10px;
		}
		
		/* Publication Categories */
		.category-item {
			background: rgba(23, 102, 162, 0.1);
			padding: 15px;
			border-radius: 12px;
			margin-bottom: 15px;
			border-left: 4px solid #1766a2;
			transition: all 0.3s ease;
		}
		
		.category-item:hover {
			background: rgba(243, 156, 18, 0.1);
			border-left-color: #f39c12;
		}
		
		.category-count {
			background: #f39c12;
			color: white;
			padding: 4px 8px;
			border-radius: 12px;
			font-size: 0.8rem;
			font-weight: 600;
		}
		
		/* Featured Publications */
		.featured-publication {
			background: linear-gradient(135deg, rgba(243, 156, 18, 0.1), rgba(230, 126, 34, 0.1));
			border: 2px solid rgba(243, 156, 18, 0.3);
			border-radius: 15px;
			padding: 20px;
			margin-bottom: 20px;
		}
		
		.featured-badge {
			background: linear-gradient(135deg, #f39c12, #e67e22);
			color: white;
			padding: 5px 12px;
			border-radius: 15px;
			font-size: 0.8rem;
			font-weight: 600;
			display: inline-block;
			margin-bottom: 10px;
		}
		
		/* Pagination Enhancement */
		.pagination-bx {
			background: white;
			border-radius: 15px;
			box-shadow: 0 8px 25px rgba(0,0,0,0.08);
			padding: 20px;
		}
		
		.pagination li a {
			background: transparent;
			border: 2px solid #1766a2;
			color: #1766a2;
			border-radius: 8px;
			margin: 0 5px;
			padding: 10px 15px;
			transition: all 0.3s ease;
		}
		
		.pagination li.active a,
		.pagination li a:hover {
			background: #1766a2;
			color: white;
		}
		
		/* Responsive Design */
		@media (max-width: 768px) {
			.page-banner h1 {
				font-size: 2.8rem;
			}
			
			.publication-card {
				padding: 20px;
			}
			
			.publication-actions {
				flex-direction: column;
				align-items: stretch;
			}
		}
		
		/* Enhanced Animations */
		@keyframes fadeInUp {
			from {
				opacity: 0;
				transform: translateY(30px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}
		
		.publication-card {
			animation: fadeInUp 0.8s ease forwards;
		}
		
		/* Publication Type Badges */
		.publication-type {
			display: inline-block;
			padding: 6px 12px;
			border-radius: 15px;
			font-size: 0.8rem;
			font-weight: 600;
			margin-bottom: 10px;
		}
		
		.type-journal {
			background: rgba(52, 152, 219, 0.2);
			color: #3498db;
			border: 1px solid rgba(52, 152, 219, 0.3);
		}
		
		.type-research {
			background: rgba(155, 89, 182, 0.2);
			color: #9b59b6;
			border: 1px solid rgba(155, 89, 182, 0.3);
		}
		
		.type-manual {
			background: rgba(39, 174, 96, 0.2);
			color: #27ae60;
			border: 1px solid rgba(39, 174, 96, 0.3);
		}
		
		.type-report {
			background: rgba(230, 126, 34, 0.2);
			color: #e67e22;
			border: 1px solid rgba(230, 126, 34, 0.3);
		}
    </style>
	
</head>
<body id="bg">
<div class="page-wraper">
	<div id="loading-icon-bx"></div>
    <!-- Header Top ==== -->
    <header class="header rs-nav">
		<div class="top-bar">
			<div class="container">
				<div class="row d-flex justify-content-between">
					<div class="topbar-left">
						<ul>
							<li><a href="membership.php#accordion1"><i class="fa fa-question-circle"></i>Ask a Question</a></li>
							<li><a href="javascript:;"><i class="fa fa-envelope-o"></i>info@WAMDEVIN.com</a></li>
						</ul>
					</div>
					<div class="topbar-right">
						<ul>
							<li>
								<select class="header-lang-bx">
									<option data-icon="flag flag-uk">English UK</option>
									<option data-icon="flag flag-us">English US</option>
									<option data-icon="flag flag-us">French FR</option>
								</select>
							</li>
							<li class="portal-menu-item">
								<a href="#" class="portal-menu-toggle" style="color: #f39c12; font-weight: 700;">
									<i class="fa fa-sign-in-alt"></i> Portal Access <i class="fa fa-chevron-down"></i>
								</a>
								<ul class="portal-submenu">
									<li class="submenu-title" style="padding: 10px 15px; background: #f39c12; color: white; font-weight: 700; border-radius: 5px 5px 0 0; margin-bottom: 5px;">
										Institution Portal
									</li>
									<li><a href="login.php" style="color: #1766a2;"><i class="fa fa-lock"></i> Institution Login</a></li>
									<li><a href="register.php" style="color: #f39c12;"><i class="fa fa-user-plus"></i> Register Institution</a></li>
									<li style="border-top: 1px solid #e0e0e0; padding-top: 5px; margin-top: 5px; padding-bottom: 5px;">
										<a href="admin/login.php" style="color: #1766a2;"><i class="fa fa-shield"></i> Admin Access</a>
									</li>
									<li><a href="membership.php" style="color: #2c3e50;"><i class="fa fa-graduation-cap"></i> Alumni Portal</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="sticky-header navbar-expand-lg">
            <div class="menu-bar clearfix">
                <div class="container clearfix">
					<!-- Header Logo ==== -->
					<div class="menu-logo">
						<a href="index.php"><img src="assets/images/logo.png" alt="WAMDEVIN logo"></a>
					</div>
					<!-- Mobile Nav Button ==== -->
                    <button class="navbar-toggler collapsed menuicon justify-content-end" type="button" data-toggle="collapse" data-target="#menuDropdown" aria-controls="menuDropdown" aria-expanded="false" aria-label="Toggle navigation">
						<span></span>
						<span></span>
						<span></span>
					</button>
					<!-- Author Nav ==== -->
                    <div class="secondary-menu">
                        <div class="secondary-inner">
                            <ul>
								<li><a href="javascript:;" class="btn-link"><i class="fa fa-facebook"></i></a></li>
								<li><a href="javascript:;" class="btn-link"><i class="fa fa-google-plus"></i></a></li>
								<li><a href="javascript:;" class="btn-link"><i class="fa fa-linkedin"></i></a></li>
								<!-- Search Button ==== -->
								<li class="search-btn"><button id="quik-search-btn" type="button" class="btn-link"><i class="fa fa-search"></i></button></li>
							</ul>
						</div>
                    </div>
					<!-- Search Box ==== -->
                    <div class="nav-search-bar">
                        <form action="#">
                            <input name="search" value="" type="text" class="form-control" placeholder="Type to search">
                            <span><i class="ti-search"></i></span>
                        </form>
						<span id="search-remove"><i class="ti-close"></i></span>
                    </div>
					
					<!-- Navigation Menu ==== -->
                    <div class="menu-links navbar-collapse collapse justify-content-start" id="menuDropdown">
						<div class="menu-logo">
							<a href="index.php"><img src="assets/images/logo.png" alt="WAMDEVIN logo"></a>
						</div>
                        <ul class="nav navbar-nav">	
							<li><a href="index.php">Home</a></li>
							<li><a href="about.php">About <i class="fa fa-chevron-down"></i></a>
								<ul class="sub-menu">
									<li><a href="membership.php">Membership</a></li>
									<li><a href="partners.php">Partners</a></li>
									<li><a href="projects.php">Projects</a></li>
								</ul>
							</li>
							<li class="add-mega-menu">
								<a href="leadership.php">Leadership</a>
							</li>
							<li><a href="service.php">Services </a>
								<ul class="sub-menu">
									<li><a href="trainners.php">Training </a></li>
									<li><a href="research.php">Research</a></li>
									<li><a href="publication.php">Publication</a></li>
									<li><a href="consultancy.php">Consultancy</a></li>
								</ul>
							</li>
							<li><a href="blog.php">Blogs</a></li>
							<li><a href="gallery.php">Gallery</a></li>
							<li class="nav-dashboard"><a href="javascript:;">Portal</a>
								<ul class="sub-menu">
									<li><a href="login.php">Login</a></li>
									<li><a href="register.php">Register</a></li>
								</ul>
							</li>
							<li><a href="contact.php">Contact</a></li>
						</ul>
						<div class="nav-social-link">
							<a href="javascript:;"><i class="fa fa-facebook"></i></a>
							<a href="javascript:;"><i class="fa fa-google-plus"></i></a>
							<a href="javascript:;"><i class="fa fa-linkedin"></i></a>
						</div>
                    </div>
					<!-- Navigation Menu END ==== -->
                </div>
            </div>
        </div>
    </header>
    <!-- header END ==== -->
    <!-- Content -->
    <div class="page-content bg-white">
        <!-- Enhanced Professional Publication Hero Banner -->
        <div class="page-banner ovbl-dark" style="background-image: linear-gradient(135deg, rgba(23, 102, 162, 0.95), rgba(243, 156, 18, 0.9)), url(assets/images/banner/banner2.jpg);">
            <div class="container">
                <div class="page-banner-entry" data-aos="fade-up">
                    <div style="background: rgba(255,255,255,0.12); backdrop-filter: blur(15px); padding: 45px; border-radius: 25px; border: 1px solid rgba(255,255,255,0.25); box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
                        <h1 class="text-white" style="font-size: 3.8rem; font-weight: 800; margin-bottom: 25px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                            <i class="fas fa-book-open" style="color: #f39c12; margin-right: 15px;"></i>
                            WAMDEVIN <span style="color: #f39c12;">PUBLICATIONS</span>
                        </h1>
                        <h3 style="color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 25px; font-size: 1.6rem;">
                            Academic Research & Training Materials Hub
                        </h3>
                        <p style="color: rgba(255,255,255,0.9); font-size: 1.3rem; line-height: 1.7; margin-bottom: 35px;">
                            Access comprehensive research papers, academic journals, training materials, and educational resources 
                            from leading Management Development Institutes across West Africa
                        </p>
                        <div style="display: flex; gap: 25px; justify-content: center; flex-wrap: wrap; margin-bottom: 20px;">
                            <div style="background: rgba(243, 156, 18, 0.25); padding: 18px 28px; border-radius: 12px; text-align: center; border: 1px solid rgba(243, 156, 18, 0.3);">
                                <i class="fas fa-journal-whills" style="color: #f39c12; font-size: 1.8rem; margin-bottom: 12px; display: block;"></i>
                                <span style="color: white; font-weight: 600; font-size: 1.1rem;">Academic Journals</span>
                            </div>
                            <div style="background: rgba(243, 156, 18, 0.25); padding: 18px 28px; border-radius: 12px; text-align: center; border: 1px solid rgba(243, 156, 18, 0.3);">
                                <i class="fas fa-file-alt" style="color: #f39c12; font-size: 1.8rem; margin-bottom: 12px; display: block;"></i>
                                <span style="color: white; font-weight: 600; font-size: 1.1rem;">Research Papers</span>
                            </div>
                            <div style="background: rgba(243, 156, 18, 0.25); padding: 18px 28px; border-radius: 12px; text-align: center; border: 1px solid rgba(243, 156, 18, 0.3);">
                                <i class="fas fa-graduation-cap" style="color: #f39c12; font-size: 1.8rem; margin-bottom: 12px; display: block;"></i>
                                <span style="color: white; font-weight: 600; font-size: 1.1rem;">Training Materials</span>
                            </div>
                            <div style="background: rgba(243, 156, 18, 0.25); padding: 18px 28px; border-radius: 12px; text-align: center; border: 1px solid rgba(243, 156, 18, 0.3);">
                                <i class="fas fa-download" style="color: #f39c12; font-size: 1.8rem; margin-bottom: 12px; display: block;"></i>
                                <span style="color: white; font-weight: 600; font-size: 1.1rem;">Resources</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- Enhanced Professional Breadcrumb -->
		<div class="breadcrumb-row" style="background: linear-gradient(135deg, #f8f9fa, #ffffff); padding: 25px 0; border-bottom: 1px solid #eee;">
			<div class="container">
				<ul class="list-inline" style="margin: 0; display: flex; align-items: center; justify-content: center;">
					<li style="margin-right: 15px;">
						<a href="index.php" style="color: #1766a2; text-decoration: none; font-weight: 600; display: flex; align-items: center;">
							<i class="fas fa-home" style="margin-right: 8px; color: #f39c12;"></i>Home
						</a>
					</li>
					<li style="color: #666; margin-right: 15px;">
						<i class="fas fa-chevron-right" style="color: #ccc;"></i>
					</li>
					<li style="color: #666; font-weight: 600;">
						<i class="fas fa-book-open" style="margin-right: 8px; color: #f39c12;"></i>
						Publications Hub
					</li>
				</ul>
			</div>
		</div>
		<!-- Breadcrumb row END -->
        <!-- Enhanced Publication Content Area -->
         <div class="content-block" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); padding: 60px 0;">
			<div class="section-area section-sp1">
				<div class="container">
					<div class="row">
						<!-- Publications Content -->
						<div class="col-lg-8">
							<!-- Featured Publication -->
							<div class="featured-publication" data-aos="fade-up">
								<div class="featured-badge">
									<i class="fas fa-star" style="margin-right: 5px;"></i>Featured Publication
								</div>
								<div class="publication-type type-journal">Academic Journal</div>
								<h3 style="color: #1766a2; font-weight: 700; margin-bottom: 15px;">
									West African Management Development Review (WAMDR)
								</h3>
								<p style="color: #666; line-height: 1.7; margin-bottom: 20px;">
									The flagship academic journal of WAMDEVIN, featuring peer-reviewed research on management development, 
									leadership training, and organizational excellence across West African institutions.
								</p>
								<div style="display: flex; gap: 15px; flex-wrap: wrap;">
									<a href="#" class="btn-read-more">
										<i class="fas fa-eye" style="margin-right: 8px;"></i>View Latest Issue
									</a>
									<a href="#" class="btn-download">
										<i class="fas fa-download" style="margin-right: 5px;"></i>Download PDF
									</a>
								</div>
							</div>

							<!-- Publication 1: Training Needs Analysis -->
							<div class="publication-card" data-aos="fade-up">
								<div class="publication-type type-research">Research Report</div>
								<div class="publication-meta">
									<ul>
										<li><i class="fa fa-calendar"></i>Published: December 2017</li>
										<li><i class="fa fa-user"></i>WAMDEVIN Research Team</li>
										<li><i class="fa fa-eye"></i>2,450 views</li>
										<li><i class="fa fa-download"></i>890 downloads</li>
									</ul>
								</div>
								<h5 class="publication-title">
									<a href="#">Training Needs Analysis of West African Management Development Institutes</a>
								</h5>
								<p class="publication-excerpt">
									A comprehensive study investigating the skills gaps among faculty staff of MDIs across the West African Sub-region. 
									This pioneering research analyzed 17 institutions to identify critical training needs and development priorities 
									for enhanced management education delivery.
								</p>
								<div class="publication-actions">
									<a href="#" class="btn-read-more">
										<i class="fas fa-eye" style="margin-right: 8px;"></i>Read Full Report
									</a>
									<div class="publication-stats">
										<span><i class="fas fa-file-pdf"></i>PDF Available</span>
										<span style="margin-left: 15px;"><i class="fas fa-quote-left"></i>45 Citations</span>
									</div>
								</div>
							</div>

							<!-- Publication 2: Online Training Impact -->
							<div class="publication-card" data-aos="fade-up" data-aos-delay="100">
								<div class="publication-type type-research">Impact Assessment</div>
								<div class="publication-meta">
									<ul>
										<li><i class="fa fa-calendar"></i>Published: March 2021</li>
										<li><i class="fa fa-user"></i>WAMDEVIN Secretariat</li>
										<li><i class="fa fa-eye"></i>3,120 views</li>
										<li><i class="fa fa-download"></i>1,250 downloads</li>
									</ul>
								</div>
								<h5 class="publication-title">
									<a href="#">Assessment of WAMDEVIN Online Training Programme Impact on Faculty Staff</a>
								</h5>
								<p class="publication-excerpt">
									An extensive evaluation of online training effectiveness during the COVID-19 pandemic, analyzing performance 
									improvements and digital skills enhancement among MDI faculty across 14 member institutions with 98 respondents.
								</p>
								<div class="publication-actions">
									<a href="#" class="btn-read-more">
										<i class="fas fa-eye" style="margin-right: 8px;"></i>Read Assessment
									</a>
									<div class="publication-stats">
										<span><i class="fas fa-file-pdf"></i>PDF Available</span>
										<span style="margin-left: 15px;"><i class="fas fa-quote-left"></i>32 Citations</span>
									</div>
								</div>
							</div>

							<!-- Publication 3: Management Development Manual -->
							<div class="publication-card" data-aos="fade-up" data-aos-delay="200">
								<div class="publication-type type-manual">Training Manual</div>
								<div class="publication-meta">
									<ul>
										<li><i class="fa fa-calendar"></i>Updated: October 2023</li>
										<li><i class="fa fa-user"></i>WAMDEVIN Training Committee</li>
										<li><i class="fa fa-eye"></i>4,890 views</li>
										<li><i class="fa fa-download"></i>2,100 downloads</li>
									</ul>
								</div>
								<h5 class="publication-title">
									<a href="#">Best Practices in Management Development Training</a>
								</h5>
								<p class="publication-excerpt">
									A comprehensive manual outlining proven methodologies, innovative approaches, and successful case studies 
									in management development training across West African institutions. Essential resource for faculty and trainers.
								</p>
								<div class="publication-actions">
									<a href="#" class="btn-read-more">
										<i class="fas fa-eye" style="margin-right: 8px;"></i>View Manual
									</a>
									<div class="publication-stats">
										<span><i class="fas fa-file-pdf"></i>PDF Available</span>
										<span style="margin-left: 15px;"><i class="fas fa-users"></i>Used by 15 MDIs</span>
									</div>
								</div>
							</div>

							<!-- Publication 4: Leadership Excellence Guide -->
							<div class="publication-card" data-aos="fade-up" data-aos-delay="300">
								<div class="publication-type type-manual">Leadership Guide</div>
								<div class="publication-meta">
									<ul>
										<li><i class="fa fa-calendar"></i>Published: June 2023</li>
										<li><i class="fa fa-user"></i>WAMDEVIN Leadership Council</li>
										<li><i class="fa fa-eye"></i>2,780 views</li>
										<li><i class="fa fa-download"></i>1,450 downloads</li>
									</ul>
								</div>
								<h5 class="publication-title">
									<a href="#">Leadership Excellence in African Management Development</a>
								</h5>
								<p class="publication-excerpt">
									An authoritative guide on developing transformational leadership capabilities within African contexts, 
									featuring culturally relevant frameworks and practical strategies for leadership development programs.
								</p>
								<div class="publication-actions">
									<a href="#" class="btn-read-more">
										<i class="fas fa-eye" style="margin-right: 8px;"></i>Access Guide
									</a>
									<div class="publication-stats">
										<span><i class="fas fa-file-pdf"></i>PDF Available</span>
										<span style="margin-left: 15px;"><i class="fas fa-star"></i>4.8/5 Rating</span>
									</div>
								</div>
							</div>

							<!-- Publication 5: Digital Transformation Report -->
							<div class="publication-card" data-aos="fade-up" data-aos-delay="400">
								<div class="publication-type type-report">Annual Report</div>
								<div class="publication-meta">
									<ul>
										<li><i class="fa fa-calendar"></i>Published: January 2024</li>
										<li><i class="fa fa-user"></i>WAMDEVIN Digital Committee</li>
										<li><i class="fa fa-eye"></i>1,920 views</li>
										<li><i class="fa fa-download"></i>780 downloads</li>
									</ul>
								</div>
								<h5 class="publication-title">
									<a href="#">Digital Transformation in West African MDIs: Progress Report 2023</a>
								</h5>
								<p class="publication-excerpt">
									Comprehensive analysis of digital adoption trends, technological infrastructure development, and innovation 
									initiatives across WAMDEVIN member institutions during 2023.
								</p>
								<div class="publication-actions">
									<a href="#" class="btn-read-more">
										<i class="fas fa-eye" style="margin-right: 8px;"></i>Read Report
									</a>
									<div class="publication-stats">
										<span><i class="fas fa-file-pdf"></i>PDF Available</span>
										<span style="margin-left: 15px;"><i class="fas fa-chart-line"></i>Trending</span>
									</div>
								</div>
							</div>

							<!-- Publication 6: Case Writing Manual -->
							<div class="publication-card" data-aos="fade-up" data-aos-delay="500">
								<div class="publication-type type-manual">Academic Manual</div>
								<div class="publication-meta">
									<ul>
										<li><i class="fa fa-calendar"></i>Published: September 2023</li>
										<li><i class="fa fa-user"></i>WAMDEVIN Academic Council</li>
										<li><i class="fa fa-eye"></i>3,560 views</li>
										<li><i class="fa fa-download"></i>1,890 downloads</li>
									</ul>
								</div>
								<h5 class="publication-title">
									<a href="#">Case Writing and Publication Guidelines for Management Faculty</a>
								</h5>
								<p class="publication-excerpt">
									Essential handbook for faculty members on developing high-quality case studies, research methodologies, 
									and publication standards for management education across West African contexts.
								</p>
								<div class="publication-actions">
									<a href="#" class="btn-read-more">
										<i class="fas fa-eye" style="margin-right: 8px;"></i>Download Manual
									</a>
									<div class="publication-stats">
										<span><i class="fas fa-file-pdf"></i>PDF Available</span>
										<span style="margin-left: 15px;"><i class="fas fa-users"></i>200+ Faculty Users</span>
									</div>
								</div>
							</div>

							<!-- Enhanced Pagination -->
							<div class="pagination-bx rounded-sm clearfix" data-aos="fade-up">
								<ul class="pagination">
									<li class="previous"><a href="#"><i class="ti-arrow-left"></i> Previous</a></li>
									<li class="active"><a href="#">1</a></li>
									<li><a href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li><a href="#">4</a></li>
									<li class="next"><a href="#">Next <i class="ti-arrow-right"></i></a></li>
								</ul>
							</div>
						</div>
						
						<!-- Enhanced Publications Sidebar -->
						<div class="col-lg-4 sticky-top">
							<aside class="side-bar sticky-top">
								<div class="sidebar-widget" data-aos="fade-left">
									<h6 class="widget-title">
										<i class="fas fa-search" style="color: #f39c12; margin-right: 8px;"></i>
										Publication Search
									</h6>
									<div class="search-bx style-1">
										<form role="search" method="post">
											<div class="input-group">
												<input name="text" class="form-control" placeholder="Search publications..." type="text" style="border-radius: 25px 0 0 25px;">
												<span class="input-group-btn">
													<button type="submit" class="fa fa-search" style="background: #1766a2; color: white; border: none; padding: 12px 15px; border-radius: 0 25px 25px 0;"></button>
												</span> 
											</div>
										</form>
									</div>
								</div>
								
								<div class="sidebar-widget" data-aos="fade-left" data-aos-delay="100">
									<h6 class="widget-title">
										<i class="fas fa-list" style="color: #f39c12; margin-right: 8px;"></i>
										Publication Categories
									</h6>
									<div class="category-item">
										<div style="display: flex; justify-content: space-between; align-items: center;">
											<span style="color: #1766a2; font-weight: 600;">Research Reports</span>
											<span class="category-count">12</span>
										</div>
									</div>
									<div class="category-item">
										<div style="display: flex; justify-content: space-between; align-items: center;">
											<span style="color: #1766a2; font-weight: 600;">Training Manuals</span>
											<span class="category-count">8</span>
										</div>
									</div>
									<div class="category-item">
										<div style="display: flex; justify-content: space-between; align-items: center;">
											<span style="color: #1766a2; font-weight: 600;">Academic Journals</span>
											<span class="category-count">15</span>
										</div>
									</div>
									<div class="category-item">
										<div style="display: flex; justify-content: space-between; align-items: center;">
											<span style="color: #1766a2; font-weight: 600;">Annual Reports</span>
											<span class="category-count">5</span>
										</div>
									</div>
									<div class="category-item">
										<div style="display: flex; justify-content: space-between; align-items: center;">
											<span style="color: #1766a2; font-weight: 600;">Case Studies</span>
											<span class="category-count">25</span>
										</div>
									</div>
								</div>
								
								<div class="sidebar-widget" data-aos="fade-left" data-aos-delay="200">
									<h6 class="widget-title">
										<i class="fas fa-fire" style="color: #f39c12; margin-right: 8px;"></i>
										Most Downloaded
									</h6>
									<div class="widget-post-bx">
										<div style="padding: 15px; background: rgba(243, 156, 18, 0.1); border-radius: 10px; margin-bottom: 15px; border-left: 4px solid #f39c12;">
											<h6 style="color: #1766a2; font-weight: 600; margin-bottom: 8px; font-size: 0.95rem;">Best Practices in Management Development</h6>
											<div style="color: #666; font-size: 0.85rem; margin-bottom: 10px;">
												<i class="fa fa-download" style="color: #f39c12; margin-right: 5px;"></i>2,100 downloads
											</div>
											<a href="#" style="background: #1766a2; color: white; padding: 6px 12px; border-radius: 12px; text-decoration: none; font-size: 0.8rem;">
												<i class="fas fa-eye" style="margin-right: 5px;"></i>View
											</a>
										</div>
										<div style="padding: 15px; background: rgba(23, 102, 162, 0.1); border-radius: 10px; margin-bottom: 15px; border-left: 4px solid #1766a2;">
											<h6 style="color: #1766a2; font-weight: 600; margin-bottom: 8px; font-size: 0.95rem;">Case Writing Guidelines</h6>
											<div style="color: #666; font-size: 0.85rem; margin-bottom: 10px;">
												<i class="fa fa-download" style="color: #f39c12; margin-right: 5px;"></i>1,890 downloads
											</div>
											<a href="#" style="background: #1766a2; color: white; padding: 6px 12px; border-radius: 12px; text-decoration: none; font-size: 0.8rem;">
												<i class="fas fa-eye" style="margin-right: 5px;"></i>View
											</a>
										</div>
										<div style="padding: 15px; background: rgba(39, 174, 96, 0.1); border-radius: 10px; margin-bottom: 15px; border-left: 4px solid #27ae60;">
											<h6 style="color: #1766a2; font-weight: 600; margin-bottom: 8px; font-size: 0.95rem;">Leadership Excellence Guide</h6>
											<div style="color: #666; font-size: 0.85rem; margin-bottom: 10px;">
												<i class="fa fa-download" style="color: #f39c12; margin-right: 5px;"></i>1,450 downloads
											</div>
											<a href="#" style="background: #1766a2; color: white; padding: 6px 12px; border-radius: 12px; text-decoration: none; font-size: 0.8rem;">
												<i class="fas fa-eye" style="margin-right: 5px;"></i>View
											</a>
										</div>
									</div>
								</div>
								
								<div class="sidebar-widget" data-aos="fade-left" data-aos-delay="300">
									<h6 class="widget-title">
										<i class="fas fa-envelope" style="color: #f39c12; margin-right: 8px;"></i>
										Publication Updates
									</h6>
									<div class="news-box">
										<p>Subscribe to receive notifications about new publications and research updates.</p>
										<form class="subscription-form" action="assets/script/mailchamp.php" method="post">
											<div class="ajax-message"></div>
											<div class="input-group">
												<input name="dzEmail" required="required" type="email" class="form-control" placeholder="Your Email Address" style="border-radius: 25px 0 0 25px;"/>
												<button name="submit" value="Submit" type="submit" class="btn" style="background: #1766a2; border: none; border-radius: 0 25px 25px 0; color: white;">
													<i class="fa fa-paper-plane-o"></i>
												</button>
											</div>
										</form>
									</div>
								</div>
								
								<div class="sidebar-widget" data-aos="fade-left" data-aos-delay="400">
									<h6 class="widget-title">
										<i class="fas fa-tags" style="color: #f39c12; margin-right: 8px;"></i>
										Popular Topics
									</h6>
									<div class="tagcloud"> 
										<a href="#" style="background: #1766a2; color: white; padding: 8px 15px; border-radius: 20px; margin: 5px; display: inline-block; text-decoration: none; font-size: 0.85rem;">Management Development</a> 
										<a href="#" style="background: #f39c12; color: white; padding: 8px 15px; border-radius: 20px; margin: 5px; display: inline-block; text-decoration: none; font-size: 0.85rem;">Leadership Training</a> 
										<a href="#" style="background: #27ae60; color: white; padding: 8px 15px; border-radius: 20px; margin: 5px; display: inline-block; text-decoration: none; font-size: 0.85rem;">Digital Skills</a> 
										<a href="#" style="background: #e74c3c; color: white; padding: 8px 15px; border-radius: 20px; margin: 5px; display: inline-block; text-decoration: none; font-size: 0.85rem;">Faculty Development</a> 
										<a href="#" style="background: #9b59b6; color: white; padding: 8px 15px; border-radius: 20px; margin: 5px; display: inline-block; text-decoration: none; font-size: 0.85rem;">Case Writing</a> 
										<a href="#" style="background: #34495e; color: white; padding: 8px 15px; border-radius: 20px; margin: 5px; display: inline-block; text-decoration: none; font-size: 0.85rem;">Research Methods</a> 
									</div>
								</div>
							</aside>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
    <!-- Content END-->
	
	<!-- Publication Methodology Section -->
	<div class="section-area section-sp1" style="background: linear-gradient(135deg, #1766a2 0%, #176599 100%); color: white; padding: 80px 0;">
		<div class="container">
			<div class="heading-bx text-center" data-aos="fade-up">
				<h2 style="color: white; font-weight: 800; margin-bottom: 30px;">
					Our <span style="color: #f39c12;">Publication</span> Methodology
				</h2>
				<p style="color: rgba(255,255,255,0.9); font-size: 1.2rem; max-width: 900px; margin: 0 auto 50px;">
					WAMDEVIN ensures publication excellence through rigorous academic standards, peer review processes, 
					and commitment to advancing management development knowledge across West Africa.
				</p>
			</div>
			
			<!-- Publication Excellence Pillars -->
			<div class="row" data-aos="fade-up" data-aos-delay="100">
				<div class="col-lg-3 col-md-6 m-b30">
					<div style="background: rgba(255,255,255,0.12); backdrop-filter: blur(10px); padding: 35px; border-radius: 20px; height: 100%; border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease;">
						<div style="font-size: 3rem; color: #f39c12; margin-bottom: 20px; text-align: center;">
							<i class="fas fa-check-circle"></i>
						</div>
						<h5 style="color: white; font-weight: 700; margin-bottom: 15px; text-align: center;">Rigorous Peer Review</h5>
						<p style="color: rgba(255,255,255,0.85); line-height: 1.7; text-align: center;">
							All publications undergo comprehensive peer review by regional and international experts
						</p>
					</div>
				</div>
				
				<div class="col-lg-3 col-md-6 m-b30">
					<div style="background: rgba(255,255,255,0.12); backdrop-filter: blur(10px); padding: 35px; border-radius: 20px; height: 100%; border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease;">
						<div style="font-size: 3rem; color: #f39c12; margin-bottom: 20px; text-align: center;">
							<i class="fas fa-check-circle"></i>
						</div>
						<h5 style="color: white; font-weight: 700; margin-bottom: 15px; text-align: center;">Quality Assurance</h5>
						<p style="color: rgba(255,255,255,0.85); line-height: 1.7; text-align: center;">
							Strict adherence to international publication standards and academic integrity guidelines
						</p>
					</div>
				</div>
				
				<div class="col-lg-3 col-md-6 m-b30">
					<div style="background: rgba(255,255,255,0.12); backdrop-filter: blur(10px); padding: 35px; border-radius: 20px; height: 100%; border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease;">
						<div style="font-size: 3rem; color: #f39c12; margin-bottom: 20px; text-align: center;">
							<i class="fas fa-check-circle"></i>
						</div>
						<h5 style="color: white; font-weight: 700; margin-bottom: 15px; text-align: center;">African Context Focus</h5>
						<p style="color: rgba(255,255,255,0.85); line-height: 1.7; text-align: center;">
							Emphasis on research relevant to West African management development challenges
						</p>
					</div>
				</div>
				
				<div class="col-lg-3 col-md-6 m-b30">
					<div style="background: rgba(255,255,255,0.12); backdrop-filter: blur(10px); padding: 35px; border-radius: 20px; height: 100%; border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease;">
						<div style="font-size: 3rem; color: #f39c12; margin-bottom: 20px; text-align: center;">
							<i class="fas fa-check-circle"></i>
						</div>
						<h5 style="color: white; font-weight: 700; margin-bottom: 15px; text-align: center;">Open Access Impact</h5>
						<p style="color: rgba(255,255,255,0.85); line-height: 1.7; text-align: center;">
							Making quality research accessible to MDIs, practitioners, and policymakers across the region
						</p>
					</div>
				</div>
			</div>
			
			<!-- Publication Excellence Framework -->
			<div class="row m-t50" data-aos="fade-up" data-aos-delay="200">
				<div class="col-lg-12">
					<div style="background: rgba(255,255,255,0.95); padding: 50px; border-radius: 25px; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
						<h3 style="color: #1766a2; font-weight: 700; margin-bottom: 35px; text-align: center;">
							Publication Excellence Framework
						</h3>
						<div class="row">
							<div class="col-lg-3 col-md-6 m-b30">
								<div style="text-align: center; padding: 25px; background: rgba(23, 102, 162, 0.05); border-radius: 15px; height: 100%; border: 2px solid rgba(243, 156, 18, 0.2);">
									<div style="font-size: 2.5rem; color: #f39c12; margin-bottom: 15px;">
										<i class="fas fa-book-open"></i>
									</div>
									<h5 style="color: #1766a2; font-weight: 700; margin-bottom: 12px;">Academic Journals</h5>
									<p style="color: #666; line-height: 1.6; font-size: 0.95rem;">
										Peer-reviewed journals featuring cutting-edge management research
									</p>
								</div>
							</div>
							
							<div class="col-lg-3 col-md-6 m-b30">
								<div style="text-align: center; padding: 25px; background: rgba(23, 102, 162, 0.05); border-radius: 15px; height: 100%; border: 2px solid rgba(243, 156, 18, 0.2);">
									<div style="font-size: 2.5rem; color: #f39c12; margin-bottom: 15px;">
										<i class="fas fa-file-alt"></i>
									</div>
									<h5 style="color: #1766a2; font-weight: 700; margin-bottom: 12px;">Research Reports</h5>
									<p style="color: #666; line-height: 1.6; font-size: 0.95rem;">
										Comprehensive studies on MDI capacity and development needs
									</p>
								</div>
							</div>
							
							<div class="col-lg-3 col-md-6 m-b30">
								<div style="text-align: center; padding: 25px; background: rgba(23, 102, 162, 0.05); border-radius: 15px; height: 100%; border: 2px solid rgba(243, 156, 18, 0.2);">
									<div style="font-size: 2.5rem; color: #f39c12; margin-bottom: 15px;">
										<i class="fas fa-graduation-cap"></i>
									</div>
									<h5 style="color: #1766a2; font-weight: 700; margin-bottom: 12px;">Training Materials</h5>
									<p style="color: #666; line-height: 1.6; font-size: 0.95rem;">
										Evidence-based resources for faculty development programs
									</p>
								</div>
							</div>
							
							<div class="col-lg-3 col-md-6 m-b30">
								<div style="text-align: center; padding: 25px; background: rgba(23, 102, 162, 0.05); border-radius: 15px; height: 100%; border: 2px solid rgba(243, 156, 18, 0.2);">
									<div style="font-size: 2.5rem; color: #f39c12; margin-bottom: 15px;">
										<i class="fas fa-lightbulb"></i>
									</div>
									<h5 style="color: #1766a2; font-weight: 700; margin-bottom: 12px;">Case Studies</h5>
									<p style="color: #666; line-height: 1.6; font-size: 0.95rem;">
										Real-world African management scenarios for teaching excellence
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Publication Methodology Section END -->
	
	<!-- Publication Opportunity Section -->
	<div class="section-area section-sp1" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); padding: 80px 0;">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-10">
					<div style="background: white; padding: 60px; border-radius: 30px; box-shadow: 0 25px 50px rgba(0,0,0,0.2);" data-aos="fade-up">
						<div class="heading-bx text-center" style="margin-bottom: 45px;">
							<h3 style="color: #1766a2; font-weight: 800; margin-bottom: 20px; font-size: 2.5rem;">
								Publish with <span style="color: #f39c12;">WAMDEVIN</span>
							</h3>
							<p style="color: #666; font-size: 1.2rem; line-height: 1.7; max-width: 800px; margin: 0 auto;">
								Join West Africa's premier management development research community. Share your expertise, 
								advance knowledge, and contribute to institutional excellence across the region.
							</p>
						</div>
						
						<div class="row m-b40">
							<div class="col-lg-6 m-b30">
								<div style="padding: 25px; background: rgba(243, 156, 18, 0.08); border-radius: 15px; height: 100%; border-left: 4px solid #f39c12;">
									<div style="display: flex; align-items: start; gap: 15px;">
										<div style="font-size: 2rem; color: #f39c12;">
											<i class="fas fa-star"></i>
										</div>
										<div>
											<h5 style="color: #1766a2; font-weight: 700; margin-bottom: 10px;">Publication Support</h5>
											<p style="color: #666; line-height: 1.7; margin: 0;">
												Editorial assistance, peer review coordination, and guidance through the publication process
											</p>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-lg-6 m-b30">
								<div style="padding: 25px; background: rgba(243, 156, 18, 0.08); border-radius: 15px; height: 100%; border-left: 4px solid #f39c12;">
									<div style="display: flex; align-items: start; gap: 15px;">
										<div style="font-size: 2rem; color: #f39c12;">
											<i class="fas fa-star"></i>
										</div>
										<div>
											<h5 style="color: #1766a2; font-weight: 700; margin-bottom: 10px;">Regional Reach</h5>
											<p style="color: #666; line-height: 1.7; margin: 0;">
												Access to 17 MDI institutions network and management development practitioners across West Africa
											</p>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-lg-6 m-b30">
								<div style="padding: 25px; background: rgba(243, 156, 18, 0.08); border-radius: 15px; height: 100%; border-left: 4px solid #f39c12;">
									<div style="display: flex; align-items: start; gap: 15px;">
										<div style="font-size: 2rem; color: #f39c12;">
											<i class="fas fa-star"></i>
										</div>
										<div>
											<h5 style="color: #1766a2; font-weight: 700; margin-bottom: 10px;">Author Recognition</h5>
											<p style="color: #666; line-height: 1.7; margin: 0;">
												Build your academic profile and contribute to management knowledge in African contexts
											</p>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-lg-6 m-b30">
								<div style="padding: 25px; background: rgba(243, 156, 18, 0.08); border-radius: 15px; height: 100%; border-left: 4px solid #f39c12;">
									<div style="display: flex; align-items: start; gap: 15px;">
										<div style="font-size: 2rem; color: #f39c12;">
											<i class="fas fa-star"></i>
										</div>
										<div>
											<h5 style="color: #1766a2; font-weight: 700; margin-bottom: 10px;">Open Access Options</h5>
											<p style="color: #666; line-height: 1.7; margin: 0;">
												Maximize impact through accessible, freely available research for practitioners and policymakers
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="text-center" style="margin-bottom: 40px;">
							<a href="contact.php" class="btn" style="background: linear-gradient(135deg, #1766a2, #2980b9); color: white; padding: 18px 45px; border-radius: 30px; font-weight: 700; font-size: 1.1rem; text-decoration: none; display: inline-block; box-shadow: 0 10px 25px rgba(23, 102, 162, 0.3); transition: all 0.3s ease;">
								<i class="fas fa-paper-plane" style="margin-right: 10px;"></i>Submit Your Publication
							</a>
						</div>
						
						<div class="row">
							<div class="col-lg-6">
								<div style="background: linear-gradient(135deg, rgba(23, 102, 162, 0.08), rgba(23, 102, 162, 0.12)); padding: 30px; border-radius: 20px; text-align: center; backdrop-filter: blur(10px); border: 1px solid rgba(23, 102, 162, 0.15);">
									<div style="font-size: 3rem; color: #1766a2; font-weight: 800; margin-bottom: 8px;">38+</div>
									<div style="color: #666; font-weight: 600; font-size: 1.1rem;">Years Publishing Excellence</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div style="background: linear-gradient(135deg, rgba(243, 156, 18, 0.08), rgba(243, 156, 18, 0.12)); padding: 30px; border-radius: 20px; text-align: center; backdrop-filter: blur(10px); border: 1px solid rgba(243, 156, 18, 0.15);">
									<div style="font-size: 3rem; color: #f39c12; font-weight: 800; margin-bottom: 8px;">65+</div>
									<div style="color: #666; font-weight: 600; font-size: 1.1rem;">Publications Network</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Publication Opportunity Section END -->
	
	<!-- Footer ==== -->
    <footer>
        <div class="footer-top">
			<div class="pt-exebar">
				<div class="container">
					<div class="d-flex align-items-stretch">
						<div class="pt-logo mr-auto">
							<a href="index.php"><img src="assets/images/logo-white.png" alt="WAMDEVIN logo"/></a>
						</div>
						<div class="pt-social-link">
							<ul class="list-inline m-a0">
								<li><a href="#" class="btn-link"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#" class="btn-link"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#" class="btn-link"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#" class="btn-link"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
						<div class="pt-btn-join">
							<a href="membership.php" class="btn ">Join Now</a>
						</div>
					</div>
				</div>
			</div>
            <div class="container">
                <div class="row">
					<div class="col-lg-4 col-md-12 col-sm-12 footer-col-4">
                        <div class="widget">
                            <h5 class="footer-title">Sign Up For A Newsletter</h5>
							<p class="text-capitalize m-b20">Subscribe to WAMDEVIN for insights on publication excellence, management development research, academic innovation, and scholarly leadership across West Africa.</p>
                            <div class="subscribe-form m-b20">
								<form class="subscription-form" action="assets/script/mailchamp.php" method="post">
									<div class="ajax-message"></div>
									<div class="input-group">
										<input name="email" required="required"  class="form-control" placeholder="Your Email Address" type="email">
										<span class="input-group-btn">
											<button name="submit" value="Submit" type="submit" class="btn"><i class="fa fa-arrow-right"></i></button>
										</span> 
									</div>
								</form>
							</div>
                        </div>
                    </div>
					<div class="col-12 col-lg-5 col-md-7 col-sm-12">
						<div class="row">
							<div class="col-4 col-lg-4 col-md-4 col-sm-4">
								<div class="widget footer_widget">
									<h5 class="footer-title">Company</h5>
									<ul>
										<li><a href="index.php">Home</a></li>
										<li><a href="about.php">About</a></li>
										<li><a href="membership.php#accordion1">FAQs</a></li>
										<li><a href="contact.php">Contact</a></li>
									</ul>
								</div>
							</div>
							<div class="col-4 col-lg-4 col-md-4 col-sm-4">
								<div class="widget footer_widget">
									<h5 class="footer-title">Get In Touch</h5>
									<ul>
										<li><a href="admin/index.php">Portal</a></li>
										<li><a href="blog.php">Blog</a></li>
										<li><a href="projects.php">Projects</a></li>
										<li><a href="index.php">Event</a></li>
									</ul>
								</div>
							</div>
							<div class="col-4 col-lg-4 col-md-4 col-sm-4">
								<div class="widget footer_widget">
									<h5 class="footer-title">Training</h5>
									<ul>
										<li><a href="trainners.php">Training</a></li>
										<li><a href="research.php">Research</a></li>
										<li><a href="publication.php">Publication</a></li>
										<li><a href="contact.php">Contact</a></li>
									</ul>
								</div>
							</div>
						</div>
                    </div>
					<div class="col-12 col-lg-3 col-md-5 col-sm-12 footer-col-4">
                        <div class="widget widget_gallery gallery-grid-4">
                            <h5 class="footer-title">Our Gallery</h5>
                            <ul class="magnific-image">
								<li><a href="assets/images/gallery/pic1.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic1.jpg" alt="Gallery image"></a></li>
								<li><a href="assets/images/gallery/pic2.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic2.jpg" alt="Gallery image"></a></li>
								<li><a href="assets/images/gallery/pic3.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic3.jpg" alt="Gallery image"></a></li>
								<li><a href="assets/images/gallery/pic4.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic4.jpg" alt="Gallery image"></a></li>
								<li><a href="assets/images/gallery/pic5.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic5.jpg" alt="Gallery image"></a></li>
								<li><a href="assets/images/gallery/pic6.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic6.jpg" alt="Gallery image"></a></li>
								<li><a href="assets/images/gallery/pic7.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic7.jpg" alt="Gallery image"></a></li>
								<li><a href="assets/images/gallery/pic8.jpg" class="magnific-anchor"><img src="assets/images/gallery/pic8.jpg" alt="Gallery image"></a></li>
							</ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                        <p style="color: rgba(255,255,255,0.8); margin: 0; font-size: 0.95rem;">
                            &copy; 2026 WAMDEVIN - West African Management Development Institutes Network | 
                            <a href="index.php" style="color: #f39c12; text-decoration: none;">www.wamdevin.com</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer END ==== -->
    <!-- scroll top button -->
    <button class="back-to-top fa fa-chevron-up" ></button>
</div>

<!-- Enhanced Professional Footer Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    // Enhanced AOS initialization with error handling
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS animations with enhanced settings
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 1000,
                easing: 'ease-in-out-sine',
                once: true,
                offset: 100,
                delay: 100
            });
            
            console.log('WAMDEVIN: AOS animations initialized successfully');
        } else {
            console.warn('WAMDEVIN: AOS library not loaded, falling back to standard animations');
        }
        
        // Enhanced interactive elements
        document.querySelectorAll('.publication-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-12px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
        
        // Category item interactions
        document.querySelectorAll('.category-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(10px)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
        
        // Sidebar widget interactions
        document.querySelectorAll('.sidebar-widget').forEach(widget => {
            widget.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 15px 35px rgba(0,0,0,0.15)';
            });
            
            widget.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.08)';
            });
        });
        
        // Publication search functionality
        const searchInput = document.querySelector('input[name="text"]');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                // Future implementation for real-time search
                console.log('Searching for:', this.value);
            });
        }
        
        // Professional console branding
        console.log(`
            ╔══════════════════════════════════════════════════════════════╗
            ║                    WAMDEVIN PUBLICATIONS HUB                  ║
            ║              Academic Research & Training Materials           ║
            ║                Professional Excellence Platform               ║
            ╚══════════════════════════════════════════════════════════════╝
        `);
        
        // Performance monitoring
        window.addEventListener('load', function() {
            const loadTime = performance.now();
            console.log(`WAMDEVIN: Publications page loaded in ${Math.round(loadTime)}ms`);
        });
    });
    
    // Professional error handling
    window.addEventListener('error', function(e) {
        console.error('WAMDEVIN Publications Hub - Error:', e.error);
    });
</script>

<?php include __DIR__ . '/includes/footer-scripts.php'; ?>
</body>

</html>

