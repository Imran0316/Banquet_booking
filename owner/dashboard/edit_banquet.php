<?php
session_start();
include("../../db.php");
include("include/header.php");
// include("include/spinner.php");
include("include/sidebar.php");
$banquet_id = $_GET["id"];
$stmt = $pdo->prepare("SELECT * FROM banquets WHERE id = ?");
$stmt->execute([$banquet_id]);
$banquet_row = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<!-- Content Start -->
<div class="content">


    <?php
include("include/navbar.php");
?>

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
            <form action="banquet_update.php?id=<?php echo $banquet_id; ?>" method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                        <input type="hidden" class="form-control form-control-sm"  value="<?php echo $owner_id ?>" name="owner_id" >

                    <div class="col-md-6">
                        <label class="form-label small">Banquet Name</label>
                        <input type="text" class="form-control form-control-sm" value="<?php echo $banquet_row["name"] ?>" name="banquet_name" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Location</label>
                        <input type="text" class="form-control form-control-sm" value="<?php echo $banquet_row["location"] ?>" name="location" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label small">Capacity</label>
                        <input type="number" class="form-control form-control-sm" value="<?php echo $banquet_row["capacity"] ?>" name="capacity" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Price (PKR)</label>
                        <input type="number" value="<?php echo $banquet_row["price"] ?>" class="form-control form-control-sm" name="price" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small">Description</label>
                    <textarea class="form-control form-control-sm"  name="description" rows="2"><?php echo $banquet_row["description"] ?></textarea>
                </div>
                 <div>
                    <img width="100px" src='../../uploads<?php echo $banquet_row["image"] ?>' alt="banquet image" srcset="">
                 </div>
                <div class="mb-3">
                    <label class="form-label small">Cover Image</label>
                    <input type="file" name="cover_image" class="form-control"  id="cover_image">
                </div>

                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-sm btn-primary" name="banquet_update">Update</button>
                </div>
            </form>
        </div>
    </div>


    <?php
include("include/footer.php");
?>


