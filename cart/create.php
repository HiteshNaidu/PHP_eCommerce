<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php';
include_once '../objects/cart.php';
 
$database = new Database();
$db = $database->getConnection();
 
$cart = new Cart($db);
 
$data = json_decode(file_get_contents("php://input"));
 
if(!empty($data->id) && !empty($data->productId) && !empty($data->userId) && !empty($data->quantities)){
    $cart->id = $data->id;
    $cart->productId = $data->productId;
    $cart->userId = $data->userId;
    $cart->quantities = $data->quantities;

    $cart->created = date('Y-m-d H:i:s');
 
    if($cart->create()){
        http_response_code(201);
 
        echo json_encode(array("message" => "Cart was created."));
    }
    else{
        http_response_code(503);
 
        echo json_encode(array("message" => "Unable to create cart."));
    }
}
else{
    http_response_code(400);
 
    echo json_encode(array("message" => "Unable to create cart. Data is incomplete."));
}
?>