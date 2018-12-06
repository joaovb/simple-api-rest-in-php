<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Realiza conexão com banco de dados e objetos
include_once '../config/database.php';
include_once '../objects/product.php';

//obtém conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

//prepara objeto do produto
$product = new Product($db);

//obtém id do produto a ser editado
$data = json_decode(file_get_contents("php://input"));

//seta id propriedade do produto a ser editado
$product->id = $data->id;

//defini valores da propriedade do produto
$product->name = $data->name;
$product->price = $data->price;
$product->description = $data->description;
$product->category_id = $data->category_id;


//atualiza o produto
if($product->update()){

    //seta código de resposta - 200 OK
    http_response_code(200);

    //diga ao usuário
    echo json_encode(array("message" => "Produto atualizado"));
}

//se não conseguir atualizar o produto, informe o usuário
else{

    //seta código de resposta - 503 service unavailable
    http_response_code(503);

    //informe ao usuário
    echo json_encode(array("message" => "Não é possivel atualizar o produto"));
}

