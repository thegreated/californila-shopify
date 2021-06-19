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
 
    
    public function requestInsert($product_request_name,$product_link,$instruction,$productShopId){

        $data = array(
            'metafield'=>array( 
                "namespace"=> "product_request",
                "key" => "product_request_name",
                "value_type"=> "string",
                "value" =>  $product_request_name

            )
        );
        $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/customers/".$productShopId."/metafields.json", $data, 'POST');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
 
        $data = array(
            'metafield'=>array( 
                "namespace"=> "product_request",
                "key" => "product_link",
                "value_type"=> "string",
                "value" =>  $product_link

            )
        );
        $collection = parent::shopify_call( TOKEN, SHOP,"/admin/api/2021-04/customers/".$productShopId."/metafields.json", $data, 'POST');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
        $data = array(
            'metafield'=>array( 
                "namespace"=> "product_request",
                "key" => "instruction",
                "value_type"=> "string",
                "value" =>  $instruction

            )
        );
        $collection = parent::shopify_call(TOKEN, SHOP,"/admin/api/2021-04/customers/".$productShopId."/metafields.json", $data, 'POST');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
        return $collection;



        

    
      
    }

}