<?php

class Reservation {
    public $reservationId;
    public $name;
    public $studentId;
    public $major;
    public $whatsAppNumber;
    public $reservedDate;
    public $duration;
    public $startTime;
    public $endTime;
    public $reservationDocumentId;
    public $visitorNumber;
    public $activity;
    public $reservation_date;

    public $fileId;
    public $uploaderId;
    public $fileTitle;
    public $fileName;
    public $fileURL;
    public $fileDir;
    public $fileDesc;
    public $fileKey;
    public $mimeType;
    public $inputDate;
    public $lastUpdate;

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

        $sql = "SELECT name, reserved_date, start_time, end_time, activity FROM room_reservations";
        $result = $dbs->query($sql);

        $events = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Create Reservation objects manually and populate them with fetched data
                $reservation = new Reservation();
                $reservation->name = $row['name'];
                $reservation->reservedDate = $row['reserved_date'];
                $reservation->startTime = $row['start_time'];
                $reservation->endTime = $row['end_time'];
                $reservation->activity = $row['activity'];
    
                $events[] = $reservation;
            }
        }

        return $events;
    }

    public static function getBookedSchedules() {
        global $dbs;

        $sql = "SELECT reserved_date, start_time, end_time FROM room_reservations";
        $result = $dbs->query($sql);

        $schedule = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // return as mapped schedule instead of Reservation's object
                $schedule[] = [
                    'start_date' => $row['reserved_date'],
                    'end_date' => $row['reserved_date'],
                    'start_time' => $row['start_time'],
                    'end_time' => $row['end_time'],
                ];
            }
        }

        return $schedule;
    }

    public static function getBookedSchedules1() {
        global $dbs;

        $sql = "SELECT reserved_date, start_time, end_time FROM room_reservations";
        $result = $dbs->query($sql);

        $schedule = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // return as mapped schedule instead of Reservation's object
                $schedule[] = [
                    'start_date' => $row['reserved_date'],
                    'end_date' => $row['reserved_date'],
                    'start_time' => $row['start_time'],
                    'end_time' => $row['end_time'],
                ];
            }
        }

        return $schedule;
    }

    public function save() {
        global $dbs;

        $sql = "INSERT INTO room_reservations (name, student_id, major, whatsapp_number, reserved_date, duration, start_time, end_time, reservation_document_id, visitor_number, activity, reservation_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $dbs->prepare($sql);
        $stmt->bind_param("ssssssssiiss", $this->name, $this->studentId, $this->major, $this->whatsAppNumber, $this->reservedDate, $this->duration, $this->startTime, $this->endTime, $this->reservationDocumentId, $this->visitorNumber, $this->activity, $this->reservation_date);
        
        // Check if the reservation already exists before inserting
        $existingReservation = $this->checkExistingReservation();

        if ($existingReservation) {
            // A reservation already exists with the same date, start time, and end time
            return ["success" => false, "message" => "Error: This schedule is already reserved."]; // You might also handle this case as needed (e.g., provide an error message)
        }    

        // Proceed with the insertion if no existing reservation is found
        if ($stmt->execute()) {
            $this->reservationId = $stmt->insert_id;
            return ["success" => true, "message" => "Reservation saved successfully."];
        } else {
            return ["success" => false, "message" => "Error: Failed to insert reservation."];
        }
    }

    public function insertFile() {
        global $dbs;

        $sql = "INSERT INTO files (uploader_id, file_title, file_name, file_url, file_dir, file_desc, file_key, mime_type, input_date, last_update) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $dbs->prepare($sql);
        $stmt->bind_param("ssssssssss", $this->uploaderId, $this->fileTitle, $this->fileName, $this->fileURL, $this->fileDir, $this->fileDesc, $this->fileKey, $this->mimeType, $this->inputDate, $this->lastUpdate);

        if ($stmt->execute()) {
            $insertId = $stmt->insert_id;
            $this->fileId = $insertId;
            return ["success" => true, "message" => "File uploaded successfully.", "insert_id" => $insertId];
        } else {
            return ["success" => false, "message" => "Error: Failed to upload file.", "insert_id" => 0];
        }
    }

    public function associateFileWithReservation() {
        global $dbs;
        
        $sql = "UPDATE room_reservations SET reservation_document_id = ? WHERE reservation_id = ?";
        $stmt = $dbs->prepare($sql);
        $stmt->bind_param("ii", $this->reservationDocumentId, $this->reservationId);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function checkExistingReservation() {
        global $dbs;
    
        $sql = "SELECT * FROM room_reservations 
        WHERE reserved_date = ? 
        AND (
            (start_time <= ? AND end_time >= ?) OR            -- Case: New reservation overlaps existing
            (start_time >= ? AND end_time <= ?) OR            -- Case: New reservation is within existing
            (start_time < ? AND end_time > ?) OR            -- Case: New reservation's start_time is within existing
            (start_time < ? AND end_time > ?)               -- Case: New reservation's end_time is within existing
        )";
    
        $stmt = $dbs->prepare($sql);
        $stmt->bind_param("sssssssss",
            $this->reservedDate, 
            $this->startTime, $this->endTime,                  // For overlapping case
            $this->startTime, $this->endTime,                  // For new reservation within existing
            $this->startTime, $this->startTime,                // For new reservation's start_time within existing
            $this->endTime, $this->endTime                     // For new reservation's end_time within existing
        );
        $stmt->execute();
    
        $result = $stmt->get_result();
        $existingReservations = $result->fetch_all(MYSQLI_ASSOC);
    
        return $existingReservations; // Returns existing reservation data if found, otherwise returns an empty array
    }    

    public function update() {
        global $dbs;

        $sql = "UPDATE room_reservations SET name=?, student_id=?, major=?, whatsapp_number=?, reserved_date=?, duration=?, start_time=?, end_time=?, reservation_document_id=?, visitor_number=?, activity=? WHERE id=?";
        
        $stmt = $dbs->prepare($sql);
        $stmt->bind_param("sssssissiisi", $this->name, $this->studentId, $this->major, $this->whatsAppNumber, $this->reservedDate, $this->duration, $this->startTime, $this->endTime, $this->reservationDocumentId, $this->visitorNumber, $this->activity, $this->reservationId);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public static function deleteById($reservationId) {
        global $dbs;

        $sql = "DELETE FROM room_reservations WHERE reservation_id = ?";
        
        $stmt = $dbs->prepare($sql);
        $stmt->bind_param("i", $reservationId);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}