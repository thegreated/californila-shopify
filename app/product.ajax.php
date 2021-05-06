<?php require_once('../admin/initialize.php');

$products = new Product();
$countUnreadProduct = $products->product_count_unread($_GET['customer_id']);

echo $countUnreadProduct ;
$customer = new Customer();
$res = $customer->insertCustomerInformation($_GET['customer_id'],$countUnreadProduct);

var_dump($res);
