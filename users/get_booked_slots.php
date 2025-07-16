<?php
include("../db.php");

if (isset($_GET['date'])) {
    $date = $_GET['date'];

    $stmt = $pdo->prepare("SELECT time_slot FROM bookings WHERE date = ?");
    $stmt->execute([$date]);

    $bookedSlots = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $bookedSlots[] = $row['time_slot'];
    }

    echo json_encode($bookedSlots);
}
?>
