<?php
include("../../db.php");

$owner_id = $_POST['owner_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

// Handle Image Upload
$image = $_FILES['image']['name'];
$tmp = $_FILES['image']['tmp_name'];

if (!empty($image)) {
    $imagePath = "../../uploads" . $image;
    move_uploaded_file($tmp, $imagePath);
    $stmt = $pdo->prepare("UPDATE banquet_owner SET name=?, email=?, phone=?, owner_image=? WHERE id=?");
    $stmt->execute([$name, $email, $phone, $image, $owner_id]);
} else {
    $stmt = $pdo->prepare("UPDATE banquet_owner SET name=?, email=?, phone=? WHERE id=?");
    $stmt->execute([$name, $email, $phone, $owner_id]);
}

header("Location: owner_profile.php?id=" . $owner_id);
exit;
?>
