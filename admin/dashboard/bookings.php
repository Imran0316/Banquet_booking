<?php

include("../../db.php");
include("include/header.php");
// include("include/spinner.php");

include("include/sidebar.php");



$stmt = $pdo->query("SELECT bookings.*, users.name AS user_name, banquets.name AS banquet_name
FROM bookings
JOIN users ON bookings.user_id = users.id
JOIN banquets ON bookings.banquet_id = banquets.id
");



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

                            <th scope="col">Sr.</th>
                            <th scope="col">User Name</th>
                            <th scope="col">Banquet</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                            <th scope="col">Status</th>
                            <th scope="col">Booking Time</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <tr>

                                <td><?php echo $sr++; ?></td>
                                <td><?php echo $row["user_name"]; ?></td>
                                <td><?php echo $row["banquet_name"]; ?></td>
                                <td><?php echo $row["date"]; ?></td>
                                <td><?php echo $row["time_slot"]; ?></td>
                                <td><?php echo $row["status"]; ?></td>
                                <td><?php echo $row["created_at"]; ?></td>
                                <td><a href="booking_details.php?id=<?php echo $row["id"]; ?>">Details</a></td>
                                

                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Banquet owner details -->



    <?php
    include("include/footer.php");
    ?>