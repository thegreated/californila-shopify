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
            $shopify = new Shopify();
            $result = $shopify->updateCustomerProfile($user_id,$first_name,$last_name,$gender,$facebook,$instagram,$birthday,$phone,$email);
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
        
    }


}


?>
