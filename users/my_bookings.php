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
           bn.location, bn.description,bn.image AS banquet_image, bn.capacity, bn.price, bn.id AS banquet_id, u.name AS user_name
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
    <?php
    if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['success'];
        unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php elseif (isset($_SESSION["error"])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['erro'];
        unset($_SESSION['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>
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
              <p class="card-text mb-1"><strong>Date:
                </strong><?php echo $booking["date"] . " " . $booking["time_slot"] ?></p>
              <p class="card-text mb-1"><strong>Capacity: </strong><?php echo $booking["capacity"] ?></p>
              <p class="card-text mb-1"><strong>Price: </strong><?php echo $booking["price"] ?></p>
              <p class="card-text"><strong>Status: </strong><span
                  class="badge text-dark"><?php echo $booking["status"] ?></span></p>

              <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                data-bs-target="#simpleDetailsModal">
                View Details
              </button>
              <?php if ($booking["status"] === 'canceled'): ?>
                <button disabled type="button" class="btn btn-danger" id="confirmCancelBtn">
                  Cancel
                </button> <br>
                <small class="text-danger">Booking Already Canceled</small>
              <?php else: ?>
                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelBookingModal">
                  Cancel
                </button>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>



  </div>
</section>

<!-- Cancel Booking Modal -->
<div class="modal fade" id="cancelBookingModal" tabindex="-1" aria-labelledby="cancelBookingLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-3">
      <div class="modal-header">
        <h5 class="modal-title" id="cancelBookingLabel">Cancel Booking</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <p class="mb-3">Are you sure you want to cancel this booking?</p>
        <p>Advance non-refundalble</p>

        <a href="/cancellation-policies" class="link-primary" target="_blank" rel="noopener">
          View Cancellation Policies
        </a>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Keep Booking</button>

        <button type="button" class="btn btn-danger" id="confirmCancelBtn">
          <a href="booking_cancel.php?booking_id=<?php echo $booking["id"] ?>"
            class="text-decoration-none text-white">Cancel</a>
        </button>

      </div>
    </div>
  </div>
</div>
<!-- DETAILS MODEL -->
<div class="modal fade" id="simpleDetailsModal" tabindex="-1" aria-labelledby="simpleDetailsModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="simpleDetailsModalLabel">Booking / Banquet Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Replace below with dynamic content later -->
        <div class="row">
          <div class="col-md-5">
            <img src="../<?php echo $booking["banquet_image"] ?>" alt="Banquet" class="img-fluid rounded mb-3">
          </div>
          <div class="col-md-7">
            <table class="table table-sm table-borderless">
              <tbody>
                <tr>
                  <th class="w-40">Banquet</th>
                  <td id="md-banquet-name"><?php echo $booking["banquet_name"] ?></td>
                </tr>
                <tr>
                  <th>Location</th>
                  <td id="md-location"><?php echo $booking["location"] ?></td>
                </tr>
                <tr>
                  <th>Booking Date</th>
                  <td id="md-date"><?php echo $booking["date"] ?></td>
                </tr>
                <tr>
                  <th>Time Slot</th>
                  <td id="md-slot"><?php echo $booking["time_slot"] ?></td>
                </tr>
                <tr>
                  <th>Guests</th>
                  <td id="md-guests"><?php echo $booking["capacity"] ?></td>
                </tr>
                <tr>
                  <th>Price</th>
                  <td id="md-price"><?php echo $booking["price"] ?></td>
                </tr>
                <tr>
                  <th>Status</th>
                  <td id="md-status"><span class="badge bg-success"><?php echo $booking["status"] ?></span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <hr>
        <h6>Description</h6>
        <p id="md-desc"><?php echo $booking["description"] ?></p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php
include("../includes/footer.php");
?>