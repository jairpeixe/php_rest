<?php
    // Headers necessários
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // Setando a configuração do banco de dados
    include_once '../config/database.php';

    // Instanciar o objeto produto
    include_once '../objects/product.php';

    $database = new Database();
    $db = $database->getConnection();

    $product = new Product($db);

    // Capturar dados vindos do POST
    $data = json_decode(file_get_contents("php://input"));

    // Verificar se os dados não estão vazios
    if(!empty($data->name) && !empty($data->price) && !empty($data->description) && !empty($data->category_id)) {
        
        // Configurar valores da propriedade
        $product->name = $data->name;
        $product->price = $data->price;
        $product->description = $data->description;
        $product->category_id = $data->category_id;
        $product->created = date('Y-m-d H:i:s');

        if($product->create()) {

            // Setar a resposta para o código - 201 created
            http_response_code(201);

            // Notificar o usuário
            echo json_encode(array("message" => "Product was created."));
        }
        // Se for impossível de criar o produto, notificar o usuário.
        else {
            // Setar a resposta para o código - 503 service unavailable
            http_response_code(503);

            // notificar o usuário 
            echo json_encode(array("message" => "Unable to create product."));
        }
    }
    // Notificar o usuário que os dados estão incompletos
    else {
        // Setar a resposta para o código - 400 bad request
        http_response_code(400);

        // notificar o usuário
        echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
    }
?>