<?php

include __DIR__ . '/header.php';

$names = [
    ["Adinda Shabilla", "Universitas YARSI"],
    ["Citra Rachmani", "Universitas YARSI"],
    ["Khairul Rizal", "Universitas YARSI"],
    ["Miftahul Huda", "Universitas YARSI"],
    ["Siska Agustina", "Universitas YARSI"],
    ["Prio Bagas Wicaksono", "Universitas YARSI"],
    ["Abdulloh Arasyid", "Universitas YARSI"],
    ["Anisa Putri Yasmin", "Universitas YARSI"],
    ["Anna Evandra Aurelia", "Universitas YARSI"],
    ["Ayu Savina", "Universitas YARSI"],
    ["Azzahra Julianty Safitri", "Universitas YARSI"],
    ["Bagas Triandsa", "Universitas YARSI"],
    ["Candrakanti Rahisna Bramantya", "Universitas YARSI"],
    ["Fajar Adrian Rivai", "Universitas YARSI"],
    ["Farhan Kausar Samsu", "Universitas YARSI"],
    ["Fariha Subaiha Azhari", "Universitas YARSI"],
    ["Fitri Rahmawati", "Universitas YARSI"],
    ["Hanan Yumna Salimah", "Universitas YARSI"],
    ["Kayza Namira Putri", "Universitas YARSI"],
    ["Margi Ariyanti", "Universitas YARSI"],
    ["Mohammad Ilham Maulana", "Universitas YARSI"],
    ["Muhammad Faishal Hasyim", "Universitas YARSI"],
    ["Muhammad Ghanaya Nafii", "Universitas YARSI"],
    ["Nada Syahrani Putri", "Universitas YARSI"],
    ["Nadia Putri Firdani", "Universitas YARSI"],
    ["Nadya Putri Anggraeni", "Universitas YARSI"],
    ["Nadya Zahra Khaerunnisa", "Universitas YARSI"],
    ["Nazwa Syafira Riskyani", "Universitas YARSI"],
    ["Nilna Saadah", "Universitas YARSI"],
    ["Nur Hajja Nia Ramdhani", "Universitas YARSI"],
    ["Salsha Billa Yunita Sari", "Universitas YARSI"],
    ["Rafi Arrizqi Hidayat", "Universitas YARSI"],
    ["Shafiyah Alifah Rahmi", "Universitas YARSI"],
    ["Siti Rahmadhani Andevi Putri", "Universitas YARSI"],
    ["Syahla Aura Syahrial", "Universitas YARSI"],
    ["Tegar Restu Wijaya", "Universitas YARSI"],
    ["Sulthan Ihsan Ardiansyah", "Universitas YARSI"],
    ["Syifa Rahmania", "Universitas YARSI"],
    ["Thalia Putri Maharani", "Universitas YARSI"],
    ["Vita Anggreeni Safitri", "Universitas YARSI"],
    ["Anessa Feby", "Universitas YARSI"],
    ["Latifa Khorqi", "Universitas YARSI"],
    ["Meliyana Salsa Bila", "Universitas YARSI"],
    ["Muhammad Ilham Assofyan", "Universitas YARSI"],
    ["Oxana Nurzalfa Hakim", "Universitas YARSI"],
    ["Susilo Teguh Handoyono", "Universitas YARSI"],
];
?>

<div class="container-fluid">
    <dl class="row">
        <dt class="col-sm-3">Programmer</dt>
        <dd class="col-sm-9">
            <a target="_blank" href="https://github.com/idoalit">Waris Agung Widodo</a>
        </dd>

        <dt class="col-sm-3">Data Coordinator</dt>
        <dd class="col-sm-9">Danang Dwijo Kangko</dd>

        <dt class="col-sm-3">Data Entry</dt>
        <dd class="col-sm-9">
            <ul class="list-unstyled">
                <?php
                foreach ($names as $name) {
                    echo '<li>'. $name[0] .' &mdash; '.$name[1].'</li>';
                }
                ?>
            </ul>
        </dd>
    </dl>
</div>