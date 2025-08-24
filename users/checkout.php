<?php
session_start();
include("../db.php");
include("include/header.php");
$page = "inner";
include("include/navbar.php");
error_reporting(0);
// Inputs
$banquet_id = isset($_GET['banquetID']) ? intval($_GET['banquetID']) : (isset($_POST['banquetID']) ? intval($_POST['banquetID']) : 1);
$date_selected = isset($_GET['event_date']) ? $_GET['event_date'] : (isset($_POST['event_date']) ? $_POST['event_date'] : date('Y-m-d'));
$time_selected = isset($_GET['time_slot']) ? $_GET['time_slot'] : (isset($_POST['time_slot']) ? $_POST['time_slot'] : '');

if (isset($_POST['user_signup'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name && $email && $phone && $password) {
        // Check if email already exists
        $checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $checkStmt->execute([$email]);
        if ($checkStmt->rowCount() > 0) {
            $_SESSION['error'] = 'Email already registered. Please log in.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $email, $phone, $hash])) {
                // Automatically log in the user after signup
                $_SESSION['id'] = $pdo->lastInsertId();
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                $_SESSION['phone'] = $phone;

                // Redirect to the next step
                header("Location: checkout.php?banquetID=$banquet_id&event_date=$date_selected&time_slot=$time_selected");
?>
<script>
    // Fallback JavaScript redirect to ensure proper page reload
    window.location.href = "checkout.php?banquetID=<?php echo $banquet_id; ?>&event_date=<?php echo $date_selected; ?>&time_slot=<?php echo $time_selected; ?>";
</script>
<?php
                exit(); // Ensure immediate redirection and stop further script execution
            } else {
                $_SESSION['error'] = 'Error signing up. Please try again.';
            }
        }
    } else {
        $_SESSION['error'] = 'All signup fields are required.';
    }
}

$is_logged_in = isset($_SESSION['id']) && !empty($_SESSION['id']);

