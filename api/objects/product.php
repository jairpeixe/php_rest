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

        function create() {
            
            // Query insert registro no banco de dados
            $query = "INSERT INTO " . $this->table_name . " SET name=:name, price=:price, description=:description, category_id=:category_id, created=:created";
            
            // Preparar a query
            $stmt = $this->conn->prepare($query);

            // Verificações de segurança
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->price = htmlspecialchars(strip_tags($this->price));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->created = htmlspecialchars(strip_tags($this->created));

            // Amarrar os valores
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":price", $this->price);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":category_id", $this->category_id);
            $stmt->bindParam(":created", $this->created);

            // Ececutar a query
            if($stmt->execute()) {
                return true;
            }

            return false;
        }
    }