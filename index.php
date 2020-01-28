<?php

if(isset($_GET['dev']) && $_GET['dev'] == 'yes'){
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
}

date_default_timezone_set('UTC');

session_start();

// includes
include('inc/db.php');
include('inc/functions.php');

// start timer for page loaded var
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

// get products
$query 								= $conn->query("SELECT * FROM `shop_products` WHERE `category_id` = '1' AND `hidden` = 'no' ORDER BY `title` + 0 ");
$all_products 						= $query->fetchAll(PDO::FETCH_ASSOC);

// get products
$query 								= $conn->query("SELECT * FROM `whmcs`.`tblproductgroups` ORDER BY `name` ");
$all_categories 					= $query->fetchAll(PDO::FETCH_ASSOC);

// set some defaults
$query 								= $conn->query("SELECT * FROM `shop_carts` WHERE `key` = '".$_SESSION['cart_key']."' ");
$cart_items 						= $query->fetchAll(PDO::FETCH_ASSOC);

// get sponsor / affiliate details
if(isset($_SESSION['mlm_affiliate']) && !empty($_SESSION['mlm_affiliate'])){
	$query 								= $conn->query("SELECT * FROM `users` WHERE `id` = '".$_SESSION['mlm_affiliate']."' ");
	$affiliate 							= $query->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html>
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	

		<title><?php echo $site['title']; ?></title>	

		<!--
			<meta name="keywords" content="<?php echo $site['title']; ?>" />
			<meta name="description" content="<?php echo $site['title']; ?> e-Cig vape store and supplies.">
			<meta name="author" content="<?php echo $site['url']; ?>">
		-->

		<!-- Favicon -->
		<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
		<link rel="apple-touch-icon" href="img/apple-touch-icon.png">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome-free/css/all.min.css">
		<link rel="stylesheet" href="vendor/animate/animate.min.css">
		<link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.min.css">
		<link rel="stylesheet" href="vendor/owl.carousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="vendor/owl.carousel/assets/owl.theme.default.min.css">
		<link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.min.css">
		<link rel="stylesheet" href="vendor/bootstrap-star-rating/css/star-rating.min.css">
		<link rel="stylesheet" href="vendor/bootstrap-star-rating/themes/krajee-fas/theme.min.css">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="css/theme.css">
		<link rel="stylesheet" href="css/theme-elements.css">
		<link rel="stylesheet" href="css/theme-blog.css">
		<link rel="stylesheet" href="css/theme-shop.css">

		<!-- Skin CSS -->
		<!-- <link rel="stylesheet" href="css/skins/skin-ublo.css"> -->
		<link rel="stylesheet" href="css/skins/default.css">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="css/custom.css">

		<!-- Head Libs -->
		<script src="vendor/modernizr/modernizr.min.js"></script>

		<!-- Basic age verification -->
		<link href="css/age-verification.css" rel="stylesheet">
	</head>
	<body>
		<div class="demo">
		<div class="body">
			<header id="header" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyStartAt': 135, 'stickySetTop': '-135px', 'stickyChangeLogo': true}">
				<div class="header-body border-color-primary border-bottom-0 box-shadow-none" data-sticky-header-style="{'minResolution': 0}" data-sticky-header-style-active="{'background-color': '#f7f7f7'}" data-sticky-header-style-deactive="{}">
					<div class="header-top header-top-borders">
						<div class="container h-100">
							<div class="header-row h-100">
								<div class="header-column justify-content-start">
									<div class="header-row">
										<nav class="header-nav-top">
											
										</nav>
									</div>
								</div>

								<div class="header-column justify-content-end">
									<div class="header-row">
										<nav class="header-nav-top">
											<ul class="nav nav-pills">
												<li class="nav-item nav-item-anim-icon d-none d-md-block">
													Premium Quality Vape Juice British Made and Certified
												</li>
											</ul>
										</nav>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="header-container container">
						<div class="header-row py-2">
							<div class="header-column">
								<div class="header-row">
									<div class="header-logo">
										<a href="?c=home">
											<img alt="Ublo Club" width="150" height="48" data-sticky-width="82" data-sticky-height="40" data-sticky-top="84" src="img/ublo_logo.png">
										</a>
									</div>
								</div>
							</div>
							<div class="header-column justify-content-end">
								<div class="header-row">
									<!--
										<ul class="header-extra-info d-flex align-items-center mr-3">
											<li class="d-none d-sm-inline-flex">
												<div class="header-extra-info-text">
													<label>SEND US AN EMAIL</label>
													<strong><a href="mailto:mail@example.com">sales@ublo.club</a></strong>
												</div>
											</li>
											<li>
												<div class="header-extra-info-text">
													<label>CALL US NOW</label>
													<strong><a href="tel:8001234567">0800 123 4567</a></strong>
												</div>
											</li>
										</ul>
									-->
									<!-- cart summary -->
									<div class="header-nav-features">
										<div class="header-nav-feature header-nav-features-cart header-nav-features-cart-big d-inline-flex ml-2" data-sticky-header-style="{'minResolution': 991}" data-sticky-header-style-active="{'top': '78px'}" data-sticky-header-style-deactive="{'top': '0'}">
											<a href="#" class="header-nav-features-toggle">
												<img src="img/icons/icon-cart-big.svg" height="34" alt="" class="header-nav-top-icon-img">
												<span class="cart-info">
													<?php
														if(isset($cart_items[0])){
															$cart_total = count($cart_items);

															echo '<span class="cart-qty">'.$cart_total.'</span>';
														}
													?>
												</span>
											</a>
											<div class="header-nav-features-dropdown" id="headerTopCartDropdown">
												<?php if(isset($cart_items[0])){ ?>
													<ol class="mini-products-list">
														<?php foreach($cart_items as $cart_item){ ?>
															<?php foreach($all_products as $product){ ?>
																<?php if($cart_item['product_id'] == $product['id']){ ?>
																	<li class="item">
																		<a href="#" title="Camera X1000" class="product-image"><img src="<?php echo stripslashes($product['image_main']); ?>" alt="<?php echo stripslashes($product['title']); ?>"></a>
																		<div class="product-details">
																			<p class="product-name">
																				<a href="#"><?php echo stripslashes($product['title']); ?></a>
																			</p>
																			<p class="qty-price">
																				 <?php echo stripslashes($cart_item['quantity']); ?> X <span class="price">£<?php echo stripslashes($product['price_month']); ?></span>
																			</p>
																			<!-- <a href="" title="Remove This Item" class="btn-remove"><i class="fas fa-times"></i></a> -->
																		</div>
																	</li>
																	<?php break; ?>
																<?php } ?>
															<?php } ?>
														<?php } ?>
													</ol>
													<div class="totals">
														<span class="label">Total:</span>
														<span class="price-total"><span class="price">£<?php echo number_format($_SESSION['cart_total'], 2); ?></span></span>
													</div>
													<div class="actions">
														<a class="btn btn-danger" href="actions.php?a=empty_cart" onclick="return confirm('Are you sure?')">Empty Cart</a>
														<a class="btn btn-success" href="?c=cart">View Cart</a>
														<!-- <a class="btn btn-primary" href="#">Checkout</a> -->
													</div>
												<?php }else{ ?>
													Cart is empty.
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- top menu -->
					<div class="container">
						<div class="header-nav-bar bg-color-light-scale-1 mb-3 px-3 px-lg-0">
							<div class="header-row">
								<div class="header-column">
									<div class="header-row justify-content-end">
										<div class="header-nav header-nav-links justify-content-start" data-sticky-header-style="{'minResolution': 991}" data-sticky-header-style-active="{'margin-left': '150px'}" data-sticky-header-style-deactive="{'margin-left': '0'}">
											<div class="header-nav-main header-nav-main-square header-nav-main-dropdown-no-borders header-nav-main-dropdown-arrow header-nav-main-effect-3 header-nav-main-sub-effect-1">
												<nav class="collapse">
													<ul class="nav nav-pills" id="mainNav">
														<li class="dropdown">
															<a class="<?php if(get('c')=='' || get('c')=='home'){echo'active';} ?>" href="?c=home">
																Shop
															</a>
														</li>
														<li class="dropdown">
															<a class="<?php if(get('c')=='cart'){echo'active';} ?>" href="?c=cart">
																Cart
															</a>
														</li>
														<li class="dropdown">
															<a class="<?php if(get('c')=='faq'){echo'active';} ?>" href="?c=faq">
																FAQs
															</a>
														</li>
														<li class="dropdown">
															<a class="<?php if(get('c')=='about_us'){echo'active';} ?>" href="?c=about_us">
																About Us
															</a>
														</li>
														<li class="dropdown">
															<a class="<?php if(get('c')=='contact_us'){echo'active';} ?>" href="?c=contact_us">
																Contact Us
															</a>
														</li>
													</ul>
												</nav>
											</div>
											<button class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main nav">
												<i class="fas fa-bars"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>

			<div id="status_message"></div>

			<?php
				$c = $_GET['c'];
				switch ($c){
					// staging
					case "staging":
						staging();
						break;

					case "about_us":
						about_us();
						break;

					case "contact_us":
						contact_us();
						break;

					case "privacy_policy":
						privacy_policy();
						break;

					case "faq":
						faq();
						break;

					case "product":
						product();
						break;

					case "cart":
						cart();
						break;

					// home
					default:
						home();
						break;
				}
			?>

			<?php function home(){ ?>
	        	<?php global $conn, $globals, $global_settings, $site, $all_products, $all_categories; ?>
	        	<?php $max_stars = 5; ?>
				<div role="main" class="main shop py-4">
					<div class="container">
						<div class="masonry-loader masonry-loader-showing">
							<div class="row products product-thumb-info-list" data-plugin-masonry data-plugin-options="{'layoutMode': 'fitRows'}">
								<!-- sample product with sale icon -->
								<!--
									<div class="col-12 col-sm-6 col-lg-3 product">
										<a href="shop-product-sidebar-left.html">
											<span class="onsale">Sale!</span>
										</a>
										<span class="product-thumb-info border-0">
											<a href="shop-cart.html" class="add-to-cart-product bg-color-primary">
												<span class="text-uppercase text-1">Add to Cart</span>
											</a>
											<a href="shop-product-sidebar-left.html">
												<span class="product-thumb-info-image">
													<img alt="" class="img-fluid" src="img/products/product-grey-1.jpg">
												</span>
											</a>
											<span class="product-thumb-info-content product-thumb-info-content pl-0 bg-color-light">
												<a href="shop-product-sidebar-left.html">
													<h4 class="text-4 text-primary">Photo Camera</h4>
													<span class="price">
														<del><span class="amount">$325</span></del>
														<ins><span class="amount text-dark font-weight-semibold">$299</span></ins>
													</span>
												</a>
											</span>
										</span>
									</div>
								-->
								
								<?php foreach($all_products as $product){ ?>
									<?php if($product['homepage'] == 'yes'){ ?>
										<div class="col-12 col-sm-6 col-lg-3 product">
											<?php if($product['sale_icon'] == 'yes'){ ?>
												<a href="?c=product&id=<?php echo $product['id']; ?>">
													<span class="onsale">Sale!</span>
												</a>
											<?php } ?>
											<span class="product-thumb-info border-0">
												<a href="?c=product&id=<?php echo $product['id']; ?>" class="add-to-cart-product bg-color-primary">
													<span class="text-uppercase text-1">Select Options</span>
												</a>
												<a href="?c=product&id=<?php echo $product['id']; ?>">
													<span class="product-thumb-info-image">
														<img alt="" class="img-fluid" src="<?php echo $product['image_main']; ?>">
													</span>
												</a>
												<span class="product-thumb-info-content product-thumb-info-content pl-0 bg-color-light">
													<a href="?c=product&id=<?php echo $product['id']; ?>">
														<h4 class="text-4 text-primary"><?php echo $product['title']; ?></h4>
														
														<div title="Rated <?php echo stripslashes($product['stars']); ?> out of 5" class="float-left">
															<input type="text" class="d-none" value="<?php echo stripslashes($product['stars']); ?>" title="" data-plugin-star-rating data-plugin-options="{'displayOnly': true, 'color': 'primary', 'size':'xs'}">
														</div>

														<div class="pb-0 clearfix"></div>

														<span class="price">
															<ins><span class="amount text-dark font-weight-semibold">£<?php echo $product['price_month']; ?></span></ins>
														</span>
													</a>
												</span>
											</span>
										</div>
									<?php } ?>
								<?php } ?>
							</div>

							<!-- pagination -->
							<!--
								<div class="row">
									<div class="col">
										<ul class="pagination float-right">
											<li class="page-item"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>
											<li class="page-item active"><a class="page-link" href="#">1</a></li>
											<li class="page-item"><a class="page-link" href="#">2</a></li>
											<li class="page-item"><a class="page-link" href="#">3</a></li>
											<a class="page-link" href="#"><i class="fas fa-angle-right"></i></a>
										</ul>
									</div>
								</div>
							-->
						</div>
					</div>
				</div>
			<?php } ?>

			<?php function product(){ ?>
				<?php 
					global $conn, $globals, $global_settings, $site, $all_products, $all_categories;

					$product_id = get('id');
				
					// get product from existing array
					foreach($all_products as $all_product){
						if($product_id == $all_product['id']){
							$product = $all_product;
							break;
						}
					}

					// get linked products
					$query 						= $conn->query("SELECT * FROM `shop_products_linked` WHERE `primary` = '".$product_id."' ");
					$linked_products_raw 		= $query->fetchAll(PDO::FETCH_ASSOC);

					// get the linked product name
					$count 						= 0;
					foreach($linked_products_raw as $linked_product_raw){
						$linked_products[$count]['id'] 				= $linked_product_raw['id'];
						$linked_products[$count]['product_id'] 		= $linked_product_raw['primary'];
						$linked_products[$count]['primary'] 		= $linked_product_raw['primary'];
						$linked_products[$count]['secondary'] 		= $linked_product_raw['secondary'];

						$query 					= $conn->query("SELECT `id`,`title`,`order` FROM `shop_products` WHERE `id` = '".$linked_product_raw['secondary']."' ");
						$linked_product_data 	= $query->fetch(PDO::FETCH_ASSOC);
						$linked_products[$count]['title']			= stripslashes($linked_product_data['title']);

						$count++;
					}

					if(isset($linked_products) && is_array($linked_products)){
						usort($linked_products, 'sort_array_by_title');
					}
				?>

				<div role="main" class="main shop py-4">
					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<div class="row">
									<div class="col-lg-6">
										<div class="owl-carousel owl-theme" data-plugin-options="{'items': 1, 'margin': 10}">
											<div>
												<img alt="" class="img-fluid" src="<?php echo stripslashes($product['image_main']); ?>">
											</div>
										</div>
									</div>

									<div class="col-lg-6">
										<div class="summary entry-summary">
											<h1 class="mb-0 font-weight-bold text-7"><?php echo stripslashes($product['title']); ?></h1>
											<div class="pb-0 clearfix">
												<div title="Rated <?php echo stripslashes($product['stars']); ?> out of 5" class="float-left">
													<input type="text" class="d-none" value="<?php echo stripslashes($product['stars']); ?>" title="" data-plugin-star-rating data-plugin-options="{'displayOnly': true, 'color': 'primary', 'size':'xs'}">
												</div>

												<!--
													<div class="review-num">
														<span class="count" itemprop="ratingCount">2</span> reviews
													</div>
												-->
											</div>

											<p class="price">
												<span class="amount">£<?php echo stripslashes($product['price_month']); ?></span>
											</p>

											<!-- <p class="mb-4"><?php echo stripslashes($product['title_2']); ?></p> -->

											<form action="actions.php?a=add_to_cart" enctype="multipart/form-data" method="post" class="cart">
												<?php if($product['homepage'] == 'yes'){ ?>
													<div class="form-group row">
														<label class="col-lg-12 control-label pt-2" for="blend">Step 1:</label>
														<div class="col-lg-6 col-xs-12">
															<select id="blend" name="blend" class="form-control form-control-sm mb-3" onchange="jump_to_product(this);">
																<option value="" selected="">Choose a strength and blend</option>
																<?php if(is_array($linked_products)){ ?>
																	<?php foreach($linked_products as $linked_product){ ?>
																		<option value="<?php echo $linked_product['secondary']; ?>"><?php echo $linked_product['title']; ?></option>
																	<?php } ?>
																<?php } ?>
															</select>
														</div>
													</div>
												<?php }else{ ?>
													<input type="Hidden" name="product_id" value="<?php echo $product_id; ?>">
													<input type="Hidden" name="price" value="<?php echo $product['price_month']; ?>">
													
													<div class="form-group row">
														<label class="col-lg-12 control-label pt-2" for="blend">Step 2:</label>
														<div class="col-lg-6 col-xs-12">
															<div class="quantity quantity-lg">
																<input type="button" class="minus" value="-">
																<input type="text" class="input-text qty text" title="Qty" value="1" id="quantity" name="quantity" min="1" step="1">
																<input type="button" class="plus" value="+">
															</div>

															<button type="submit" class="btn btn-primary btn-modern text-uppercase">Add to cart</button>
															<a href="?c=cart" class="btn btn-success btn-modern text-uppercase">View Cart</a>
														</div>
													</div>

												<?php } ?>
											</form>

											<!--
												<div class="product-meta">
													<span class="posted-in">Categories: <a rel="tag" href="#">Accessories</a>, <a rel="tag" href="#">Bags</a>.</span>
												</div>
											-->
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col">
										<div class="tabs tabs-product mb-2">
											<ul class="nav nav-tabs">
												<li class="nav-item active"><a class="nav-link py-3 px-4" href="#productDescription" data-toggle="tab">Description</a></li>
												<!-- <li class="nav-item"><a class="nav-link py-3 px-4" href="#productInfo" data-toggle="tab">Additional Information</a></li> -->
												<!-- <li class="nav-item"><a class="nav-link py-3 px-4" href="#productReviews" data-toggle="tab">Reviews (2)</a></li> -->
											</ul>
											<div class="tab-content p-0">
												<div class="tab-pane p-4 active" id="productDescription">
													<?php echo stripslashes($product['description']); ?>
												</div>
												<div class="tab-pane p-4" id="productInfo">
													<table class="table m-0">
														<tbody>
															<tr>
																<th class="border-top-0">
																	Size:
																</th>
																<td class="border-top-0">
																	Unique
																</td>
															</tr>
															<tr>
																<th>
																	Colors
																</th>
																<td>
																	Red, Blue
																</td>
															</tr>
															<tr>
																<th>
																	Material
																</th>
																<td>
																	100% Leather
																</td>
															</tr>
														</tbody>
													</table>
												</div>
												<div class="tab-pane p-4" id="productReviews">
													<ul class="comments">
														<li>
															<div class="comment">
																<div class="img-thumbnail border-0 p-0 d-none d-md-block">
																	<img class="avatar" alt="" src="img/avatars/avatar-2.jpg">
																</div>
																<div class="comment-block">
																	<div class="comment-arrow"></div>
																	<span class="comment-by">
																		<strong>Jack Doe</strong>
																		<span class="float-right">
																			<div class="pb-0 clearfix">
																				<div title="Rated 3 out of 5" class="float-left">
																					<input type="text" class="d-none" value="3" title="" data-plugin-star-rating data-plugin-options="{'displayOnly': true, 'color': 'primary', 'size':'xs'}">
																				</div>
										
																				<div class="review-num">
																					<span class="count" itemprop="ratingCount">2</span> reviews
																				</div>
																			</div>
																		</span>
																	</span>
																	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae, gravida pellentesque urna varius vitae.</p>
																</div>
															</div>
														</li>
														<li>
															<div class="comment">
																<div class="img-thumbnail border-0 p-0 d-none d-md-block">
																	<img class="avatar" alt="" src="img/avatars/avatar.jpg">
																</div>
																<div class="comment-block">
																	<div class="comment-arrow"></div>
																	<span class="comment-by">
																		<strong>John Doe</strong>
																		<span class="float-right">
																			<div class="pb-0 clearfix">
																				<div title="Rated 3 out of 5" class="float-left">
																					<input type="text" class="d-none" value="3" title="" data-plugin-star-rating data-plugin-options="{'displayOnly': true, 'color': 'primary', 'size':'xs'}">
																				</div>
										
																				<div class="review-num">
																					<span class="count" itemprop="ratingCount">2</span> reviews
																				</div>
																			</div>
																		</span>
																	</span>
																	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra odio, gravida urna varius vitae, gravida pellentesque urna varius vitae.</p>
																</div>
															</div>
														</li>
													</ul>
													<hr class="solid my-5">
													<h4>Add a review</h4>
													<div class="row">
														<div class="col">
															<form action="" id="submitReview" method="post">
																<div class="form-row">
																	<div class="form-group col pb-2">
																		<label class="required font-weight-bold text-dark">Rating</label>
																		<input type="text" class="rating-loading" value="0" title="" data-plugin-star-rating data-plugin-options="{'color': 'primary', 'size':'xs'}">
																	</div>
																</div>
																<div class="form-row">
																	<div class="form-group col-lg-6">
																		<label class="required font-weight-bold text-dark">Name</label>
																		<input type="text" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control" name="name" id="name" required>
																	</div>
																	<div class="form-group col-lg-6">
																		<label class="required font-weight-bold text-dark">Email Address</label>
																		<input type="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control" name="email" id="email" required>
																	</div>
																</div>
																<div class="form-row">
																	<div class="form-group col">
																		<label class="required font-weight-bold text-dark">Review</label>
																		<textarea maxlength="5000" data-msg-required="Please enter your review." rows="8" class="form-control" name="review" id="review" required></textarea>
																	</div>
																</div>
																<div class="form-row">
																	<div class="form-group col mb-0">
																		<input type="submit" value="Post Review" class="btn btn-primary btn-modern" data-loading-text="Loading...">
																	</div>
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<hr class="solid my-5">

								<h4 class="mb-3">Related <strong>Products</strong></h4>
								<div class="masonry-loader masonry-loader-showing">
									<div class="row products product-thumb-info-list mt-3" data-plugin-masonry data-plugin-options="{'layoutMode': 'fitRows'}">
										
										<?php
											$query 						= $conn->query("SELECT * FROM `shop_products` WHERE `category_id` = '1' AND `id` != '".$product_id."' ORDER BY RAND() LIMIT 4 ");
											$related_products 			= $query->fetchAll(PDO::FETCH_ASSOC);
										?>

										<?php foreach($related_products as $related_product){ ?>
											<div class="col-12 col-sm-6 col-lg-3 product">
												<span class="product-thumb-info border-0">
													<a href="?c=product&id=<?php echo $related_product['id']; ?>" class="add-to-cart-product bg-color-primary">
														<?php if($related_product['homepage'] == 'yes'){ ?>
															<span class="text-uppercase text-1">Select Options</span>
														<?php }else{ ?>
															<span class="text-uppercase text-1">Order Now</span>
														<?php } ?>
													</a>
													<a href="?c=product&id=<?php echo $related_product['id']; ?>">
														<span class="product-thumb-info-image">
															<img alt="" class="img-fluid" src="<?php echo $related_product['image_main']; ?>">
														</span>
													</a>
													<span class="product-thumb-info-content product-thumb-info-content pl-0 bg-color-light">
														<a href="?c=product&id=<?php echo $related_product['id']; ?>">
															<h4 class="text-4 text-primary"><?php echo stripslashes($related_product['title']); ?></h4>
															<span class="price">
																<ins><span class="amount text-dark font-weight-semibold">£<?php echo $related_product['price_month']; ?></span></ins>
															</span>
														</a>
													</span>
												</span>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<!--
								<div class="col-lg-3">
									<aside class="sidebar">
										<form action="page-search-results.html" method="get">
											<div class="input-group mb-3 pb-1">
												<input class="form-control text-1" placeholder="Search..." name="s" id="s" type="text">
												<span class="input-group-append">
													<button type="submit" class="btn btn-dark text-1 p-2"><i class="fas fa-search m-2"></i></button>
												</span>
											</div>
										</form>
										<h5 class="font-weight-bold pt-3">Categories</h5>
										<ul class="nav nav-list flex-column">
											<li class="nav-item"><a class="nav-link" href="#">Arts & Crafts</a></li>
											<li class="nav-item"><a class="nav-link" href="#">Automotive</a></li>
											<li class="nav-item"><a class="nav-link" href="#">Baby</a></li>
											<li class="nav-item"><a class="nav-link" href="#">Books</a></li>
											<li class="nav-item"><a class="nav-link" href="#">Eletronics</a></li>
											<li class="nav-item"><a class="nav-link" href="#">Women's Fashion</a></li>
											<li class="nav-item"><a class="nav-link" href="#">Men's Fashion</a></li>
											<li class="nav-item"><a class="nav-link" href="#">Health & Household</a></li>
											<li class="nav-item"><a class="nav-link" href="#">Home & Kitchen</a></li>
											<li class="nav-item"><a class="nav-link" href="#">Military Accessories</a></li>
											<li class="nav-item"><a class="nav-link" href="#">Movies & Television</a></li>
											<li class="nav-item"><a class="nav-link" href="#">Sports & Outdoors</a></li>
											<li class="nav-item"><a class="nav-link" href="#">Tools & Home Improvement</a></li>
											<li class="nav-item"><a class="nav-link" href="#">Toys & Games</a></li>
										</ul>
										<h5 class="font-weight-bold pt-5">Tags</h5>
										<div class="mb-3 pb-1">
											<a href="#"><span class="badge badge-dark badge-sm badge-pill text-uppercase px-2 py-1 mr-1">Nike</span></a>
											<a href="#"><span class="badge badge-dark badge-sm badge-pill text-uppercase px-2 py-1 mr-1">Travel</span></a>
											<a href="#"><span class="badge badge-dark badge-sm badge-pill text-uppercase px-2 py-1 mr-1">Sport</span></a>
											<a href="#"><span class="badge badge-dark badge-sm badge-pill text-uppercase px-2 py-1 mr-1">TV</span></a>
											<a href="#"><span class="badge badge-dark badge-sm badge-pill text-uppercase px-2 py-1 mr-1">Books</span></a>
											<a href="#"><span class="badge badge-dark badge-sm badge-pill text-uppercase px-2 py-1 mr-1">Tech</span></a>
											<a href="#"><span class="badge badge-dark badge-sm badge-pill text-uppercase px-2 py-1 mr-1">Adidas</span></a>
											<a href="#"><span class="badge badge-dark badge-sm badge-pill text-uppercase px-2 py-1 mr-1">Promo</span></a>
											<a href="#"><span class="badge badge-dark badge-sm badge-pill text-uppercase px-2 py-1 mr-1">Reading</span></a>
											<a href="#"><span class="badge badge-dark badge-sm badge-pill text-uppercase px-2 py-1 mr-1">Social</span></a>
											<a href="#"><span class="badge badge-dark badge-sm badge-pill text-uppercase px-2 py-1 mr-1">Books</span></a>
											<a href="#"><span class="badge badge-dark badge-sm badge-pill text-uppercase px-2 py-1 mr-1">Tech</span></a>
											<a href="#"><span class="badge badge-dark badge-sm badge-pill text-uppercase px-2 py-1 mr-1">New</span></a>
										</div>
										<div class="row mb-5">
											<div class="col">
												<h5 class="font-weight-bold pt-5">Top Rated Products</h5>
												<ul class="simple-post-list">
													<li>
														<div class="post-image">
															<div class="d-block">
																<a href="shop-product-sidebar-left.html">
																	<img alt="" width="60" height="60" class="img-fluid" src="img/products/product-grey-1.jpg">
																</a>
															</div>
														</div>
														<div class="post-info">
															<a href="shop-product-sidebar-left.html">Photo Camera</a>
															<div class="post-meta text-dark font-weight-semibold">
																$299
															</div>
														</div>
													</li>
													<li>
														<div class="post-image">
															<div class="d-block">
																<a href="shop-product-sidebar-left.html">
																	<img alt="" width="60" height="60" class="img-fluid" src="img/products/product-grey-4.jpg">
																</a>
															</div>
														</div>
														<div class="post-info">
															<a href="shop-product-sidebar-left.html">Luxury bag</a>
															<div class="post-meta text-dark font-weight-semibold">
																$199
															</div>
														</div>
													</li>
													<li>
														<div class="post-image">
															<div class="d-block">
																<a href="shop-product-sidebar-left.html">
																	<img alt="" width="60" height="60" class="img-fluid" src="img/products/product-grey-8.jpg">
																</a>
															</div>
														</div>
														<div class="post-info">
															<a href="shop-product-sidebar-left.html">Military Rucksack</a>
															<div class="post-meta text-dark font-weight-semibold">
																$49
															</div>
														</div>
													</li>
												</ul>
											</div>
										</div>
									</aside>
								</div>
							-->
						</div>
					</div>
				</div>
			<?php } ?>

			<?php function cart(){ ?>
				<?php global $conn, $globals, $global_settings, $site, $all_products, $all_categories, $cart_items, $affiliate; ?>
				
				<div role="main" class="main shop py-4">
					<div class="container">
						<div class="row">
							<div class="col-lg-9">
								<div class="accordion accordion-modern" id="accordion">
									<div class="card card-default">
										<div class="card-header">
											<h4 class="card-title m-0">
												<a class="accordion-toggle">
													Cart
												</a>
											</h4>
										</div>
										<div id="collapseOne" class="collapse show">
											<div class="card-body">
												<div class="card-body">
													<?php if(isset($cart_items[0])){ ?>
														<form action="actions.php?a=update_cart_checkout" enctype="multipart/form-data" method="post" class="cart">
															<table class="shop_table cart">
																<thead>
																	<tr>
																		<th class="product-name">
																			Product
																		</th>
																		<th class="product-price">
																			Price
																		</th>
																		<th class="product-quantity">
																			Quantity
																		</th>
																		<th class="product-subtotal">
																			Total
																		</th>
																		<th>
																			Actions
																		</th>
																	</tr>
																</thead>
																<tbody>
																	<?php if(isset($cart_items[0])){ ?>
																		<ol class="mini-products-list">
																			<?php foreach($cart_items as $cart_item){ ?>
																				<?php foreach($all_products as $product){ ?>
																					<?php if($cart_item['product_id'] == $product['id']){ ?>
																						<tr class="cart_table_item">
																							<td class="product-name">
																								<input type="hidden" name="product_ids[]" value="<?php echo $product['id']; ?>">
																								<strong><?php echo stripslashes($product['title']); ?></strong>
																							</td>
																							<td class="product-price">
																								<input type="hidden" name="prices[]" value="<?php echo $cart_item['price']; ?>">
																								<span class="amount">£<?php echo number_format($cart_item['price'], 2); ?></span>
																							</td>
																							<td class="product-quantity">
																								<div class="quantity quantity-lg">
																									<input type="button" class="minus" value="-">
																									<input type="text" class="input-text qty text" title="Qty" value="<?php echo stripslashes($cart_item['quantity']); ?>" id="quantity" name="quantities[]" min="1" step="1">
																									<input type="button" class="plus" value="+">
																								</div>
																							</td>
																							<td class="product-subtotal">
																								<span class="amount">£<?php echo number_format($cart_item['price'] * $cart_item['quantity'], 2); ?></span>
																							</td>
																							<td>
																								<a href="actions.php?a=delete_cart_item&id=<?php echo $cart_item['id']; ?>" title="Delete this item" class="btn btn-danger" onclick="return confirm('Are you sure?')"><strong>X</strong></a>
																							</td>
																						</tr>

																						<?php break; ?>
																					<?php } ?>
																				<?php } ?>
																			</ol>
																		<?php } ?>
																	<?php } ?>
																</tbody>
															</table>

															<div class="form-row">
																<div class="form-group col">
																	<label class="font-weight-bold text-dark text-2">Shipping</label>
																	<select id="shipping_id" name="shipping_id" class="form-control" onchange="set_shipping(this);">
																		<option value="">Select Shipping Method</option>
																		<?php if(number_format($_SESSION['cart_total'], 2) > 39.90){ ?>
																			<option value="shipping_free" <?php if($_SESSION['shipping_id']=='shipping_free'){echo'selected';}?>>Free 48 Hour Shipping.</option>
																		<?php }else{ ?>
																			<option value="shipping_48" <?php if($_SESSION['shipping_id']=='shipping_48'){echo'selected';}?>>Royal Mail 48 Hour Signed For - £2.99</option>
																			<option value="shipping_24" <?php if($_SESSION['shipping_id']=='shipping_24'){echo'selected';}?>>Royal Mail 24 Hour Signed For - £3.99</option>
																			<option value="shipping_nextday" <?php if($_SESSION['shipping_id']=='shipping_nextday'){echo'selected';}?>>Guaranteed Next Working Day - £7.99</option>
																		<?php } ?>
																	</select>
																</div>
															</div>

															<div class="form-row">
																<div class="form-group col">
																	<a href="?c=home" class="btn btn-default btn-modern text-uppercase mt-5 mb-5 mb-lg-0 float-right mb-2">Continue Shopping</a>
																	<input type="submit" value="Update Cart" class="btn btn-success btn-modern text-uppercase mt-5 mb-5 mb-lg-0 float-right mb-2" data-loading-text="Loading...">
																</div>
															</div>
														</form>
													<?php }else{ ?>
														Your cart is empty. Please add at least one product from our <a href="?c=home">shop</a>.
													<?php } ?>
												</div>

												<?php if(isset($cart_items[0]) && isset($_SESSION['shipping_id']) && !empty($_SESSION['shipping_id'])){ ?>
													<div class="row">
														<div class="col">
															<div class="tabs tabs-product mb-2">
																<ul class="nav nav-tabs">
																	<li class="nav-item active"><a class="nav-link py-3 px-4" href="#new_customer" data-toggle="tab">New Customer</a></li>
																	<li class="nav-item"><a class="nav-link py-3 px-4" href="#existing_customer" data-toggle="tab">Existing Customer</a></li>
																	<!-- <li class="nav-item"><a class="nav-link py-3 px-4" href="#productReviews" data-toggle="tab">Reviews (2)</a></li> -->
																</ul>
																<div class="tab-content p-0">
																	<div class="tab-pane p-4 active" id="new_customer">
																		<form action="actions.php?a=checkout" id="frmBillingAddress" method="post">
																			<div class="form-row">
																				<div class="form-group col-lg-6">
																					<label class="font-weight-bold text-dark text-2">First Name</label>
																					<input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo $_SESSION['checkout_details']['first_name']; ?>" required="">
																				</div>
																				<div class="form-group col-lg-6">
																					<label class="font-weight-bold text-dark text-2">Last Name</label>
																					<input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo $_SESSION['checkout_details']['last_name']; ?>" required="">
																				</div>
																			</div>
																			<div class="form-row">
																				<div class="form-group col">
																					<label class="font-weight-bold text-dark text-2">Company Name <small>(optional)</small></label>
																					<input type="text" id="company_name" name="company_name" class="form-control" value="<?php echo $_SESSION['checkout_details']['company_name']; ?>">
																				</div>
																			</div>
																			<div class="form-row">
																				<div class="form-group col">
																					<label class="font-weight-bold text-dark text-2">Address 1</label>
																					<input type="text" id="address_1" name="address_1" class="form-control" value="<?php echo $_SESSION['checkout_details']['address_1']; ?>" required="">
																				</div>
																			</div>
																			<!--
																			<div class="form-row">
																				<div class="form-group col">
																					<label class="font-weight-bold text-dark text-2">Address 2 <small>(optional)</small></label>
																					<input type="text" id="address_2" name="address_2" class="form-control" value="<?php echo $_SESSION['checkout_details']['address_2']; ?>">
																				</div>
																			</div>
																			-->
																			<div class="form-row">
																				<div class="form-group col">
																					<label class="font-weight-bold text-dark text-2">City </label>
																					<input type="text" id="address_city" name="address_city" class="form-control" value="<?php echo $_SESSION['checkout_details']['address_city']; ?>" required="">
																				</div>
																			</div>
																			<div class="form-row">
																				<div class="form-group col">
																					<label class="font-weight-bold text-dark text-2">County </label>
																					<input type="text" id="address_state" name="address_state" class="form-control" value="<?php echo $_SESSION['checkout_details']['address_state']; ?>" required="">
																				</div>
																			</div>
																			<div class="form-row">
																				<div class="form-group col">
																					<label class="font-weight-bold text-dark text-2">Country</label>
																					<select id="address_country" name="address_country" class="form-control" required="">
																						<!--
																						<option value="" disabled="">Choose one</option>
																						<option value="AF">Afghanistan</option>
																						<option value="AX">Åland Islands</option>
																						<option value="AL">Albania</option>
																						<option value="DZ">Algeria</option>
																						<option value="AS">American Samoa</option>
																						<option value="AD">Andorra</option>
																						<option value="AO">Angola</option>
																						<option value="AI">Anguilla</option>
																						<option value="AQ">Antarctica</option>
																						<option value="AG">Antigua and Barbuda</option>
																						<option value="AR">Argentina</option>
																						<option value="AM">Armenia</option>
																						<option value="AW">Aruba</option>
																						<option value="AU">Australia</option>
																						<option value="AT">Austria</option>
																						<option value="AZ">Azerbaijan</option>
																						<option value="BS">Bahamas</option>
																						<option value="BH">Bahrain</option>
																						<option value="BD">Bangladesh</option>
																						<option value="BB">Barbados</option>
																						<option value="BY">Belarus</option>
																						<option value="BE">Belgium</option>
																						<option value="BZ">Belize</option>
																						<option value="BJ">Benin</option>
																						<option value="BM">Bermuda</option>
																						<option value="BT">Bhutan</option>
																						<option value="BO">Bolivia, Plurinational State of</option>
																						<option value="BQ">Bonaire, Sint Eustatius and Saba</option>
																						<option value="BA">Bosnia and Herzegovina</option>
																						<option value="BW">Botswana</option>
																						<option value="BV">Bouvet Island</option>
																						<option value="BR">Brazil</option>
																						<option value="IO">British Indian Ocean Territory</option>
																						<option value="BN">Brunei Darussalam</option>
																						<option value="BG">Bulgaria</option>
																						<option value="BF">Burkina Faso</option>
																						<option value="BI">Burundi</option>
																						<option value="KH">Cambodia</option>
																						<option value="CM">Cameroon</option>
																						<option value="CA">Canada</option>
																						<option value="CV">Cape Verde</option>
																						<option value="KY">Cayman Islands</option>
																						<option value="CF">Central African Republic</option>
																						<option value="TD">Chad</option>
																						<option value="CL">Chile</option>
																						<option value="CN">China</option>
																						<option value="CX">Christmas Island</option>
																						<option value="CC">Cocos (Keeling) Islands</option>
																						<option value="CO">Colombia</option>
																						<option value="KM">Comoros</option>
																						<option value="CG">Congo</option>
																						<option value="CD">Congo, the Democratic Republic of the</option>
																						<option value="CK">Cook Islands</option>
																						<option value="CR">Costa Rica</option>
																						<option value="CI">Côte d'Ivoire</option>
																						<option value="HR">Croatia</option>
																						<option value="CU">Cuba</option>
																						<option value="CW">Curaçao</option>
																						<option value="CY">Cyprus</option>
																						<option value="CZ">Czech Republic</option>
																						<option value="DK">Denmark</option>
																						<option value="DJ">Djibouti</option>
																						<option value="DM">Dominica</option>
																						<option value="DO">Dominican Republic</option>
																						<option value="EC">Ecuador</option>
																						<option value="EG">Egypt</option>
																						<option value="SV">El Salvador</option>
																						<option value="GQ">Equatorial Guinea</option>
																						<option value="ER">Eritrea</option>
																						<option value="EE">Estonia</option>
																						<option value="ET">Ethiopia</option>
																						<option value="FK">Falkland Islands (Malvinas)</option>
																						<option value="FO">Faroe Islands</option>
																						<option value="FJ">Fiji</option>
																						<option value="FI">Finland</option>
																						<option value="FR">France</option>
																						<option value="GF">French Guiana</option>
																						<option value="PF">French Polynesia</option>
																						<option value="TF">French Southern Territories</option>
																						<option value="GA">Gabon</option>
																						<option value="GM">Gambia</option>
																						<option value="GE">Georgia</option>
																						<option value="DE">Germany</option>
																						<option value="GH">Ghana</option>
																						<option value="GI">Gibraltar</option>
																						<option value="GR">Greece</option>
																						<option value="GL">Greenland</option>
																						<option value="GD">Grenada</option>
																						<option value="GP">Guadeloupe</option>
																						<option value="GU">Guam</option>
																						<option value="GT">Guatemala</option>
																						<option value="GG">Guernsey</option>
																						<option value="GN">Guinea</option>
																						<option value="GW">Guinea-Bissau</option>
																						<option value="GY">Guyana</option>
																						<option value="HT">Haiti</option>
																						<option value="HM">Heard Island and McDonald Islands</option>
																						<option value="VA">Holy See (Vatican City State)</option>
																						<option value="HN">Honduras</option>
																						<option value="HK">Hong Kong</option>
																						<option value="HU">Hungary</option>
																						<option value="IS">Iceland</option>
																						<option value="IN">India</option>
																						<option value="ID">Indonesia</option>
																						<option value="IR">Iran, Islamic Republic of</option>
																						<option value="IQ">Iraq</option>
																						<option value="IE">Ireland</option>
																						<option value="IM">Isle of Man</option>
																						<option value="IL">Israel</option>
																						<option value="IT">Italy</option>
																						<option value="JM">Jamaica</option>
																						<option value="JP">Japan</option>
																						<option value="JE">Jersey</option>
																						<option value="JO">Jordan</option>
																						<option value="KZ">Kazakhstan</option>
																						<option value="KE">Kenya</option>
																						<option value="KI">Kiribati</option>
																						<option value="KP">Korea, Democratic People's Republic of</option>
																						<option value="KR">Korea, Republic of</option>
																						<option value="KW">Kuwait</option>
																						<option value="KG">Kyrgyzstan</option>
																						<option value="LA">Lao People's Democratic Republic</option>
																						<option value="LV">Latvia</option>
																						<option value="LB">Lebanon</option>
																						<option value="LS">Lesotho</option>
																						<option value="LR">Liberia</option>
																						<option value="LY">Libya</option>
																						<option value="LI">Liechtenstein</option>
																						<option value="LT">Lithuania</option>
																						<option value="LU">Luxembourg</option>
																						<option value="MO">Macao</option>
																						<option value="MK">Macedonia, the former Yugoslav Republic of</option>
																						<option value="MG">Madagascar</option>
																						<option value="MW">Malawi</option>
																						<option value="MY">Malaysia</option>
																						<option value="MV">Maldives</option>
																						<option value="ML">Mali</option>
																						<option value="MT">Malta</option>
																						<option value="MH">Marshall Islands</option>
																						<option value="MQ">Martinique</option>
																						<option value="MR">Mauritania</option>
																						<option value="MU">Mauritius</option>
																						<option value="YT">Mayotte</option>
																						<option value="MX">Mexico</option>
																						<option value="FM">Micronesia, Federated States of</option>
																						<option value="MD">Moldova, Republic of</option>
																						<option value="MC">Monaco</option>
																						<option value="MN">Mongolia</option>
																						<option value="ME">Montenegro</option>
																						<option value="MS">Montserrat</option>
																						<option value="MA">Morocco</option>
																						<option value="MZ">Mozambique</option>
																						<option value="MM">Myanmar</option>
																						<option value="NA">Namibia</option>
																						<option value="NR">Nauru</option>
																						<option value="NP">Nepal</option>
																						<option value="NL">Netherlands</option>
																						<option value="NC">New Caledonia</option>
																						<option value="NZ">New Zealand</option>
																						<option value="NI">Nicaragua</option>
																						<option value="NE">Niger</option>
																						<option value="NG">Nigeria</option>
																						<option value="NU">Niue</option>
																						<option value="NF">Norfolk Island</option>
																						<option value="MP">Northern Mariana Islands</option>
																						<option value="NO">Norway</option>
																						<option value="OM">Oman</option>
																						<option value="PK">Pakistan</option>
																						<option value="PW">Palau</option>
																						<option value="PS">Palestinian Territory, Occupied</option>
																						<option value="PA">Panama</option>
																						<option value="PG">Papua New Guinea</option>
																						<option value="PY">Paraguay</option>
																						<option value="PE">Peru</option>
																						<option value="PH">Philippines</option>
																						<option value="PN">Pitcairn</option>
																						<option value="PL">Poland</option>
																						<option value="PT">Portugal</option>
																						<option value="PR">Puerto Rico</option>
																						<option value="QA">Qatar</option>
																						<option value="RE">Réunion</option>
																						<option value="RO">Romania</option>
																						<option value="RU">Russian Federation</option>
																						<option value="RW">Rwanda</option>
																						<option value="BL">Saint Barthélemy</option>
																						<option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
																						<option value="KN">Saint Kitts and Nevis</option>
																						<option value="LC">Saint Lucia</option>
																						<option value="MF">Saint Martin (French part)</option>
																						<option value="PM">Saint Pierre and Miquelon</option>
																						<option value="VC">Saint Vincent and the Grenadines</option>
																						<option value="WS">Samoa</option>
																						<option value="SM">San Marino</option>
																						<option value="ST">Sao Tome and Principe</option>
																						<option value="SA">Saudi Arabia</option>
																						<option value="SN">Senegal</option>
																						<option value="RS">Serbia</option>
																						<option value="SC">Seychelles</option>
																						<option value="SL">Sierra Leone</option>
																						<option value="SG">Singapore</option>
																						<option value="SX">Sint Maarten (Dutch part)</option>
																						<option value="SK">Slovakia</option>
																						<option value="SI">Slovenia</option>
																						<option value="SB">Solomon Islands</option>
																						<option value="SO">Somalia</option>
																						<option value="ZA">South Africa</option>
																						<option value="GS">South Georgia and the South Sandwich Islands</option>
																						<option value="SS">South Sudan</option>
																						<option value="ES">Spain</option>
																						<option value="LK">Sri Lanka</option>
																						<option value="SD">Sudan</option>
																						<option value="SR">Suriname</option>
																						<option value="SJ">Svalbard and Jan Mayen</option>
																						<option value="SZ">Swaziland</option>
																						<option value="SE">Sweden</option>
																						<option value="CH">Switzerland</option>
																						<option value="SY">Syrian Arab Republic</option>
																						<option value="TW">Taiwan, Province of China</option>
																						<option value="TJ">Tajikistan</option>
																						<option value="TZ">Tanzania, United Republic of</option>
																						<option value="TH">Thailand</option>
																						<option value="TL">Timor-Leste</option>
																						<option value="TG">Togo</option>
																						<option value="TK">Tokelau</option>
																						<option value="TO">Tonga</option>
																						<option value="TT">Trinidad and Tobago</option>
																						<option value="TN">Tunisia</option>
																						<option value="TR">Turkey</option>
																						<option value="TM">Turkmenistan</option>
																						<option value="TC">Turks and Caicos Islands</option>
																						<option value="TV">Tuvalu</option>
																						<option value="UG">Uganda</option>
																						<option value="UA">Ukraine</option>
																						<option value="AE">United Arab Emirates</option>
																						-->
																						<option value="GB" selected>United Kingdom</option>
																						<!--
																						<option value="US">United States</option>
																						<option value="UM">United States Minor Outlying Islands</option>
																						<option value="UY">Uruguay</option>
																						<option value="UZ">Uzbekistan</option>
																						<option value="VU">Vanuatu</option>
																						<option value="VE">Venezuela, Bolivarian Republic of</option>
																						<option value="VN">Viet Nam</option>
																						<option value="VG">Virgin Islands, British</option>
																						<option value="VI">Virgin Islands, U.S.</option>
																						<option value="WF">Wallis and Futuna</option>
																						<option value="EH">Western Sahara</option>
																						<option value="YE">Yemen</option>
																						<option value="ZM">Zambia</option>
																						<option value="ZW">Zimbabwe</option>
																						-->
																					</select>
																				</div>
																			</div>
																			<div class="form-row">
																				<div class="form-group col">
																					<label class="font-weight-bold text-dark text-2">Postal Code </label>
																					<input type="text" id="address_zip" name="address_zip" class="form-control" value="<?php echo $_SESSION['checkout_details']['address_zip']; ?>"  required="">
																				</div>
																			</div>
																			<div class="form-row">
																				<div class="form-group col">
																					<label class="font-weight-bold text-dark text-2">Email Address </label>
																					<input type="text" id="email" name="email" class="form-control" value="<?php echo $_SESSION['checkout_details']['email']; ?>" required="">
																				</div>
																			</div>
																			<!--
																			<div class="form-row">
																				<div class="form-group col">
																					<label class="font-weight-bold text-dark text-2">Tel </label>
																					<input type="text" id="tel" name="tel" class="form-control" placeholder="+44 7399 973949" value="<?php echo $_SESSION['checkout_details']['tel']; ?>" required="">
																				</div>
																			</div>
																			-->
																			<div class="form-row">
																				<div class="form-group col-lg-6">
																					<label class="font-weight-bold text-dark text-2">Password </label>
																					<input type="password" id="password" name="password" class="form-control" placeholder="********" required="">
																				</div>
																				<div class="form-group col-lg-6">
																					<label class="font-weight-bold text-dark text-2">Re-type Password </label>
																					<input type="password" id="password2" name="password2" class="form-control" placeholder="********" required="">
																				</div>
																			</div>
																			<div class="form-row">
																				<div class="form-group col">
																					<input type="submit" value="Place Order" class="btn btn-primary btn-modern text-uppercase mt-5 mb-5 mb-lg-0 float-right mb-2" data-loading-text="Loading...">
																				</div>
																			</div>
																		</form>
																	</div>
																	<div class="tab-pane p-4" id="existing_customer">
																		<form action="actions.php?a=checkout&login=yes" id="frmBillingAddress" method="post">
																			<div class="form-row">
																				<div class="form-group col-lg-6">
																					<label class="font-weight-bold text-dark text-2">Email Address </label>
																					<input type="text" id="email" name="email" class="form-control" value="" required="">
																				</div>
																				<div class="form-group col-lg-6">
																					<label class="font-weight-bold text-dark text-2">Password </label>
																					<input type="password" id="password" name="password" class="form-control" placeholder="********" required="">
																				</div>
																			</div>
																			<div class="form-row">
																				<div class="form-group col">
																					<input type="submit" value="Login & Order" class="btn btn-primary btn-modern text-uppercase mt-5 mb-5 mb-lg-0 float-right mb-2" data-loading-text="Loading...">
																				</div>
																			</div>
																		</form>
																	</div>
																</div>
															</div>
														</div>
													</div>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
								
								<!--
								<div class="actions-continue">
									<input type="submit" value="Place Order" name="proceed" class="btn btn-primary btn-modern text-uppercase mt-5 mb-5 mb-lg-0">
								</div>
								-->

							</div>
							<div class="col-lg-3">
								<h4 class="text-primary">Cart Totals</h4>
								<table class="cart-totals">
									<tbody>
										<tr class="cart-subtotal">
											<th>
												<strong class="text-dark">Cart Subtotal</strong>
											</th>
											<td>
												<strong class="text-dark"><span class="amount">£<?php echo number_format($_SESSION['cart_total'], 2); ?></span></strong>
											</td>
										</tr>
										<tr class="shipping">
											<th>
												Shipping
											</th>
											<td>
												<?php 
													if($_SESSION['shipping_id'] == 'shipping_free'){
														$shipping_cost = 'Free';
													}elseif($_SESSION['shipping_id'] == 'shipping_48'){
														$shipping_cost = '£2.99';
													}elseif($_SESSION['shipping_id'] == 'shipping_24'){
														$shipping_cost = '£3.99';
													}elseif($_SESSION['shipping_id'] == 'shipping_nextday'){
														$shipping_cost = '£7.99';
													}else{
														$shipping_cost = 'Select Option';
													}

													echo $shipping_cost;
												?>
											</td>
										</tr>
										<tr class="total">
											<th>
												<strong class="text-dark">Order Total</strong>
											</th>
											<td>
												<strong class="text-dark"><span class="amount">£<?php echo number_format($_SESSION['cart_total'], 2); ?></span></strong>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>

			<?php function faq(){ ?>
				<?php 
					global $conn, $globals, $global_settings, $site, $all_products, $all_categories;

					// set some defaults
					$query 								= $conn->query("SELECT * FROM `shop_faq` WHERE `website` = 'ublo.club' ORDER BY 'title' ");
					$faqs 								= $query->fetchAll(PDO::FETCH_ASSOC);
				?>

				<div role="main" class="main">
					<div class="container py-4">
						<div class="row">
							<div class="col">
								<div class="toggle toggle-primary" data-plugin-toggle>
									<?php foreach($faqs as $faq){ ?>
										<section class="toggle">
											<label><?php echo stripslashes($faq['title']); ?></label>
											<?php echo htmlspecialchars_decode(stripslashes($faq['description'])); ?>
										</section>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>

			<?php function about_us(){ ?>
	        	<?php global $conn, $globals, $global_settings, $site, $all_products, $all_categories; ?>
				<div role="main" class="main shop py-4">
					<div class="container">
						<h3>About Us</h3>
						Ublo Club was launched with a clearly defined goal of bringing the very highest quality Premium Quality British Made & Certified Juice to the British vaper.<br>
						<br>
						For your peace of mind, the ingredients Ublo Club use in our vaping liquids are pharmaceutical grade and the finest food grade flavourings. They are laboratory tested and certified to comply with the TPD (Tobacco Products Directive*) so that you can relax and enjoying your vaping without having to worry about cheap sub standard and ‘grey market’ products.<br>
						<br>
						<a href="https://www.gov.uk/guidance/e-cigarettes-regulations-for-consumer-products" target="_blank" rel=nofollow>‘Tobacco Products Directive</a>
					</div>
				</div>
			<?php } ?>

			<?php function contact_us(){ ?>
	        	<?php global $conn, $globals, $global_settings, $site, $all_products, $all_categories; ?>
				<div role="main" class="main shop py-4">
					<div class="container">
						<h3>Contact Us</h3>
						<strong>Registered Address</strong><br>
						Ublo Club Ltd<br>
						20-22 Wenlock Road<br>
						London<br>
						England<br>
						N1 7GU<br>
						<br>
						<strong>Phone</strong><br>
						0121 2856690<br>
						<br>
						<strong>Email</strong><br>
						<a href="mailto:sales@ublo.club">sales@ublo.club</a>
					</div>
				</div>
			<?php } ?>

			<?php function privacy_policy(){ ?>
	        	<?php global $conn, $globals, $global_settings, $site, $all_products, $all_categories; ?>
				<div role="main" class="main shop py-4">
					<div class="container">
						<h3>Privacy Policy</h3>
						Ublo Club complies with the General Data Protection Regulation (GDPR) 2018<br>
						<br>
						Your privacy is important to us. Read this policy to learn about the personal data that we collect from you and how we use it. We encourage you to read the policy and get in touch if you have any queries.<br>
						This Privacy Policy describes how your personal information is collected, used, and shared when you visit or make a purchase from https://ublo.club (the “Site”).<br>
						<br>

						<strong>PERSONAL INFORMATION WE COLLECT</strong><br>
						When you visit the Site, we automatically collect certain information about your device, including information about your web browser, IP address, time zone, and some of the cookies that are installed on your device. Additionally, as you browse the Site, we collect information about the individual web pages or products that you view, what websites or search terms referred you to the Site, and information about how you interact with the Site. We refer to this automatically collected information as “Device Information.”<br>
						We collect Device Information using the following technologies:<br>
						– “Cookies” are data files that are placed on your device or computer and often include an anonymous unique identifier. For more information about cookies, and how to disable cookies, visit http://www.allaboutcookies.org.<br>
						– “Log files” track actions occurring on the Site, and collect data including your IP address, browser type, Internet service provider, referring/exit pages, and date/time stamps.<br>
						– “Web beacons,” “tags,” and “pixels” are electronic files used to record information about how you browse the Site.<br>
						Additionally when you make a purchase or attempt to make a purchase through the Site, we collect certain information from you, including your name, billing address, shipping address, payment information (including credit or debit card numbers, email address, and phone number). We refer to this information as “Order Information.”<br>
						When we talk about “Personal Information” in this Privacy Policy, we are talking both about Device Information and Order Information.<br>
						<br>

						<strong>HOW DO WE USE YOUR PERSONAL INFORMATION?</strong><br>
						We use the Order Information that we collect generally to fulfil any orders placed through the Site (including processing your payment information, arranging for shipping, and providing you with invoices and/or order confirmations). Additionally, we use this Order Information to:<br>
						Communicate with you;<br>
						Screen our orders for potential risk or fraud; and<br>
						When in line with the preferences you have shared with us, provide you with information or advertising relating to our products or services.<br>
						We use the Device Information that we collect to help us screen for potential risk and fraud (in particular, your IP address), and more generally to improve and optimise our Site (for example, by generating analytics about how our customers browse and interact with the Site, and to assess the success of our marketing and advertising campaigns).<br>
						<br>

						<strong>SHARING YOUR PERSONAL INFORMATION</strong><br>
						We share your Personal Information with third parties to help us use your Personal Information, as described above.<br>
						We use Google Analytics to help us understand how our customers use the Site – you can read more about how Google uses your Personal Information here: https://www.google.com/intl/en/policies/privacy/.<br>
						You can also opt-out of Google Analytics here: https://tools.google.com/dlpage/gaoptout.<br>
						Finally, we may also share your Personal Information to comply with applicable laws and regulations, to respond to a subpoena, search warrant or other lawful request for information we receive, or to otherwise protect our rights.<br>
						<br>

						<strong>DO NOT TRACK</strong><br>
						Please note that we do not alter our Site’s data collection and use practices when we see a Do Not Track signal from your browser.<br>
						<br>

						<strong>YOUR RIGHTS</strong><br>
						If you are a European resident, you have the right to access personal information we hold about you and to ask that your personal information be corrected, updated, or deleted. If you would like to exercise this right, please contact us through the contact information below.<br>
						Additionally, if you are a European resident we note that we are processing your information in order to fulfil contracts we might have with you (for example if you make an order through the Site), or otherwise to pursue our legitimate business interests listed above.<br>
						<br>

						<strong>DATA RETENTION</strong><br>
						When you place an order through the Site, we will maintain your Order Information for our records unless and until you ask us to delete this information.<br>
						<br>

						<strong>MINORS</strong><br>
						The Site is not intended for individuals under the age of 18.<br>
						<br>

						<strong>CHANGES</strong><br>
						We may update this privacy policy from time to time in order to reflect, for example, changes to our practices or for other operational, legal or regulatory reasons.<br>
						<br>

						<strong>TERMS OF SERVICE</strong><br>
						Specific terms relating to accessing our website and the purchase of our products can be found in our Terms of Service policy. Please read before using our service.<br>
						<br>

						<strong>CONTACT US</strong><br>
						For more information about our privacy practices, if you have questions, or if you would like to make a complaint, please contact us via the contact form on this website or by mail using the details provided below:<br>
						Ublo Club Ltd, 20-22 Wenlock Road, London, England, N1 7GU
					</div>
				</div>
			<?php } ?>

			<?php function staging(){ ?>
	        	<?php global $conn, $globals, $global_settings, $site, $all_products, $all_categories; ?>
	        	<?php $max_stars = 5; ?>
				<div role="main" class="main shop py-4">
					<div class="container">
						<?php debug($_SESSION); ?>
					</div>
				</div>
			<?php } ?>

			<footer id="footer">
				<div class="container mt-4 pt-2 pb-5 footer-top-light-border">
					<div class="row py-4">
						<div class="col-md-3 text-center text-md-left">
							<h5 class="text-4 text-color-light mb-3 mt-4 mt-lg-0">CONTACT INFO</h5>
							<p class="text-3 mb-0 text-color-light opacity-7">REGISTERED ADDRESS</p>
							<p class="text-3 mb-3">Ublo Club Ltd, 20-22 Wenlock Road, London, England, N1 7GU</p>
							<p class="text-3 mb-0 text-color-light opacity-7">PHONE</p>
							<p class="text-3 mb-3">0121 2856690</p>
							<p class="text-3 mb-0 text-color-light opacity-7">EMAIL</p>
							<p class="text-3 mb-0"><a href="mailto:info@porto.com" class="">sales@ublo.club</a></p>
						</div>
						<div class="col-md-9 text-center text-md-left">
							<div class="row">
								<div class="col-md-7 col-lg-5 mb-0">
									<h5 class="text-4 text-color-light mb-3 mt-4 mt-lg-0">MY ACCOUNT</h5>
									<div class="row">
										<div class="col-md-5">
											<p class="mb-1"><a href="?c=about_us" class="text-3 link-hover-style-1">About Us</a></p>
											<p class="mb-1"><a href="?c=contact_us" class="text-3 link-hover-style-1">Contact Us</a></p>
											<p class="mb-1"><a href="?c=privacy_policy" class="text-3 link-hover-style-1">Privacy Policy</a></p>
											<p class="mb-1"><a href="?c=faq" class="text-3 link-hover-style-1">FAQ</a></p>
											<p class="mb-1"><a href="https://ublo.club/billing" class="text-3 link-hover-style-1">My Account</a></p>
										</div>
										<!--
											<div class="col-md-5">
												<p class="mb-1"><a href="#" class="text-3 link-hover-style-1">Orders history</a></p>
												<p class="mb-1"><a href="#" class="text-3 link-hover-style-1">Advanced search</a></p>
												<p class="mb-1"><a href="#" class="text-3 link-hover-style-1">Login</a></p>
											</div>
										-->
									</div>
								</div>
								<div class="col-md-5 col-lg-4">
									<!--
										<h5 class="text-4 text-color-light mb-3 mt-4 mt-lg-0">MAIN FEATURES</h5>
										<p class="mb-1"><a href="#" class="text-3 link-hover-style-1">Super Fast Theme</a></p>
										<p class="mb-1"><a href="#" class="text-3 link-hover-style-1">SEO Optmized</a></p>
										<p class="mb-1"><a href="#" class="text-3 link-hover-style-1">RTL Support</a></p>
									-->
								</div>
								<div class="col-lg-3">
									<!--
										<p class="mb-1 mt-lg-3 pt-lg-3"><a href="" class="text-3">Powerful Admin Panel</a></p>
										<p class="mb-1"><a href="#" class="text-3 link-hover-style-1">Mobile & Retina Optimized</a></p>
									-->
								</div>
							</div>
							<div class="row footer-top-light-border mt-4 pt-4">
								<div class="col-lg-5 text-center text-md-left">
									<p class="text-2 mt-1">© Copyright <?php echo date("Y", time()); ?>. All Rights Reserved. UK Registered Company No 12182038. VAT Number GB 333 2139 35</p>
								</div>
								<!--
									<div class="col-lg-3 text-center text-md-left">
										<p class="text-3 mb-0 font-weight-semibold text-color-light opacity-8">BUSINESS HOURS</p>
										<p class="text-3 mb-0">Mon - Sat 9:00AM -5:00PM</p>
									</div>
								-->
								<div class="col-lg-4 text-center text-md-left">
									<img src="img/visa-and-mastercard-logo-26.png" alt="Payment icons" height="50">
								</div>
							</div>
						</div>
					</div>
				</div>
			</footer>
		</div>

		<!-- Vendor -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/jquery.appear/jquery.appear.min.js"></script>
		<script src="vendor/jquery.easing/jquery.easing.min.js"></script>
		<script src="vendor/jquery.cookie/jquery.cookie.min.js"></script>
		<script src="vendor/popper/umd/popper.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/common/common.min.js"></script>
		<script src="vendor/jquery.validation/jquery.validate.min.js"></script>
		<script src="vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
		<script src="vendor/jquery.gmap/jquery.gmap.min.js"></script>
		<script src="vendor/jquery.lazyload/jquery.lazyload.min.js"></script>
		<script src="vendor/isotope/jquery.isotope.min.js"></script>
		<script src="vendor/owl.carousel/owl.carousel.min.js"></script>
		<script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="vendor/vide/jquery.vide.min.js"></script>
		<script src="vendor/vivus/vivus.min.js"></script>
		<script src="vendor/bootstrap-star-rating/js/star-rating.min.js"></script>
		<script src="vendor/bootstrap-star-rating/themes/krajee-fas/theme.min.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="js/theme.js"></script>

		<!-- Current Page Vendor and Views -->
		<script src="js/views/view.shop.js"></script>
		
		<!-- Theme Custom -->
		<script src="js/custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="js/theme.init.js"></script>

		<!-- Google Analytics: Change UA-XXXXX-X to be your site's ID. Go to https://www.google.com/analytics/ for more information.
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
			ga('create', 'UA-12345678-1', 'auto');
			ga('send', 'pageview');
		</script>
		-->

		<!-- Basic age verification -->
		<script src="https://cdn.jsdelivr.net/jquery.cookie/1.4.1/jquery.cookie.min.js"></script>
    	<script src="js/age-verification.js"></script>

    	<script>
    		function jump_to_product(selectObject) {
			    var product_id = selectObject.value; 
			    window.location.href = "?c=product&id="+product_id;
			}

			function set_shipping(selectObject) {
			    var shipping_id = selectObject.value; 
			    window.location.href = "actions.php?a=set_shipping&shipping_id="+shipping_id;
			}
		</script>

		<script src="jquery.bs.gdpr.cookies.js"></script>
	    <script type="text/javascript">
	        var settings = {
	            message: 'This site uses cookies to provide you with a great user experience. By using this site you accept our use of cookies.',
	            moreLinkLabel: '',
	            messageMaxHeightPercent: 30,
	            delay: 1000,
	            OnAccept : function() {
	                console.log('User accepted cookies');
	            }
	        }

	        $(document).ready(function() {
	            $('body').bsgdprcookies(settings);

	            $('#cookiesBtn').on('click', function(){
	                $('body').bsgdprcookies(settings, 'reinit');
	            });
	        });
	    </script>

	    <?php if(!empty($_SESSION['alert']['status'])){ ?>
	    	<script>
				document.getElementById('status_message').innerHTML = '<div class="container"><div class="row"><div class="col-md-12"><div class="alert alert-<?php echo $_SESSION['alert']['status']; ?>" role="alert"><?php echo $_SESSION['alert']['message']; ?></div></div></div></div>';
				setTimeout(function() {
					$('#status_message').fadeOut('fast');
				}, 10000);
	        </script>
	        <?php unset($_SESSION['alert']); ?>
	    <?php } ?>
	</body>
</html>
