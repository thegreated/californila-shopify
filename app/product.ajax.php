<?php require_once('../admin/initialize.php');

$shopify = new Shopify();

$product = new Product();
$product->unitTest();
$test = $product->updateProduct('6831442657447');
var_dump($test);



