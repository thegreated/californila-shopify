
<?php
	 


	 require_once('initialize.php');
	  

		if(isset($_POST["method"]) && $_POST["method"] == 'ADD_PRODUCTS'){

			$args['warehouse_id'] = $_POST['warehouse'];
			$args['service_type'] = $_POST['service_type'];
			$args['merchant'] = $_POST['merchant'];
			$args['weight'] = $_POST['weight'];
			$args['lenght'] = $_POST['lenght'];
			$args['width'] = $_POST['width'];
			$args['height'] = $_POST['height'];
			$args['quantity'] = $_POST['quantity'];
			$args['value'] = $_POST['value'];
			$args['description'] = $_POST['description'];
			$args['customer_id'] =$_POST['customer_id'];
			$args['status'] =$_POST['status'];
			$product = new Product($args);
			$uploadfile = $_FILES['file']['name'];

			return $uploadfile;
			//$sql = $product->create();

			

		}

		if(isset($_POST["method"]) && $_POST["method"] == 'HIDE_PRODUCTS'){
			$product_id = $_POST['product_id'];
			$product = new Product();
			$product->hideProduct($product_id,1);
		}

		if(isset($_POST["method"]) && $_POST["method"] == 'UNHIDE_PRODUCTS'){
			$product_id = $_POST['product_id'];
			$product = new Product();
			$product->hideProduct($product_id,0);
		}
		if(isset($_POST["method"]) && $_POST["method"] == 'SHOW_EDIT_PRODUCTS'){
			$product_id = $_POST['product_id'];
			$product = new product();
			$productData = $product->find_by_productId($product_id);
			echo json_encode($productData);
		}

	
 
 ?>