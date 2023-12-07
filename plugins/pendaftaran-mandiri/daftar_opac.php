<?php

/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 21/05/2021 14:44
 * @File name           : daftar.php
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

use SLiMS\DB;

// check apakah ada yang mengirimkan data
$error_message = '';
$berhasil_simpan = null;
if (isset($_POST['daftar_mandiri'])) {

    $data['member_id'] = utility::filterData('npm', 'post', true, true, true);

    // cek apakah di table member sudah ada ID ini
    $member_qm = DB::getInstance()->query(sprintf("select * from member where member_id = '%s'", $data['member_id']));
    if ($member_qm->rowCount()) {
        echo '<div class="alert alert-danger" role="alert">
        Anda sudah terdaftar. Silahkan hubungi petugas untuk info lebih lanjut.
        </div>';
    } else {

        // mendapatkan data yang dikirim
        //    $data['member_id'] = date('YmdHis');
        $data['member_name'] =  utility::filterData('nama_lengkap', 'post', true, true, true);
        $data['member_email'] = utility::filterData('email', 'post', true, true, true);
        $data['member_address'] = utility::filterData('alamat', 'post', true, true, true);

        //    $data['is_new'] = 1;
        //    $data['is_pending'] = 1;
        //    $data['gender'] = 1;
        //    $data['expire_date'] = date('Y-m-d H:i:s');
        $data['input_date'] = date('Y-m-d H:i:s');

        // simpan ke database table member
        require_once SIMBIO . '/simbio_DB/simbio_dbop.inc.php';
        $sql_op = new simbio_dbop($dbs);
        $insert = $sql_op->insert('pendaftaran_mandiri', $data);

        if ($insert) {
            $berhasil_simpan = true;
        } else {
            $berhasil_simpan = false;
            $error_message = 'GAGAL MENYIMPAN DATA. ' . $sql_op->error;
        }

        if ($berhasil_simpan) {
            echo '<div class="alert alert-success" role="alert">
          Pendaftaran berhasil!
        </div>';
        } else if (!is_null($berhasil_simpan)) {
            echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
        }
    }
}

?>

<form action="index.php?p=pendaftaran_mandiri" method="post">
    <div class="form-group">
        <label for="npm">NPM</label>
        <input type="text" class="form-control" name="npm" id=npm required>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Nama Lengkap</label>
        <input type="text" class="form-control" name="nama_lengkap" required>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Email</label>
        <input type="email" class="form-control" name="email" required>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Alamat</label>
        <textarea class="form-control" name="alamat"></textarea>
    </div>
    <button type="submit" class="btn btn-primary" name="daftar_mandiri" value="1">Submit</button>
</form>