<?php
/**
 * Plugin Name: Loan History Helper
 * Plugin URI: https://github.com/drajathasan/slims-loan-history-helper
 * Description: Plugin untuk mengenerate ulang isi dari tabel loan history
 * Version: 1.0.0
 * Author: Drajat Hasan
 * Author URI: https://t.me/drajathasan
 */

// get plugin instance
$plugin = \SLiMS\Plugins::getInstance();

// registering menus or hook
$plugin->registerMenu("system", "Indeks Sejarah Peminjaman", __DIR__ . "/index.php");