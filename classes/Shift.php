<?php


class Shift
{
    // Specifics
    private $tableName = 'shifts';

    //Properties
    private $id, $shift_name, $start_time, $end_time;

    // Constructor
    public function __construct() {}

    // CRUD
    public function add()
    {
        // Get connection
        $db = DbConnection::getInstance()->getConnection();
        // Query
        try {
            $stmt = $db->prepare("INSERT INTO " . $this->tableName . "(shift_name, start_time, end_time) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $this->getShiftName(), $this->getStartTime(), $this->getEndTime());
            $stmt->execute();
        } catch (Exception $e) {
            error_log("Error adding Shift: " . $e->getMessage());
            throw $e;
        }
    }

    public function edit()
    {
        // Get connection
        $db = DbConnection::getInstance()->getConnection();
        // Query
        try {
            $stmt = $db->prepare("UPDATE " . $this->tableName . " SET shift_name = ?, start_time = ?, end_time = ? WHERE id = ?");
            $stmt->bind_param("sssi", $this->getShiftName(), $this->getStartTime(),$this->getEndTime(), $this->getId());
            $stmt->execute();
        } catch (Exception $e) {
            error_log("Error edit Shift: " . $e->getMessage());
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
            $shift = new Shift(); // Initiate new Object
            $shift->convertToObjectClass($result); //Convert MySQLI Object to Object Class
            return $shift;
        } catch (Exception $e) {
            error_log("Error getting Shift details: " . $e->getMessage());
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
            error_log("Error deleting Shift: " . $e->getMessage());
            throw $e;
        }
    }

    public static function toList()
    {
        // Get connection
        $db = DbConnection::getInstance()->getConnection();
        // Query
        try {
            $stmt = $db->prepare("SELECT * FROM shifts");
            $stmt->execute();
            $result = $stmt->get_result();
            // Converting records from results into Dish Array
            $list = array();
            foreach ($result as $row) {
                $shift = new Shift(); // Initiate new Object
                $shift->convertToObjectClass($row); // Convert MySQLI object to Object Class
                $list[] = $shift;
            }
            return $list;
        } catch (Exception $e) {
            error_log("Error getting list of Shifts: " . $e->getMessage());
            throw $e;
        }
    }

    // Gets; Sets
    public function setShiftName($shift_name) { $this->shift_name = $shift_name; }
    public function setStartTime($start_time) { $this->start_time = $start_time; }
    public function setEndTime($end_time) { $this->end_time = $end_time; }
    public function setId($id) { $this->id = $id; }
    public function getShiftName() { return $this->shift_name; }
    public function getStartTime() { return $this->start_time; }
    public function getEndTime() { return $this->end_time; }
    public function getId() { return $this->id; }

    // Customized Functions
    public function convertToObjectClass($object)
    {
        try {
            $this->setId($object['id']);
            $this->setShiftName($object['shift_name']);
            $this->setStartTime($object['start_time']);
            $this->setEndTime($object['end_time']);
        } catch (Exception $e) {
            error_log("Error converting MySQLI object to Shift: " . $e->getMessage());
            throw $e;
        }
    }

    public function setDish($shift_name, $start_time, $end_time){
        try {
            $this->setShiftName($shift_name);
            $this->setStartTime($start_time);
            $this->setEndTime($end_time);
        } catch (Exception $e) {
            error_log("Error setting Shift values: " . $e->getMessage());
            throw $e;
        }
    }
}
?>