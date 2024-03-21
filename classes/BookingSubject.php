<?php


interface BookingSubject {
    public function attach(\SplObserver $observer);
    public function detach(\SplObserver $observer);
    public function notifyConfirm();
    public function notifyPaid();
    public function notifyBookingSuccess();
}
?>