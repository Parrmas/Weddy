<?php


class DbConnection
{
    // Properties
    private static $instance = null;
    private $connection;

    // Constructor
    public function __construct(){
        // Create db connection & choose db
        try {
            $this->connection = mysqli_connect('localhost', 'lbtpdijm_weddy', 'Admin@123$%') or
            die ('Unable to connect. Check your connection parameters.');
            mysqli_select_db($this->connection, 'lbtpdijm_weddy') or die(mysqli_error($this->connection));
            $this->connection->set_charset("utf8mb4"); // Set db charset
        } catch (Exception $e){
            error_log("Error connecting to database: " . $e->getMessage());
            throw $e;
        }
    }

    // Get Instance
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DbConnection();
        }
        return self::$instance;
    }

    // Get connection when needed
    public function getConnection()
    {
        return $this->connection;
    }
}
?>