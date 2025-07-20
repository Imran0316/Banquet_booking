<?php
session_start();
include("../../db.php");
include("include/header.php");
include("include/sidebar.php");

$banquet_id = $_GET["id"];
$stmt = $pdo->prepare("SELECT * FROM banquets WHERE id = ?");
$stmt->execute([$banquet_id]);
$banquet_row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!-- Content Start -->
<div class="content">
<?php include("include/navbar.php"); ?>

<div class="container-fluid px-4">
    <div class="banquet-form mt-5 p-4 rounded shadow" style="background-color: #ffffff;">
        <h4 class="mb-4 fw-bold text-primary border-bottom pb-2">Edit Banquet Details</h4>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form action="banquet_update.php?id=<?php echo $banquet_id; ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="owner_id" value="<?php echo $owner_id; ?>">

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Banquet Name</label>
                    <input type="text" name="banquet_name" class="form-control" required value="<?php echo htmlspecialchars($banquet_row["name"]); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" required value="<?php echo htmlspecialchars($banquet_row["location"]); ?>">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Capacity</label>
                    <input type="number" name="capacity" class="form-control" required value="<?php echo $banquet_row["capacity"]; ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Price (PKR)</label>
                    <input type="number" name="price" class="form-control" required value="<?php echo $banquet_row["price"]; ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($banquet_row["description"]); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Cover Image</label><br>
                <?php if (!empty($banquet_row["image"])): ?>
                    <img src="../../uploads<?php echo $banquet_row["image"]; ?>" class="img-thumbnail mb-2" style="width: 150px;">
                <?php else: ?>
                    <p class="text-muted">No image uploaded yet.</p>
                <?php endif; ?>
                <input type="hidden" name="old_image" value="<?php echo $banquet_row["image"]; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Upload New Cover Image</label>
                <input type="file" name="cover_image" class="form-control">
            </div>

            <div class="d-grid">
                <button type="submit" name="banquet_update" class="btn btn-primary">Update Banquet</button>
            </div>
        </form>
    </div>
</div>

<?php include("include/footer.php"); ?>

