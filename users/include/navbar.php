<?php
include 'header.php';
?>

<style>
  .logo-img {
    height: 50px;
    /* Adjust height */
    width: auto;
    /* Maintain aspect ratio */
    object-fit: contain;
    /* Prevent distortion */
    filter: drop-shadow(1px 1px 2px rgba(0, 0, 0, 0.4));
    /* Optional glow */
}

.navbar-brand {
    padding: 0.3rem 0;
    
}
.brand-text{
    font-family: 'Libre Baskerville', serif;
    font-size: 1.5rem;
    color: gold;
}
.color_nav {
    background-color: maroon !important;
}


.nav-link {
    font-weight: 500;
    letter-spacing: 0.5px;
    color: #fff !important;
}

.navbar .navbar-nav .nav-item .nav-link:hover {
    color: gold !important;
}
</style>

<?php if($page === "home"){?>
<nav
    class="navbar navbar-expand-lg w-100 navbar-light  bg-transparent transition-nav position-fixed z-2 position-absolute  shadow-sm">
    <?php }else{?>
    <nav class="navbar navbar-expand-lg w-100 navbar-light transition-nav  z-2  color_nav shadow-sm">
        <?php }?>
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../assets/images/logo_goldenrod.png" alt="Mera Shadi Hall Logo" class="logo-img me-2">
                <span class="brand-text">MeraShadiHall</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link " href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listed_banquets.php">Banquets</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../owner/">List Banquet</a>
                    </li>

                    <?php if (isset($_SESSION['id'])):  ?>

                    <li class="nav-item">
                        <a class="nav-link" href="my_bookings.php">My Bookings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../banquet_booking/logout.php">Logout</a>
                    </li>
                    <?php else:
          ?>

                    <li class="nav-item">
                        <a class="nav-link" href="../banquet_booking/users/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>