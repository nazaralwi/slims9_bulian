<?php

if ($_SESSION['uid'] > 1)
{
    echo '<div class="bg-danger p-2 text-white">';
    echo 'Hanya akun super-admin yang dapat merubah bagian ini.';
    echo '</div>';
    exit;
}
$majorList = ['S1 Teknik Informatika', 'S1 Software Engineering', 'S1 Sistem Informasi', 
            'S1 Sains Data', 'S1 Teknik Telekomunikasi', 'D3 Teknik Telekomunikasi', 'S1 Automation Technology', 
            'S1 Teknik Biomedis', 'S1 Teknologi Pangan', 'S1 Teknik Industri', 'S1 Desain Komunikasi Visual', 
            'S1 Digital Logistic', 'S1 Bisnis Digital', 'S1 Product Innovation', 'D3  Teknik Digital', 'Lainnya'];

$form = new simbio_form_table_AJAX('onsiteReservationForm', $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'], 'post');
$form->submit_button_attr = 'name="onsiteReservation" value="' . __('Reservasi') . '" class="s-btn btn btn-default"';

$form->table_attr = 'id="dataList" cellpadding="0" cellspacing="0"';
$form->table_header_attr = 'class="alterCell"';
$form->table_content_attr = 'class="alterCell2"';

$form->addTextField('text', 'name', 'Nama', $meta['name'] ?? '', 'rows="1" class="form-control"', 'Name');
$form->addTextField('text', 'studentId', 'NIM', $meta['studentId'] ?? '', 'rows="1" class="form-control"', 'Student ID');
$form->addSelectList('major', 'Program Studi', $majorList, $meta['major'] ?? '', 'class="select2"', 'Major');
$form->addTextField('text', 'whatsAppNumber', 'Nomor WhatsApp', $meta['whatsAppNumber'] ?? '', 'rows="1" class="form-control"', 'WhatsApp Number');
$form->addSelectList('visitorNumber', 'Jumlah pengguna ruangan', ['5', '6', '7', '8', '9', '10'], $meta['visitorNumber'] ?? '', 'class="select2"', 'Visitor Number');
$form->addTextField('text', 'activity', 'Kegiatan yang Akan Dilakukan', $meta['activity'] ?? '', 'rows="1" class="form-control"', 'Activity');

echo $form->printOut();
?>