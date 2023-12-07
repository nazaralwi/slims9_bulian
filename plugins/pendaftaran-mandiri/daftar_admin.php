<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 21/05/2021 14:47
 * @File name           : daftar_admin.php
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

defined('INDEX_AUTH') OR die('Direct access not allowed!');

// IP based access limitation
require LIB . 'ip_based_access.inc.php';
do_checkIP('smc');
do_checkIP('smc-membership');
// start the session
require SB . 'admin/default/session.inc.php';
require SIMBIO . 'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO . 'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO . 'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO . 'simbio_DB/datagrid/simbio_dbgrid.inc.php';

// privileges checking
$can_read = utility::havePrivilege('membership', 'r');

if (!$can_read) {
    die('<div class="errorBox">' . __('You are not authorized to view this section') . '</div>');
}

if (isset($_POST['member_name'])) {
    $data['member_id'] = utility::filterData('member_id', 'post');
    $data['member_name'] = utility::filterData('member_name', 'post');
    $data['member_email'] = utility::filterData('member_email', 'post');
    $data['is_new'] = 1;
    $data['is_pending'] = 1;
    $data['gender'] = 1;
    $data['expire_date'] = date('Y-m-d H:i:s');

    // simpan ke table member
    require_once SIMBIO . 'simbio_DB/simbio_dbop.inc.php';
    $sql_op = new simbio_dbop(DB::getInstance('mysqli'));
    $insert = $sql_op->insert('member', $data);

    if($insert) {
        echo '<div class="alert alert-secondary" role="alert">sukses</div>';
        $pm_id = utility::filterData('pm_ID', 'post');
        $hapus = DB::getInstance()->query(sprintf("delete from pendaftaran_mandiri where member_id = '%s'", $pm_id));
        if ($hapus) {
            echo '<div class="alert alert-secondary" role="alert">data di pendaftaran mandiri sudah dihapus</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">data di pendaftaran manditi GAGAL dihapus</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">gagal menyimpan data. error : ' . $sql_op->error . '</div>';
    }

    exit();
}

if(isset($_GET['member_id'])) {
    $member_id = utility::filterData('member_id');
    $member_q = DB::getInstance()->query(sprintf("SELECT * FROM pendaftaran_mandiri WHERE member_id = '%s'", $member_id));
    $member = $member_q->fetch(\PDO::FETCH_OBJ);

    $url_action = $_SERVER['PHP_SELF'] . '?' . http_build_query(['mod' => $_GET['mod'], 'id' => $_GET['id'], 'member_id' => $member_id]);

    echo <<<HTML
        <div class="container-fluid">
        <form action="{$url_action}" method="post" class="submitViaAJAX">
        <input type="hidden" name="pm_ID" value="{$member_id}">
        <div class="mb-3">
            <label for="memberid" class="form-label">Nama Anggota</label>
            <input name="member_id" type="text" class="form-control" id="memberid" value="{$member->member_id}">
        </div>
        <div class="mb-3">
            <label for="namaanggota" class="form-label">Nama Anggota</label>
            <input name="member_name" type="text" class="form-control" id="namaanggota" value="{$member->member_name}">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input name="member_email" type="email" class="form-control" id="exampleInputEmail1" value="{$member->member_email}">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
        </div>
    HTML;

    exit();
}

?>
    <div class="menuBox">
        <div class="menuBoxInner printIcon">
            <div class="per_title">
                <h2><?php echo __('Pendaftaran Mandiri'); ?></h2>
            </div>
        </div>
    </div>
<?php

// menampilkan data anggota yang sudah mendaftar
$grid = new simbio_datagrid();
$grid->setSQLColumn('member_id', 'member_name', 'member_email', 'input_date', 'member_id');
function lihat($dbs, $data, $index) {
    $adm = $_SERVER['PHP_SELF'] . '?' . http_build_query(['mod' => $_GET['mod'], 'id' => $_GET['id'], 'member_id' => $data[$index]]);
    return <<<HTML
    <a class="btn-sm btn btn-primary" href="{$adm}" title="LIHAT">LIHAT</a>
    HTML;
}
$grid->modifyColumnContent(4, 'callback{lihat}');
//$criteria = 'is_new = 1 ';
//$grid->setSQLCriteria($criteria);
echo $grid->createDataGrid($dbs, 'pendaftaran_mandiri');