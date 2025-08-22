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

    .brand-text {
        font-family: 'Libre Baskerville', serif;
        font-size: 1.5rem;
        color: gold;
    }
   
  /* Hover effect */
  .dropdown-menu .dropdown-item:hover {
    background-color: maroon; 
    color: #fff !important;
    
  }

  /* Dropdown shadow */
  .dropdown-menu {
    /* min-width: 200px;
    padding: 8px; */
    border: 1px solid goldenrod;
    background-color: transparent;
    backdrop-filter: blur(10px);
  }
  .dropdown-menu .dropdown-item{
    color: #fff !important;
  }
  /* Profile image hover glow */
  #userDropdown img:hover {
    box-shadow: 0 0 10px gold;
    transition: 0.3s;
  }

</style>

<?php if ($page === "home") { ?>
    <nav
        class="navbar navbar-expand-lg w-100 navbar-light  bg-transparent transition-nav position-fixed z-2 position-absolute  shadow-sm">
    <?php } else { ?>
        <nav class="navbar navbar-expand-lg w-100 navbar-light transition-nav  z-2   shadow-sm">
        <?php } ?>
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="assets/images/logo_maroon.png" alt="Mera Shadi Hall Logo" class="logo-img me-2">
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
                        <a class="nav-link" href="users/listed_banquets.php">Banquets</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="owner/">List Banquet</a>
                    </li>

                    <?php if (isset($_SESSION['id'])): ?>


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                               
                                <span><?php echo $_SESSION["name"]; ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="users/user_profile.php"> Profile</a></li>
                                <li><a class="dropdown-item" href="../users/my_bookings.php">My Bookings</a></li>
                                <li>
                                    <hr class="dropdown-divider" style="border-color: goldenrod;">
                                </li>
                                <li><a class="dropdown-item text-danger" href="../banquet_booking/logout.php">Logout</a></li>
                            </ul>
                        </li>

                    <?php else:
                        ?>

                        <li class="nav-item">
                            <a class="nav-link" href="../banquet_booking/users/login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="users/register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php
    // include 'footer.php';
    ?>