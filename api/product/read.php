<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    // Conexão com o banco de dados

    include_once '../config/database.php';
    include_once '../objects/product.php';

    // Instanciar o banco de dados e o objeto produto
    $database = new Database();
    $db = $database->getConnection();

    // Iniciar o objeto
    $product = new Product($db);

    // Query nos produtos
    $stmt = $product->read();
    $num = $stmt->rowCount();

    echo $num . "\n";

    if($num > 0) {
        
        // Array de produtos
        $products_array = array();
        $products_array["records"] = array();

        // Recuperar a tabela de conteúdos
        // fetch() é mais rápido que fetchAll()
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Extrair a linha, isto vai fazer $row['name'] ser somente $name
            extract($row);

            $product_item = array(
                "id" => $id,
                "name" => $name,
                "description" => html_entity_decode($description),
                "price" => $price,
                "category_id" => $category_id,
                "category_name" => $category_name
            );

            array_push($products_array["records"], $product_item);
        }

        // Setar o código de resposta - 200 OK
        http_response_code(200);

        // Mostrar os dados do produto no formato json
        echo json_encode($products_array);
    }
    else {
        
        // Setar o código de resposta - 400 Not found
        http_response_code(400);

        echo json_encode(array("message" => "Não foram encontrados produtos."));
    }
?>