<?php
/*
 * File: place.php
 * Project: libs
 * File Created: Thursday, 25th November 2021 2:19:23 pm
 * Author: Waris Agung Widodo (ido.alit@gmail.com)
 * -----
 * Last Modified: Thursday, 25th November 2021 2:19:47 pm
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
    <form class="form-inline" method="POST" action="<?= adminUrl('place') ?>" target="blindSubmit">
        <div class="mr-2">
            <label for="placeID" class="justify-content-start">Tempat Terbit Lama</label>
            <select name="place_lama" id="placeID" class="select2 form-control mb-2 mr-sm-2" 
                data-src="<?= AWB ?>AJAX_lookup_handler.php?format=json&amp;allowNew=true" data-src-table="mst_place" 
                data-src-cols="place_id:place_name" placeholder="Tempat Terbit lama" style="display: none;">
                <option value="NONE"></option>
            </select>
        </div>

        <div class="mr-2">
            <label for="placeID2" class="justify-content-start">Tempat Terbit Baru</label>
            <select name="place_baru" id="placeID2" class="select2 form-control mb-2 mr-sm-2" 
                data-src="<?= AWB ?>AJAX_lookup_handler.php?format=json&amp;allowNew=true" data-src-table="mst_place" 
                data-src-cols="place_id:place_name" style="display: none;">
                <option value="NONE"></option>
            </select>
        </div>

        <div class="form-check mb-2 mr-sm-2 pt-4">
            <input class="form-check-input" type="checkbox" id="inlineFormCheck" value="1" name="delete">
            <label class="form-check-label" for="inlineFormCheck">
                Hapus Tempat Terbit Lama
            </label>
        </div>

        <div class="pt-4">
            <button type="submit" class="btn btn-primary mb-2">Submit</button>
        </div>
    </form>
</div>