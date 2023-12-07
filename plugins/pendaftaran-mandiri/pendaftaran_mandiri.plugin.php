<?php
/**
 * Plugin Name: Pendaftaran Mandiri
 * Plugin URI: https://github.com/idoalit/pendaftaran-mandiri
 * Description: Pendaftaran mandiri di OPAC
 * Version: 1.0.1
 * Author: Waris Agung Widodo
 * Author URI: https://github.com/idoalit
 */

// get plugin instance
$plugin = \SLiMS\Plugins::getInstance();

// register plugins
$plugin->registerMenu('opac', 'Pendaftaran mandiri', __DIR__ . '/daftar_opac.php', 'Pendaftaran mandiri');

$plugin->registerMenu('membership', 'Pendaftaran Mandiri', __DIR__ . '/daftar_admin.php', 'Daftar anggota yang sudah mendaftar di pendaftaran mandiri');