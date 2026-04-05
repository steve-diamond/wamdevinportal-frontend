<?php
$pageTitle = 'Compose Message - WAMDEVIN Admin';
$pageDescription = 'Prepare stakeholder updates and official correspondence.';
$currentPage = 'mailbox';
$useCalendar = false;
$useCharts = false;
$useCounter = false;
$includeLegacyCSS = true;
$includeLegacyJS = true;
$pageCSS = [
    'assets/vendors/summernote/summernote.css',
    'assets/vendors/file-upload/imageuploadify.min.css'
];
$pageJS = [
    'assets/vendors/summernote/summernote.js',
    'assets/vendors/file-upload/imageuploadify.min.js'
];
$inlineScript = <<<JAVASCRIPT
(function() {
    'use strict';
    if (typeof jQuery !== 'undefined') {
        jQuery(function($) {
            if ($.fn.summernote) {
                $('.summernote').summernote({
                    height: 300,
                    tabsize: 2
                });
            }

            if ($.fn.imageuploadify) {
                $('input[type="file"]').imageuploadify();
            }
        });
    }
})();
JAVASCRIPT;

include('includes/admin-header.php');
include('includes/admin-sidebar.php');
?>

	<main class="ttr-wrapper" id="main-content" role="main">
					<li>
						<a href="add-listing.html" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-layout-accordion-list"></i></span>
		                	<span class="ttr-label">Add listing</span>
		                </a>
		            </li>
					<li>
						<a href="#" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-user"></i></span>
		                	<span class="ttr-label">My Profile</span>
		                	<span class="ttr-arrow-icon"><i class="fa fa-angle-down"></i></span>
		                </a>
		                <ul>
		                	<li>
		                		<a href="user-profile.html" class="ttr-material-button"><span class="ttr-label">User Profile</span></a>
		                	</li>
		                	<li>
		                		<a href="teacher-profile.html" class="ttr-material-button"><span class="ttr-label">Teacher Profile</span></a>
		                	</li>
		                </ul>
		            </li>
		            <li class="ttr-seperate"></li>
				</ul>
				<!-- sidebar menu end -->
			</nav>
			<!-- sidebar menu end -->
		</div>
	</div>
	<!-- Left sidebar menu end -->

	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container-fluid">
			<div class="db-breadcrumb">
				<h4 class="breadcrumb-title">Compose</h4>
				<ul class="db-breadcrumb-list">
					<li><a href="#"><i class="fa fa-home"></i>Home</a></li>
					<li>Compose</li>
				</ul>
			</div>	
			<?php include('includes/admin-page-intro.php'); ?>
			<div class="row">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="email-wrapper">
							<div class="email-menu-bar">
								<div class="compose-mail">
									<a href="mailbox-compose.html" class="btn btn-block">Compose</a>
								</div>
								<div class="email-menu-bar-inner">
									<ul>
										<li class="active"><a href="mailbox.html"><i class="fa fa-envelope-o"></i>Inbox <span class="badge badge-success">8</span></a></li>
										<li><a href="mailbox.html"><i class="fa fa-send-o"></i>Sent</a></li>
										<li><a href="mailbox.html"><i class="fa fa-file-text-o"></i>Drafts <span class="badge badge-warning">8</span></a></li>
										<li><a href="mailbox.html"><i class="fa fa-cloud-upload"></i>Outbox <span class="badge badge-danger">8</span></a></li>
										<li><a href="mailbox.html"><i class="fa fa-trash-o"></i>Trash</a></li>
									</ul>
								</div>
							</div>
							<div class="mail-list-container">
								<form class="mail-compose">
									<div class="form-group col-12">
										<input class="form-control" type="email" placeholder="To">
									</div>
									<div class="form-group col-12">
										<input class="form-control" type="email" placeholder="CC">
									</div>
									<div class="form-group col-12">
										<input class="form-control" type="text" placeholder="Subject">
									</div>
									<div class="form-group col-12">
										<div class="summernote"><p>Hello World</p></div>
									</div>
									<div class="form-group col-12">
										<input type="file" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf" multiple>
									</div>
									<div class="form-group col-12">
										<button type="submit" class="btn btn-lg">Send</button>
									</div>
								</form>
							</div>
						</div>
					</div> 
				</div>
				<!-- Your Profile Views Chart END-->
			</div>
		</div>
	</main>

<?php include('includes/admin-footer.php'); ?>
