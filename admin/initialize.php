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
  define("IMG_PATH", PROJECT_PATH . '/themefiles/img/products/main/pic/');
  define("IMG_PATH_THUMB", PROJECT_PATH . '/themefiles/img/products/thumb/pic/');
  define("ADMIN_SHARED", PROJECT_PATH . '/controller/shared/');
  define("TOKEN", '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');
  define("SHOP",  'californilacargo');
  define("CURRENTLINK", "http://$_SERVER[HTTP_HOST]/php-modified/404.htm");
  define("LINK",'https://californila.com/apps/californila-cargo/');
  define("PRODUCTID",  'PRODUCT');

  // Assign the root URL to a PHP constant
  // * Do not need to include the domain
  // * Use same document root as webserver
  // * Can set a hardcoded value:
  // define("WWW_ROOT", '/~kevinskoglund/chain_gang/public');
  // define("WWW_ROOT", '');
  // * Can dynamically find everything in URL up to "/public"
  $public_end = strpos($_SERVER['SCRIPT_NAME'], '/') + 7;
  $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
  define("WWW_ROOT", '');

  require_once('functions.php');
  require_once('shopify_function.php');
  require_once('status_error_functions.php');
  require_once('db_credentials.php');
  require_once('database_functions.php');
  require_once('validation_functions.php');


  require_once('classes/databaseobject.class.php');
  require_once('classes/data_table.class.php');
  require_once('classes/shopify.class.php');
  require_once('classes/customer.class.php');
  require_once('classes/product.class.php');
  require_once('classes/announcement.class.php');
  require_once('classes/session_admin.class.php');
  require_once('classes/session.class.php');
  require_once('classes/email.class.php');

  // -> All classes in directory

  // Autoload class definitions
  
  function my_autoload($class) {
    if(preg_match('/\A\w+\Z/', $class)) {
      include('classes/' . $class . '.class.php');
    }
  }
  spl_autoload_register('my_autoload');

  $database = db_connect();
  DatabaseObject::set_database($database);

  $session = new Session;
  $controller_session = new Session_admin;

?>
