<?php
session_start();
include("../../db.php");
include("include/header.php");
// include("include/spinner.php");
include("include/sidebar.php");

$stmt=$pdo->query("SELECT banquets.*,
banquet_owner.name AS owner_name
FROM banquets
JOIN banquet_owner ON banquets.owner_id = banquet_owner.id
");

$sr = 1;
?>

<!-- Content Start -->
<div class="content">
    <?php
include("include/navbar.php");
?>


  <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Banquets</h6>
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
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                           
                            <th scope="col">Sr.</th>
                            <th scope="col">Banquet Name</th>
                            <th scope="col">Owner Name</th>
                            <th scope="col">Location</th>
                            <th scope="col">Status</th>
                            <th scope="col">Registration Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            ?>
                        <tr>
                          
                            <td><?php echo $sr++; ?></td>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $row["owner_name"]; ?></td>
                            <td><?php echo $row["location"]; ?></td>
                            <td><?php echo $row["status"]; ?></td>
                            <td><?php echo $row["created_at"]; ?></td>
                            <td> <a href="banquet_details.php?id=<?php echo $row["id"]; ?>" class="btn btn-outline-primary">Details</a>
                            <a href="delete_banquet.php?id=<?php echo $row["id"]; ?>" ><i class="fa-solid fa-trash-can ms-3"></i></a>
                        </td>
                        </tr>
                        <?php }?>
                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<?php
include("include/footer.php");

?>