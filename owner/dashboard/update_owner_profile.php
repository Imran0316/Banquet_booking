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
    // Get old image path from DB
    $stmt = $pdo->prepare("SELECT owner_image FROM banquet_owner WHERE id = ?");
    $stmt->execute([$owner_id]);
    $old = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($old['owner_image']) && file_exists('../../uploads/' . $old['owner_image'])) {
        unlink('../../uploads/' . $old['owner_image']);
    }

    // Now upload new image and update DB as usual
    $imagePath = "../../uploads/" . $image;
    move_uploaded_file($tmp, $imagePath);
    $stmt = $pdo->prepare("UPDATE banquet_owner SET name=?, email=?, phone=?, owner_image=? WHERE id=?");
    $stmt->execute([$name, $email, $phone, $image, $owner_id]);
} else {
    // No new image, don't touch old image
    $stmt = $pdo->prepare("UPDATE banquet_owner SET name=?, email=?, phone=? WHERE id=?");
    $stmt->execute([$name, $email, $phone, $owner_id]);
}

header("Location: owner_profile.php?id=" . $owner_id);
exit;
?>
