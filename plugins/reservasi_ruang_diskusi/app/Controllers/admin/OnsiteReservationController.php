<?php

namespace DiscussionRoomReservation\App\Controllers;

use DiscussionRoomReservation\App\Views\View;

class OnsiteReservationController {
    function index() {
        View::load(
            'reserved_schedule'
        );
    }
}