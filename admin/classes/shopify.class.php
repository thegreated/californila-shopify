<?php

class Shopify extends DatabaseObject{

 

    public function productAdd($title,$arrayData,$customerid){
        $product = [
            "product" => [
              "title"=> $title
            ]
        ];
        //add product shopify
        $collection = parent::shopify_call(TOKEN, SHOP, "/admin/api/2021-04/products.json", $product, 'POST');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
        //add metafield to product
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
        $this->addMetafieldCustomer($productShopId,$customerid);

    
        return  $productShopId;
    }
    //update metafields
    public function updateProductMetafields($productShopId,$arrayData){

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

    //dashboartd
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
                    'key' => 'product_count_unread',
                    'value' => $i,
                    'value_type' => 'string',               
                    'namespace' => 'product_unread'
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

    
}