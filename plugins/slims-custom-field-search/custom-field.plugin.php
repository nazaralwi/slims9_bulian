<?php
/**
 * Plugin Name: Custom Field
 * Plugin URI: https://github.com/drajathasan/slims-custom-field
 * Description: Add search filter for custom field
 * Version: 1.0.0
 * Author: Drajat Hasan
 * Author URI: https://github.com/drajathasan
 */

 /**
 * Get plugin instance
 */
$plugin = \SLiMS\Plugins::getInstance();

$plugin->register('membership_init', function(){
    global $dbs,$sysconf;
    include __DIR__ . '/pages/membership-index.php';
    exit;
});