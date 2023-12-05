<?php
/**
 * Plugin Name: Reservasi Ruang Diskusi
 * Plugin URI: https://github.com/drajathasan/member_self_registration
 * Description: Plugin untuk Reservasi Ruang Diskusi
 * Version: 1.0.0
 * Author: Nazar Alwi
 * Author URI: Nazar Alwi
 */

// get plugin instance
$plugin = \SLiMS\Plugins::getInstance();

// registering menus
$plugin->registerMenu('membership', 'Reservasi Ruang Diskusi', __DIR__ . '/index.php');
$plugin->registerMenu('opac', 'Reservasi Ruang Diskusi', __DIR__ . '/reservasi_online.inc.php');
