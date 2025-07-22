<?php
session_start();

include '../db.php';
include '../includes/header.php';

if (isset($_GET['registered']) && $_GET['registered'] == 1) {
    echo "<div class='alert alert-success'>Registration successful! You can now log in.</div>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: login.php");
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];

        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['error'] = "Email or password is incorrect";
        header("Location: login.php");
        exit();
    }
}
?>



<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center" style="background:linear-gradient(120deg,#fffbe6 60%,#fff5f5 100%);">
    <div class="row w-100 justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-4 p-4" style="background:#fff;">
                <div class="text-center mb-4">
                    <div class="mb-2">
                        <span class="d-inline-block rounded-circle" style="background:linear-gradient(45deg,#800000,#DAA520);width:70px;height:70px;">
                            <i class="fas fa-hotel fa-2x text-white" style="line-height:70px;"></i>
                        </span>
                    </div>
                    <h2 class="fw-bold mb-0" style="font-family:'Playfair Display',serif;color:#800000;letter-spacing:1px;"><span style="color:#DAA520;">Login</span></h2>
                    <p class="text-muted mb-0" style="font-size:1rem;">Welcome to Mera Shadi Hall</p>
                </div>
                <?php
                if (isset($_SESSION['error'])) {
                    echo "<div class='alert alert-danger text-center fw-bold'>" . $_SESSION['error'] . "</div>";
                    unset($_SESSION['error']);
                }
                if (isset($_SESSION['success'])) {
                    echo "<div class='alert alert-success text-center fw-bold'>" . $_SESSION['success'] . "</div>";
                    unset($_SESSION['success']);
                }
                ?>
                <form action="" method="post" autocomplete="off">
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold text-maroon"><i class="fa fa-envelope me-1"></i> Email</label>
                        <input type="email" class="form-control rounded-pill border-2" id="email" name="email" required style="border-color:#DAA520;">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold text-maroon"><i class="fa fa-lock me-1"></i> Password</label>
                        <input type="password" class="form-control rounded-pill border-2" id="password" name="password" required style="border-color:#DAA520;">
                    </div>
                    <button type="submit" name="login" class="btn w-100 py-2 fw-bold rounded-pill" style="background:linear-gradient(90deg,#800000,#DAA520);color:#fff;font-size:1.1rem;box-shadow:0 2px 10px #DAA52044;">Login</button>
                </form>
                <p class="mt-4 text-center">Don't have an account? <a href="register.php" style="color:#800000;font-weight:500;">Register here</a></p>
                <hr>
                <div class="text-center">
                    <small class="text-muted">© 2025 Banquet Booking. All rights reserved.</small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-maroon {
        color: #800000 !important;
    }

    .card {
        border-radius: 1.5rem !important;
    }

    .btn:focus,
    .form-control:focus {
        box-shadow: 0 0 0 2px #DAA52044 !important;
        border-color: #DAA520 !important;
    }

    input[type="email"],
    input[type="password"] {
        background: #fffbe6 !important;
    }
</style>