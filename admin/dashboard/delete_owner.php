<?php
include("../../db.php");
$owner_id = $_GET["id"];
$stmt = $pdo->prepare("DELETE FROM banquet_owner WHERE id = ?");
$delete = $stmt->execute([$owner_id]);
if($delete){
$_SESSION["success"] = "Delete Successfully";
header("Location: banquets.php");
exit();
}else{
$_SESSION["error"] = "Delete Failed!";
header("Location: banquets.php");
exit();
}
?>