
<?php
class Product extends DatabaseObject {

  
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
        $this->callShortcut($prod,$data);
        $data = array(
            'metafield'=>array( 
                "namespace"=> "package_status",
                "key" => "cargo_pending_to_ph_date",
                "value_type"=> "string",
                "value" =>  date("Y-m-d H:i:s")
          
            )
        );
        $this->callShortcut($prod,$data);
        $data = array(
            'metafield'=>array( 
                "namespace"=> "package_status",
                "key" => "shipment_status",
                "value_type"=> "string",
                "value" => $shipment
          
            )
        );
 
        $this->callShortcut($prod,$data);

        
      }
    
  }
  
  private function callShortcut($productShopId,$data){
    $collection = parent::shopify_call( "/admin/api/2021-04/products/".$productShopId."/metafields.json", $data, 'POST');
    $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);

  }
      //add product price to  metafields
    private function calculate_product_cost($cargo,$productShopId){
        $price =  $this->product_calculate($cargo);
      
        // //adding variant
        $variant = array(
            "variant" => array(
              "option1"=> "cargo-price",
              "price" =>  $price, 
              "inventory_policy" => "continue",

            )
        );
        $collection = parent::shopify_call("/admin/api/2021-04/products/".$productShopId."/variants.json", $variant, 'POST');
        $collection = json_decode($collection['response'], JSON_PRETTY_PRINT);
        return $collection;
        
        
    }
      //calculate product
    public function product_calculate($cargo){
      $subtotal_air = 0;
      $subtotal_sea = 0;
      $dollar_prize = 47.65;
      $subtotal = 0;
      $lbs = 0;
      $lbsunroubd = (float) $this->weight;
      if($lbsunroubd > 1){
            //check if decimal
          if ($this->is_decimal($lbsunroubd)) {
          //check if less that .4
              if(($lbsunroubd % 1) < 0.5){
                  $lbs = $lbsunroubd;
              }else{
                $lbs = round($lbsunroubd);
              }
          }else{
          
            $lbs = $lbsunroubd;
          }
          
        }else{
          $lbs = 1;
      }

      $weight = $lbs;
      
      $length_inches = (float) $this->lenght;
      $width_inches = (float) $this->width;
      $height_inches = (float) $this->height;

      $length = $length_inches;
      $width = $width_inches;
      $height = $height_inches;

      $declared_value = $this->value;
      $dimensional_weight = (($length * $width * $height ) / 166);
      $dimensional_weight = number_format( (float) $dimensional_weight, 2, '.', '');
      $air_cargo = $weight * 7.99;
      $sea_cargo = $dimensional_weight * 2.75;
      $air_cargo_dw = $dimensional_weight * 7.99;
      $sea_cargo_dw = $dimensional_weight * 2.75;
      if($weight > $dimensional_weight){
        $subtotal_air = $air_cargo + $special_handling;
        $subtotal_sea = $sea_cargo + $special_handling;
      }
      else if($weight < $dimensional_weight){
        $subtotal_air = $air_cargo_dw + $special_handling ; 
        $subtotal_sea = $sea_cargo_dw + $special_handling;
        }
        $sea=  (float) $subtotal_sea * $dollar_prize;
        $air =  (float) $subtotal_air *  $dollar_prize;
        switch($cargo){
        case 'sea-cargo':
          return number_format( (float) $sea, 2, '.', '');
        break;
        case 'air-cargo':
          return  number_format( (float) $air, 2, '.', '');
        break;
        default:
          return number_format( (float) $sea, 2, '.', '');
        break;
        }
      
      

    }

     private function is_decimal( $val ) {
          return is_numeric( $val ) && floor( $val ) != $val;
      }
    





}