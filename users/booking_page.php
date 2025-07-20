<?php 
session_start();
include("../db.php");
include("../includes/header.php");
$banquet_id = $_GET["id"];
// $user_id = $_SESSION['id'];
$page = "inner";
?>



<style>
    .navbar{
        background-color: red !important;
    }
body {
    background-color: #f8f9fa;
    font-family: 'Segoe UI', sans-serif;
}

.container-wrapper {
    max-width: 1200px;
    /* margin: 40px auto; */
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
    padding-top: 100px !important;
    align-items: center;
    justify-content: center;
}

.banquet-details {
    flex: 1 1 60%;
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
}

.booking-widget {
    flex: 1 1 35%;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    position: sticky;
    top: 20px;
}

.price-box {
    font-size: 22px;
    font-weight: bold;
    color: #28a745;
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
}

#timeSlot option:disabled {
    color: red;
    font-style: italic;
}


</style>

<!-- Content Start -->
<div class="content">
    <?php
include("../includes/navbar.php");

?>

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
    <div class="container-wrapper">
        
        <!-- Left: Banquet Details -->
        <div class="banquet-details">
            <img src="uploads/banquet.jpg" alt="Banquet" class="img-fluid rounded mb-4">

            <h3 class="mb-1">🌟 Royal Galaxy Banquet</h3>
            <p class="text-muted mb-2">📍 Bahadurabad, Karachi</p>
            <div class="mb-3">
                <span class="badge rounded-pill badge-tag">Wedding</span>
                <span class="badge rounded-pill badge-tag">Corporate</span>
                <span class="badge rounded-pill badge-tag">Birthday</span>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <strong>👥 Capacity:</strong> 400 Guests
                </div>
                <div class="col-md-4">
                    <strong>📏 Area:</strong> 7000 sqft
                </div>
                <div class="col-md-4">
                    <strong>⌛ Min Time:</strong> 2 hours
                </div>
            </div>

            <h5>📋 Description</h5>
            <p>
                This luxurious banquet is perfect for weddings, birthdays, and corporate events. With elegant decor,
                spacious halls, and premium service, it makes your event unforgettable.
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
        <div class="booking-widget">
            <div class="price-box mb-3">PKR 75,000 <small class="text-muted">/ per event</small></div>

            <form action="submit_booking.php?id=<?php echo $banquet_id ?>" method="POST">
                <label class="form-label">Event Date</label>
                 <input type="text" name="event_date" id="myDatePicker" class="form-control" placeholder="Select date">

                <input type="hidden" name="banquetID" value="<?php echo $banquet_id ?>" class="form-control">

                <input type="hidden" name="userID" value="<?php echo $user_id ?>" class="form-control">

                <label class="form-label">Time Slot</label>
                <select name="time_slot"  id="timeSlot" class="form-select" required>
                    <option value="">-- Select Time --</option>
                    <option value="Morning (10 AM - 2 PM)">Morning (10 AM - 2 PM)</option>
                    <option value="Evening (7 PM - 11 PM)">Evening (7 PM - 11 PM)</option>
                </select>

                <label class="form-label">Number of Guests</label>
                <input type="number" name="guests" class="form-control" min="50" required>

                <label class="form-label">Event Type</label>
                <select name="event_type" class="form-select" required>
                    <option value="">-- Select Event --</option>
                    <option>Wedding</option>
                    <option>Birthday</option>
                    <option>Corporate</option>
                    <option>Other</option>
                </select>

                <button class="btn btn-success w-100 mt-4" name="submit_booking" type="submit">📨 Confirm
                    Booking</button>
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
                        const originalText = $(this).data("original-text");
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
