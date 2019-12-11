<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
include_once '../config/database.php';
include_once '../objects/comment.php';
 
$database = new Database();
$db = $database->getConnection();
 
$comment = new Comment($db);
 
$comment->id = isset($_GET['id']) ? $_GET['id'] : die();
 
$comment->readSingleComment();
 
if($comment->id!=null){
    $comment_arr = array(
        "id" =>  $comment->id,
        "imageURL" => $comment->imageURL,
        "productId" => $comment->productId,
        "rating" => $comment->rating,
        "text" => $comment->text,
        "userId" => $comment->userId
    );
 
    http_response_code(200);
 
    echo json_encode($comment_arr);
}
 
else{
    http_response_code(404);
 
    echo json_encode(array("message" => "Comment does not exist."));
}
?>