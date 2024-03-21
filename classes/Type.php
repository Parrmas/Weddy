<?php


class Type
{
    // Specifics
    private $tableName = 'types';

    // Properties
    private $id, $name, $type, $count, $price, $note;

    // Constructor
    public function __construct() {}

    // CRUD
    public function add()
    {
        // Get connection
        $db = DbConnection::getInstance()->getConnection();
        // Query
        try {
            $stmt = $db->prepare("INSERT INTO " . $this->tableName . "(name, type, count, price, note) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiis", $this->getName(), $this->getType(), $this->getCount(), $this->getPrice(), $this->getNote());
            $stmt->execute();
        } catch (Exception $e) {
            error_log("Error adding Type: " . $e->getMessage());
            throw $e;
        }
    }

    public function edit()
    {
        // Get connection
        $db = DbConnection::getInstance()->getConnection();
        // Query
        try {
            $stmt = $db->prepare("UPDATE " . $this->tableName . " SET name = ?, type = ?, count = ?, price = ?, note = ? WHERE id = :id");
            $stmt->bind_param("ssiisi",
                $this->getName(),
                $this->getType(),
                $this->getCount(),
                $this->getPrice(),
                $this->getNote(),
                $this->getId());
            $stmt->execute();
        } catch (Exception $e) {
            error_log("Error edit Type: " . $e->getMessage());
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
            $type = new Type(); // Initiate new Object
            $type->convertToObjectClass($result); //Convert MySQLI Object to Object Class
            return $type;
        } catch (Exception $e) {
            error_log("Error getting Type details: " . $e->getMessage());
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
            error_log("Error deleting Type: " . $e->getMessage());
            throw $e;
        }
    }

    public static function toList()
    {
        // Get connection
        $db = DbConnection::getInstance()->getConnection();
        // Query
        try {
            $stmt = $db->prepare("SELECT * FROM types");
            $stmt->execute();
            $result = $stmt->get_result();
            // Converting records from results into Dish Array
            $list = array();
            foreach ($result as $row) {
                $type = new Type(); // Initiate new Object
                $type->convertToObjectClass($row); // Convert MySQLI object to Object Class
                $list[] = $type;
            }
            return $list;
        } catch (Exception $e) {
            error_log("Error getting list of Types: " . $e->getMessage());
            throw $e;
        }
    }

    // Gets; Sets
    public function setName($name) { $this->name = $name; }
    public function setType($type) { $this->type = $type; }
    public function setCount($count) { $this->count = $count; }
    public function setPrice($price) { $this->price = $price; }
    public function setNote($note) { $this->note = $note; }
    public function setId($id) { $this->id = $id; }
    public function getName() { return $this->name; }
    public function getType() { return $this->type; }
    public function getCount() { return $this->count; }
    public function getPrice() { return $this->price; }
    public function getNote() { return $this->note; }
    public function getId() { return $this->id; }

    // Customized Functions
    public function convertToObjectClass($object)
    {
        try {
            $this->setId($object['id']);
            $this->setName($object['name']);
            $this->setType($object['type']);
            $this->setCount($object['count']);
            $this->setPrice($object['price']);
        } catch (Exception $e) {
            error_log("Error converting MySQLI class to Dish: " . $e->getMessage());
            throw $e;
        }
    }

    public function setDish($name, $type, $count, $price){
        try {
            $this->setName($name);
            $this->setType($type);
            $this->setCount($count);
            $this->setPrice($price);
        } catch (Exception $e) {
            error_log("Error setting Type values: " . $e->getMessage());
            throw $e;
        }
    }
}
?>