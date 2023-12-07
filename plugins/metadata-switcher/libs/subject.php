<?php
/*
 * File: subject.php
 * Project: libs
 * File Created: Thursday, 25th November 2021 2:12:29 pm
 * Author: Waris Agung Widodo (ido.alit@gmail.com)
 * -----
 * Last Modified: Thursday, 25th November 2021 2:12:34 pm
 * Modified By: Waris Agung Widodo (ido.alit@gmail.com)
 * -----
 * License: GNU GPL v3
 */

global $dbs;

?>
<div class="pt-3">
    <p>
        Harap perhatikan data yang anda pilih karena saat sudah ter-submit tidak dapat dibatalkan. Pastikan juga anda telah <strong>membackup database</strong> anda!
    </p>
    <form class="form-inline" method="POST" action="<?= adminUrl('subject') ?>" target="blindSubmit">
        <div class="mr-2">
            <label for="topicID" class="justify-content-start">Subjek Lama</label>
            <select name="topic_lama" id="topicID" class="select2 form-control mb-2 mr-sm-2" 
                data-src="<?= AWB ?>AJAX_lookup_handler.php?format=json&amp;allowNew=true" data-src-table="mst_topic" 
                data-src-cols="topic_id:topic" placeholder="Subjek lama" style="display: none;">
                <option value="NONE"></option>
            </select>
        </div>

        <div class="mr-2">
            <label for="topicID2" class="justify-content-start">Subjek Baru</label>
            <select name="topic_baru" id="topicID2" class="select2 form-control mb-2 mr-sm-2" 
                data-src="<?= AWB ?>AJAX_lookup_handler.php?format=json&amp;allowNew=true" data-src-table="mst_topic" 
                data-src-cols="topic_id:topic" style="display: none;">
                <option value="NONE"></option>
            </select>
        </div>

        <div class="form-check mb-2 mr-sm-2 pt-4">
            <input class="form-check-input" type="checkbox" id="inlineFormCheck" value="1" name="delete">
            <label class="form-check-label" for="inlineFormCheck">
                Hapus Subjek Lama
            </label>
        </div>

        <div class="pt-4">
            <button type="submit" class="btn btn-primary mb-2">Submit</button>
        </div>
    </form>
</div>