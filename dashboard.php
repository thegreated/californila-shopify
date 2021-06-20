<?php
require_once('admin/initialize.php');

if(isset($_POST["method"])){
    $condition = $_POST["method"];
    $user_id =  $_POST["user_id"];
    switch($condition){
        case('EDIT_PROFILE'):
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $gender  = $_POST['gender'];
            $birthday = $_POST['birthday'];
            $facebook= $_POST['facebook'];
            $instagram = $_POST['instagram'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $customer = new Customer();
            $result = $customer->updateCustomerProfile($user_id,$first_name,$last_name,$gender,$facebook,$instagram,$birthday,$phone,$email);
            echo json_encode($result);
        break;
        case('EDIT_EMAIL'):
            $args['new_email'] = $_POST['new_email'];
            $shopify  = new Shopify();
            $result = $shopify->updateEmail($user_id,$args['new_email']);
        break;
        case('EDIT_PASSWORD'):

        break;
        case('CHANGE_PROFILE_IMG'):
        
        break;
        case('SAVE_REQUEST'):
            $product_request_name = $_POST['product_request_name'];
            $product_link = $_POST['product_link'];
            $instruction = $_POST['instruction'];
            $customer = new Customer();
            echo $product_request_name.' '.$product_link.' '.$instruction.' '.$productShopId.' '.$user_id;
            $result = $customer->requestInsert($product_request_name,$product_link,$instruction,$user_id);
         
            echo $result;


        break;
        case('PENDING_USA_PACKAGE'):
            $arrayProductId =  $_POST['productId'];
            $shipment =  $_POST['shipment'];
            $product = new Product();
            $result = $product->product_pending_to_u_s($arrayProductId,$user_id,$shipment);
            echo json_encode($result);
        break;
        
    }


}


?>
