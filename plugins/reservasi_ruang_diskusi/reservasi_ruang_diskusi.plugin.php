<?php
/**
 * Plugin Name: Reservasi Ruang Diskusi
 * Plugin URI: https://github.com/nazaralwi/plugin_reservasi_ruang_diskusi
 * Description: Plugin untuk Reservasi Ruang Diskusi
 * Version: 1.0.0
 * Author: Nazar Alwi
 * Author URI: nazaralwi.com
 */

// Discussion Room Reservation Base
define('DRRB', SB.'plugins'.DS.'reservasi_ruang_diskusi');

// get plugin instance
$plugin = \SLiMS\Plugins::getInstance();

// registering menus
$plugin->registerMenu('membership', 'Reservasi Ruang Diskusi', DRRB . DS . 'app/index.php');
$plugin->registerMenu('opac', 'Reservasi Ruang Diskusi', DRRB . DS . 'app/member/Controllers/reservasi_online_controller.inc.php');
