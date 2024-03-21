<?php
require_once(__DIR__ . '/BookingObserver.php');
require_once(__DIR__ . '/BookingSubject.php');
require_once(__DIR__ . '/Notification.php');
class Facade
{
    private $bookingRepository;

    public function __construct(BookingRepository $bookingRepository) {
        $this->bookingRepository = $bookingRepository;
    }

    public function addBooking(Booking $booking, $products) { //Takes in an combined array of both Dish and Service
        $booking_total = $this->bookingRepository->calculateTotal($booking, $products);
        $booking->setTotal($booking_total);
        $this->bookingRepository->addBooking($booking);
        $this->bookingRepository->addProducts($booking->getId(), $products);
        $booking->attach(new EmailNotification());
        $booking->attach(new SmsNotification());
        $booking->notifyBookingSuccess();
    }

    public function getAllBookings() {
        return $this->bookingRepository->getAllBooking();
    }

    public function getBookingById($id) {
        return $this->bookingRepository->getBookings($id);
    }

    public function confirmBooking(Booking $booking) {
        $this->bookingRepository->confirmBooking($booking);
    }

    public function confirmBookingPayment(Booking $booking) {
        $this->bookingRepository->confirmBookingPayment($booking);
    }

    public function addDishToBooking(Booking $booking, Dish $dish) {
        $this->bookingRepository->addDish($booking, $dish);
    }

    public function getDishesForBooking(Booking $booking) {
        return $this->bookingRepository->getDishes($booking);
    }

    public function addServiceToBooking(Booking $booking, Service $service) {
        $this->bookingRepository->addService($booking, $service);
    }

    public function getServicesForBooking(Booking $booking) {
        return $this->bookingRepository->getServices($booking);
    }
}
?>