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
    );
}
?>

<?php
$calendar
->hideSaturdays()
->hideSundays()
->setTimeFormat('08:00', '16:00', 15)
->useWeekView()
->addEvents($events);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newDate'])) {
  $newDate = $_POST["newDate"];

  $calendar->display($newDate, 'grey');
} else {
  $calendar->display(date('Y-m-d'), 'grey');
}
exit;
?>