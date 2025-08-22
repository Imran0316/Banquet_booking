<?php
session_start();
include("../db.php");

$bookingId = $_GET['booking_id'] ?? null;
if ($bookingId) {
   
    $stmt = $pdo->prepare(query: "UPDATE bookings SET status = 'canceled' WHERE id = ?");
    $stmt->execute([$bookingId]);


    header("Location: my_bookings.php");
    $_SESSION['success'] = "Booking canceled successfully.";
    exit();
} else {

    $_SESSION['error'] = "Invalid Booking Id.";

}

?>