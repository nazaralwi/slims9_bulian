<?php
$attr = [
    'action' => $_SERVER['PHP_SELF'] .'?p=reservasi_ruang_diskusi',
    'method' => 'POST',
    'enctype' => 'multipart/form-data'
];

// require helper
require __DIR__ . DS . 'helper.php';

if (isset($_POST['name']))
{
    reserveSchedule();
}

// check dependency
if (!file_exists(SB.'plugins'.DS.'reservasi_ruang_diskusi'.DS.'formmaker.inc.php'))
{
    echo '<div class="bg-danger p-2 text-white">';
    echo 'Folder <b>'.SB.'plugins'.DS.'reservasi_ruang_diskusi'.DS.'formmaker.inc.php</b> tidak ada. Pastikan folder itu tersedia.';
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

    $visitorCount = [['label' => __('5'), 'value' => 5],['label' => __('6'), 'value' => 6],
    ['label' => __('7'), 'value' => 7],['label' => __('8'), 'value' => 8],
    ['label' => __('9'), 'value' => 9],['label' => __('10'), 'value' => 10]];

    // set key
    define('DR_INDEX_AUTH', '1');

    // require helper
    require SB.'plugins'.DS.'reservasi_ruang_diskusi'.DS.'formmaker.inc.php';

    // create form
    createForm($attr);
    createFormContent(__('Nama'), 'text', 'name', 'Isikan nama Anda', true, '', true);
    createFormContent(__('NIM'), 'text', 'studentId', 'Isikan NIM Anda');
    createSelect(__('Program Studi'), 'major', $majorList);
    createFormContent(__('Nomor WhatsApp'), 'text', 'whatsAppNumber', 'Isikan nomor WhatsApp Anda', true, '', true);
    createSelect(__('Jumlah pengguna ruangan'), 'visitorNumber', $visitorCount);
    createFormContent(__('Kegiatan yang Akan Dilakukan'), 'text', 'activity', 'Isikan nomor Kegiatan Anda', true, '', true);
    createFormButton('Daftar', 'submit', 'register');
    createBlindIframe('blindIframe');
    closeTag('div');
    closeTag('form');
}
