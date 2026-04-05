<?php
$pageTitle = 'Bookmarks - WAMDEVIN Admin';
$pageDescription = 'Manage bookmarked courses and resources.';
$currentPage = 'bookmark';
$useCalendar = false;
$useCharts = false;
$useCounter = false;
$includeLegacyCSS = true;
$includeLegacyJS = true;

include('includes/admin-header.php');
include('includes/admin-sidebar.php');
?>

<main class="ttr-wrapper" id="main-content" role="main">
	<div class="container-fluid">
		<div class="db-breadcrumb">
			<h4 class="breadcrumb-title">Bookmarks</h4>
			<ul class="db-breadcrumb-list">
				<li><a href="index.php"><i class="fa fa-home"></i>Home</a></li>
				<li>Bookmarks</li>
			</ul>
		</div>	
		<?php include('includes/admin-page-intro.php'); ?>
		<div class="row">
			<!-- Bookmarks List -->
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
					<div class="wc-title">
						<h4>Courses Bookmarks</h4>
					</div>
					<div class="widget-inner">
						<div class="card-courses-list bookmarks-bx">
							<div class="card-courses-media">
								<img src="assets/images/courses/pic6.jpg" alt=""/>
							</div>
							<div class="card-courses-full-dec">
								<div class="card-courses-title">
									<h4 class="m-b5">Become a PHP Master and Make Money</h4>
								</div>
								<div class="card-courses-list-bx">
									<ul class="card-courses-view">
										<li class="card-courses-categories">
											<h5>Categories</h5>
											<h4>Science - Biology</h4>
										</li>
										<li class="card-courses-review">
											<h5>3 Review</h5>
											<ul class="cours-star">
												<li class="active"><i class="fa fa-star"></i></li>
												<li class="active"><i class="fa fa-star"></i></li>
												<li class="active"><i class="fa fa-star"></i></li>
												<li><i class="fa fa-star"></i></li>
												<li><i class="fa fa-star"></i></li>
											</ul>
										</li>
										<li class="card-courses-price">
											<del>$190</del>
											<h5 class="text-primary m-b0">$120</h5>
										</li>
									</ul>
								</div>
								<div class="row card-courses-dec">
									<div class="col-md-12">
										<p>Lorem ipsum dolor sit amet, est ei idque voluptua copiosae, pro detracto disputando reformidans at, ex vel suas eripuit. Vel alii zril maiorum ex, mea id sale eirmod epicurei. Sit te possit senserit, eam alia veritus maluisset ei, id cibo vocent ocurreret per. Te qui doming doctus referrentur, usu debet tamquam et. Sea ut nullam aperiam, mei cu tollit salutatus delicatissimi. </p>	
									</div>
									<div class="col-md-12">
										<a href="#" class="btn radius-xl">View Courses</a>
										<a href="#" class="btn red outline radius-xl ">Cancel</a>
									</div>
								</div>
								
							</div>
						</div>
						<div class="card-courses-list bookmarks-bx">
							<div class="card-courses-media">
								<img src="assets/images/courses/pic7.jpg" alt=""/>
							</div>
							<div class="card-courses-full-dec">
								<div class="card-courses-title">
									<h4 class="m-b5">Become a PHP Master and Make Money</h4>
								</div>
								<div class="card-courses-list-bx">
									<ul class="card-courses-view">
										<li class="card-courses-categories">
											<h5>Categories</h5>
											<h4>Science - Biology</h4>
										</li>
										<li class="card-courses-review">
											<h5>3 Review</h5>
											<ul class="cours-star">
												<li class="active"><i class="fa fa-star"></i></li>
												<li class="active"><i class="fa fa-star"></i></li>
												<li class="active"><i class="fa fa-star"></i></li>
												<li><i class="fa fa-star"></i></li>
												<li><i class="fa fa-star"></i></li>
											</ul>
										</li>
										<li class="card-courses-price">
											<del>$190</del>
											<h5 class="text-primary m-b0">$120</h5>
										</li>
									</ul>
								</div>
								<div class="row card-courses-dec">
									<div class="col-md-12">
										<p>Lorem ipsum dolor sit amet, est ei idque voluptua copiosae, pro detracto disputando reformidans at, ex vel suas eripuit. Vel alii zril maiorum ex, mea id sale eirmod epicurei. Sit te possit senserit, eam alia veritus maluisset ei, id cibo vocent ocurreret per. Te qui doming doctus referrentur, usu debet tamquam et. Sea ut nullam aperiam, mei cu tollit salutatus delicatissimi. </p>	
									</div>
									<div class="col-md-12">
										<a href="#" class="btn radius-xl">View Courses</a>
										<a href="#" class="btn red outline radius-xl ">Cancel</a>
									</div>
								</div>
								
							</div>
						</div>
						<div class="card-courses-list bookmarks-bx">
							<div class="card-courses-media">
								<img src="assets/images/courses/pic8.jpg" alt=""/>
							</div>
							<div class="card-courses-full-dec">
								<div class="card-courses-title">
									<h4 class="m-b5">Become a PHP Master and Make Money</h4>
								</div>
								<div class="card-courses-list-bx">
									<ul class="card-courses-view">
										<li class="card-courses-categories">
											<h5>Categories</h5>
											<h4>Science - Biology</h4>
										</li>
										<li class="card-courses-review">
											<h5>3 Review</h5>
											<ul class="cours-star">
												<li class="active"><i class="fa fa-star"></i></li>
												<li class="active"><i class="fa fa-star"></i></li>
												<li class="active"><i class="fa fa-star"></i></li>
												<li><i class="fa fa-star"></i></li>
												<li><i class="fa fa-star"></i></li>
											</ul>
										</li>
										<li class="card-courses-price">
											<del>$190</del>
											<h5 class="text-primary m-b0">$120</h5>
										</li>
									</ul>
								</div>
								<div class="row card-courses-dec">
									<div class="col-md-12">
										<p>Lorem ipsum dolor sit amet, est ei idque voluptua copiosae, pro detracto disputando reformidans at, ex vel suas eripuit. Vel alii zril maiorum ex, mea id sale eirmod epicurei. Sit te possit senserit, eam alia veritus maluisset ei, id cibo vocent ocurreret per. Te qui doming doctus referrentur, usu debet tamquam et. Sea ut nullam aperiam, mei cu tollit salutatus delicatissimi. </p>	
									</div>
									<div class="col-md-12">
										<a href="#" class="btn radius-xl">View Courses</a>
										<a href="#" class="btn red outline radius-xl ">Cancel</a>
									</div>
								</div>
								
							</div>
						</div>
						<div class="card-courses-list bookmarks-bx">
							<div class="card-courses-media">
								<img src="assets/images/courses/pic9.jpg" alt=""/>
							</div>
							<div class="card-courses-full-dec">
								<div class="card-courses-title">
									<h4 class="m-b5">Become a PHP Master and Make Money</h4>
								</div>
								<div class="card-courses-list-bx">
									<ul class="card-courses-view">
										<li class="card-courses-categories">
											<h5>Categories</h5>
											<h4>Science - Biology</h4>
										</li>
										<li class="card-courses-review">
											<h5>3 Review</h5>
											<ul class="cours-star">
												<li class="active"><i class="fa fa-star"></i></li>
												<li class="active"><i class="fa fa-star"></i></li>
												<li class="active"><i class="fa fa-star"></i></li>
												<li><i class="fa fa-star"></i></li>
												<li><i class="fa fa-star"></i></li>
											</ul>
										</li>
										<li class="card-courses-price">
											<del>$190</del>
											<h5 class="text-primary m-b0">$120</h5>
										</li>
									</ul>
								</div>
								<div class="row card-courses-dec">
									<div class="col-md-12">
										<p>Lorem ipsum dolor sit amet, est ei idque voluptua copiosae, pro detracto disputando reformidans at, ex vel suas eripuit. Vel alii zril maiorum ex, mea id sale eirmod epicurei. Sit te possit senserit, eam alia veritus maluisset ei, id cibo vocent ocurreret per. Te qui doming doctus referrentur, usu debet tamquam et. Sea ut nullam aperiam, mei cu tollit salutatus delicatissimi. </p>	
									</div>
									<div class="col-md-12">
										<a href="#" class="btn radius-xl">View Courses</a>
										<a href="#" class="btn red outline radius-xl ">Cancel</a>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Bookmarks List END-->
		</div>
	</div>
</main>

<?php include('includes/admin-footer.php'); ?>
