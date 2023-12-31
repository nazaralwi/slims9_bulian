<?php

$attribute = "SELECT * FROM room_reservations WHERE reservation_id='{itemID}'";

$itemID = $dbs->escape_string(trim(isset($_POST['itemID'])?$_POST['itemID']:'')); 
$rec_q = $dbs->query(str_replace('{itemID}', $itemID, $attribute));
$rec_d = $rec_q->fetch_assoc();

// create new instance
$form = new simbio_form_table_AJAX('updateOnsiteReservationForm', $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'], 'post');
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
$str_input .= simbio_form_element::textField('text', 'reservationId', $rec_d['reservation_id']??'', 'id="reservationId" onblur="ajaxCheckID(\''.SWB.'admin/AJAX_check_id.php\', \'member\', \'member_id\', \'msgBox\', \'memberID\')" class="form-control col-4"');
$str_input .= '<div id="msgBox" class="col mt-2"></div>';
$str_input .= '</div>';
$str_input .= '</div>';

$majorList = ['S1 Teknik Informatika', 'S1 Software Engineering', 'S1 Sistem Informasi', 
            'S1 Sains Data', 'S1 Teknik Telekomunikasi', 'D3 Teknik Telekomunikasi', 'S1 Automation Technology', 
            'S1 Teknik Biomedis', 'S1 Teknologi Pangan', 'S1 Teknik Industri', 'S1 Desain Komunikasi Visual', 
            'S1 Digital Logistic', 'S1 Bisnis Digital', 'S1 Product Innovation', 'D3  Teknik Digital', 'Lainnya'];

$form->addAnything(__('Reservation ID'), $rec_d['reservation_id']);
$form->addAnything(__('Reservation Date'), $rec_d['reservation_date']);

$str_member_id = simbio_form_element::textField('text', 'memberId', $rec_d['member_id'], 'id="memberId" class="form-control col-4" readonly');
$form->addAnything(__('NIDN/NIM'), $str_member_id);

$str_member_name = simbio_form_element::textField('text', 'name', $rec_d['name'], 'id="name" class="form-control col-4" readonly');
$form->addAnything(__('Nama'), $str_member_name);

$form->addSelectList('major', 'Program Studi', $majorList, $rec_d['major'] ?? '', 'class="form-control col-6" required', 'Major');
$form->addTextField('text', 'whatsAppNumber', 'Nomor WhatsApp', $rec_d['whatsapp_number'] ?? '', 'rows="1" class="form-control col-6" required', 'WhatsApp Number');

$str_date = '<input type="date" id="reservationDate" name="reservationDate" class="form-control col-6" value="'.date($rec_d['reserved_date']).'" min="'.date('Y-m-d').'" onchange="populateSubcategories()" required/>';
$form->addAnything('Tanggal Reservasi', $str_date);

// $reservationDuration = ['30' => '30 menit', '60' => '1 jam', '90' => '1,5 jam', '120' => '2 jam', '>120' => '> 2 jam'];
$reservationDuration = [['30', '30 menit'], ['60', '1 jam'], ['90', '1,5 jam'], ['120', '2 jam'], ['>120', '> 2 jam']];
$form->addSelectList('duration', 'Durasi Peminjaman', $reservationDuration, $rec_d['duration'] ?? '', 'onchange="populateSubcategories()" class="form-control col-6" required', 'Duration');
// $form->addSelectList('availableSchedule', 'Jadwal Reservasi yang Tersedia', [], $meta['availableSchedule'] ?? '', 'class="form-control col-6" required', 'Available Schedule');

$str_available_schedule = '<select id="availableSchedule" class="form-control col-6" name="availableSchedule" required><option value="'. $rec_d['start_time'] . ' - ' . $rec_d['end_time'] .'">'. $rec_d['start_time'] . ' - ' . $rec_d['end_time'] .'</option></select>';
$str_available_schedule .= '<div id="error-container" aria-live="polite"; class="col-6"></div>';
$form->addAnything('Jadwal Reservasi yang Tersedia', $str_available_schedule);

// required (> 2 hours)
// md5 
$str_input  = '<div id="reservationDocument" class="container-fluid">';
$str_input .= '<div class="row">';
$str_input .= '<div class="custom-file col-6">';
$str_input .= simbio_form_element::textField('file', 'reservationDocumentInput','','class="custom-file-input" required');
$str_input .= '<label class="custom-file-label" for="reservationDocumentInput">Choose file</label>';
$str_input .= '</div>';
$str_input .= '<div class="col-4 mt-2">Maximum '.$sysconf['max_upload'].' KB</div>';
$str_input .= '</div>';
$str_input .= '</div>';
$form->addAnything('File To Attach', $str_input);

$form->addSelectList('visitorNumber', 'Jumlah pengguna ruangan', ['5', '6', '7', '8', '9', '10'], $rec_d['visitor_number'] ?? '', 'class="form-control col-6" required', 'Visitor Number');
$form->addTextField('text', 'activity', 'Kegiatan yang Akan Dilakukan', $rec_d['activity'] ?? '', 'rows="1" class="form-control col-6" required', 'Activity');

echo $form->printOut();

echo '<style>
.error-message {
    color: #b9191b; /* Red color */
    font-size: 0.8rem; /* Slightly smaller than your form controls */
    margin-bottom: 0.5rem;
    margin-top: 0.5rem;
    padding: 5px;
    border: 1px solid #e74c3c; /* Light red border */
    border-radius: 4px;
    background-color: #fcf8f6; /* Lighten background for contrast */
}

#error-container {
    display: block; /* Ensure container is visible */
}

