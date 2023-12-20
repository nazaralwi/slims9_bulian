<?php

require 'vendor/autoload.php';
require DRRB .DS. 'app/Models/Reservation.php';

use benhall14\phpCalendar\Calendar as Calendar;

$calendar = new Calendar;
$reservationEvents = Reservation::getAllEvents();
$events = [];

function getMinutesAndSecond($time) {
    $timeParts = explode(":", $time);
    $formattedTime = $timeParts[0] . ":" . $timeParts[1];
    return $formattedTime;
}

foreach ($reservationEvents as $event) {
    $events[] = array(
        'start' => $event->reserved_date.' '.getMinutesAndSecond($event->start_time),
        'end' => $event->reserved_date.' '.getMinutesAndSecond($event->end_time),
        'summary' => $event->activity,
        'mask' => false,
    );
}

$calendar
->hideSaturdays()
->hideSundays()
->setTimeFormat('08:00', '16:00', 15)
->useWeekView()
->addEvents($events)
->display(date('Y-m-d'), 'grey');
