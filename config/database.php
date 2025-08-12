<?php 
class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $name = 'fooddelivery_dataset';
    private $conn;
    private $query;

    public function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->name};charset=utf8";
        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    // Prepare query SQL
    public function query($sql) {
        $this->query = $this->conn->prepare($sql);
    }

    // Bind values to the SQL statement
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->query->bindValue($param, $value, $type);
    }

    // Execute query SQL
    public function execute() {
        return $this->query->execute();
    }

    // Fetch all results
    public function resultSet() {
        $this->execute();
        return $this->query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch a single result
    public function single() {
        $this->execute();
        return $this->query->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch the number of affected rows
    public function rowCount() {
        return $this->query->rowCount();
    }

    // Get the ID of the last inserted row
    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }
}

?>