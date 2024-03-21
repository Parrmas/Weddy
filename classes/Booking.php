<?php
require_once(__DIR__ . '/BookingObserver.php');
require_once(__DIR__ . '/BookingSubject.php');
require_once(__DIR__ . '/Notification.php');
class Booking implements BookingSubject
{
    // Observers
    private $observers;
    private $bookingStatus;
    // Properties
    private $id;
    private $person_1_name;
    private $person_2_name;
    private $phone;
    private $date;
    private $amount;
    private $no_of_table;
    private $no_of_reserved_table;
    private $type_id;
    private $shift_id;
    private $status;
    private $paid;
    private $total;
    private $fee;
    private $dishes = array();
    private $services = array();

    // Constructor
    public function __construct(){
        $this->observers = new \SplObjectStorage;
        $this->bookingStatus = false;
    }

    // Gets; Sets
    public function setId($id) { $this->id = $id; }
    public function getId() { return $this->id; }

    public function setPerson1Name($person_1_name) { $this->person_1_name = $person_1_name; }
    public function getPerson1Name() { return $this->person_1_name; }

    public function setPerson2Name($person_2_name) { $this->person_2_name = $person_2_name; }
    public function getPerson2Name() { return $this->person_2_name; }

    public function setPhone($phone) { $this->phone = $phone; }
    public function getPhone() { return $this->phone; }

    public function setDate($date) {
        $date = date_create_from_format("d/m/Y", $date);
        $date_formatted = date_format($date,"Y-m-d");
        $this->date = $date_formatted;
    }
    public function getDate() { return $this->date; }
    public function getFormattedDate() {
        return $this->formatDate($this->date);
    }

    public function setAmount($amount) { $this->amount = $amount; }
    public function getAmount() { return $this->amount; }

    public function setNoOfTable($no_of_table) { $this->no_of_table = $no_of_table; }
    public function getNoOfTable() { return $this->no_of_table; }

    public function setNoOfReservedTable($no_of_reserved_table) { $this->no_of_reserved_table = $no_of_reserved_table; }
    public function getNoOfReservedTable() { return $this->no_of_reserved_table; }

    public function setTypeId($type_id) { $this->type_id = $type_id; }
    public function getTypeId() { return $this->type_id; }

    public function setShiftId($shift_id) { $this->shift_id = $shift_id; }
    public function getShiftId() { return $this->shift_id; }

    public function setStatus($status) {
        $this->status = $status;
        if ($status == 1) {
            $this->notifyConfirm();
        }
    }
    public function getStatus() { return $this->status; }

    public function setPaid($paid) {
        $this->paid = $paid;
        if ($paid == 1) {
            $this->notifyPaid();
        }
    }
    public function getPaid() { return $this->paid; }

    public function setTotal($total) { $this->total = $total; }
    public function getTotal() { return $this->total; }

    public function setFee($fee) { $this->fee = $fee; }
    public function getFee() { return $this->fee; }

    // Setters for Dishes and Services
    public function addDish(Dish $dish) { $this->dishes[] = $dish; }
    public function addService(Service $service) { $this->services[] = $service; }

    //Getters for Dishes and Services
    public function getDishes(){ return $this->dishes; }
    public function getServices(){ return $this->services; }

    // Customs
    public function convertToObjectClass($object)
    {
        try {
            $this->setId($object['id']);
            $this->setPerson1Name($object['person_1_name']);
            $this->setPerson2Name($object['person_2_name']);
            $this->setPhone($object['phone']);
            $this->setDate($object['date']);
            $this->setAmount($object['amount']);
            $this->setNoOfTable($object['no_of_table']);
            $this->setNoOfReservedTable($object['no_of_reserved_table']);
            $this->setTypeId($object['type_id']);
            $this->setShiftId($object['shift_id']);
            $this->setStatus($object['status']);
            $this->setPaid($object['paid']);
            $this->setTotal($object['total']);
            $this->setFee($object['fee']);
        } catch (Exception $e) {
            error_log("Error converting MySQLI object to Booking: " . $e->getMessage());
            throw $e;
        }
    }

    public function setBookingData($object)
    {
        try {
            $this->setPerson1Name($object['person_1_name']);
            $this->setPerson2Name($object['person_2_name']);
            $this->setPhone($object['phone']);
            $this->setDate($object['date']);
            $this->setAmount($object['amount']);
            $this->setNoOfTable($object['no_of_table']);
            $this->setNoOfReservedTable($object['no_of_reserved_table']);
            $this->setTypeId($object['type_id']);
            $this->setShiftId($object['shift_id']);
        } catch (Exception $e) {
            error_log("Error converting MySQLI object to Booking: " . $e->getMessage());
            throw $e;
        }
    }

    public function formatDate($date){
        try {
            $dateTime = DateTime::createFromFormat('Y-m-d', $date);

            // Format the DateTime object to 'dd/mm/yyyy'
            $formattedDate = $dateTime->format('d/m/Y');

            return $formattedDate;
        } catch (Exception $e) {
            error_log("Error formatting Booking date: " . $e->getMessage());
            throw $e;
        }
    }

    public function calculateTotal(){
        // Get connection
        $db = DbConnection::getInstance()->getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM types WHERE id = ?");
            $stmt->bind_param("i", $this->getTypeId());
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $price = $row['price'];
            $total = $this->getNoOfTable() * $price;
            return $total;
        } catch (Exception $e) {
            error_log("Error calculating dishes total: " . $e->getMessage());
            throw $e;
        }
    }

    // Notify Booking
    public function attach(\SplObserver $observer) {
        $this->observers->attach($observer);
    }

    public function detach(\SplObserver $observer) {
        $this->observers->detach($observer);
    }

    public function notifyBookingSuccess() {
        foreach ($this->observers as $observer) {
            $observer->bookingSuccess($this);
        }
    }

    public function notifyConfirm() {
        foreach ($this->observers as $observer) {
            $observer->updateConfirm($this);
        }
    }

    public function notifyPaid() {
        foreach ($this->observers as $observer) {
            $observer->updatePaid($this);
        }
    }
}
?>