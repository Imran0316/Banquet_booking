<?php

include("../../db.php");
// Get owner imagee from database
$owner_id = $_SESSION['owner_id'];
$stmt = $pdo->prepare("SELECT owner_image FROM banquet_owner WHERE id = ?");
$stmt->execute([$owner_id]);
$owner = $stmt->fetch(PDO::FETCH_ASSOC);
$owner_img = !empty($owner['owner_image']) ? '../../uploads/' . $owner['owner_image'] : 'img/user.jpg';
?>
<!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3 bg-white shadow-lg" style="min-height:100vh;">
            <nav class="navbar bg-white navbar-light">
                <a href="index.php" class="navbar-brand mx-4 mb-3">
                    <h3 style="font-family:'Playfair Display',serif; font-weight:700; letter-spacing:1px;">
                        <span style="color:#800000;">Banquet</span> <br> <span style="color:#DAA520;">Booking</span>
                    </h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle border border-3" src="<?php echo $owner_img; ?>" alt="" style="width: 50px; height: 50px; object-fit:cover; border-color:#DAA520;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 fw-bold" style="color:#800000;"><?php echo $_SESSION["owner_name"]; ?></h6>
                        <span class="badge rounded-pill" style="background:linear-gradient(90deg,#800000,#DAA520);color:#fff;font-size:0.8rem;">Banquet Owner</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.php" class="nav-item nav-link active" style="font-weight:500;">
                        <i class="fa fa-tachometer-alt me-2" style="color:#DAA520;"></i>
                        <span style="color:#800000;">Dashboard</span>
                    </a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" style="font-weight:500;">
                            <i class="fa fa-building me-2" style="color:#DAA520;"></i>
                            <span style="color:#800000;">Banquets</span>
                        </a>
                        <div class="dropdown-menu bg-white border-0  rounded-3 py-2">
                            <a href="add_banquet.php" class="dropdown-item ps-5" style="color:#800000;">
                                <i class="bi bi-building-add me-2" style="color:#DAA520;"></i>Add Banquet
                            </a>
                            <a href="manage_banquet.php?id=<?php echo $_SESSION['owner_id']; ?>" class="dropdown-item ps-5" style="color:#800000;">
                                <i class="bi bi-building-fill-gear me-2" style="color:#DAA520;"></i>Manage Banquet
                            </a>
                        </div>
                        
                        
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" style="font-weight:500;">
                            <i class="bi bi-calendar-check-fill"  style="color:#DAA520;"></i>
                            <span style="color:#800000;">Bookings</span>
                        </a>
                        <div class="dropdown-menu bg-white border-0  rounded-3 py-2">
                            <a href="bookings.php" class="dropdown-item ps-5" style="color:#800000;">
                                <i class="bi bi-building-add me-2" style="color:#DAA520;"></i>Booking 
                            </a>
                            <a href="canceled_bookings.php?id=<?php echo $_SESSION['owner_id']; ?>" class="dropdown-item ps-5" style="color:#800000;">
                                <i class="bi bi-building-fill-gear me-2" style="color:#DAA520;"></i>canceled Booking
                            </a>
                        </div>
                        
                        
                    </div>
                    
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" style="font-weight:500;">
                            <i class="far fa-file-alt me-2" style="color:#DAA520;"></i>
                            <span style="color:#800000;">Pages</span>
                        </a>
                        <div class="dropdown-menu bg-white border-0 shadow rounded-3 py-2">
                            <a href="signin.php" class="dropdown-item" style="color:#800000;">Sign In</a>
                            <a href="signup.php" class="dropdown-item" style="color:#800000;">Sign Up</a>
                            <a href="404.php" class="dropdown-item" style="color:#800000;">404 Error</a>
                            <a href="blank.php" class="dropdown-item" style="color:#800000;">Blank Page</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <style>
.sidebar {
    background: #fff;
    border-right: 2px solid #DAA520;
}
.sidebar .navbar-brand h3 {
    font-size: 2rem;
}
.sidebar .nav-link.active, .sidebar .nav-link:hover {
    background: linear-gradient(90deg,#80000022,#DAA52022);
    border-radius: 10px;
}
.sidebar .dropdown-menu .dropdown-item:hover {
    background: #FFF5F5;
}
</style>