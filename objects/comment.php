<?php
class Comment{
 
    private $connection;
 
    public $id;
    public $imageURL;
    public $productId;
    public $rating;
    public $text;
    public $userId;
 
    public function __construct($db){
        $this->connection = $db;
    }

    function create(){
        $query = "INSERT INTO comments
                    SET id=:id, imageURL=:imageURL, productId=:productId, rating=:rating, text=:text, userId=:userId";
     
        $stmt = $this->connection->prepare($query);
     
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->imageURL = htmlspecialchars(strip_tags($this->imageURL));
        $this->productId = htmlspecialchars(strip_tags($this->productId));
        $this->rating = htmlspecialchars(strip_tags($this->rating));
        $this->text = htmlspecialchars(strip_tags($this->text));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
     
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":imageURL", $this->imageURL);
        $stmt->bindParam(":productId", $this->productId);
        $stmt->bindParam(":rating", $this->rating);
        $stmt->bindParam(":text", $this->text);
        $stmt->bindParam(":userId", $this->userId);
     
        if($stmt->execute()){
            return true;
        }
     
        return false;   
    }

    function read(){
     
        $query = "SELECT * FROM comments";
     
        $stmt = $this->connection->prepare($query);
     
        $stmt->execute();
     
        return $stmt;
    }

    function readSingleComment(){
        $query = "SELECT id, imageURL, productId, rating, text, userId FROM comments
                    WHERE id = ?";

        $stmt = $this->connection->prepare($query);
     
        $stmt->bindParam(1, $this->id);
     
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        $this->id = $row['id'];
        $this->imageURL = $row['imageURL'];
        $this->productId = $row['productId'];
        $this->rating = $row['rating'];
        $this->text = $row['text'];
        $this->userId = $row['userId'];
    }

    function update(){
        $query = "UPDATE comments
                SET imageURL = :imageURL, productId = :productId, rating = :rating, text = :text, userId = :userId
                    WHERE id = :id";
     
        $stmt = $this->connection->prepare($query);

        $this->imageURL = htmlspecialchars(strip_tags($this->imageURL));
        $this->productId = htmlspecialchars(strip_tags($this->productId));
        $this->rating = htmlspecialchars(strip_tags($this->rating));
        $this->text = htmlspecialchars(strip_tags($this->text));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':imageURL', $this->imageURL);
        $stmt->bindParam(':productId', $this->productId);
        $stmt->bindParam(':rating', $this->rating);
        $stmt->bindParam(':text', $this->text);
        $stmt->bindParam(':userId', $this->userId);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()){
            return true;
        }
     
        return false;
    }

    function delete(){
        $query = "DELETE FROM comments WHERE id = ?";

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