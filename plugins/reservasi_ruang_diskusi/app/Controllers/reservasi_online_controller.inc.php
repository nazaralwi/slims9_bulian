<?php
// Load necessary models
require_once SB.'plugins'.DS.'reservasi_ruang_diskusi'.DS.'helper.php';

// Handle form submissions or other controller logic
if (isset($_POST['name'])) {
    reserveSchedule(); // Handle reservation schedule logic...
}

// Include the view
include SB.'plugins'.DS.'reservasi_ruang_diskusi'.DS.'app/Views/reservasi_online_view.inc.php';