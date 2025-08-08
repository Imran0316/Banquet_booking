<?php
header('Content-Type: application/json');
include("../db.php");

$banquet_id = $_GET["id"];
if (!$banquet_id) {
    echo json_encode(["error" => "Missing ID"]);
    exit;
}

$banquet_id = $_GET["id"];
$stmt = $pdo->query("SELECT date, time_slot FROM bookings WHERE banquet_id = $banquet_id");
$slotCounts = [];
$detailedBookings = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $date = date("Y-m-d", strtotime($row['date'])); // ✅ Proper format for flatpickr
    if (!isset($slotCounts[$date])) {
        $slotCounts[$date] = [];
        $detailedBookings[$date] = [];
    }
    $slotCounts[$date][] = $row['time_slot'];
    $detailedBookings[$date][] = $row['time_slot'];
}

$fullyBooked = [];
$partiallyBooked = [];

foreach ($slotCounts as $date => $slots) {
    if (in_array("Morning (10 AM - 2 PM)", $slots) && in_array("Evening (7 PM - 11 PM)", $slots)) {
        $fullyBooked[] = $date;
    } else {
        $partiallyBooked[] = $date;
    }
}

echo json_encode([
    "fullyBooked" => $fullyBooked,
    "partiallyBooked" => $partiallyBooked,
    "detailedBookings" => $detailedBookings
]);
?>
