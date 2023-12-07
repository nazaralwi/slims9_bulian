<?php
/*
 * File: place_action.php
 * Project: libs
 * File Created: Thursday, 25th November 2021 2:19:35 pm
 * Author: Waris Agung Widodo (ido.alit@gmail.com)
 * -----
 * Last Modified: Thursday, 25th November 2021 2:19:41 pm
 * Modified By: Waris Agung Widodo (ido.alit@gmail.com)
 * -----
 * License: GNU GPL v3
 */

global $dbs;

if (isset($_POST['place_lama']) && isset($_POST['place_baru'])) {
    $id_lama = utility::filterData('place_lama', 'post', true, true, true);
    $id_baru = utility::filterData('place_baru', 'post', true, true, true);

    if (stripos($id_baru, 'NEW:') === 0) {
        $new_place = str_ireplace('NEW:', '', $id_baru);
        $id_baru = utility::getID($dbs, 'mst_place', 'place_id', 'place_name', $new_place);
    }

    // build sql query
    $sql_switch = "UPDATE `biblio` SET `publish_place_id` = '$id_baru' WHERE `publish_place_id` = '$id_lama';";
    if ($dbs->query($sql_switch)) {
        utility::jsToastr('Place Switcher', 'Data berhasil di tukar', 'success');
        if (isset($_POST['delete']) && $_POST['delete'] > 0) {
            $sql_delete= "DELETE FROM `mst_place` WHERE `place_id` = '$id_lama';";
            if ($dbs->query($sql_delete)) {
                utility::jsToastr('Place Switcher', 'Tempat terbit lama berhasil dihapus', 'success');
            } else {
                utility::jsToastr('Place Switcher', $dbs->error, 'error');
            }
        }
    } else {
        utility::jsToastr('Place Switcher', $dbs->error, 'error');
    }
}