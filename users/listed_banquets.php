<?php
session_start();
include("../db.php");
include("../includes/header.php");
include("../includes/navbar.php");

$stmt = $pdo->query("SELECT * FROM banquets");



?>
<style>
.navbar {
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
.banquet-card {
  transition: all 0.3s ease;
  box-shadow: 0 10px 20px rgba(255, 255, 255, 0.3) !important;
  border-bottom: 1px solid gray !important;
}

.banquet-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.3) !important;
  border-bottom: none !important;

}

.card-body h5 {
  font-size: 1.1rem;
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
            <!-- Card Container -->
            <div class="col-md-4 mb-4">
                <div class="card banquet-card shadow-sm border-0 rounded-4 overflow-hidden">

                    <!-- Image -->
                    <img src="uploads/<?php echo $banquet_row['image']; ?>" class="card-img-top"
                        style="height: 180px; object-fit: cover;" alt="Banquet Image">

                    <!-- Card Body -->
                    <div class="card-body">
                        <h5 class="fw-semibold mb-1"><?php echo $banquet_row["name"]; ?></h5>
                        <small class="text-muted d-block mb-2">
                            📍 <?php echo $banquet_row["location"]; ?>
                        </small>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="small text-muted">👥 Capacity:</span>
                            <span class="small"><?php echo $banquet_row["capacity"]; ?> People</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="small text-muted">💰 Price:</span>
                            <span class="small fw-bold text-dark">PKR <?php echo $banquet_row["price"]; ?></span>
                        </div>

                        <!-- Button -->
                        <a href="banquet_details.php?id=<?php echo $banquet_row['id']; ?>"
                            class="btn btn-sm btn-dark w-100 rounded-pill">
                            View Details
                        </a>
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