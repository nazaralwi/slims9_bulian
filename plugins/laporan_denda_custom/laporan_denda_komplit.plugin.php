<?php
/**
 * Plugin Name: Laporan Denda Komplit
 * Plugin URI: -
 * Description: Kustom fitur laporan denda pertanggal
 * Version: 1.0.0
 * Author: Drajat Hasan
 * Author URI: https://t.me/drajathasan
 */

// get plugin instance
$plugin = \SLiMS\Plugins::getInstance();

// registering menus or hook
$plugin->registerMenu("reporting", "Laporan Dendan Kustom", __DIR__ . "/fines_report.php");