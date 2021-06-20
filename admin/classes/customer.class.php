<?php


class Customer extends DatabaseObject {

    
    public function requestInsert($product_request_name,$product_link,$instruction,$productShopId){

        $data = array(
            'metafield'=>array( 
                "namespace"=> "product_request",
                "key" => "product_request_name",
                "value_type"=> "string",
                "value" =>  $product_request_name

            )
        );
        $this->callShortcut($productShopId,$data);
 
        $data = array(
            'metafield'=>array( 
                "namespace"=> "product_request",
                "key" => "product_link",
                "value_type"=> "string",
                "value" =>  $product_link

            )
        );
        $this->callShortcut($productShopId,$data);
        $data = array(
            'metafield'=>array( 
                "namespace"=> "product_request",
                "key" => "instruction",
                "value_type"=> "string",
                "value" =>  $instruction

            )
        );
        $this->callShortcut($productShopId,$data);
    

      
    }

      //updttecustomerProfile-----------------------------------------
    public function updateCustomerProfile($customerid,$first_name,$last_name,$gender,$facebook,$instagram,$birthday,$phone,$email){

        $data = array('customer' => 
        array(
            'id' => $customerid,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone' => $phone,
             
        )
        );

        $collection = parent::shopify_call("/admin/api/2021-04/customers/".$customerid.".json",$data, 'PUT');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);


        $data = array('metafield' => 
        array(
            'key' => 'birthday',
            'value' => $birthday,
            'value_type' => 'string',               
            'namespace' => 'customer_profile'
        )
        );
        $this->callShortcut($customerid,$data);
       
      

        $data = array('metafield' => 
        array(
            'key' => 'gender',
            'value' => $gender,
            'value_type' => 'string',               
            'namespace' => 'customer_profile'
        )
        );
        $this->callShortcut($customerid,$data);

        $data = array('metafield' => 
        array(
            'key' => 'facebook',
            'value' => $facebook,
            'value_type' => 'string',               
            'namespace' => 'customer_profile'
        )
        );
        $this->callShortcut($customerid,$data);

        $data = array('metafield' => 
        array(
            'key' => 'instagram',
            'value' => $instagram,
            'value_type' => 'string',               
            'namespace' => 'customer_profile'
        )
        );
        $this->callShortcut($customerid,$data);
        

    }

     private function callShortcut($customerid,$data){
        $collection = parent::shopify_call( "/admin/api/2021-04/customers/".$customerid."/metafields.json", $data, 'POST');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
        return $collection;
     }

}