<?php


class Customer extends DatabaseObject {

    private $customer_table = ['First Name','Last Name','Email','Number Product','Modify'];
    private $customer_column = ['first_name','last_name','email'];

    public function insertCustomerInformation($id,$data){
        //insert to shopoify count product
        $customerCollection =  parent::shopify_connect('CUSTOMER_DASHBOARD_PRODUCT_COUNT',$id,$data);
        return $customerCollection;

    }
    //insertcustomer product
    public function insertCustomerProduct($args){
        

    }

    public function metafield_test(){

    }

}