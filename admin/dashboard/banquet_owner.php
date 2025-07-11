<?php

include("../../db.php");
include("include/header.php");
// include("include/spinner.php");

include("include/sidebar.php");



$stmt=$pdo->query("SELECT * FROM banquet_owner");
$sr = 1;
?>

<div class="content">
    <?php
    include("include/navbar.php");
    ?>

    <!-- Banquet owner details -->
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
                            <?php
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            ?>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td><?php echo $sr++; ?></td>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $row["email"]; ?></td>
                            <td><?php echo $row["phone"]; ?></td>
                            <td><?php echo $row["status"]; ?></td>
                            <td><?php echo $row["created_at"]; ?></td>
                            <td><a href="delete_owner.php?id=<?php echo $row["id"]; ?>" ><i class="fa-solid fa-trash-can ms-3"></i></a></td>
                            <form action="owner_status.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                <input type="hidden" name="current_status" value="<?php echo $row["status"]; ?>">
                                <?php 
                            if($row["status"] == "rejected"){
                            ?>
                                <td><input type="submit" class="btn btn-sm btn-primary"  name="status_action" value="approved"></td>

                            <?php }else if($row["status"] == "pending"){ ?>  
                                   <td><input type="submit" class="btn btn-sm btn-primary"  name="status_action" value="approved"></td>
                            <?php } else{?>
                            <td><input type="submit" class="btn btn-sm btn-danger"  name="status_action" value="rejected"></td>
                             <?php }?>   
                            </form>
                            
                        </tr>
                        <?php }?>
                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Banquet owner details -->



    <?php
include("include/footer.php");
?>