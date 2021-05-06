
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
      

    }

    static public function find_by_product($id) {
        $sql = "SELECT * FROM " . static::$table_name . " ";
        $sql .= "WHERE customer_id='" . self::$database->escape_string($id) . "' ORDER BY id DESC;";
        $obj_array = static::find_by_sql($sql);
        if(!empty($obj_array)) {
          return $obj_array;
        } else {
          return false;
        }
      }

      static public function find_by_productId($id) {
        $sql = "SELECT * FROM " . static::$table_name . " ";
        $sql .= "WHERE id='" . self::$database->escape_string($id) . "' ORDER BY id DESC;";
        $obj_array = static::find_by_sql($sql);
        if(!empty($obj_array)) {
          return $obj_array;
        } else {
          return false;
        }
      }

      static public function product_count($id) {
        $sql = "SELECT sum(qty) as qty FROM " . static::$table_name . " ";
        $sql .= "WHERE customer_id='" . self::$database->escape_string($id) . "'";
        $obj_array = static::find_by_sql($sql);
        return $obj_array[0]->qty;
      }

      static public function hideProduct($id,$hidden){
        $sql ="UPDATE " . static::$table_name . " SET hidden = ".$hidden." WHERE id ='".$id."' ";
        $sql .= " LIMIT 1";
        $result = self::$database->query($sql);
        return $result;

      }

       public function updateProduct($id){
        $sql ="UPDATE " . static::$table_name . " SET warehouse_id = '".$this->warehouse_id."' ,service_type = '".$this->service_type."'";
        $sql .=" , merchant_info = '".$this->merchant_info."' ,weight = ".$this->weight."  ,lenght = ".$this->lenght." ,width = ".$this->width."";
        $sql .=" ,height = ".$this->height." ,qty = ".$this->qty." ,value = ".$this->value." ,package_type = '".$this->package_type."' ,status = ".$this->status." ,description = '".$this->description."'";
              if(!empty($this->imagesList)){ $sql .= "  ,imagesList = '".$this->imagesList."'"; }
        $sql .= " WHERE id ='".$id."' ";
        $sql .= " LIMIT 1";
        $result = self::$database->query($sql);
        return $sql;


      }
      static public function product_count_unread($id) {
        $sql = "SELECT count(qty) as qty FROM " . static::$table_name . " ";
        $sql .= "WHERE customer_id='" . self::$database->escape_string($id) . "' AND viewed = 0 ";
        $obj_array = static::find_by_sql($sql);
        return $obj_array[0]->qty;
      }

      public function create() {

          return parent::create();


      }



}