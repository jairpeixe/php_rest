<?php
    class Database {

        // Especifique as credencias de acesso ao banco de dados
        private $host = "localhost";
        private $db_name = "api_db";
        private $username = "root";
        private $password = "root";

        public $conn;

        // Iniciando a conexão do banco de dados
        public function getConnection() {

            $this->conn = null;

            try {
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                $this->conn->exec("set names utf8");
            } catch (PDOException $exception) {
                echo "Connection error: " . $exception->getMessage();
            }

            return $this->conn;
        }
    }
?>