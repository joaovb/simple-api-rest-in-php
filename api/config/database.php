<?php

class Database{
    //Especificando as credenciais de acesso ao banco de dados.
    private $host = "localhost";
    private $db_name = "api_db";
    private $username = "root";
    private $password = "";

    //faz a conexão com o banco de dados.
    public function getConnection(){
        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" .$this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Erro de conexão: " .$exception->getMessage();
        }
        return $this->conn;

    }
}
?>