<?php
session_start();
include("../../db.php");

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["status_action"])){
$id =$_POST["banquet_id"];
$status = $_POST["status"];
$remarks =$_POST["remarks"];

try{
$stmt =$pdo->prepare("UPDATE banquets SET status = ?, Remarks = ? WHERE id = ?");
$updated = $stmt->execute([$status,$remarks,$id]);
if($updated){
    $_SESSION["success"] = "Action Recorded";
    header("Location: banquets.php");
exit();
}else{
    $_SESSION["error"] = "Error Action!";
    header("Location: banquets.php");
exit();
}
}catch (PDOException $e) {
    $_SESSION["error"] = "DB Error: " . $e->getMessage();
}
}
?>