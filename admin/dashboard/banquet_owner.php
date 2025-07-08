<?php

include("../../db.php");
include("include/header.php");
// include("include/spinner.php");

include("include/sidebar.php");

if($_SERVER['REQUEST_METHOD'] === 'POST'){
// $stmt = $pdo->query("UPDATE banquet_owner SET status = 'Approved' WHERE id = 2");

}

$stmt=$pdo->query("SELECT * FROM banquet_owner");
$sr = 1;
?>

<div class="content">
    <?php
    include("include/navbar.php");
    ?>

    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Banquets Owner Detail</h6>
                <a href="">Show All</a>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col"><input class="form-check-input" type="checkbox"></th>
                            <th scope="col">Sr.</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Status</th>
                            <th scope="col">Registration Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td><?php echo $sr++; ?></td>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $row["email"]; ?></td>
                            <td><?php echo $row["phone"]; ?></td>
                            <td><?php echo $row["status"]; ?></td>
                            <td><?php echo $row["created_at"]; ?></td>
                            <form action="" method="post">
                            <td><input type="submit" class="btn btn-sm btn-primary"  name="status_action" value="approved"></td>
                            </form>
                            <?php }?>
                        </tr>
                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Recent Sales End -->



    <?php
include("include/footer.php");
?>