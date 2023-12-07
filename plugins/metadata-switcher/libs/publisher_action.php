<?php
/*
 * File: publisher_action.php
 * Project: libs
 * File Created: Thursday, 25th November 2021 1:04:58 pm
 * Author: Waris Agung Widodo (ido.alit@gmail.com)
 * -----
 * Last Modified: Thursday, 25th November 2021 1:05:04 pm
 * Modified By: Waris Agung Widodo (ido.alit@gmail.com)
 * -----
 * License: GNU GPL v3
 */

global $dbs;

if (isset($_POST['publisher_lama']) && isset($_POST['publisher_baru'])) {
    $id_lama = utility::filterData('publisher_lama', 'post', true, true, true);
    $id_baru = utility::filterData('publisher_baru', 'post', true, true, true);

    if (stripos($id_baru, 'NEW:') === 0) {
        $new_publisher = str_ireplace('NEW:', '', $id_baru);
        $id_baru = utility::getID($dbs, 'mst_publisher', 'publisher_id', 'publisher_name', $new_publisher);
    }

    // build sql query
    $sql_switch = "UPDATE `biblio` SET `publisher_id` = '$id_baru' WHERE `publisher_id` = '$id_lama';";
    if ($dbs->query($sql_switch)) {
        utility::jsToastr('Publisher Switcher', 'Data berhasil di tukar', 'success');
        if (isset($_POST['delete']) && $_POST['delete'] > 0) {
            $sql_delete= "DELETE FROM `mst_publisher` WHERE `publisher_id` = '$id_lama';";
            if ($dbs->query($sql_delete)) {
                utility::jsToastr('Publisher Switcher', 'Publisher Lama berhasil dihapus', 'success');
            } else {
                utility::jsToastr('Publisher Switcher', $dbs->error, 'error');
            }
        }
    } else {
        utility::jsToastr('Publisher Switcher', $dbs->error, 'error');
    }
}