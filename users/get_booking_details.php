<?php
session_start();
include("../db.php");

header('Content-Type: application/json');

if (!isset($_GET['booking_id'])) {
    echo json_encode(['error' => 'Booking ID is required']);
    exit;
}

$booking_id = intval($_GET['booking_id']);

try {
    $stmt = $pdo->prepare("SELECT 
        bookings.id,
        bookings.date,
        bookings.time_slot AS booking_time,
        bookings.status AS booking_status,
        banquets.name AS banquet_name,
        banquets.price,
        banquets.capacity,
        banquets.location AS banquet_address,
        banquets.image AS banquet_image
    FROM bookings
    JOIN banquets ON bookings.banquet_id = banquets.id
    WHERE bookings.id = ?");

    $stmt->execute([$booking_id]);
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($booking) {
        echo json_encode($booking);
    } else {
        echo json_encode(['error' => 'Booking not found']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
}
