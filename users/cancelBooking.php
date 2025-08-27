<?php
session_start();
// ensure user logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}
include "../db.php"; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
 
    $booking_id = isset($_POST['booking_id']) ? intval($_POST['booking_id']) : 0;

    if ($booking_id > 0) {
        try {
           
            $stmt = $pdo->prepare("UPDATE bookings SET status = 'canceled' WHERE id = ? ");
            $stmt->execute(params: [$booking_id]);

            if ($stmt->rowCount() > 0) {
                $_SESSION["success"] = "Booking cancelled successfully.";
                header("Location: my_bookings.php");
                exit();
            } else {
                $_SESSION["error"] = "Booking not found or already cancelled.";
                header("Location: my_bookings.php");
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION["error"] = "Error: " . $e->getMessage();
            header("Location: my_bookings.php");
            exit();
        }
    } else {
        $_SESSION["error"] = "Invalid Id.";
        header("Location: my_bookings.php");
        exit();
    }
} else {
    $_SESSION["error"] = " Invalid request method.";
    header("Location: my_bookings.php");
    exit();
}
