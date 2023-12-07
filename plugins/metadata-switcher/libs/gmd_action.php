<?php
/*
 * File: gmd_action.php
 * Project: libs
 * File Created: Thursday, 25th November 2021 12:39:38 pm
 * Author: Waris Agung Widodo (ido.alit@gmail.com)
 * -----
 * Last Modified: Thursday, 25th November 2021 12:39:44 pm
 * Modified By: Waris Agung Widodo (ido.alit@gmail.com)
 * -----
 * License: GNU GPL v3
 */

global $dbs;

if (isset($_POST['gmd_lama']) && isset($_POST['gmd_baru'])) {
    $id_lama = (int)utility::filterData('gmd_lama', 'post', true, true, true);
    $id_baru = (int)utility::filterData('gmd_baru', 'post', true, true, true);
    // build sql query
    $sql_switch = "UPDATE `biblio` SET `gmd_id` = '$id_baru' WHERE `gmd_id` = '$id_lama';";
    if ($dbs->query($sql_switch)) {
        utility::jsToastr('GMD Switcher', 'Data berhasil di tukar', 'success');
        if (isset($_POST['delete']) && $_POST['delete'] > 0) {
            $sql_delete= "DELETE FROM `mst_gmd` WHERE `gmd_id` = '$id_lama';";
            if ($dbs->query($sql_delete)) {
                utility::jsToastr('GMD Switcher', 'GMD Lama berhasil dihapus', 'success');
            } else {
                utility::jsToastr('GMD Switcher', $dbs->error, 'error');
            }
        }
    } else {
        utility::jsToastr('GMD Switcher', $dbs->error, 'error');
    }
}