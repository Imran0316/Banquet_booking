<?php
session_start();

include '../db.php';
include '../includes/header.php';

if(isset($_GET['registered']) && $_GET['registered'] == 1) {
    echo "<div class='alert alert-success'>Registration successful! You can now log in.</div>";
    
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["login"])){
$email = $_POST["email"];
$password = $_POST["password"];

if(empty($email) || empty($password)) {
    $_SESSION['error'] = "All fields are required.";    
    header("Location: login.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if($user && password_verify($password, $user['password'])){

    $_SESSION['id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['email'] = $user['email'];

  header("Location: ../index.php");   
  exit();
}else{
     $_SESSION['error'] = "Email or password is incorrect";    
     header("Location: login.php");
     exit();
}
}
?>

<div class="login login_user container-fluid">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2 class="text-center">Login</h2>
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
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary">Login</button>
            </form>
            <p class="mt-3">Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</div>