<div class="menuBox">
    <div class="menuBoxInner memberIcon">
        <div class="per_title">
            <h2><?= $page_title ?></h2>
        </div>
        <div class="sub_section">
            <div class="btn-group">
                <a href="<?= Url::adminSection('/reservationScheduleList') ?>" class="btn btn-primary">Daftar Jadwal Reservasi</a>
                <a href="<?= Url::adminSection('/onsiteReservation') ?>" class="btn btn-success">Reservasi Onsite</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.editLink').forEach((el) => {
        el.href = el.getAttribute('href').replace(/(\&sec=%2FreservationScheduleList)/g, '');
    });

    const form = document.querySelector('.simbio_form_maker');
    if (form !== null) {
        form.setAttribute('action', '<?= Url::adminSection('/editReservation') ?>');
    }
</script>