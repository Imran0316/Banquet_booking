<?php

session_start();
include("../../db.php");

$image_id = $_GET['id'] ?? 0;
$banquet_id = $_GET['banquet_id'] ?? 0;

// Get image path from DB
$stmt = $pdo->prepare("SELECT image FROM banquet_images WHERE id = ?");
$stmt->execute([$image_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row && !empty($row['image'])) {
    $imagePath = "../../uploads/" . $row['image'];
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
    // Delete from DB
    $stmt = $pdo->prepare("DELETE FROM banquet_images WHERE id = ?");
    $stmt->execute([$image_id]);
    $_SESSION['success'] = "Gallery image deleted successfully.";
} else {
    $_SESSION['error'] = "Image not found.";
}

header("Location: edit_banquet.php?id=" . $banquet_id);
exit;
?>