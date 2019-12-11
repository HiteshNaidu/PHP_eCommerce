<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/comment.php';

$database = new Database();
$db = $database->getConnection();

$comment = new Comment($db);

$stmt = $comment->read();
$num = $stmt->rowCount();

if($num > 0){
    $comments_arr = array();
    $comments_arr["comments"] = array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $comment_item=array(
            "id" => $id,
            "imageURL" => $imageURL,
            "productId" => $productId,
            "rating" => $rating,
            "text" => $text,
            "userId" => $userId
        );
 
        array_push($comments_arr["comments"], $comment_item);
    }

    http_response_code(200);

    echo json_encode($comments_arr);
}
else{
    http_response_code(404);

    echo json_encode(
        array("message" => "No comments found.")
    );
}