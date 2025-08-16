<?php
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
        }

        .success-card {
            max-width: 700px;
            margin: 50px auto;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .success-header {
            background: linear-gradient(135deg, #8B0000, goldenrod);
            color: #fff;
            border-radius: 15px 15px 0 0;
            padding: 20px;
            text-align: center;
        }

        .success-body {
            padding: 25px;
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
            <p>Thank you <strong class="text-uppercase"><?php echo htmlspecialchars($booking['name']); ?> </strong>, your booking was successful.</p>
        </div>
        <div class="success-body">
            <h5 class="mb-3">Booking Details</h5>
            <p><span class="info-label">Booking ID:</span> <?php echo $booking['id']; ?></p>
            <p><span class="info-label">Banquet:</span> <?php echo htmlspecialchars($booking['banquet_name']); ?></p>
            <p><span class="info-label">Location:</span> <?php echo htmlspecialchars($booking['location']); ?></p>
            <p><span class="info-label">Date:</span> <?php echo $booking['date']; ?></p>
            <p><span class="info-label">Time Slot:</span> <?php echo $booking['time_slot']; ?></p>

            <hr>
            <h5 class="mb-3">Payment Details</h5>
            <p><span class="info-label">Payment ID:</span> <?php echo rand() .  $payment['id'] ; ?></p>
            <p><span class="info-label">Amount Paid:</span> Rs. <?php echo number_format($payment['amount'], 2); ?></p>
            <p><span class="info-label">Payment Method:</span> <?php echo ucfirst($payment['method']); ?></p>
            <p><span class="info-label">Status:</span>
                <span class="badge bg-success"><?php echo ucfirst($payment['status']); ?></span>
            </p>

            <div class="mt-4 text-center">
                <a href="my_bookings.php" class="btn btn-success me-2">View My Bookings</a>
                <a href="index.php" class="btn btn-outline-dark">Go to Home</a>
            </div>
        </div>
    </div>
</body>

</html>