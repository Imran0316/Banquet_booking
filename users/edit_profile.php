<?php
session_start();
// ensure user logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}
include("../db.php");
$userId = $_SESSION['id'] ?? null;
if (isset($_POST["update"]) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Update user profile
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?");
    if ($stmt->execute([$name, $email, $phone, $userId])) {
        header("Location: user_profile.php");
        $_SESSION['success'] = "Profile updated successfully.";
        exit();
    } else {
        header("Location: user_profile.php");
        $_SESSION['error'] = "Failed to update profile.";
        exit();

    }

} else {
    $_SESSION['error'] = "Invalid input.";
    header("Location: user_profile.php");
    exit();

}



?>