<?php


class Service extends Product
{
    // Specifics
    private $tableName = 'services';
    // Properties
    private $description;

    // Constructor
    public function __construct() {}

    // Functions
    // CRUD
    public function add()
    {
        // Get connection
        $db = DbConnection::getInstance()->getConnection();
        // Query
        try {
            $stmt = $db->prepare("INSERT INTO " . $this->tableName . "(name, price, description) VALUES (?, ?, ?)");
            $stmt->bind_param("sis", $this->getName(), $this->getPrice(), $this->getDescription());
            $stmt->execute();
        } catch (Exception $e) {
            error_log("Error adding Service: " . $e->getMessage());
            throw $e;
        }
    }

    public function edit()
    {
        // Get connection
        $db = DbConnection::getInstance()->getConnection();
        // Query
        try {
            $stmt = $db->prepare("UPDATE " . $this->tableName . " SET name = ?, price = ?, description = ? WHERE id = ?");
            $stmt->bind_param("sisi", $this->getName(), $this->getPrice(), $this->getDescription(), $this->getId());
            $stmt->execute();
        } catch (Exception $e) {
            error_log("Error editing Service: " . $e->getMessage());
            throw $e;
        }
    }

    public function details()
    {
        // Get connection
        $db = DbConnection::getInstance()->getConnection();
        // Query
        try {
            $stmt = $db->prepare("SELECT * FROM " . $this->tableName . " WHERE id = ?");
            $stmt->bind_param("i", $this->getId());
            $stmt->execute();
            $result = $stmt->get_result();
            $service = new Service(); // Initiate new Object
            $service->convertToObjectClass($result); //Convert MySQLI Object to Object Class
            return $service;
        } catch (Exception $e) {
            error_log("Error getting Service details: " . $e->getMessage());
            throw $e;
        }
    }

    public function delete()
    {
        // Get connection
        $db = DbConnection::getInstance()->getConnection();
        // Query
        try {
            $stmt = $db->prepare("DELETE FROM " . $this->tableName . " WHERE id = ?");
            $stmt->bind_param("i", $this->getId());
            $stmt->execute();
        } catch (Exception $e) {
            error_log("Error deleting Service: " . $e->getMessage());
            throw $e;
        }
    }

    public static function toList()
    {
        // Get connection
        $db = DbConnection::getInstance()->getConnection();
        // Query
        try {
            $stmt = $db->prepare("SELECT * FROM services");
            $stmt->execute();
            $result = $stmt->get_result();
            // Converting records from results into Service Array
            $list = array();
            foreach ($result as $row) {
                $dish = new Service(); // Initiate new Object
                $dish->convertToObjectClass($row); // Convert MySQLI Object to Object Class
                $list[] = $dish;
            }
            return $list;
        } catch (Exception $e) {
            error_log("Error getting list of Services: " . $e->getMessage());
            throw $e;
        }
    }

    // Gets; Sets
    public function setName($name) { $this->name = $name; }
    public function setPrice($price) { $this->price = $price; }
    public function setDescription($description) { $this->description = $description; }
    public function setId($id) { $this->id = $id; }
    public function getName() { return $this->name; }
    public function getPrice() { return $this->price; }
    public function getDescription() { return $this->description; }
    public function getId() { return $this->id; }

    // Customized Functions
    public function convertToObjectClass($object)
    {
        try {
            $this->setId($object['id']);
            $this->setName($object['service_name']);
            $this->setPrice($object['price']);
            $this->setDescription($object['description']);
        } catch (Exception $e) {
            error_log("Error converting MySQLI object to Service: " . $e->getMessage());
            throw $e;
        }
    }

    public function setService($name, $price, $description){
        try {
            $this->setName($name);
            $this->setPrice($price);
            $this->setDescription($description);
        } catch (Exception $e) {
            error_log("Error setting Service values: " . $e->getMessage());
            throw $e;
        }
    }
}
?>