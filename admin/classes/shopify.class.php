<?php

class Shopify extends DatabaseObject{


    //customer dashboard update_product_warehouse
    public function product_pending_to_u_s($product_id,$customerid,$shipment){
        foreach($product_id as $prod){
     
            $data = array(
                'metafield'=>array( 
                    "namespace"=> "package_status",
                    "key" => "cargo_pending_to_philippines",
                    "value_type"=> "boolean",
                    "value" => TRUE
              
                )
            );
            //add metafield to product
            $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/products/".$prod."/metafields.json", $data, 'POST');
            $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);

            $data = array(
                'metafield'=>array( 
                    "namespace"=> "package_status",
                    "key" => "cargo_pending_to_ph_date",
                    "value_type"=> "string",
                    "value" =>  date("Y-m-d H:i:s")
              
                )
            );
            //add metafield to product
            $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/products/".$prod."/metafields.json", $data, 'POST');
            $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);


            $data = array(
                'metafield'=>array( 
                    "namespace"=> "package_status",
                    "key" => "shipment_status",
                    "value_type"=> "string",
                    "value" => $shipment
              
                )
            );
            //add metafield to product
            $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/products/".$prod."/metafields.json", $data, 'POST');
            $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);

            $this->notificationHead_pending($customerid);
        }
      
    }
    
    public function productAdd($title,$arrayData,$customerid,$merchant_info,$package_type){

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
        
        $productShopId =  $collection['product']['id'];
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
        $this->notificationHead($customerid);
    
      
    }
    //update metafields
    public function updateProductMetafields($productShopId,$arrayData,$customerid,$warehouse_id,$status){


        if($warehouse_id == "ph-warehouse" && $status == '2' || $status == '3'){

            $data = array(
                'metafield'=>array( 
                    "namespace"=> "package_status",
                    "key" => "cargo_pending_to_philippines",
                    "value_type"=> "boolean",
                        "value" => FALSE
    
                )
            );
   
            $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/products/".$productShopId."/metafields.json", $data, 'POST');
            $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
            if( $status == '2'){
                $data = array(
                    'metafield'=>array( 
                        "namespace"=> "package_status",
                        "key" => "cargo_package_date",
                        "value_type"=> "string",
                        "value" =>  date("Y-m-d H:i:s")
                
                    )
                );
                //add metafield to product
                $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/products/".$productShopId."/metafields.json", $data, 'POST');
                 $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
             }

        }
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

    //notification new product u.s
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

    //notification new product pending
    private function notificationHead_pending($customerid){

            $data = array(
                'metafield' => array(
                'key' => 'product_notification_header_pending',
                'value' => TRUE,
                'value_type' => 'boolean',               
                'namespace' => 'product_dashboard'
            )
            );
              $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/customers/".$customerid."/metafields.json", $data, 'POST');
              $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
              return $collection;
    
    }

    //return product cargo_status
    public function getCargoStatus($id){
        $collectionProduct = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/products/".$id."/metafields.json", array(), 'GET');
        $collectionProduct = json_decode($collectionProduct['response'], JSON_PRETTY_PRINT);
        foreach($collectionProduct as $key => $value){
            foreach($value as $val){
                 if($val['namespace'] == "package_status" && $val['key'] == "shipment_status"){
                     return $val['value'];
                 }
            }
        }
           
   
    }
    //show product to admin
    public function getProductList($customerid){

     
          $arrayProduct = [];
          $arrayTestid = [];
          $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/products.json", array(), 'GET');
          $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
          foreach($collection as $key => $value){
                foreach($value as $val){
                    $collectionProduct = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/products/".$val['id']."/metafields.json", array(), 'GET');
                    $collectionProduct = json_decode($collectionProduct['response'], JSON_PRETTY_PRINT);
                    $collectionProduct = json_decode($collectionProduct['metafields'][0]['value']);
                    if($collectionProduct[''])
                        array_push($arrayProduct, $this->jsonToArray($val['id'],$collectionProduct));
   
                }
          }
        //  return $arrayTestid;
          return $arrayProduct;


        //   $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/customers/".$customerid."/metafields.json", array(), 'GET');
        //   $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
        //   $i = 0;
        //   $arrayProduct = [];
        //   $collectionProduct = '';
        //   foreach($collection as $key => $value){
        //       foreach($value as $val){
        //          if($val['namespace'] == "customerProducts"){
                    
        //             $collectionProduct = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/products/".$val['value']."/metafields.json", array(), 'GET');
        //             $collectionProduct = json_decode($collectionProduct['response'], JSON_PRETTY_PRINT);
        //             $collectionProduct = json_decode($collectionProduct['metafields'][0]['value']);
        //             array_push($arrayProduct, $this->jsonToArray($val['value'],$collectionProduct));
        //              $i++;
        //          }
        //       }
          
        //   return $arrayProduct;

        
         //}
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

    // get single product modal
    public function getProductSingle($productId){
        $collectionProduct = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/products/".$productId."/metafields.json", array(), 'GET');
        $collectionProduct = json_decode($collectionProduct['response'], JSON_PRETTY_PRINT);
        $collectionProduct = json_decode($collectionProduct['metafields'][0]['value']);
        return $collectionProduct;

    }

       // output product total
    public function getProductPrice($productId){
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

     //update use via email
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