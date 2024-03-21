<?php


class EmailNotification implements BookingObserver {
    public function bookingSuccess(\SplSubject $subject) {
        if ($subject->getId() != null) {
            error_log("Attempting to send email booking success notification...");
            // Implement email sending logic here
            error_log("Email booking success notification sent successfully.");
        }
    }

    public function updateConfirm(\SplSubject $subject) {
        if ($subject->getStatus() == 1) {
            error_log("Attempting to send email confirm notification...");
            // Implement email sending logic here
            error_log("Email confirm notification sent successfully.");
        }
    }

    public function updatePaid(\SplSubject $subject) {
        if ($subject->getStatus() == 1) {
            error_log("Attempting to send email paid notification...");
            // Implement email sending logic here
            error_log("Email paid notification sent successfully.");
        }
    }
}

class SmsNotification implements BookingObserver {
    public function bookingSuccess(\SplSubject $subject) {
        if ($subject->getId() != null) {
            error_log("Attempting to send email confirm notification...");
            // Implement email sending logic here
            error_log("Email confirm notification sent successfully.");
        }
    }

    public function updateConfirm(\SplSubject $subject) {
        if ($subject->getPaid() == 1) {
            error_log("Attempting to send SMS confirm notification...");
            // Implement SMS sending logic here
            error_log("SMS confirm notification sent successfully.");
        }
    }

    public function updatePaid(\SplSubject $subject) {
        if ($subject->getPaid() == 1) {
            error_log("Attempting to send SMS paid notification...");
            // Implement SMS sending logic here
            error_log("SMS paid notification sent successfully.");
        }
    }
}
?>