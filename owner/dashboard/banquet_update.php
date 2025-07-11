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

$targetDir="../../uploads/";
$fileName = basename($_FILES["cover_image"]["name"]);
$targetFile = $targetDir . time() . "_" . $fileName;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

$AllowedTypes = ['jpg','jpeg','gif','png'];

if(in_array($imageFileType,$AllowedTypes)){
  if(move_uploaded_file($_FILES["cover_image"]["tmp_name"],$targetFile)){
      
$stmt = $pdo->prepare("UPDATE banquets SET name = ?, location = ?, capacity = ?, price = ?, description = ?, image = ?  WHERE id = ?");
$stmt->execute([$banquet_name,$location,$capacity,$price,$description,$targetFile,$banquet_id]);
$_SESSION["success"] = "Updated successfully";
header("Location: edit_banquet.php?id=$banquet_id");
exit();

  }else{
    $_SESSION['error'] = "Image upload failed";
    header("Location: edit_banquet.php?id=$banquet_id");
exit();

  }
}else{
    $_SESSION['error'] = "File type error";
    header("Location: edit_banquet.php?id=<?php echo $banquet_id; ?>");
exit();

}


}
?>