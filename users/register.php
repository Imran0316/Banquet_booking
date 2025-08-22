<?php
session_start();
include '../db.php';
include '../includes/header.php';
?>

<div class="container-fluid signup-layout">
  <div class="illustration">
    <div class="circle-backdrop"></div>
     <img src="...assets/images/logo_maroon.png" alt="Mera Shadi Hall Logo">
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
      <div class="form-group">
        <label for="password">Password:</label>
        <div class="input-group">
          <input type="password" class="form-control" id="password" name="password" 
                 pattern="[A-Za-z]{6}[0-9]{9}" 
                 title="Password must be 15 characters: 6 letters + 9 digits" required>
          <div class="input-group-append">
            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">👁</button>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="confirm_pass">Confirm Password:</label>
        <div class="input-group">
          <input type="password" class="form-control" id="confirm_pass" name="confirm_pass" required>
          <div class="input-group-append">
            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('confirm_pass')">👁</button>
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary" name="signup">Sign up</button>
    </form>
    <p class="mt-3">Already have an account? <a href="login.php">login here</a></p>
  </div>
</div>

<script>
function togglePassword(fieldId) {
  let input = document.getElementById(fieldId);
  if (input.type === "password") {
    input.type = "text";
  } else {
    input.type = "password";
  }
}
</script>

<style>
body {
  margin: 0; padding: 0;
  font-family: 'Segoe UI', sans-serif;
  background: linear-gradient(to right bottom, #fce8e6, #fff5f9);
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
  background: #ffc0cb; border-radius: 50%;
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


.form-control:focus {
  outline: none; border-bottom: 2px solid #222;
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
