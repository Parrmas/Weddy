<?php
require_once(__DIR__ . '/BookingObserver.php');
require_once(__DIR__ . '/BookingSubject.php');
require_once(__DIR__ . '/Notification.php');
class BookingRepository
{
    // Properties
    private $db;

    // Constructor
    public function __construct($db) { $this->db = $db; }

    // Booking Management
    public function addBooking(Booking $booking)
    {
        try {
            $this->db = DbConnection::getInstance()->getConnection();
            $stmt = $this->db->prepare("INSERT INTO bookings (person_1_name, person_2_name, phone, date, amount, no_of_table, no_of_reserved_table, type_id, shift_id, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssiiiiii",
                $booking->getPerson1Name(),
                $booking->getPerson2Name(),
                $booking->getPhone(),
                $booking->getDate(),
                $booking->getAmount(),
                $booking->getNoOfTable(),
                $booking->getNoOfReservedTable(),
                $booking->getTypeId(),
                $booking->getShiftId(),
                $booking->getTotal()
            );
            $stmt->execute();
            $booking->setId($this->db->insert_id);
        } catch (Exception $e) {
            error_log("Error adding booking: " . $e->getMessage());
            throw $e;
        }
    }

    public function getAllBooking(){
        try {
            $this->db = DbConnection::getInstance()->getConnection();
            $stmt = $this->db->prepare("SELECT * FROM bookings");
            $stmt->execute();
            $result = $stmt->get_result();
            $list = array();
            foreach ($result as $row) {
                $booking = new Booking();
                $booking->convertToObjectClass($row);
                $list[] = $booking;
            }
            return @$list;
        } catch (Exception $e){
            error_log("Error getting all bookings: " . $e->getMessage());
            throw $e;
        }
    }

    public function getBookings($id){
        try {
            $this->db = DbConnection::getInstance()->getConnection();
            $stmt = $this->db->prepare("SELECT * FROM bookings WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $booking = new Booking();
            $booking->convertToObjectClass($result);
            return $booking;
        } catch (Exception $e){
            error_log("Error getting booking: " . $e->getMessage());
            throw $e;
        }
    }

    public function confirmBooking(Booking $booking){
        try {
            $this->db = DbConnection::getInstance()->getConnection();
            $stmt = $this->db->prepare("UPDATE bookings SET status = 1 WHERE id = ?");
            $stmt->bind_param("i",$booking->getId());
            $stmt->execute();
            $booking->attach(new EmailNotification());
            $booking->attach(new SmsNotification());
            $booking->setStatus(1);
        } catch (Exception $e){
            error_log("Error confirm booking: " . $e->getMessage());
            throw $e;
        }
    }

    public function confirmBookingPayment(Booking $booking){
        try {
            $this->db = DbConnection::getInstance()->getConnection();
            $stmt = $this->db->prepare("UPDATE bookings SET paid = 1 WHERE id = ?");
            $stmt->bind_param("i",$booking->getId());
            $stmt->execute();
            $booking->attach(new EmailNotification());
            $booking->attach(new SmsNotification());
            $booking->setPaid(1);
        } catch (Exception $e){
            error_log("Error confirm booking: " . $e->getMessage());
            throw $e;
        }
    }

    function calculateTotal(Booking $booking, $products){
        try {
            $room_total = $booking->calculateTotal();
            $product_total = 0;
            foreach ($products as $product) {
                if ($product instanceof Dish) $product_total += $product->getPrice();
                if ($product instanceof Service) $product_total += $product->getPrice();
            }
            return $room_total + $product_total;
        } catch (Exception $e){
            error_log("Error calculating total: " . $e->getMessage());
            throw $e;
        }
    }

    public function addProducts($booking_id, $products) { // Takes in an array of both Dish and Service
        foreach ($products as $product) {
            if ($product instanceof Dish) $this->addDish($booking_id, $product);
            if ($product instanceof Service)  $this->addService($booking_id, $product);
        }
    }

    public function getChosenProductsDetails($list) {
        $products = array();
        foreach ($list as $row) {
            if ($row['tag'] === 'dish'){
                $product = $this->getChosenDish($row['id']);
                $products[] = $product;
            }
            if ($row['tag'] === 'service'){
                $product = $this->getChosenService($row['id']);
                $products[] = $product;
            }
        }
        return $products;
    }

    // Booking - Dishes Management
    // Add Dishes details
    public function addDish($booking_id, Dish $dish)
    {
        try {
            $this->db = DbConnection::getInstance()->getConnection();
            $stmt = $this->db->prepare("INSERT INTO booking_dishes (booking_id, dish_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $booking_id, $dish->getId());
            $stmt->execute();
        } catch (Exception $e){
            error_log("Error adding dish to booking: " . $e->getMessage());
            throw $e;
        }
    }

    public function getDishes(Booking $booking)
    {
        try {
            $this->db = DbConnection::getInstance()->getConnection();
            $stmt = $this->db->prepare("SELECT dish_id FROM booking_dishes WHERE booking_id = ?");
            $stmt->bind_param("i", $booking->getId());
            $stmt->execute();
            $dishList = $stmt->get_result();
            foreach ($dishList as $dishId) {
                $stmt = $this->db->prepare("SELECT * FROM dishes WHERE id = ?");
                $stmt->bind_param("i", $dishId);
                $stmt->execute();
                $result = $stmt->get_result();
                $dish = new Dish();
                $dish->convertToObjectClass($result);
                $booking->addDish($dish);
            }
        } catch (Exception $e){
            error_log("Error getting dishes from booking: " . $e->getMessage());
            throw $e;
        }
    }

    public function getChosenDish($id)
    {
        try {
            $this->db = DbConnection::getInstance()->getConnection();
            $stmt = $this->db->prepare("SELECT * FROM dishes WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $dish = new Dish();
            $dish->convertToObjectClass($result->fetch_assoc());
            return $dish;
        } catch (Exception $e){
            error_log("Error getting dishes from booking: " . $e->getMessage());
            throw $e;
        }
    }

    // Booking - Service Management
    // Add Services details
    public function addService($booking_id, Service $service)
    {
        try {
            $this->db = DbConnection::getInstance()->getConnection();
            $stmt = $this->db->prepare("INSERT INTO booking_services (booking_id, service_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $booking_id, $service->getId());
            $stmt->execute();
        } catch (Exception $e){
            error_log("Error adding service booking: " . $e->getMessage());
            throw $e;
        }
    }

    public function getServices(Booking $booking)
    {
        try {
            $this->db = DbConnection::getInstance()->getConnection();
            $stmt = $this->db->prepare("SELECT service_id FROM booking_services WHERE booking_id = ?");
            $stmt->bind_param("i", $booking->getId());
            $stmt->execute();
            $serviceList = $stmt->get_result();
            foreach ($serviceList as $serviceId) {
                $stmt = $this->db->prepare("SELECT * FROM services WHERE id = ?");
                $stmt->bind_param("i", $serviceId);
                $stmt->execute();
                $result = $stmt->get_result();
                $service = new Service();
                $service->convertToObjectClass($result);
                $booking->addService($service);
            }
        } catch (Exception $e){
            error_log("Error getting services from booking: " . $e->getMessage());
            throw $e;
        }
    }

    public function getChosenService($id)
    {
        try {
            $this->db = DbConnection::getInstance()->getConnection();
            $stmt = $this->db->prepare("SELECT * FROM services WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $service = new Service();
            $service->convertToObjectClass($result->fetch_assoc());
            return $service;
        } catch (Exception $e){
            error_log("Error getting dishes from booking: " . $e->getMessage());
            throw $e;
        }
    }
}
?>