
<?php
class Product extends DatabaseObject {

    static protected $table_name = "products";
    //insert to table
    static protected $db_columns = ['warehouse_id', 'customer_id', 'service_type','merchant_info','weight','lenght','width','height','qty','value','package_type','description','status','imagesList','hidden','viewed'];
    //view product
    public $product_table = ['Image','Desicription','Dimention HxWxL (cm)','Weight(kg)','Value','Qty','Modify'];
    //add product to rest api
    public $product_table_api = ['warehouse_id', 'customer_id', 'service_type','merchant_info','weight','lenght','width','height','qty','value','package_type','description','status','imagesList'];
    


    public $id;
    public $warehouse_id ;
    public $customer_id;
    public $service_type ;
    public $merchant_info;
    public $weight;
    public $lenght;
    public $width;
    public $height;
    public $qty;
    public $value;
    public $package_type;
    public $description;
    public $status ;
    public $hidden;
    public $imagesList;
    public $viewed;
    public $imagesLocation;

    public function __construct($args=[]) {
         $this->id = $args['id'] ?? '';
         $this->warehouse_id = $args['warehouse_id'] ?? '';
         $this->customer_id = $args['customer_id'] ?? '';
         $this->service_type = $args['service_type'] ?? '';
         $this->merchant_info = $args['merchant'] ?? '';
         $this->weight = $args['weight'] ?? '';
         $this->width = $args['width'] ?? '';
         $this->lenght = $args['lenght'] ?? '';
         $this->height = $args['height'] ?? '';
         $this->qty = $args['quantity'] ?? '';
         $this->value = $args['value'] ?? '';
         $this->package_type = $args['package_type'] ?? '';
         $this->description = $args['description'] ?? '';
         $this->hidden = $args['hidden'] ?? '0';
         $this->imagesList = $args['imagesList'] ?? '';
         $this->viewed = $args['viewed'] ?? '0';
         $this->status = $args['status'] ?? '1';
         $this->imagesLocation = $args['imagesLocation'] ?? '';
      

    }



       public function updateProduct($id){
        $shopify = new Shopify();
        $this->id = $id;
        $email = new Email();
        $shopify->updateProductMetafields($id,$this->jsonProduct(),$this->customer_id);
        $sendEmail = $email->addProductSendEmail($this->customer_id);
      }



      public function create() {

       $shopify = new Shopify();
       $email = new Email();
       $variant = $this->product_calculate();
      $shopify->productAdd($this->description,$this->jsonProduct(),$this->customer_id,$this->merchant_info,$this->package_type,$variant,$this->qty);
      $sendEmail = $email->addProductSendEmail($this->customer_id);
       return  $variant;

      }
      
      public function product_calculate(){
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
         
         $args['sea'] = number_format( (float) $sea, 2, '.', '');
         $args['air'] = number_format( (float) $air, 2, '.', '');

         return $args;
       

      }

     private function is_decimal( $val )
      {
          return is_numeric( $val ) && floor( $val ) != $val;
      }
      //json generator
      public function jsonProduct(){
      
        $json = "{\"customer_id\":\"".$this->customer_id."\",\"warehouse_id\":\"".$this->warehouse_id."\",\"service_type\":\"".$this->service_type."\",\"merchant_info\":\"".$this->merchant_info."\",\"weight\":\"".$this->weight."\",";
        $json .= "\"lenght\":\"".$this->lenght."\",\"width\":\"".$this->width."\", \"height\":\"".$this->height."\",\"qty\":\"".$this->qty."\",\"value\":\"".$this->value."\",";
        $json .= "\"package_type\":\"".$this->package_type."\",\"status\":\"".$this->status."\",\"description\":\"".$this->description."\"";
        
        if($this->imagesList  == ""){
          $shopify = new Shopify();
          $data = $shopify->getProductSingle($this->id);
          $json .= ",\"imagesList\":\"".$data->imagesList."\",\"imagesLocation\":\"".$data->imagesLocation."\"}";
        
        }else {
          $json .= ",\"imagesList\":\"".$this->imagesList."\",\"imagesLocation\":\"".$this->imagesLocation."\"}";
        }
        return $json;
        
      }


      public function unitTest(){
        $this->id = "1";
        $this->warehouse_id ='test';
        $this->customer_id =  'test';
        $this->service_type = 'test';
        $this->merchant_info =  'test';
        $this->weight =  '50.5';
        $this->width = '17';
        $this->lenght =  '20';
        $this->height = '23';
        $this->qty =  '1';
        $this->value =  '500';
        $this->package_type = 'test';
        $this->description ='test';
        var_dump($this->create());
        // $this->imagesList  '';

      }





}