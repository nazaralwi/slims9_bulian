<?php

class Reservation {
    public $id;
    public $name;
    public $studentId;
    public $major;
    public $whatsAppNumber;
    public $reservedDate;
    public $duration;
    public $startTime;
    public $endTime;
    public $reservationDocument;
    public $visitorNumber;
    public $activity;
    public $reservation_date;

    public static function getById($reservationId) {
        global $dbs;

        $sql = "SELECT * FROM room_reservations WHERE id = ?";
        $stmt = $dbs->prepare($sql);
        $stmt->bind_param("i", $reservationId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $reservation = $result->fetch_object('Reservation');
            return $reservation;
        } else {
            return null;
        }
    }

    public static function getAll() {
        global $dbs;

        $sql = "SELECT * FROM room_reservations";
        $result = $dbs->query($sql);

        $reservations = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object('Reservation')) {
                $reservations[] = $row;
            }
        }

        return $reservations;
    }   
    
    public static function getAllEvents() {
        global $dbs;

        $sql = "SELECT reserved_date, start_time, end_time, activity FROM room_reservations";
        $result = $dbs->query($sql);

        $events = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Create Reservation objects manually and populate them with fetched data
                $reservation = new Reservation();
                $reservation->reservedDate = $row['reserved_date'];
                $reservation->startTime = $row['start_time'];
                $reservation->endTime = $row['end_time'];
                $reservation->activity = $row['activity'];
    
                $events[] = $reservation;
            }
        }

        return $events;
    }

    public function save() {
        global $dbs;

        $sql = "INSERT INTO room_reservations (name, student_id, major, whatsapp_number, reserved_date, duration, start_time, end_time, reservation_document, visitor_number, activity, reservation_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $dbs->prepare($sql);
        $stmt->bind_param("sssssisssiss", $this->name, $this->studentId, $this->major, $this->whatsAppNumber, $this->reservedDate, $this->duration, $this->startTime, $this->endTime, $this->reservationDocument, $this->visitorNumber, $this->activity, $this->reservation_date);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update() {
        global $dbs;

        $sql = "UPDATE room_reservations SET name=?, student_id=?, major=?, whatsapp_number=?, reserved_date=?, duration=?, start_time=?, end_time=?, reservation_document=?, visitor_number=?, activity=? WHERE id=?";
        
        $stmt = $dbs->prepare($sql);
        $stmt->bind_param("sssssisssisi", $this->name, $this->studentId, $this->major, $this->whatsAppNumber, $this->reservedDate, $this->duration, $this->startTime, $this->endTime, $this->reservationDocument, $this->visitorNumber, $this->activity, $this->id);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public static function deleteById($reservationId) {
        global $dbs;

        $sql = "DELETE FROM room_reservations WHERE id = ?";
        
        $stmt = $dbs->prepare($sql);
        $stmt->bind_param("i", $reservationId);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}