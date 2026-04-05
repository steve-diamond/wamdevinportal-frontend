<?php
$pageTitle = 'Teacher Profile - WAMDEVIN Admin';
$pageDescription = 'Maintain facilitator profiles and delivery readiness.';
$currentPage = 'teacher-profile';
$useCalendar = false;
$useCharts = false;
$useCounter = false;
$includeLegacyCSS = true;
$includeLegacyJS = true;
$inlineScript = <<<JAVASCRIPT
(function() {
    'use strict';
    function newMenuItem() {
        var newElem = jQuery('tr.list-item').first().clone();
        newElem.find('input').val('');
        newElem.appendTo('table#item-add');
    }

    if (typeof jQuery !== 'undefined') {
        jQuery(function($) {
            if ($('table#item-add').length) {
                $('.add-item').on('click', function(e) {
                    e.preventDefault();
                    newMenuItem();
                });
                $(document).on('click', '#item-add .delete', function(e) {
                    e.preventDefault();
                    $(this).closest('tr').remove();
                });
            }
        });
    }
})();
JAVASCRIPT;

include('includes/admin-header.php');
include('includes/admin-sidebar.php');
?>

							<main class="ttr-wrapper" id="main-content" role="main">
										<label class="col-form-label">Phone No.</label>
										<div>
											<input class="form-control" type="text" value="+120 012345 6789">
										</div>
									</div>
									
									<div class="seperator"></div>
									
									<div class="col-12 m-t20">
										<div class="ml-auto m-b5">
											<h3>2. Address</h3>
										</div>
									</div>
									<div class="form-group col-6">
										<label class="col-form-label">Address</label>
										<div>
											<input class="form-control" type="text" value="5-S2-20 Dummy City, UK">
										</div>
									</div>
									<div class="form-group col-6">
										<label class="col-form-label">City</label>
										<div>
											<input class="form-control" type="text" value="US">
										</div>
									</div>
									<div class="form-group col-6">
										<label class="col-form-label">State</label>
										<div>
											<input class="form-control" type="text" value="California">
										</div>
									</div>
									<div class="form-group col-6">
										<label class="col-form-label">Postcode</label>
										<div>
											<input class="form-control" type="text" value="000702">
										</div>
									</div>

									<div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>

									<div class="col-12 m-t20">
										<div class="ml-auto">
											<h3 class="m-form__section">3. Social Links</h3>
										</div>
									</div>

									<div class="form-group col-6">
										<label class="col-form-label">Linkedin</label>
										<div>
											<input class="form-control" type="text" value="www.linkedin.com">
										</div>
									</div>
									<div class="form-group col-6">
										<label class="col-form-label">Facebook</label>
										<div>
											<input class="form-control" type="text" value="www.facebook.com">
										</div>
									</div>
									<div class="form-group col-6">
										<label class="col-form-label">Twitter</label>
										<div>
											<input class="form-control" type="text" value="www.twitter.com">
										</div>
									</div>
									<div class="form-group col-6">
										<label class="col-form-label">Instagram</label>
										<div>
											<input class="form-control" type="text" value="www.instagram.com">
										</div>
									</div>
									<div class="col-12">
										<button type="reset" class="btn">Save changes</button>
										<button type="reset" class="btn-secondry">Cancel</button>
									</div>
								</div>
							</form>
							<form class="edit-profile">
								<div class="row">
									<div class="col-12 m-t20">
										<div class="ml-auto">
											<h3 class="m-form__section">4. Add Item</h3>
										</div>
									</div>
									<div class="col-12">
										<table id="item-add" class="wam-table-full">
											<tr class="list-item">
												<td>
													<div class="row">
														<div class="col-md-4">
															<label class="col-form-label">Course Name</label>
															<div>
																<input class="form-control" type="text" value="">
															</div>
														</div>
														<div class="col-md-3">
															<label class="col-form-label">Course Category</label>
															<div>
																<input class="form-control" type="text" value="">
															</div>
														</div>
														<div class="col-md-3">
															<label class="col-form-label">Course Category</label>
															<div>
																<input class="form-control" type="text" value="">
															</div>
														</div>
														<div class="col-md-2">
															<label class="col-form-label">Close</label>
															<div class="form-group">
																<a class="delete" href="#"><i class="fa fa-close"></i></a>
															</div>
														</div>
													</div>
												</td>
											</tr>
										</table>
									</div>
									<div class="col-12">
										<button type="button" class="btn-secondry add-item m-r5"><i class="fa fa-fw fa-plus-circle"></i>Add Item</button>
										<button type="reset" class="btn">Save changes</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- Your Profile Views Chart END-->
			</div>
		</div>
	</main>

<?php include('includes/admin-footer.php'); ?>
