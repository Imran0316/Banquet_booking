<?php
session_start();
include("../../db.php");
$banquet_id = $_GET["id"];
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["banquet_update"])){
$banquet_name = $_POST["banquet_name"];
$location =$_POST["location"];
$capacity = $_POST["capacity"];
$price = $_POST["price"];
$description =$_POST["description"];
$cover_image =$_POST["cover_image"];

$stmt = $pdo->prepare("UPDATE banquets SET name = ?, location = ?, capacity = ?, price = ?, description = ?, image = ?  WHERE id = ?");
$stmt->execute([$banquet_name,$location,$capacity,$price,$description,$cover_image,$banquet_id]);
if($stmt){
  $_SESSION['success'] = "Updated  Successfully";

  exit();
}else{
     $_SESSION['error'] = "Error Updating";

  exit();
}
}
?>

