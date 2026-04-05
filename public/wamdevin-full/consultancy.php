<!DOCTYPE html>
<html lang="en">

<head>

	<!-- META ============================================= -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="WAMDEVIN consultancy services, MDI strategic advisory, management development consulting, organizational transformation, leadership consulting, institutional development, West Africa management consulting, executive coaching, strategic planning, change management" />
	<meta name="author" content="West African Management Development Institutes Network (WAMDEVIN)" />
	<meta name="robots" content="index, follow" />
	
	<!-- DESCRIPTION -->
	<meta name="description" content="WAMDEVIN Consultancy Services - Professional strategic advisory, institutional development, and management consulting services from West African Management Development experts." />
	
	<!-- OG -->
	<meta property="og:title" content="WAMDEVIN Consultancy Services - Strategic Advisory & Management Consulting" />
	<meta property="og:description" content="Expert consultancy services in organizational transformation, leadership development, and strategic planning from West African Management Development specialists." />
	<meta property="og:image" content="assets/images/logo-white.png" />
	<meta property="og:url" content="https://www.wamdevin.com/consultancy.php" />
	<meta property="og:type" content="website" />
	<meta property="og:site_name" content="WAMDEVIN - West African Management Development Institutes Network" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- TWITTER CARD -->
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:title" content="WAMDEVIN Consultancy - Strategic Management Services" />
	<meta name="twitter:description" content="Professional consultancy services in organizational development, leadership training, and strategic transformation across West Africa." />
	<meta name="twitter:image" content="assets/images/logo-white.png" />
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="assets/images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>WAMDEVIN Consultancy Services - Strategic Advisory & Management Consulting</title>
	
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
	
	<!-- CONSULTANCY PAGE SPECIFIC STYLES -->
	<style>
		/* Professional Consultancy Page Styles */
		body { 
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
			line-height: 1.6; 
		}
		
		/* Enhanced Consultancy Hero Banner */
		.page-banner {
			background: linear-gradient(135deg, rgba(23, 102, 162, 0.95), rgba(243, 156, 18, 0.9)), url('assets/images/banner/banner1.jpg');
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
		
		/* Professional Consultancy Content Styling */
		.content-block {
			background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
		}
		
		/* Service Cards */
		.service-card {
			background: white;
			border-radius: 20px;
			box-shadow: 0 15px 35px rgba(0,0,0,0.12);
			padding: 35px;
			margin-bottom: 35px;
			border-left: 5px solid #1766a2;
			transition: all 0.3s ease;
			position: relative;
			overflow: hidden;
		}
		
		.service-card::before {
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
		
		.service-card:hover {
			transform: translateY(-8px);
			box-shadow: 0 25px 50px rgba(0,0,0,0.18);
			border-left-color: #f39c12;
		}
		
		.service-header {
			display: flex;
			align-items: center;
			margin-bottom: 25px;
		}
		
		.service-icon {
			background: linear-gradient(135deg, #1766a2, #2980b9);
			color: white;
			width: 70px;
			height: 70px;
			border-radius: 15px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 1.8rem;
			margin-right: 20px;
			box-shadow: 0 8px 20px rgba(23, 102, 162, 0.3);
		}
		
		.service-title {
			color: #1766a2;
			font-weight: 700;
			font-size: 1.5rem;
			margin: 0;
		}
		
		.service-description {
			color: #666;
			line-height: 1.8;
			margin-bottom: 25px;
			text-align: justify;
		}
		
		.service-features {
			list-style: none;
			padding: 0;
			margin-bottom: 25px;
		}
		
		.service-features li {
			padding: 8px 0;
			border-bottom: 1px solid rgba(243, 156, 18, 0.2);
			color: #555;
			display: flex;
			align-items: center;
		}
		
		.service-features li:last-child {
			border-bottom: none;
		}
		
		.service-features i {
			color: #f39c12;
			margin-right: 12px;
			width: 20px;
		}
		
		.service-cta {
			display: flex;
			gap: 15px;
			flex-wrap: wrap;
		}
		
		.btn-consult {
			background: linear-gradient(135deg, #1766a2, #2980b9);
			color: white;
			padding: 12px 25px;
			border-radius: 25px;
			text-decoration: none;
			font-weight: 600;
			transition: all 0.3s ease;
			border: none;
		}
		
		.btn-consult:hover {
			background: linear-gradient(135deg, #f39c12, #e67e22);
			color: white;
			transform: translateY(-2px);
			box-shadow: 0 8px 20px rgba(243, 156, 18, 0.3);
		}
		
		.btn-learn-more {
			background: transparent;
			color: #1766a2;
			padding: 12px 25px;
			border: 2px solid #1766a2;
			border-radius: 25px;
			text-decoration: none;
			font-weight: 600;
			transition: all 0.3s ease;
		}
		
		.btn-learn-more:hover {
			background: #1766a2;
			color: white;
		}
		
		/* Expertise Areas */
		.expertise-grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
			gap: 25px;
			margin: 30px 0;
		}
		
		.expertise-item {
			background: linear-gradient(135deg, rgba(23, 102, 162, 0.1), rgba(243, 156, 18, 0.1));
			padding: 25px;
			border-radius: 15px;
			text-align: center;
			border: 2px solid rgba(243, 156, 18, 0.2);
			transition: all 0.3s ease;
		}
		
		.expertise-item:hover {
			transform: translateY(-5px);
			border-color: #f39c12;
			box-shadow: 0 15px 30px rgba(243, 156, 18, 0.2);
		}
		
		.expertise-item i {
			font-size: 3rem;
			color: #f39c12;
			margin-bottom: 15px;
		}
		
		.expertise-item h4 {
			color: #1766a2;
			font-weight: 700;
			margin-bottom: 10px;
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
		
		/* Client Testimonial Cards */
		.testimonial-card {
			background: linear-gradient(135deg, rgba(243, 156, 18, 0.1), rgba(230, 126, 34, 0.1));
			border-left: 5px solid #f39c12;
			padding: 25px;
			border-radius: 15px;
			margin-bottom: 20px;
		}
		
		.testimonial-text {
			font-style: italic;
			color: #666;
			margin-bottom: 15px;
			line-height: 1.7;
		}
		
		.testimonial-author {
			color: #1766a2;
			font-weight: 600;
		}
		
		.testimonial-position {
			color: #999;
			font-size: 0.9rem;
		}
		
		/* Statistics Cards */
		.stat-card {
			background: linear-gradient(135deg, #1766a2, #2980b9);
			color: white;
			padding: 25px;
			border-radius: 15px;
			text-align: center;
			margin-bottom: 20px;
			box-shadow: 0 8px 25px rgba(23, 102, 162, 0.3);
		}
		
		.stat-number {
			font-size: 2.5rem;
			font-weight: 800;
			color: #f39c12;
		}
		
		/* Process Steps */
		.process-steps {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
			gap: 20px;
			margin: 30px 0;
		}
		
		.process-step {
			text-align: center;
			padding: 20px;
			position: relative;
		}
		
		.step-number {
			background: linear-gradient(135deg, #f39c12, #e67e22);
			color: white;
			width: 50px;
			height: 50px;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			font-weight: 700;
			font-size: 1.2rem;
			margin: 0 auto 15px;
			box-shadow: 0 5px 15px rgba(243, 156, 18, 0.3);
		}
		
		.step-title {
			color: #1766a2;
			font-weight: 600;
			margin-bottom: 10px;
		}
		
		/* Responsive Design */
		@media (max-width: 768px) {
			.page-banner h1 {
				font-size: 2.8rem;
			}
			
			.service-card {
				padding: 25px;
			}
			
			.service-header {
				flex-direction: column;
				text-align: center;
			}
			
			.service-icon {
				margin-right: 0;
				margin-bottom: 15px;
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
		
		.service-card {
			animation: fadeInUp 0.8s ease forwards;
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
							<li><a href="blog.php" data-translate="nav.blogs">Blogs</a></li>
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
        <!-- Enhanced Professional Consultancy Hero Banner -->
        <div class="page-banner ovbl-dark" style="background-image: linear-gradient(135deg, rgba(23, 102, 162, 0.95), rgba(243, 156, 18, 0.9)), url(assets/images/banner/banner1.jpg);">
            <div class="container">
                <div class="page-banner-entry" data-aos="fade-up">
                    <div style="background: rgba(255,255,255,0.12); backdrop-filter: blur(15px); padding: 45px; border-radius: 25px; border: 1px solid rgba(255,255,255,0.25); box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
                        <h1 class="text-white" style="font-size: 3.8rem; font-weight: 800; margin-bottom: 25px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                            <i class="fas fa-handshake" style="color: #f39c12; margin-right: 15px;"></i>
                            WAMDEVIN <span style="color: #f39c12;">CONSULTANCY</span>
                        </h1>
                        <h3 style="color: rgba(255,255,255,0.95); font-weight: 600; margin-bottom: 25px; font-size: 1.6rem;">
                            Strategic Advisory & Management Consulting Services
                        </h3>
                        <p style="color: rgba(255,255,255,0.9); font-size: 1.3rem; line-height: 1.7; margin-bottom: 35px;">
                            Professional consultancy services in organizational transformation, leadership development, 
                            strategic planning, and institutional excellence across West African Management Development Institutes
                        </p>
                        <div style="display: flex; gap: 25px; justify-content: center; flex-wrap: wrap; margin-bottom: 20px;">
                            <div style="background: rgba(243, 156, 18, 0.25); padding: 18px 28px; border-radius: 12px; text-align: center; border: 1px solid rgba(243, 156, 18, 0.3);">
                                <i class="fas fa-chart-line" style="color: #f39c12; font-size: 1.8rem; margin-bottom: 12px; display: block;"></i>
                                <span style="color: white; font-weight: 600; font-size: 1.1rem;">Strategic Planning</span>
                            </div>
                            <div style="background: rgba(243, 156, 18, 0.25); padding: 18px 28px; border-radius: 12px; text-align: center; border: 1px solid rgba(243, 156, 18, 0.3);">
                                <i class="fas fa-users-cog" style="color: #f39c12; font-size: 1.8rem; margin-bottom: 12px; display: block;"></i>
                                <span style="color: white; font-weight: 600; font-size: 1.1rem;">Organizational Development</span>
                            </div>
                            <div style="background: rgba(243, 156, 18, 0.25); padding: 18px 28px; border-radius: 12px; text-align: center; border: 1px solid rgba(243, 156, 18, 0.3);">
                                <i class="fas fa-trophy" style="color: #f39c12; font-size: 1.8rem; margin-bottom: 12px; display: block;"></i>
                                <span style="color: white; font-weight: 600; font-size: 1.1rem;">Leadership Coaching</span>
                            </div>
                            <div style="background: rgba(243, 156, 18, 0.25); padding: 18px 28px; border-radius: 12px; text-align: center; border: 1px solid rgba(243, 156, 18, 0.3);">
                                <i class="fas fa-cogs" style="color: #f39c12; font-size: 1.8rem; margin-bottom: 12px; display: block;"></i>
                                <span style="color: white; font-weight: 600; font-size: 1.1rem;">Process Optimization</span>
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
						<i class="fas fa-handshake" style="margin-right: 8px; color: #f39c12;"></i>
						Consultancy Services
					</li>
				</ul>
			</div>
		</div>
		<!-- Breadcrumb row END -->
        <!-- Enhanced Consultancy Content Area -->
        <div class="content-block" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); padding: 60px 0;">
			<div class="section-area section-sp1">
				<div class="container">
					<div class="row">
						<!-- Consultancy Services Content -->
						<div class="col-md-7 col-lg-8 col-xl-8">
							<!-- Strategic Planning & Advisory -->
							<div class="service-card" data-aos="fade-up">
								<div class="service-header">
									<div class="service-icon">
										<i class="fas fa-chess-king"></i>
									</div>
									<h3 class="service-title">Strategic Planning & Advisory</h3>
								</div>
								<p class="service-description">
									Comprehensive strategic planning services to help Management Development Institutes develop clear vision, 
									mission, and strategic roadmaps for sustainable growth and organizational excellence. Our expert consultants 
									work closely with leadership teams to create actionable strategic plans aligned with institutional goals.
								</p>
								<ul class="service-features">
									<li><i class="fas fa-check-circle"></i>Institutional Strategic Planning</li>
									<li><i class="fas fa-check-circle"></i>Vision & Mission Development</li>
									<li><i class="fas fa-check-circle"></i>SWOT Analysis & Environmental Scanning</li>
									<li><i class="fas fa-check-circle"></i>Strategic Implementation Roadmaps</li>
									<li><i class="fas fa-check-circle"></i>Performance Measurement Systems</li>
								</ul>
								<div class="service-cta">
									<a href="#" class="btn-consult">
										<i class="fas fa-phone" style="margin-right: 8px;"></i>Request Consultation
									</a>
									<a href="#" class="btn-learn-more">Learn More</a>
								</div>
							</div>

							<!-- Organizational Development & Transformation -->
							<div class="service-card" data-aos="fade-up" data-aos-delay="100">
								<div class="service-header">
									<div class="service-icon" style="background: linear-gradient(135deg, #f39c12, #e67e22);">
										<i class="fas fa-sitemap"></i>
									</div>
									<h3 class="service-title">Organizational Development & Transformation</h3>
								</div>
								<p class="service-description">
									Expert guidance in organizational restructuring, change management, and cultural transformation initiatives. 
									We help MDIs adapt to evolving educational landscapes while maintaining their core mission and values 
									through structured transformation processes.
								</p>
								<ul class="service-features">
									<li><i class="fas fa-check-circle"></i>Organizational Structure Design</li>
									<li><i class="fas fa-check-circle"></i>Change Management Strategies</li>
									<li><i class="fas fa-check-circle"></i>Cultural Transformation Programs</li>
									<li><i class="fas fa-check-circle"></i>Process Reengineering</li>
									<li><i class="fas fa-check-circle"></i>Digital Transformation Support</li>
								</ul>
								<div class="service-cta">
									<a href="#" class="btn-consult">
										<i class="fas fa-phone" style="margin-right: 8px;"></i>Request Consultation
									</a>
									<a href="#" class="btn-learn-more">Learn More</a>
								</div>
							</div>

							<!-- Leadership Development & Executive Coaching -->
							<div class="service-card" data-aos="fade-up" data-aos-delay="200">
								<div class="service-header">
									<div class="service-icon" style="background: linear-gradient(135deg, #27ae60, #2ecc71);">
										<i class="fas fa-crown"></i>
									</div>
									<h3 class="service-title">Leadership Development & Executive Coaching</h3>
								</div>
								<p class="service-description">
									Personalized leadership development programs and executive coaching services designed to enhance 
									leadership capabilities of MDI directors, senior faculty, and management teams. Our approach combines 
									international best practices with African leadership philosophies.
								</p>
								<ul class="service-features">
									<li><i class="fas fa-check-circle"></i>Executive Leadership Coaching</li>
									<li><i class="fas fa-check-circle"></i>Leadership Assessment & 360° Feedback</li>
									<li><i class="fas fa-check-circle"></i>Succession Planning Programs</li>
									<li><i class="fas fa-check-circle"></i>Team Building & Collaboration</li>
									<li><i class="fas fa-check-circle"></i>Emotional Intelligence Development</li>
								</ul>
								<div class="service-cta">
									<a href="#" class="btn-consult">
										<i class="fas fa-phone" style="margin-right: 8px;"></i>Request Consultation
									</a>
									<a href="#" class="btn-learn-more">Learn More</a>
								</div>
							</div>

							<!-- Quality Assurance & Accreditation Support -->
							<div class="service-card" data-aos="fade-up" data-aos-delay="300">
								<div class="service-header">
									<div class="service-icon" style="background: linear-gradient(135deg, #9b59b6, #8e44ad);">
										<i class="fas fa-award"></i>
									</div>
									<h3 class="service-title">Quality Assurance & Accreditation Support</h3>
								</div>
								<p class="service-description">
									Comprehensive quality assurance frameworks and accreditation support services to help MDIs achieve 
									international standards and recognition. We provide guidance on quality management systems, 
									continuous improvement processes, and accreditation preparation.
								</p>
								<ul class="service-features">
									<li><i class="fas fa-check-circle"></i>Quality Management System Design</li>
									<li><i class="fas fa-check-circle"></i>Accreditation Preparation & Support</li>
									<li><i class="fas fa-check-circle"></i>Academic Program Evaluation</li>
									<li><i class="fas fa-check-circle"></i>Faculty Development Standards</li>
									<li><i class="fas fa-check-circle"></i>Continuous Improvement Frameworks</li>
								</ul>
								<div class="service-cta">
									<a href="#" class="btn-consult">
										<i class="fas fa-phone" style="margin-right: 8px;"></i>Request Consultation
									</a>
									<a href="#" class="btn-learn-more">Learn More</a>
								</div>
							</div>

							<!-- Our Consulting Process -->
							<div style="background: white; border-radius: 20px; padding: 40px; margin-top: 40px; box-shadow: 0 15px 35px rgba(0,0,0,0.12);" data-aos="fade-up" data-aos-delay="400">
								<h3 style="color: #1766a2; font-weight: 700; text-align: center; margin-bottom: 30px;">
									<i class="fas fa-cogs" style="color: #f39c12; margin-right: 10px;"></i>
									Our Consulting Process
								</h3>
								<div class="process-steps">
									<div class="process-step">
										<div class="step-number">1</div>
										<h5 class="step-title">Initial Assessment</h5>
										<p style="color: #666; font-size: 0.9rem;">Comprehensive evaluation of current state and challenges</p>
									</div>
									<div class="process-step">
										<div class="step-number">2</div>
										<h5 class="step-title">Strategic Design</h5>
										<p style="color: #666; font-size: 0.9rem;">Customized solutions and strategic recommendations</p>
									</div>
									<div class="process-step">
										<div class="step-number">3</div>
										<h5 class="step-title">Implementation</h5>
										<p style="color: #666; font-size: 0.9rem;">Guided execution with continuous support</p>
									</div>
									<div class="process-step">
										<div class="step-number">4</div>
										<h5 class="step-title">Monitoring</h5>
										<p style="color: #666; font-size: 0.9rem;">Progress tracking and performance optimization</p>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Enhanced Consultancy Sidebar -->
						<div class="col-md-5 col-lg-4 col-xl-4 sticky-top">
							<aside class="side-bar sticky-top">
								<div class="sidebar-widget" data-aos="fade-left">
									<h6 class="widget-title">
										<i class="fas fa-phone" style="color: #f39c12; margin-right: 8px;"></i>
										Request Consultation
									</h6>
									<div style="background: linear-gradient(135deg, rgba(23, 102, 162, 0.1), rgba(243, 156, 18, 0.1)); padding: 25px; border-radius: 15px; text-align: center;">
										<i class="fas fa-headset" style="font-size: 3rem; color: #f39c12; margin-bottom: 20px;"></i>
										<h5 style="color: #1766a2; margin-bottom: 15px;">Get Expert Advice</h5>
										<p style="color: #666; margin-bottom: 20px;">Schedule a free consultation with our experienced consultants</p>
										<a href="contact.php" class="btn-consult" style="display: inline-block;">
											<i class="fas fa-calendar" style="margin-right: 8px;"></i>Book Consultation
										</a>
									</div>
								</div>
								
								<div class="sidebar-widget" data-aos="fade-left" data-aos-delay="100">
									<h6 class="widget-title">
										<i class="fas fa-chart-bar" style="color: #f39c12; margin-right: 8px;"></i>
										Consultancy Statistics
									</h6>
									<div class="stat-card">
										<div class="stat-number">150+</div>
										<p style="margin: 0; font-size: 1rem;">Successful Projects</p>
									</div>
									<div class="stat-card" style="background: linear-gradient(135deg, #f39c12, #e67e22);">
										<div class="stat-number" style="color: white;">25+</div>
										<p style="margin: 0; font-size: 1rem; color: white;">Partner Institutions</p>
									</div>
									<div class="stat-card" style="background: linear-gradient(135deg, #27ae60, #2ecc71);">
										<div class="stat-number" style="color: white;">95%</div>
										<p style="margin: 0; font-size: 1rem; color: white;">Client Satisfaction</p>
									</div>
								</div>
								
								<div class="sidebar-widget" data-aos="fade-left" data-aos-delay="200">
									<h6 class="widget-title">
										<i class="fas fa-star" style="color: #f39c12; margin-right: 8px;"></i>
										Client Testimonials
									</h6>
									<div class="testimonial-card">
										<p class="testimonial-text">
											"WAMDEVIN's strategic planning consultation transformed our institution. 
											Their expertise and guidance were invaluable in our organizational development."
										</p>
										<div class="testimonial-author">Dr. Amina Hassan</div>
										<div class="testimonial-position">Director, Ghana Institute of Management</div>
									</div>
									<div class="testimonial-card">
										<p class="testimonial-text">
											"The leadership coaching program exceeded our expectations. 
											Our management team is now more effective and cohesive."
										</p>
										<div class="testimonial-author">Prof. Kwame Osei</div>
										<div class="testimonial-position">CEO, Nigeria Management Institute</div>
									</div>
								</div>
								
								<div class="sidebar-widget" data-aos="fade-left" data-aos-delay="300">
									<h6 class="widget-title">
										<i class="fas fa-cogs" style="color: #f39c12; margin-right: 8px;"></i>
										Service Areas
									</h6>
									<div class="expertise-grid">
										<div class="expertise-item">
											<i class="fas fa-chess-king"></i>
											<h4>Strategic Planning</h4>
											<p style="font-size: 0.9rem; color: #666;">Vision & Mission Development</p>
										</div>
										<div class="expertise-item">
											<i class="fas fa-users-cog"></i>
											<h4>Change Management</h4>
											<p style="font-size: 0.9rem; color: #666;">Organizational Transformation</p>
										</div>
										<div class="expertise-item">
											<i class="fas fa-crown"></i>
											<h4>Leadership Coaching</h4>
											<p style="font-size: 0.9rem; color: #666;">Executive Development</p>
										</div>
										<div class="expertise-item">
											<i class="fas fa-award"></i>
											<h4>Quality Assurance</h4>
											<p style="font-size: 0.9rem; color: #666;">Accreditation Support</p>
										</div>
									</div>
								</div>
								
								<div class="sidebar-widget" data-aos="fade-left" data-aos-delay="400">
									<h6 class="widget-title">
										<i class="fas fa-download" style="color: #f39c12; margin-right: 8px;"></i>
										Resources & Downloads
									</h6>
									<div style="padding: 15px; background: rgba(23, 102, 162, 0.1); border-radius: 10px; margin-bottom: 15px; border-left: 4px solid #1766a2;">
										<h6 style="color: #1766a2; font-weight: 600; margin-bottom: 8px;">Strategic Planning Guide</h6>
										<p style="margin-bottom: 10px; font-size: 0.9rem; color: #666;">Comprehensive institutional planning framework</p>
										<a href="#" style="background: #1766a2; color: white; padding: 8px 15px; border-radius: 15px; text-decoration: none; font-size: 0.85rem;">
											<i class="fas fa-file-pdf" style="margin-right: 5px;"></i>Download PDF
										</a>
									</div>
									<div style="padding: 15px; background: rgba(243, 156, 18, 0.1); border-radius: 10px; margin-bottom: 15px; border-left: 4px solid #f39c12;">
										<h6 style="color: #f39c12; font-weight: 600; margin-bottom: 8px;">Leadership Assessment Tool</h6>
										<p style="margin-bottom: 10px; font-size: 0.9rem; color: #666;">Professional leadership evaluation framework</p>
										<a href="#" style="background: #f39c12; color: white; padding: 8px 15px; border-radius: 15px; text-decoration: none; font-size: 0.85rem;">
											<i class="fas fa-file-pdf" style="margin-right: 5px;"></i>Download PDF
										</a>
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
	
	<!-- Consultancy Methodology Section -->
	<div class="section-area section-sp1" style="background: linear-gradient(135deg, #1766a2 0%, #176599 100%); color: white; padding: 80px 0;">
		<div class="container">
			<div class="heading-bx text-center" data-aos="fade-up">
				<h2 style="color: white; font-weight: 800; margin-bottom: 30px;">
					Our <span style="color: #f39c12;">Consultancy</span> Methodology
				</h2>
				<p style="color: rgba(255,255,255,0.9); font-size: 1.2rem; max-width: 900px; margin: 0 auto 50px;">
					WAMDEVIN consultancy services deliver transformation through proven methodologies, expert collaboration, 
					and commitment to sustainable institutional excellence and strategic impact.
				</p>
			</div>
			
			<!-- Consultancy Excellence Pillars -->
			<div class="row" data-aos="fade-up" data-aos-delay="100">
				<div class="col-lg-3 col-md-6 m-b30">
					<div style="background: rgba(255,255,255,0.12); backdrop-filter: blur(10px); padding: 35px; border-radius: 20px; height: 100%; border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease;">
						<div style="font-size: 3rem; color: #f39c12; margin-bottom: 20px; text-align: center;">
							<i class="fas fa-check-circle"></i>
						</div>
						<h5 style="color: white; font-weight: 700; margin-bottom: 15px; text-align: center;">Strategic Expertise</h5>
						<p style="color: rgba(255,255,255,0.85); line-height: 1.7; text-align: center;">
							Deep understanding of management development challenges in African contexts
						</p>
					</div>
				</div>
				
				<div class="col-lg-3 col-md-6 m-b30">
					<div style="background: rgba(255,255,255,0.12); backdrop-filter: blur(10px); padding: 35px; border-radius: 20px; height: 100%; border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease;">
						<div style="font-size: 3rem; color: #f39c12; margin-bottom: 20px; text-align: center;">
							<i class="fas fa-check-circle"></i>
						</div>
						<h5 style="color: white; font-weight: 700; margin-bottom: 15px; text-align: center;">Collaborative Approach</h5>
						<p style="color: rgba(255,255,255,0.85); line-height: 1.7; text-align: center;">
							Partnership-based engagement ensuring institutional buy-in and sustainability
						</p>
					</div>
				</div>
				
				<div class="col-lg-3 col-md-6 m-b30">
					<div style="background: rgba(255,255,255,0.12); backdrop-filter: blur(10px); padding: 35px; border-radius: 20px; height: 100%; border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease;">
						<div style="font-size: 3rem; color: #f39c12; margin-bottom: 20px; text-align: center;">
							<i class="fas fa-check-circle"></i>
						</div>
						<h5 style="color: white; font-weight: 700; margin-bottom: 15px; text-align: center;">Evidence-Based Solutions</h5>
						<p style="color: rgba(255,255,255,0.85); line-height: 1.7; text-align: center;">
							Recommendations grounded in research, data analysis, and best practice benchmarking
						</p>
					</div>
				</div>
				
				<div class="col-lg-3 col-md-6 m-b30">
					<div style="background: rgba(255,255,255,0.12); backdrop-filter: blur(10px); padding: 35px; border-radius: 20px; height: 100%; border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease;">
						<div style="font-size: 3rem; color: #f39c12; margin-bottom: 20px; text-align: center;">
							<i class="fas fa-check-circle"></i>
						</div>
						<h5 style="color: white; font-weight: 700; margin-bottom: 15px; text-align: center;">Measurable Impact</h5>
						<p style="color: rgba(255,255,255,0.85); line-height: 1.7; text-align: center;">
							Clear metrics and monitoring mechanisms ensuring accountability and continuous improvement
						</p>
					</div>
				</div>
			</div>
			
			<!-- Consultancy Excellence Framework -->
			<div class="row m-t50" data-aos="fade-up" data-aos-delay="200">
				<div class="col-lg-12">
					<div style="background: rgba(255,255,255,0.95); padding: 50px; border-radius: 25px; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
						<h3 style="color: #1766a2; font-weight: 700; margin-bottom: 35px; text-align: center;">
							Consultancy Excellence Framework
						</h3>
						<div class="row">
							<div class="col-lg-3 col-md-6 m-b30">
								<div style="text-align: center; padding: 25px; background: rgba(23, 102, 162, 0.05); border-radius: 15px; height: 100%; border: 2px solid rgba(243, 156, 18, 0.2);">
									<div style="font-size: 2.5rem; color: #f39c12; margin-bottom: 15px;">
										<i class="fas fa-chart-line"></i>
									</div>
									<h5 style="color: #1766a2; font-weight: 700; margin-bottom: 12px;">Strategic Planning</h5>
									<p style="color: #666; line-height: 1.6; font-size: 0.95rem;">
										Institutional vision, mission, and strategic roadmap development
									</p>
								</div>
							</div>
							
							<div class="col-lg-3 col-md-6 m-b30">
								<div style="text-align: center; padding: 25px; background: rgba(23, 102, 162, 0.05); border-radius: 15px; height: 100%; border: 2px solid rgba(243, 156, 18, 0.2);">
									<div style="font-size: 2.5rem; color: #f39c12; margin-bottom: 15px;">
										<i class="fas fa-sitemap"></i>
									</div>
									<h5 style="color: #1766a2; font-weight: 700; margin-bottom: 12px;">Organizational Design</h5>
									<p style="color: #666; line-height: 1.6; font-size: 0.95rem;">
										Structure optimization and transformation implementation
									</p>
								</div>
							</div>
							
							<div class="col-lg-3 col-md-6 m-b30">
								<div style="text-align: center; padding: 25px; background: rgba(23, 102, 162, 0.05); border-radius: 15px; height: 100%; border: 2px solid rgba(243, 156, 18, 0.2);">
									<div style="font-size: 2.5rem; color: #f39c12; margin-bottom: 15px;">
										<i class="fas fa-crown"></i>
									</div>
									<h5 style="color: #1766a2; font-weight: 700; margin-bottom: 12px;">Leadership Coaching</h5>
									<p style="color: #666; line-height: 1.6; font-size: 0.95rem;">
										Executive development and succession planning guidance
									</p>
								</div>
							</div>
							
							<div class="col-lg-3 col-md-6 m-b30">
								<div style="text-align: center; padding: 25px; background: rgba(23, 102, 162, 0.05); border-radius: 15px; height: 100%; border: 2px solid rgba(243, 156, 18, 0.2);">
									<div style="font-size: 2.5rem; color: #f39c12; margin-bottom: 15px;">
										<i class="fas fa-award"></i>
									</div>
									<h5 style="color: #1766a2; font-weight: 700; margin-bottom: 12px;">Quality Assurance</h5>
									<p style="color: #666; line-height: 1.6; font-size: 0.95rem;">
										Accreditation support and continuous improvement systems
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Consultancy Methodology Section END -->
	
	<!-- Consultancy Opportunity Section -->
	<div class="section-area section-sp1" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); padding: 80px 0;">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-10">
					<div style="background: white; padding: 60px; border-radius: 30px; box-shadow: 0 25px 50px rgba(0,0,0,0.2);" data-aos="fade-up">
						<div class="heading-bx text-center" style="margin-bottom: 45px;">
							<h3 style="color: #1766a2; font-weight: 800; margin-bottom: 20px; font-size: 2.5rem;">
								Partner with <span style="color: #f39c12;">WAMDEVIN</span> Consultancy
							</h3>
							<p style="color: #666; font-size: 1.2rem; line-height: 1.7; max-width: 800px; margin: 0 auto;">
								Transform your institution through strategic advisory and expert consultancy services. 
								Join our network of satisfied clients achieving institutional excellence and sustainable growth.
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
											<h5 style="color: #1766a2; font-weight: 700; margin-bottom: 10px;">Expert Consultants</h5>
											<p style="color: #666; line-height: 1.7; margin: 0;">
												Access to experienced management development specialists with proven track records
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
											<h5 style="color: #1766a2; font-weight: 700; margin-bottom: 10px;">Customized Solutions</h5>
											<p style="color: #666; line-height: 1.7; margin: 0;">
												Tailored strategic approaches addressing your institution's unique challenges and opportunities
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
											<h5 style="color: #1766a2; font-weight: 700; margin-bottom: 10px;">Ongoing Support</h5>
											<p style="color: #666; line-height: 1.7; margin: 0;">
												Implementation guidance and monitoring throughout your transformation journey
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
											<h5 style="color: #1766a2; font-weight: 700; margin-bottom: 10px;">Proven Results</h5>
											<p style="color: #666; line-height: 1.7; margin: 0;">
												Track record of successful projects delivering measurable organizational impact
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="text-center" style="margin-bottom: 40px;">
							<a href="contact.php" class="btn" style="background: linear-gradient(135deg, #1766a2, #2980b9); color: white; padding: 18px 45px; border-radius: 30px; font-weight: 700; font-size: 1.1rem; text-decoration: none; display: inline-block; box-shadow: 0 10px 25px rgba(23, 102, 162, 0.3); transition: all 0.3s ease;">
								<i class="fas fa-handshake" style="margin-right: 10px;"></i>Start Your Transformation
							</a>
						</div>
						
						<div class="row">
							<div class="col-lg-6">
								<div style="background: linear-gradient(135deg, rgba(23, 102, 162, 0.08), rgba(23, 102, 162, 0.12)); padding: 30px; border-radius: 20px; text-align: center; backdrop-filter: blur(10px); border: 1px solid rgba(23, 102, 162, 0.15);">
									<div style="font-size: 3rem; color: #1766a2; font-weight: 800; margin-bottom: 8px;">150+</div>
									<div style="color: #666; font-weight: 600; font-size: 1.1rem;">Successful Projects</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div style="background: linear-gradient(135deg, rgba(243, 156, 18, 0.08), rgba(243, 156, 18, 0.12)); padding: 30px; border-radius: 20px; text-align: center; backdrop-filter: blur(10px); border: 1px solid rgba(243, 156, 18, 0.15);">
									<div style="font-size: 3rem; color: #f39c12; font-weight: 800; margin-bottom: 8px;">95%</div>
									<div style="color: #666; font-weight: 600; font-size: 1.1rem;">Client Satisfaction</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Consultancy Opportunity Section END -->
	
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
							<p class="text-capitalize m-b20">Subscribe to WAMDEVIN for insights on consultancy excellence, management development innovation, strategic solutions, and institutional transformation across West Africa.</p>
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
										<li><a href="publication.php">Blog</a></li>
										<li><a href="projects.php">Projects</a></li>
										<li><a href="index.php">Event</a></li>
									</ul>
								</div>
							</div>
							<div class="col-4 col-lg-4 col-md-4 col-sm-4">
								<div class="widget footer_widget">
									<h5 class="footer-title">Services</h5>
									<ul>
										<li><a href="trainners.php">Training</a></li>
										<li><a href="research.php">Research</a></li>
										<li><a href="publication.php">Publication</a></li>
										<li><a href="consultancy.php">Consultancy</a></li>
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
        document.querySelectorAll('.service-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-12px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
        
        // Expertise item interactions
        document.querySelectorAll('.expertise-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.05)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
        
        // Process step interactions
        document.querySelectorAll('.process-step').forEach(step => {
            step.addEventListener('mouseenter', function() {
                const stepNumber = this.querySelector('.step-number');
                if (stepNumber) {
                    stepNumber.style.transform = 'scale(1.2)';
                    stepNumber.style.boxShadow = '0 8px 25px rgba(243, 156, 18, 0.5)';
                }
            });
            
            step.addEventListener('mouseleave', function() {
                const stepNumber = this.querySelector('.step-number');
                if (stepNumber) {
                    stepNumber.style.transform = 'scale(1)';
                    stepNumber.style.boxShadow = '0 5px 15px rgba(243, 156, 18, 0.3)';
                }
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
        
        // Service CTA button interactions
        document.querySelectorAll('.btn-consult, .btn-learn-more').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px) scale(1.05)';
            });
            
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
        
        // Professional console branding
        console.log(`
            ╔══════════════════════════════════════════════════════════════╗
            ║                    WAMDEVIN CONSULTANCY SERVICES              ║
            ║              Strategic Advisory & Management Consulting       ║
            ║                Professional Excellence Platform               ║
            ╚══════════════════════════════════════════════════════════════╝
        `);
        
        // Performance monitoring
        window.addEventListener('load', function() {
            const loadTime = performance.now();
            console.log(`WAMDEVIN: Consultancy page loaded in ${Math.round(loadTime)}ms`);
        });
    });
    
    // Professional error handling
    window.addEventListener('error', function(e) {
        console.error('WAMDEVIN Consultancy Services - Error:', e.error);
    });
</script>

<?php include __DIR__ . '/includes/footer-scripts.php'; ?>
</body>

</html>

