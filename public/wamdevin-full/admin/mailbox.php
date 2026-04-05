<?php
$pageTitle = 'Mailbox - WAMDEVIN Admin';
$pageDescription = 'Manage stakeholder correspondence and internal updates.';
$currentPage = 'mailbox';
$useCalendar = false;
$useCharts = false;
$useCounter = false;
$includeLegacyCSS = true;
$includeLegacyJS = true;
$inlineScript = <<<JAVASCRIPT
(function() {
    'use strict';
    if (typeof jQuery !== 'undefined') {
        jQuery(function($) {
            $('[data-toggle="tooltip"]').tooltip();
        });
    }
})();
JAVASCRIPT;

include('includes/admin-header.php');
include('includes/admin-sidebar.php');
?>

							<main class="ttr-wrapper" id="main-content" role="main">
											<li><a href="#"><i class="fa fa-clock-o"></i> Snooze</a></li>
											<li><a href="#"><i class="fa fa-envelope-open"></i> Mark as unread</a></li>
										</ul>
									</div> 
									<div class="next-prev-btn">
										<a href="#"><i class="fa fa-angle-left"></i></a>
										<a href="#"><i class="fa fa-angle-right"></i></a>
									</div>
								</div>
								<div class="mail-box-list">
									<div class="mail-list-info">
										<div class="checkbox-list">
											<div class="custom-control custom-checkbox checkbox-st1">
												<input type="checkbox" class="custom-control-input" id="check2">
												<label class="custom-control-label" for="check2"></label>
											</div>
										</div>
										<div class="mail-rateing">
											<span><i class="fa fa-star-o"></i></span>
										</div>
										<div class="mail-list-title">
											<h6>David Moore</h6>
										</div>
										<div class="mail-list-title-info">
											<p>Change the password for your Micr</p>
										</div>
										<div class="mail-list-time">
											<span>10:59 AM</span>
										</div>
										<ul class="mailbox-toolbar">
											<li data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></li>
											<li data-toggle="tooltip" title="Archive"><i class="fa fa-arrow-down"></i></li>
											<li data-toggle="tooltip" title="Snooze"><i class="fa fa-clock-o"></i></li>
											<li data-toggle="tooltip" title="Mark as unread"><i class="fa fa-envelope-open"></i></li>
										</ul>
									</div>
									<div class="mail-list-info">
										<div class="checkbox-list">
											<div class="custom-control custom-checkbox checkbox-st1">
												<input type="checkbox" class="custom-control-input" id="check3">
												<label class="custom-control-label" for="check3"></label>
											</div>
										</div>
										<div class="mail-rateing">
											<span><i class="fa fa-star-o"></i></span>
										</div>
										<div class="mail-list-title">
											<h6>David Moore</h6>
										</div>
										<div class="mail-list-title-info">
											<p>Change the password for your Micr</p>
										</div>
										<div class="mail-list-time">
											<span>10:59 AM</span>
										</div>
										<ul class="mailbox-toolbar">
											<li data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></li>
											<li data-toggle="tooltip" title="Archive"><i class="fa fa-arrow-down"></i></li>
											<li data-toggle="tooltip" title="Snooze"><i class="fa fa-clock-o"></i></li>
											<li data-toggle="tooltip" title="Mark as unread"><i class="fa fa-envelope-open"></i></li>
										</ul>
									</div>
									<div class="mail-list-info">
										<div class="checkbox-list">
											<div class="custom-control custom-checkbox checkbox-st1">
												<input type="checkbox" class="custom-control-input" id="check4">
												<label class="custom-control-label" for="check4"></label>
											</div>
										</div>
										<div class="mail-rateing">
											<span><i class="fa fa-star-o"></i></span>
										</div>
										<div class="mail-list-title">
											<h6>David Moore</h6>
										</div>
										<div class="mail-list-title-info">
											<p>Change the password for your Micr</p>
										</div>
										<div class="mail-list-time">
											<span>10:59 AM</span>
										</div>
										<ul class="mailbox-toolbar">
											<li data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></li>
											<li data-toggle="tooltip" title="Archive"><i class="fa fa-arrow-down"></i></li>
											<li data-toggle="tooltip" title="Snooze"><i class="fa fa-clock-o"></i></li>
											<li data-toggle="tooltip" title="Mark as unread"><i class="fa fa-envelope-open"></i></li>
										</ul>
									</div>
									<div class="mail-list-info">
										<div class="checkbox-list">
											<div class="custom-control custom-checkbox checkbox-st1">
												<input type="checkbox" class="custom-control-input" id="check5">
												<label class="custom-control-label" for="check5"></label>
											</div>
										</div>
										<div class="mail-rateing">
											<span><i class="fa fa-star-o"></i></span>
										</div>
										<div class="mail-list-title">
											<h6>David Moore</h6>
										</div>
										<div class="mail-list-title-info">
											<p>Change the password for your Micr</p>
										</div>
										<div class="mail-list-time">
											<span>10:59 AM</span>
										</div>
										<ul class="mailbox-toolbar">
											<li data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></li>
											<li data-toggle="tooltip" title="Archive"><i class="fa fa-arrow-down"></i></li>
											<li data-toggle="tooltip" title="Snooze"><i class="fa fa-clock-o"></i></li>
											<li data-toggle="tooltip" title="Mark as unread"><i class="fa fa-envelope-open"></i></li>
										</ul>
									</div>
									<div class="mail-list-info">
										<div class="checkbox-list">
											<div class="custom-control custom-checkbox checkbox-st1">
												<input type="checkbox" class="custom-control-input" id="check6">
												<label class="custom-control-label" for="check6"></label>
											</div>
										</div>
										<div class="mail-rateing">
											<span><i class="fa fa-star-o"></i></span>
										</div>
										<div class="mail-list-title">
											<h6>David Moore</h6>
										</div>
										<div class="mail-list-title-info">
											<p>Change the password for your Micr</p>
										</div>
										<div class="mail-list-time">
											<span>10:59 AM</span>
										</div>
										<ul class="mailbox-toolbar">
											<li data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></li>
											<li data-toggle="tooltip" title="Archive"><i class="fa fa-arrow-down"></i></li>
											<li data-toggle="tooltip" title="Snooze"><i class="fa fa-clock-o"></i></li>
											<li data-toggle="tooltip" title="Mark as unread"><i class="fa fa-envelope-open"></i></li>
										</ul>
									</div>
									<div class="mail-list-info">
										<div class="checkbox-list">
											<div class="custom-control custom-checkbox checkbox-st1">
												<input type="checkbox" class="custom-control-input" id="check7">
												<label class="custom-control-label" for="check7"></label>
											</div>
										</div>
										<div class="mail-rateing">
											<span><i class="fa fa-star-o"></i></span>
										</div>
										<div class="mail-list-title">
											<h6>David Moore</h6>
										</div>
										<div class="mail-list-title-info">
											<p>Change the password for your Micr</p>
										</div>
										<div class="mail-list-time">
											<span>10:59 AM</span>
										</div>
										<ul class="mailbox-toolbar">
											<li data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></li>
											<li data-toggle="tooltip" title="Archive"><i class="fa fa-arrow-down"></i></li>
											<li data-toggle="tooltip" title="Snooze"><i class="fa fa-clock-o"></i></li>
											<li data-toggle="tooltip" title="Mark as unread"><i class="fa fa-envelope-open"></i></li>
										</ul>
									</div>
									<div class="mail-list-info">
										<div class="checkbox-list">
											<div class="custom-control custom-checkbox checkbox-st1">
												<input type="checkbox" class="custom-control-input" id="check8">
												<label class="custom-control-label" for="check8"></label>
											</div>
										</div>
										<div class="mail-rateing">
											<span><i class="fa fa-star-o"></i></span>
										</div>
										<div class="mail-list-title">
											<h6>David Moore</h6>
										</div>
										<div class="mail-list-title-info">
											<p>Change the password for your Micr</p>
										</div>
										<div class="mail-list-time">
											<span>10:59 AM</span>
										</div>
										<ul class="mailbox-toolbar">
											<li data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></li>
											<li data-toggle="tooltip" title="Archive"><i class="fa fa-arrow-down"></i></li>
											<li data-toggle="tooltip" title="Snooze"><i class="fa fa-clock-o"></i></li>
											<li data-toggle="tooltip" title="Mark as unread"><i class="fa fa-envelope-open"></i></li>
										</ul>
									</div>
									<div class="mail-list-info">
										<div class="checkbox-list">
											<div class="custom-control custom-checkbox checkbox-st1">
												<input type="checkbox" class="custom-control-input" id="check9">
												<label class="custom-control-label" for="check9"></label>
											</div>
										</div>
										<div class="mail-rateing">
											<span><i class="fa fa-star-o"></i></span>
										</div>
										<div class="mail-list-title">
											<h6>David Moore</h6>
										</div>
										<div class="mail-list-title-info">
											<p>Change the password for your Micr</p>
										</div>
										<div class="mail-list-time">
											<span>10:59 AM</span>
										</div>
										<ul class="mailbox-toolbar">
											<li data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></li>
											<li data-toggle="tooltip" title="Archive"><i class="fa fa-arrow-down"></i></li>
											<li data-toggle="tooltip" title="Snooze"><i class="fa fa-clock-o"></i></li>
											<li data-toggle="tooltip" title="Mark as unread"><i class="fa fa-envelope-open"></i></li>
										</ul>
									</div>
									<div class="mail-list-info">
										<div class="checkbox-list">
											<div class="custom-control custom-checkbox checkbox-st1">
												<input type="checkbox" class="custom-control-input" id="check10">
												<label class="custom-control-label" for="check10"></label>
											</div>
										</div>
										<div class="mail-rateing">
											<span><i class="fa fa-star-o"></i></span>
										</div>
										<div class="mail-list-title">
											<h6>David Moore</h6>
										</div>
										<div class="mail-list-title-info">
											<p>Change the password for your Micr</p>
										</div>
										<div class="mail-list-time">
											<span>10:59 AM</span>
										</div>
										<ul class="mailbox-toolbar">
											<li data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></li>
											<li data-toggle="tooltip" title="Archive"><i class="fa fa-arrow-down"></i></li>
											<li data-toggle="tooltip" title="Snooze"><i class="fa fa-clock-o"></i></li>
											<li data-toggle="tooltip" title="Mark as unread"><i class="fa fa-envelope-open"></i></li>
										</ul>
									</div>
									<div class="mail-list-info">
										<div class="checkbox-list">
											<div class="custom-control custom-checkbox checkbox-st1">
												<input type="checkbox" class="custom-control-input" id="check11">
												<label class="custom-control-label" for="check11"></label>
											</div>
										</div>
										<div class="mail-rateing">
											<span><i class="fa fa-star-o"></i></span>
										</div>
										<div class="mail-list-title">
											<h6>David Moore</h6>
										</div>
										<div class="mail-list-title-info">
											<p>Change the password for your Micr</p>
										</div>
										<div class="mail-list-time">
											<span>10:59 AM</span>
										</div>
										<ul class="mailbox-toolbar">
											<li data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></li>
											<li data-toggle="tooltip" title="Archive"><i class="fa fa-arrow-down"></i></li>
											<li data-toggle="tooltip" title="Snooze"><i class="fa fa-clock-o"></i></li>
											<li data-toggle="tooltip" title="Mark as unread"><i class="fa fa-envelope-open"></i></li>
										</ul>
									</div>
									<div class="mail-list-info">
										<div class="checkbox-list">
											<div class="custom-control custom-checkbox checkbox-st1">
												<input type="checkbox" class="custom-control-input" id="check12">
												<label class="custom-control-label" for="check12"></label>
											</div>
										</div>
										<div class="mail-rateing">
											<span><i class="fa fa-star-o"></i></span>
										</div>
										<div class="mail-list-title">
											<h6>David Moore</h6>
										</div>
										<div class="mail-list-title-info">
											<p>Change the password for your Micr</p>
										</div>
										<div class="mail-list-time">
											<span>10:59 AM</span>
										</div>
										<ul class="mailbox-toolbar">
											<li data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></li>
											<li data-toggle="tooltip" title="Archive"><i class="fa fa-arrow-down"></i></li>
											<li data-toggle="tooltip" title="Snooze"><i class="fa fa-clock-o"></i></li>
											<li data-toggle="tooltip" title="Mark as unread"><i class="fa fa-envelope-open"></i></li>
										</ul>
									</div>
									<div class="mail-list-info">
										<div class="checkbox-list">
											<div class="custom-control custom-checkbox checkbox-st1">
												<input type="checkbox" class="custom-control-input" id="check13">
												<label class="custom-control-label" for="check13"></label>
											</div>
										</div>
										<div class="mail-rateing">
											<span><i class="fa fa-star-o"></i></span>
										</div>
										<div class="mail-list-title">
											<h6>David Moore</h6>
										</div>
										<div class="mail-list-title-info">
											<p>Change the password for your Micr</p>
										</div>
										<div class="mail-list-time">
											<span>10:59 AM</span>
										</div>
										<ul class="mailbox-toolbar">
											<li data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></li>
											<li data-toggle="tooltip" title="Archive"><i class="fa fa-arrow-down"></i></li>
											<li data-toggle="tooltip" title="Snooze"><i class="fa fa-clock-o"></i></li>
											<li data-toggle="tooltip" title="Mark as unread"><i class="fa fa-envelope-open"></i></li>
										</ul>
									</div>
									<div class="mail-list-info">
										<div class="checkbox-list">
											<div class="custom-control custom-checkbox checkbox-st1">
												<input type="checkbox" class="custom-control-input" id="check14">
												<label class="custom-control-label" for="check14"></label>
											</div>
										</div>
										<div class="mail-rateing">
											<span><i class="fa fa-star-o"></i></span>
										</div>
										<div class="mail-list-title">
											<h6>David Moore</h6>
										</div>
										<div class="mail-list-title-info">
											<p>Change the password for your Micr</p>
										</div>
										<div class="mail-list-time">
											<span>10:59 AM</span>
										</div>
										<ul class="mailbox-toolbar">
											<li data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></li>
											<li data-toggle="tooltip" title="Archive"><i class="fa fa-arrow-down"></i></li>
											<li data-toggle="tooltip" title="Snooze"><i class="fa fa-clock-o"></i></li>
											<li data-toggle="tooltip" title="Mark as unread"><i class="fa fa-envelope-open"></i></li>
										</ul>
									</div>
									<div class="mail-list-info">
										<div class="checkbox-list">
											<div class="custom-control custom-checkbox checkbox-st1">
												<input type="checkbox" class="custom-control-input" id="check15">
												<label class="custom-control-label" for="check15"></label>
											</div>
										</div>
										<div class="mail-rateing">
											<span><i class="fa fa-star-o"></i></span>
										</div>
										<div class="mail-list-title">
											<h6>David Moore</h6>
										</div>
										<div class="mail-list-title-info">
											<p>Change the password for your Micr</p>
										</div>
										<div class="mail-list-time">
											<span>10:59 AM</span>
										</div>
										<ul class="mailbox-toolbar">
											<li data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></li>
											<li data-toggle="tooltip" title="Archive"><i class="fa fa-arrow-down"></i></li>
											<li data-toggle="tooltip" title="Snooze"><i class="fa fa-clock-o"></i></li>
											<li data-toggle="tooltip" title="Mark as unread"><i class="fa fa-envelope-open"></i></li>
										</ul>
									</div>
									<div class="mail-list-info">
										<div class="checkbox-list">
											<div class="custom-control custom-checkbox checkbox-st1">
												<input type="checkbox" class="custom-control-input" id="check16">
												<label class="custom-control-label" for="check16"></label>
											</div>
										</div>
										<div class="mail-rateing">
											<span><i class="fa fa-star-o"></i></span>
										</div>
										<div class="mail-list-title">
											<h6>David Moore</h6>
										</div>
										<div class="mail-list-title-info">
											<p>Change the password for your Micr</p>
										</div>
										<div class="mail-list-time">
											<span>10:59 AM</span>
										</div>
										<ul class="mailbox-toolbar">
											<li data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></li>
											<li data-toggle="tooltip" title="Archive"><i class="fa fa-arrow-down"></i></li>
											<li data-toggle="tooltip" title="Snooze"><i class="fa fa-clock-o"></i></li>
											<li data-toggle="tooltip" title="Mark as unread"><i class="fa fa-envelope-open"></i></li>
										</ul>
									</div>
									<div class="mail-list-info">
										<div class="checkbox-list">
											<div class="custom-control custom-checkbox checkbox-st1">
												<input type="checkbox" class="custom-control-input" id="check17">
												<label class="custom-control-label" for="check17"></label>
											</div>
										</div>
										<div class="mail-rateing">
											<span><i class="fa fa-star-o"></i></span>
										</div>
										<div class="mail-list-title">
											<h6>David Moore</h6>
										</div>
										<div class="mail-list-title-info">
											<p>Change the password for your Micr</p>
										</div>
										<div class="mail-list-time">
											<span>10:59 AM</span>
										</div>
										<ul class="mailbox-toolbar">
											<li data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></li>
											<li data-toggle="tooltip" title="Archive"><i class="fa fa-arrow-down"></i></li>
											<li data-toggle="tooltip" title="Snooze"><i class="fa fa-clock-o"></i></li>
											<li data-toggle="tooltip" title="Mark as unread"><i class="fa fa-envelope-open"></i></li>
										</ul>
									</div>
									<div class="mail-list-info">
										<div class="checkbox-list">
											<div class="custom-control custom-checkbox checkbox-st1">
												<input type="checkbox" class="custom-control-input" id="check18">
												<label class="custom-control-label" for="check18"></label>
											</div>
										</div>
										<div class="mail-rateing">
											<span><i class="fa fa-star-o"></i></span>
										</div>
										<div class="mail-list-title">
											<h6>David Moore</h6>
										</div>
										<div class="mail-list-title-info">
											<p>Change the password for your Micr</p>
										</div>
										<div class="mail-list-time">
											<span>10:59 AM</span>
										</div>
										<ul class="mailbox-toolbar">
											<li data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></li>
											<li data-toggle="tooltip" title="Archive"><i class="fa fa-arrow-down"></i></li>
											<li data-toggle="tooltip" title="Snooze"><i class="fa fa-clock-o"></i></li>
											<li data-toggle="tooltip" title="Mark as unread"><i class="fa fa-envelope-open"></i></li>
										</ul>
									</div>
									<div class="mail-list-info">
										<div class="checkbox-list">
											<div class="custom-control custom-checkbox checkbox-st1">
												<input type="checkbox" class="custom-control-input" id="check19">
												<label class="custom-control-label" for="check19"></label>
											</div>
										</div>
										<div class="mail-rateing">
											<span><i class="fa fa-star-o"></i></span>
										</div>
										<div class="mail-list-title">
											<h6>David Moore</h6>
										</div>
										<div class="mail-list-title-info">
											<p>Change the password for your Micr</p>
										</div>
										<div class="mail-list-time">
											<span>10:59 AM</span>
										</div>
										<ul class="mailbox-toolbar">
											<li data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></li>
											<li data-toggle="tooltip" title="Archive"><i class="fa fa-arrow-down"></i></li>
											<li data-toggle="tooltip" title="Snooze"><i class="fa fa-clock-o"></i></li>
											<li data-toggle="tooltip" title="Mark as unread"><i class="fa fa-envelope-open"></i></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div> 
				</div>
				<!-- Your Profile Views Chart END-->
			</div>
		</div>
	</main>

<?php include('includes/admin-footer.php'); ?>
