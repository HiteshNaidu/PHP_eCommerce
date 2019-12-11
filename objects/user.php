<?php
class User{
    private $connection;
 
    public $id;
    public $email;
    public $username;
    public $password;
    public $shippingAddress;
    public $purchaseHistory;
 
    public function __construct($db){
        $this->connection = $db;
    }

    function create(){
        $query = "INSERT INTO users
                    SET id=:id, email=:email, username=:username, password=:password, shippingAddress=:shippingAddress, purchaseHistory=:purchaseHistory";
     
        $stmt = $this->connection->prepare($query);
     
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->shippingAddress = htmlspecialchars(strip_tags($this->shippingAddress));
        $this->purchaseHistory = htmlspecialchars(strip_tags($this->purchaseHistory));
     
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":shippingAddress", $this->shippingAddress);
        $stmt->bindParam(":purchaseHistory", $this->purchaseHistory);
     
        if($stmt->execute()){
            return true;
        }
     
        return false;   
    }

    function read(){
        $query = "SELECT * FROM users";
     
        $stmt = $this->connection->prepare($query);
     
        $stmt->execute();
     
        return $stmt;
    }

    function readSingleUser(){
        $query = "SELECT id, email, username, password, shippingAddress, purchaseHistory FROM users
                    WHERE id = ?";

        $stmt = $this->connection->prepare($query);
     
        $stmt->bindParam(1, $this->id);
     
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        $this->id = $row['id'];
        $this->email = $row['email'];
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->shippingAddress = $row['shippingAddress'];
        $this->purchaseHistory = $row['purchaseHistory'];
    }

    function update(){
        $query = "UPDATE users
                SET email = :email, username = :username, password = :password, shippingAddress = :shippingAddress, purchaseHistory = :purchaseHistory
                    WHERE id = :id";
     
        $stmt = $this->connection->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->shippingAddress = htmlspecialchars(strip_tags($this->shippingAddress));
        $this->purchaseHistory = htmlspecialchars(strip_tags($this->purchaseHistory));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':shippingAddress', $this->shippingAddress);
        $stmt->bindParam(':purchaseHistory', $this->purchaseHistory);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()){
            return true;
        }
     
        return false;
    }

    function delete(){
        $query = "DELETE FROM users WHERE id = ?";

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