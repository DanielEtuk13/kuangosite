<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if (!empty($_GET["action"]))
	switch ($_GET["action"]) {
		case "add":
			if (!empty($_POST["quantity"])) {
				$productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
				$itemArray = array($productByCode[0]["code"] => array('name' => $productByCode[0]["name"], 'code' => $productByCode[0]["code"], 'quantity' => $_POST["quantity"], 'image' => $productByCode[0]["image"]));

				if (!empty($_SESSION["cart_item"])) {
					if (in_array($productByCode[0]["code"], array_keys($_SESSION["cart_item"]))) {
						foreach ($_SESSION["cart_item"] as $k => $v) {
							if ($productByCode[0]["code"] == $k) {
								if (empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							}
						}
					} else {
						$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
					}
				} else {
					$_SESSION["cart_item"] = $itemArray;
				}
			}
			break;
		case "remove":
			if (!empty($_SESSION["cart_item"])) {
				foreach ($_SESSION["cart_item"] as $k => $v) {
					if ($_GET["code"] == $k)
						unset($_SESSION["cart_item"][$k]);
					if (empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
				}
			}
			break;
		case "empty":
			unset($_SESSION["cart_item"]);
			break;
	}


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>KuangoQMS</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="keywords" />
	<meta content="" name="description" />

	<!-- Favicons -->
	<link href="/kuangosite/img/kuango_logo.jpg" rel="icon" />
	<link href="/kuangosite/img/kuango_logo.jpg" rel="apple-touch-icon" />

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,700|Roboto:300,400,700&display=swap" rel="stylesheet" />

	<!-- Bootstrap CSS File -->
	<link href="/kuangosite/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

	<!-- Vendor CSS Files -->
	<link href="/kuangosite/vendor/icofont/icofont.min.css" rel="stylesheet" />
	<link href="/kuangosite/vendor/line-awesome/css/line-awesome.min.css" rel="stylesheet" />
	<link href="/kuangosite/vendor/aos/aos.css" rel="stylesheet" />
	<link href="/kuangosite/vendor/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

	<!-- Main CSS File -->
	<link href="/kuangosite/css/style.css" rel="stylesheet" />
	<link href="style.css" type="text/css" rel="stylesheet" />
</head>

<body>
	<div class="site-wrap">
		<div class="site-mobile-menu site-navbar-target">
			<div class="site-mobile-menu-header">
				<div class="site-mobile-menu-close mt-3">
					<span class="icofont-close js-menu-toggle"></span>
				</div>
			</div>
			<div class="site-mobile-menu-body"></div>
		</div>

		<header class="site-navbar js-sticky-header site-navbar-target" role="banner">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-6 col-lg-2">
						<h1 class="mb-0 site-logo">
							<a href="/kuangosite/index.html" class="mb-0">KuangoQMS</a>
						</h1>
					</div>

					<div class="col-12 col-md-10 d-none d-lg-block">
						<nav class="site-navigation position-relative text-right" role="navigation">
							<ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
								<li>
									<a href="/kuangosite/index.html" class="nav-link">Home</a>
								</li>
								<li><a href="/kuangosite/features.html" class="nav-link">Features</a></li>
								<li><a href="/kuangosite/product_page/pricing.php" class="nav-link">Pricing</a></li>
								<li>
									<a href="/kuangosite/contact.html" class="nav-link">Contact</a>
								</li>
							</ul>
						</nav>
					</div>

					<div class="col-6 d-inline-block d-lg-none ml-md-0 py-3" style="position: relative; top: 3px;">
						<a href="#" class="burger site-menu-toggle js-menu-toggle" data-toggle="collapse" data-target="#main-navbar">
							<span></span>
						</a>
					</div>
				</div>
			</div>
		</header>

		<main id="main">
			<div class="hero-section inner-page">
				<div class="wave">
					<svg width="1920px" height="265px" viewBox="0 0 1920 265" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
						<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
								<path d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,667 L1017.15166,667 L0,667 L0,439.134243 Z" id="Path"></path>
							</g>
							b
						</g>
					</svg>
				</div>

				<div class="container">
					<div class="row align-items-center">
						<div class="col-12">
							<div class="row justify-content-center">
								<div class="col-md-7 text-center hero-text">
									<h1 data-aos="fade-up" data-aos-delay="">Pricing</h1>
									<p class="mb-5" data-aos="fade-up" data-aos-delay="100">
										Purchase a KuangoQMS
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="site-section pb-0">
				<div id="shopping-cart" class="container">
					<div class="row align-items-center justify-content-section">
						<div class="col-md-4 mr-auto">
							<h2 class="mb-4">QMS component selector</h2>
							<a class="btn" href="/kuangosite/product_page/pricing.php?action=empty" style="background-color: rgb(255, 255, 255);
    box-shadow: 0 3px 6px rgba(0, 0, 0, .16), 0 1px 2px rgba(0, 0, 0, .23);
">Empty Cart</a>
							<?php
							if (isset($_SESSION["cart_item"])) {
								$total_quantity = 0;

							?>
								<br>
								<table class="tbl-cart" cellpadding="10" cellspacing="1">
									<tbody>
										<br>
										<tr>
											<th style="text-align:left;">Name</th>
											<th style="text-align:left;">ID</th>
											<th style="text-align:right;" width="5%">Quantity</th>
											<th style="text-align:center;" width="5%">Remove</th>
										</tr>
										<?php
										foreach ($_SESSION["cart_item"] as $item) {

										?>

											<tr>
												<td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /><?php echo $item["name"]; ?></td>
												<td><?php echo $item["code"]; ?></td>
												<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
												<td style="text-align:center;"><a href="/kuangosite/product_page/pricing.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
											</tr>
										<?php
											$total_quantity += $item["quantity"];
										}
										?>

										<tr>
											<td colspan="2" align="right">Total:</td>
											<td align="right"><?php echo $total_quantity; ?></td>
											<td></td>
											<br>
											<td>
												<a class="btn" href="/kuangosite/phpmailer/formpage.html" style="background-color: rgb(255, 255, 255);
														box-shadow: 0 3px 6px rgba(0, 0, 0, .16), 0 1px 2px rgba(0, 0, 0, .23);">Checkout
												</a>
											</td>
										</tr>
									</tbody>
								</table>
							<?php
							} else {
							?>
								<div class=" no-records">Your Cart is Empty
								</div>
							<?php
							}
							?>
						</div>
						<br>
						<br>
						<p class="mb-4">
							Select the preferred units suitable for your company.
						</p>
						<div id="product-grid">
							<div class="txt-heading">Products</div>
							<?php
							$product_array = $db_handle->runQuery("SELECT * FROM tblproduct ORDER BY id ASC");
							if (!empty($product_array)) {
								foreach ($product_array as $key => $value) {
							?>
									<div class="product-item">
										<form method="post" action="/kuangosite/product_page/pricing.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
											<div class="product-image"><img src="<?php echo $product_array[$key]["image"]; ?>"></div>
											<div class="product-tile-footer">
												<div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
												<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
											</div>
										</form>
									</div>
							<?php
								}
							}

							?>
						</div>

					</div>
				</div>

			</div>
	</div>
	</div>
	</div>


	<div class="site-section border-top border-bottom">
		<div class="container">
			<div class="row justify-content-center text-center mb-5">
				<div class="col-md-4">
					<h2 class="section-heading">Reviews</h2>
				</div>
			</div>
			<div class="row justify-content-center text-center">
				<div class="col-md-7">
					<div class="owl-carousel testimonial-carousel">
						<div class="review text-center">
							<p class="stars">
								<span class="icofont-star"></span>
								<span class="icofont-star"></span>
								<span class="icofont-star"></span>
								<span class="icofont-star"></span>
								<span class="icofont-star muted"></span>
							</p>
							<h3>Excellent Technology Innovation!</h3>
							<blockquote>
								<p>
									Helped a lot to effectively manage queues in my company.
								</p>
							</blockquote>

							<p class="review-user">
								<img src="/kuangosite/img/person_1.jpg" alt="Image" class="img-fluid rounded-circle mb-3" />
								<span class="d-block">
									<span class="text-black">Mrs Kuango</span>, &mdash;
									Staff, Kuango Tech Ltd
								</span>
							</p>
						</div>

						<div class="review text-center">
							<p class="stars">
								<span class="icofont-star"></span>
								<span class="icofont-star"></span>
								<span class="icofont-star"></span>
								<span class="icofont-star"></span>
								<span class="icofont-star muted"></span>
							</p>
							<h3>Smoother Workflow</h3>
							<blockquote>
								<p>
									This technology has helped my company focus more on
									quality customer service.
								</p>
							</blockquote>

							<p class="review-user">
								<img src="/kuangosite/img/person_2.jpg" alt="Image" class="img-fluid rounded-circle mb-3" />
								<span class="d-block">
									<span class="text-black">Kevin Folawiyo</span>, &mdash;
									CEO, BetaPharma
								</span>
							</p>
						</div>

						<div class="review text-center">
							<p class="stars">
								<span class="icofont-star"></span>
								<span class="icofont-star"></span>
								<span class="icofont-star"></span>
								<span class="icofont-star"></span>
								<span class="icofont-star muted"></span>
							</p>
							<h3>Awesome functionality!</h3>
							<blockquote>
								<p>
									With 100% uptime, this is the best solution to handling
									customer long queue's.
								</p>
							</blockquote>

							<p class="review-user">
								<img src="/kuangosite/img/person_3.jpg" alt="Image" class="img-fluid rounded-circle mb-3" />
								<span class="d-block">
									<span class="text-black">Ayomide Fowler</span>, &mdash;
									User
								</span>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="site-section cta-section">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 mr-auto text-center text-md-left mb-5 mb-md-0">
					<h2>Purchase the KuangoQMS now!</h2>
				</div>
				<div class="col-md-5 text-center text-md-right">
					<p>
						<a href="//kuangosite/product_page/pricing.php" class="btn"><span class="icofont-dollar mr-3"></span>Pricing Page</a>
					</p>
				</div>
			</div>
		</div>
	</div>
	</main>
	<footer class="footer" role="contentinfo">
		<div class="container">
			<div class="row">
				<div class="col-md-4 mb-4 mb-md-0">
					<h3>About Kuango Tech Ltd</h3>
					<p>
						Kuango Tech Ltd Kuango Tech Ltd is purely an information
						technology company registered in Nigeria with Registration
						Number: RC1472552, since 19 February, 2018, with our office
						situated at Suite 7 Aisha Plaza, KM12 Lasu-Isheri road, Alimosho
						LGA - Lagos, Nigeria.
					</p>
					<p class="social">
						<a href="#"><span class="icofont-twitter"></span></a>
						<a href="#"><span class="icofont-facebook"></span></a>
						<a href="#"><span class="icofont-instagram"></span></a>
					</p>
				</div>
				<div class="col-md-7 ml-auto">
					<div class="row site-section pt-0">
						<div class="col-md-4 mb-4 mb-md-0">
							<h3>Navigation</h3>
							<ul class="list-unstyled">
								<li><a href="//kuangosite/product_page/pricing.php">Pricing</a></li>
								<li><a href="/kuangosite/features.html">Features</a></li>
								<li><a href="/kuangosite/contact.html">Contact</a></li>
							</ul>
						</div>
						<div class="col-md-4 mb-4 mb-md-0">
							<h3>Services</h3>
							<ul class="list-unstyled">
								<li><a href="#">Collaboration</a></li>
								<li><a href="#">Todos</a></li>
							</ul>
						</div>
						<div class="col-md-4 mb-4 mb-md-0">
							<h3>Purchase</h3>
							<ul class="list-unstyled">
								<li><a href="//kuangosite/product_page/pricing.php">Purcahse online </a></li>
								<li>
									<a href="#">Speak to our active customer support.</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="row justify-content-center text-center">
				<div class="col-md-7">
					<p class="copyright">
						&copy; Copyright Kuango Tech Ltd. All Rights Reserved, 2020.
					</p>
				</div>
			</div>
		</div>
	</footer>
	</div>
	<!-- .site-wrap -->

	<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

	<!-- Vendor JS Files -->
	<script src="/kuangosite/vendor/jquery/jquery.min.js"></script>
	<script src="/kuangosite/vendor/jquery/jquery-migrate.min.js"></script>
	<script src="/kuangosite/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="/kuangosite/vendor/easing/easing.min.js"></script>
	<script src="/kuangosite/vendor/php-email-form/validate.js"></script>
	<script src="/kuangosite/vendor/sticky/sticky.js"></script>
	<script src="/kuangosite/vendor/aos/aos.js"></script>
	<script src="/kuangosite/vendor/owlcarousel/owl.carousel.min.js"></script>

	<!-- Main JS File -->
	<script src="/kuangosite/js/main.js"></script>
</body>

</html>