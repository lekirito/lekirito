<?php 

class Database {

    private $host, $username, $password, $dbName, $conn;

    function __construct() {
        $cleardbUrl = "mysql://b1e9054b6e03a7:42d68fb0@eu-cdbr-west-02.cleardb.net/heroku_bd9fb2ff7a34cac?reconnect=true";

        // Specify your own database credentials
        $this->host = parse_url($cleardbUrl, PHP_URL_HOST);
        $this->username = parse_url($cleardbUrl, PHP_URL_USER);
        $this->password = parse_url($cleardbUrl, PHP_URL_PASS);
        $this->dbName = substr(parse_url($cleardbUrl, PHP_URL_PATH), 1);
    }
  
    // Get the database connection
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbName, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            ]);
            $this->conn->exec("Set Names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
    
}

?>