<?php
require DRRB .DS. 'lib/vendor/autoload.php';
require DRRB .DS. 'app/models/Reservation.php';

function reserveScheduleOnsite($self)
{
    if (isset($_POST['onsiteReservation']))
    {
        $reservation = new Reservation();

        $reservation->name = $_POST['name'];
        $reservation->studentId = $_POST['studentId'];
        $reservation->major = $_POST['major'];
        $reservation->whatsAppNumber = $_POST['whatsAppNumber'];
        $reservation->duration = $_POST['duration'];
        $reservation->visitorNumber = $_POST['visitorNumber'];
        $reservation->activity = $_POST['activity'];
    
        $reservation->reservation_date = date('Y-m-d H:i:s');
    
        if ($reservation->save())
        {
            utility::jsToastr('Reservasi Onsite', 'Berhasil melakukan reservasi', 'success');
            echo '<script>parent.$("#mainContent").simbioAJAX("'.$self.'")</script>';
        }
        else
        {
            utility::jsToastr('Reservasi Onsite', 'Gagal melakukan reservasi', 'error');
        }
        exit;
    }
} 

function reserveSchedule()
{
    $reservation = new Reservation();

    $reservation->name = $_POST['name'];
    $reservation->studentId = $_POST['studentId'];
    $reservation->major = $_POST['major'];
    $reservation->whatsAppNumber = $_POST['whatsAppNumber'];
    $reservation->reservedDate = $_POST['reservationDate'];
    $reservation->duration = $_POST['duration'];

    $timeRange = $_POST['availableSchedule'];
    $times = explode(" - ", $timeRange);
    $reservation->startTime = $times[0];
    $reservation->endTime = $times[1];
    $reservation->reservationDocument = '';

    $reservation->visitorNumber = $_POST['visitorNumber'];
    $reservation->activity = $_POST['activity'];

    $reservation->reservation_date = date('Y-m-d H:i:s');

    if ($reservation->save())
    {
        echo '<script type="text/javascript">';
        echo 'alert("Reservasi berhasil.");';
        echo 'location.href = \'index.php?p=reservasi_ruang_diskusi\';';
        echo '</script>';
        exit();
    }
    else
    {
        echo '<script type="text/javascript">';
        echo 'location.href = \'index.php?p=reservasi_ruang_diskusi\';';
        echo '</script>';
        exit();
    }
}

function updateReservation($self)
{
    if (isset($_POST['updateRecordID']) && isset($_POST['updateReservationData']))
    {
        global $dbs;

        $updateRecordID = $dbs->escape_string($_POST['updateRecordID']);
        $reservation = Reservation::getById($updateRecordID);

        if ($reservation) {
            $map = [
                'name' => 'name', 'studentId' => 'studentId', 'major' => 'major', 
                'whatsAppNumber' => 'whatsAppNumber', 'duration' => 'duration',
                'visitorNumber' => 'visitorNumber', 'activity' => 'activity',
            ];

            foreach ($map as $key => $property) {
                if (isset($_POST[$key])) {
                    $reservation->$property = str_replace(['"'], '', strip_tags($_POST[$key]));
                }
            }

            if ($reservation->update()) {
                utility::jsToastr('Onsite Reservation', 'Berhasil memperbarui data reservasi', 'success');
                echo '<script>parent.$("#mainContent").simbioAJAX("'.MWB.'membership/index.php")</script>';
                exit;
            } else {
                utility::jsToastr('Onsite Reservation', 'Gagal menyimpan data reservasi', 'error');
                exit;
            }
        } else {
            echo "Reservation not found.";
            exit;
        }
    }
}

function cancelReservation($self)
{
    if (isset($_POST['itemID']) && !empty($_POST['itemID']) && isset($_POST['itemAction']))
    {
        $fail = 0;

        foreach ($_POST['itemID'] as $itemID) {
            $delete = Reservation::deleteById($itemID);

            if (!$delete) {
                $fail++;
            }
        }

        if (!$fail) {
            utility::jsToastr('Onsite Reservation', 'Berhasil membatalkan reservasi', 'success');
            echo '<script>parent.$("#mainContent").simbioAJAX("'.$self.'")</script>';
            exit;
        } else {
            utility::jsToastr('Onsite Reservation', 'Gagal membatalkan reservasi', 'error');
            exit;
        }
    }
}

function getCurrentUrl($query = [])
{
    
    return $_SERVER['PHP_SELF'] . '?' . http_build_query(array_merge(['mod' => $_GET['mod'], 'id' => $_GET['id']], $query));
}

function dirCheckPermission()
{
    $msg = '';
    if (!is_writable(SB.'lib'.DS.'contents'.DS))
    {
        $msg = 'Direktori : <b>'.SB.'lib'.DS.'contents'.DS.'</b> tidak dapat ditulis!. Harap merubah permission pada folder tersebut.';
    }

    return $msg;
}