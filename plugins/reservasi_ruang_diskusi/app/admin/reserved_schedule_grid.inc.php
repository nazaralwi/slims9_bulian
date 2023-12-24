<?php

// create datagrid
$datagrid = new simbio_datagrid();

// table spec
$table_spec = 'room_reservations';

// set column
$datagrid->setSQLColumn('reservation_id AS \''.__('ID Reservasi').'\'',
                        'reservation_date AS \''.__('Tanggal Reservasi').'\'', 
                        'name AS \''.__('Nama').'\'', 
                        'reservation_document_id AS \''.__('ID Dokumen').'\'', 
                        'student_id AS \''.__('NIM').'\'', 
                        'major AS \''.__('Jurusan').'\'',
                        'whatsapp_number AS \''.__('Nomor WhatsApp').'\'',
                        'reserved_date AS \''.__('Tanggal').'\'',
                        'duration AS \''.__('Durasi').'\'',
                        'start_time AS \''.__('Awal').'\'',
                        'end_time AS \''.__('Akhir').'\'',
                        'visitor_number AS \'' . __('Jumlah anggota') . '\'',
                        'activity AS \'' . __('Kegiatan') . '\'');

// ordering
$datagrid->setSQLorder('reservation_date DESC');

// set table and table header attributes
$datagrid->icon_edit = SWB.'admin/'.$sysconf['admin_template']['dir'].'/'.$sysconf['admin_template']['theme'].'/edit.gif';
$datagrid->table_name = 'reservationScheduleList';
$datagrid->table_attr = 'id="dataList" class="s-table table"';
$datagrid->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';
// set delete proccess URL
$datagrid->chbox_form_URL = null;

// put the result into variables
$datagrid_result = $datagrid->createDataGrid($dbs, $table_spec, 10, true);
if ((isset($_GET['keywords']) AND $_GET['keywords'])) {
    echo '<div class="infoBox">';
    echo __('Found').' '.$datagrid->num_rows.' '.__('from your search with keyword').' : "'.htmlentities($_GET['keywords']).'"'; //mfc
    echo '</div>';
}

echo $datagrid_result;
