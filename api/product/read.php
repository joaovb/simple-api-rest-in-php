<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//inclui arquivos de conexão com o banco de dados.
include_once '../config/database.php';
include_once '../objects/product.php';

//instância banco de dados e objeto do produto.
$database = new Database();
$db = $database->getConnection();

//inicializa objeto
$product = new Product($db);


//realiza leitura dos produtos.

//query products
$stmt = $product->read();
$num = $stmt->rowCount();

//verifica se mias de 0 registro foi encontrado
if($num>0){

    //array products
    $products_array = array();
    $products_arr["records"] = array();

    //recupera o conteúdo da tabela
    //fetch() é mais rápido que fetchAll()
    //http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        //extari linha
        // isso fará $row['name']
        // apenas $name apenas
        extract($row);

        $product_item = array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => $price,
            "categoty_id" => $category_id,
            "category_name" => $category_name
        );

        array_push($products_arr["records"], $product_item);
    }

    // set código de resposta - 200 OK
    http_response_code(200);

    //exibe dados do produto no formato json
    echo json_encode($products_arr);
} else{

    //set response code - 404 Not Found
    http_response_code(404);

    //informa que nenhum produto foi encontrado
    echo json_encode(
        array("message" => "Não encontramos produtos.")
    );
}
