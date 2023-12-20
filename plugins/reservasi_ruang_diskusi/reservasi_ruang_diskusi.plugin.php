<?php
/**
 * Plugin Name: Reservasi Ruang Diskusi
 * Plugin URI: https://github.com/nazaralwi
 * Description: Plugin untuk Reservasi Ruang Diskusi
 * Version: 1.0.0
 * Author: Nazar Alwi
 * Author URI: https://nazaralwi.com
 */

// Discussion Room Reservation Base
define('DRRB', SB.'plugins'.DS.'reservasi_ruang_diskusi');
require_once DRRB. '/lib/vendor/autoload.php';

// get plugin instance
$plugin = \SLiMS\Plugins::getInstance();

// registering menus
$plugin->registerMenu('membership', 'Reservasi Ruang Diskusi', DRRB . DS . 'app/index_admin.php');
$plugin->registerMenu('opac', 'Reservasi Ruang Diskusi', DRRB . DS . 'app/index_member.php');
$plugin->registerMenu('opac', 'Jadwal Ruang Diskusi', DRRB . DS . 'app/index_opac.php');