.hidden {
    display: none;
}
</style>';

// Change labelUpload with uploaded file name
echo '<script>
$(document).on("change", ".custom-file-input", function () {
    let fileName = $(this).val().replace(/\\\\/g, "/").replace(/.*\\//, "");
    $(this).parent(".custom-file").find(".custom-file-label").text(fileName);
});
</script>';

// Populate available schedule based on selected date
echo '<script>
    const today = new Date().toISOString().substr(0, 10);
    document.getElementById(\'reservationDate\').value = today;

    function populateSubcategories() {
        hideErrorMessage()

        const category = document.getElementById(\'duration\').value;
        const availableSchedule = document.getElementById(\'availableSchedule\');
        availableSchedule.innerHTML = \'\';

        const selectedDate = document.getElementById(\'reservationDate\').value;

        fetch(\'http://localhost/slims9_bulian/index.php?p=populate_schedule\', {
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
                        availableSchedule.appendChild(newOption);
                    });
                } else {
                    const newOption = document.createElement(\'option\');
                    newOption.value = \'Jadwal tidak tersedia\';
                    newOption.text = \'Tidak ada jadwal\';
                    availableSchedule.appendChild(newOption);
                }
                $(\'#availableSchedule\').trigger(\'change\');
            })
            .catch(error => console.error(\'Error:\', error));
    }

    window.onload = populateSubcategories;
</script>';

// Prevent form submission when schedule isn't available ("Tidak ada jadwal")
echo '<script>
document.getElementById("updateOnsiteReservationForm").addEventListener("submit", function(event) {
    var availableSchedule = document.getElementById(\'availableSchedule\');
    var selectedValue = availableSchedule.value;

    if (selectedValue === "Jadwal tidak tersedia") { // Replace "requiredValue" with the desired value
        event.preventDefault(); // Prevent form submission
        showInlineErrorMessage("Jadwal tidak tersedia. Silahkan pilih jadwal yang lain.");
    }
});
function showInlineErrorMessage(message) {
    var errorContainer = document.getElementById("error-container");
    
    // Clear any existing error messages:
    errorContainer.innerHTML = "";
    
    var errorMessage = document.createElement("p");
    errorMessage.classList.add("error-message"); // Add a class for styling
    errorMessage.textContent = message;
    
    errorContainer.appendChild(errorMessage);
}
function hideErrorMessage() {
    var errorContainer = document.getElementById("error-container");
    errorContainer.innerHTML = ""; // Clear the contents of the error container
}      
</script>';

echo '<script>
$(document).ready(function() {
    // Initially hide the conditional field and remove required attribute
    $(\'#reservationDocument\').hide();
    $(\'#reservationDocumentInput\').prop(\'required\', false);

    // Use event delegation on the form container
    $(\'#dataList\').on(\'change\', \'#duration, #availableSchedule\', function() {
        var selectedDuration = $(\'#duration\').val(); // Get the selected duration
        var selectedSchedule = $(\'#availableSchedule\').val(); // Get the selected schedule
        
        // Show/hide the conditional field based on the selected duration and available schedule
        if (selectedDuration === \'>120\' && selectedSchedule !== \'Jadwal tidak tersedia\') {
            $(\'#reservationDocument\').show(); // Show the conditional field
            $(\'#reservationDocumentInput\').prop(\'required\', true); // Add required
        } else {
            $(\'#reservationDocument\').hide(); // Hide the conditional field
            $(\'#reservationDocumentInput\').prop(\'required\', false); // remove required
        }
    });
});

// Call populateSubcategories after the initial load
populateSubcategories();
</script>';