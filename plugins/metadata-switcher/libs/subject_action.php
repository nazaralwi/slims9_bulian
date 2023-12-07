<?php
/*
 * File: subject_action.php
 * Project: libs
 * File Created: Thursday, 25th November 2021 2:12:41 pm
 * topic: Waris Agung Widodo (ido.alit@gmail.com)
 * -----
 * Last Modified: Thursday, 25th November 2021 2:12:48 pm
 * Modified By: Waris Agung Widodo (ido.alit@gmail.com)
 * -----
 * License: GNU GPL v3
 */

global $dbs;

if (isset($_POST['topic_lama']) && isset($_POST['topic_baru'])) {
    $id_lama = utility::filterData('topic_lama', 'post', true, true, true);
    $id_baru = utility::filterData('topic_baru', 'post', true, true, true);

    if (stripos($id_baru, 'NEW:') === 0) {
        $new_topic = str_ireplace('NEW:', '', $id_baru);
        $id_baru = utility::getID($dbs, 'mst_topic', 'topic_id', 'topic', $new_topic);
    }

    // build sql query
    $sql_switch = "UPDATE `biblio_topic` SET `topic_id` = '$id_baru' WHERE `topic_id` = '$id_lama';";
    if ($dbs->query($sql_switch)) {
        utility::jsToastr('Subject Switcher', 'Data berhasil di tukar', 'success');
        if (isset($_POST['delete']) && $_POST['delete'] > 0) {
            $sql_delete= "DELETE FROM `mst_topic` WHERE `topic_id` = '$id_lama';";
            if ($dbs->query($sql_delete)) {
                utility::jsToastr('Subject Switcher', 'Pengarang Lama berhasil dihapus', 'success');
            } else {
                utility::jsToastr('Subject Switcher', $dbs->error, 'error');
            }
        }
    } else {
        utility::jsToastr('Subject Switcher', $dbs->error, 'error');
    }
}