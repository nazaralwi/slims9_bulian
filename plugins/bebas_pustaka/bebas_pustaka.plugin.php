<?php
/**
 * Plugin Name: Bebas Pustaka
 * Plugin URI: -
 * Description: Belajar membuat plugin kustom page
 * Version: 1.0.0
 * Author: Foo
 * Author URI: https://foo.who
 */
use SLiMS\Plugins;
$plugins = Plugins::getInstance();

$plugins->registerMenu('opac', 'bebas_pustaka', __DIR__ . '/bebas_pustaka.php');
