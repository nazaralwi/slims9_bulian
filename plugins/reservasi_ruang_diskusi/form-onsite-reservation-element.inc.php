<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-05-08 09:15:43
 * @modify date 2022-03-28 12:53:36
 * @desc [description]
 */

if ($_SESSION['uid'] > 1)
{
    echo '<div class="bg-danger p-2 text-white">';
    echo 'Hanya akun super-admin yang dapat merubah bagian ini.';
    echo '</div>';
    exit;
}

// create new instance
$form = new simbio_form_table_AJAX('onsiteReservationForm', $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'], 'post');
$form->submit_button_attr = 'name="onsiteReservation" value="' . __('Reservasi') . '" class="s-btn btn btn-default"';
// form table attributes
$form->table_attr = 'id="dataList" cellpadding="0" cellspacing="0"';
$form->table_header_attr = 'class="alterCell"';
$form->table_content_attr = 'class="alterCell2"';

/* Form Element(s) */
// Nama
$form->addTextField('text', 'name', 'Nama', $meta['name'] ?? '', 'rows="1" class="form-control"', 'Name');

// NIM
$form->addTextField('text', 'studentId', 'NIM', $meta['studentId'] ?? '', 'rows="1" class="form-control"', 'Student ID');

// Program Studi
$majorList = [['0', 'S1 Teknik Informatika'], ['1', 'S1 Software Engineering'], ['2', 'S1 Sistem Informasi'], 
            ['3', 'S1 Sains Data'], ['4', 'S1 Teknik Telekomunikasi'], ['5', 'D3 Teknik Telekomunikasi'], ['6', 'S1 Automation Technology'], 
            ['7', 'S1 Teknik Biomedis'], ['8', 'S1 Teknologi Pangan'], ['9', 'S1 Teknik Industri'], ['10', 'S1 Desain Komunikasi Visual'], 
            ['11', 'S1 Digital Logistic'], ['12', 'S1 Bisnis Digital'], ['13', 'S1 Product Innovation'], ['14', 'D3  Teknik Digital'], ['15', 'Lainnya']];
$form->addSelectList('major', 'Program Studi', $majorList, $meta['major'] ?? '', 'class="select2"', 'Major');

// WhatsApp Number
$form->addTextField('text', 'whatsAppNumber', 'Nomor WhatsApp', $meta['whatsAppNumber'] ?? '', 'rows="1" class="form-control"', 'WhatsApp Number');

// Visitor Discussion Room Number
$form->addSelectList('visitorNumber', 'Jumlah pengguna ruangan', [['0', '5'], ['1', '6'], ['2', '7'], ['3', '8'], ['4', '9'], ['5', '10']], $meta['visitorNumber'] ?? '', 'class="select2"', 'Visitor Number');

// Kegiatan yang Dilakukan
$form->addTextField('text', 'activity', 'Kegiatan yang Akan Dilakukan', $meta['activity'] ?? '', 'rows="1" class="form-control"', 'Activity');

// print out the form object
echo $form->printOut();
?>