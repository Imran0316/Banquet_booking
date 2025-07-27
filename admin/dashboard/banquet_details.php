<?php
session_start();
include("../../db.php");
include("include/header.php");
include("include/sidebar.php");

$banquet_id = $_GET["id"];

// Fetch Banquet + Owner
$stmt = $pdo->prepare("SELECT banquets.*, banquet_owner.name AS owner_name, banquet_owner.phone AS owner_phone, banquet_owner.email AS owner_email FROM banquets JOIN banquet_owner ON banquets.owner_id = banquet_owner.id WHERE banquets.id = ?");
$stmt->execute([$banquet_id]);
$banquet_row = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch banquet gallery images
$img_stmt = $pdo->prepare("SELECT * FROM banquet_images WHERE banquet_id = ?");
$img_stmt->execute([$banquet_id]);
$gallery_images = $img_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Content Start -->
<div class="content">
    <?php include("include/navbar.php"); ?>

    <style>
        .table th { color: black !important; }
        .cover-img { width: 100%; height: 300px; object-fit: cover; border-radius: 12px; margin-bottom: 20px; }
        .gallery-thumb { height: 100px; width: 100%; max-width: 120px; object-fit: cover; border-radius: 8px; transition: 0.3s; cursor: pointer; box-shadow: 0 2px 8px #DAA52022; border: 2px solid #fffbe6; }
        .gallery-thumb:hover { transform: scale(1.07); border-color: #DAA520; }
        @media (max-width: 575px) {
            .gallery-thumb { height: 70px; max-width: 90px; }
            .table th, .table td { font-size: 13px; padding: 6px 4px; }
        }
        /* Modal image always same size and centered */
        .gallery-modal-img { width: 100%; max-width: 700px; height: 400px; object-fit: contain; margin: auto; display: block; background: #fffbe6; border-radius: 12px; }
        @media (max-width: 767px) {
            .gallery-modal-img { height: 220px; max-width: 98vw; }
        }
    </style>

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Banquet Details</h6>
                <a href="banquets_list.php">Show All</a>
            </div>
            <h2 class="py-3"><?php echo $banquet_row["name"] . " By " . $banquet_row["owner_name"] ?></h2>

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

            <!-- Cover Image -->
            <img src="../../uploads<?php echo $banquet_row['image']; ?>" alt="Cover Image" class="cover-img">

            <!-- Banquet Info Table -->
            <div class="table-responsive mb-3">
                <table class="table text-start align-middle border table-hover">
                    <tr>
                        <th>Banquet Name:</th><td><?php echo $banquet_row["name"]; ?></td>
                        <th>Owner Name:</th><td><?php echo $banquet_row["owner_name"]; ?></td>
                        <th>Email:</th><td><?php echo $banquet_row["owner_email"]; ?></td>
                    </tr>
                    <tr>
                        <th>Phone:</th><td><?php echo $banquet_row["owner_phone"]; ?></td>
                        <th>Registration Date:</th><td><?php echo $banquet_row["created_at"]; ?></td>
                        <th>Location:</th><td><?php echo $banquet_row["location"]; ?></td>
                    </tr>
                    <tr>
                        <th>Capacity:</th><td><?php echo $banquet_row["capacity"]; ?></td>
                        <th>Price:</th><td><?php echo $banquet_row["price"]; ?></td>
                        <th>Status:</th><td><?php echo $banquet_row["status"]; ?></td>
                    </tr>
                </table>
            </div>

            <!-- Description Table -->
            <div class="table-responsive mb-3">
                <table class="table text-start align-middle border table-hover">
                    <tr>
                        <th>Description:</th>
                        <td><?php echo $banquet_row["description"]; ?></td>
                    </tr>
                </table>
            </div>

            <!-- Gallery Images Section -->
            <div class="row mt-5 g-3">
                <h5 class="text-start mb-3">Gallery Images</h5>
                <?php foreach ($gallery_images as $index => $image): ?>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 d-flex justify-content-center">
                        <img src="../../uploads/<?php echo $image['image']; ?>" class="gallery-thumb"
                             data-bs-toggle="modal" data-bs-target="#galleryModal"
                             data-bs-slide-to="<?php echo $index; ?>">
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Action Button -->
            <button class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#actionModal">Action</button>

            <!-- Action Modal -->
            <div class="modal fade" id="actionModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
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
                                        <option value="pending">Pending</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Remarks</label>
                                    <textarea class="form-control" name="remarks" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" name="status_action" class="btn btn-success" value="Submit">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Gallery Modal with Carousel -->
            <div class="modal fade" id="galleryModal" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content bg-dark">
                        <div class="modal-body p-0">
                            <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php foreach ($gallery_images as $i => $image): ?>
                                        <div class="carousel-item <?php echo $i == 0 ? 'active' : ''; ?>">
                                            <img src="../../uploads/<?php echo $image['image']; ?>" class="d-block w-100 gallery-modal-img">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include("include/footer.php"); ?>
