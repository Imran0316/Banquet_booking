<?php
session_start();

include '../db.php';
include '../includes/header.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["login"])) {
  $email = $_POST["email"];
  $password = $_POST["password"];

  if (empty($email) || empty($password)) {
    $_SESSION['error'] = "All fields are required.";
    header("Location: login.php");
    exit();
  }

  if ($email == "imran@gmail.com") {
    if ($password == "ik775239") {

      header("Location: dashboard/");
      exit();
    } else {
      $_SESSION['error'] = "Incorrect Password.";
      header("Location: index.php");
      exit();
    }
  } else {
    $_SESSION['error'] = "Email not found.";
    header("Location: index.php");
    exit();
  }

}
?>



<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center admin-bg">
  <div class="col-md-5 col-lg-4">
    <div class="card shadow-lg border-0 rounded-4 p-4 bg-white">
      <div class="text-center mb-4">
        <img src="../assets/images/logo_goldenrod.png" alt="Admin Logo" class="mb-3" style="width:80px;">
        <h3 class="fw-bold text-dark">Admin Login</h3>
        <p class="text-muted small">Banquet Booking Management System</p>
      </div>

      <?php
      if (isset($_SESSION['error'])) {
        echo "<small class='text-danger text-center'>" . "ⓘ". $_SESSION['error'] . "</small>";
        unset($_SESSION['error']);
      }
      if (isset($_SESSION['success'])) {
        echo "<div class='alert alert-success text-center'>" . $_SESSION['success'] . "</div>";
        unset($_SESSION['success']);
      }
      ?>

      <form action="" method="post">
        <div class="form-group mb-3">
          <label for="email" class="fw-semibold">Email</label>
          <div class="input-group">
            <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
            <input type="email" class="form-control shadow-sm" id="email" name="email" placeholder="admin@banquet.com"
              required>
          </div>
        </div>

        <div class="form-group mb-3">
          <label for="password" class="fw-semibold">Password</label>
          <div class="input-group">
            <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
            <input type="password" class="form-control shadow-sm" id="password" name="password" placeholder="••••••"
              required>
          </div>
        </div>

        <button type="submit" name="login" class="btn btn-dark w-100 rounded-3 py-2 fw-bold shadow-sm">
          <i class="bi bi-box-arrow-in-right"></i> Login
        </button>
      </form>

      <p class="mt-4 text-center text-muted small">
        ⓘ Only authorized admins can access this panel.
      </p>
    </div>
  </div>
</div>


<style>
  body,
  html {
    height: 100%;
    font-family: 'Poppins', sans-serif;
  }

  .admin-bg {
    background: linear-gradient(135deg, #232526 0%, #414345 100%);
  }

  .card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25);
  }

  .btn-dark {
    background: linear-gradient(135deg, #000000, #434343);
    border: none;
  }

  .btn-dark:hover {
    background: linear-gradient(135deg, #434343, #000000);
  }
</style>