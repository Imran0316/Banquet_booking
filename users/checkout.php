<?php
session_start();
include("../db.php");
include("include/header.php");
$page = "inner";
include("include/navbar.php");

$date_selected = isset($_GET['event_date']) ? $_GET['event_date'] : date('Y-m-d');
$time_selected = isset($_GET['time_slot']) ? $_GET['time_slot'] : '00:00';

// Fetch banquet details from the database
$banquet_id = isset($_GET['banquetID']) ? intval($_GET['banquetID']) : 1; // Default to 1 if no ID is provided

//User Signup
if (isset($_POST['user_signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insert user into the database
    $stmt = $pdo->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$name, $email, $phone, $password])) {
        $_SESSION['id'] = $pdo->lastInsertId(); // Store user ID in session
        // header("Location: checkout.php?id=$banquet_id&event_date=$date_selected&time_slot=$time_selected");
        
    } else {
        echo "<script>alert('Error signing up. Please try again.');</script>";
    }
}


$is_logged_in = isset($_SESSION['id']) && !empty($_SESSION['id']);


$stmt = $pdo->prepare("SELECT * FROM banquets WHERE id = ?");
$stmt->execute([$banquet_id]);
$banquet = $stmt->fetch(PDO::FETCH_ASSOC);

// Calculate 30% of the total amount and store in a variable
$advance_fee = $banquet['price'] * 0.3;





?>



