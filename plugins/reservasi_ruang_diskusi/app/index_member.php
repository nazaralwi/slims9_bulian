<?php
// Load necessary models
require_once DRRB . DS . 'helper/helper.php';

use DiscussionRoomReservation\Lib\Url;

// Handle form submissions or other controller logic
reserveSchedule(Url::memberSection()); // Handle reservation schedule logic...

// Include the view
include DRRB . DS . 'app/Views/member/reservasi_online_view.inc.php';
