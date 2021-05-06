<?php

class People extends DatabaseObject {

  static protected $table_name = "people";
  static protected $db_columns = ['id', 'first_name', 'last_name', 'email','address','city','zip_code','contact_number','password','activation_code','activated'];

  public $id;
  public $first_name;
  public $last_name;
  public $email;
  public $address;
  public $city;
  public $zip_code;
  public $contact_number;
  public $username;
  protected $hashed_password;
  public $password;
  public $passnorm;
  public $confirm_password;
  public $activation_code;
  public $activated = '1';
  protected $password_required = true;

  
  public function __construct($args=[]) {
    $this->id = $args['id'] ?? '';
    $this->first_name = $args['first_name'] ?? '';
    $this->last_name = $args['last_name'] ?? '';
    $this->email = $args['email'] ?? '';
    $this->address = $args['address'] ?? '';
    $this->city = $args['city'] ?? '';
    $this->zip_code = $args['zip_code'] ?? '';
    $this->contact_number = $args['contact_number'] ?? '';
    $this->password = $args['password'] ?? '';
    $this->confirm_password = $args['confirm_password'] ?? '';
	  $this->activation_code = $args['activation_code'] ?? '';
	  $this->activated = $args['activated'] ?? '';

  }

  public function full_name() {
    return $this->first_name . " " . $this->last_name;
  }

  protected function set_hashed_password() {
	$this->passnorm = $this->password;
    $this->password = password_hash($this->password, PASSWORD_BCRYPT);
  }
  
  protected function set_activation_code(){
	$data = str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
	$data1 = str_shuffle("0123456789");
	$data2 = str_shuffle("");
	$result = $data .'-'. $data1;
	$result = str_shuffle($result);
	$this->activation_code = substr($result, -20);
 }

  public function verify_password($password,$hashed_password) {
    return password_verify($password, $hashed_password);
  }
  
  public function activated(){
	  
  }

  public function create() {

	//	$this->set_activation_code();
		//$this->send_email('Welcome to Company');
		return parent::create();

  }

  public function update() {
    if($this->password != '') {
      $this->set_hashed_password();
      // validate password
    } else {
      // password not being updated, skip hashing and validation
      $this->password_required = false;
    }
    return parent::update();
  }
  
  protected function send_email($subject){
	
	$to 	  = $this->email;
	$from	  = 'portfolio';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	 
	// Create email headers
	$headers .= 'From: '.$from."\r\n".
		'Reply-To: '.$from."\r\n" .
		'X-Mailer: PHP/' . phpversion();
	 
	// Compose a simple HTML email message
	$message = '<html><body> <hr><center>';
	$message .= '<h1>Thank you for registering in Company</h1>';
	$message .= '<h3> To verify your account click <a href="http://edsite.x10host.com/public/verify.php?v='. $this->activation_code .'"> here </a> </h3>';
	$message .= '</center><hr></body></html>';
	 
	// Sending email
//	mail($to, $subject, $message, $headers);

	  
  }
   public function login(){
	 $emailval = $this->find_by_email($this->email);
	 
	 if (!$emailval) {
		    $this->errors[] = "Email is not register";
	 }else{
		if($this->verify_password($this->password,$emailval->password)){
			if(!$emailval->activated){
				$this->errors[] = "Account is not yet activated";
			}else{ //activated and ready to insert to session
				$this->id = $emailval->id;
				$this->email = $emailval->email;
				return true;
			}
		}else{
			$this->errors[] = "Password is incorrect";
		}
	 }
   }

   
   static public function find_by_email($email) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE email='" . self::$database->escape_string($email) . "'";
    $obj_array = static::find_by_sql($sql);
    if(!empty($obj_array)) {
      return array_shift($obj_array);
      //return true;
    } else {
      return false;
    }
  }
  
  static public function activate_user($code) {
    $sql = "UPDATE " . static::$table_name . " SET ";
    $sql .= "activated = '1'";
    $sql .= "WHERE activation_code='" . self::$database->escape_string($code) . "' ";
    $sql .= "LIMIT 1";
    $result = self::$database->query($sql);
    return $result;
  }


  static public function delete_user($code) {
    $sql = "UPDATE " . static::$table_name . " SET ";
    $sql .= "activated = '1'";
    $sql .= "WHERE activation_code='" . self::$database->escape_string($code) . "' ";
    $sql .= "LIMIT 1";
    $result = self::$database->query($sql);
    return $result;
  }

  static public function move_to_trash($code) {
   
  }
  
  
  protected function validate() {
    $this->errors = [];

    if(is_blank($this->first_name)) {
      $this->errors[] = "First name cannot be blank.";
    } elseif (!has_length($this->first_name, array('min' => 2, 'max' => 255))) {
      $this->errors[] = "First name must be between 2 and 255 characters.";
    }

    if(is_blank($this->last_name)) {
      $this->errors[] = "Last name cannot be blank.";
    } elseif (!has_length($this->last_name, array('min' => 2, 'max' => 255))) {
      $this->errors[] = "Last name must be between 2 and 255 characters.";
    }

    if(is_blank($this->email)) {
      $this->errors[] = "Email cannot be blank.";
    } elseif (!has_length($this->email, array('max' => 255))) {
      $this->errors[] = "Last name must be less than 255 characters.";
    } elseif (!has_valid_email_format($this->email)) {
      $this->errors[] = "Email must be a valid format.";
    }


    if($this->password_required) {
      if(is_blank($this->password)) {
        $this->errors[] = "Password cannot be blank.";
      } elseif (!has_length($this->password, array('min' => 12))) {
        $this->errors[] = "Password must contain 12 or more characters";
      } elseif (!preg_match('/[A-Z]/', $this->password)) {
        $this->errors[] = "Password must contain at least 1 uppercase letter";
      } elseif (!preg_match('/[a-z]/', $this->password)) {
        $this->errors[] = "Password must contain at least 1 lowercase letter";
      } elseif (!preg_match('/[0-9]/', $this->password)) {
        $this->errors[] = "Password must contain at least 1 number";
      } elseif (!preg_match('/[^A-Za-z0-9\s]/', $this->password)) {
        $this->errors[] = "Password must contain at least 1 symbol";
      }

      if(is_blank($this->confirm_password)) {
        $this->errors[] = "Confirm password cannot be blank.";
      } elseif ($this->passnorm !== $this->confirm_password) {
        $this->errors[] = "Password and confirm password must match.";
      }
    }

    return $this->errors;
  }
  


}

?>
