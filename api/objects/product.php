<?php 
    class Product {

        // Conexão com o banco de dados e nome da tabela
        private $conn;
        private $table_name = "products";

        // Propriedades do objeto
        public $id;
        public $name;
        public $description;
        public $price;
        public $category_id;
        public $category_name;
        public $created;

        // Construtor com o parametro $db como conexão
        public function __construct($db) {
            $this->conn = $db;
        }
        
        function read() {

            // Query SELECT tudo
            $query = "SELECT
                        c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                      FROM  
                        " . $this->table_name . " p 
                        LEFT JOIN 
                            categories c 
                                ON p.category_id = c.id 
                      ORDER BY 
                        p.created DESC";
            
            //$query = "SELECT * FROM " . $this->table_name; 
            
            // Preparar a query
            $stmt = $this->conn->prepare($query);

            // Executar a query
            $stmt->execute();

            return $stmt;
        }
    }