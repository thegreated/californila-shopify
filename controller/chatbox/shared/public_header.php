<?php
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	 <title>Chain Gang <?php if(isset($page_title)) { echo '- ' . h($page_title); } ?></title>
	<script src="../themefiles/js/jquery.min.js"></script>
	<!-- Google font -->
<!-- 	<link href="https://fonts.googleapis.com/css?family=Hind:400,700" rel="stylesheet"> -->

	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="../themefiles/css/bootstrap.min.css" />

	<!-- Slick -->
	<link type="text/css" rel="stylesheet" href="../themefiles/css/slick.css" />
	<link type="text/css" rel="stylesheet" href="../themefiles/css/slick-theme.css" />

	<!-- nouislider -->
	<link type="text/css" rel="stylesheet" href="../themefiles/css/nouislider.min.css" />

	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="../themefiles/css/font-awesome.min.css">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="../themefiles/css/style.css" />
	



	<!-- HTML5 shim and Respond.
	
	 for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

</head>

<body>
	<!-- HEADER -->
	<header  style="    position: fixed;
    top: 0;
    right: 0;
    left: 0;
    z-index: 1030;background-color: white;border-bottom: 1px solid black;">
		<!-- top Header -->
		<div id="top-header">
			<div class="container">
				<div class="pull-left">
					<span>Welcome to E-shop!</span>
				</div>
				<div class="pull-right">
					<ul class="header-top-links">
					</ul>
				</div>
			</div>
		</div>
		<!-- /top Header -->

		<!-- header -->
		<div id="header">
			<div class="container">
				<div class="pull-left">
					<!-- Logo -->
					<div class="header-logo">
						<a class="logo" href="../index.php">
							<img src="../themefiles/img/logo2.png" alt="">
						</a>
					</div>
					<!-- /Logo -->

					<!-- Search -->
					<div class="header-search">
						<form method="get" action="products.php">
							<input class="input search-input" type="text" placeholder="Enter your keyword" name="searchput">
							<select class="input search-categories" name="search">
								<option value="all">All Categories</option>
								<?php $product   = new product();
								  $category = $product->get_all_category();
							 		foreach($category as $cat){?>
							<option value="<?=$cat->category; ?>"><?=$cat->category; ?></option>
								<?php } ?>
							</select>
							<button class="search-btn"><i class="fa fa-search"></i></button>
						</form>
					</div>
					<!-- /Search -->
				</div>
				<div class="pull-right">
					<ul class="header-btns">
						<!-- Account -->
						<li class="header-account dropdown default-dropdown">
							<div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
								<div class="header-btns-icon">
									<i class="fa fa-user-o"></i>
								</div>
								<strong class="text-uppercase">My Account <i class="fa fa-caret-down"></i></strong>
							</div>
							<?php if(islogin()) { ?>
							Welcome 
							<?php  }else if(!islogin()){ ?>
							<a href="login.php" class="text-uppercase">Login</a> / <a href="register.php" class="text-uppercase">Join</a>
							<?php } ?>
							<ul class="custom-menu">
								<?php if(islogin()) { ?>
								<li><a href="profile.php"><i class="fa fa-user-o"></i> My Account</a></li>
								<li><a href="logout.php"><i class="fa fa-user-plus"></i> Logout</a></li>
								<?php  }else if(!islogin()){ ?>
								<li><a href="login.php"><i class="fa fa-unlock-alt"></i> Login</a></li>
								<li><a href="register.php"><i class="fa fa-user-plus"></i> Register</a></li>
								<?php } ?>
							</ul>
						</li>
						<!-- /Account -->

						<!-- Cart -->
						<li class="header-cart dropdown default-dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
								<div class="header-btns-icon">
									<i class="fa fa-shopping-cart"></i>
									<span class="qty"></span>
								</div>
								<strong class="text-uppercase">My Cart:</strong>
								<br>
								<span class='sub_total'></span>
							</a>
							<div class="custom-menu">

								<div id="shopping-cart">

									<div id="shopping-cart-data">
									</div>

									<div class="shopping-cart-btns">
										
										<a href="Checkout.php" class="primary-btn center">Checkout <i class="fa fa-arrow-circle-right"></i></a>
									</div>

								</div>

							</div>
						</li>
						<!-- /Cart -->

						<!-- Mobile nav toggle-->
						<li class="nav-toggle">
							<button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-bars"></i></button>
						</li>
						<!-- / Mobile nav toggle -->
					</ul>
				</div>
			</div>
			<!-- header -->
		</div>
		<!-- container -->
	</header>