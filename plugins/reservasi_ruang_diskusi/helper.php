<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-05-08 09:15:53
 * @modify date 2022-03-28 14:07:00
 * @desc [description]
 */

use Zein\Storage\Local\Upload;

require __DIR__ . '/lib/vendor/autoload.php';
require __DIR__ . '/app/Models/Reservation.php';

// Save Register
function reserveSchedule()
{
    $reservation = new Reservation();

    $reservation->name = $_POST['name'];
    $reservation->studentId = $_POST['studentId'];
    $reservation->major = $_POST['major'];
    $reservation->whatsAppNumber = $_POST['whatsAppNumber'];
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
        // echo 'alert("Reservasi gagal'.$sql->error.'");';
        echo 'location.href = \'index.php?p=reservasi_ruang_diskusi\';';
        echo '</script>';
        exit();
    }
}

function updateReservation()
{
    if (isset($_POST['updateRecordID']) && isset($_POST['updateReservationData']))
    {
        // Assuming $dbs is your database connection
        global $dbs;

        // Get reservation by ID using the Reservation class method
        $updateRecordID = $dbs->escape_string($_POST['updateRecordID']);
        $reservation = Reservation::getById($updateRecordID);

        if ($reservation) {
            // Map POST data to reservation properties
            $map = [
                'name' => 'name', 'studentId' => 'studentId', 
                'major' => 'major', 'whatsAppNumber' => 'whatsAppNumber',
                'visitorNumber' => 'visitorNumber', 'activity' => 'activity',
            ];

            foreach ($map as $key => $property) {
                if (isset($_POST[$key])) {
                    $reservation->$property = str_replace(['"'], '', strip_tags($_POST[$key]));
                }
            }

            // Perform the update using the Reservation class method
            if ($reservation->update()) {
                utility::jsToastr('Onsite Reservation', 'Berhasil memperbarui data reservasi', 'success');
                echo '<script>parent.$("#mainContent").simbioAJAX("'.MWB.'membership/index.php")</script>';
                exit;
            } else {
                utility::jsToastr('Onsite Reservation', 'Gagal menyimpan data reservasi', 'error');
                exit;
            }
        } else {
            // Handle reservation not found
            echo "Reservation not found.";
            exit;
        }
    }
}

// cancel reservation
function cancelReservation($self)
{
    if (isset($_POST['itemID']) && !empty($_POST['itemID']) && isset($_POST['itemAction']))
    {
        // Counter for failed deletions
        $fail = 0;

        foreach ($_POST['itemID'] as $itemID) {
            // Delete reservation by ID
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

// copy template
function copyTemplate($data)
{
    if ((int)$data['selfRegistrationActive'] === 1 && !file_exists(SB.'lib'.DS.'contents'.DS.'daftar_online.inc.php'))
    {
        copy(__DIR__.DS.'daftar_online.inc.php', SB.'lib'.DS.'contents'.DS.'daftar_online.inc.php');
    }
}

// Creating Table
function createTable()
{
    global $dbs;

    // setup query
    @$dbs->query("CREATE TABLE IF NOT EXISTS `member_online` (
        `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `member_name` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
        `birth_date` date DEFAULT NULL,
        `inst_name` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
        `gender` int(1) NOT NULL,
        `member_address` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
        `member_phone` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
        `member_email` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
        `mpasswd` varchar(64) COLLATE utf8mb4_bin DEFAULT NULL,
        `input_date` date DEFAULT NULL,
        `last_update` date DEFAULT NULL
      ) ENGINE='MyISAM';");
    
}

// compose Url
function getCurrentUrl($query = [])
{
    
    return $_SERVER['PHP_SELF'] . '?' . http_build_query(array_merge(['mod' => $_GET['mod'], 'id' => $_GET['id']], $query));
}

// premission check
function dirCheckPermission()
{
    $msg = '';
    if (!is_writable(SB.'lib'.DS.'contents'.DS))
    {
        $msg = 'Direktori : <b>'.SB.'lib'.DS.'contents'.DS.'</b> tidak dapat ditulis!. Harap merubah permission pada folder tersebut.';
    }

    return $msg;
}

function reserveScheduleOnsite($self)
{
    if (isset($_POST['onsiteReservation']))
    {
        $reservation = new Reservation();

        $reservation->name = $_POST['name'];
        $reservation->studentId = $_POST['studentId'];
        $reservation->major = $_POST['major'];
        $reservation->whatsAppNumber = $_POST['whatsAppNumber'];
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
            utility::jsToastr('Reservasi Onsite', 'Gagal melakukan reservasi '.$sql->error, 'error');
        }
        exit;
    }
} 
