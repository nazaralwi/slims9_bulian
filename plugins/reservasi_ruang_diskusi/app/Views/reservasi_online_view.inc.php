<?php
$attr = [
    'action' => $_SERVER['PHP_SELF'] .'?p=reservasi_ruang_diskusi',
    'method' => 'POST',
    'enctype' => 'multipart/form-data'
];

// check dependency
if (!file_exists(SB.'plugins'.DS.'reservasi_ruang_diskusi'.DS.'helper/formmaker.inc.php'))
{
    echo '<div class="bg-danger p-2 text-white">';
    echo 'Folder <b>'.SB.'plugins'.DS.'reservasi_ruang_diskusi'.DS.'helper/formmaker.inc.php</b> tidak ada. Pastikan folder itu tersedia.';
    echo '</div>';
}
else
{
    $majorList = [['label' => __('S1 Teknik Informatika'), 'value' => 'S1 Teknik Informatika'], ['label' => __('S1 Software Engineering'), 'value' => 'S1 Software Engineering'],
    ['label' => __('S1 Sistem Informasi'), 'value' => 'S1 Sistem Informasi'], ['label' => __('S1 Sains Data'), 'value' => 'S1 Sains Data'],
    ['label' => __('S1 Teknik Telekomunikasi'), 'value' => 'S1 Teknik Telekomunikasi'], ['label' => __('D3 Teknik Telekomunikasi'), 'value' => 'D3 Teknik Telekomunikasi'],
    ['label' => __('S1 Automation Technology'), 'value' => 'S1 Automation Technology'], ['label' => __('S1 Teknik Biomedis'), 'value' => 'S1 Teknik Biomedis'],
    ['label' => __('S1 Teknologi Pangan'), 'value' => 'S1 Teknologi Pangan'], ['label' => __('S1 Teknik Industri'), 'value' => 'S1 Teknik Industri'],
    ['label' => __('S1 Desain Komunikasi Visual'), 'value' => 'S1 Desain Komunikasi Visual'], ['label' => __('S1 Digital Logistic'), 'value' => 'S1 Digital Logistic'],
    ['label' => __('S1 Bisnis Digital'), 'value' => 'S1 Bisnis Digital'], ['label' => __('S1 Product Innovation'), 'value' => 'S1 Product Innovation'],
    ['label' => __('D3  Teknik Digital'), 'value' => 'D3  Teknik Digital'], ['label' => __('Lainnya'), 'value' => 'Lainnya']];

    $reservationDuration = [['label' => __('30 menit'), 'value' => 30],['label' => __('1 jam'), 'value' => 60],
    ['label' => __('1,5 jam'), 'value' => 90],['label' => __('2 jam'), 'value' => 120], ['label' => __('> 2 jam'), 'value' => '>120']];

    $visitorCount = [['label' => __('5'), 'value' => 5],['label' => __('6'), 'value' => 6],
    ['label' => __('7'), 'value' => 7],['label' => __('8'), 'value' => 8],
    ['label' => __('9'), 'value' => 9],['label' => __('10'), 'value' => 10]];

    // set key
    define('DR_INDEX_AUTH', '1');

    // require helper
    require SB.'plugins'.DS.'reservasi_ruang_diskusi'.DS.'helper/formmaker.inc.php';

    // create form
    createForm($attr);
    createFormContent(__('Nama'), 'text', 'name', 'Isikan nama Anda', true, '', true);
    createFormContent(__('NIM'), 'text', 'studentId', 'Isikan NIM Anda');
    createSelect(__('Program Studi'), 'major', $majorList);
    createFormContent(__('Nomor WhatsApp'), 'text', 'whatsAppNumber', 'Isikan nomor WhatsApp Anda', true, '', true);
    createDate(__('Tanggal Reservasi'), 'reservationDate', date('Y-m-d'), 'populateSubcategories()');
    createSelect(__('Durasi Peminjaman'), 'duration', $reservationDuration, 'onchange="populateSubcategories()"');
    createDynamicSelect(__('Jadwal Reservasi yang Tersedia'), 'availableSchedule');
    createSelect(__('Jumlah pengguna ruangan'), 'visitorNumber', $visitorCount);
    createFormContent(__('Kegiatan yang Akan Dilakukan'), 'text', 'activity', 'Isikan nomor Kegiatan Anda', true, '', true);
    createFormButton('Daftar', 'submit', 'register');
    closeTag('div');
    closeTag('form');

    echo '<script>
    const today = new Date().toISOString().substr(0, 10);
    document.getElementById(\'reservationDate\').value = today;

    function populateSubcategories() {
        const duration = document.getElementById(\'duration\').value;
        const availableSchedule = document.getElementById(\'availableSchedule\');
        availableSchedule.innerHTML = \'\';

        const selectedDate = document.getElementById(\'reservationDate\').value;

        fetch(\'plugins/reservasi_ruang_diskusi/app/Views/process.php\', {
            method: \'POST\',
            headers: {
                \'Content-Type\': \'application/x-www-form-urlencoded\',
            },
            body: `selectedDate=${selectedDate}`,
        })
            .then(response => response.json())
            .then(data => {
                const options = data[duration];
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
            })
            .catch(error => console.error(\'Error:\', error));
    }

    window.onload = populateSubcategories;
    </script>';
}
