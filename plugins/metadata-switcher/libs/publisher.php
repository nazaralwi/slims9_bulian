<?php
/*
 * File: publisher.php
 * Project: libs
 * File Created: Thursday, 25th November 2021 1:04:45 pm
 * Author: Waris Agung Widodo (ido.alit@gmail.com)
 * -----
 * Last Modified: Thursday, 25th November 2021 1:04:51 pm
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
    <form class="form-inline" method="POST" action="<?= adminUrl('publisher') ?>" target="blindSubmit">
        <div class="mr-2">
            <label for="publisherID" class="justify-content-start">Penerbit Lama</label>
            <select name="publisher_lama" id="publisherID" class="select2 form-control mb-2 mr-sm-2" 
                data-src="<?= AWB ?>AJAX_lookup_handler.php?format=json&amp;allowNew=true" data-src-table="mst_publisher" 
                data-src-cols="publisher_id:publisher_name" placeholder="Penerbit lama" style="display: none;">
                <option value="NONE"></option>
            </select>
        </div>

        <div class="mr-2">
            <label for="publisherID2" class="justify-content-start">Penerbit Baru</label>
            <select name="publisher_baru" id="publisherID2" class="select2 form-control mb-2 mr-sm-2" 
                data-src="<?= AWB ?>AJAX_lookup_handler.php?format=json&amp;allowNew=true" data-src-table="mst_publisher" 
                data-src-cols="publisher_id:publisher_name" style="display: none;">
                <option value="NONE"></option>
            </select>
        </div>

        <div class="form-check mb-2 mr-sm-2 pt-4">
            <input class="form-check-input" type="checkbox" id="inlineFormCheck" value="1" name="delete">
            <label class="form-check-label" for="inlineFormCheck">
                Hapus Penerbit Lama
            </label>
        </div>

        <div class="pt-4">
            <button type="submit" class="btn btn-primary mb-2">Submit</button>
        </div>
    </form>
</div>