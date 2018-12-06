<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');


//Realiza conexão com banco de dados e objetos
include_once '../config/database.php';
include_once '../objects/product.php';

//obtém conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

//prepara objeto do produto
$product = new Product($db);

//seta ID propriedade do registro para leitura
$product->id = isset($_GET['id']) ? $_GET['id'] : die();

//leia os detalhes do produto a ser editado
$product->readOne();

if($product->name!=null){
    //cria array
    $product_arr = array(
        "id" => $product->id,
        "name" => $product->name,
        "description" => $product->description,
        "price" => $product->price,
        "category_id" => $product->category_id,
        "category_name" => $product->category_name
    );

    //defini código de resposta - 200 OK
    http_response_code(200);

    //formata em json
    echo json_encode($product_arr);
}

else{
    //set response code - 404 não encontrado
    http_response_code(404);

    //diz ao usuário que o produto não existe
    echo json_encode(array("message" => "Produto não existe") );
}
