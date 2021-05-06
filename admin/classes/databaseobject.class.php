<?php

class DatabaseObject {

  static protected $database;
  static protected $table_name = "";
  static protected $columns = [];
  public $errors = [];

  static public function set_database($database) {
    self::$database = $database;
  }

  static public function find_by_sql($sql) {
    $result = self::$database->query($sql);
    if(!$result) {
      exit("Database query failed.");
    }

    // results into objects
    $object_array = [];
    while($record = $result->fetch_assoc()) {
      $object_array[] = static::instantiate($record);
    }

    $result->free();

    return $object_array;
  }

  static public function find_all() {
    $sql = "SELECT * FROM " . static::$table_name .' ORDER BY id DESC LIMIT 3';
    return static::find_by_sql($sql);
  }

  static public function count_all() {
    $sql = "SELECT COUNT(*) FROM " . static::$table_name;
    $result_set = self::$database->query($sql);
    $row = $result_set->fetch_array();
    return array_shift($row);
  }

  
  static public function find_by_id($id) {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE ownder_id='" . self::$database->escape_string($id) . "'";
    $obj_array = static::find_by_sql($sql);
    if(!empty($obj_array)) {
      return array_shift($obj_array);
    } else {
      return false;
    }
  }

  static public function legit_find_id($id){
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE id='" . self::$database->escape_string($id) . "'";
    $obj_array = static::find_by_sql($sql);
    if(!empty($obj_array)) {
      return array_shift($obj_array);
    } else {
      return false;
    }
  }

  static protected function instantiate($record) {
    $object = new static;
    // Could manually assign values to properties
    // but automatically assignment is easier and re-usable
    foreach($record as $property => $value) {
      if(property_exists($object, $property)) {
        $object->$property = $value;
      }
    }
    return $object;
  }

  protected function validate() {
    $this->errors = [];

    // Add custom validations

    return $this->errors;
  }

  public function create() {
    $this->validate();
    if(!empty($this->errors)) { return false; }

    $attributes = $this->sanitized_attributes();
    $sql = "INSERT INTO " . static::$table_name . " (";
    $sql .= join(', ', array_keys($attributes));
    $sql .= ") VALUES ('";
    $sql .= join("', '", array_values($attributes));
    $sql .= "')";
    $result = self::$database->query($sql);
    if($result) {
      $this->id = self::$database->insert_id;
    }
    return $this->id;
  }

  protected function update() {
    $this->validate();
    if(!empty($this->errors)) { return false; }

    $attributes = $this->sanitized_attributes();
    $attribute_pairs = [];
    foreach($attributes as $key => $value) {
      if($key=='password'){break;}
      $attribute_pairs[] = "{$key}='{$value}'";
    }

    $sql = "UPDATE " . static::$table_name . " SET ";
    $sql .= join(', ', $attribute_pairs);
    $sql .= " WHERE id='" . self::$database->escape_string($this->id) . "' ";
    $sql .= "LIMIT 1";
    $result = self::$database->query($sql);
    return $sql;
  }

  public function save() {
    // A new record will not have an ID yet
    if(isset($this->id)) {
      return $this->update();
    } else {
      return $this->create();
    }
  }

  public function merge_attributes($args=[]) {
    foreach($args as $key => $value) {
      if(property_exists($this, $key) && !is_null($value)) {
        $this->$key = $value;
      }
    }
  }

  // Properties which have database columns, excluding ID
  public function attributes() {
    $attributes = [];
    foreach(static::$db_columns as $column) {
      if($column == 'id') { continue; }
      $attributes[$column] = $this->$column;
    }
    return $attributes;
  }

  protected function sanitized_attributes() {
    $sanitized = [];
    foreach($this->attributes() as $key => $value) {
      $sanitized[$key] = self::$database->escape_string($value);
    }
    return $sanitized;
  }

