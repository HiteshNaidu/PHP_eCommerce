<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
include_once '../config/database.php';
include_once '../objects/cart.php';
 
$database = new Database();
$db = $database->getConnection();
 
$cart = new Cart($db);
 
$cart->id = isset($_GET['id']) ? $_GET['id'] : die();
 
$cart->readSingleCart();
 
if($cart->id!=null){
    $cart_arr = array(
        "id" =>  $cart->id,
        "productId" => $cart->productId,
        "userId" => $cart->userId,
        "quantities" => $cart->quantities
    );
 
    http_response_code(200);
 
    echo json_encode($cart_arr);
}
 
else{
    http_response_code(404);
 
    echo json_encode(array("message" => "Cart does not exist."));
}
?>