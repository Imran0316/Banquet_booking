<?php
session_start();
include("../db.php");
include("../includes/header.php");
include("../includes/navbar.php");



?>
<style>
    .navbar{
        backdrop-filter: blur(50);
    }
      .hero-section {
      height: 250px;
      background: url('../assets/images/banquet7.jpg') center/cover no-repeat;
      position: relative;
      color: white;
    }

    .hero-overlay {
      background-color: rgba(0, 0, 0, 0.6);
      position: absolute;
      inset: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      flex-direction: column;
    }
    .card-title {
      font-size: 1.2rem;
    }

    .banquet-card img {
      height: 180px;
      object-fit: cover;
    }
</style>

<section class="hero-section">
  <div class="hero-overlay">
    <h1 class="display-5 fw-bold">Find the Perfect Banquet</h1>
    <p class="lead">Choose from the best venues for weddings, parties & events</p>
    <a href="#banquet-list" class="btn btn-light btn-sm mt-2">Browse Banquets</a>
  </div>
</section>


<!-- 🔶 Banquet Cards Section -->
<section id="banquet-list" class="py-5 bg-light">
  <div class="container">
    <div class="row g-4">

      <!-- 🔹 Banquet Card -->
      <div class="col-md-4">
        <div class="card banquet-card shadow-sm">
          <img src="uploads/banquet1.jpg" class="card-img-top" alt="Banquet Image">
          <div class="card-body">
            <h5 class="card-title">Royal Galaxy Banquet</h5>
            <p class="card-text text-muted mb-2">
              📍 Clifton, Karachi<br>
              👥 Capacity: 400 Guests<br>
              💰 Price: PKR 50,000+
            </p>
            <a href="banquet_details.php?id=1" class="btn btn-primary btn-sm">View Details</a>
          </div>
        </div>
      </div>

      <!-- Repeat Card for More Banquets -->
      <div class="col-md-4">
        <div class="card banquet-card shadow-sm">
          <img src="uploads/banquet2.jpg" class="card-img-top" alt="Banquet Image">
          <div class="card-body">
            <h5 class="card-title">Dream Palace Hall</h5>
            <p class="card-text text-muted mb-2">
              📍 Gulshan, Karachi<br>
              👥 Capacity: 300 Guests<br>
              💰 Price: PKR 35,000+
            </p>
            <a href="banquet_details.php?id=2" class="btn btn-primary btn-sm">View Details</a>
          </div>
        </div>
      </div>

      <!-- Add more cards as needed -->

    </div>
  </div>
</section>




<?php 
// include("../includes/footer.php");

?>