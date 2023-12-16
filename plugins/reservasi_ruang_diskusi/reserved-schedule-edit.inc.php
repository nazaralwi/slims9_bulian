<?php

$attribute = "SELECT * FROM room_reservations WHERE id='{itemID}'";

$itemID = $dbs->escape_string(trim(isset($_POST['itemID'])?$_POST['itemID']:'')); 
$rec_q = $dbs->query(str_replace('{itemID}', $itemID, $attribute));
$rec_d = $rec_q->fetch_assoc();

// create new instance
$form = new simbio_form_table_AJAX('mainForm', $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'], 'post');
$form->submit_button_attr = 'name="updateReservationData" value="'.__('Update').'" class="s-btn btn btn-default"';

// form table attributes
$form->table_attr = 'id="dataList" class="s-table table"';
$form->table_header_attr = 'class="alterCell font-weight-bold"';
$form->table_content_attr = 'class="alterCell2"';

// edit mode flag set
if ($rec_q->num_rows > 0) {
    $form->edit_mode = true;
    // record ID for delete process
    $form->record_id = $itemID;
    // form record title
    $form->record_title = $rec_d['name'];
    // submit button attribute
    $form->submit_button_attr = 'name="updateReservationData" value="'.__('Update').'" class="s-btn btn btn-primary"';
}

// member code
$str_input  = '<div class="container">';
$str_input .= '<div class="row">';
$str_input .= simbio_form_element::textField('text', 'reservationId', $rec_d['id']??'', 'id="reservationId" onblur="ajaxCheckID(\''.SWB.'admin/AJAX_check_id.php\', \'member\', \'member_id\', \'msgBox\', \'memberID\')" class="form-control col-4"');
$str_input .= '<div id="msgBox" class="col mt-2"></div>';
$str_input .= '</div>';
$str_input .= '</div>';

$majorList = ['S1 Teknik Informatika', 'S1 Software Engineering', 'S1 Sistem Informasi', 
            'S1 Sains Data', 'S1 Teknik Telekomunikasi', 'D3 Teknik Telekomunikasi', 'S1 Automation Technology', 
            'S1 Teknik Biomedis', 'S1 Teknologi Pangan', 'S1 Teknik Industri', 'S1 Desain Komunikasi Visual', 
            'S1 Digital Logistic', 'S1 Bisnis Digital', 'S1 Product Innovation', 'D3  Teknik Digital', 'Lainnya'];

$form->addAnything(__('Reservation ID'), $rec_d['id']);
$form->addAnything(__('Reservation Date'), $rec_d['reservation_date']);
$form->addTextField('text', 'name', __('Name').'*', $rec_d['name']??'', 'rows="1" class="form-control"', 'Name');
$form->addTextField('text', 'studentId', __('NIM'), $rec_d['student_id']??'', 'rows="1" class="form-control"', 'Student Id');
$form->addSelectList('major', __('Program Studi'), $majorList, $rec_d['major'] ?? '', 'class="select2"', 'Major');
$form->addTextField('text', 'whatsAppNumber', __('Nomor WhatsApp'), $rec_d['whatsapp_number'] ?? '', 'rows="1" class="form-control"', 'WhatsApp Number');
$reservationDuration = [['30','30 menit'],['60','1 jam'], ['90','1,5 jam'], ['120','2 jam']];
$form->addSelectList('duration', __('Durasi Peminjaman'), $reservationDuration, $rec_d['duration'] ?? '', 'class="select2"', 'Duration');
$form->addSelectList('visitorNumber', __('Jumlah pengguna ruangan'), ['5', '6', '7', '8', '9', '10'], $rec_d['visitorNumber'] ?? '', 'class="select2"', 'Visitor Number');
$form->addTextField('text', 'activity', __('Kegiatan yang Akan Dilakukan'), $rec_d['activity'] ?? '', 'rows="1" class="form-control"', 'Activity');

echo $form->printOut();