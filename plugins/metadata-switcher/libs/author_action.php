<?php
/*
 * File: author_action.php
 * Project: libs
 * File Created: Thursday, 25th November 2021 1:56:19 pm
 * Author: Waris Agung Widodo (ido.alit@gmail.com)
 * -----
 * Last Modified: Thursday, 25th November 2021 1:56:34 pm
 * Modified By: Waris Agung Widodo (ido.alit@gmail.com)
 * -----
 * License: GNU GPL v3
 */

global $dbs;

if (isset($_POST['author_lama']) && isset($_POST['author_baru'])) {
    $id_lama = utility::filterData('author_lama', 'post', true, true, true);
    $id_baru = utility::filterData('author_baru', 'post', true, true, true);

    if (stripos($id_baru, 'NEW:') === 0) {
        $new_author = str_ireplace('NEW:', '', $id_baru);
        $id_baru = utility::getID($dbs, 'mst_author', 'author_id', 'author_name', $new_author);
    }

    // build sql query
    $sql_switch = "UPDATE `biblio_author` SET `author_id` = '$id_baru' WHERE `author_id` = '$id_lama';";
    if ($dbs->query($sql_switch)) {
        utility::jsToastr('Author Switcher', 'Data berhasil di tukar', 'success');
        if (isset($_POST['delete']) && $_POST['delete'] > 0) {
            $sql_delete= "DELETE FROM `mst_author` WHERE `author_id` = '$id_lama';";
            if ($dbs->query($sql_delete)) {
                utility::jsToastr('Author Switcher', 'Pengarang Lama berhasil dihapus', 'success');
            } else {
                utility::jsToastr('Author Switcher', $dbs->error, 'error');
            }
        }
    } else {
        utility::jsToastr('Author Switcher', $dbs->error, 'error');
    }
}