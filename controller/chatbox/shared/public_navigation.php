	<!-- NAVIGATION -->
	<div  id="navigation" style="margin-top: 130px">
		<!-- container -->
		<div class="container">
			<div id="responsive-nav">
				<!-- category nav -->
				<div class="category-nav show-on-click">
					<span class="category-header">Categories <i class="fa fa-list"></i></span>
					<ul class="category-list">
						<?php $product   = new product();
								  $category = $product->get_all_category();
							 		foreach($category as $cat){?>
							<li><a href="products.php?searchput=<?=$cat->category; ?>&search=<?=$cat->category; ?>"><?=$cat->category; ?></a></li>
								<?php } ?>
	
						
					</ul>
				</div>
				<!-- /category nav -->

				<!-- menu nav -->
				<div class="menu-nav">
					<span class="menu-header">Menu <i class="fa fa-bars"></i></span>
					<ul class="menu-list">
						<li><a href="../index.php">Home</a></li>
						<li><a href="../products.php">Shop</a></li>
					</ul>
				</div>
				<!-- menu nav -->
			</div>
		</div>
		<!-- /container -->
	</div>
	<!-- /NAVIGATION -->