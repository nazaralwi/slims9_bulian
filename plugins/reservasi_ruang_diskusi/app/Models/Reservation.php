<?php

class Reservation {
    // Properties representing the table columns
    public $id;
    public $name;
    public $studentId;
    public $major;
    public $whatsAppNumber;
    public $visitorNumber;
    public $activity;
    public $reservation_date;

    // Method to get a reservation by ID
    public static function getById($reservationId) {
        global $dbs; // Assuming $dbs is your database connection

        $sql = "SELECT * FROM onsite_reservation WHERE id = ?";
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

    // Method to retrieve all reservations
    public static function getAll() {
        global $dbs; // Assuming $dbs is your database connection

        $sql = "SELECT * FROM onsite_reservation";
        $result = $dbs->query($sql);

        $reservations = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object('Reservation')) {
                $reservations[] = $row;
            }
        }

        return $reservations;
    }    

    // Method to save a new reservation to the database
    public function save() {
        global $dbs; // Assuming $dbs is your database connection

        $sql = "INSERT INTO onsite_reservation (name, student_id, major, whatsapp_number, visitor_number, activity, reservation_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $dbs->prepare($sql);
        $stmt->bind_param("ssssiss", $this->name, $this->studentId, $this->major, $this->whatsAppNumber, $this->visitorNumber, $this->activity, $this->reservation_date);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Method to update an existing reservation
    public function update() {
        global $dbs; // Assuming $dbs is your database connection

        $sql = "UPDATE onsite_reservation SET name=?, student_id=?, major=?, whatsapp_number=?, visitor_number=?, activity=? WHERE id=?";
        
        $stmt = $dbs->prepare($sql);
        $stmt->bind_param("ssssisi", $this->name, $this->studentId, $this->major, $this->whatsAppNumber, $this->visitorNumber, $this->activity, $this->id);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Method to delete a reservation
    public function delete() {
        global $dbs; // Assuming $dbs is your database connection

        $sql = "DELETE FROM onsite_reservation WHERE id=?";
        
        $stmt = $dbs->prepare($sql);
        $stmt->bind_param("i", $this->id);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}