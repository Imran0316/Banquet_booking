<?php
include("../db.php");

// Sample bookings for testing the Giggster-inspired calendar
$sample_bookings = [
    ['date' => '2025-01-15', 'time_slot' => 'Morning (10 AM - 2 PM)', 'banquet_id' => 1],
    ['date' => '2025-01-15', 'time_slot' => 'Evening (7 PM - 11 PM)', 'banquet_id' => 1],
    ['date' => '2025-01-20', 'time_slot' => 'Morning (10 AM - 2 PM)', 'banquet_id' => 1],
    ['date' => '2025-01-25', 'time_slot' => 'Evening (7 PM - 11 PM)', 'banquet_id' => 1],
    ['date' => '2025-01-30', 'time_slot' => 'Morning (10 AM - 2 PM)', 'banquet_id' => 1],
    ['date' => '2025-01-30', 'time_slot' => 'Evening (7 PM - 11 PM)', 'banquet_id' => 1],
    ['date' => '2025-02-05', 'time_slot' => 'Morning (10 AM - 2 PM)', 'banquet_id' => 1],
    ['date' => '2025-02-10', 'time_slot' => 'Evening (7 PM - 11 PM)', 'banquet_id' => 1],
    ['date' => '2025-02-15', 'time_slot' => 'Morning (10 AM - 2 PM)', 'banquet_id' => 1],
    ['date' => '2025-02-15', 'time_slot' => 'Evening (7 PM - 11 PM)', 'banquet_id' => 1],
];

// Clear existing test bookings
$stmt = $pdo->prepare("DELETE FROM bookings WHERE banquet_id = 1");
$stmt->execute();

// Insert sample bookings
$stmt = $pdo->prepare("INSERT INTO bookings (date, time_slot, banquet_id, user_id, status) VALUES (?, ?, ?, ?, ?)");

foreach ($sample_bookings as $booking) {
    $stmt->execute([
        $booking['date'],
        $booking['time_slot'],
        $booking['banquet_id'],
        1, // user_id
        'confirmed' // status
    ]);
}

echo "Sample bookings added successfully!<br>";
echo "You can now test the Giggster-inspired calendar by visiting: <a href='booking_page.php?id=1'>booking_page.php?id=1</a>";
?>
