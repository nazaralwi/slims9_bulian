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
$plugins->registerMenu('opac', 'Member', DRRB . DS . 'app/index_member.php');
$plugin->registerMenu('opac', 'Jadwal Ruang Diskusi', DRRB . DS . 'app/index_opac.php');

// For AJAX request
$plugin->registerMenu('opac', 'Populate Schedule', DRRB . DS . 'app/reservation_logic/populate_schedule.php');
$plugin->registerMenu('opac', 'Reservation Calendar', DRRB . DS . 'app/opac/reservation_schedule_for_ajax.php');