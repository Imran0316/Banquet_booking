<?php
session_start();
include 'db.php';
include '../Banquet_booking/includes/header.php';
include '../Banquet_booking/includes/navbar.php';
$_SESSION['user_id'] = $_SESSION['id'];
?>

<!-- Hero Carousel -->
<div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
  <div class="carousel-inner">

    <div class="carousel-item active" style="height: 90vh; background: url('assets/images/banquet8.jpg') center center / cover no-repeat;">
        
  <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(160, 0, 0, 0.18); z-index: 1;"></div>
      <div class="carousel-overlay d-flex align-items-center justify-content-center text-white text-center" style="background: rgba(0,0,0,0.5); height: 100%;">
        <div>
          <h1 class="display-4 fw-bold">Plan Your Dream <span class="wedding"> Wedding </span></h1>
          <p class="lead">Find beautiful venues that suit your occasion</p>
          <a href="banquet_list.php" class="btn btn-outline btn-lg mt-3">Explore Banquets</a>
        </div>
      </div>
    </div>

    <div class="carousel-item" style="height: 90vh; background: url('assets/images/banquet9.jpg') center center / cover no-repeat;">
          <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(160, 0, 0, 0.18); z-index: 1;"></div>
      <div class="carousel-overlay d-flex align-items-center justify-content-center text-white text-center" style="background: rgba(0,0,0,0.5); height: 100%;">
        <div>
          <h1 class="display-4 fw-bold">Book for <span class="wedding"> Every </span> Celebration</h1>
          <p class="lead">Birthdays, Parties, Corporate Events — all in one place</p>
          <a href="banquet_list.php" class="btn btn-outline btn-lg mt-3">Browse Now</a>
        </div>
      </div>
    </div>

    <div class="carousel-item" style="height: 90vh; background: url('assets/images/banquet7.jpg') center center / cover no-repeat;">
          <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(160, 0, 0, 0.18); z-index: 1;"></div>
      <div class="carousel-overlay d-flex align-items-center justify-content-center text-white text-center" style="background: rgba(0,0,0,0.5); height: 100%;">
        <div>
          <h1 class="display-4 fw-bold">Book Hassle-<span class="wedding">Free</span></h1>
          <p class="lead">Available slots, instant booking, no tension!</p>
          <a href="banquet_list.php" class="btn btn-outline btn-lg mt-3">Book Now</a>
        </div>
      </div>
    </div>

  </div>

  <!-- Optional controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- section-2 -->
 <!-- WHY CHOOSE US  -->
<section class="sec-2 py-5 bg-light">
  <div class="container text-center pattern-bg">
    <h2 class="mb-4 fw-bold">Why Book With Us?</h2>
    <div class="row g-4 pt-5">
      
      <div class="col-md-4">
        <i class="fa-solid fa-calendar-check fa-3x mb-3 text-warning"></i>
        <h5 class="fw-semibold">Easy Booking</h5>
        <p class="text-muted">Book your desired banquet with just a few clicks. No hassle, no confusion.</p>
      </div>
      
      <div class="col-md-4">
        <i class="fa-solid fa-shield-halved fa-3x mb-3 text-warning"></i>
        <h5 class="fw-semibold">Trusted Owners</h5>
        <p class="text-muted">We verify each banquet and its owner to ensure reliable service.</p>
      </div>
      
      <div class="col-md-4">
        <i class="fa-solid fa-star fa-3x mb-3 text-warning"></i>
        <h5 class="fw-semibold">Top Rated Venues</h5>
        <p class="text-muted">Browse only the best-reviewed banquets in your city.</p>
      </div>

    </div>
  </div>
</section>
<!-- section-3 -->
 <!--  TOP BANQUETS-->
<section class="py-5">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold">Top Rated Banquets</h2>
      <p class="text-muted">Discover the most popular venues this week</p>
    </div>

    <div class="row g-4">
      <!-- Card 1 -->
      <div class="col-md-4">
        <div class="card shadow-sm">
          <img src="uploads/banquets/sample1.jpg" class="card-img-top" alt="Banquet 1">
          <div class="card-body">
            <h5 class="card-title">Grand Palace Banquet</h5>
            <p class="card-text"><i class="fa fa-map-marker-alt"></i> Clifton, Karachi</p>
            <p class="text-muted">Capacity: 500 | Rs. 150,000</p>
            <a href="#" class="btn btn-outline-warning">View Details</a>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-md-4">
        <div class="card shadow-sm">
          <img src="uploads/banquets/sample2.jpg" class="card-img-top" alt="Banquet 2">
          <div class="card-body">
            <h5 class="card-title">The Elegant Hall</h5>
            <p class="card-text"><i class="fa fa-map-marker-alt"></i> Gulshan-e-Iqbal</p>
            <p class="text-muted">Capacity: 300 | Rs. 90,000</p>
            <a href="#" class="btn btn-outline-warning">View Details</a>
          </div>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-md-4">
        <div class="card shadow-sm">
          <img src="uploads/banquets/sample3.jpg" class="card-img-top" alt="Banquet 3">
          <div class="card-body">
            <h5 class="card-title">Royal Orchid Venue</h5>
            <p class="card-text"><i class="fa fa-map-marker-alt"></i> DHA Phase 6</p>
            <p class="text-muted">Capacity: 700 | Rs. 200,000</p>
            <a href="#" class="btn btn-outline-warning">View Details</a>
          </div>
        </div>
      </div>
    </div>

    <div class="text-center mt-4">
      <a href="banquet_list.php" class="btn btn-warning px-4">Explore All Banquets</a>
    </div>
  </div>
</section>



<!-- 
<h3>User</h3>
<a href="../Banquet_booking/users/login.php">login</a> -->
<?php
include '../Banquet_booking/includes/footer.php';

?>