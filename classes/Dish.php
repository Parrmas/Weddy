<?php


class Dish extends Product
{
    // Specifics
    private $tableName = 'dishes';
    // Constructor
    public function __construct() {}

    // CRUD
    public function add()
    {
        // Get connection
        $db = DbConnection::getInstance()->getConnection();
        // Query
        try {
            $stmt = $db->prepare("INSERT INTO " . $this->tableName . "(name, price) VALUES (?, ?)");
            $stmt->bind_param("si", $this->getName(), $this->getPrice());
            $stmt->execute();
        } catch (Exception $e) {
            error_log("Error adding Dish: " . $e->getMessage());
            throw $e;
        }
    }

    public function edit()
    {
        // Get connection
        $db = DbConnection::getInstance()->getConnection();
        // Query
        try {
            $stmt = $db->prepare("UPDATE " . $this->tableName . " SET name = ?, price = ? WHERE id = ?");
            $stmt->bind_param("sii", $this->getName(), $this->getPrice(), $this->getId());
            $stmt->execute();
        } catch (Exception $e) {
            error_log("Error edit Dish: " . $e->getMessage());
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
            $dish = new Dish(); // Initiate new Object
            $dish->convertToObjectClass($result); //Convert MySQLI Object to Object Class
            return $dish;
        } catch (Exception $e) {
            error_log("Error getting Dish details: " . $e->getMessage());
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
            error_log("Error deleting Dish: " . $e->getMessage());
            throw $e;
        }
    }

    public static function toList()
    {
        // Get connection
        $db = DbConnection::getInstance()->getConnection();
        // Query
        try {
            $stmt = $db->prepare("SELECT * FROM dishes");
            $stmt->execute();
            $result = $stmt->get_result();
            // Converting records from results into Dish Array
            $list = array();
            foreach ($result as $row) {
                $dish = new Dish(); // Initiate new Object
                $dish->convertToObjectClass($row); // Convert MySQLI object to Object Class
                $list[] = $dish;
            }
            return $list;
        } catch (Exception $e) {
            error_log("Error getting list of Dishes: " . $e->getMessage());
            throw $e;
        }
    }

    // Gets; Sets
    public function setName($name) { $this->name = $name; }
    public function setPrice($price) { $this->price = $price; }
    public function setId($id) { $this->id = $id; }
    public function getName() { return $this->name; }
    public function getPrice() { return $this->price; }
    public function getId() { return $this->id; }

    // Customized Functions
    public function convertToObjectClass($object)
    {
        try {
            $this->setId($object['id']);
            $this->setName($object['dish_name']);
            $this->setPrice($object['price']);
        } catch (Exception $e) {
            error_log("Error converting MySQLI object to Dish: " . $e->getMessage());
            throw $e;
        }
    }

    public function setDish($name, $price){
        try {
            $this->setName($name);
            $this->setPrice($price);
        } catch (Exception $e) {
            error_log("Error setting Dish values: " . $e->getMessage());
            throw $e;
        }
    }
}
?>