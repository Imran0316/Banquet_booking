<?php
include("../../db.php");
$banquet_id = $_GET["id"];
$stmt = $pdo->prepare("DELETE FROM banquets WHERE id = ?");
$delete = $stmt->execute([$banquet_id]);
if($delete){
$_SESSION["success"] = "Delete Successfully";
header("Location: manage_banquet.php");
exit();
}else{
$_SESSION["error"] = "Delete Failed!";
header("Location: manage_banquet.php");
exit();
}
?>