<?php

// Set variables for our request
$shop = $_GET['shop'];
$api_key = "2eb660069efac078f0aac31ab415fbd3";
$scopes = "read_orders,write_products,read_themes,write_themes,write_script_tags,read_customers,write_customers,";
$redirect_uri = "https://californila.com/apps/californila-cargo/generate_token.php";

// Build install/approval URL to redirect to
$install_url = "https://" . $shop . ".myshopify.com/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

// Redirect
header("Location: " . $install_url);
die();