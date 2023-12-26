<?php
defined('INDEX_AUTH') OR die('Direct access not allowed!');

// IP based access limitation
require LIB . 'ip_based_access.inc.php';
do_checkIP('smc');
do_checkIP('smc-membership');

// start the session
// Set dependencies
require SB . 'admin/default/session.inc.php';
require SIMBIO . 'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO . 'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO . 'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO . 'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require DRRB . DS . 'app/helper/reservation_utils.php';
// End dependencies

// privileges checking
$can_read = utility::havePrivilege('membership', 'r');

if (!$can_read) {
    die('<div class="errorBox">' . __('You are not authorized to view this section') . '</div>');
}

use DiscussionRoomReservation\Lib\Url;

$page_title = 'Reservasi Ruang Diskusi';

updateStatusForExpiredReservations();

updateReservation(Url::adminSection('/reservationScheduleList'));
reserveScheduleOnsite(Url::adminSection('/reservationScheduleList'));
cancelReservation(Url::adminSection('/reservationScheduleList'));
?>

<div class="menuBox">
    <div class="menuBoxInner memberIcon">
        <div class="per_title">
            <h2><?= $page_title ?></h2>
        </div>
        <div class="sub_section">
            <div class="btn-group">
                <a href="<?= Url::adminSection('/reservationScheduleList') ?>" class="btn btn-primary">Daftar Jadwal Reservasi</a>
                <a href="<?= Url::adminSection('/reservationScheduleHistoryList') ?>" class="btn btn-primary">Daftar Riwayat Reservasi</a>
                <a href="<?= Url::adminSection('/onsiteReservation') ?>" class="btn btn-success">Reservasi Onsite</a>
            </div>
        </div>
    </div>
</div>

<?php
switch (true) {
    case isset($_GET['sec']) && $_GET['sec'] == '/onsiteReservation':
        include __DIR__ . '/admin/onsite_reservation_form.inc.php';
        break;

    case isset($_GET['sec']) && $_GET['sec'] == '/reservationScheduleList':
        include __DIR__ . '/admin/onsite_reservation_grid.inc.php';
        break;

    case isset($_GET['sec']) && $_GET['sec'] == '/reservationScheduleHistoryList':
        include __DIR__ . '/admin/onsite_reservation_history_grid.inc.php';
        break;

    case (isset($_POST['detail']) || (isset($_GET['sec']) && $_GET['sec'] == '/editReservation')):
        include __DIR__ . '/admin/onsite_reservation_edit.inc.php';
        break;
    
    default:
        include __DIR__ . '/admin/onsite_reservation_grid.inc.php';
        break;
}
?>
<script>
    document.querySelectorAll('.editLink').forEach((el) => {
        el.href = el.getAttribute('href').replace(/(\&sec=%2FreservationScheduleList)/g, '');
    });

    const form = document.querySelector('.simbio_form_maker');
    if (form !== null) {
        form.setAttribute('action', '<?= Url::adminSection('/editReservation') ?>');
    }
</script>