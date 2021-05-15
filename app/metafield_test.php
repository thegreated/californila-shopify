<?php require_once('../admin/initialize.php');


$product = new Product();
$data = $product->find_by_productId($_GET['id']);
var_dump($data[0]->imagesList);
