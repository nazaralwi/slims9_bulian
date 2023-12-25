<?php

require_once DRRB . DS . 'app/helper/reservation_utils.php';

$reservations = getReservationByMemberId($_SESSION['mid']);

$reservations = array_filter($reservations, function ($reservation) {
    return $reservation->status !== 'ongoing';
});

function sortByDate($a, $b) {
  $dateA = strtotime($a->reservationLastUpdate);
  $dateB = strtotime($b->reservationLastUpdate);

  return $dateB - $dateA; // Compare in reverse order for descending
}

usort($reservations, 'sortByDate');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['itemID']) && !empty($_POST['itemID']) && isset($_POST['itemAction']) && $_POST['itemAction'] === 'cancel') {
      cancelReservationByMember('index.php?p=member&sec=discussion_room_reservation_list');
  }
}
?>

<div class="list-group">
  <?php if (count($reservations) != 0) : ?>
  <?php foreach ($reservations as $reservation): ?>
    <a href="" class="list-group-item list-group-item-action flex-column align-items-start">
      <div class="d-flex w-100 align-items-center justify-content-between">
        <h5 class="mb-1"><?= $reservation->activity ?></h5>
        <?php if ($reservation->status == 'cancelled') : ?>
          <small class="badge badge-danger">Cancelled</small>
        <?php elseif (($reservation->status == 'completed')): ?>
          <small class="badge badge-success">Completed</small>
        <?php endif;?>
      </div>
      <p class="mb-1">Jadwal: <?= convertDate($reservation->reservedDate) . ' <strong>' . getMinutesAndSecond($reservation->startTime) . '</strong>-<strong>' . getMinutesAndSecond($reservation->endTime) . '</strong>'?></p>
      <small>Jumlah anggota: <?= $reservation->visitorNumber ?> orang</small>
    </a>
  <?php endforeach; ?>
  <?php else: ?>
    <div class="alert alert-secondary text-center" role="alert">
      No reservation history
    </div>
  <?php endif; ?>
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