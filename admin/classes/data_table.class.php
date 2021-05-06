
<?php

class Data_table extends DatabaseObject {

    public $condition;
    public $id;

    private $customer_table = ['First Name','Last Name','Email','Number Product','Modify'];
    private $customer_column = ['first_name','last_name','email'];
    

    public function __construct($args=[]) {

        $this->condition = $args['condition'] ?? '';
        $this->id = $args['id'] ?? '';
    }

    public function sqlGenerator(){

        $productList = [];
        $column =  '';
        switch($this->condition){
            //view product on product.php
            case 'SELECT_PRODUCT':
                $product = new Product();
                $column  = $product->product_table;
                $productList =  $product->find_by_product($this->id);
                $htmlreturn = '<table class="table table-striped table-bordered zero-configuration">'.$this->headerData($column,'header');
        
                
                foreach($productList as $val){
                       if($val->hidden){ 
                              $htmlreturn .=  '<tr style="background:#C2C2C2">';
                         }else{ $htmlreturn .= '<tr style="font-size:13px">';   }
                       if($val->imagesList != ''){
                             $image = explode(',', $val->imagesList);
                             $htmlreturn .= '<td><img src="uploads/'.$image[0].'" height="60px"></td>';
                       }else{  $htmlreturn .= '<td></td>';}
                      

                       $htmlreturn .= '<td>'.$val->description.'</td>'; 
                       $htmlreturn .= '<td>'.$val->height.'x'.$val->width.'x'.$val->lenght.'</td>'; 
                       $htmlreturn .= '<td>'.$val->weight.'</td>';   
                       $htmlreturn .= '<td>$'.$val->value.'</td>';  
                       $htmlreturn .= '<td>'.$val->qty.'</td>';
                       $htmlreturn .= '<td>                               
                                        <a href="product.php?customer='.$val->customer_id.'&product='.$val->id.'" class="btn mb-1 btn-rounded btn-primary p-1  m-1 "><i class="fa fa-eye" aria-hidden="true"></i></a>';
                        if($val->hidden){ 
                            $htmlreturn .= '<button type="button" class="btn mb-1 btn-rounded btn-info p-1 m-1  sweet-unhide" data-id="'.$val->id.'"><i class="fa fa-eye" aria-hidden="true"></i></button>';
                        }else{
                            $htmlreturn .= '<button type="button" class="btn mb-1 btn-rounded btn-info p-1 m-1  sweet-hide" data-id="'.$val->id.'"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>';
                        }
        
                       $htmlreturn .= ' <button type="button" class="btn mb-1 btn-rounded btn-warning p-1  m-1 editProductBtn" data-id="'.$val->id.'" data-toggle="modal" data-target="#editProduct" data-whatever="@mdo"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </td></tr>';                 
                 }
                $htmlreturn .= $this->headerData($column,'').'</table>';
                echo $htmlreturn;
            break;
            default :
        }

  
    
    }
    

    public function mainGenerator(){
        $product = new Product();
         $column = [];
         $customerCollection = [];
         $data = [];
         $link = '';
         switch($this->condition){
            //select customer on product.php
            case 'SELECT_CUSTOMER':
                $link = 'product.php?customer=';
                $column = $this->customer_table;
                $data = $this->customer_column;
                $customerCollection =  parent::shopify_connect($this->condition);
            break;
            //select all customer on customer.php
            case 'SELECT_ONE_CUSTOMER':
                $customerCollection =  parent::shopify_connect($this->condition,$this->id);
                return $customerCollection;
            break;
            default :
        }
         $htmlreturn = '<table class="table table-striped table-bordered zero-configuration">'.$this->headerData($column,'header');
         foreach ($customerCollection as $customer){
            foreach($customer as $key => $value){
                
                    $htmlreturn .= '<tr>';
                    for($i = 0; $i < count($data); $i++){
                        $htmlreturn .= '<td>'.$value[$data[$i]].'</td>';                              
                    }

                    // static data
                    $datas= '<td>'.$product->product_count($value['id']).'</td>';
                    $htmlreturn .= ($this->condition == 'SELECT_CUSTOMER') ? $datas : '' ;
                    // end test

                    $htmlreturn .= '<td> <a href="'.$link.''.$value['id'].'" class="btn btn-primary">Add Product</a> </td>';
                    $htmlreturn .= '</tr>';
            }
           
        }
        $htmlreturn .= $this->headerData($column,'').'</table>';

        echo $htmlreturn;
    }

    private function headerData($column,$conditionData){
        
        if($conditionData == "header") { $conditionData  = 'thead'; } else { $conditionData  = 'tfoot';}

        $return_data ='<'.$conditionData .'><tr>  ';
            for($i = 0; $i < count($column); $i++){
              $return_data .= '<th>'.$column[$i].'</th>';
            }
        $return_data .='  </tr> </'.$conditionData .'> ';
        
        return $return_data;
    }


    

}


    