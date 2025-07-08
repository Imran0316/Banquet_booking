<?php
session_start();

include '../db.php';
include '../includes/header.php';


if(isset($_GET['registered']) && $_GET['registered'] == 1) {
    echo "<div class='alert alert-success'>Registration successful! </br>
Your account is pending approval. You will be notified once it's approved. </div>";
    
}
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["login"])){
$email = $_POST["email"];
$password = $_POST["password"];

if(empty($email) || empty($password)) {
    $_SESSION['error'] = "All fields are required.";    
    header("Location: login.php");
    exit();
}

// $stmt = $pdo->prepare("SELECT * FROM banquet_owner");
// $banquet_owner =  $stmt->fetchAll();


$stmt = $pdo->prepare("SELECT * FROM banquet_owner WHERE email = ? ");
$stmt->execute([$email]);
$owner_status = $stmt->fetch();



if($owner_status['status'] == "approved"){
if(password_verify($password,$owner_status['password'])){
    $_SESSION['owner_id'] = $owner_status['id'];
    $_SESSION['owner_name'] = $owner_status['name'];
    $_SESSION['owner_email'] = $owner_status['email'];

  header("Location: ../index.php");   
  exit();
}
}else{
     $_SESSION['error'] = "Not approved yet!";    
     header("Location: login.php");
     exit();
}
// if($owner_status == "pending" && password_verify($password, $banquet_owner['password'])){

//     $_SESSION['id'] = $user['id'];
//     $_SESSION['name'] = $user['name'];
//     $_SESSION['email'] = $user['email'];

//   header("Location: ../index.php");   
//   exit();
// }else{
//      $_SESSION['error'] = "Email or password is incorrect";    
//      header("Location: login.php");
//      exit();
// }
}
?>

<div class="container-fluid">
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