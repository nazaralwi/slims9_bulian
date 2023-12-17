<?php
defined('INDEX_AUTH') or die('Direct access not allowed!');

// IP based access limitation
require LIB . 'ip_based_access.inc.php';
do_checkIP('smc');
do_checkIP('smc-membership');
// Start the session
require SB . 'admin/default/session.inc.php';
// Set dependencies
require SIMBIO . 'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO . 'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO . 'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO . 'simbio_DB/datagrid/simbio_dbgrid.inc.php';
require DRRB . DS . 'helper/helper.php';
// End dependencies

// Privileges checking
$can_read = utility::havePrivilege('membership', 'r');

if (!$can_read) {
    die('<div class="errorBox">' . __('You are not authorized to view this section') . '</div>');
}

$page_title = 'Reservasi Ruang Diskusi';

$meta = $sysconf['selfRegistration'] ?? [];
if (!is_array($meta)) {
    $meta = [];
}

updateReservation(getCurrentUrl(['memberList' => 1]));
reserveScheduleOnsite(getCurrentUrl(['memberList' => 1]));
cancelReservation(getCurrentUrl(['memberList' => 1]));

?>

<div class="menuBox">
    <div class="menuBoxInner memberIcon">
        <div class="per_title">
            <h2><?= $page_title ?></h2>
        </div>
        <div class="sub_section">
            <div class="btn-group">
                <a href="<?= getCurrentUrl(['reservedScheduleList' => 1]) ?>" class="btn btn-primary">Daftar Jadwal Reservasi</a>
                <a href="<?= getCurrentUrl(['onsiteReservation' => 1]) ?>" class="btn btn-success">Reservasi Onsite</a>
            </div>
        </div>
    </div>
</div>

<?php
$dirPermissionError = dirCheckPermission();
if (!empty($dirPermissionError)) {
    die('<div class="errorBox">' . $dirPermissionError . '</div>');
}

switch (true) {
    case count($meta) === 0:
    case isset($_GET['onsiteReservation']) && count($meta) > 0:
        include __DIR__ . '/admin/Controllers/onsite_reservation_controller.inc.php';
        break;

    case isset($_GET['reservedScheduleList']) && count($meta) > 0:
        include __DIR__ . '/admin/Views/reserved_schedule_grid.inc.php';
        break;

    case (isset($_POST['detail']) || (isset($_GET['action']) && $_GET['action'] == 'detail')) && count($meta) > 0:
        include __DIR__ . '/admin/Views/reserved_schedule_edit.inc.php';
        break;

    default:
        include __DIR__ . '/admin/Views/reserved_schedule_grid.inc.php';
        break;
}
?>
<script>
    document.querySelectorAll('.editLink').forEach((el) => {
        el.href = el.getAttribute('href').replace(/(\&memberList=1)/g, '');
    });

    const form = document.querySelector('.simbio_form_maker');
    if (form !== null) {
        form.setAttribute('action', '<?= getCurrentUrl() ?>');
    }
</script>