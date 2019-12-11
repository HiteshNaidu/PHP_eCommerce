<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
include_once '../config/database.php';
include_once '../objects/user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
 
$user->id = isset($_GET['id']) ? $_GET['id'] : die();
 
$user->readSingleUser();
 
if($user->id!=null){
    $user_arr = array(
        "id" =>  $user->id,
        "email" => $user->email,
        "username" => $user->username,
        "password" => $user->password,
        "shippingAddress" => $user->shippingAddress,
        "purchaseHistory" => $user->purchaseHistory
    );
 
    http_response_code(200);
 
    echo json_encode($user_arr);
}
 
else{
    http_response_code(404);
 
    echo json_encode(array("message" => "user does not exist."));
}
?>