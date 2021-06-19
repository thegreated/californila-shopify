
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
            case 'SELECT_PRODUCT_SHOPIFY':
                $shopify = new Shopify();
                $product = new Product();
                $products = $shopify->getProductList($this->id);
               
                $column  = $product->product_table;
                
                $htmlreturn = '<table class="table table-striped table-bordered zero-configuration">'.$this->headerData($column,'header');
                $htmlreturn .=  $this->id;
                foreach($products  as $product){
                 
                    $htmlreturn .=  '<tr>';
                    $htmlreturn .= '<td>';
                    //image multiple
                        $imgLines = explode(',', $product['imagesList']);
                        foreach($imgLines as $imgLine){
                             $htmlreturn .= '<img src=".'.$product['imagesLocation'].''.$imgLine.'" height="100px" />';
                         }
                        
                    $htmlreturn .= '</td>';
                    $htmlreturn .= '<td>'.$product['description'].'</td>';
                    $htmlreturn .= '<td>'.$product['dimention'].'</td>';
                    $htmlreturn .= '<td>'.$product['weight'].'</td>';
                    $htmlreturn .= '<td>'.$product['value'].'</td>';
                    $htmlreturn .= '<td>'.$product['qty'].'</td>';
                    $htmlreturn .= '<td>
                                     <a href="product.php?customer='.$this->id.'&product='.$product['productId'].'" class="btn mb-1 btn-rounded btn-primary p-1  m-1 "><i class="fa fa-eye" aria-hidden="true"></i></a>
                                     <button type="button" class="btn mb-1 btn-rounded btn-warning p-1  m-1 editProductBtn" data-id="'.$product['productId'].'" data-toggle="modal" data-target="#editProduct" data-whatever="@mdo"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                      </td>';
                    $htmlreturn .=  '</tr>';
                }
                $htmlreturn .= $this->headerData($column,'').'</table>';
                return $htmlreturn;

            break; 
            default :
        }

  
    
    }
    

    public function mainGenerator(){
        $product = new Product();
        $shopify = new Shopify();
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
                    $id = $shopify->productCount($value['id']);
                    $htmlreturn .= '<tr>';
                    for($i = 0; $i < count($data); $i++){
                        $htmlreturn .= '<td>'.$value[$data[$i]].'</td>';                              
                    }

                    // static data
                    $datas= '<td>'.$id['metafield']['value'].'</td>';
                    $htmlreturn .= ($this->condition == 'SELECT_CUSTOMER') ? $datas : '' ;
                    // end test

                    $htmlreturn .= '<td> <a href="'.$link.''.$value['id'].'" class="btn btn-primary">Add Product</a> </td>';
                    $htmlreturn .= '</tr>';
            }
           
        }
        $htmlreturn .= $this->headerData($column,'').'</table>';

        echo $htmlreturn;
    }

    public function headerData($column,$conditionData){
        
        if($conditionData == "header") { $conditionData  = 'thead'; } else { $conditionData  = 'tfoot';}

        $return_data ='<'.$conditionData .'><tr>  ';
            for($i = 0; $i < count($column); $i++){
              $return_data .= '<th>'.$column[$i].'</th>';
            }
        $return_data .='  </tr> </'.$conditionData .'> ';
        
        return $return_data;
    }


    

}


    