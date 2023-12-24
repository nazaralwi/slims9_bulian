<?php

require_once DRRB . DS . 'app/helper/reservation_utils.php';

$reservations = getReservationByMemberId($_SESSION['mid']);
?>

<div class="list-group">
  <?php foreach ($reservations as $reservation): ?>
    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1"><?= $reservation->activity ?></h5>
        <small><?= $reservation->duration . ' mins' ?></small>
      </div>
      <p class="mb-1">Jadwal: <?= convertDate($reservation->reservedDate) . ' <strong>' . getMinutesAndSecond($reservation->startTime) . '</strong>-<strong>' . getMinutesAndSecond($reservation->endTime) . '</strong>'?></p>
      <small>Jumlah anggota: <?= $reservation->visitorNumber ?> orang</small>
    </a>
  <?php endforeach; ?>
</div>

<?php

function getMinutesAndSecond($time) {
  $timeParts = explode(":", $time);
  $formattedTime = $timeParts[0] . ":" . $timeParts[1];
  return $formattedTime;
}


function convertDate($dateString) {
  // Convert date string to timestamp
  $timestamp = strtotime($dateString);

  // Format the date as 'd MonthName YYYY'
  $formattedDate = date('j F Y', $timestamp);

  return $formattedDate;
}