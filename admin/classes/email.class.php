
<?php


class Email extends DatabaseObject {


    public $to;
    public $subject;
    public $from;
    public $message;
    public $customerId;

    public function __construct($args=[]) {
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
        $args['subject'] = "Product is already on Warehouse";
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
        $htmlreturn = '<table class="table table-striped table-bordered zero-configuration" style="margin:50px;border:1px solid black;"> <tr> 
        <td style="margin:10px;padding:10px"></td> 
        <td style="margin:10px;padding:10px">Description </td>
        <td style="margin:10px;padding:10px"> Value </td>
        <td style="margin:10px;padding:10px"> Qty </td>
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
            $htmlreturn .=  '</tr>';
        }
        $htmlreturn .= '</table>';
        return $htmlreturn;


        }
    




}