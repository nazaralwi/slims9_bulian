<?php

use DTSIslam\Lib\Url;
?>
<div class="menuBox">
    <div class="menuBoxInner circulationIcon">
        <div class="per_title">
            <h2><?= $title ?? '' ?></h2>
        </div>
        <div class="infoBox"><?= $description ?? '' ?></div>
        <div class="sub_section">
            <div class="btn-group">
                <a href="<?= Url::adminSection('/merge'); ?>" class="btn btn-primary"><?= __('Merge subject'); ?></a>
                <a href="<?= Url::adminSection('/use'); ?>" class="btn btn-success"><?= __('Use DTS Islam'); ?></a>
                <!-- <a href="<?= Url::adminSection('/drop'); ?>" class="btn btn-danger"><?= __('Drop DTS Islam'); ?></a> -->
                <a href="<?= Url::adminSection('/credits'); ?>" class="btn btn-info"><?= __('Credits'); ?></a>
            </div>
        </div>
    </div>
</div>