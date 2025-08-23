<?php
session_start();
include("../../db.php");
include("include/header.php");
include("include/sidebar.php");

// Fetch booking details from the database
if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    $query = "SELECT b.*, 
                     u.name AS user_name, u.phone AS user_phone, 
                     bn.name AS banquet_name, bn.price, bn.description
              FROM bookings b
              JOIN users u ON b.user_id = u.id
              JOIN banquets bn ON b.banquet_id = bn.id
              WHERE b.id = :booking_id";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $_SESSION['error'] = "Booking not found.";
        header("Location: bookings.php");
        exit();
    }
    $stmt2 = $pdo->prepare("SELECT * FROM payments WHERE booking_id = ?");
    $stmt2->execute([$booking_id]);
    $paymnets = $stmt2->fetch(PDO::FETCH_ASSOC);
} else {
    $_SESSION['error'] = "No booking ID provided.";

}
?>

<!-- Content Start -->
<div class="content">
    <?php include("include/navbar.php"); ?>

    <style>
        .table th {
            color: black !important;
        }

        .cover-img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .gallery-thumb {
            height: 100px;
            width: 100%;
            max-width: 120px;
            object-fit: cover;
            border-radius: 8px;
            transition: 0.3s;
            cursor: pointer;
            box-shadow: 0 2px 8px #DAA52022;
            border: 2px solid #fffbe6;
        }

        .gallery-thumb:hover {
            transform: scale(1.07);
            border-color: #DAA520;
        }

        @media (max-width: 575px) {
            .gallery-thumb {
                height: 70px;
                max-width: 90px;
            }

            .table th,
            .table td {
                font-size: 13px;
                padding: 6px 4px;
            }
        }

        /* Modal image always same size and centered */
        .gallery-modal-img {
            width: 100%;
            max-width: 700px;
            height: 400px;
            object-fit: contain;
            margin: auto;
            display: block;
            background: #fffbe6;
            border-radius: 12px;
        }

        @media (max-width: 767px) {
            .gallery-modal-img {
                height: 220px;
                max-width: 98vw;
            }
        }
    </style>

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Booking Details</h6>
                <a href="bookings.php">Show All</a>
            </div>

            <?php
            if (isset($_SESSION['error'])) {
                echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
                unset($_SESSION['success']);
            }
            ?>


            <!-- Banquet Info Table -->
            <div class="table-responsive mb-3">
                <table class="table text-start align-middle border table-hover">
                    <tr>
                        <th>Banquet Name:</th>
                        <td><?php echo $booking["banquet_name"]; ?></td>
                        <th>Customer Name:</th>
                        <td><?php echo $booking["user_name"]; ?></td>
                        <th>Phone:</th>
                        <td><?php echo $booking["user_phone"]; ?></td>
                    </tr>
                    <tr>
                        <th>Booking Date:</th>
                        <td><?php echo $booking["date"]; ?></td>
                        <th>Booking Time:</th>
                        <td><?php echo $booking["time_slot"]; ?></td>
                        <th>Address:</th>
                        <td><?php echo $booking["address"]; ?></td>
                    </tr>
                    <tr>
                        <th>Notes:</th>
                        <td><?php echo $booking["notes"]; ?></td>
                        <th>Price:</th>
                        <td><?php echo $booking["price"]; ?></td>
                        <th>Status:</th>
                        <td><?php echo $booking["status"]; ?></td>
                    </tr>
                    <tr>
                        <th>Payment_option:</th>
                        <td><?php echo $paymnets["payment_option"]; ?></td>
                        <th>paid:</th>
                        <td><?php echo $paymnets["amount"]; ?></td>
                        <th>Payment Status:</th>
                        <td><?php echo $paymnets["status"]; ?></td>

                    </tr>
                    <tr>
                        <th>Transaction Id:</th>
                        <td><?php echo $paymnets["transaction_ref"]; ?>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Description Table -->
            <div class="table-responsive mb-3">
                <table class="table text-start align-middle border table-hover">
                    <tr>
                        <th>Description:</th>
                        <td><?php echo $booking["description"]; ?></td>
                    </tr>
                </table>
            </div>

          
            <!-- Action Button -->
            <!-- <button class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#actionModal">Action</button> -->

            <!-- Action Modal -->
            <!-- <div class="modal fade" id="actionModal" tabindex="-1">
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
            </div> -->

        </div>
    </div>
</div>

<?php include("include/footer.php"); ?>