<?php
// Set dependencies
// require SIMBIO . 'simbio_GUI/table/simbio_table.inc.php';
// require SIMBIO . 'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
// require SIMBIO . 'simbio_GUI/paging/simbio_paging.inc.php';
// require SIMBIO . 'simbio_DB/datagrid/simbio_dbgrid.inc.php';
// require DRRB . DS . 'helper/helper.php';
// End dependencies

use DiscussionRoomReservation\Lib\Url;

$page_title = 'Reservasi Ruang Diskusi';

updateReservation(Url::adminSection('/memberList'));
reserveScheduleOnsite(Url::adminSection('/memberList'));
cancelReservation(Url::adminSection('/memberList'));

?>

<div class="menuBox">
    <div class="menuBoxInner memberIcon">
        <div class="per_title">
            <h2><?= $page_title ?></h2>
        </div>
        <div class="sub_section">
            <div class="btn-group">
                <a href="<?= Url::adminSection('/reservedScheduleList') ?>" class="btn btn-primary">Daftar Jadwal Reservasi</a>
                <a href="<?= Url::adminSection('/onsiteReservation') ?>" class="btn btn-success">Reservasi Onsite</a>
            </div>
        </div>
    </div>
</div>
