<?php require_once('../admin/initialize.php');


$product = new Product();
$data = $product->deletemetafield($_GET['customer']);
var_dump($data);
