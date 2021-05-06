<?php  require_once('../admin/initialize.php'); 
      // require_login_redirect_controller();
       include(ADMIN_SHARED . '/header_admin.php');
        $page = 'product';
        include(ADMIN_SHARED . '/menu_admin.php');?>

    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Product</h4>
                </div>
				<?php 
	             echo "<br/>gg: ".returnID()."<br/>";
			//echo IMG_PATH;
				if(is_post_request()) {
			
				  // Create record using post parameters
                  $_POST['product']['upload_id'] = returnID();
				  $args = $_POST['product'];
                  echo $_POST['product']['upload_id'];
                 // $_POST['product']['upload_id'] = returnID();
				  
				  $product = new Product($args);
				  $file = $_FILES["files"];
				  $location = $product->move_images($file);
                 // print_r($location);

				  $main = extract_array($location['main']);  //converting array to single array
                  $thumb = extract_array($location['thumb']); //converting array to single array
                   
                  $stringmain = array_toString($main);//convert to string
                  $stringthumb = array_toString($thumb);//convert to string
				 //inserting to database
                 $product->location = $stringmain;
                 $product->thumb_location = $stringthumb;
				 $result = $product->save();

				  if($result === true) {
					$new_id = $product->ownder_id;
					echo 'success';
				  } else {
					echo 'errors';
				  }
				
				} else {
				  // display the form
				  $product = new Product;
				}
				

				?>
				 <form action="<?php echo url_for('controller/productadd.php'); ?>" method="post" enctype="multipart/form-data">
					  <div class="form-group" style="display:none">
						<label for="exampleInputEmail1">Owener Id</label>
						<input type="text" class="form-control" id="exampleInputEmail1" name="product[ownder_id]" value="<?php echo '18' ?>"  />
					  </div>
					  <div class="form-group">
						<label for="exampleInputEmail1">Name</label>
						<input type="text" class="form-control" id="exampleInputEmail1" name="product[name]" placeholder="Name" />
					  </div>
					  <div class="form-group">
						<label for="exampleInputPassword1">Description</label>
						<input type="text" class="form-control" id="exampleInputPassword1" name="product[description]" placeholder="Description" />
					  </div>
					  <div class="form-group">
						<label for="exampleInputPassword1">Category</label>
						<input type="text" class="form-control" id="exampleInputPassword1" name="product[category]" placeholder="Category" />
					  </div>
					   <div class="form-group">
						<label for="exampleInputPassword1">Originated</label>
						<input type="text" class="form-control" id="exampleInputPassword1" name="product[originated]" value="PH" />
					  </div>
					   <div class="form-group">
						<label for="exampleInputPassword1">Price</label>
						<input type="number" class="form-control" id="exampleInputPassword1" name="product[price]" placeholder="Price" />
					  </div>
					   <div class="form-group">
						<label for="exampleInputPassword1">Sale Price</label>
						<small>(OPTIONAL) </small>
						<input type="number" class="form-control" id="exampleInputPassword1" name="product[sale_price]" placeholder="Sale Price" />
					  </div>
					  <div class="form-group">
						<label for="exampleInputPassword1">Quantity</label>
						<input type="number" class="form-control" id="exampleInputPassword1" name="product[quantity]" placeholder="Quantity" />
<input type="hidden" class="form-control" id="" name="product[upload_id]" value="<?php echo returnID(); ?>" />
					  </div>
					   <div class="form-group">
						<label for="exampleInputPassword1">location</label>
					 </div>
					  
					  <div class="form-group">
						<label for="exampleInputFile">Upload Images</label>
						<input type="file" id="exampleInputFile" name="files[]" multiple/>
						<p class="help-block">Maximum upload of 5 images</p>
					  </div>
					  <button type="submit" class="btn btn-default">Submit</button>
				</form>  
            </div>
    
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    &copy; 2015 YourCompany | By : <a href="http://www.designbootstrap.com/" target="_blank">DesignBootstrap</a>
                </div>

            </div>
        </div>
    </footer>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
</body>
</html>
