<?php


function insert_Session($id,$email){
    global $session;
	$args=[$id, $email];
	if($session->login($args)){
		return true;
	}
	
}


function returnID(){
   global $session;
   return $session->admin_id;
}


function islogin(){
  global $session;
  if($session->admin_id != ''){
    return true;
  }else{
    return false;
  }
}
function islogout(){
    global $session;
    $session->logout();
     redirect_to(url_for('index.php'));
}
function require_login() {
  global $session;
  if(!$session->is_logged_in()) {
    redirect_to(url_for('/staff/login.php'));
  } else {
    // Do nothing, let the rest of the page proceed
  }
}
function require_login_redirect() {
  global $session;
  if(!$session->is_logged_in()) {
   
  } else {
     redirect_to(url_for('profile.php'));
  }
}

function display_errors($errors=array()) {
  $output = '';
  if(!empty($errors)) {
    $output .= "<div class=\"errors\">";
    $output .= "Please fix the following errors:";
    $output .= "<ul>";
    foreach($errors as $error) {
      $output .= "<li>" . h($error) . "</li>";
    }
    $output .= "</ul>";
    $output .= "</div>";
  }
  return $output;
}

function display_session_message() {
  global $session;
  $msg = $session->message();
  if(isset($msg) && $msg != '') {
    $session->clear_message();
    return '<div id="message">' . h($msg) . '</div>';
  }
}
//--------------------------------------------------------
//---controller
function insert_Session_controller($id,$email){
  global $controller_session;
  $args=[$id, $email];
  if($controller_session->login($args)){
    return true;
  }
}
function returnID_controller(){
   global $controller_session;
   return $controller_session->controller_admin_id;
}

function islogin_controller(){
  global $controller_session;
  if(isset($controller_session->$controller_admin_id) && $controller_session->$controller_admin_id != ''){
    return true;
  }else{
    return false;
  }
}

function is_logout_controller(){
    global $controller_session;
    $controller_session->logout();
    redirect_to(url_for('controller/login.php'));
}
function require_login_redirect_controller(){
   global $controller_session;
  if(!$controller_session->is_logged_in()) {
    redirect_to(url_for('controller/login.php'));
  } else {
     //redirect_to(url_for('controller/admin.php'));
  }

}

function countallmsg(){
  $chat = new chat();
  $chatbox = $chat->countallmsg(returnID());
  return $chatbox;
}

?>
