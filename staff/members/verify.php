<?php

if(!isset($_GET['v'])){
	echo '<h3> Error invalid Reset </h3>';
}else{
	
	$people = new People;
	$result = $people->activate_user($_GET['v']);
	if($result){
		echo 'Your account successfully activated';
	}
}