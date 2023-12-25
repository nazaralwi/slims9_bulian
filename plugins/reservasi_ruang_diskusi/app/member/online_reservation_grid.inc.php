<?php

require_once DRRB . DS . 'app/helper/reservation_utils.php';

$reservations = getReservationByMemberId($_SESSION['mid']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['itemID']) && !empty($_POST['itemID']) && isset($_POST['itemAction']) && $_POST['itemAction'] === 'cancel') {
      cancelReservationByMember('index.php?p=member&sec=discussion_room_reservation_list');
  }
}
?>

<div class="list-group">
  <?php foreach ($reservations as $reservation): ?>
    <a href="" class="list-group-item list-group-item-action flex-column align-items-start">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1"><?= $reservation->activity ?></h5>
        <form method="post">
            <!-- Add a hidden input field for itemID -->
            <input type="hidden" name="itemID" value="<?= $reservation->reservationId ?>">

            <!-- Add a submit button to trigger the form submission -->
            <small><button type="submit" class="btn btn-danger" name="itemAction" value="cancel">Cancel Reservation</button></small>
        </form>
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