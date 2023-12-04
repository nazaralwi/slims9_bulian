<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2021-05-08 09:16:04
 * @modify date 2022-03-28 14:01:52
 * @desc [description]
 */

$attribute = "SELECT * FROM onsite_reservation WHERE id='{itemID}'";

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
$form->addAnything(__('Reservation ID').'*', $str_input);

$form->addAnything(__('Reservation Date'), $rec_d['reservation_date']);

// member name
$form->addTextField('text', 'name', __('Name').'*', $rec_d['name']??'', 'rows="1" class="form-control"', 'Name');

// member institution
$form->addTextField('text', 'studentId', __('NIM'), $rec_d['student_id']??'', 'rows="1" class="form-control"', 'Student Id');

// Program Studi
$majorList = ['S1 Teknik Informatika', 'S1 Software Engineering', 'S1 Sistem Informasi', 
            'S1 Sains Data', 'S1 Teknik Telekomunikasi', 'D3 Teknik Telekomunikasi', 'S1 Automation Technology', 
            'S1 Teknik Biomedis', 'S1 Teknologi Pangan', 'S1 Teknik Industri', 'S1 Desain Komunikasi Visual', 
            'S1 Digital Logistic', 'S1 Bisnis Digital', 'S1 Product Innovation', 'D3  Teknik Digital', 'Lainnya'];
$form->addSelectList('major', __('Program Studi'), $majorList, $rec_d['major'] ?? '', 'class="select2"', 'Major');

// WhatsApp Number
$form->addTextField('text', 'whatsAppNumber', __('Nomor WhatsApp'), $rec_d['whatsapp_number'] ?? '', 'rows="1" class="form-control"', 'WhatsApp Number');

// Visitor Discussion Room Number
$form->addSelectList('visitorNumber', __('Jumlah pengguna ruangan'), ['5', '6', '7', '8', '9', '10'], $rec_d['visitorNumber'] ?? '', 'class="select2"', 'Visitor Number');

// Kegiatan yang Dilakukan
$form->addTextField('text', 'activity', __('Kegiatan yang Akan Dilakukan'), $rec_d['activity'] ?? '', 'rows="1" class="form-control"', 'Activity');

// Member image
if (isset($sysconf['selfRegistration']) && isset($sysconf['selfRegistration']['withImage']) && (bool)$sysconf['selfRegistration']['withImage'] === true)
{
    if (!empty($rec_d['member_image']))
    {
        $Url = SWB . 'images/persons/' . $rec_d['member_image'];
        $form->addAnything('Photo Profil', "
            <img src=\"{$Url}\" style=\"width: 140px; height: 180px\"/>
        ");
    }
}

// print out the form object
echo $form->printOut();