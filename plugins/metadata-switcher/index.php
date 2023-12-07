<?php
/*
 * File: index.php
 * Project: metadata_switcher
 * File Created: Thursday, 25th November 2021 9:15:05 am
 * Author: Waris Agung Widodo (ido.alit@gmail.com)
 * -----
 * Last Modified: Thursday, 25th November 2021 9:16:59 am
 * Modified By: Waris Agung Widodo (ido.alit@gmail.com)
 * -----
 * License: GNU GPL v3
 */

// load action by section
loadAction();

?>

<div style="background-color: #f2f7ff; min-height: calc(100vh - 146px)" class="container-fluid py-3">
    <div class="mb-4">
        <h2><?= __('Metadata Switcher') ?></h2>
        <p>
            <code>Metadata Switcher</code> berfungsi untuk mengganti data satu ke data yang lain. 
            Sebagai contoh, ada 2 data pengarang: 1) <b>Waris A.W.</b> dan 2) <b>Waris Agung Widodo</b>. Kita hendak menggunakan yang nomer 2, maka:
            Pada data lama kita pilih pengarang 1, dan pada baru kita pilih pengarang 2. Selanjutnya tinggal klik submit maka semua data akan terupdate 😉
        </p>
    </div>
    <div>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link<?= isActive('gmd') ?>" href="<?= adminUrl('gmd') ?>"><?= __('GMD') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?= isActive('publisher') ?>" href="<?= adminUrl('publisher') ?>"><?= __('Publisher') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?= isActive('author') ?>" href="<?= adminUrl('author') ?>"><?= __('Author') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?= isActive('subject') ?>" href="<?= adminUrl('subject') ?>"><?= __('Subject') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?= isActive('place') ?>" href="<?= adminUrl('place') ?>"><?= __('Place') ?></a>
            </li>
        </ul>
    </div>
    <div>
        <?php loadSection() ?>
    </div>
</div>