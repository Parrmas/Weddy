<?php


interface BookingObserver {
    public function bookingSuccess(\SplSubject $subject);
    public function updateConfirm(\SplSubject $subject);
    public function updatePaid(\SplSubject $subject);
}
?>