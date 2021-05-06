<?php  require_once('../admin/initialize.php'); 
       require_login_redirect_controller();
       include(ADMIN_SHARED . '/header_admin.php');
        $page = 'message';
        include(ADMIN_SHARED . '/menu_admin.php');


        include('chatbox/index.php')?>
         <?php  include(ADMIN_SHARED . '/footer_admin.php'); ?>