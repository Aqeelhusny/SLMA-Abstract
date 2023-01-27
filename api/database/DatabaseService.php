<?php
class DatabaseService
{
    private $host = "localhost";
    private $db_name = "slma";
    private $username = "root";
    private $password = "";
    public  $conn = null;

    public  function getConnection()
    {

        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
        } catch (Exception $exception) {
            http_response_code(500);
            echo json_encode(array("message" => $exception->getMessage()));
            die();
        }
        return $this->conn;
    }
}
