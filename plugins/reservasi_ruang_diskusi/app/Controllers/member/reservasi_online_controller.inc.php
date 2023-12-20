<?php
// Load necessary models
require_once DRRB . DS . 'helper/helper.php';

// Handle form submissions or other controller logic
if (isset($_POST['name'])) {
    reserveSchedule(); // Handle reservation schedule logic...
}

// Include the view
include DRRB . DS . 'app/Views/member/reservasi_online_view.inc.php';