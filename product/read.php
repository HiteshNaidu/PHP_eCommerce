<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$stmt = $product->read();
$num = $stmt->rowCount();

if($num > 0){
    $products_arr = array();
    $products_arr["products"] = array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $product_item=array(
            "id" => $id,
            "description" => $description,
            "price" => $price,
            "shippingCost" => $shippingCost,
            "imageURL" => $imageURL
        );
 
        array_push($products_arr["products"], $product_item);
    }

    http_response_code(200);

    echo json_encode($products_arr);
}
else{
    http_response_code(404);

    echo json_encode(
        array("message" => "No products found.")
    );
}