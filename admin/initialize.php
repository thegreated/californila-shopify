<?php

  ob_start(); // turn on output buffering

  // Assign file paths to PHP constants
  // __FILE__ returns the current path to this file
  // dirname() returns the path to the parent directory
  define("PRIVATE_PATH", dirname(__FILE__));
  define("PROJECT_PATH", dirname(PRIVATE_PATH));
  define("PUBLIC_PATH", PROJECT_PATH );
  define("SHARED_PATH", PRIVATE_PATH . '/shared');
  define("STAFF_PATH", PUBLIC_PATH . '/staff');
  define("TOKEN", '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');
  define("SHOP", 'californilacargo');
  define("SHOPIFY_APP_KEY", "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");
  // define("CURRENTLINK", "http://$_SERVER[HTTP_HOST]/php-modified/404.htm");
  // define("LINK",'https://californila.com/apps/californila-cargo/');


  require_once('classes/databaseobject.class.php');
  require_once('classes/customer.class.php');
  require_once('classes/product.class.php');
  require_once('classes/email.class.php');

?>
