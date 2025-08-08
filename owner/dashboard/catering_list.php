<?php 
session_start();
include("../../db.php");
include("include/header.php");
include("include/sidebar.php");
$owner_id = $_SESSION['owner_id'];
$stmt = $pdo->prepare("SELECT * FROM catering_services WHERE owner_id = ?");
$catering_run = $stmt->execute([$owner_id]);
$catering_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$sr = 1;
?>


<!-- Content Start -->
<div class="content">
    <?php include("include/navbar.php"); ?>
    <div class="container-fluid pt-4 px-4">
        <div class="bg-white rounded-4 shadow-lg p-4" style="border-top:3px solid #DAA520;">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="mb-0 fw-bold" style="color:#800000;font-family:'Playfair Display',serif;">Manage Banquets
                </h4>
                <!-- Trigger Button -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCateringModal">
                    Add New Catering
                </button>


            </div>


            <?php
            if (isset($_SESSION['error'])) {
                echo "<div class='alert alert-danger mb-3'>" . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo "<div class='alert alert-success mb-3'>" . $_SESSION['success'] . "</div>";
                unset($_SESSION['success']);
            }
            ?>
            <div class="table-responsive">
                <table class="table align-middle table-bordered table-hover mb-0" style="background:#fffbe6;">
                    <thead>
                        <tr style="background:linear-gradient(90deg,#80000022,#DAA52022);color:#800000;">

                            <th scope="col">Sr.</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price per/head</th>
                            <th scope="col">Min Guest</th>
                            <th scope="col">Status</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($catering_rows){?>
                        <?php foreach ($catering_rows as $banquet_data) { ?>
                        <tr>

                            <td><?php echo $sr++; ?></td>
                            <td class="fw-bold" style="color:#800000;"><?php echo $banquet_data["title"]; ?></td>
                            <td><?php echo $banquet_data["description"]; ?></td>
                            <td><?php echo $banquet_data["price_per_head"]; ?></td>
                            <td><?php echo $banquet_data["min_guests"]; ?></td>
                            <td>
                                <span class="badge rounded-pill px-3 py-1"
                                    style="background:<?php echo ($banquet_data["status"] == "approved") ? "#DAA520" : "#800000"; ?>;color:#fff;">
                                    <?php echo ucfirst($banquet_data["status"]); ?>
                                </span>
                            </td>
                            <td><?php echo date('d M Y', strtotime($banquet_data["created_at"])); ?></td>
                            <td>
                                <a href="edit_banquet.php?id=<?php echo $banquet_data["id"]; ?>" class="me-2"
                                    title="Edit">
                                    <i class="fa-regular fa-pen-to-square" style="color:#DAA520;font-size:1.2rem;"></i>
                                </a>
                                <a href="delete_banquet.php?id=<?php echo $banquet_data["id"]; ?>" title="Delete">
                                    <i class="fa-solid fa-trash-can" style="color:#800000;font-size:1.2rem;"></i>
                                </a>
                            </td>
                        </tr>
                        <?php }?>
                        <?php }else {
                             echo "<div class='alert alert-danger w-50'>No banquets found for this owner.</div>";
                        } ?>
                    </tbody>
                </table>

            </div>

        </div>
        <!-- Button trigger modal -->
        <?php include("include/footer.php"); ?>



        <!-- Modal -->
        <div class="modal fade" id="addCateringModal" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" action="catering_store.php" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Catering Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Banquet dropdown -->
                        <div class="mb-3">
                            <label>Banquet</label>
                            <select name="banquet_id" class="form-select" required>
                                <option value="" hidden>Select Banquet</option>
                                <?php
                                        
                                        $banquets = $pdo->query("SELECT * FROM banquets WHERE owner_id = $owner_id");
                                        while ($b = $banquets->fetch(PDO::FETCH_ASSOC)):
                                        ?>
                                <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['name']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <input type="hidden" name="owner_id" value="<?php echo $owner_id; ?>">

                        <!-- Title -->
                        <div class="mb-3">
                            <label>Menu Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control" id=""></textarea>
                        </div>
                        <!-- Price Per Head -->
                        <div class="mb-3">
                            <label>Price Per Head (Rs)</label>
                            <input type="number" name="price_per_head" class="form-control" required>
                        </div>

                        <!-- Min Guests -->
                        <div class="mb-3">
                            <label>Minimum Guests</label>
                            <input type="number" name="min_guests" class="form-control" required>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save Catering</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>

<style>
.bg-white {
    background: #fff !important;
}

.table thead tr {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    letter-spacing: 1px;
}

.table-hover tbody tr:hover {
    background: #fff5f5 !important;
    transition: background 0.2s;
}

.badge {
    font-size: 0.9rem;
    font-family: 'Poppins', sans-serif;
}
</style>