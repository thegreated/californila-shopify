<?php


function url_for($script_path) {
  // add the leading '/' if not present
  if($script_path[0] != '/') {
    $script_path = "/" . $script_path;
  }
  return WWW_ROOT . $script_path;
}

function u($string="") {
  return urlencode($string);
}

function raw_u($string="") {
  return rawurlencode($string);
}

function h($string="") {
  return htmlspecialchars($string);
}

function error_404() {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
  exit();
}

function error_500() {
  header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
  exit();
}

function redirect_to($location) {
  header("Location: " . $location);
  exit;
}

function is_post_request() {
  return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request() {
  return $_SERVER['REQUEST_METHOD'] == 'GET';
}
//extract multi_dimention
function extract_array($location){
  $array = array();
  foreach ($location as $user)
  {
    array_push( $array, $user);
  }
  return $array;
}

function array_toString($array){
  $string = '';
  $count = 0;
  foreach ($array as $row) {
    if($count == 0)
    $string = $row[$count];
    else
    $string .= ','.$row[$count];

    $count++;
  }
  return $string;
}

// PHP on Windows does not have a money_format() function.
// This is a super-simple replacement.
if(!function_exists('money_format')) {
  function money_format($format, $number) {
    return '$' . number_format($number, 2);
  }
}
//profile.php
function condition_pay($paymentID,$payerID,$token){
  if($paymentID == "" && $payerID == "" && $token == "" ){
    return false;
  }else{
    return true;
  }
}

function get_transactionDUP($id){

  $order = new order();
  $order_details = $order->get_transaction_data($id);
  return $order_details;
}

function get_transaction(){

  $order = new order();
  $order_details = $order->get_transaction_data(returnID());
  return $order_details;
}
function get_all_transaction_data(){

  $order = new order();
  $order_details = $order->  get_all_transaction_data();
  return  $order_details;
}
function get_count_pending(){
  $order = new order();
  $order_details = $order->get_transaction_data(returnID());
  return count($order_details);
}

function get_name_image($product_id){
  $product = new product();
  $order_details = $product->find_by_id($product_id);
  return $order_details;
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function get_Date(){

  $date = new Datetime("now");
  return $d2->format('U');    
}
?>
