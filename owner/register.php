<?php
session_start();

include '../db.php';
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["signup"])) {
    $name = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password = $_POST["password"];
    $confirm_pass = $_POST["confirm_pass"];

    // Validations
    if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($confirm_pass)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: register.php");
        exit();
    }

    // Username must start with a capital letter
    if (!preg_match("/^[A-Z][a-zA-Z ]*$/", $name)) {
        $_SESSION['error'] = "Username must start with a capital letter.";
        header("Location: register.php");
        exit();
    }

    // Email format check
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: register.php");
        exit();
    }

    // Phone number must be digits only (10-13 digits allowed)
    if (!preg_match("/^[0-9]{10,13}$/", $phone)) {
        $_SESSION['error'] = "Phone number must be 10-13 digits.";
        header("Location: register.php");
        exit();
    }

    // Password validation (at least 8 characters)
    if (strlen($password) < 8) {
        $_SESSION['error'] = "Password must be at least 8 characters long.";
        header("Location: register.php");
        exit();
    }

    // Confirm password check
    if ($password !== $confirm_pass) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: register.php");
        exit();
    }

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT * FROM banquet_owner WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = "Email already exists.";
        header("Location: register.php");
        exit();
    }

    // Insert into DB
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO `banquet_owner`(`name`, `email`, `phone`, `password`, `created_at`) VALUES (?,?,?,?,NOW())");
    $stmt->execute([$name, $email, $phone, $hashed_password]);

    $_SESSION['success'] = "Registration successful. Please login.";
    header("Location: index.php?registered=1");
    exit();
}
?>


<!-- FORM UI -->
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center owner-bg">
  <div class="col-md-5 col-lg-4">
    <div class="card shadow-lg border-0 rounded-4 p-4 bg-white">
      
      <div class="text-center mb-3">
        <img src="assets/images/owner-logo.png" alt="Owner Logo" style="width:70px;" class="mb-2">
        <h4 class="fw-bold text-dark mb-1">Owner Registration</h4>
        <small class="text-muted">Banquet Booking System</small>
      </div>

      <?php
      if (isset($_SESSION['error'])) {
          echo "<div class='alert alert-danger text-center small'>" . $_SESSION['error'] . "</div>";
          unset($_SESSION['error']);
      }
      if (isset($_SESSION['success'])) {
          echo "<div class='alert alert-success text-center small'>" . $_SESSION['success'] . "</div>";
          unset($_SESSION['success']);
      }
      ?>

      <form action="" method="post">
        <div class="form-group mb-2">
          <div class="input-group input-group-sm">
            <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username (First letter capital)" required>
          </div>
        </div>

        <div class="form-group mb-2">
          <div class="input-group input-group-sm">
            <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
          </div>
        </div>

        <div class="form-group mb-2">
          <div class="input-group input-group-sm">
            <span class="input-group-text bg-white"><i class="bi bi-telephone"></i></span>
            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone (10-13 digits)" required>
          </div>
        </div>

        <div class="form-group mb-2">
          <div class="input-group input-group-sm">
            <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password (min 8 chars)" required>
          </div>
        </div>

        <div class="form-group mb-3">
          <div class="input-group input-group-sm">
            <span class="input-group-text bg-white"><i class="bi bi-lock-fill"></i></span>
            <input type="password" class="form-control" id="confirm_pass" name="confirm_pass" placeholder="Confirm Password" required>
          </div>
        </div>

        <button type="submit" class="btn btn-gradient w-100 rounded-3 py-2 fw-bold shadow-sm" name="signup">
          <i class="bi bi-person-plus"></i> Sign Up
        </button>
      </form>

      <p class="mt-3 text-center small text-muted">
        Already have an account? 
        <a href="index.php" class="fw-bold text-decoration-none text-success">Login here</a>
      </p>
    </div>
  </div>
</div>


<style>
    body, html {
      height: 100%;
      font-family: 'Poppins', sans-serif;
    }

    .owner-bg {
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
    }

    .card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 25px rgba(0,0,0,0.2);
    }

    .btn-gradient {
      background: linear-gradient(135deg, #11998e, #38ef7d);
      border: none;
      color: #fff;
    }

    .btn-gradient:hover {
      background: linear-gradient(135deg, #38ef7d, #11998e);
      color: #fff;
    }

    .input-group-text {
      border-right: 0;
    }

    .form-control {
      border-left: 0;
    }
</style>
