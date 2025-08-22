<?php
session_start();
include '../db.php'; // PDO connection

if (isset($_POST['update_password'])) {
    $userId = $_SESSION['id'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // 1. Check new password == confirm
    if ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = "New password & confirm password do not match!";
        header("Location: user_profile.php");
        exit;
    }

    // 2. Fetch current password hash from DB
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['error'] = "User not found!";
        header("Location: user_profile.php");
        exit;
    }

    // 3. Verify current password
    if (!password_verify($currentPassword, $user['password'])) {
        $_SESSION['error'] = "Current password is incorrect!";
        header("Location: user_profile.php");
        exit;
    }

    // 4. Hash new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // 5. Update password
    $update = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    if ($update->execute([$hashedPassword, $userId])) {
        $_SESSION['success'] = "Password updated successfully.";
        header("Location: user_profile.php");
        exit;
    } else {
        $_SESSION['error'] = "Error updating password!";
        header("Location: user_profile.php");
        exit;
    }
}
?>