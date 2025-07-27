<?php
include("../../db.php");
$banquet_id = $_GET['id'] ?? 0;

// 1. Get cover image path
$stmt = $pdo->prepare("SELECT image FROM banquets WHERE id = ?");
$stmt->execute([$banquet_id]);
$banquet = $stmt->fetch(PDO::FETCH_ASSOC);
if ($banquet && file_exists($banquet['image'])) {
    unlink($banquet['image']);
}

// 2. Get all gallery images
$stmt2 = $pdo->prepare("SELECT image FROM banquet_images WHERE banquet_id = ?");
$stmt2->execute([$banquet_id]);
while ($img = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    if ($img && file_exists($img['image'])) {
        unlink($img['image']);
    }
}

// 3. Delete gallery images from DB
$pdo->prepare("DELETE FROM banquet_images WHERE banquet_id = ?")->execute([$banquet_id]);
// 4. Delete banquet from DB
$pdo->prepare("DELETE FROM banquets WHERE id = ?")->execute([$banquet_id]);

$_SESSION['success'] = "Banquet Deleted successfully.";
header("Location: manage_banquet.php");
exit;
?>