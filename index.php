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
$query 								= $conn->query("SELECT * FROM `shop_products` WHERE `category_id` = '1' ORDER BY `title` + 0 ");
$all_products 						= $query->fetchAll(PDO::FETCH_ASSOC);

// get products
$query 								= $conn->query("SELECT * FROM `whmcs`.`tblproductgroups` ORDER BY `name` ");
$all_categories 					= $query->fetchAll(PDO::FETCH_ASSOC);

// set some defaults
$query 								= $conn->query("SELECT * FROM `shop_carts` WHERE `key` = '".$_SESSION['cart_key']."' ");
$cart_items 						= $query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	

		<title><?php echo $site['title']; ?></title>	

		<meta name="keywords" content="<?php echo $site['title']; ?>" />
		<meta name="description" content="<?php echo $site['title']; ?> e-Cig vape store and supplies.">
		<meta name="author" content="<?php echo $site['url']; ?>">

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
				<div class="header-body border-color-primary border-bottom-0 box-shadow-none" data-sticky-header-style="{'minResolution': 0}" data-sticky-header-style-active="{'background-color': '#f7f7f7'}" data-sticky-header-style-deactive="{'background-color': '#FFF'}">
					<div class="header-top header-top-borders">
						<div class="container h-100">
							<div class="header-row h-100">
								<div class="header-column justify-content-start">
									<div class="header-row">
										<nav class="header-nav-top">
											<ul class="nav nav-pills">
												<li class="nav-item nav-item-borders py-2">
													<span class="pl-0"><i class="far fa-dot-circle text-4 text-color-primary" style="top: 1px;"></i> 1 Blah Street, City, County, A1 2BC</span>
												</li>
												<li class="nav-item nav-item-borders py-2 d-none d-lg-inline-flex">
													<a href="tel:123-456-7890"><i class="fab fa-whatsapp text-4 text-color-primary" style="top: 0;"></i> 0800 123 4567</a>
												</li>
												<li class="nav-item nav-item-borders py-2 d-none d-sm-inline-flex">
													<a href="mailto:mail@domain.com"><i class="far fa-envelope text-4 text-color-primary" style="top: 1px;"></i> sales@ublo.club</a>
												</li>
											</ul>
										</nav>
									</div>
								</div>
								<div class="header-column justify-content-end">
									<div class="header-row">
										<nav class="header-nav-top">
											<ul class="nav nav-pills">
												<li class="nav-item nav-item-anim-icon d-none d-md-block">
													<a class="nav-link pl-0" href="?c=about_us"><i class="fas fa-angle-right"></i> About Us</a>
												</li>
												<li class="nav-item nav-item-anim-icon d-none d-md-block">
													<a class="nav-link" href="?c=contact_us"><i class="fas fa-angle-right"></i> Contact Us</a>
												</li>
												<!--
													<li class="nav-item dropdown nav-item-left-border d-none d-sm-block">
														<a class="nav-link" href="#" role="button" id="dropdownLanguage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<img src="img/blank.gif" class="flag flag-us" alt="English" /> English
															<i class="fas fa-angle-down"></i>
														</a>
														<div class="dropdown-menu" aria-labelledby="dropdownLanguage">
															<a class="dropdown-item" href="#"><img src="img/blank.gif" class="flag flag-us" alt="English" /> English</a>
															<a class="dropdown-item" href="#"><img src="img/blank.gif" class="flag flag-es" alt="English" /> Español</a>
															<a class="dropdown-item" href="#"><img src="img/blank.gif" class="flag flag-fr" alt="English" /> Française</a>
														</div>
													</li>
												-->
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
														<a class="btn btn-danger" href="actions.php?a=empty_cart">Empty Cart</a>
														<a class="btn btn-primary" href="?c=cart">View Cart</a>
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

						$query 					= $conn->query("SELECT `id`,`title` FROM `shop_products` WHERE `id` = '".$linked_product_raw['secondary']."' ");
						$linked_product_data 	= $query->fetch(PDO::FETCH_ASSOC);
						$linked_products[$count]['title']			= stripslashes($linked_product_data['title']);

						$count++;
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
												<li class="nav-item"><a class="nav-link py-3 px-4" href="#productInfo" data-toggle="tab">Additional Information</a></li>
												<li class="nav-item"><a class="nav-link py-3 px-4" href="#productReviews" data-toggle="tab">Reviews (2)</a></li>
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
				<?php global $conn, $globals, $global_settings, $site, $all_products, $all_categories; ?>
				
				<div role="main" class="main shop py-4">
					<div class="container">
						<div class="row">
							<div class="col-lg-9">
								<form action="actions.php?a=checkout" id="frmBillingAddress" method="post">

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
																</tr>
															</thead>
															<tbody>
																
																<tr class="cart_table_item">
																	<td class="product-name">
																		<strong>Business Builder Kit</strong>
																	</td>
																	<td class="product-price">
																		<span class="amount">£40.00</span>
																	</td>
																	<td class="product-quantity">
																		1
																	</td>
																	<td class="product-subtotal">
																		<span class="amount">£40.00</span>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>

													<div class="form-row">
														<div class="form-group col-lg-6">
															<label class="font-weight-bold text-dark text-2">First Name</label>
															<input type="text" id="first_name" name="first_name" class="form-control" required="">
														</div>
														<div class="form-group col-lg-6">
															<label class="font-weight-bold text-dark text-2">Last Name</label>
															<input type="text" id="last_name" name="last_name" class="form-control" required="">
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col">
															<label class="font-weight-bold text-dark text-2">Company Name <small>(optional)</small></label>
															<input type="text" id="company_name" name="company_name" class="form-control">
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col">
															<label class="font-weight-bold text-dark text-2">Address 1</label>
															<input type="text" id="address_1" name="address_1" class="form-control" required="">
														</div>
													</div>
													<!--
													<div class="form-row">
														<div class="form-group col">
															<label class="font-weight-bold text-dark text-2">Address 2 <small>(optional)</small></label>
															<input type="text" id="address_2" name="address_2" class="form-control">
														</div>
													</div>
													-->
													<div class="form-row">
														<div class="form-group col">
															<label class="font-weight-bold text-dark text-2">City </label>
															<input type="text" id="address_city" name="address_city" class="form-control" required="">
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col">
															<label class="font-weight-bold text-dark text-2">County / State </label>
															<input type="text" id="address_state" name="address_state" class="form-control" required="">
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col">
															<label class="font-weight-bold text-dark text-2">Country</label>
															<select id="address_country" name="address_country" class="form-control">
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
																<option value="GB" selected>United Kingdom</option>
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
															</select>
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col">
															<label class="font-weight-bold text-dark text-2">Zip / Postal Code </label>
															<input type="text" id="address_zip" name="address_zip" class="form-control" required="">
														</div>
													</div>
													<div class="form-row">
														<div class="form-group col">
															<label class="font-weight-bold text-dark text-2">Email Address </label>
															<input type="text" id="email" name="email" class="form-control" required="">
														</div>
													</div>
													<!--
													<div class="form-row">
														<div class="form-group col">
															<label class="font-weight-bold text-dark text-2">Tel </label>
															<input type="text" id="tel" name="tel" class="form-control" placeholder="+44 7399 973949" required="">
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
															<input type="submit" value="Next" class="btn btn-primary btn-modern text-uppercase mt-5 mb-5 mb-lg-0 float-right mb-2" data-loading-text="Loading...">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>
								
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
												<strong class="text-dark"><span class="amount">£<?php echo number_format(123.00, 2); ?></span></strong>
											</td>
										</tr>
										<tr class="shipping">
											<th>
												Shipping
											</th>
											<td>
												Free Shipping<input type="hidden" value="free_shipping" id="shipping_method" name="shipping_method">
											</td>
										</tr>
										<tr class="total">
											<th>
												<strong class="text-dark">Order Total</strong>
											</th>
											<td>
												<strong class="text-dark"><span class="amount">£<?php echo number_format($order_total, 2); ?></span></strong>
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
				?>

				<div role="main" class="main">
					<div class="container py-4">
						<div class="row">
							<div class="col">
								<div class="toggle toggle-primary" data-plugin-toggle>
									<section class="toggle active">
										<label>Is vape legal in the UK?</label>
										<p>
											Vape is perfectly legal in the UK.
										</p>
									</section>

									<section class="toggle">
										<label>Is is safe to vape?</label>
										<p>
											On this matter, we can only speak for our own brand, Ublo.

											Yes, all our product is tested, certified and made in the UK. The product is organically sourced and bottled here in the UK, unlike some other cheaper products available on the market.
										</p>
									</section>

									<section class="toggle">
										<label>Do I need a special E-Cig?</label>
										<p>
											You do not need a special E-Cig, you simply need a medium to high wattage E-Cig to get the best experience.
										</p>
									</section>

									<section class="toggle">
										<label>How much should I use?</label>
										<p>
											We recommended initially using the product in small doses until you feel comfortable with the dosage that you are using.
										</p>
									</section>

									<section class="toggle">
										<label>I have some doubts.</label>
										<p>
											If you are unsure about anything please feel free to contact us on sales@ublo.club
										</p>
									</section>

									<section class="toggle">
										<label>Curabitur eget leo at velit imperdiet varius iaculis vitaes?</label>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget leo at velit imperdiet varius. In eu ipsum vitae velit congue iaculis vitae at risus. Nullam tortor nunc, bibendum vitae semper a, volutpat eget massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer fringilla, orci sit amet posuere auctor, orci eros pellentesque odio, nec pellentesque erat ligula nec massa. Aenean consequat lorem ut felis ullamcorper posuere gravida tellus faucibus. Maecenas dolor elit, pulvinar eu vehicula eu, consequat et lacus. Duis et purus ipsum. In auctor mattis ipsum id molestie. Donec risus nulla, fringilla a rhoncus vitae, semper a massa. Vivamus ullamcorper, enim sit amet consequat laoreet, tortor tortor dictum urna, ut egestas urna ipsum nec libero. Nulla justo leo, molestie vel tempor nec, egestas at massa. Aenean pulvinar, felis porttitor iaculis pulvinar, odio orci sodales odio, ac pulvinar felis quam sit.</p>
									</section>

									<section class="toggle">
										<label>Curabitur eget leo at velit imperdiet vague iaculis vitaes?</label>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget leo at velit imperdiet varius. In eu ipsum vitae velit congue iaculis vitae at risus. Nullam tortor nunc, bibendum vitae semper a, volutpat eget massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer fringilla, orci sit amet posuere auctor, orci eros pellentesque odio, nec pellentesque erat ligula nec massa. Aenean consequat lorem ut felis ullamcorper posuere gravida tellus faucibus. Maecenas dolor elit, pulvinar eu vehicula eu, consequat et lacus. Duis et purus ipsum. In auctor mattis ipsum id molestie. Donec risus nulla, fringilla a rhoncus vitae, semper a massa. Vivamus ullamcorper, enim sit amet consequat laoreet, tortor tortor dictum urna, ut egestas urna ipsum nec libero. Nulla justo leo, molestie vel tempor nec, egestas at massa. Aenean pulvinar, felis porttitor iaculis pulvinar, odio orci sodales odio, ac pulvinar felis quam sit.</p>
									</section>

									<section class="toggle">
										<label>Curabitur eget leo at velit imperdiet viaculis vitaes?</label>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget leo at velit imperdiet varius. In eu ipsum vitae velit congue iaculis vitae at risus. Nullam tortor nunc, bibendum vitae semper a, volutpat eget massa.</p>
									</section>

									<section class="toggle">
										<label>Curabitur eget leo at velit imperdiet varius iaculis vitaes?</label>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget leo at velit imperdiet varius. In eu ipsum vitae velit congue iaculis vitae at risus. Nullam tortor nunc, bibendum vitae semper a, volutpat eget massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer fringilla, orci sit amet posuere auctor, orci eros pellentesque odio, nec pellentesque erat ligula nec massa. Aenean consequat lorem ut felis ullamcorper posuere gravida tellus faucibus. Maecenas dolor elit, pulvinar eu vehicula eu, consequat et lacus. Duis et purus ipsum. In auctor mattis ipsum id molestie. Donec risus nulla, fringilla a rhoncus vitae, semper a massa. Vivamus ullamcorper, enim sit amet consequat laoreet, tortor tortor dictum urna, ut egestas urna ipsum nec libero. Nulla justo leo, molestie vel tempor nec, egestas at massa. Aenean pulvinar, felis porttitor iaculis pulvinar, odio orci sodales odio, ac pulvinar felis quam sit.</p>
									</section>
								</div>
							</div>
						</div>
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
				<div class="container my-4 py-2">
					<div class="row py-4">
						<div class="col-lg-4 text-center text-lg-left">
							<h5 class="text-4 text-color-light mb-3">SUBSCRIBE NEWSLETTER</h5>
							<p class="text-3 mb-0">Get all the latest informaton on Events, Sales and Offfers.</p>
							<p class="text-3 mb-0">Sign up for newsletter today.</p>
						</div>
						<div class="col-lg-5 text-center text-lg-left px-4 mt-1 mt-lg-3">
							<div class="pt-1 pt-lg-3 mt-1">
								<div class="alert alert-success d-none" id="newsletterSuccess">
									<strong>Success!</strong> You've been added to our email list.
								</div>
								<div class="alert alert-danger d-none" id="newsletterError"></div>
								<form id="newsletterForm" action="php/newsletter-subscribe.php" method="POST" class="mw-100">
									<div class="input-group input-group-rounded">
										<input class="form-control form-control-sm bg-light px-4 text-3" placeholder="Email Address..." name="newsletterEmail" id="newsletterEmail" type="text">
										<span class="input-group-append">
											<button class="btn btn-primary  text-color-light text-2 py-3 px-4" type="submit"><strong>SUBSCRIBE!</strong></button>
										</span>
									</div>
								</form>
							</div>
						</div>
						<div class="col-lg-3 text-center text-lg-left">
							<div class="pt-3 mt-1">
								<ul class="footer-social-icons social-icons social-icons-clean social-icons-big social-icons-opacity-light social-icons-icon-light mt-0 mt-lg-3">
									<li class="social-icons-facebook"><a href="https://www.facebook.com/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
									<li class="social-icons-twitter"><a href="https://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
									<li class="social-icons-linkedin"><a href="https://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fab fa-linkedin-in"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="container mt-4 pt-2 pb-5 footer-top-light-border">
					<div class="row py-4">
						<div class="col-md-3 text-center text-md-left">
							<h5 class="text-4 text-color-light mb-3 mt-4 mt-lg-0">CONTACT INFO</h5>
							<p class="text-3 mb-0 text-color-light opacity-7">ADDRESS</p>
							<p class="text-3 mb-3">123 Street name, City, USA.</p>
							<p class="text-3 mb-0 text-color-light opacity-7">PHONE</p>
							<p class="text-3 mb-3">Toll Free (123) 456-7890</p>
							<p class="text-3 mb-0 text-color-light opacity-7">EMAIL</p>
							<p class="text-3 mb-0"><a href="mailto:info@porto.com" class="">mail@example.com</a></p>
						</div>
						<div class="col-md-9 text-center text-md-left">
							<div class="row">
								<div class="col-md-7 col-lg-5 mb-0">
									<h5 class="text-4 text-color-light mb-3 mt-4 mt-lg-0">MY ACCOUNT</h5>
									<div class="row">
										<div class="col-md-5">
											<p class="mb-1"><a href="#" class="text-3 link-hover-style-1">About us</a></p>
											<p class="mb-1"><a href="#" class="text-3 link-hover-style-1">Contact Us</a></p>
											<p class="mb-1"><a href="#" class="text-3 link-hover-style-1">My account</a></p>
										</div>
										<div class="col-md-5">
											<p class="mb-1"><a href="#" class="text-3 link-hover-style-1">Orders history</a></p>
											<p class="mb-1"><a href="#" class="text-3 link-hover-style-1">Advanced search</a></p>
											<p class="mb-1"><a href="#" class="text-3 link-hover-style-1">Login</a></p>
										</div>
									</div>
								</div>
								<div class="col-md-5 col-lg-4">
									<h5 class="text-4 text-color-light mb-3 mt-4 mt-lg-0">MAIN FEATURES</h5>
									<p class="mb-1"><a href="#" class="text-3 link-hover-style-1">Super Fast Theme</a></p>
									<p class="mb-1"><a href="#" class="text-3 link-hover-style-1">SEO Optmized</a></p>
									<p class="mb-1"><a href="#" class="text-3 link-hover-style-1">RTL Support</a></p>
								</div>
								<div class="col-lg-3">
									<p class="mb-1 mt-lg-3 pt-lg-3"><a href="" class="text-3">Powerful Admin Panel</a></p>
									<p class="mb-1"><a href="#" class="text-3 link-hover-style-1">Mobile & Retina Optimized</a></p>
								</div>
							</div>
							<div class="row footer-top-light-border mt-4 pt-4">
								<div class="col-lg-5 text-center text-md-left">
									<p class="text-2 mt-1">© Copyright <?php echo date("Y", time()); ?>. All Rights Reserved.</p>
								</div>
								<div class="col-lg-3 text-center text-md-left">
									<p class="text-3 mb-0 font-weight-semibold text-color-light opacity-8">BUSINESS HOURS</p>
									<p class="text-3 mb-0">Mon - Sun /9:00AM -8:00PM</p>
								</div>
								<div class="col-lg-4 text-center text-md-left">
									<img src="img/payment-icon.png" alt="Payment icons" class="img-fluid mt-4 mt-lg-2">
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
		</script>
	</body>
</html>
