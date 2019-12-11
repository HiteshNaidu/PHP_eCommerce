<?php
class Cart{
 
    private $connection;
 
    public $id;
    public $productId;
    public $userId;
    public $quantities;
 
    public function __construct($db){
        $this->connection = $db;
    }

    function create(){
        $query = "INSERT INTO cart
                    SET id=:id, productId=:productId, userId=:userId, quantities=:quantities";
     
        $stmt = $this->connection->prepare($query);
     
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->productId = htmlspecialchars(strip_tags($this->productId));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->quantities = htmlspecialchars(strip_tags($this->quantities));
     
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":productId", $this->productId);
        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":quantities", $this->quantities);
     
        if($stmt->execute()){
            return true;
        }
     
        return false;   
    }

    function read(){
     
        $query = "SELECT * FROM cart";
     
        $stmt = $this->connection->prepare($query);
     
        $stmt->execute();
     
        return $stmt;
    }

    function readSingleCart(){
        $query = "SELECT id, productId, userId, quantities FROM cart
                    WHERE id = ?";

        $stmt = $this->connection->prepare($query);
     
        $stmt->bindParam(1, $this->id);
     
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        $this->id = $row['id'];
        $this->productId = $row['productId'];
        $this->userId = $row['userId'];
        $this->quantities = $row['quantities'];
    }

    function update(){
        $query = "UPDATE cart
                SET productId = :productId, userId = :userId, quantities = :quantities
                    WHERE id = :id";
     
        $stmt = $this->connection->prepare($query);

        $this->productId = htmlspecialchars(strip_tags($this->productId));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->quantities = htmlspecialchars(strip_tags($this->quantities));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':productId', $this->productId);
        $stmt->bindParam(':userId', $this->userId);
        $stmt->bindParam(':quantities', $this->quantities);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()){
            return true;
        }
     
        return false;
    }

    function delete(){
        $query = "DELETE FROM cart WHERE id = ?";

        $stmt = $this->connection->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));
     
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()){
            return true;
        }
     
        return false;       
    }
}
?>