<?php
session_start();
// ensure user logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}
// checkout_success.php
require_once "../db.php"; // database connection file

// --- Step 1: Get booking_id & payment_id from URL ---
$bookingId = isset($_GET['bookingId']) ? $_GET['bookingId'] : null;
$paymentId = isset($_GET['paymentId']) ? $_GET['paymentId'] : null;

if (!$bookingId || !$paymentId) {
    die("Invalid request.");
}

// --- Step 2: Fetch booking details ---
$stmt = $pdo->prepare("
    SELECT b.id, b.date, b.time_slot, b.created_at,bn.name AS banquet_name,
            bn.location, bn.capacity, bn.price,
           u.name, u.email, u.phone
    FROM bookings b
    JOIN banquets bn ON b.banquet_id = bn.id
    JOIN users u ON b.user_id = u.id
    WHERE b.id = ?
");
$stmt->execute([$bookingId]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

// --- Step 3: Fetch payment details ---
$stmt = $pdo->prepare("SELECT id, amount, method, status, created_at FROM payments WHERE id = ?");
$stmt->execute([$paymentId]);
$payment = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking || !$payment) {
    die("Booking or Payment not found.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Booking Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f9f9f9;
            background-image: url('../assets/images/success.png') !important;
            background-size: cover;
            background-position: center;

        }

        .success-card {
            max-width: 700px;
            margin: 50px auto;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(165, 0, 0, 0.1);
            background: transparent !important;
            backdrop-filter: blur(15px);

        }

        .success-header {
            backdrop-filter: blur(5px);
            background: transparent;
            color: maroon;
            border-radius: 15px 15px 0 0;
            padding: 20px;
            text-align: center;
        }

        .success-body {
            padding: 25px;
            display: flex;
            justify-content: center;
            align-items: start;
        
        }

        .info-label {
            font-weight: 600;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="card success-card">
        <div class="success-header">
            <h2>Booking Confirmed!</h2>
            <p>Thank you <strong class="text-uppercase"><?php echo htmlspecialchars($booking['name']); ?> </strong>,
                your booking was successful.</p>
        </div>
        <div class="success-body">
            <div class="left border-end border-dark pe-3">
                <h5 class="mb-3">Booking Details</h5>
                <p><span class="info-label">Booking ID:</span> <?php echo $booking['id']; ?></p>
                <p><span class="info-label">Banquet:</span> <?php echo htmlspecialchars($booking['banquet_name']); ?>
                </p>
                <p><span class="info-label">Location:</span> <?php echo htmlspecialchars($booking['location']); ?></p>
                <p><span class="info-label">Date:</span> <?php echo $booking['date']; ?></p>
                <p><span class="info-label">Time Slot:</span> <?php echo $booking['time_slot']; ?></p>
            </div>
        
            <div class="right ps-3">
                <h5 class="mb-3">Payment Details</h5>
                <p><span class="info-label">Payment ID:</span> <?php echo rand() . $payment['id']; ?></p>
                <p><span class="info-label">Amount Paid:</span> Rs. <?php echo number_format($payment['amount'], 2); ?>
                </p>
                <p><span class="info-label">Payment Method:</span> <?php echo ucfirst($payment['method']); ?></p>
                <p><span class="info-label">Status:</span>
                    <span class="badge text-dark"><?php echo ucfirst($payment['status']); ?></span>
                </p>
            </div>

        </div>
        <div class="m-4 text-center">
            <a href="my_bookings.php" style="background-color: maroon; color: white; " class="btn  me-2">View My Bookings</a>
            <a href="../index.php" style="border: 1px solid goldenrod; color: goldenrod; " class="btn ">Go to Home</a>
        </div>
    </div>
</body>

</html>