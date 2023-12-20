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
        'start' => $event->reservedDate.' '.getMinutesAndSecond($event->startTime),
        'end' => $event->reservedDate.' '.getMinutesAndSecond($event->endTime),
        'summary' => $event->name . "<br>" . $event->activity,
        'mask' => false,
        // 'classes' => ['contohClass']
    );
}
?>
<!-- <style>
    .contohClass {
        background-color: #000000;
    }
</style> -->
<div class="text-right mb-2">
    <button type="button" id="nextWeekBtn" class="btn btn-secondary">Next Week</button>
    <button type="button" id="todayWeekBtn" class="btn btn-secondary">Today's Week</button>
    <button type="button" id="prevWeekBtn" class="btn btn-secondary">Previous Week</button>
</div>

<?php
$calendar
->hideSaturdays()
->hideSundays()
->setTimeFormat('08:00', '16:00', 15)
->useWeekView()
->addEvents($events)
->display(date('Y-m-d'), 'grey');
