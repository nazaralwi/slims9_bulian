<?php
/*
 * File: gmd.php
 * Project: libs
 * File Created: Thursday, 25th November 2021 9:42:40 am
 * Author: Waris Agung Widodo (ido.alit@gmail.com)
 * -----
 * Last Modified: Thursday, 25th November 2021 9:42:47 am
 * Modified By: Waris Agung Widodo (ido.alit@gmail.com)
 * -----
 * License: GNU GPL v3
 */

 global $dbs;

 $gmds = [];
 $query = $dbs->query('select gmd_id, gmd_name from mst_gmd');
 while ($data = $query->fetch_assoc()) $gmds[] = $data;

?>
<div class="pt-3">
    <p>
        Harap perhatikan data yang anda pilih karena saat sudah ter-submit tidak dapat dibatalkan. Pastikan juga anda telah <strong>membackup database</strong> anda!
    </p>
    <form class="form-inline" method="POST" action="<?= adminUrl('gmd') ?>" target="blindSubmit">
        <label class="sr-only" for="inlineFormInputName2">GMD Lama</label>
        <select name="gmd_lama" class="form-control mb-2 mr-sm-2" required>
            <option value="">--Pilih GMD Lama--</option>
            <?php foreach ($gmds as $gmd): ?>
            <option value="<?= $gmd['gmd_id'] ?>"><?= $gmd['gmd_name'] ?></option>
            <?php endforeach; ?>
        </select>

        <label class="sr-only" for="inlineFormInputGroupUsername2">GMD Baru</label>
        <select name="gmd_baru" class="form-control mb-2 mr-sm-2" required>
            <option value="">--Pilih GMD Baru--</option>
            <?php foreach ($gmds as $gmd): ?>
            <option value="<?= $gmd['gmd_id'] ?>"><?= $gmd['gmd_name'] ?></option>
            <?php endforeach; ?>
        </select>

        <div class="form-check mb-2 mr-sm-2">
            <input class="form-check-input" type="checkbox" id="inlineFormCheck" value="1" name="delete">
            <label class="form-check-label" for="inlineFormCheck">
                Hapus GMD Lama
            </label>
        </div>

        <button type="submit" class="btn btn-primary mb-2">Submit</button>
    </form>
</div>