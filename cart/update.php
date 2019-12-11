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

$cart->id = $data->id;
$cart->productId = $data->productId;
$cart->userId = $data->userId;
$cart->quantities = $data->quantities;

if($cart->update()){
    http_response_code(200);

    echo json_encode(array("message" => "Cart was updated."));
}
else{
    http_response_code(503);

    echo json_encode(array("message" => "Unable to update cart."));
}
?>