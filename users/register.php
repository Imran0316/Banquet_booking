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
        header("Location: register.php");
        exit();
    }

    try {
        // Check if email already exists
        $checkQuery = "SELECT id FROM users WHERE email = :email";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            $_SESSION['error'] = "Email already exists.";
            header("Location: register.php");
            exit();
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert user into the database
        $query = "INSERT INTO users (name, email, phone, password) VALUES (:username, :email, :phone, :password)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->execute();

        $_SESSION['success'] = "Registration successful. You can now log in.";
        header("Location: login.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: register.php");
        exit();
    }
}
?>

<div class="container-fluid signup-layout">
  <div class="illustration">
    <div class="circle-backdrop"></div>
     <img src="../assets/images/logo_maroon.png" alt="Mera Shadi Hall Logo">
  </div>
  <div class="form-wrapper">

    <!-- Error / Success Messages Top par -->
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

    <h2 class="text-center">Register Now!</h2>

    <form action="" method="post">
      <div class="form-group">
        <label for="username">Username:</label>
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

      <!-- ✅ Corrected Password Field -->
      <div class="form-group">
        <label for="password">Password:</label>
        <div class="input-group">
          <input type="password" class="form-control" id="password" name="password" 
                 minlength="8"
                 title="Password must be at least 8 characters long"
                 required>
          <div class="input-group-append">
            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">👁</button>
          </div>
        </div>
      </div>

      <!-- ✅ Confirm Password with Match Check -->
      <div class="form-group">
        <label for="confirm_pass">Confirm Password:</label>
        <div class="input-group">
          <input type="password" class="form-control" id="confirm_pass" name="confirm_pass" minlength="8" required>
          <div class="input-group-append">
            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('confirm_pass')">👁</button>
          </div>
        </div>
        <small id="passMsg" style="color:red; display:none;">Passwords do not match</small>
      </div>

      <button type="submit" class="btn btn-primary" name="signup">Sign up</button>
    </form>
    <p class="mt-3">Already have an account? <a href="login.php">login here</a></p>
  </div>
</div>

<script>
function togglePassword(fieldId) {
  let input = document.getElementById(fieldId);
  input.type = (input.type === "password") ? "text" : "password";
}

// ✅ Confirm Password Validation
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
}

.illustration {
  flex: 1; position: relative;
  display: flex; justify-content: center; align-items: center;
}

.circle-backdrop {
  position: absolute; width: 300px; height: 300px;
  background: #8585854d; border-radius: 50%;
  top: 50%; left: 50%; transform: translate(-50%, -50%);
}

.illustration img {
  position: relative; z-index: 2;
  max-width: 80%; height: auto;
}

.form-wrapper {
  flex: 1; padding: 60px; box-sizing: border-box;
}

.form-wrapper h2 {
  font-size: 28px; font-weight: 600;
  color: #222; margin-bottom: 40px;
}

.form-group label {
  display: block;
  font-size: 14px; margin-bottom: 8px;
  font-weight: 500;
}

.form-control {
  width: 100%;
  padding: 8px 0; border: none;
  border-bottom: 1px solid #999;
  background: transparent;
  font-size: 16px; color: #333;
  border-radius: 0;
}

.form-control:focus-within {
  outline: none;
   border-bottom: 2px solid #222;
   box-shadow: none;
}

.btn-primary {
  display: block; width: 100%;
  padding: 14px; margin-top: 30px;
  background-color: #000; color: #fff;
  font-size: 16px; border: none;
  border-radius: 30px; cursor: pointer;
}

.btn-primary:hover {
  background-color: #333;
}

/* Alert Messages */
.alert {
  padding: 12px 20px;
  border-radius: 6px;
  margin-bottom: 20px;
  text-align: center;
  font-size: 14px;
  font-weight: 500;
}

.alert-danger {
  background: #ffe0e0;
  color: #d93025;
  border: 1px solid #d93025;
}

.alert-success {
  background: #e6ffed;
  color: #1e7e34;
  border: 1px solid #1e7e34;
}

.input-group-append .btn {
  border: none !important;
  background: transparent !important;
  box-shadow: none !important;
}

.input-group-append .btn:hover,
.input-group-append .btn:focus {
  border: none !important;
  background: transparent !important;
  box-shadow: none !important;
}

</style>
