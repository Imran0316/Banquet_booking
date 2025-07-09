<?php
include("../../db.php");

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["status_action"])){
$id = $_POST["id"];
$current_status = $_POST["current_status"];

$new_status = ($current_status == 'approved') ? 'rejected' : 'approved';
$stmt = $pdo->prepare("UPDATE banquet_owner SET status = ? WHERE id = ?"); 
$stmt->execute([$new_status,$id]);
header("Location: banquet_owner.php");
exit();
}

?>