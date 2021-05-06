<?php


class Announcement extends DatabaseObject {

    static protected $table_name = "announcement";
    private $customer_table = ['announce','date_created'];
    
    public function __construct($args=[]) {

        $this->announce = $args['announce'] ?? '';
        $this->date_created = $args['date_created'] ?? '';

    }

    public function create() {
        return parent::create();
    }

}