<?php

class Session_admin {

  public $controller_admin_id;
  public $controller_username;
  private $controller_last_login;

  public const MAX_LOGIN_AGE = 60*60*24; // 1 day

  public function __construct() {
    $this->check_stored_login();
  }

  public function login($admin) {
    if($admin) {
      // prevent session fixation attacks
      session_regenerate_id();
      $this->controller_admin_id = $_SESSION['controller_admin_id'] = $admin[0];
      $this->controller_username = $_SESSION['controller_username'] = $admin[1];
      $this->controller_last_login = $_SESSION['controller_last_login'] = time();
    }
    return true;
  }

  public function is_logged_in() {
    // return isset($this->admin_id);
    return isset($this->controller_admin_id) && $this->last_login_is_recent();
  }

  public function logout() {
    unset($_SESSION['controller_admin_id']);
    unset($_SESSION['controller_username']);
    unset($_SESSION['controller_last_login']);
    unset($this->controller_admin_id);
    unset($this->controller_username);
    unset($this->controller_last_login);
    return true;
  }

  private function check_stored_login() {
    if(isset($_SESSION['controller_admin_id'])) {
      $this->controller_admin_id = $_SESSION['controller_admin_id'];
      $this->controller_username = $_SESSION['controller_username'];
      $this->controller_last_login = $_SESSION['controller_last_login'];
    }
  }

  private function last_login_is_recent() {
    if(!isset($this->controller_last_login)) {
      return false;
    } elseif(($this->controller_last_login + self::MAX_LOGIN_AGE) < time()) {
      return false;
    } else {
      return true;
    }
  }

  public function message($msg="") {
    if(!empty($msg)) {
      // Then this is a "set" message
      $_SESSION['controller_message'] = $msg;
      return true;
    } else {
      // Then this is a "get" message
      return $_SESSION['controller_message'] ?? '';
    }
  }

  public function clear_message() {
    unset($_SESSION['controller_message']);
  }
}

?>
