<?php

class Shopify extends DatabaseObject{

 

    public function productAdd($title,$arrayData,$customerid,$merchant_info,$package_type,$variants,$qty){
        $product = array(
            "product" => array(
              "title"=> $title,
              "vendor"=> $merchant_info,
              "product_type" => $package_type
            )
            );
        //add product shopify
        $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/products.json", $product, 'POST');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
        
        //add metafield to product
        $productShopId =  $collection['product']['id'];
        //adding variant
        $variant = array(
            "variant" => array(
              "option1"=> 'air-cargo',
              "price" => $variants['air'],
              "inventory_policy" => "continue"
            
            )
        );
        $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/products/".$productShopId."/variants.json", $variant, 'POST');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);

        $variant = array(
            "variant" => array(
              "option1"=> 'sea-cargo',
              "price" => $variants['sea'],
              "inventory_policy" => "continue"

             
            )
        );
        $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/products/".$productShopId."/variants.json", $variant, 'POST');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);


        $data = array(
            'metafield'=>array( 
                "namespace"=> "productData",
                "key" => $productShopId,
                "value_type"=> "json_string",
                    "value" => $arrayData

            )
        );
        //add metafield to product
        $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/products/".$productShopId."/metafields.json", $data, 'POST');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
        $this->addMetafieldCustomer($productShopId,$customerid);
        $this->notificationHead($customerid);
    
        return  $productShopId;
    }
    //update metafields
    public function updateProductMetafields($productShopId,$arrayData,$customerid){

        $data = array(
            'metafield'=>array( 
                "namespace"=> "productData",
                "key" => $productShopId,
                "value_type"=> "json_string",
                    "value" => $arrayData

            )
        );
        //update product shopify
        $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/products/".$productShopId."/metafields.json", $data, 'POST');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
        $this->notificationHead($customerid);
        

    }

    public function addMetafieldCustomer($id,$customerid){

        $product = array(
            "metafield" => array(
              "namespace"=> "customerProducts",
              "key" => PRODUCTID."-".$id,
              "value_type"=> "string",
                  "value" =>  $id
            )
          );
          $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/customers/".$customerid."/metafields.json", $product, 'POST');
          $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
          return $collection;

    }

    private function notificationHead($customerid){

        $data = array(
            'metafield' => array(
            'key' => 'product_notification_header',
            'value' => TRUE,
            'value_type' => 'boolean',               
            'namespace' => 'product_dashboard'
        )
        );
          $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/customers/".$customerid."/metafields.json", $data, 'POST');
          $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
          return $collection;

    }

    //show product to admin
    public function getProductList($customerid){

     
          $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/customers/".$customerid."/metafields.json", array(), 'GET');
          $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
          $i = 0;
          $arrayProduct = [];
          $collectionProduct = '';
          foreach($collection as $key => $value){
              foreach($value as $val){
                 if($val['namespace'] == "customerProducts"){
                    
                    $collectionProduct = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/products/".$val['value']."/metafields.json", array(), 'GET');
                    $collectionProduct = json_decode($collectionProduct['response'], JSON_PRETTY_PRINT);
                    $collectionProduct = json_decode($collectionProduct['metafields'][0]['value']);
                    array_push($arrayProduct, $this->jsonToArray($val['value'],$collectionProduct));
                     $i++;
                 }
              }
          
          return $arrayProduct;

        
         }
    }


    

    //json to array 
    private function jsonToArray($product_id,$collectionProduct){
        $args['productId'] = $product_id;
        $args['imagesList'] =  $collectionProduct->imagesList;
        $args['imagesLocation'] =  $collectionProduct->imagesLocation;
        $args['description'] = $collectionProduct->description;
        $args['dimention'] = $collectionProduct->height.' x '.$collectionProduct->width.' x '.$collectionProduct->lenght;
        $args['weight'] = $collectionProduct->weight;
        $args['value'] = $collectionProduct->value;
        $args['qty'] = $collectionProduct->qty;
        $args['status'] = $collectionProduct->status;
        return $args;

    }

    public function getProductSingle($productId){
        $collectionProduct = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/products/".$productId."/metafields.json", array(), 'GET');
        $collectionProduct = json_decode($collectionProduct['response'], JSON_PRETTY_PRINT);
        $collectionProduct = json_decode($collectionProduct['metafields'][0]['value']);
        return $collectionProduct;

    }

    //dashboard admin
    public function productCount($customerid){
        $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/customers/".$customerid."/metafields.json", array(), 'GET');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
        $i = 0;
        foreach($collection as $key => $value){
            foreach($value as $val){
               if($val['namespace'] == "customerProducts")
                   $i++;
            }
        
       }
        $data = array('metafield' => 
        array(
            'key' => 'product_count_warehouse',
            'value' => $i,
            'value_type' => 'string',               
            'namespace' => 'product_dashboard'
        )
        );
 
        $collection = $this->shopify_call(TOKEN, SHOP, "/admin/api/2021-04/customers/".$customerid."/metafields.json", $data, 'POST');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);

        $data = array('metafield' => 
        array(
            'key' => 'product_count_packed',
            'value' => $i,
            'value_type' => 'string',               
            'namespace' => 'product_dashboard'
        )
        );

        $collection = $this->shopify_call(TOKEN, SHOP, "/admin/api/2021-04/customers/".$customerid."/metafields.json", $data, 'POST');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);


        return  $collection;

    }
    

    //customer api -----------------------------------------
    public function getCustomerData($customerid){
        $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/customers/".$customerid.".json", array(), 'GET');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
        return $collection;

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

        $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/customers/".$customerid.".json",$data, 'PUT');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);

        $data = array('metafield' => 
        array(
            'key' => 'birthday',
            'value' => $birthday,
            'value_type' => 'string',               
            'namespace' => 'customer_profile'
        )
        );
        $collection = $this->shopify_call(TOKEN, SHOP, "/admin/api/2021-04/customers/".$customerid."/metafields.json", $data, 'POST');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
        
        $data = array('metafield' => 
        array(
            'key' => 'gender',
            'value' => $gender,
            'value_type' => 'string',               
            'namespace' => 'customer_profile'
        )
        );
        $collection = $this->shopify_call(TOKEN, SHOP, "/admin/api/2021-04/customers/".$customerid."/metafields.json", $data, 'POST');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);

        $data = array('metafield' => 
        array(
            'key' => 'facebook',
            'value' => $facebook,
            'value_type' => 'string',               
            'namespace' => 'customer_profile'
        )
        );
        $collection = $this->shopify_call(TOKEN, SHOP, "/admin/api/2021-04/customers/".$customerid."/metafields.json", $data, 'POST');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);

        $data = array('metafield' => 
        array(
            'key' => 'instagram',
            'value' => $instagram,
            'value_type' => 'string',               
            'namespace' => 'customer_profile'
        )
        );
        $collection = $this->shopify_call(TOKEN, SHOP, "/admin/api/2021-04/customers/".$customerid."/metafields.json", $data, 'POST');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);


     }


     public function updateEmail($customerid,$email){

        
        $data = array('customer' => 
        array(
            'id' => $customerid,
            'email' => $email,
        )
        );

        $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/customers/".$customerid.".json",$data, 'PUT');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);

     }
     public function updatePassword($customerid,$email){

    }
}