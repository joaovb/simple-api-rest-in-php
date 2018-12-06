<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Method: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


//Realiza conexão com banco de dados.
include_once '../config/database.php';

//Instância objeto do produto
include_once '../objects/product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

//obtém dados
$data = json_decode(file_get_contents("php://input"));

//verifica se os dados não estão vazios
if(
    !empty($data->name) &&
    !empty($data->price) &&
    !empty($data->description) &&
    !empty($data->category_id)
){
    //defini valores da propriedade do produto
    $product->name = $data->name;
    $product->price = $data->price;
    $product->description = $data->description;
    $product->category_id = $data->category_id;
    $product->created = date('Y-m-d H:i:s');

    //cria o produto
    if($product->create()){

        //defini código de resposta 201
        http_response_code(201);

        //informa ao usuário
        echo json_encode(array("message" => "Produto criado"));
    }

    //se não for possível cria o produto, informe o usuário
    else{
        //defini código de resposta 503 - serviço indisponível
        http_response_code(503);

        //informa ao usuário
        echo json_encode(array("message" => "Não é posivel criar o produto"));
    }
}

//informa os dados dos usuários incompletos
else{
    //defini código de resposta 400 - pedido incorreto
    http_response_code(400);

    //informa ao usuário
    echo json_encode(array("message" => "Não é possível criar o produto.Os dados estão incompletos"));
}