// Fetch banquet
$stmt = $pdo->prepare("SELECT * FROM banquets WHERE id = ?");
$stmt->execute([$banquet_id]);
$banquet = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['price' => 0, 'name' => 'Banquet', 'cover_image' => '../assets/images/banquet7.jpg', 'location' => ''];
$fullPrice = floatval($banquet['price']);
$advanceFee = round($fullPrice * 0.3, 2);

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking - <?php echo htmlspecialchars($banquet['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        /* Clean single-page layout with step sections on left */
        body {
            font-family: 'Poppins', sans-serif;
        }

        .container {
            max-width: 1100px;
        }

        .form-section {
            padding: 20px;
        }

        .card-summary {
            padding: 18px;
        }

        .card-summary img {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 6px
        }

        .muted {
            color: #666;
            font-size: 13px
        }

        .btn-primary {
            background: goldenrod;
            border: none
        }

        .btn-primary:hover {
            background: darkgoldenrod
        }

        .small-label {
            font-size: 13px;
            font-weight: 600
        }

        .input-borderless {
            border: 0;
            border-bottom: 1px solid #ddd;
            border-radius: 0
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .step-box {
            border: 1px solid #e6e6e6;
            border-radius: 6px;
            margin-bottom: 12px;
        }

        .step-header {
            padding: 12px 16px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fafafa;
        }

        .step-body {
            padding: 16px;
            display: none;
        }

        .step-body.active {
            display: block;
        }

        .step-number {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #f0c419;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-right: 8px
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row g-4">
            <!-- LEFT: Step-wise inputs -->
            <div class="col-md-8">
                <div class="card form-section">
                    <div class="card-body">
                        <?php if(isset($_SESSION["success"])){
                            echo '<div class="alert alert-success">' . $_SESSION["success"] . '</div>';
                            unset($_SESSION["success"]);
                        } elseif (isset($_SESSION["error"])) {
                            echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION["error"]) . '</div>';
                            unset($_SESSION["error"]); // Destroy the error session after displaying it
                        } ?>
                        <h5 class="mb-3">Book Your Slot</h5>

                        <!-- STEP 1: Personal (Signup) -->
                        <div class="step-box">
                            <div class="step-header" onclick="openStep(1)">
                                <div><span class="step-number">1</span> Personal Information</div>
                                <div id="statusStep1" class="muted">
                                    <?php echo $is_logged_in ? 'Logged in' : 'Not logged in'; ?>
                                </div>
                            </div>
                            <div class="step-body" id="stepBody1">
                                <?php if (!$is_logged_in) { ?>
                                    <div id="guestAlert"></div>
                                    <form action="" method="POST">
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label class="small-label">Full name</label>
                                                <input name="name" id="name" class="form-control" placeholder="Full name">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label class="small-label">Email</label>
                                                <input name="email" id="email" class="form-control" placeholder="Email">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label class="small-label">Phone</label>
                                                <input name="phone" id="phone" class="form-control"
                                                    placeholder="03XXXXXXXXX">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label class="small-label">Password</label>
                                                <input type="password" name="password" id="password" class="form-control"
                                                    placeholder="Choose a password">
                                            </div>
                                            <div class="col-12 mt-2">
                                                <div class="form-text">(If you don't have an account we'll create one with
                                                    these credentials.)</div>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <button type="button" class="btn btn-primary" onclick="saveStep1()"><input
                                                        type="submit" name="user_signup" class="bg-transparent border-0" value="singup"></button>
                                            </div>
                                            <small>Already have an Account
                                                <a type="button" class="text-underline" data-bs-toggle="modal"
                                                    data-bs-target="#loginModal">
                                                    Login
                                                </a>
                                            </small>
                                        </div>
                                    </form>
                                <?php } else {
                                    $stmtU = $pdo->prepare('SELECT name,email,phone FROM users WHERE id=? LIMIT 1');
                                    $stmtU->execute([$_SESSION['id']]);
                                    $user = $stmtU->fetch(PDO::FETCH_ASSOC) ?: [];
                                    ?>
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="small-label">Name</label>
                                            <input class="form-control"
                                                value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" readonly>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="small-label">Email</label>
                                            <input class="form-control"
                                                value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" readonly>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="small-label">Phone (editable)</label>
                                            <input id="phoneLogged" class="form-control"
                                                value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <button type="button" class="btn btn-primary" onclick="openStep(2)">Continue to
                                                Details</button>
                                        </div>

                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- Login Modal -->
                        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content p-3 rounded-3 shadow">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="loginModalLabel">Login</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Message Alert -->
                                        <div id="loginMessage"></div>

                                        <form id="loginForm">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email address</label>
                                                <input type="email" name="login_email" class="form-control" id="email"
                                                    placeholder="Enter email" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" name="login_password" class="form-control"
                                                    id="password" placeholder="Enter password" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100">Login</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="submit_booking.php" method="POST">
                            <!-- STEP 2: Details (Phone/address/notes) -->
                            <div class="step-box">
                                <div class="step-header" onclick="openStep(2)">
                                    <div><span class="step-number">2</span> Details</div>
                                    <div id="statusStep2" class="muted">Fill address & notes</div>
                                </div>
                                <div class="step-body" id="stepBody2">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="small-label">Phone</label>
                                            <input id="phoneStep2"  class="form-control" placeholder="03XXXXXXXXX">
                                        </div>
                                        <div class="col-12 mb-2">
                                            <label class="small-label">Address</label>
                                            <input id="addressStep2" name="address" class="form-control"
                                                placeholder="e.g. 123 Street, DHA, Karachi">
                                        </div>
                                        <div class="col-12 mb-2">
                                            <label class="small-label">Extra Notes</label>
                                            <textarea id="notesStep2" name="notes" class="form-control"
                                                placeholder="e.g. light decoration"></textarea>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <button type="button" class="btn btn-primary" onclick="openStep(3)">Continue
                                                to
                                                Payment</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- STEP 3: Payment -->
                            <div class="step-box">
                                <div class="step-header" onclick="openStep(3)">
                                    <div><span class="step-number">3</span> Payment</div>
                                    <div id="statusStep3" class="muted">Choose payment type & method</div>
                                </div>
                                <div class="step-body" id="stepBody3">
                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <label class="small-label">Payment Type</label>
                                            <div class="form-check">
                                                <input class="form-check-input paymentOptionLeft" type="radio"
                                                    name="payment_option_left" id="payFullLeft" value="full" checked>
                                                <label class="form-check-label" for="payFullLeft">Full Payment</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input paymentOptionLeft" type="radio"
                                                    name="payment_option_left" id="payAdvanceLeft" value="advance">
                                                <label class="form-check-label" for="payAdvanceLeft">Advance
                                                    (30%)</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <label class="small-label" >Payment Method</label>
                                            <select id="paymentMethodLeft" name="paymentMethodLeft" class="form-select">
                                                <option value="">Select method</option>
                                                <option value="card">Card</option>
                                                <option value="jazzcash">JazzCash</option>
                                                <option value="easypaisa">EasyPaisa</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-2" id="methodFieldsLeft" style="display:none">
                                            <div id="cardFieldsLeft" style="display:none">
                                                <input id="cardNumberLeft" class="form-control mb-2"
                                                    placeholder="Card number" name="cardNumberLeft">
                                                <input id="cardExpiryLeft" class="form-control mb-2"
                                                    placeholder="MM/YY">
                                                <input id="cardCvcLeft" class="form-control mb-2" placeholder="CVC">
                                            </div>
                                            <div id="mobileFieldsLeft" style="display:none">
                                                <input id="payerNameLeft" class="form-control mb-2"
                                                    placeholder="Payer name" name="payerNameLeft">
                                                <input id="payerNumberLeft" name="payer_number" class="form-control mb-2"
                                                    placeholder="03XXXXXXXXX">
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <!-- Hidden form that will submit to checkout.php -->
                                            <form id="toCheckoutLeft" action="checkout.php" method="GET">
                                                <input type="hidden" name="banquetID"
                                                    value="<?php echo $banquet_id; ?>">
                                                <input type="hidden" name="event_date" id="hidden_event_date_left"
                                                    value="<?php echo htmlspecialchars($date_selected); ?>">
                                                <input type="hidden" name="time_slot" id="hidden_time_slot_left"
                                                    value="<?php echo htmlspecialchars($time_selected); ?>">
                                                <input type="hidden" name="payment_option"
                                                    id="hidden_payment_option_left" value="full">
                                                <input type="hidden" name="amount" id="hidden_amount_left"
                                                    value="<?php echo number_format($fullPrice, 2); ?>">
                                                <button type="submit" class="btn btn-primary">Proceed to
                                                    Checkout</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Minimal summary card (only image, selected date/time, total amount) -->
            <div class="col-md-4">
                <div class="card card-summary">
                    <div class="d-flex align-items-center mb-3">
                        <img src="../<?php echo $banquet["image"]; ?>" alt="thumb">
                        
                        <div class="ms-3">
                            <div class="fw-bold"><?php echo htmlspecialchars($banquet['name']); ?></div>
                            <div class="muted"><?php echo htmlspecialchars($banquet['location'] ?? ''); ?></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="summary-row">
                            <div class="muted">Selected Date</div>
                            <div id="summaryDate"><?php echo htmlspecialchars($date_selected); ?></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="summary-row">
                            <div class="muted">Selected Time</div>
                            <div id="summaryTime"><?php echo htmlspecialchars($time_selected ?: '--'); ?></div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <div class="summary-row">
                            <div class="muted">Total Amount</div>
                            <div id="summaryAmount"><?php echo number_format($fullPrice, 2); ?></div>
                        </div>
                    </div>
                    <div class="muted">(Amount updates when you choose Advance or Full on the left)</div>
                </div>
            </div>
        </div>
    </div>

    <?php include("../includes/footer.php"); ?>
    <script>
        $(document).ready(function () {
            $("#loginForm").submit(function (e) {
                e.preventDefault(); // Stop normal form submission

                $.ajax({
                    url: "ajax_login.php",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            $("#loginMessage").html(
                                `<div class="alert alert-success">${response.message}</div>`
                            );
                            // Example: hide modal after 1s
                            setTimeout(() => {
                                $("#loginModal").modal("hide");
                                location.reload(); // reload to show logged-in state
                            }, 1000);
                        } else {
                            $("#loginMessage").html(
                                `<div class="alert alert-danger">${response.message}</div>`
                            );
                        }
                    }
                });
            });
        });
    </script>

    <script>
        // Date helpers (avoid timezone issues)
        function parseYMD(dateStr) { if (!dateStr || typeof dateStr !== 'string') return new Date(dateStr); const p = dateStr.split('-').map(Number); if (p.length !== 3) return new Date(dateStr); return new Date(p[0], p[1] - 1, p[2]); }
        function formatLocal(d) { const y = d.getFullYear(); const m = String(d.getMonth() + 1).padStart(2, '0'); const day = String(d.getDate()).padStart(2, '0'); return `${y}-${m}-${day}`; }

        // Step open/close
        function openStep(n) {
            $('.step-body').removeClass('active');
            $('#stepBody' + n).addClass('active');
            // scroll into view for mobile
            document.getElementById('stepBody' + n).scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        // Save Step1 data (basic validation) and move to step 2
        function saveStep1() {
            // if logged in, skip validation
            var logged = <?php echo $is_logged_in ? 'true' : 'false'; ?>;
            if (!logged) {
                var name = $('#name').val().trim();
                var email = $('#email').val().trim();
                var phone = $('#phone').val().trim();
                var pass = $('#password').val().trim();
                if (!name || !email || !phone || !pass) {
                    $('#guestAlert').html('<div class="alert alert-danger">Please fill all personal fields to continue.</div>');
                    return;
                }
                // copy values to step2 phone field for continuity
                $('#phoneStep2').val(phone);
                // show next
                openStep(2);
            } else {
                // logged in - copy logged phone to step2
                $('#phoneStep2').val($('#phoneLogged').val());
                openStep(2);
            }
        }

        // Initialize flatpickr and other behaviors
        $(function () {
            // load booked dates & initialize flatpickr on left date input
            $.getJSON('get_booked_dates.php?id=<?php echo $banquet_id; ?>', function (data) {
                const fully = data.fullyBooked || [];
                window.flatpickrInstance = flatpickr('#myDatePickerLeft', {
                    dateFormat: 'Y-m-d', minDate: 'today', maxDate: new Date().fp_incr(365), disable: fully,
                    onChange: function (sd, dateStr) {
                        if (dateStr) { $('#hidden_event_date_left').val(dateStr); $('#summaryDate').text(dateStr); updateTimeSlots(dateStr); }
                    }
                });
            });

            // time slot change -> update hidden + summary
            $('#timeSlotLeft').on('change', function () { const v = $(this).val(); $('#hidden_time_slot_left').val(v); $('#summaryTime').text(v || '--'); });

            // payment option change
            $(document).on('change', '.paymentOptionLeft', function () { refreshAmountLeft(); });

            // payment method change - show/hide fields
            $('#paymentMethodLeft').on('change', function () { const m = $(this).val(); if (!m) { $('#methodFieldsLeft').hide(); $('#cardFieldsLeft').hide(); $('#mobileFieldsLeft').hide(); } else { $('#methodFieldsLeft').show(); if (m === 'card') { $('#cardFieldsLeft').show(); $('#mobileFieldsLeft').hide(); } else { $('#cardFieldsLeft').hide(); $('#mobileFieldsLeft').show(); } } });

            // clicking summary card date/time should open corresponding step
            $('#summaryDate').on('click', function () { openStep(2); $('#myDatePickerLeft').focus(); });
            $('#summaryTime').on('click', function () { openStep(2); $('#timeSlotLeft').focus(); });

            // initial open step 1
            openStep(1);
            refreshAmountLeft();
        });

        function refreshAmountLeft() { const full = <?php echo json_encode($fullPrice); ?>; const opt = document.querySelector('.paymentOptionLeft:checked') ? document.querySelector('.paymentOptionLeft:checked').value : 'full'; const amount = opt === 'advance' ? parseFloat((full * 0.3).toFixed(2)) : parseFloat(full); $('#summaryAmount').text(amount.toFixed(2)); $('#hidden_payment_option_left').val(opt); $('#hidden_amount_left').val(amount.toFixed(2)); }

        function updateTimeSlots(dateStr) { $.getJSON('get_booked_slots.php', { date: dateStr, id: <?php echo $banquet_id; ?> }, function (booked) { $('#timeSlotLeft option').prop('disabled', false).each(function () { const orig = $(this).data('original-text'); if (orig) $(this).text(orig); }); booked.forEach(function (slot) { $('#timeSlotLeft option').filter(function () { return $(this).val() === slot; }).each(function () { $(this).data('original-text', $(this).text()); $(this).text($(this).text() + ' (Booked)'); $(this).prop('disabled', true); }); }); $('#timeSlotLeft').val(''); $('#hidden_time_slot_left').val(''); $('#summaryTime').text('--'); }); }
    </script>

</body>

</html>