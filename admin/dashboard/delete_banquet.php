<?php
session_start();
include("../../db.php");
$banquet_id = $_GET["id"];
$stmt2 = $pdo->prepare("DELETE FROM banquet_images WHERE banquet_id = ?");
$delete2 = $stmt2->execute([$banquet_id]);
$stmt = $pdo->prepare("DELETE FROM banquets WHERE id = ?");
$delete = $stmt->execute([$banquet_id]);
if($delete && $delete2){
    $_SESSION["success"] = "Banquet deleted successfully";
    header("Location: banquets.php");
    exit();
} else {
    $_SESSION["error"] = "Failed to delete banquet!";
    header("Location: banquets.php");
    exit();
}


?>