<?php
class Product{
 
    private $connection;
 
    public $id;
    public $description;
    public $price;
    public $shippingPrice;
    public $imageURL;
 
    public function __construct($db){
        $this->connection = $db;
    }

    function read(){
     
        $query = "SELECT * FROM products";
     
        $stmt = $this->connection->prepare($query);
     
        $stmt->execute();
     
        return $stmt;
    }
}
?>