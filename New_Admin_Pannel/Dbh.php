<?php
class Db_connector
{
    private $serverName = "localhost";
    private $Dbusername = "root";
    private $Dbpassword = "";
    private $Dbname = "life_line";     //new file

    public function getConnection()
    {
        $dsn = "mysql:host=" . $this->serverName . ";dbname=" . $this->Dbname;
        try {
            $conn = new PDO($dsn, $this->Dbusername, $this->Dbpassword);
            // Set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $ex) {
            die("Connection failed: " . $ex->getMessage());
        }
    }
}