<style>
    * {
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    .step-header {
        padding: 15px 20px;
        font-weight: bold;
        cursor: pointer;
        user-select: none;
    }

    .step-header.disabled {
        color: #aaa;
        cursor: not-allowed;
    }

    .step-content {
        display: none;
        padding: 20px;
    }

    .step.active .step-content {
        display: block;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-size: 14px;
        color: black;
        font-weight: bold;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 10px;
        border: 1px solid #ccc;
        font-size: 14px;
        border-radius: 0px !important;

    }

    .form-group input:focus-visible {
        border-color: goldenrod;
        box-shadow: 0 0 5px rgba(218, 165, 32, 0.5);
    }

    .form-group select:focus-visible {
        border-color: goldenrod;
        box-shadow: 0 0 5px rgba(218, 165, 32, 0.5);
    }

    .form-group textarea:focus-visible {
        border-color: goldenrod;
        box-shadow: 0 0 5px rgba(218, 165, 32, 0.5);
    }

    .btn {
        padding: 10px 20px;
        background-color: goldenrod;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: darkgoldenrod;
    }

    /* Login Modal Styles */
    .modal-content {
        border-radius: 8px;
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        border-bottom: 1px solid #e9ecef;
        padding: 20px 25px 15px;
    }

    .modal-body {
        padding: 25px;
    }

    .modal-footer {
        border-top: 1px solid #e9ecef;
        padding: 15px 25px 20px;
    }

    .modal-title {
        color: #333;
        font-weight: 600;
    }

    .modal .form-control {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 10px 12px;
    }

    .modal .form-control:focus {
        border-color: goldenrod;
        box-shadow: 0 0 0 0.2rem rgba(218, 165, 32, 0.25);
    }

    .modal .btn-primary {
        background-color: goldenrod;
        border-color: goldenrod;
        padding: 10px 20px;
        font-weight: 500;
    }

    .modal .btn-primary:hover {
        background-color: darkgoldenrod;
        border-color: darkgoldenrod;
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
        bottom: 4px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 7px;
        color: #6c757d;
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

<div class="container py-5 d-flex  align-items-start justify-content-equal">
    <div class="left_section col-8 ">
        <?php if (!$is_logged_in) { ?>
            <!-- Step 1 -->
            <div class="step active " id="step1">
                <div class="step-header" onclick="toggleStep(1)"><span
                        class="border border-1  rounded-circle border-dark px-1 me-2"> 1 </span> Personal Information</div>
                <form action="" method="POST" id="projectForm " class="step-content px-5">
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <label for="address">Full Name:</label>
                            <input type="text" name="name" class="form-control" id="address" placeholder="Full Name"
                                required>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="address">Email:</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="address">Phone:</label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="e.g 03123456789"
                                required>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" name="password" id="password" name="password"
                                placeholder="" required>
                        </div>

                        <div class="col-12">
                            <input type="submit" value="Next" class="btn btn-primary" onclick="enableStep2()"
                                name="user_signup" value="
                        "> <br>
                            <small>Already have an account? <a href="#" onclick="openLoginModal()">Login</a></small>
                        </div>
                    </div>
                </form>

            </div>
            <!-- Step 2 -->
            <div class="step" id="step2">
                <div class="step-header disabled" id="step2-header" onclick="toggleStep(2)"><span
                        class="border border-1  rounded-circle border-dark px-1 me-2"> 2 </span> Event Information</div>
                <form id="projectForm " class="step-content px-5">
                    <div class="row">

                        <div class="form-group col-12 mb-3">
                            <label for="notes">Extra Notes</label>
                            <textarea name="notes" id="" placeholder="e.g light decoration" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="e.g. 123 Street, DHA, Karachi"
                                required>
                        </div>

                        <div class="col-12">
                            <button type="button" class="btn btn-primary" onclick="enableStep3()">Next</button>
                        </div>
                    </div>
                </form>

            </div>
            <!-- Step 3 -->
            <div class="step" id="step3">
                <div class="step-header disabled" id="step3-header" onclick="toggleStep(3)"><span
                        class="border border-1  rounded-circle border-dark px-1 me-2"> 2 </span> Pay for location</div>
                <form id="paymentForm" method="POST" class="step-content px-5">
                    <div class="row">
                        <!-- Pay With -->
                        <div class="form-group col-md-6 mb-3">
                            <label for="paymentMethod">Pay with:</label>
                            <select class="form-select" id="paymentMethod" required
                                onchange="handlePaymentMethod(this.value)">
                                <option value="">Select payment method</option>
                                <option value="card">Credit or Debit Card</option>
                                <option value="jazzcash">JazzCash</option>
                                <option value="easypaisa">EasyPaisa</option>
                            </select>
                        </div>

                        <!-- Card Number -->
                        <div class="form-group col-md-6 mb-3 card-fields">
                            <label for="cardNumber">Card Number:</label>
                            <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456">
                        </div>

                        <!-- Expiry -->
                        <div class="form-group col-md-6 mb-3 card-fields">
                            <label for="expiry">Expiration Date:</label>
                            <input type="date" class="form-control" id="expiry" placeholder="MM / YY">
                        </div>

                        <!-- CVC -->
                        <div class="form-group col-md-6 mb-3 card-fields">
                            <label for="cvc">Security Code:</label>
                            <input type="text" class="form-control" id="cvc" placeholder="CVC">
                        </div>

                        <!-- Country -->
                        <div class="form-group col-md-6 mb-3 card-fields">
                            <label for="country">Country:</label>
                            <select class="form-select" id="country">
                                <option value="Pakistan" selected>Pakistan</option>
                                <option value="India">India</option>
                                <option value="UAE">UAE</option>
                            </select>
                        </div>

                        <!-- Name on Card -->
                        <div class="form-group col-md-6 mb-3 card-fields">
                            <label for="nameOnCard">Name on Card:</label>
                            <input type="text" class="form-control" id="nameOnCard" placeholder="Full name">
                        </div>

                        <!-- JazzCash / EasyPaisa Fields -->
                        <div id="mobileFields" style="display: none;">
                            <div class="form-group col-md-6 mb-3 me-2">
                                <label for="payerName">Your Name:</label>
                                <input type="text" class="form-control" id="payerName" placeholder="e.g. Ali Khan">
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="payerNumber">Mobile Number:</label>
                                <input type="text" class="form-control" id="payerNumber" placeholder="e.g. 03XXXXXXXXX">
                            </div>
                        </div>

                    
                       
                    </div>
                </form>



            </div>
        <?php } else { ?>
            <!-- Step 1 -->
            <div class="step active " id="step1">
                <div class="step-header" onclick="toggleStep(1)"><span
                        class="border border-1  rounded-circle border-dark px-1 me-2"> 1 </span> Event Information</div>
                <form id="projectForm " class="step-content px-5">
                    <div class="row">

                        <div class="form-group col-12 mb-3">
                            <label for="notes">Extra Notes <span
                                    style="font-size: 12px; font-weight: 100;">(optional)</span></label>
                            <textarea name="notes" id="" placeholder="e.g light decoration" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-12 mb-3">
                            <label for="address">Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="address" placeholder="e.g. 123 Street, DHA, Karachi"
                                required>
                        </div>

                        <div class="col-12">
                            <button type="button" class="btn btn-primary" onclick="enableStep2()">Next</button>
                        </div>
                    </div>
                </form>

            </div>
            <!-- Step 2 -->
            <div class="step" id="step2">
                <div class="step-header disabled" id="step2-header" onclick="toggleStep(2)"><span
                        class="border border-1  rounded-circle border-dark px-1 me-2"> 2 </span> Pay for location</div>
                <form id="paymentForm" class="step-content px-5">
                    <div class="row">
                        <!-- Pay With -->
                        <div class="form-group col-md-6 mb-3">
                            <label for="paymentMethod">Pay with:</label>
                            <select class="form-select" id="paymentMethod" required
                                onchange="handlePaymentMethod(this.value)">
                                <option value="">Select payment method</option>
                                <option value="card">Credit or Debit Card</option>
                                <option value="jazzcash">JazzCash</option>
                                <option value="easypaisa">EasyPaisa</option>
                            </select>
                        </div>

                        <!-- Card Number -->
                        <div class="form-group col-md-6 mb-3 card-fields">
                            <label for="cardNumber">Card Number:</label>
                            <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456">
                        </div>

                        <!-- Expiry -->
                        <div class="form-group col-md-6 mb-3 card-fields">
                            <label for="expiry">Expiration Date:</label>
                            <input type="date" class="form-control" id="expiry" placeholder="MM / YY">
                        </div>

                        <!-- CVC -->
                        <div class="form-group col-md-6 mb-3 card-fields">
                            <label for="cvc">Security Code:</label>
                            <input type="text" class="form-control" id="cvc" placeholder="CVC">
                        </div>

                        <!-- Country -->
                        <div class="form-group col-md-6 mb-3 card-fields">
                            <label for="country">Country:</label>
                            <select class="form-select" id="country">
                                <option value="Pakistan" selected>Pakistan</option>
                                <option value="India">India</option>
                                <option value="UAE">UAE</option>
                            </select>
                        </div>

                        <!-- Name on Card -->
                        <div class="form-group col-md-6 mb-3 card-fields">
                            <label for="nameOnCard">Name on Card:</label>
                            <input type="text" class="form-control" id="nameOnCard" placeholder="Full name">
                        </div>

                        <!-- JazzCash / EasyPaisa Fields -->
                        <div id="mobileFields" style="display: none;">
                            <div class="form-group col-md-6 mb-3 me-2">
                                <label for="payerName">Your Name:</label>
                                <input type="text" class="form-control" id="payerName" placeholder="e.g. Ali Khan">
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="payerNumber">Mobile Number:</label>
                                <input type="text" class="form-control" id="payerNumber" placeholder="e.g. 03XXXXXXXXX">
                            </div>
                        </div>

                        
                    </div>
                </form>



            </div>
        <?php } ?>
    </div>
    <div class="right_section col-4 ">
        <div class="card shadow-sm p-4 border rounded-4">
            <div class="d-flex align-items-start mb-3">
                <img src="../assets/images/banquet7.jpg" class="rounded me-3 w-25" alt="Banquet Image">
                <div>
                    <h6 class="mb-0">Skyline Views | Multi-set Studio</h6>
                    <small class="text-muted">Fire Escape</small><br>
                    <small class="text-success">★★★★★ 140</small><br>
                    <small class="text-muted">Los Angeles, CA</small>
                </div>
            </div>

            <form>
                <div class="mb-3">
                    <label class="form-label">Select Date</label>
                    <input type="text" id="myDatePicker" value="<?php echo $date_selected ?>"
                        class="form-control border-0 border-bottom rounded-0" required>

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
                            <div class="time-scale-header">Time Availability for <span id="selectedDateText"></span>
                            </div>
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
                            <div class="time-scale-legend">
                                <div class="legend-item">
                                    <div class="legend-color booked"></div>
                                    <span>Booked or unavailable</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="form-label">Time Slot</label>
                    <select name="time_slot" id="timeSlot" class="form-select" required>
                        <option value="">-- Select Time --</option>
                        <option value="Morning (10 AM - 2 PM)">Morning (10 AM - 2 PM)</option>
                        <option value="Evening (7 PM - 11 PM)">Evening (7 PM - 11 PM)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Select Payment Option</label>
                    <div class="form-check">
                        <input class="form-check-input paymentOption" type="radio" name="payment_option" id="payAdvance"
                            value="advance">
                        <label class="form-check-label" for="payAdvance">
                            Pay Advance Only (30%)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input paymentOption" type="radio" name="payment_option" id="payFull"
                            value="full" checked>
                        <label class="form-check-label" for="payFull">
                            Pay Full Amount
                        </label>
                    </div>
                </div>
                <div class="d-flex justify-content-between fw-bold mb-3">
                    <span>Total PKR</span>
                    <span id="totalAmount"><?php echo number_format($banquet['price'], 2); ?></span>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary" id="bookNowBtn">Book Now</button>
                    <p class="mb-0 small text-muted"><a href="#">Learn more</a></p>
                </div>
            </form>
        </div>

    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login to Your Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="loginAlert" style="display: none;"></div>

                <form id="loginForm" method="POST" action="">
                    <div class="form-group mb-3">
                        <label for="login_email">Email:</label>
                        <input type="email" name="login_email" id="login_email" class="form-control"
                            placeholder="Enter your email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="login_password">Password:</label>
                        <input type="password" name="login_password" id="login_password" class="form-control"
                            placeholder="Enter your password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="user_login" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <small class="text-muted">Don't have an account? <a href="#" onclick="closeLoginModal()">Sign
                        up</a></small>
            </div>
        </div>
    </div>
</div>

<?php
include("../includes/footer.php");
?>
<script>
    function toggleStep(stepNumber) {
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step3 = document.getElementById('step3');
        const step2Header = document.getElementById('step2-header');
        const step3Header = document.getElementById('step3-header');

        if (stepNumber === 1) {
            step1.classList.add('active');
            step2.classList.remove('active');
        } else if (stepNumber === 2 && !step2Header.classList.contains('disabled')) {
            step2.classList.add('active');
            step1.classList.remove('active');
        } else if (stepNumber === 3 && !step3Header.classList.contains('disabled')) {
            step3.classList.add('active');
            step2.classList.remove('active');
        }
    }

    function enableStep2() {
        const step2Header = document.getElementById('step2-header');
        step2Header.classList.remove('disabled');
        toggleStep(2);
    }

    function enableStep3() {
        const step3Header = document.getElementById('step3-header');
        step3Header.classList.remove('disabled');
        toggleStep(3);
    }
</script>


<script>
    function handlePaymentMethod(method) {
        const cardFields = document.querySelectorAll('.card-fields');
        const mobileFields = document.getElementById('mobileFields');

        if (method === 'easypaisa' || method === 'jazzcash') {
            cardFields.forEach(field => field.style.display = 'none');
            mobileFields.style.display = 'flex';
        } else if (method === 'card') {
            cardFields.forEach(field => field.style.display = 'block');
            mobileFields.style.display = 'none';
        } else {
            // Reset
            cardFields.forEach(field => field.style.display = 'none');
            mobileFields.style.display = 'none';
        }
    }

    // By default hide card fields
    document.addEventListener('DOMContentLoaded', () => {
        handlePaymentMethod('');
    });

    // Login Modal Functions
    function openLoginModal() {
        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
    }

    function closeLoginModal() {
        const loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
        if (loginModal) {
            loginModal.hide();
        }
    }

    // AJAX Login Function
    $(document).ready(function () {
        $('#loginForm').on('submit', function (e) {
            e.preventDefault();

            const email = $('#login_email').val();
            const password = $('#login_password').val();

            $.ajax({
                url: 'ajax_login.php',
                type: 'POST',
                data: {
                    login_email: email,
                    login_password: password
                },
                success: function (response) {
                    const data = JSON.parse(response);

                    if (data.success) {
                        // Show success message
                        $('#loginAlert').html(
                            '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            data.message +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                        ).show();

                        // Close modal after 2 seconds and reload page
                        setTimeout(function () {
                            closeLoginModal();
                            window.location.reload();
                        }, 2000);
                    } else {
                        // Show error message
                        $('#loginAlert').html(
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                            data.message +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                        ).show();
                    }
                },
                error: function () {
                    $('#loginAlert').html(
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">An error occurred. Please try again.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                    ).show();
                }
            });
        });
    });
</script>
<script>
    // Global variables for calendar
    let currentDate = new Date();
    let selectedDate = null;
    let bookingData = null;

    // Initialize calendar when page loads
    $(document).ready(function () {
        // Load booking data
        loadBookingData();

        // Initialize custom calendar first
        initializeCustomCalendar();

        // Add click handler to date input to show simple calendar
        $('#myDatePicker').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            // Position calendar below input, keep inside viewport
            const input = $(this);
            const inputOffset = input.offset();
            const inputHeight = input.outerHeight();
            const calendar = $('#simpleCalendar');
            const calendarWidth = calendar.outerWidth();
            const calendarHeight = calendar.outerHeight() || 450;
            const scrollTop = $(window).scrollTop();
            const scrollLeft = $(window).scrollLeft();
            const windowWidth = $(window).width();

            let left = inputOffset.left;
            let top = inputOffset.top + inputHeight + 4;
            // If calendar overflows right, shift left
            if (left + calendarWidth > windowWidth - 10) {
                left = windowWidth - calendarWidth - 10;
                if (left < 0) left = 10;
            }
            // If calendar overflows bottom, show above input
            if (top + calendarHeight > $(window).height() + scrollTop) {
                top = inputOffset.top - calendarHeight - 4;
                if (top < 0) top = 10;
            }
            calendar.css({
                'position': 'fixed',
                'top': top - scrollTop,
                'left': left - scrollLeft,
                'display': 'block',
                'right': 'auto',
                'bottom': 'auto',
                'max-width': '95vw',
            });
            // Prevent horizontal scroll
            $('body').css('overflow-x', 'hidden');
        });

        // Close calendar when clicking outside
        $(document).on('click', function (e) {
            if (!$(e.target).closest('#simpleCalendar, #myDatePicker').length) {
                $('#simpleCalendar').hide();
                $('body').css('overflow-x', '');
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
        $.getJSON("get_booked_dates.php?id=<?php echo $banquet_id ?>", function (data) {
            bookingData = data;
            renderCalendar();
        });
    }

    function initializeCustomCalendar() {
        // Month navigation
        $('#prevMonth').on('click', function () {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        $('#nextMonth').on('click', function () {
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

                // Check if date is in the past
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                const isPastDate = currentDay < today;

                // Check booking status
                const dateStr = formatDate(currentDay);
                const bookingStatus = getBookingStatus(dateStr);

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

    function showTimeScaleOnHover(dateStr) {
        const date = new Date(dateStr);
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

    function hideTimeScale() {
        // Hide time scale after a small delay to allow moving mouse to time scale
        setTimeout(function () {
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
        selectedDate = new Date(dateStr);

        // Update the date input
        $('#myDatePicker').val(dateStr);

        // Update flatpickr instance if it exists
        if (window.flatpickrInstance) {
            window.flatpickrInstance.setDate(dateStr);
        }

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

    function formatDate(date) {
        return date.toISOString().slice(0, 10);
    }

    function isSameDay(date1, date2) {
        return formatDate(date1) === formatDate(date2);
    }

    function updateTimeSlots(selectedDate) {
        $.getJSON("get_booked_slots.php", {
            date: selectedDate
        }, function (bookedSlots) {
            const slotMap = {
                "Morning (10 AM - 2 PM)": "Morning (10 AM - 2 PM)",
                "Evening (7 PM - 11 PM)": "Evening (7 PM - 11 PM)"
            };

            $("#timeSlot option").each(function () {
                const originalText = $(this).data("original-text");
                if (originalText) {
                    $(this).text(originalText);
                }
                $(this).prop("disabled", false);
            });

            bookedSlots.forEach(function (slotLabel) {
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
        $.getJSON("get_booked_dates.php?id=<?php echo $banquet_id ?>", function (data) {
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
                onDayCreate: function (dObj, dStr, fp, dayElem) {
                    const date = dayElem.dateObj;
                    const ymd = fp.formatDate(dayElem.dateObj, "Y-m-d");
                    if (fullyBooked.includes(ymd)) {
                        dayElem.classList.add("fully-booked");
                    } else if (partiallyBooked.includes(ymd)) {
                        dayElem.classList.add("partially-booked");
                    }
                },
                onChange: function (selectedDates, dateStr) {
                    updateTimeSlots(dateStr);
                }
            });
        });
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentRadios = document.querySelectorAll('.paymentOption');
        const totalAmountElement = document.getElementById('totalAmount');

        // Original price from PHP
        const fullPrice = <?php echo $banquet['price']; ?>;

        // Function to update amount
        function updateAmount() {
            let selectedOption = document.querySelector('.paymentOption:checked').value;

            let updatedAmount = selectedOption === 'advance' ?
                fullPrice * 0.3 :
                fullPrice;

            // Update the amount element
            totalAmountElement.textContent = updatedAmount.toFixed(2);
        }

        // Attach change event to radio buttons
        paymentRadios.forEach(radio => {
            radio.addEventListener('change', updateAmount);
        });

        // Optional: run once on load to reflect default selection
        updateAmount();
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