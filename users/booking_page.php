<?php
session_start();
include("../db.php");
include("include/header.php");
$banquet_id = $_GET["id"];
// $user_id = $_SESSION['id'];
$page = "inner";
// if(!isset($user_id) || empty($user_id)) {
//     header("Location: login.php");
//     exit();

// }
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

/* Simple Calendar Styles - No Card */
#simpleCalendar {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    height: 450px;
    /* Increased height to accommodate time scale */
    overflow-y: auto;
    /* Allow scrolling if needed */
}

.calendar-header {
    background: none;
    color: #333;
    padding: 8px 0;
    text-align: center;
    border-bottom: 1px solid #e9ecef;
    margin-bottom: 8px;
}

.calendar-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.calendar-nav button {
    background: none;
    border: none;
    color: #666;
    font-size: 16px;
    cursor: pointer;
    padding: 5px 8px;
    border-radius: 4px;
    transition: background 0.2s;
}

.calendar-nav button:hover {
    background: #e9ecef;
}

.calendar-title {
    font-size: 16px;
    font-weight: 600;
    color: #333;
}

.calendar-body {
    padding: 15px;
    padding-bottom: 140px;
    /* Increased space for time scale section */
    position: relative;
}

.calendar-weekdays {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 2px;
    margin-bottom: 8px;
}

.weekday {
    text-align: center;
    font-size: 11px;
    font-weight: 500;
    color: #666;
    padding: 4px;
}

.calendar-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 1px;
}

.calendar-day {
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    border-radius: 4px;
    position: relative;
    transition: all 0.2s;
    font-size: 13px;
    font-weight: 400;
    color: #333;
    border: 1px solid transparent;
}

.calendar-day:hover {
    background: #f8f9fa;
}

.calendar-day.selected {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

.calendar-day.disabled {
    color: #ccc;
    cursor: not-allowed;
    opacity: 0.6;
}

.calendar-day.other-month {
    color: #ddd;
}

.calendar-day.booked {
    background: white;
    border: 1px solid #ddd;
    position: relative;
}

.calendar-day.partially-booked {
    background: white;
    border: 1px solid #ddd;
    position: relative;
}

/* Progress Bar Styles */
.progress-bar {
    position: absolute;
    bottom: 2px;
    left: 2px;
    right: 2px;
    height: 3px;
    background: #e9ecef;
    border-radius: 1px;
}

.progress-fill {
    height: 100%;
    border-radius: 1px;
    transition: width 0.3s ease;
}

.progress-fill.partial {
    background: #6c757d;
    width: 50%;
}

.progress-fill.full {
    background: #dc3545;
    width: 100%;
}

/* Time Scale Section */
.time-scale-section {
    margin-top: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 6px;
    border: 1px solid #e9ecef;
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 10;
    max-height: 120px;
    overflow-y: auto;
}

.time-scale-header {
    font-size: 14px;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
}

.time-scale {
    position: relative;
    height: 40px;
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 8px 0;
    margin-bottom: 10px;
}

.time-scale-container {
    position: relative;
    height: 100%;
    display: flex;
    align-items: center;

}

.time-scale-line {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #dee2e6;
    transform: translateY(-50%);
}

.hour-markers {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 100%;
    display: flex;
    justify-content: space-between;
}

.hour-marker {
    position: relative;
    width: 1px;
    height: 100%;
}

.hour-marker::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 1px;
    height: 6px;
    background: #adb5bd;
}

.hour-marker::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 1px;
    height: 6px;
    background: #adb5bd;
}

.hour-label {
    position: absolute;
    top: 8px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 9px;
    font-weight: 500;
    color: #495057;
}

.am-pm-label {
    position: absolute;
    bottom: 14px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 7px;
    color: rgb(255, 0, 0);
    font-weight: 400;
}

.booked-slot {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    height: 4px;
    background: #6c757d;
    border-radius: 2px;
    z-index: 1;
    opacity: 0.7;
}

.booked-slot.morning {
    left: 41.67%;
    /* 10 AM position */
    width: 16.67%;
    /* 4 hours (10 AM - 2 PM) */
    background: #ffc107;
}

.booked-slot.evening {
    left: 79.17%;
    /* 7 PM position */
    width: 16.67%;
    /* 4 hours (7 PM - 11 PM) */
    background: #dc3545;
}

.time-scale-legend {
    font-size: 11px;
    color: #6c757d;
    display: flex;
    align-items: center;
    gap: 8px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 4px;
}

