<?php 
session_start();
include("../../db.php");
include("include/header.php");
// include("include/spinner.php");
include("include/sidebar.php");
$owner_id = $_SESSION["owner_id"];
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["banquet_submit"])){
$id = $_POST["owner_id"];
$Banquet_name = $_POST["banquet_name"];
$location = $_POST["location"];
$capacity = $_POST["capacity"];
$price = $_POST["price"];
$description = $_POST["description"];

$targetDir = "../../uploads/";
$fileName = basename($_FILES["cover_image"]["name"]);
$targetFile = $targetDir . time() . "_" . $fileName;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

$Allowedtype = ['jpg','jpeg','gif','png'];

if(in_array($imageFileType,$Allowedtype)){
  if(move_uploaded_file($_FILES["cover_image"]["tmp_name"], $targetFile)){
    $stmt=$pdo->prepare("INSERT INTO `banquets`( `owner_id`, `name`, `location`, `capacity`, `price`, `description`, `image`, `created_at`) VALUES (?,?,?,?,?,?,?,NOW())");
    $stmt->execute([$owner_id,$Banquet_name,$location,$capacity,$price,$description,$targetFile]);
    $_SESSION['success'] = "Banquet Added successfully";
    header("Location: add_banquet.php");
    exit();
  }else{
    $_SESSION['error'] = "Image upload failed";

  }
}else{
    $_SESSION['error'] = "File type error";
}
}
?>


<!-- Content Start -->
<div class="content">


    <?php
include("include/navbar.php");

?>
    <!-- Banquet detail form -->
    <div class="container-fluid px-4">
        <div class="banquet-form mt-4 p-4">
            <h5 class="mb-3 text-primary fw-semibold">Add Banquet Details</h5>
            <?php
            if(isset($_SESSION['error'])) {
                echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']);
                
            }
            if(isset($_SESSION['success'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
                unset($_SESSION['success']);
            }
            ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                        <input type="hidden" class="form-control form-control-sm"  value="<?php echo $owner_id ?>" name="owner_id" >

                    <div class="col-md-6">
                        <label class="form-label small">Banquet Name</label>
                        <input type="text" class="form-control form-control-sm" name="banquet_name" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Location</label>
                        <input type="text" class="form-control form-control-sm" name="location" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label small">Capacity</label>
                        <input type="number" class="form-control form-control-sm" name="capacity" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Price (PKR)</label>
                        <input type="number" class="form-control form-control-sm" name="price" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small">Description</label>
                    <textarea class="form-control form-control-sm" name="description" rows="2"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label small">Cover Image</label>
                    <input type="file" name="cover_image" class="form-control" id="cover_image">
                </div>

                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-sm btn-primary" name="banquet_submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <?php 
include("include/footer.php");
?>