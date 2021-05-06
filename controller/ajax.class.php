<?php

require_once('../admin/initialize.php');

if(isset($_POST["method"]) && $_POST["method"] == 'view_product_admin'){

		$transac = $_POST['transac'];
		$order = new product();
		$order_details = $order->get_product_data($transac);
	    echo json_encode($order_details);
	    
}else if(isset($_POST["method"]) && $_POST["method"] == 'trash_product'){
	$transac = $_POST['transac'];
	$DatabaseObject = new DatabaseObject();
	$res = $DatabaseObject->delete_product_data($transac);
	echo  $res;


}else if(isset($_POST["method"]) && $_POST["method"] == 'save_trash_product'){

	$arrayinsert = $_POST['arrays'];
	$DatabaseObject = new DatabaseObject();
	$res = $DatabaseObject->insert_trash_product($arrayinsert);
	echo  $res;

}else if(isset($_POST["method"]) && $_POST["method"] == 'add_admin'){

	$admin_add = $_POST['arr'];

	$admin = new admin($admin_add);
	$result = $admin->register();

	echo $result;
}else if(isset($_POST["method"]) && $_POST["method"] == 'login_admin'){

	$admin_add = $_POST['arr'];

	$admin = new admin($admin_add);
	$result = $admin->login();
	if($result == 'true'){
		 insert_Session_controller($admin->id,$admin->username);
	}
	echo $result;

}else if (isset($_POST["method"]) && $_POST["method"] == 'view_customer'){

	$viewid = $_POST['viewid'];
	$people = new people();
	$res = $people->legit_find_id($viewid);
 	echo json_encode($res);

}else if (isset($_POST["method"]) && $_POST["method"] == 'update_transac'){

	$status = $_POST['status'];
 	$update_transac = $_POST['update_transac'];
	$order = new order();
	$res = $order->update_transaction($status,$update_transac);
 	echo $res;

}else if (isset($_POST["method"]) && $_POST["method"] == 'trash_user'){

	$email =  $_POST["email"];
	$people = new people();
	//get data  by email
	$get_data = $people->find_by_email($email);

	//echo $get_data->first_name;
	//echo json_encode($get_data);
	//save data to trash
	$arr_person = createarray($get_data);
	$people = new people_trash($arr_person);
	$save_data = $people->create(); 
	echo json_encode($get_data);

}else if (isset($_POST["method"]) && $_POST["method"] == 'view_trash'){


	$people = new people_trash();
	$trash = $people->find_all();
	echo json_encode($trash);

}else if (isset($_POST["method"]) && $_POST["method"] == 'update_payed'){

	$transac = $_POST['update_transac'];
	$paymentID = $_POST['paymentID'];
	$payerID = $_POST['payerID'];
	$token 	= $_POST['token'];

	$order = new order();
	//update info
	$order->update_transaction_paypal($paymentID,$paymentID,$token,$transac);
	//MINUS THE QUANTITY
	$transaction = $order->select_transaction($transac);;
	foreach ($transaction as $key ) {
		$data = $product->minus_quantity($key->productID,$key->quantity);
	}

}else if (isset($_POST["method"]) && $_POST["method"] == 'show_transaction_activity'){

	$returnarr = array();
	$name = array();
	$date = array();

	$allarray = array();

	$transc = new order();
	$person = new people();



	$info = $transc->get_all_transaction_data_admin();
	foreach ($info as $key) {

		$memid = $person->legit_find_id($key->memberID);
		array_push($returnarr,$key->total);
		array_push($name, $memid->first_name);
		array_push($date, time_elapsed_string($key->date));

	}

	$allarray[0] = $returnarr;
	$allarray[1] = $name;
	$allarray[2] = $date;

	echo json_encode($allarray);
}

function createarray($arr){

		$person = [];
		$person['id'] = $arr->id;
		$person['first_name'] = $arr->first_name;
		$person['last_name'] = $arr->last_name;
		$person['email'] = $arr->email;
		$person['address'] = $arr->address;
		$person['city'] = $arr->city;
		$person['zip_code'] = $arr->zip_code;
		$person['contact_number'] = $arr->contact_number;
		$person['password'] = $arr->password;
		$person['activation_code'] = $arr->activation_code;
		$person['activated'] = $arr->activated;

		return $person;
		
}

//trash_user