<?php

use DTSIslam\Lib\Url;

include __DIR__ . '/header.php';

?>

<div class="container-fluid">
    <div class="row align-items-center mb-3">
        <div class="col-md-2">
            <button class="btn btn-primary btn-sm btn-block startMigrating">
                Start Migrating
            </button>
        </div>
        <div class="col-md-10">
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
            </div>
        </div>
    </div>
    <div class="card card-body bg-dark text-light text-monospace log"></div>
</div>

<script>
    const baseUrl = '<?= Url::adminSection('/') ?>'

    class UseDTS {
        constructor() {
            this.biblioTopicCount = this.getBiblioTopicCount()
        }

        getBiblioTopicCount() {
            return fetch(`${baseUrl}biblio/topic/count`)
                .then(res => res.json())
                .then(res => res.data)
        }

        async doMigrate() {
            let migrated = 0
            const perBatch = 100
            const batch = Math.ceil((await this.biblioTopicCount) / perBatch)
            $('.progress-bar').css('width', '0.1%')
            for (let b = 1; b <= batch; b++) {
                this.log(`Run for batch ${b} of ${batch}`)
                try {
                    const m = await fetch(`${baseUrl}biblio/topic/migrate`, {
                        method: 'post',
                        body: JSON.stringify({
                            batch: b,
                            total: batch,
                            perbatch: perBatch
                        })
                    })
                    const r = await m.json()
                    migrated += r.migrated

                    // if any error
                    r.error.map(m => this.log(m, true))

                    $('.progress-bar').css('width', ((b / batch) * 100) + '%')
                } catch (error) {
                    this.log(error, true)
                }
            }

            // finished
            $('.progress-bar').removeClass('progress-bar-animated').addClass('bg-success')
            this.log('Done!')

            return migrated
        }

        log(message, isError = false) {
            const d = new Date;
            $('.log').append(`<div ${isError?'class="text-danger"':''}>${d.getFullYear()}-${d.getMonth()}-${d.getDate()} ${d.getHours()}:${d.getMinutes()}:${d.getSeconds()} > ${message}</div>`);
            if ($('.log').children().length > 10) $('.log').find('div:first').remove();
        }
    }

    (async () => {
        const dts = new UseDTS()
        dts.log(`Your biblio topics ~${await dts.biblioTopicCount}`)

        const btnMerge = $('.startMigrating')
        btnMerge.click(async () => {
            const migrated = await dts.doMigrate()
            dts.log(`Migrated data: ~${migrated}`)
        })
    })()
</script>