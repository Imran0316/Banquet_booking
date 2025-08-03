<?php
session_start();
include("../db.php");
include("include/header.php");
$banquet_id = $_GET["id"];
$user_id = $_SESSION['id'];
$page = "inner";
if(!isset($user_id) || empty($user_id)) {
    header("Location: login.php");
    exit();

}
$stmt = $pdo->prepare("SELECT * FROM `banquets` WHERE id = ?");
$stmt->execute([$banquet_id]);
$banquet_data = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt2 = $pdo->prepare("SELECT * FROM `banquet_images` WHERE banquet_id = ? Limit 3");
$stmt2->execute([$banquet_id]);
$galleries = $stmt2->fetchAll(PDO::FETCH_ASSOC);


?>



<style>
body {
    background-color: #f8f9fa;
    font-family: 'Segoe UI', sans-serif;
}

.booking_det {
    display: flex !important;
    align-items: center;
    justify-content: center;
}


.booking-widget {
    background: #fff;
    padding: 25px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    position: sticky;
    top: 20px;
}

.price-box {
    font-size: 22px;
    font-weight: bold;
    color: #000000ff;
}

.form-label {
    font-weight: 500;
    margin-top: 15px;
}

.badge-tag {
    background-color: #e9ecef;
    color: #333;
    margin-right: 6px;
}

.section-divider {
    border-top: 1px solid #ddd;
    margin: 25px 0;
    width: 90%;
}

#timeSlot option:disabled {
    color: red;
    font-style: italic;
}

/* General form styling */
form {
    padding: 20px;
}

/* Input and select styles */
form input.form-control,
form select.form-select {
    border: none;
    border-bottom: 2px solid #ccc;
    border-radius: 0;
    box-shadow: none;
    padding: 8px 4px;
    font-size: 15px;
    background: transparent;
    transition: border-color 0.3s ease;
}

form input.form-control:focus,
form select.form-select:focus {
    border-bottom: 2px solid #28a745;
    outline: none;
    box-shadow: none;
}

/* Label styling */
form .form-label {
    font-weight: 600;
    margin-top: 20px;
    font-size: 14px;
    color: #555;
}

/* Button styling */
form button[type="submit"] {
    padding: 10px;
    font-size: 16px;
    border-radius: 6px;
}


@media (max-width: 767px) {
    .main-gallery-image {
        height: 300px !important;
    }
}
</style>

