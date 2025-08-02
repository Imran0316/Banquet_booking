<?php
session_start();
include("../db.php");
include("include/header.php");
$page = "inner";
include("include/navbar.php");

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
    $stmt = $pdo->prepare("SELECT * FROM banquets WHERE name LIKE :search OR location LIKE :search");
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM banquets");
}




?>
<style>
* {
    padding: 0%;
    margin: 0%;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}





.hero-section {
    height: 250px;
    background: url('../assets/images/banquet7.jpg') center/cover no-repeat;
    position: relative !important;
    color: white;
}

.hero-overlay {
    background-color: rgba(104, 0, 0, 0.5);
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    flex-direction: column;
}

.hero-section h1 {
    font-family: 'Libre Baskerville', serif;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.507);
    line-height: 1.2;
}

.hero-section .btn {
    color: maroon;
    background-color: goldenrod;
    font-size: 1.1rem;
    border: none !important;
    transition: all 0.3s ease-in;
}

.hero-section .btn:hover {
    color: white;
    background-color: maroon;
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
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3) !important;
    border-bottom: none !important;

}

.card-body h5 {
    font-size: 1.1rem;
}

.sec-2 {

    background: url('../assets/images/pattern2.jpg') center/cover no-repeat;
    position: relative !important;
    background-attachment: fixed;

}

.banquet-card i {
    color: #f39c12;
    font-size: .8rem;

}
</style>

<section class="hero-section hero-sec-2">
    <div class="hero-overlay">
        <h1 class="display-5 fw-bold">Find the Perfect Banquet</h1>
        <p class="lead">Choose from the best venues for weddings, parties & events</p>
        <a href="#banquet-list" class="btn btn-light btn-sm mt-2">Browse Banquets</a>
    </div>
</section>

<section id="banquet-list" class="py-5 bg-light sec-2">
    <div class="container py-4">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by name or location"
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100">Search</button>
            </div>
        </form>
    </div>

</section>

<!-- 🔶 Banquet Cards Section -->
<section id="banquet-list" class="py-5 bg-light sec-2">
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
                        <h5 class="fw-semibold mb-1">
                            <?php echo $banquet_row["name"] . " | " . $banquet_row["location"]; ?><span> | Banquet
                            </span></h5>

                        <p class="card-text mb-2">Starting From Rs. <?php echo $banquet_row["price"]; ?></p>

                        <p><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"><i
                                    class="fa-solid fa-star"></i></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><span></space>
                        </p>
                        <!-- Button -->
                        <a href="booking_page.php?id=<?php echo $banquet_row['id']; ?>"
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