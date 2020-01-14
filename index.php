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
if(!isset($_SESSION['cart_total'])){
	$_SESSION['cart_total'] 		= 0;
}
if(!isset($_SESSION['cart'])){
	$_SESSION['cart'] 				= array();
}

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
														if(!empty($_SESSION['cart'])){
															$cart_total = count($_SESSION['cart']);

															echo '<span class="cart-qty">'.$cart_total.'</span>';
														}
													?>
												</span>
											</a>
											<div class="header-nav-features-dropdown" id="headerTopCartDropdown">
												<?php if(!empty($_SESSION['cart'])){ ?>
													<ol class="mini-products-list">
														<?php foreach($_SESSION['cart'] as $cart_item){ ?>
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
														<!-- <a class="btn btn-red" href="actions.php?a=empty_cart">Empty Cart</a> -->
														<a class="btn btn-dark" href="#">View Cart</a>
														<a class="btn btn-primary" href="#">Checkout</a>
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
					<!-- top menu bar -->
					<!-- 
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
																<a class="dropdown-item dropdown-toggle" href="index.html">
																	Home
																</a>
																<ul class="dropdown-menu">
																	<li>
																		<a class="dropdown-item" href="index.html">
																			Landing Page
																		</a>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Classic</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="index-classic.html" data-thumb-preview="img/previews/preview-classic.jpg">Classic - Original</a></li>
																			<li><a class="dropdown-item" href="index-classic-color.html" data-thumb-preview="img/previews/preview-classic-color.jpg">Classic - Color</a></li>
																			<li><a class="dropdown-item" href="index-classic-light.html" data-thumb-preview="img/previews/preview-classic-light.jpg">Classic - Light</a></li>
																			<li><a class="dropdown-item" href="index-classic-video.html" data-thumb-preview="img/previews/preview-classic-video.jpg">Classic - Video</a></li>
																			<li><a class="dropdown-item" href="index-classic-video-light.html" data-thumb-preview="img/previews/preview-classic-video-light.jpg">Classic - Video - Light</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Corporate <span class="tip tip-dark">hot</span></a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="index-corporate.html" data-thumb-preview="img/previews/preview-corporate.jpg">Corporate - Version 1</a></li>
																			<li><a class="dropdown-item" href="index-corporate-2.html" data-thumb-preview="img/previews/preview-corporate-2.jpg">Corporate - Version 2</a></li>
																			<li><a class="dropdown-item" href="index-corporate-3.html" data-thumb-preview="img/previews/preview-corporate-3.jpg">Corporate - Version 3</a></li>
																			<li><a class="dropdown-item" href="index-corporate-4.html" data-thumb-preview="img/previews/preview-corporate-4.jpg">Corporate - Version 4</a></li>
																			<li><a class="dropdown-item" href="index-corporate-5.html" data-thumb-preview="img/previews/preview-corporate-5.jpg">Corporate - Version 5</a></li>
																			<li><a class="dropdown-item" href="index-corporate-6.html" data-thumb-preview="img/previews/preview-corporate-6.jpg">Corporate - Version 6</a></li>
																			<li><a class="dropdown-item" href="index-corporate-7.html" data-thumb-preview="img/previews/preview-corporate-7.jpg">Corporate - Version 7</a></li>
																			<li><a class="dropdown-item" href="index-corporate-8.html" data-thumb-preview="img/previews/preview-corporate-8.jpg">Corporate - Version 8</a></li>
																			<li><a class="dropdown-item" href="index-corporate-9.html" data-thumb-preview="img/previews/preview-corporate-9.jpg">Corporate - Version 9</a></li>
																			<li><a class="dropdown-item" href="index-corporate-10.html" data-thumb-preview="img/previews/preview-corporate-10.jpg">Corporate - Version 10</a></li>
																			<li><a class="dropdown-item" href="index-corporate-11.html" data-thumb-preview="img/previews/preview-corporate-11.jpg">Corporate - Version 11</a></li>
																			<li><a class="dropdown-item" href="index-corporate-12.html" data-thumb-preview="img/previews/preview-corporate-12.jpg">Corporate - Version 12</a></li>
																			<li><a class="dropdown-item" href="index-corporate-13.html" data-thumb-preview="img/previews/preview-corporate-13.jpg">Corporate - Version 13</a></li>
																			<li><a class="dropdown-item" href="index-corporate-14.html" data-thumb-preview="img/previews/preview-corporate-14.jpg">Corporate - Version 14</a></li>
																			<li><a class="dropdown-item" href="index-corporate-15.html" data-thumb-preview="img/previews/preview-corporate-15.jpg">Corporate - Version 15</a></li>
																			<li><a class="dropdown-item" href="index-corporate-16.html" data-thumb-preview="img/previews/preview-corporate-16.jpg">Corporate - Version 16</a></li>
																			<li><a class="dropdown-item" href="index-corporate-17.html" data-thumb-preview="img/previews/preview-corporate-17.jpg">Corporate - Version 17</a></li>
																			<li><a class="dropdown-item" href="index-corporate-18.html" data-thumb-preview="img/previews/preview-corporate-18.jpg">Corporate - Version 18</a></li>
																			<li><a class="dropdown-item" href="index-corporate-19.html" data-thumb-preview="img/previews/preview-corporate-19.jpg">Corporate - Version 19</a></li>
																			<li><a class="dropdown-item" href="index-corporate-20.html" data-thumb-preview="img/previews/preview-corporate-20.jpg">Corporate - Version 20</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Portfolio</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="index-portfolio.html" data-thumb-preview="img/previews/preview-portfolio.jpg">Portfolio - Version 1</a></li>
																			<li><a class="dropdown-item" href="index-portfolio-2.html" data-thumb-preview="img/previews/preview-portfolio-2.jpg">Portfolio - Version 2</a></li>
																			<li><a class="dropdown-item" href="index-portfolio-3.html" data-thumb-preview="img/previews/preview-portfolio-3.jpg">Portfolio - Version 3</a></li>
																			<li><a class="dropdown-item" href="index-portfolio-4.html" data-thumb-preview="img/previews/preview-portfolio-4.jpg">Portfolio - Version 4</a></li>
																			<li><a class="dropdown-item" href="index-portfolio-5.html" data-thumb-preview="img/previews/preview-portfolio-5.jpg">Portfolio - Version 5</a></li>
																		</ul>
																	</li>		
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Blog</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="index-blog.html" data-thumb-preview="img/previews/preview-blog.jpg">Blog - Version 1</a></li>
																			<li><a class="dropdown-item" href="index-blog-2.html" data-thumb-preview="img/previews/preview-blog-2.jpg">Blog - Version 2</a></li>
																			<li><a class="dropdown-item" href="index-blog-3.html" data-thumb-preview="img/previews/preview-blog-3.jpg">Blog - Version 3</a></li>
																			<li><a class="dropdown-item" href="index-blog-4.html" data-thumb-preview="img/previews/preview-blog-4.jpg">Blog - Version 4</a></li>
																			<li><a class="dropdown-item" href="index-blog-5.html" data-thumb-preview="img/previews/preview-blog-5.jpg">Blog - Version 5</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">One Page</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="index-one-page.html" data-thumb-preview="img/previews/preview-one-page.jpg">One Page Original</a></li>
																		</ul>
																	</li>
																</ul>
															</li>
															<li class="dropdown dropdown-mega">
																<a class="dropdown-item dropdown-toggle" href="elements.html">
																	Elements
																</a>
																<ul class="dropdown-menu">
																	<li>
																		<div class="dropdown-mega-content">
																			<div class="row">
																				<div class="col-lg-3">
																					<span class="dropdown-mega-sub-title">Elements 1</span>
																					<ul class="dropdown-mega-sub-nav">
																						<li><a class="dropdown-item" href="elements-accordions.html">Accordions</a></li>
																						<li><a class="dropdown-item" href="elements-toggles.html">Toggles</a></li>
																						<li><a class="dropdown-item" href="elements-tabs.html">Tabs</a></li>
																						<li><a class="dropdown-item" href="elements-icons.html">Icons</a></li>
																						<li><a class="dropdown-item" href="elements-icon-boxes.html">Icon Boxes</a></li>
																						<li><a class="dropdown-item" href="elements-carousels.html">Carousels</a></li>
																						<li><a class="dropdown-item" href="elements-modals.html">Modals</a></li>
																						<li><a class="dropdown-item" href="elements-lightboxes.html">Lightboxes</a></li>
																						<li><a class="dropdown-item" href="elements-word-rotator.html">Word Rotator</a></li>
																						<li><a class="dropdown-item" href="elements-before-after.html">Before / After</a></li>
																						<li><a class="dropdown-item" href="elements-360-image-viewer.html">360º Image Viewer</a></li>
																					</ul>
																				</div>
																				<div class="col-lg-3">
																					<span class="dropdown-mega-sub-title">Elements 2</span>
																					<ul class="dropdown-mega-sub-nav">
																						<li><a class="dropdown-item" href="elements-buttons.html">Buttons</a></li>
																						<li><a class="dropdown-item" href="elements-badges.html">Badges</a></li>
																						<li><a class="dropdown-item" href="elements-lists.html">Lists</a></li>
																						<li><a class="dropdown-item" href="elements-cards.html">Cards</a></li>
																						<li><a class="dropdown-item" href="elements-image-gallery.html">Image Gallery</a></li>
																						<li><a class="dropdown-item" href="elements-image-frames.html">Image Frames</a></li>
																						<li><a class="dropdown-item" href="elements-image-hotspots.html">Image Hotspots</a></li>
																						<li><a class="dropdown-item" href="elements-testimonials.html">Testimonials</a></li>
																						<li><a class="dropdown-item" href="elements-blockquotes.html">Blockquotes</a></li>							
																						<li><a class="dropdown-item" href="elements-sticky-elements.html">Sticky Elements</a></li>
																					</ul>
																				</div>
																				<div class="col-lg-3">
																					<span class="dropdown-mega-sub-title">Elements 3</span>
																					<ul class="dropdown-mega-sub-nav">
																						<li><a class="dropdown-item" href="elements-typography.html">Typography</a></li>
																						<li><a class="dropdown-item" href="elements-call-to-action.html">Call to Action</a></li>
																						<li><a class="dropdown-item" href="elements-pricing-tables.html">Pricing Tables</a></li>
																						<li><a class="dropdown-item" href="elements-tables.html">Tables</a></li>
																						<li><a class="dropdown-item" href="elements-progressbars.html">Progress Bars</a></li>
																						<li><a class="dropdown-item" href="elements-process.html">Process</a></li>
																						<li><a class="dropdown-item" href="elements-counters.html">Counters</a></li>
																						<li><a class="dropdown-item" href="elements-countdowns.html">Countdowns</a></li>
																						<li><a class="dropdown-item" href="elements-sections-parallax.html">Sections &amp; Parallax</a></li>
																						<li><a class="dropdown-item" href="elements-tooltips-popovers.html">Tooltips &amp; Popovers</a></li>							
																					</ul>
																				</div>
																				<div class="col-lg-3">
																					<span class="dropdown-mega-sub-title">Elements 4</span>
																					<ul class="dropdown-mega-sub-nav">
																						<li><a class="dropdown-item" href="elements-headings.html">Headings</a></li>
																						<li><a class="dropdown-item" href="elements-dividers.html">Dividers</a></li>
																						<li><a class="dropdown-item" href="elements-animations.html">Animations</a></li>
																						<li><a class="dropdown-item" href="elements-medias.html">Medias</a></li>
																						<li><a class="dropdown-item" href="elements-maps.html">Maps</a></li>
																						<li><a class="dropdown-item" href="elements-arrows.html">Arrows</a></li>
																						<li><a class="dropdown-item" href="elements-star-ratings.html">Star Ratings</a></li>
																						<li><a class="dropdown-item" href="elements-alerts.html">Alerts</a></li>
																						<li><a class="dropdown-item" href="elements-posts.html">Posts</a></li>
																						<li><a class="dropdown-item" href="elements-forms-basic-contact.html">Forms</a></li>
																					</ul>
																				</div>
																			</div>
																		</div>
																	</li>
																</ul>
															</li>
															<li class="dropdown">
																<a class="dropdown-item dropdown-toggle" href="#">
																	Features
																</a>
																<ul class="dropdown-menu">
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Headers</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-headers-overview.html">Overview</a></li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Classic</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-headers-classic.html">Classic</a></li>
																					<li><a class="dropdown-item" href="feature-headers-classic-language-dropdown.html">Classic + Language Dropdown</a></li>
																					<li><a class="dropdown-item" href="feature-headers-classic-big-logo.html">Classic + Big Logo</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Flat</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-headers-flat.html">Flat</a></li>
																					<li><a class="dropdown-item" href="feature-headers-flat-top-bar.html">Flat + Top Bar</a></li>
																					<li><a class="dropdown-item" href="feature-headers-flat-top-bar-top-borders.html">Flat + Top Bar + Top Border</a></li>
																					<li><a class="dropdown-item" href="feature-headers-flat-colored-top-bar.html">Flat + Colored Top Bar</a></li>
																					<li><a class="dropdown-item" href="feature-headers-flat-borders.html">Flat + Borders</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Center</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-headers-center.html">Center</a></li>
																					<li><a class="dropdown-item" href="feature-headers-center-double-navs.html">Center + Double Navs</a></li>
																					<li><a class="dropdown-item" href="feature-headers-center-nav-buttons.html">Center + Nav + Buttons</a></li>
																					<li><a class="dropdown-item" href="feature-headers-center-below-slider.html">Center Below Slider</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Floating</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-headers-floating-bar.html">Floating Bar</a></li>
																					<li><a class="dropdown-item" href="feature-headers-floating-icons.html">Floating Icons</a></li>
																				</ul>
																			</li>
																			<li><a class="dropdown-item" href="feature-headers-below-slider.html">Below Slider</a></li>
																			<li><a class="dropdown-item" href="feature-headers-full-video.html">Full Video</a></li>
																			<li><a class="dropdown-item" href="feature-headers-narrow.html">Narrow</a></li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Sticky</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-headers-sticky-shrink.html">Sticky Shrink</a></li>
																					<li><a class="dropdown-item" href="feature-headers-sticky-static.html">Sticky Static</a></li>
																					<li><a class="dropdown-item" href="feature-headers-sticky-change-logo.html">Sticky Change Logo</a></li>
																					<li><a class="dropdown-item" href="feature-headers-sticky-reveal.html">Sticky Reveal</a></li>
																				</ul>
																			</li>				
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Transparent</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-headers-transparent-light.html">Transparent Light</a></li>
																					<li><a class="dropdown-item" href="feature-headers-transparent-dark.html">Transparent Dark</a></li>
																					<li><a class="dropdown-item" href="feature-headers-transparent-light-bottom-border.html">Transparent Light + Bottom Border</a></li>
																					<li><a class="dropdown-item" href="feature-headers-transparent-dark-bottom-border.html">Transparent Dark + Bottom Border</a></li>
																					<li><a class="dropdown-item" href="feature-headers-transparent-bottom-slider.html">Transparent Bottom Slider</a></li>
																					<li><a class="dropdown-item" href="feature-headers-semi-transparent-light.html">Semi Transparent Light</a></li>
																					<li><a class="dropdown-item" href="feature-headers-semi-transparent-dark.html">Semi Transparent Dark</a></li>
																					<li><a class="dropdown-item" href="feature-headers-semi-transparent-bottom-slider.html">Semi Transparent Bottom Slider</a></li>
																					<li><a class="dropdown-item" href="feature-headers-semi-transparent-top-bar-borders.html">Semi Transparent + Top Bar + Borders</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Full Width</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-headers-full-width.html">Full Width</a></li>
																					<li><a class="dropdown-item" href="feature-headers-full-width-borders.html">Full Width + Borders</a></li>
																					<li><a class="dropdown-item" href="feature-headers-full-width-transparent-light.html">Full Width Transparent Light</a></li>
																					<li><a class="dropdown-item" href="feature-headers-full-width-transparent-dark.html">Full Width Transparent Dark</a></li>
																					<li><a class="dropdown-item" href="feature-headers-full-width-semi-transparent-light.html">Full Width Semi Transparent Light</a></li>
																					<li><a class="dropdown-item" href="feature-headers-full-width-semi-transparent-dark.html">Full Width Semi Transparent Dark</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Navbar</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-headers-navbar.html">Navbar</a></li>
																					<li><a class="dropdown-item" href="feature-headers-navbar-full.html">Navbar Full</a></li>
																					<li><a class="dropdown-item" href="feature-headers-navbar-pills.html">Navbar Pills</a></li>
																					<li><a class="dropdown-item" href="feature-headers-navbar-divisors.html">Navbar Divisors</a></li>
																					<li><a class="dropdown-item" href="feature-headers-navbar-icons-search.html">Nav Bar + Icons + Search</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Side Header</a>
																				<ul class="dropdown-menu">
																					<li class="dropdown-submenu">
																						<a class="dropdown-item" href="#">Side Header Left</a>
																						<ul class="dropdown-menu">
																							<li><a class="dropdown-item" href="feature-headers-side-header-left-dropdown.html">Dropdown</a></li>
																							<li><a class="dropdown-item" href="feature-headers-side-header-left-expand.html">Expand</a></li>
																							<li><a class="dropdown-item" href="feature-headers-side-header-left-columns.html">Columns</a></li>
																							<li><a class="dropdown-item" href="feature-headers-side-header-left-slide.html">Slide</a></li>
																							<li><a class="dropdown-item" href="feature-headers-side-header-left-semi-transparent.html">Semi Transparent</a></li>
																							<li><a class="dropdown-item" href="feature-headers-side-header-left-dark.html">Dark</a></li>
																						</ul>
																					</li>
																					<li class="dropdown-submenu">
																						<a class="dropdown-item" href="#">Side Header Right</a>
																						<ul class="dropdown-menu">
																							<li><a class="dropdown-item" href="feature-headers-side-header-right-dropdown.html">Dropdown</a></li>
																							<li><a class="dropdown-item" href="feature-headers-side-header-right-expand.html">Expand</a></li>
																							<li><a class="dropdown-item" href="feature-headers-side-header-right-columns.html">Columns</a></li>
																							<li><a class="dropdown-item" href="feature-headers-side-header-right-slide.html">Slide</a></li>
																							<li><a class="dropdown-item" href="feature-headers-side-header-right-semi-transparent.html">Semi Transparent</a></li>
																							<li><a class="dropdown-item" href="feature-headers-side-header-right-dark.html">Dark</a></li>
																						</ul>
																					</li>
																					<li class="dropdown-submenu">
																						<a class="dropdown-item" href="#">Side Header Offcanvas</a>
																						<ul class="dropdown-menu">
																							<li><a class="dropdown-item" href="feature-headers-side-header-offcanvas-push.html">Push</a></li>
																							<li><a class="dropdown-item" href="feature-headers-side-header-offcanvas-slide.html">Slide</a></li>
																						</ul>
																					</li>
																					<li><a class="dropdown-item" href="feature-headers-side-header-narrow-bar.html">Side Header Narrow Bar</a></li>
																				</ul>
																			</li>
																			<li><a class="dropdown-item" href="feature-headers-sign-in-sign-up.html">Sign In / Sign Up</a></li>
																			<li><a class="dropdown-item" href="feature-headers-logged.html">Logged</a></li>
																			<li><a class="dropdown-item" href="feature-headers-mini-cart.html">Mini Cart</a></li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Search Styles</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-headers-search-simple-input.html">Simple Input</a></li>
																					<li><a class="dropdown-item" href="feature-headers-search-simple-input-reveal.html">Simple Input Reveal</a></li>
																					<li><a class="dropdown-item" href="feature-headers-search-dropdown.html">Dropdown</a></li>
																					<li><a class="dropdown-item" href="feature-headers-search-big-input-hidden.html">Big Input Hidden</a></li>
																					<li><a class="dropdown-item" href="feature-headers-search-full-screen.html">Full Screen</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Extra</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-headers-extra-big-icon.html">Big Icon</a></li>
																					<li><a class="dropdown-item" href="feature-headers-extra-big-icons-top.html">Big Icons Top</a></li>
																					<li><a class="dropdown-item" href="feature-headers-extra-button.html">Button</a></li>
																					<li><a class="dropdown-item" href="feature-headers-extra-background-color.html">Background Color</a></li>
																				</ul>
																			</li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Navigations</a>
																		<ul class="dropdown-menu">
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Pills</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-navigations-pills.html">Pills</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-pills-arrows.html">Pills + Arrows</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-pills-dark-text.html">Pills Dark Text</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-pills-color-dropdown.html">Pills Color Dropdown</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-pills-square.html">Pills Square</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-pills-rounded.html">Pills Rounded</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Stripes</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-navigations-stripe.html">Stripe</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-stripe-dark-text.html">Stripe Dark Text</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-stripe-color-dropdown.html">Stripe Color Dropdown</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Hover Effects</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-navigations-hover-top-line.html">Top Line</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-hover-top-line-animated.html">Top Line Animated</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-hover-top-line-color-dropdown.html">Top Line Color Dropdown</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-hover-bottom-line.html">Bottom Line</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-hover-bottom-line-animated.html">Bottom Line Animated</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-hover-slide.html">Slide</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-hover-sub-title.html">Sub Title</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-hover-line-under-text.html">Line Under Text</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Vertical</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-navigations-vertical-dropdown.html">Dropdown</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-vertical-expand.html">Expand</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-vertical-columns.html">Columns</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-vertical-slide.html">Slide</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Hamburguer</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-navigations-hamburguer-sidebar.html">Sidebar</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-hamburguer-overlay.html">Overlay</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Dropdown Styles</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-navigations-dropdowns-dark.html">Dark</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-dropdowns-light.html">Light</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-dropdowns-colors.html">Colors</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-dropdowns-top-line.html">Top Line</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-dropdowns-square.html">Square</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-dropdowns-arrow.html">Arrow Dropdown</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-dropdowns-arrow-center.html">Arrow Center Dropdown</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-dropdowns-modern-light.html">Modern Light</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-dropdowns-modern-dark.html">Modern Dark</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Dropdown Effects</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-navigations-dropdowns-effect-no-effect.html">No Effect</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-dropdowns-effect-opacity.html">Opacity</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-dropdowns-effect-move-to-top.html">Move To Top</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-dropdowns-effect-move-to-bottom.html">Move To Bottom</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-dropdowns-effect-move-to-right.html">Move To Right</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-dropdowns-effect-move-to-left.html">Move To Left</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Font Styles</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-navigations-font-small.html">Small</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-font-medium.html">Medium</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-font-large.html">Large</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-font-alternative.html">Alternative</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Icons</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-navigations-icons.html">Icons</a></li>
																					<li><a class="dropdown-item" href="feature-navigations-icons-float-icons.html">Float Icons</a></li>
																				</ul>
																			</li>
																			<li><a class="dropdown-item" href="feature-navigations-sub-title.html">Sub Title</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-divisors.html">Divisors</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-logo-between.html">Logo Between</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-one-page.html">One Page Nav</a></li>
																			<li><a class="dropdown-item" href="feature-navigations-click-to-open.html">Click To Open</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Page Headers</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-page-headers-overview.html">Overview</a></li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Classic</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-page-headers-classic-small.html">Small</a></li>				
																					<li><a class="dropdown-item" href="feature-page-headers-classic-medium.html">Medium</a></li>				
																					<li><a class="dropdown-item" href="feature-page-headers-classic-large.html">Large</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Modern</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-page-headers-modern-small.html">Small</a></li>				
																					<li><a class="dropdown-item" href="feature-page-headers-modern-medium.html">Medium</a></li>				
																					<li><a class="dropdown-item" href="feature-page-headers-modern-large.html">Large</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Colors</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-page-headers-colors-primary.html">Primary</a></li>				
																					<li><a class="dropdown-item" href="feature-page-headers-colors-secondary.html">Secondary</a></li>				
																					<li><a class="dropdown-item" href="feature-page-headers-colors-tertiary.html">Tertiary</a></li>				
																					<li><a class="dropdown-item" href="feature-page-headers-colors-quaternary.html">Quaternary</a></li>				
																					<li><a class="dropdown-item" href="feature-page-headers-colors-light.html">Light</a></li>				
																					<li><a class="dropdown-item" href="feature-page-headers-colors-dark.html">Dark</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Title Position</a>
																				<ul class="dropdown-menu">
																					<li class="dropdown-submenu">
																						<a class="dropdown-item" href="#">Left</a>
																						<ul class="dropdown-menu">
																							<li><a class="dropdown-item" href="feature-page-headers-title-position-left-small.html">Small</a></li>				
																							<li><a class="dropdown-item" href="feature-page-headers-title-position-left-medium.html">Medium</a></li>				
																							<li><a class="dropdown-item" href="feature-page-headers-title-position-left-large.html">Large</a></li>
																						</ul>
																					</li>
																					<li class="dropdown-submenu">
																						<a class="dropdown-item" href="#">Right</a>
																						<ul class="dropdown-menu">
																							<li><a class="dropdown-item" href="feature-page-headers-title-position-right-small.html">Small</a></li>				
																							<li><a class="dropdown-item" href="feature-page-headers-title-position-right-medium.html">Medium</a></li>				
																							<li><a class="dropdown-item" href="feature-page-headers-title-position-right-large.html">Large</a></li>
																						</ul>
																					</li>
																					<li class="dropdown-submenu">
																						<a class="dropdown-item" href="#">Center</a>
																						<ul class="dropdown-menu">
																							<li><a class="dropdown-item" href="feature-page-headers-title-position-center-small.html">Small</a></li>				
																							<li><a class="dropdown-item" href="feature-page-headers-title-position-center-medium.html">Medium</a></li>				
																							<li><a class="dropdown-item" href="feature-page-headers-title-position-center-large.html">Large</a></li>
																						</ul>
																					</li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Background</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-page-headers-background-fixed.html">Fixed</a></li>		
																					<li><a class="dropdown-item" href="feature-page-headers-background-parallax.html">Parallax</a></li>
																					<li><a class="dropdown-item" href="feature-page-headers-background-video.html">Video</a></li>			
																					<li><a class="dropdown-item" href="feature-page-headers-background-transparent-header.html">Transparent Header</a></li>			
																					<li><a class="dropdown-item" href="feature-page-headers-background-pattern.html">Pattern</a></li>			
																					<li><a class="dropdown-item" href="feature-page-headers-background-overlay.html">Overlay</a></li>			
																					<li><a class="dropdown-item" href="feature-page-headers-background-clean.html">Clean (No Background)</a></li>	
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Extra</a>
																				<ul class="dropdown-menu">
																					<li class="dropdown-submenu">
																						<a class="dropdown-item" href="#">Breadcrumb</a>
																						<ul class="dropdown-menu">
																							<li><a class="dropdown-item" href="feature-page-headers-extra-breadcrumb-outside.html">Outside</a></li>				
																							<li><a class="dropdown-item" href="feature-page-headers-extra-breadcrumb-dark.html">Dark</a></li>			
																						</ul>
																					</li>
																					<li><a class="dropdown-item" href="feature-page-headers-extra-scroll-to-content.html">Scroll to Content</a></li>			
																					<li><a class="dropdown-item" href="feature-page-headers-extra-full-width.html">Full Width</a></li>
																				</ul>
																			</li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Footers</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-footers-overview.html">Overview</a></li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Classic</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-footers-classic.html#footer">Classic</a></li>
																					<li><a class="dropdown-item" href="feature-footers-classic-advanced.html#footer">Advanced</a></li>
																					<li><a class="dropdown-item" href="feature-footers-classic-compact.html#footer">Compact</a></li>
																					<li><a class="dropdown-item" href="feature-footers-classic-simple.html#footer">Simple</a></li>
																					<li><a class="dropdown-item" href="feature-footers-classic-locations.html#footer">Locations</a></li>
																					<li class="dropdown-submenu">
																						<a class="dropdown-item" href="#">Copyright</a>
																						<ul class="dropdown-menu">
																							<li><a class="dropdown-item" href="feature-footers-classic-copyright-light.html#footer">Light</a></li>
																							<li><a class="dropdown-item" href="feature-footers-classic-copyright-dark.html#footer">Dark</a></li>
																							<li><a class="dropdown-item" href="feature-footers-classic-copyright-social-icons.html#footer">Social Icons</a></li>
																						</ul>
																					</li>
																					<li class="dropdown-submenu">
																						<a class="dropdown-item" href="#">Colors</a>
																						<ul class="dropdown-menu">
																							<li><a class="dropdown-item" href="feature-footers-classic-colors-primary.html#footer">Primary</a></li>
																							<li><a class="dropdown-item" href="feature-footers-classic-colors-secondary.html#footer">Secondary</a></li>
																							<li><a class="dropdown-item" href="feature-footers-classic-colors-tertiary.html#footer">Tertiary</a></li>
																							<li><a class="dropdown-item" href="feature-footers-classic-colors-quaternary.html#footer			">Quaternary</a></li>
																							<li><a class="dropdown-item" href="feature-footers-classic-colors-light.html#footer">Light</a></li>
																							<li><a class="dropdown-item" href="feature-footers-classic-colors-light-simple.html#footer">Light Simple</a></li>
																						</ul>
																					</li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Modern</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-footers-modern.html#footer">Modern</a></li>
																					<li><a class="dropdown-item" href="feature-footers-modern-font-style-alternative.html#footer">Font Style Alternative</a></li>
																					<li><a class="dropdown-item" href="feature-footers-modern-clean.html#footer">Clean</a></li>	
																					<li><a class="dropdown-item" href="feature-footers-modern-useful-links.html#footer">Useful Links</a></li>
																					<li class="dropdown-submenu">
																						<a class="dropdown-item" href="#">Background</a>
																						<ul class="dropdown-menu">
																							<li><a class="dropdown-item" href="feature-footers-modern-background-image-simple.html#footer">Image Simple</a></li>
																							<li><a class="dropdown-item" href="feature-footers-modern-background-image-advanced.html#footer">Image Advanced</a></li>
																							<li><a class="dropdown-item" href="feature-footers-modern-background-video-simple.html#footer">Video Simple</a></li>
																						</ul>
																					</li>
																					<li class="dropdown-submenu">
																						<a class="dropdown-item" href="#">Call to Action</a>
																						<ul class="dropdown-menu">
																							<li><a class="dropdown-item" href="feature-footers-modern-call-to-action-button.html#footer">Button</a></li>
																							<li><a class="dropdown-item" href="feature-footers-modern-call-to-action-simple.html#footer">Simple</a></li>
																						</ul>
																					</li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Blog</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-footers-blog-classic.html#footer">Blog Classic</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">eCommerce</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-footers-ecommerce-classic.html#footer">eCommerce Classic</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Contact Form</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-footers-contact-form-classic.html#footer">Classic</a></li>
																					<li><a class="dropdown-item" href="feature-footers-contact-form-above-the-map.html#footer">Above the Map</a></li>
																					<li><a class="dropdown-item" href="feature-footers-contact-form-center.html#footer">Center</a></li>
																					<li><a class="dropdown-item" href="feature-footers-contact-form-columns.html#footer">Columns</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Map</a>
																				<ul class="dropdown-menu">
																					<li><a class="dropdown-item" href="feature-footers-map-hidden.html#footer">Hidden Map</a></li> 
																					<li><a class="dropdown-item" href="feature-footers-map-full-width.html#footer">Full Width</a></li>
																				</ul>
																			</li>
																			<li class="dropdown-submenu">
																				<a class="dropdown-item" href="#">Extra</a>
																				<ul class="dropdown-menu">
																					<li class="dropdown-submenu">
																						<a class="dropdown-item" href="#">Simple</a>
																						<ul class="dropdown-menu">
																							<li><a class="dropdown-item" href="feature-footers-extra-top-social-icons.html#footer">Top Social Icons</a></li>
																							<li><a class="dropdown-item" href="feature-footers-extra-big-icons.html#footer">Big Icons</a></li>
																						</ul>
																					</li>
																					<li><a class="dropdown-item" href="feature-footers-extra-recent-work.html#footer">Recent Work</a></li>
																					<li><a class="dropdown-item" href="feature-footers-extra-reveal.html#footer">Reveal</a></li>
																					<li><a class="dropdown-item" href="feature-footers-extra-instagram.html#footer">Instagram</a></li>
																					<li class="dropdown-submenu">
																						<a class="dropdown-item" href="#">Full Width</a>
																						<ul class="dropdown-menu">
																							<li><a class="dropdown-item" href="feature-footers-extra-full-width-light.html#footer">Simple Light</a></li>
																							<li><a class="dropdown-item" href="feature-footers-extra-full-width-dark.html#footer">Simple Dark</a></li>
																						</ul>
																					</li>
																				</ul>
																			</li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Admin Extension <span class="tip tip-dark">hot</span><em class="not-included">(Not Included)</em></a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-admin-forms-basic.html">Forms Basic</a></li>
																			<li><a class="dropdown-item" href="feature-admin-forms-advanced.html">Forms Advanced</a></li>
																			<li><a class="dropdown-item" href="feature-admin-forms-wizard.html">Forms Wizard</a></li>
																			<li><a class="dropdown-item" href="feature-admin-forms-code-editor.html">Code Editor</a></li>
																			<li><a class="dropdown-item" href="feature-admin-tables-advanced.html">Tables Advanced</a></li>
																			<li><a class="dropdown-item" href="feature-admin-tables-responsive.html">Tables Responsive</a></li>
																			<li><a class="dropdown-item" href="feature-admin-tables-editable.html">Tables Editable</a></li>
																			<li><a class="dropdown-item" href="feature-admin-tables-ajax.html">Tables Ajax</a></li>
																			<li><a class="dropdown-item" href="feature-admin-charts.html">Charts</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Sliders</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="index-classic.html">Revolution Slider</a></li>
																			<li><a class="dropdown-item" href="index-slider-nivo.html">Nivo Slider</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Layout Options</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-layout-boxed.html">Boxed</a></li>
																			<li><a class="dropdown-item" href="feature-layout-dark.html">Dark</a></li>
																			<li><a class="dropdown-item" href="feature-layout-rtl.html">RTL</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Extra</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="feature-grid-system.html">Grid System</a></li>
																			<li><a class="dropdown-item" href="feature-page-loading.html">Page Loading</a></li>
																			<li><a class="dropdown-item" href="feature-page-transition.html">Page Transition</a></li>
																			<li><a class="dropdown-item" href="feature-lazy-load.html">Lazy Load</a></li>
																			<li><a class="dropdown-item" href="feature-side-panel.html">Side Panel</a></li>
																		</ul>
																	</li>
																</ul>
															</li>
															<li class="dropdown">
																<a class="dropdown-item dropdown-toggle" href="#">
																	Pages
																</a>
																<ul class="dropdown-menu">
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Contact Us</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="contact-us-advanced.php">Contact Us - Advanced</a></li>
																			<li><a class="dropdown-item" href="contact-us.html">Contact Us - Basic</a></li>
																			<li><a class="dropdown-item" href="contact-us-recaptcha.html">Contact Us - Recaptcha</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">About Us</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="about-us-advanced.html">About Us - Advanced</a></li>
																			<li><a class="dropdown-item" href="about-us.html">About Us - Basic</a></li>
																			<li><a class="dropdown-item" href="about-me.html">About Me</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Layouts</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="page-full-width.html">Full Width</a></li>
																			<li><a class="dropdown-item" href="page-left-sidebar.html">Left Sidebar</a></li>
																			<li><a class="dropdown-item" href="page-right-sidebar.html">Right Sidebar</a></li>
																			<li><a class="dropdown-item" href="page-left-and-right-sidebars.html">Left and Right Sidebars</a></li>
																			<li><a class="dropdown-item" href="page-sticky-sidebar.html">Sticky Sidebar</a></li>
																			<li><a class="dropdown-item" href="page-secondary-navbar.html">Secondary Navbar</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Extra</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="page-404.html">404 Error</a></li>
																			<li><a class="dropdown-item" href="page-500.html">500 Error</a></li>
																			<li><a class="dropdown-item" href="page-coming-soon.html">Coming Soon</a></li>
																			<li><a class="dropdown-item" href="page-maintenance-mode.html">Maintenance Mode</a></li>
																			<li><a class="dropdown-item" href="page-search-results.html">Search Results</a></li>
																			<li><a class="dropdown-item" href="sitemap.html">Sitemap</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Team</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="page-team-advanced.html">Team - Advanced</a></li>
																			<li><a class="dropdown-item" href="page-team.html">Team - Basic</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Services</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="page-services.html">Services - Version 1</a></li>
																			<li><a class="dropdown-item" href="page-services-2.html">Services - Version 2</a></li>
																			<li><a class="dropdown-item" href="page-services-3.html">Services - Version 3</a></li>
																		</ul>
																	</li>
																	<li><a class="dropdown-item" href="page-custom-header.html">Custom Header</a></li>
																	<li><a class="dropdown-item" href="page-careers.html">Careers</a></li>
																	<li><a class="dropdown-item" href="page-faq.html">FAQ</a></li>
																	<li><a class="dropdown-item" href="page-login.html">Login / Register</a></li>
																	<li><a class="dropdown-item" href="page-user-profile.html">User Profile</a></li>
																</ul>
															</li>
															<li class="dropdown">
																<a class="dropdown-item dropdown-toggle" href="#">
																	Portfolio
																</a>
																<ul class="dropdown-menu">
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Single Project</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="portfolio-single-wide-slider.html">Wide Slider</a></li>
																			<li><a class="dropdown-item" href="portfolio-single-small-slider.html">Small Slider</a></li>
																			<li><a class="dropdown-item" href="portfolio-single-full-width-slider.html">Full Width Slider</a></li>
																			<li><a class="dropdown-item" href="portfolio-single-gallery.html">Gallery</a></li>
																			<li><a class="dropdown-item" href="portfolio-single-carousel.html">Carousel</a></li>
																			<li><a class="dropdown-item" href="portfolio-single-medias.html">Medias</a></li>
																			<li><a class="dropdown-item" href="portfolio-single-full-width-video.html">Full Width Video</a></li>
																			<li><a class="dropdown-item" href="portfolio-single-masonry-images.html">Masonry Images</a></li>
																			<li><a class="dropdown-item" href="portfolio-single-left-sidebar.html">Left Sidebar</a></li>
																			<li><a class="dropdown-item" href="portfolio-single-right-sidebar.html">Right Sidebar</a></li>
																			<li><a class="dropdown-item" href="portfolio-single-left-and-right-sidebars.html">Left and Right Sidebars</a></li>
																			<li><a class="dropdown-item" href="portfolio-single-sticky-sidebar.html">Sticky Sidebar</a></li>
																			<li><a class="dropdown-item" href="portfolio-single-extended.html">Extended</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Grid Layouts</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="portfolio-grid-1-column.html">1 Column</a></li>
																			<li><a class="dropdown-item" href="portfolio-grid-2-columns.html">2 Columns</a></li>
																			<li><a class="dropdown-item" href="portfolio-grid-3-columns.html">3 Columns</a></li>
																			<li><a class="dropdown-item" href="portfolio-grid-4-columns.html">4 Columns</a></li>
																			<li><a class="dropdown-item" href="portfolio-grid-5-columns.html">5 Columns</a></li>
																			<li><a class="dropdown-item" href="portfolio-grid-6-columns.html">6 Columns</a></li>
																			<li><a class="dropdown-item" href="portfolio-grid-no-margins.html">No Margins</a></li>
																			<li><a class="dropdown-item" href="portfolio-grid-full-width.html">Full Width</a></li>
																			<li><a class="dropdown-item" href="portfolio-grid-full-width-no-margins.html">Full Width No Margins</a></li>
																			<li><a class="dropdown-item" href="portfolio-grid-1-column-title-and-description.html">Title and Description</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Masonry Layouts</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="portfolio-masonry-2-columns.html">2 Columns</a></li>
																			<li><a class="dropdown-item" href="portfolio-masonry-3-columns.html">3 Columns</a></li>
																			<li><a class="dropdown-item" href="portfolio-masonry-4-columns.html">4 Columns</a></li>
																			<li><a class="dropdown-item" href="portfolio-masonry-5-columns.html">5 Columns</a></li>
																			<li><a class="dropdown-item" href="portfolio-masonry-6-columns.html">6 Columns</a></li>
																			<li><a class="dropdown-item" href="portfolio-masonry-no-margins.html">No Margins</a></li>
																			<li><a class="dropdown-item" href="portfolio-masonry-full-width.html">Full Width</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Sidebar Layouts</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="portfolio-sidebar-left.html">Left Sidebar</a></li>
																			<li><a class="dropdown-item" href="portfolio-sidebar-right.html">Right Sidebar</a></li>
																			<li><a class="dropdown-item" href="portfolio-sidebar-left-and-right.html">Left and Right Sidebars</a></li>
																			<li><a class="dropdown-item" href="portfolio-sidebar-sticky.html">Sticky Sidebar</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Ajax</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="portfolio-ajax-page.html">Ajax on Page</a></li>
																			<li><a class="dropdown-item" href="portfolio-ajax-modal.html">Ajax on Modal</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Extra</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="portfolio-extra-timeline.html">Timeline</a></li>
																			<li><a class="dropdown-item" href="portfolio-extra-lightbox.html">Lightbox</a></li>
																			<li><a class="dropdown-item" href="portfolio-extra-load-more.html">Load More</a></li>
																			<li><a class="dropdown-item" href="portfolio-extra-infinite-scroll.html">Infinite Scroll</a></li>
																			<li><a class="dropdown-item" href="portfolio-extra-pagination.html">Pagination</a></li>
																			<li><a class="dropdown-item" href="portfolio-extra-combination-filters.html">Combination Filters</a></li>
																		</ul>
																	</li>
																</ul>
															</li>
															<li class="dropdown">
																<a class="dropdown-item dropdown-toggle" href="#">
																	Blog
																</a>
																<ul class="dropdown-menu">
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Large Image</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="blog-large-image-full-width.html">Full Width</a></li>
																			<li><a class="dropdown-item" href="blog-large-image-sidebar-left.html">Left Sidebar</a></li>
																			<li><a class="dropdown-item" href="blog-large-image-sidebar-right.html">Right Sidebar </a></li>
																			<li><a class="dropdown-item" href="blog-large-image-sidebar-left-and-right.html">Left and Right Sidebar</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Medium Image</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="blog-medium-image-sidebar-left.html">Left Sidebar</a></li>
																			<li><a class="dropdown-item" href="blog-medium-image-sidebar-right.html">Right Sidebar </a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Grid</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="blog-grid-4-columns.html">4 Columns</a></li>
																			<li><a class="dropdown-item" href="blog-grid-3-columns.html">3 Columns</a></li>
																			<li><a class="dropdown-item" href="blog-grid-full-width.html">Full Width</a></li>
																			<li><a class="dropdown-item" href="blog-grid-no-margins.html">No Margins</a></li>
																			<li><a class="dropdown-item" href="blog-grid-no-margins-full-width.html">No Margins Full Width</a></li>
																			<li><a class="dropdown-item" href="blog-grid-sidebar-left.html">Left Sidebar</a></li>
																			<li><a class="dropdown-item" href="blog-grid-sidebar-right.html">Right Sidebar </a></li>
																			<li><a class="dropdown-item" href="blog-grid-sidebar-left-and-right.html">Left and Right Sidebar</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Masonry</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="blog-masonry-4-columns.html">4 Columns</a></li>
																			<li><a class="dropdown-item" href="blog-masonry-3-columns.html">3 Columns</a></li>
																			<li><a class="dropdown-item" href="blog-masonry-full-width.html">Full Width</a></li>
																			<li><a class="dropdown-item" href="blog-masonry-no-margins.html">No Margins</a></li>
																			<li><a class="dropdown-item" href="blog-masonry-no-margins-full-width.html">No Margins Full Width</a></li>
																			<li><a class="dropdown-item" href="blog-masonry-sidebar-left.html">Left Sidebar</a></li>
																			<li><a class="dropdown-item" href="blog-masonry-sidebar-right.html">Right Sidebar </a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Timeline</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="blog-timeline.html">Full Width</a></li>
																			<li><a class="dropdown-item" href="blog-timeline-sidebar-left.html">Left Sidebar</a></li>
																			<li><a class="dropdown-item" href="blog-timeline-sidebar-right.html">Right Sidebar </a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Single Post</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="blog-post.html">Full Width</a></li>
																			<li><a class="dropdown-item" href="blog-post-slider-gallery.html">Slider Gallery</a></li>
																			<li><a class="dropdown-item" href="blog-post-image-gallery.html">Image Gallery</a></li>
																			<li><a class="dropdown-item" href="blog-post-embedded-video.html">Embedded Video</a></li>
																			<li><a class="dropdown-item" href="blog-post-html5-video.html">HTML5 Video</a></li>
																			<li><a class="dropdown-item" href="blog-post-blockquote.html">Blockquote</a></li>
																			<li><a class="dropdown-item" href="blog-post-link.html">Link</a></li>
																			<li><a class="dropdown-item" href="blog-post-embedded-audio.html">Embedded Audio</a></li>
																			<li><a class="dropdown-item" href="blog-post-small-image.html">Small Image</a></li>
																			<li><a class="dropdown-item" href="blog-post-sidebar-left.html">Left Sidebar</a></li>
																			<li><a class="dropdown-item" href="blog-post-sidebar-right.html">Right Sidebar </a></li>
																			<li><a class="dropdown-item" href="blog-post-sidebar-left-and-right.html">Left and Right Sidebar</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Post Comments</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="blog-post.html#comments">Default</a></li>
																			<li><a class="dropdown-item" href="blog-post-comments-facebook.html#comments">Facebook Comments</a></li>
																			<li><a class="dropdown-item" href="blog-post-comments-disqus.html#comments">Disqus Comments</a></li>
																		</ul>
																	</li>
																</ul>
															</li>
															<li class="dropdown">
																<a class="dropdown-item dropdown-toggle active" href="#">
																	Shop
																</a>
																<ul class="dropdown-menu">
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">Single Product</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="shop-product-full-width.html">Full Width</a></li>
																			<li><a class="dropdown-item" href="shop-product-sidebar-left.html">Left Sidebar</a></li>
																			<li><a class="dropdown-item" href="shop-product-sidebar-right.html">Right Sidebar</a></li>
																			<li><a class="dropdown-item" href="shop-product-sidebar-left-and-right.html">Left and Right Sidebar</a></li>
																		</ul>
																	</li>
																	<li><a class="dropdown-item" href="shop-4-columns.html">4 Columns</a></li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">3 Columns</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="shop-3-columns-full-width.html">Full Width</a></li>
																			<li><a class="dropdown-item" href="shop-3-columns-sidebar-left.html">Left Sidebar</a></li>
																			<li><a class="dropdown-item" href="shop-3-columns-sidebar-right.html">Right Sidebar </a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">2 Columns</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="shop-2-columns-full-width.html">Full Width</a></li>
																			<li><a class="dropdown-item" href="shop-2-columns-sidebar-left.html">Left Sidebar</a></li>
																			<li><a class="dropdown-item" href="shop-2-columns-sidebar-right.html">Right Sidebar </a></li>
																			<li><a class="dropdown-item" href="shop-2-columns-sidebar-left-and-right.html">Left and Right Sidebar</a></li>
																		</ul>
																	</li>
																	<li class="dropdown-submenu">
																		<a class="dropdown-item" href="#">1 Column</a>
																		<ul class="dropdown-menu">
																			<li><a class="dropdown-item" href="shop-1-column-full-width.html">Full Width</a></li>
																			<li><a class="dropdown-item" href="shop-1-column-sidebar-left.html">Left Sidebar</a></li>
																			<li><a class="dropdown-item" href="shop-1-column-sidebar-right.html">Right Sidebar </a></li>
																			<li><a class="dropdown-item" href="shop-1-column-sidebar-left-and-right.html">Left and Right Sidebar</a></li>
																		</ul>
																	</li>
																	<li><a class="dropdown-item" href="shop-cart.html">Cart</a></li>
																	<li><a class="dropdown-item" href="shop-login.html">Login</a></li>
																	<li><a class="dropdown-item" href="shop-checkout.html">Checkout</a></li>
																</ul>
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
					-->

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
