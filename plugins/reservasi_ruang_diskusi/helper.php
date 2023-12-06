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

// Save Register
function reserveSchedule()
{
    global $dbs;

    // load simbio dbop
    require_once SB.'simbio2'.DS.'simbio_DB'.DS.'simbio_dbop.inc.php';

    // set up data
    $map = [
        'name' => 'name', 'studentId' => 'student_id', 
        'major' => 'major', 'whatsAppNumber' => 'whatsapp_number',
        'visitorNumber' => 'visitor_number', 'activity' => 'activity',
    ];

    $data = [];
    foreach ($map as $key => $column_name) {
        if (isset($_POST[$key]))
        {
            $data[$column_name] = $dbs->escape_string(str_replace(['"'], '', strip_tags($_POST[$key])));
        }
    }

    $data['reservation_date'] = date('Y-m-d H:i:s');

    // do insert
    // initialise db operation
    $sql = new simbio_dbop($dbs);

    // setup for insert
    $insert = $sql->insert('onsite_reservation', $data);

    if ($insert)
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
        echo 'alert("Reservasi gagal'.$sql->error.'");';
        echo 'location.href = \'index.php?p=reservasi_ruang_diskusi\';';
        echo '</script>';
        exit();
    }
}

function updateReservation()
{
    global $dbs, $sysconf;

    if (isset($_POST['updateRecordID']) && isset($_POST['updateReservationData']))
    {
        // load simbio dbop
        require_once SB.'simbio2'.DS.'simbio_DB'.DS.'simbio_dbop.inc.php';

        // initialise db operation
        $sql = new simbio_dbop($dbs);
        $updateRecId = $dbs->escape_string($_POST['updateRecordID']);

        // select data
        $dataQuery = $dbs->query('select * from onsite_reservation where id = \''.$updateRecId.'\'');

        $dataResult = ($dataQuery->num_rows > 0) ? $dataQuery->fetch_assoc() : [];

        // check status
        $map = [
            'name' => 'name', 'studentId' => 'student_id', 
            'major' => 'major', 'whatsAppNumber' => 'whatsapp_number',
            'visitorNumber' => 'visitor_number', 'activity' => 'activity',
        ];

        $data = [];
        foreach ($map as $key => $column_name) {
            if (isset($_POST[$key]))
            {
                $data[$column_name] = str_replace(['"'], '', strip_tags($_POST[$key]));
            }
        }
        
        $data['name'] = $_POST['name'];
        $data['student_id'] = $_POST['studentId'];
        $data['major'] = $_POST['major'];
        $data['whatsapp_number'] = $_POST['whatsAppNumber'];
        $data['visitor_number'] = $_POST['visitorNumber'];
        $data['activity'] = $_POST['activity'];

        $update = $sql->update('onsite_reservation', $data, "id = ".$updateRecId);

        if ($update)
        {
            utility::jsToastr('Onsite Reservation', 'Berhasil memperbarui data reservasi', 'success');
            echo '<script>parent.$("#mainContent").simbioAJAX("'.MWB.'membership/index.php")</script>';
            exit;
        }
        else
        {
            utility::jsToastr('Onsite Reservation', 'Gagal menyimpan data reservasi', 'error');
            exit;
        }

        exit;
    }
}

// cancel reservation
function cancelReservation($self)
{
    global $dbs,$meta;

    if ((isset($_POST['itemID']) AND !empty($_POST['itemID']) AND isset($_POST['itemAction'])))
    {
        // Set Table Attribute
        $table = ['onsite_reservation', "id = '{id}'"];

        // load simbio dbop
        require_once SB.'simbio2'.DS.'simbio_DB'.DS.'simbio_dbop.inc.php';

        // process delete
        // initialise db operation
        $sql = new simbio_dbop($dbs);

        // check status
        $map = [
            'name' => 'name', 'studentId' => 'student_id', 
            'major' => 'major', 'whatsAppNumber' => 'whatsapp_number',
            'visitorNumber' => 'visitor_number', 'activity' => 'activity',
        ];

        $data = [];
        foreach ($map as $key => $column_name) {
            if (isset($_POST[$key]))
            {
                $data[$column_name] = str_replace(['"'], '', strip_tags($_POST[$key]));
            }
        }
        
        $fail = 0;
        foreach ($_POST['itemID'] as $itemID) {
            $delete = $sql->delete($table[0], str_replace('{id}', $dbs->escape_string($itemID), $table[1]));

            if (!$delete)
            {
                $fail++;
            }
        }

        if (!$fail)
        {
            $data['status'] = 'Cancel';
            $insert = $sql->insert('reservation_history', $data);
            utility::jsToastr('Onsite Reservation', 'Berhail membatalkan reservasi', 'success');
            echo '<script>parent.$("#mainContent").simbioAJAX("'.$self.'")</script>';
        }
        else
        {
            utility::jsToastr('Onsite Reservation', 'Gagal membatalkan reservasi', 'error');
        }
        exit;
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
    global $dbs;

    // load simbio dbop
    require_once SB.'simbio2'.DS.'simbio_DB'.DS.'simbio_dbop.inc.php';

    // action
    if (isset($_POST['onsiteReservation']))
    {
        // set up data
        $map = [
            'name' => 'name', 'studentId' => 'student_id', 
            'major' => 'major', 'whatsAppNumber' => 'whatsapp_number',
            'visitorNumber' => 'visitor_number', 'activity' => 'activity',
        ];

        $data = [];
        foreach ($map as $key => $column_name) {
            if (isset($_POST[$key]))
            {
                $data[$column_name] = $dbs->escape_string(str_replace(['"'], '', strip_tags($_POST[$key])));
            }
        }

        $data['reservation_date'] = date('Y-m-d H:i:s');

        // do insert
        // initialise db operation
        $sql = new simbio_dbop($dbs);

        // setup for insert
        $insert = $sql->insert('onsite_reservation', $data);

        if ($insert)
        {
            // set alert
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
