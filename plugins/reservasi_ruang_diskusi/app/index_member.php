<?php
// Load necessary models
require_once DRRB . DS . 'app/helper/helper.php';

use DiscussionRoomReservation\Lib\Url;

// Handle form submissions or other controller logic
reserveSchedule(Url::memberSection()); // Handle reservation schedule logic...

// Include the view
include DRRB . DS . 'app/member/online_reservation_form.inc.php';
