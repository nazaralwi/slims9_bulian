<?php
$majorList = getMajorList();

// Creating form as in your original code
$form = new simbio_form_table_AJAX('onsiteReservationForm', $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'], 'post');
$form->submit_button_attr = 'name="onsiteReservation" value="' . __('Reservasi') . '" class="s-btn btn btn-default"';

$form->table_attr = 'id="dataList" cellpadding="0" cellspacing="0"';
$form->table_header_attr = 'class="alterCell"';
$form->table_content_attr = 'class="alterCell2"';

$form->addTextField('text', 'name', 'Nama', $meta['name'] ?? '', 'rows="1" class="form-control"', 'Name');
$form->addTextField('text', 'studentId', 'NIM', $meta['studentId'] ?? 0, 'rows="1" class="form-control"', 'Student ID');
$form->addSelectList('major', 'Program Studi', $majorList, $meta['major'] ?? '', 'class="select2"', 'Major');
$form->addTextField('text', 'whatsAppNumber', 'Nomor WhatsApp', $meta['whatsAppNumber'] ?? '', 'rows="1" class="form-control"', 'WhatsApp Number');

$form->addDateField('date', 'Tanggal Reservasi', date('Y-m-d'), 'min="' . date("Y-m-d") . '"' . 'onchange="populateSubcategories()" class="form-control"');

$reservationDuration = ['30' => '30 menit', '60' => '1 jam', '90' => '1,5 jam', '120' => '2 jam', '>120' => '> 2 jam'];
$form->addSelectList('duration', 'Durasi Peminjaman', $reservationDuration, $meta['duration'] ?? '', 'class="select2"', 'Duration');

echo '<script>
    const today = new Date().toISOString().substr(0, 10);
    document.getElementById(\'date\').value = today;

    function populateSubcategories() {
        const category = document.getElementById(\'duration\').value;
        const availableSchedule = document.getElementById(\'availableSchedule\');
        subcategorySelect.innerHTML = \'\';

        const selectedDate = document.getElementById(\'date\').value;

        fetch(\'plugins/reservasi_ruang_diskusi/app/reservation_logic/populate_schedule.php\', {
            method: \'POST\',
            headers: {
                \'Content-Type\': \'application/x-www-form-urlencoded\',
            },
            body: `selectedDate=${selectedDate}`,
        })
            .then(response => response.json())
            .then(data => {
                const options = data[category];
                if (options && options.length > 0 && options[0] !== \'Jadwal tidak tersedia\') {
                    options.forEach(option => {
                        const newOption = document.createElement(\'option\');
                        newOption.value = option;
                        newOption.text = option;
                        subcategorySelect.appendChild(newOption);
                    });
                } else {
                    const newOption = document.createElement(\'option\');
                    newOption.value = \'Jadwal tidak tersedia\';
                    newOption.text = \'Tidak ada jadwal\';
                    subcategorySelect.appendChild(newOption);
                }
            })
            .catch(error => console.error(\'Error:\', error));
    }

    window.onload = populateSubcategories;
</script>';
$reservationDuration = [['30','30 menit'],['60','1 jam'], ['90','1,5 jam'], ['120','2 jam'], ['>120', '> 2 jam']];
$form->addSelectList('availableSchedule', 'Jadwal Reservasi yang Tersedia', [], $meta['availableSchedule'] ?? '', 'class="select2"', 'Available Schedule');

// required (> 2 hours)
// md5 
$str_input  = '<div class="container-fluid">';
$str_input .= '<div class="row">';
$str_input .= '<div class="custom-file col">';
$str_input .= simbio_form_element::textField('file', 'file2attach','','class="custom-file-input"');
$str_input .= '<label class="custom-file-label" for="customFile">Choose file</label>';
$str_input .= '</div>';
$str_input .= ' <div class="col-4 mt-2">Maximum '.$sysconf['max_upload'].' KB</div>';
$str_input .= '</div>';
$str_input .= '</div>';
// $form->addAnything(__('File To Attach'), $str_input);

$form->addSelectList('visitorNumber', 'Jumlah pengguna ruangan', ['5', '6', '7', '8', '9', '10'], $meta['visitorNumber'] ?? '', 'class="select2"', 'Visitor Number');
$form->addTextField('text', 'activity', 'Kegiatan yang Akan Dilakukan', $meta['activity'] ?? '', 'rows="1" class="form-control"', 'Activity');
echo $form->printOut();
?>