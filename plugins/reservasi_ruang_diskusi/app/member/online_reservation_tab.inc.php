<?php
require_once DRRB . DS . 'app/helper/reservation_utils.php';

function sortByDate($a, $b)
{
    $dateA = strtotime($a->reservation_date);
    $dateB = strtotime($b->reservation_date);

    return $dateB - $dateA; // Compare in reverse order for descending
}

function getMinutesAndSecond($time)
{
    $timeParts = explode(":", $time);
    $formattedTime = $timeParts[0] . ":" . $timeParts[1];
    return $formattedTime;
}

function convertDate($dateString)
{
    // Convert date string to timestamp
    $timestamp = strtotime($dateString);

    // Format the date as 'd MonthName YYYY'
    $formattedDate = date('j F Y', $timestamp);

    return $formattedDate;
}

// Update reservation status if any
updateStatusForExpiredReservations();

?>
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="form-tab" data-toggle="tab" href="#form" role="tab" aria-controls="form" aria-selected="true">Form</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="false">List</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">History</a>
    </li>
</ul>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="form" role="tabpanel" aria-labelledby="form-tab">
        <?php require DRRB . DS . 'app/member/online_reservation_form.inc.php'; ?>
    </div>
    <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="list-tab">
        <?php require DRRB . DS . 'app/member/online_reservation_grid.inc.php'; ?>
    </div>
    <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
        <?php require DRRB . DS . 'app/member/online_reservation_history_grid.inc.php'; ?>
    </div>
</div>


<!-- Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>