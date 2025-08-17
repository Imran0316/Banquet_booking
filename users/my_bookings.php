<?php
session_start();
include("../db.php");
include("include/header.php");
$page = "inner";
include("include/navbar.php");

// Fetch bookings for the logged-in user
$userId = $_SESSION['id'] ?? null;
$stmt = $pdo->prepare("
    SELECT b.id, b.date, b.time_slot, b.status, b.created_at, bn.name AS banquet_name,
           bn.location,bn.image AS banquet_image, bn.capacity, bn.price, bn.id AS banquet_id, u.name AS user_name
    FROM bookings b
    JOIN banquets bn ON b.banquet_id = bn.id
    JOIN users u ON b.user_id = u.id
    WHERE u.id = ?");
$stmt->execute([$userId]);

?>

\
<!-- My Bookings Section -->
<section class="my-bookings py-5">
    <div class="container">
        <h2 class="mb-4 fw-bold ">My Bookings</h2>

        <!-- Booking Card -->
        <div class="card mb-4 shadow-sm border border-1 rounded-3">
            <div class="row g-0">
                 <?php 
                 foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $booking): ?>
                 <?php 
                 $bookingId = $booking["id"]; 
                 $banquetId = $booking["banquet_id"];
                 ?>
                <!-- Banquet Image -->
                <div class="col-md-3">
                    <img src="../<?php echo htmlspecialchars($booking['banquet_image']); ?>" class="img-fluid rounded-start h-100"
                        alt="Banquet Image">
                        
                </div>
                <!-- Booking Details -->

                <div class="col-md-9">
                    <div class="card-body ">
                        <h3 class="card-title fw-bold text-capitalize"><?php echo $booking["banquet_name"] ?></h3>
                        <p class="card-text mb-1"><strong>Date: </strong><?php echo $booking["date"] . " ". $booking["time_slot"]?></p>
                        <p class="card-text mb-1"><strong>Capacity: </strong><?php echo $booking["capacity"] ?></p>
                        <p class="card-text mb-1"><strong>Price: </strong><?php echo $booking["price"] ?></p>
                        <p class="card-text"><strong>Status: </strong><span class="badge text-dark"><?php echo $booking["status"] ?></span></p>
                        <a href="booking_details.php?booking_id=<?php echo $bookingId ?>&banquet_id=<?php  echo $banquetId?>" class="btn btn-sm btn-outline-primary">View Details</a>
                        <a href="#" class="btn btn-sm btn-outline-danger">Cancel</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

       

    </div>
</section>

<?php
include("../includes/footer.php");
?>