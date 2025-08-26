<?php
session_start();
include '../db.php';
include '../includes/header.php';

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_pass = $_POST['confirm_pass'];

    // Check if passwords match
    if ($password !== $confirm_pass) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: owner_register.php");
        exit();
    }

    try {
        // Check if email already exists in owners table
        $checkQuery = "SELECT id FROM owners WHERE email = :email";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            $_SESSION['error'] = "Email already exists.";
            header("Location: owner_register.php");
            exit();
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert into owners table
        $query = "INSERT INTO owners (name, email, phone, password) 
                  VALUES (:username, :email, :phone, :password)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->execute();

        $_SESSION['success'] = "Owner registration successful. You can now log in.";
        header("Location: owner_login.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: owner_register.php");
        exit();
    }
}
?>

<!-- Bootstrap Icons CDN (add in header.php if not included already) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="container-fluid signup-layout">
  <div class="illustration">
    <div class="circle-backdrop"></div>
     <img src="../assets/images/logo_maroon.png" alt="Mera Shadi Hall Logo">
  </div>
  <div class="form-wrapper">

    <!-- Error / Success Messages -->
    <?php if(isset($_SESSION['error'])): ?>
      <div class="alert alert-danger">
        <?php 
          echo $_SESSION['error']; 
          unset($_SESSION['error']); 
        ?>
      </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['success'])): ?>
      <div class="alert alert-success">
        <?php 
          echo $_SESSION['success']; 
          unset($_SESSION['success']); 
        ?>
      </div>
    <?php endif; ?>

    <h2 class="text-center">Owner Register</h2>

    <form action="" method="post">
      <div class="form-group">
        <label for="username">Owner Name:</label>
        <input type="text" class="form-control" id="username" name="username" 
               pattern="[A-Z][a-zA-Z0-9]*" 
               title="First letter must be uppercase" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="tel" class="form-control" id="phone" name="phone" maxlength="11" 
               pattern="\d{11}" title="Phone number must be exactly 11 digits" required>
      </div>

      <!-- Password Field -->
      <div class="form-group">
        <label for="password">Password:</label>
        <div class="input-group">
          <input type="password" class="form-control" id="password" name="password" minlength="8" required>
          <div class="input-group-append">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="togglePassword('password', this)">
              <i class="bi bi-eye"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Confirm Password -->
      <div class="form-group">
        <label for="confirm_pass">Confirm Password:</label>
        <div class="input-group">
          <input type="password" class="form-control" id="confirm_pass" name="confirm_pass" minlength="8" required>
          <div class="input-group-append">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="togglePassword('confirm_pass', this)">
              <i class="bi bi-eye"></i>
            </button>
          </div>
        </div>
        <small id="passMsg" style="color:red; display:none;">Passwords do not match</small>
      </div>

      <button type="submit" class="btn btn-primary" name="signup">Sign up</button>
    </form>
    <p class="mt-3">Already an owner? <a href="owner_login.php">login here</a></p>
  </div>
</div>

<script>
function togglePassword(fieldId, btn) {
  let input = document.getElementById(fieldId);
  let icon = btn.querySelector("i");
  
  if (input.type === "password") {
    input.type = "text";
    icon.classList.remove("bi-eye");
    icon.classList.add("bi-eye-slash");
  } else {
    input.type = "password";
    icon.classList.remove("bi-eye-slash");
    icon.classList.add("bi-eye");
  }
}

document.getElementById("confirm_pass").addEventListener("input", function() {
  let pass = document.getElementById("password").value;
  let confirmPass = this.value;
  let msg = document.getElementById("passMsg");

  if (confirmPass !== pass) {
    msg.style.display = "block";
  } else {
    msg.style.display = "none";
  }
});
</script>




<style>
body {
  margin: 0; padding: 0;
  font-family: 'Segoe UI', sans-serif;
  display: flex; justify-content: center; align-items: center;
  height: 100vh;
}

.signup-layout {
  display: flex; width: 100%; max-width: 900px;
  min-height: 450px;
}

.illustration {
  flex: 1; position: relative;
  display: flex; justify-content: center; align-items: center;
}

.circle-backdrop {
  position: absolute; width: 240px; height: 240px;
  background: #8585854d; border-radius: 50%;
  top: 50%; left: 50%; transform: translate(-50%, -50%);
}

.illustration img {
  position: relative; z-index: 2;
  max-width: 70%; height: auto;
}

.form-wrapper {
  flex: 1; padding: 40px; box-sizing: border-box;
}

.form-wrapper h2 {
  font-size: 22px; font-weight: 500;
  color: #222; margin-bottom: 5px;
}

.form-group { margin-bottom: 16px; }
.form-group label { font-size: 13px; font-weight: 400; display: block; margin-bottom: 4px; }

.input-group-text { background: none; border: none; color: #555; cursor: pointer; }
.form-control {
  border: none; border-bottom: 1px solid #999;
  border-radius: 0; padding: 6px;
  font-size: 14px; background: transparent;
}
.form-control:focus {
  outline: none; border-bottom: 2px solid #000; box-shadow: none;
}

.btn-primary {
  padding: 10px; background: #000; border: none;
  border-radius: 25px; font-size: 14px; font-weight: 500;
}
.btn-primary:hover { background: #333; }

.alert {
  padding: 10px; border-radius: 6px; margin-bottom: 16px;
  font-size: 13px; font-weight: 400; text-align: center;
}
.alert-danger { background: #ffe0e0; color: #d93025; border: 1px solid #d93025; }
.alert-success { background: #e6ffed; color: #1e7e34; border: 1px solid #1e7e34; }
</style>

<script>
function togglePassword(fieldId, el) {
  const field = document.getElementById(fieldId);
  const icon = el.querySelector("i");
  if (field.type === "password") {
    field.type = "text";
    icon.classList.remove("bi-eye");
    icon.classList.add("bi-eye-slash");
  } else {
    field.type = "password";
    icon.classList.remove("bi-eye-slash");
    icon.classList.add("bi-eye");
  }
}
</script>