.legend-color {
    width: 10px;
    height: 3px;
    border-radius: 1px;
}

.legend-color.booked {
    background: #6c757d;
}

.legend-color.morning {
    background: #ffc107;
}

.legend-color.evening {
    background: #dc3545;
}

@media (max-width: 767px) {
    .main-gallery-image {
        height: 300px !important;
    }

    .giggster-calendar {
        max-width: 100%;
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
                    <p>"Lovely space! Everything was clean and perfect."</p>
                    <footer class="blockquote-footer">Geoff R.</footer>
                </blockquote>
            </div>

            <div class="mb-3">
                <blockquote class="blockquote">
                    <p>"Highly recommend this venue for weddings!"</p>
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

            <form action="checkout.php" method="GET">
                <label class="form-label">Event Date</label>

                <input type="hidden" name="banquetID" value="<?php echo $banquet_id ?>" class="form-control">

                <!-- <input type="hidden" name="userID" value="<?php echo $user_id ?>" class="form-control"> -->
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

    <!-- Simple Calendar - No Modal, No Card -->
    <div id="simpleCalendar"
        style="display: none; position: absolute; top: 100%; left: 0; z-index: 1000; background: white; border: 1px solid #ddd; border-radius: 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 10px; min-width: 280px;">
        <div class="calendar-header">
            <div class="calendar-nav">
                <button type="button" id="prevMonth">&lt;</button>
                <div class="calendar-title" id="currentMonth">August 2025</div>
                <button type="button" id="nextMonth">&gt;</button>
            </div>
        </div>
        <div class="calendar-body">
            <div class="calendar-weekdays">
                <div class="weekday">Su</div>
                <div class="weekday">Mo</div>
                <div class="weekday">Tu</div>
                <div class="weekday">We</div>
                <div class="weekday">Th</div>
                <div class="weekday">Fr</div>
                <div class="weekday">Sa</div>
            </div>
            <div class="calendar-days" id="calendarDays">
                <!-- Days will be populated by JavaScript -->
            </div>
        </div>

        <!-- Time Scale Section -->
        <div class="time-scale-section" id="timeScaleSection" style="display: none;"
            onmouseenter="keepTimeScaleVisible()" onmouseleave="hideTimeScale()">
            <div class="time-scale-header">Time Availability for <span id="selectedDateText"></span></div>
            <div class="time-scale">
                <div class="time-scale-container">
                    <div class="time-scale-line"></div>
                    <div class="hour-markers" id="hourMarkers">
                        <!-- Hour markers will be populated by JavaScript -->
                    </div>
                    <div id="bookedSlots">
                        <!-- Booked slots will be populated by JavaScript -->
                    </div>
                </div>
            </div>
            <!-- <div class="time-scale-legend">
                <div class="legend-item">
                    <div class="legend-color booked"></div>
                    <span>Booked or unavailable</span>
                </div>
            </div> -->
        </div>
    </div>

    <?php
    include("../includes/footer.php");
    ?>

    <script>
    // Global variables for calendar
    let currentDate = new Date();
    let selectedDate = null;
    let bookingData = null;

    // ---------- DATE HELPERS (fixed to avoid timezone shift) ----------
    // Parse YYYY-MM-DD reliably into a local Date (avoids timezone shift).
    function parseYMD(dateStr) {
        if (!dateStr || typeof dateStr !== 'string') return new Date(dateStr);
        const parts = dateStr.split('-').map(Number);
        if (parts.length !== 3) return new Date(dateStr);
        // new Date(year, monthIndex, day) constructs a local-date midnight
        return new Date(parts[0], parts[1] - 1, parts[2]);
    }

    // Format a Date object into local YYYY-MM-DD (no timezone conversion).
    function formatDate(date) {
        const y = date.getFullYear();
        const m = String(date.getMonth() + 1).padStart(2, '0');
        const d = String(date.getDate()).padStart(2, '0');
        return `${y}-${m}-${d}`;
    }

    // Compare two dates by local Y-M-D (robust).
    function isSameDay(date1, date2) {
        if (!date1 || !date2) return false;
        return formatDate(date1) === formatDate(date2);
    }
    // ------------------------------------------------------------------

    // Initialize calendar when page loads
    $(document).ready(function() {
        // Load booking data
        loadBookingData();

        // Initialize custom calendar first
        initializeCustomCalendar();

        // Add click handler to date input to show simple calendar
        $('#myDatePicker').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // Position calendar above the input to avoid scrolling
            const input = $(this);
            const inputOffset = input.offset();
            const inputHeight = input.outerHeight();
            const calendarHeight = 300; // Approximate calendar height

            $('#simpleCalendar').css({
                'position': 'absolute',
                'top': inputOffset.top - 450 - 10, // Above the input with new height
                'left': inputOffset.left,
                'display': 'block'
            });
        });

        // Close calendar when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#simpleCalendar, #myDatePicker').length) {
                $('#simpleCalendar').hide();
            }
        });

        // Initialize flatpickr but disable it initially
        initializeFlatpickr();

        // Disable flatpickr to prevent conflicts
        if (window.flatpickrInstance) {
            window.flatpickrInstance.close();
        }
    });

    function loadBookingData() {
        $.getJSON("get_booked_dates.php?id=<?php echo $banquet_id ?>", function(data) {
            bookingData = data;
            renderCalendar();
        });
    }

    function initializeCustomCalendar() {
        // Month navigation
        $('#prevMonth').on('click', function() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        $('#nextMonth').on('click', function() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });
    }

    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        // Update month title
        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        $('#currentMonth').text(monthNames[month] + ' ' + year);

        // Get first day of month and number of days
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const startDate = new Date(firstDay);
        startDate.setDate(startDate.getDate() - firstDay.getDay());

        let calendarHTML = '';

        // Generate 6 weeks of days
        for (let week = 0; week < 6; week++) {
            for (let day = 0; day < 7; day++) {
                const currentDay = new Date(startDate);
                currentDay.setDate(startDate.getDate() + (week * 7) + day);

                const isCurrentMonth = currentDay.getMonth() === month;
                const isToday = isSameDay(currentDay, new Date());
                const isSelected = selectedDate && isSameDay(currentDay, selectedDate);

                // Check booking status
                const dateStr = formatDate(currentDay);
                const bookingStatus = getBookingStatus(dateStr);

                // Check if date is in the past
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                const isPastDate = currentDay < today;

                let dayClass = 'calendar-day';
                if (!isCurrentMonth) dayClass += ' other-month';
                if (isToday) dayClass += ' today';
                if (isSelected) dayClass += ' selected';

                // Disable past dates
                if (isPastDate) {
                    dayClass += ' disabled';
                } else if (bookingStatus === 'fully-booked') {
                    dayClass += ' booked disabled';
                } else if (bookingStatus === 'partially-booked') {
                    dayClass += ' partially-booked';
                }

                // Add progress bar for booked dates
                let progressBar = '';
                if (bookingStatus !== 'available') {
                    const progressClass = bookingStatus === 'fully-booked' ? 'full' : 'partial';
                    progressBar = `
                        <div class="progress-bar">
                            <div class="progress-fill ${progressClass}"></div>
                        </div>
                    `;
                }

                // Only allow click if not past date and not fully booked
                const clickHandler = (isPastDate || bookingStatus === 'fully-booked') ? '' :
                    `onclick="selectDate('${dateStr}')"`;
                const hoverHandler = (isPastDate || bookingStatus === 'fully-booked') ? '' :
                    `onmouseenter="showTimeScaleOnHover('${dateStr}')" onmouseleave="hideTimeScale()"`;

                calendarHTML += `
                    <div class="${dayClass}" data-date="${dateStr}" ${clickHandler} ${hoverHandler}>
                        ${currentDay.getDate()}
                        ${progressBar}
                    </div>
                `;
            }
        }

        $('#calendarDays').html(calendarHTML);
    }

    function showTimeScale(dateStr) {
        // parse date string reliably to local Date
        const date = parseYMD(dateStr);
        const formattedDate = date.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        // Update selected date text
        $('#selectedDateText').text(formattedDate);

        // Generate 24-hour timeline
        let hourMarkers = '';
        for (let i = 0; i <= 24; i++) {
            const hour = i === 0 ? 12 : (i > 12 ? i - 12 : i);
            const ampm = i === 0 ? 'am' : (i === 12 ? 'pm' : (i > 12 ? 'pm' : 'am'));
            const isFirstAM = i === 0;
            const isPM = i === 12;
            const isLastAM = i === 24;

            hourMarkers += `
                <div class="hour-marker">
                    <div class="hour-label">${hour}</div>
                    ${(isFirstAM || isPM || isLastAM) ? `<div class="am-pm-label">${ampm}</div>` : ''}
                </div>
            `;
        }

        $('#hourMarkers').html(hourMarkers);

        // Get booking status and show booked slots
        const bookingStatus = getBookingStatus(dateStr);
        let bookedSlotsHTML = '';

        if (bookingStatus !== 'available') {
            const bookedSlots = bookingData.detailedBookings[dateStr] || [];
            const hasMorning = bookedSlots.includes("Morning (10 AM - 2 PM)");
            const hasEvening = bookedSlots.includes("Evening (7 PM - 11 PM)");

            if (hasMorning) {
                bookedSlotsHTML += '<div class="booked-slot morning"></div>';
            }
            if (hasEvening) {
                bookedSlotsHTML += '<div class="booked-slot evening"></div>';
            }
        }

        $('#bookedSlots').html(bookedSlotsHTML);

        // Show the time scale section
        $('#timeScaleSection').show();
    }

    // Hover functions for time scale
    function showTimeScaleOnHover(dateStr) {
        // delegate to same reliable routine (parsing inside)
        showTimeScale(dateStr);
    }

    function hideTimeScale() {
        // Hide time scale after a small delay to allow moving mouse to time scale
        setTimeout(function() {
            if (!$('#timeScaleSection:hover').length && !$('.calendar-day:hover').length) {
                $('#timeScaleSection').hide();
            }
        }, 100);
    }

    function keepTimeScaleVisible() {
        // Keep time scale visible when hovering over it
        $('#timeScaleSection').show();
    }

    function selectDate(dateStr) {
        // parse date string reliably to local Date
        selectedDate = parseYMD(dateStr);

        // Update the date input (use the same YYYY-MM-DD string)
        $('#myDatePicker').val(dateStr);

        // Update flatpickr instance if it exists
        if (window.flatpickrInstance) {
            window.flatpickrInstance.setDate(dateStr);
        }

        // Show time scale section
        showTimeScale(dateStr);

        // Close the calendar
        $('#simpleCalendar').hide();

        // Trigger time slot update
        updateTimeSlots(dateStr);
    }

    function getBookingStatus(dateStr) {
        if (!bookingData) return 'available';

        if (bookingData.fullyBooked.includes(dateStr)) {
            return 'fully-booked';
        } else if (bookingData.partiallyBooked.includes(dateStr)) {
            return 'partially-booked';
        }

        return 'available';
    }

    // NOTE: formatDate / isSameDay replaced above — any other code that relied on
    // toISOString().slice behaviour will now use the local-safe formatDate.

    function updateTimeSlots(selectedDate) {
        $.getJSON("get_booked_slots.php", {
            date: selectedDate
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
                const $option = $("#timeSlot option[value='" + slotValue + "']");
                if ($option.length) {
                    if (!$option.data("original-text")) {
                        $option.data("original-text", $option.text());
                    }
                    $option.text($option.text() + " (Booked)");
                    $option.prop("disabled", true);
                }
            });

            $("#timeSlot").val("");
        });
    }

    // Original flatpickr initialization for backward compatibility
    function initializeFlatpickr() {
        $.getJSON("get_booked_dates.php?id=<?php echo $banquet_id ?>", function(data) {
            const fullyBooked = data.fullyBooked;
            const partiallyBooked = data.partiallyBooked;

            // Store flatpickr instance globally
            window.flatpickrInstance = flatpickr("#myDatePicker", {
                minDate: "today",
                maxDate: new Date().fp_incr(365),
                dateFormat: "Y-m-d",
                disable: fullyBooked,
                allowInput: false, // Disable direct input
                clickOpens: false, // Disable click to open
                onDayCreate: function(dObj, dStr, fp, dayElem) {
                    const date = dayElem.dateObj;
                    const ymd = fp.formatDate(dayElem.dateObj, "Y-m-d");
                    if (fullyBooked.includes(ymd)) {
                        dayElem.classList.add("fully-booked");
                    } else if (partiallyBooked.includes(ymd)) {
                        dayElem.classList.add("partially-booked");
                    }
                },
                onChange: function(selectedDates, dateStr) {
                    updateTimeSlots(dateStr);
                }
            });
        });
    }
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
        background: #ffeaea;
        color: #b71c1c;
    }

    .calendar-day.today {
        background: #e3f2fd;
        color: #1976d2;
        font-weight: bold;
    }

    .calendar-day.selected {
        background: #667eea !important;
        color: white !important;
    }
    </style>