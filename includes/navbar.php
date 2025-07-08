<?php
include 'header.php';
?>


<nav class="navbar navbar-expand-lg w-100 navbar-light  bg-transparent transition-nav position-fixed z-2 position-absolute  shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">
      <i class="fa-solid fa-champagne-glasses me-2"></i>Banquet Booking
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link " href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="banquet_list.php">Banquets</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="owner/login.php">List Banquet</a>
        </li>

        <?php if (isset($_SESSION['id'])):  ?>
          
          <li class="nav-item">
            <a class="nav-link" href="my_bookings.php">My Bookings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../banquet_booking/logout.php">Logout</a>
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

<?php
// include 'footer.php';
?>