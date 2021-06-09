<?php


class Customer extends DatabaseObject {

   
    private $customer_table = ['First Name','Last Name','Email','Number Product','Modify'];
    private $customer_column = ['first_name','last_name','email'];

    public $first_name; 
    public $last_name; 
    public $gender;
    public $facebook;
    public $instagram; 
    public $birthday; 

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? '';
        $this->first_name = $args['first_name'] ?? '';
        $this->last_name = $args['last_name'] ?? '';
        $this->gender = $args['gender'] ?? '';
        $this->facebook = $args['facebook'] ?? '';
        $this->instagram = $args['instagram'] ?? '';
        $this->birthday = $args['birthday'] ?? '';

    }
    public function insertCustomerInformation($id,$data){
        //insert to shopoify count product
        $customerCollection =  parent::shopify_connect('CUSTOMER_DASHBOARD_PRODUCT_COUNT',$id,$data);
        return $customerCollection;
        
    }
 
    public function metafield_test(){

    }

}