<!-- Content Start -->
<div class="content">
    <?php
    include("include/navbar.php");

    ?>
    <div class="container my-4">
        <div class="row">
            <!-- Main Image -->
            <div class="col-lg-8 col-12 mb-3 mb-lg-0 ">
                <img id="mainImage" src="../uploads<?php echo $banquet_data["image"] ?>"
                    class="img-fluid w-100 rounded main-gallery-image" style="height: 530px; object-fit: cover;"
                    alt="Main Image">
            </div>

            <!-- Thumbnails -->
            <div class="col-lg-4 col-12">
                <div class="d-none d-lg-flex flex-column gap-3 h-100">
                    <?php
                    foreach ($galleries as $gallery) {
                    ?>
                    <img src="../uploads/<?php echo $gallery["image"];?>" class="img-fluid rounded thumb-img"
                        style="height: calc(500px / 3); object-fit: cover; cursor: pointer;"
                        onclick="changeImage(this)">
                    <?php }?>
                </div>

                <!-- Mobile Thumbnails -->
                <div class="d-flex d-lg-none gap-2 mt-3">
                    <?php 
                    foreach ($galleries as $gallery) {
                    ?>
                    <img src="../uploads/<?php echo $gallery["image"]; ?>" class="img-fluid rounded thumb-img"
                        style="height: 80px; width: 30%; object-fit: cover; cursor: pointer;"
                        onclick="changeImage(this)">
                    <?php }?>
                </div>
            </div>
        </div>
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
    <div class="booking_det container mt-5">

        <!-- Left: Banquet Details -->
        <div class="banquet-details col-lg-8 col-12">

            <h3 class="mb-1"><?php echo $banquet_data["name"] ; ?> | Banquet</h3>
            <p class="text-muted mb-2"><i class="fa-solid fa-location-dot"></i>
                <?php echo $banquet_data["location"];  ?></p>
            <div class="mb-3">
                <span class="badge rounded-pill badge-tag">Wedding</span>
                <span class="badge rounded-pill badge-tag">Corporate</span>
                <span class="badge rounded-pill badge-tag">Birthday</span>
            </div>


            <div class="section-divider "></div>
            <div class="row  text-center my-4">
                <div class="col-md-4">
                    <div>
                        <div class="icon mb-2"><i class="bi bi-clock" style="font-size: 24px;"></i></div>
                        <small class="text-muted">booking Slots</small><br>
                        <strong>Morning/Evening</strong>
                    </div>
                </div>
                <div class="col-md-4">
                    <div>
                        <div class="icon mb-2"><i class="bi bi-people" style="font-size: 24px;"></i></div>
                        <small class="text-muted">Guest Capacity</small><br>
                        <strong><?php echo $banquet_data["capacity"]; ?></strong>
                    </div>
                </div>
                <div class="col-md-4">
                    <div>
                        <div class="icon mb-2"><i class="bi bi-aspect-ratio" style="font-size: 24px;"></i></div>
                        <small class="text-muted">Square footage</small><br>
                        <strong>700 sq/ft</strong>
                    </div>
                </div>
            </div>

            <div class="section-divider "></div>
            <h5>About</h5>
            <p>
                <?php echo $banquet_data["description"]; ?>
            </p>

            <div class="section-divider"></div>

            <h5>💬 Reviews</h5>
            <div class="mb-3">
                <blockquote class="blockquote">
                    <p>“Lovely space! Everything was clean and perfect.”</p>
                    <footer class="blockquote-footer">Geoff R.</footer>
                </blockquote>
            </div>

            <div class="mb-3">
                <blockquote class="blockquote">
                    <p>“Highly recommend this venue for weddings!”</p>
                    <footer class="blockquote-footer">John M.</footer>
                </blockquote>
            </div>


        </div>

        <!-- Right: Booking Widget -->
        <div class="booking-widget col-lg-4 d-none d-lg-block border border-1 rounded ">
            <div>
                <h4 class="text-center" style="color: maroon;">Booking Details</h4>
                <div class="text-center price-box">
                    <span class="text-muted">Starting from</span>
                    <span class="" style="color: goldenrod;"><?php echo $banquet_data["price"]; ?>pkr</span>
                </div>
            </div>

            <form action="checkout.php?id=<?php echo $banquet_id ?>" method="GET">
                <label class="form-label">Event Date</label>

                <input type="hidden" name="banquetID" value="<?php echo $banquet_id ?>" class="form-control">

                <input type="hidden" name="userID" value="<?php echo $user_id ?>" class="form-control">
                <input type="text" name="event_date" id="myDatePicker" class="form-control" placeholder="Select date">

                <label class="form-label">Time Slot</label>
                <select name="time_slot" id="timeSlot" class="form-select" required>
                    <option value="">-- Select Time --</option>
                    <option value="Morning (10 AM - 2 PM)">Morning (10 AM - 2 PM)</option>
                    <option value="Evening (7 PM - 11 PM)">Evening (7 PM - 11 PM)</option>
                </select>

                <button class="btn  w-100 mt-4" name="booking_detail" type="submit"
                    style="background-color: maroon; color: white;">Book Now!</button>
            </form>
        </div>

    </div>

    <?php
    include("../includes/footer.php");
    ?>

    <script>
    $(document).ready(function() {
        $.getJSON("get_booked_dates.php?id=<?php echo $banquet_id ?>", function(data) {
            const fullyBooked = data.fullyBooked;
            const partiallyBooked = data.partiallyBooked;

            flatpickr("#myDatePicker", {
                minDate: "today",
                maxDate: new Date().fp_incr(365), // Allow booking up to
                dateFormat: "Y-m-d",
                disable: fullyBooked,
                onDayCreate: function(dObj, dStr, fp, dayElem) {
                    const date = dayElem.dateObj;
                    // const ymd = date.toISOString().slice(0, 10);
                    const ymd = fp.formatDate(dayElem.dateObj, "Y-m-d");
                    if (fullyBooked.includes(ymd)) {
                        dayElem.classList.add("fully-booked");
                    } else if (partiallyBooked.includes(ymd)) {
                        dayElem.classList.add("partially-booked");
                    }
                },
                onChange: function(selectedDates, dateStr) {
                    $.getJSON("get_booked_slots.php", {
                        date: dateStr
                    }, function(bookedSlots) {
                        const slotMap = {
                            "Morning (10 AM - 2 PM)": "Morning (10 AM - 2 PM)",
                            "Evening (7 PM - 11 PM)": "Evening (7 PM - 11 PM)"
                        };

                        $("#timeSlot option").each(function() {
                            const originalText = $(this).data(
                                "original-text");
                            if (originalText) {
                                $(this).text(originalText);
                            }
                            $(this).prop("disabled", false);
                        });

                        bookedSlots.forEach(function(slotLabel) {
                            const slotValue = slotMap[slotLabel];
                            const $option = $("#timeSlot option[value='" +
                                slotValue + "']");
                            if ($option.length) {
                                if (!$option.data("original-text")) {
                                    $option.data("original-text", $option
                                        .text());
                                }
                                $option.text($option.text() + " (Booked)");
                                $option.prop("disabled", true);
                            }
                        });

                        $("#timeSlot").val("");
                    });
                }
            });
        });
    });
    </script>


    <script>
    function changeImage(thumb) {
        document.getElementById("mainImage").src = thumb.src;
    }
    </script>

    <style>
    .flatpickr-day.partially-booked {
        border-bottom: 2px solid #ff9800 !important;
        background: #fffbe6;
    }

    .flatpickr-day.fully-booked {
        border-bottom: 2px solid #e53935 !important;
        /* Red underline */
        background: #ffeaea;
        color: #b71c1c;
    }
    </style>