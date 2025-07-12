<?php
session_start();
include("../db.php");
include("../includes/header.php");
include("../includes/navbar.php");

$stmt = $pdo->query("SELECT * FROM banquets");



?>
<style>
    .navbar{
      background-color: rgba(255, 255, 255, 0.5) !important;
        
    }
      .hero-section {
      height: 450px;
      background: url('../assets/images/banquet7.jpg') center/cover no-repeat;
      position: relative;
      color: white;
    }

    .hero-overlay {
      background-color: rgba(104, 0, 0, 0.5);
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
<?php while($banquet_row = $stmt->fetch(PDO::FETCH_ASSOC)){

?>
      <!-- 🔹 Banquet Card -->
      <div class="col-md-4">
        <div class="card banquet-card shadow-sm">
          <img src="uploads/<?php echo $banquet_row["image"]; ?>" class="card-img-top" alt="Banquet Image">
          <div class="card-body">
            <h5 class="card-title"><?php echo $banquet_row["name"]; ?></h5>
            <p class="card-text text-muted mb-2">
              📍 <?php echo $banquet_row["location"]; ?><br>
              👥 Capacity: <?php echo $banquet_row["capacity"]; ?><br>
              💰 Price: PKR <?php echo $banquet_row["price"]; ?>
            </p>
            <a href="banquet_details.php?id=1" class="btn btn-primary btn-sm">View Details</a>
          </div>
        </div>
      </div>

<?php }?>
    </div>
  </div>
</section>




<?php 
include("../includes/footer.php");

?>