<?php
    header('Content-Type: application/json');

if(isset($_POST["method"])){
    $user_id = $_POST["method"];
    switch($user_id){
        case('EDIT_PROFILE'):
            $args['first_name'] = $_POST['first_name'];
            $args['last_name'] = $_POST['last_name'];
            $args['gender'] = $_POST['gender'];
            $args['birthday'] = $_POST['birthday'];
            $args['facebook'] = $_POST['facebook'];
            $args['instagram'] = $_POST['instagram'];
            
            echo ($data);
        break;
        case('EDIT_EMAIL'):
            $args['current_email'] = $_POST['current_email'];
            $args['new_email'] = $_POST['new_email'];
        break;
        case('EDIT_PASSWORD'):
            $args['current_password'] = $_POST['current_password'];
            $args['new_password'] = $_POST['new_password'];
        break;
        case('CHANGE_PROFILE_IMG'):
            $args['profile_img'] = $_POST['profile_img'];
        break;
        
    }


}


?>
