<?php 


require_once('initialize.php');
// Count total files
$args[] = [];
if(isset($_FILES['files']['name'])){
    $countfiles = count($_FILES['files']['name']);

    // Upload directory
    $upload_location = "../uploads/";

    // To store uploaded files path
    $files_arr = array();

    // Loop all files
    for($index = 0;$index < $countfiles;$index++){

        if(isset($_FILES['files']['name'][$index]) && $_FILES['files']['name'][$index] != ''){

            // File name
            $filename = date('Ymd').'_'.time().'_'.$_FILES['files']['name'][$index];

            // Get extension
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            // Valid image extension
            $valid_ext = array("png","jpeg","jpg");

            // Check extension
            if(in_array($ext, $valid_ext)){

                // File path
                $path = $upload_location.$filename;
                
                // Upload file
                if(move_uploaded_file($_FILES['files']['tmp_name'][$index],$path)){
                    $files_arr[] = $filename;
                }
            }
        }
                    
}
    $args['imagesList'] =  implode(",", $files_arr);
}
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
    $args['package_type'] =$_POST['package_type'];
    $product = new Product($args);
    if(isset($_POST['condition']) && $_POST['condition'] == "ADD_PRODUCT" ){
        $product->create();
        $countUnreadProduct = $product->product_count_unread($args['customer_id']);
        $customer = new Customer();
        //update count dashboard POST API
        $res = $customer->insertCustomerInformation($args['customer_id'],$countUnreadProduct);
        //update customer product POST API
        
        echo $res;
    }
    if(isset($_POST['condition']) && $_POST['condition'] == "EDIT_PRODUCT" ){
        $result = $product->updateProduct($_POST['product_id']);
        echo $result;
    }


die;

