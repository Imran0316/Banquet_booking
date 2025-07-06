<?php
session_start();

include '../db.php';
include '../includes/header.php';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["signup"])){
$name = $_POST["username"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$password = $_POST["password"];
$confirm_pass = $_POST["confirm_pass"];

if(empty($name) || empty($email) || empty($phone) || empty($password) || empty($confirm_pass)) {
  $_SESSION['error'] = "All fields are required.";
  header("Location: register.php");
  exit();
}else if($password !== $confirm_pass) {
   $_SESSION['error'] = "Passwords do not match.";
     header("Location: register.php");
      exit();

}else{
    $stmt = $pdo->prepare("SELECT * FROM USERS WHERE email = ?");
    $stmt->execute([$email]);
    if($stmt->rowCount() > 0){
        $_SESSION['error'] = "Email already exists.";
          header("Location: register.php");
  exit();
    }else{
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO `users`(`name`, `email`, `phone`, `password`, `created_at`) VALUES (?,?,?,?,NOW())");
        $stmt->execute([$name,$email,$phone,$hashed_password]);

        header("Location: login.php?registered=1");
        exit();
    }


}
}
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2 class="text-center">Register Now!</h2>
            <?php
            if(isset($_SESSION['error'])) {
                echo "<p class='text-danger'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']);
                
            }
            if(isset($_SESSION['success'])) {
                echo "<p class='text-success'>" . $_SESSION['success'] . "</p>";
                unset($_SESSION['success']);
            }
            ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_pass">Confirm Password:</label>
                    <input type="password" class="form-control" id="confirm_pass" name="confirm_pass" required>
                </div>
                <button type="submit" class="btn btn-primary" name="signup">Sign up</button>
            </form>
            <p class="mt-3">Already have an account? <a href="login.php">login here</a></p>
        </div>
    </div>
</div>



<?php
include '../includes/footer.php';
?>