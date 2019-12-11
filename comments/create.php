<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php';
include_once '../objects/comment.php';
 
$database = new Database();
$db = $database->getConnection();
 
$comment = new Comment($db);
 
$data = json_decode(file_get_contents("php://input"));
 
if(!empty($data->id) && !empty($data->imageURL) && !empty($data->productId) && !empty($data->rating) && !empty($data->text) && !empty($data->userId)){
    $comment->id = $data->id;
    $comment->imageURL = $data->imageURL;
    $comment->productId = $data->productId;
    $comment->rating = $data->rating;
    $comment->text = $data->text;
    $comment->userId = $data->userId;

    $comment->created = date('Y-m-d H:i:s');
 
    if($comment->create()){
        http_response_code(201);
 
        echo json_encode(array("message" => "Comment was created."));
    }
    else{
        http_response_code(503);
 
        echo json_encode(array("message" => "Unable to create comment."));
    }
}
else{
    http_response_code(400);
 
    echo json_encode(array("message" => "Unable to create comment. Data is incomplete."));
}
?>