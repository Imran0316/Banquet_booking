<?php
session_start();
include("../../db.php");
include("include/header.php");
// include("include/spinner.php");

$stmt = $pdo->query("SELECT name , email, status FROM banquet_owner  ORDER BY id DESC LIMIT 3");
$stmt->execute();
$banquet_owners = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("
    SELECT banquets.name, banquets.status ,
    banquet_owner.name AS banquet_owner_name
    FROM banquets 
    JOIN banquet_owner ON banquets.owner_id = banquet_owner.id 
    ORDER BY banquets.id DESC 
    LIMIT 3
");

$stmt->execute();
$banquets = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt=$pdo->query("SELECT COUNT(*) AS total FROM banquet_owner");
$owner_count = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt=$pdo->query("SELECT COUNT(*) AS total FROM banquets");
$banquet_count = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<?php
include("include/sidebar.php");
?>



<!-- Content Start -->
<div class="content">
    <?php
include("include/navbar.php");
?>


    <!-- Sale & Revenue Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-line fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Today bookings</p>
                        <h6 class="mb-0"></h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-bar fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Banquet Owners</p>
                        <h6 class="mb-0 fs-2"><?php echo $owner_count["total"]; ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-area fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2 ">Total banquets</p>
                        <h6 class="mb-0 fs-2"><?php echo $banquet_count["total"]; ?></h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-pie fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Banquets</p>
                        <h6 class="mb-0"></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sale & Revenue End -->


    <!-- Sales Chart Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-6">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Banquet Owners</h6>
                        <a href="banquet_owner.php">Show All</a>
                    </div>
                    <table class="table text-start align-middle table-hover">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                        <tr>
                            <?php foreach($banquet_owners as $owner): ?>
                            <td><?php echo $owner['name']; ?></td>
                            <td><?php echo $owner['email']; ?></td>
                            <td><?php echo $owner['status']; ?></td>
                        </tr>
                        <?php endforeach;
                        ?>

                    </table>
                </div>
            </div>
            <div class="col-sm-12 col-xl-6">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Bnaquets</h6>
                        <a href="banquets.php">Show All</a>
                    </div>
                      <table class="table text-start align-middle table-hover">
                        <tr>
                            <th>Banquet Name</th>
                            <th>Owner Name</th>
                            <th>Status</th>
                        </tr>
                        <tr>
                            <?php foreach($banquets as $banquet): ?>
                            <td><?php echo $banquet['name']; ?></td>
                            <td><?php echo $banquet['banquet_owner_name']; ?></td>
                            <td><?php echo $banquet['status']; ?></td>
                        </tr>
                        <?php endforeach;
                        ?>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Sales Chart End -->





    <?php
include("include/footer.php");
?>