  public function delete() {
    $sql = "DELETE FROM " . static::$table_name . " ";
    $sql .= "WHERE id='" . self::$database->escape_string($this->id) . "' ";
    $sql .= "LIMIT 1";
    $result = self::$database->query($sql);
    return $result;

    // After deleting, the instance of the object will still
    // exist, even though the database record does not.
    // This can be useful, as in:
    //   echo $user->first_name . " was deleted.";
    // but, for example, we can't call $user->update() after
    // calling $user->delete().
  }
 public function shopify_call($token, $shop, $api_endpoint, $query = array(), $method = 'GET', $request_headers = array()) {
    
    // Build URL
    $url = "https://" . $shop . ".myshopify.com" . $api_endpoint;
    if (!is_null($query) && in_array($method, array('GET', 	'DELETE'))) $url = $url . "?" . http_build_query($query);
  
    // Configure cURL
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, TRUE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 3);
    // curl_setopt($curl, CURLOPT_SSLVERSION, 3);
    curl_setopt($curl, CURLOPT_USERAGENT, 'My New Shopify App v.1');
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
  
    // Setup headers
    $request_headers[] = "";
    if (!is_null($token)) $request_headers[] = "X-Shopify-Access-Token: " . $token;
    curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);
  
    if ($method != 'GET' && in_array($method, array('POST', 'PUT'))) {
      if (is_array($query)) $query = http_build_query($query);
      curl_setopt ($curl, CURLOPT_POSTFIELDS, $query);
    }
      
    // Send request to Shopify and capture any errors
    $response = curl_exec($curl);
    $error_number = curl_errno($curl);
    $error_message = curl_error($curl);
  
    // Close cURL to be nice
    curl_close($curl);
  
    // Return an error is cURL has a problem
    if ($error_number) {
      return $error_message;
    } else {
  
      // No error, return Shopify's response by parsing out the body and the headers
      $response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);
  
      // Convert headers into an array
      $headers = array();
      $header_data = explode("\n",$response[0]);
      $headers['status'] = $header_data[0]; // Does not contain a key, have to explicitly set
      array_shift($header_data); // Remove status, we've already set it above
      foreach($header_data as $part) {
        $h = explode(":", $part);
        $headers[trim($h[0])] = trim($h[1]);
      }
  
      // Return headers and Shopify's response
      return array('headers' => $headers, 'response' => $response[1]);
  
    }
      
  }
  
  
  public function shopify_connect($condition,$id = 0,$data = '0')
  {
  
    switch($condition){
      //select all customer
      case 'SELECT_CUSTOMER':
        $collection = $this->shopify_call(TOKEN, SHOP, "/admin/api/2021-04/customers.json", array(), 'GET');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
        return $collection ;
        break;
      //select one customer
      case 'SELECT_ONE_CUSTOMER':
        $collection = $this->shopify_call(TOKEN, SHOP, "/admin/api/2021-04/customers/".$id.".json", array(), 'GET');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
        return $collection ;
        break;
    
    case 'CUSTOMER_DASHBOARD_PRODUCT_COUNT':
      $data = array('metafield' => 
          array(
                    'key' => 'product_count_unread',
                    'value' => $data,
                    'value_type' => 'string',               
                    'namespace' => 'product_unread'
                )
        );
      $collection = $this->shopify_call(TOKEN, SHOP, "/admin/api/2021-04/customers/".$id."/metafields.json", $data, 'POST');
      $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
      return  $collection;
      break;
      
    case 'INSERT_PRODUCT_TO_SHOPIFY':

      $ed = array(
        "metafield" => array(
          "namespace"=> "productCustomer",
          "key" => PRODUCTID."-".get_Date().$this->id,
          "value_type"=> "json_string",
              "value" => $data //"{\"product\": \"json\"}"
        )
      );
      $collection = $this->shopify_call(TOKEN, SHOP, "/admin/api/2021-04/customers/".$id."/metafields.json", $ed, 'POST');
      $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
      return $collection;

    break;
  }
  }
  

  
  
 
}





?>
