
<?php


class Email extends DatabaseObject {


    public $to;
    public $subject;
    public $from;
    public $message;
    public $customerId;
    public $name;

    public function __construct($args=[]) {
        $this->name = $args['name'] ?? '';
        $this->customerId = $args['customerId'] ?? '';
        $this->to = $args['to'] ?? '';
        $this->subject = $args['subject'] ?? '';
        $this->from = $args['from'] ?? '';
        $this->message = $args['message'] ?? '';
        
    }

    public function sendEmailData(){
        $from =  'support@californila.com';
        // To send HTML mail, the Content-type header must be set
        $to = $this->to;
        $subject = $this->subject;

        
// To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        
        // Create email headers
        $headers .= 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();

        // compose message
        $message = $this->message;
        
        // send email
        mail($to, $subject, $message, $headers);
    
    }
    public function addProductSendEmail($customerId){
        $shopify = new Shopify();
        //customer
        $customerData= $shopify->getCustomerData($customerId);
        $args['customerId'] = $customerId;
        $args['to'] = $customerData['customer']['email'];
        $args['name'] = $customerData['customer']['first_name'].' '. $customerData['customer']['last_name'];
        $args['subject'] = "Product is updated on Warehouse";
        $email = new Email($args);
        $body = $email->addProductMsg();
        $args['message'] = $body;
        $email = new Email($args);
        $email->sendEmailData();
    }

    public function addProductMsg(){
        
        $productList = [];
        $column =  '';
        $shopify = new Shopify();
        $product = new Product();
        $products = $shopify->getProductList($this->customerId);
        $column  = $product->product_table;
        $htmlreturn = "<html><body><div style='margin:10px'>Hi ".$this->name.", Your product list is already updates see the details below :</div>";
        $htmlreturn .= '<table class="table table-striped table-bordered zero-configuration" style="margin:50px;border:1px solid black;"> <tr> 
        <td style="margin:10px;padding:10px"></td> 
        <td style="margin:10px;padding:10px">Description </td>
        <td style="margin:10px;padding:10px"> Value </td>
        <td style="margin:10px;padding:10px"> Qty </td>
        <td style="margin:10px;padding:10px"> Status </td>
        </tr>';
        foreach($products  as $product){
            $htmlreturn .=  '<tr>';
            $htmlreturn .= '<td style="margin:10px;padding:10px">';
            //image multiple
                $imgLines = explode(',', $product['imagesList']);
                foreach($imgLines as $imgLine){
                        $htmlreturn .= '<a href="https://californilacargo.myshopify.com/pages/packages" target="_blank"><img src="http://californila.com/apps/californila-cargo'.$product['imagesLocation'].''.$imgLine.'" height="100px" /> </a>';
                    }
                
            $htmlreturn .= '</td>';
            $htmlreturn .= '<td style="margin:10px;padding:10px">'.$product['description'].'</td>';
            $htmlreturn .= '<td style="margin:10px;padding:10px">$ '.$product['value'].'</td>';
            $htmlreturn .= '<td style="margin:10px;padding:10px">'.$product['qty'].'</td>';
            $htmlreturn .= '<td style="margin:10px;padding:10px"><a href="https://californilacargo.myshopify.com/pages/packages" style="text-decoration:none;" target="_blank">'.$this->statusConverter($product['status']).'</a></td>';
            $htmlreturn .=  '</tr>';
        }
        $htmlreturn .= '</table>';
        $htmlreturn .= '</html></body>';
        return $htmlreturn;


        }
        //maybe move to other function
    public function statusConverter($status){
        switch ($status) {
            case '1':
               return '<span style = "background-color:red;color:white;padding:10px"> Missing values </span>';
                break;
            case '2':
                return '<span style = "background-color:green;color:white;padding:10px"> Arrive Warehouse </span>';
                break;
            default:
            return '<span style = "background-color:blue;color:white;padding:10px">Ready for Shipment </span>';
                break;
        }
    }
    




}