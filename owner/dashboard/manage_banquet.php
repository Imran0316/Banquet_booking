<?php
session_start();
include("../../db.php");
include("include/header.php");
include("include/sidebar.php");
$owner_id = $_SESSION["owner_id"];
$stmt = $pdo->prepare("SELECT banquets.*,
banquet_owner.name AS owner_name
FROM banquets
JOIN banquet_owner ON banquets.owner_id = banquet_owner.id
WHERE banquets.owner_id = ?
");
$stmt->execute([$owner_id]);
$banquet_data= $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <a href="" class="fw-bold" style="color:#DAA520;">Show All</a>
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
                            <th scope="col">Banquet Name</th>
                            <th scope="col">Owner Name</th>
                            <th scope="col">Location</th>
                            <th scope="col">Status</th>
                            <th scope="col">Remarks</th>
                            <th scope="col">Registration Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($banquet_data){?>
                        <?php foreach ($banquet_data as $banquet_data) { ?>
                            <tr>

                                <td><?php echo $sr++; ?></td>
                                <td class="fw-bold" style="color:#800000;"><?php echo $banquet_data["name"]; ?></td>
                                <td><?php echo $banquet_data["owner_name"]; ?></td>
                                <td><?php echo $banquet_data["location"]; ?></td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-1"
                                        style="background:<?php echo ($banquet_data["status"] == "approved") ? "#DAA520" : "#800000"; ?>;color:#fff;">
                                        <?php echo ucfirst($banquet_data["status"]); ?>
                                    </span>
                                </td>
                                <td><?php echo $banquet_data["Remarks"]; ?></td>
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
    </div>
    <?php include("include/footer.php"); ?>
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