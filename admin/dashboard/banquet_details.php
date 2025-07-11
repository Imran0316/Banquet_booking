<?php
session_start();
include("../../db.php");
include("include/header.php");
// include("include/spinner.php");
include("include/sidebar.php");
$banquet_id=$_GET["id"];
$stmt = $pdo->prepare("SELECT banquets.*,
banquet_owner.name AS owner_name,
banquet_owner.phone AS owner_phone,
banquet_owner.email AS owner_email
FROM banquets
JOIN banquet_owner ON banquets.owner_id = banquet_owner.id
WHERE banquets.id = ?
");
$stmt->execute([$banquet_id]);
$banquet_row = $stmt->fetch(PDO::FETCH_ASSOC);
$sr = 1;
?>

<!-- Content Start -->
<div class="content">
    <?php
include("include/navbar.php");
?>
    <style>
    .table th {
        color: black !important;
    }
    </style>

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Banquet Details</h6>
                <a href="">Show All</a>
            </div>
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
            <div class="table-responsive py-5">
                <table class="table text-start align-middle  table-hover">
                    <tr>
                        <th>Banquet Name: </th>
                        <td><?php echo $banquet_row["name"]; ?></td>
                        <th>Owner Name: </th>
                        <td><?php echo $banquet_row["owner_name"]; ?></td>
                        <th> Email: </th>
                        <td><?php echo $banquet_row["owner_email"]; ?></td>
                    </tr>
                    <tr>
                        <th>Phone: </th>
                        <td><?php echo $banquet_row["owner_phone"]; ?></td>
                        <th>Registration Date: </th>
                        <td><?php echo $banquet_row["created_at"]; ?></td>
                        <th> Location: </th>
                        <td><?php echo $banquet_row["location"]; ?></td>
                    </tr>
                    <tr>
                        <th>Capacity: </th>
                        <td><?php echo $banquet_row["capacity"]; ?></td>
                        <th>Price: </th>
                        <td><?php echo $banquet_row["price"]; ?></td>
                        <th>status: </th>
                        <td><?php echo $banquet_row["status"]; ?></td>
                    </tr>

                </table>
                <table class="table text-start align-middle  table-hover">
                    <tr>
                        <th>Description: </th>
                        <td><?php echo $banquet_row["description"]; ?></td>
                    </tr>
                    <tr>
                        <th>Cover Image: </th>
                        <td><img width="100px" src='../../uploads<?php echo $banquet_row["image"] ?>'
                                alt="banquet image" srcset=""></td>
                    </tr>

                </table>

                <!-- Action Button -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#actionModal">
                    Action
                </button>

                <!-- Modal -->
                <div class="modal fade" id="actionModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <!-- Centered vertically -->
                        <div class="modal-content">
                            <form method="POST" action="banquet_approve.php">
                                <div class="modal-header">
                                    <h5 class="modal-title">Take Action</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="banquet_id" value="<?= $banquet_row['id'] ?>">

                                    <div class="mb-3">
                                        <label class="form-label">Approval Status</label>
                                        <select class="form-select" name="status" required>
                                            <option value="approved">Approved</option>
                                            <option value="rejected">Rejected</option>
                                            <option value="rejected">Pending</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Remarks</label>
                                        <textarea class="form-control" name="remarks" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    
                                    <input type="submit" name="status_action" class="btn btn-success" value="submit">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


    <?php
include("include/footer.php");

?>