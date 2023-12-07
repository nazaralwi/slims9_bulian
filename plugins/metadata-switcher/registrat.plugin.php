<?php
/*
 * File: registrat.plugin.php
 * Project: metadata_switcher
 * File Created: Thursday, 25th November 2021 9:01:54 am
 * -----
 * Plugin Name: Metadata Switcher
 * Plugin URI: https://github.com/idoalit/metadata-switcher
 * Description: Mengganti semua data terkait ke yang baru. Contohnya jika kamu ingin memperbaiki pengarang yang double.
 * Version: 1.0.0
 * Author: Waris Agung Widodo
 * Author URI: https://github.com/idoalit
 * -----
 * Last Modified: Thursday, 25th November 2021 9:02:02 am
 * Modified By: Waris Agung Widodo (ido.alit@gmail.com)
 * -----
 * License: GNU GPL v3
 */

use SLiMS\Plugins;

require_once __DIR__ . '/function.php';

$plugin = Plugins::getInstance();

$plugin->registerMenu('master_file', 'Metadata Switcher', __DIR__ . '/index.php');
