<?php
session_start();
include("../db.php");
include("include/header.php");
$page = "inner";
include("include/navbar.php");


// Fetch banquet details from the database
$banquet_id = isset($_GET['id']) ? intval($_GET['id']) : 1; // Default to 1 if no ID is provided
$query = "SELECT * FROM banquets WHERE id = $banquet_id";
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
</style>

<div class="container py-5 d-flex  align-items-start justify-content-equal">
    <div class="left_section col-8 ">
        <!-- Step 1 -->
        <div class="step active " id="step1">
            <div class="step-header" onclick="toggleStep(1)"><span
                    class="border border-1  rounded-circle border-dark px-1 me-2"> 1 </span> Personal Information</div>
            <form id="projectForm " class="step-content px-5">
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="address">Full Name:</label>
                        <input type="text" class="form-control" id="address" placeholder="Full Name" required>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="address">Email:</label>
                        <input type="email" class="form-control" id="email" placeholder="Email" required>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="address">Phone:</label>
                        <input type="text" class="form-control" id="phone" placeholder="e.g 03123456789" required>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="address">Address</label>
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

                    <!-- Submit -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-success">Pay Now</button>
                    </div>
                </div>
            </form>



        </div>

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
                    <input type="date" class="form-control border-0 border-bottom rounded-0" required>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Start Time</label>
                        <input type="time" class="form-control border-0 border-bottom rounded-0" required>
                    </div>
                    <div class="col">
                        <label class="form-label">End Time</label>
                        <input type="time" class="form-control border-0 border-bottom rounded-0" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>$19.00 x 2 hours</span>
                    <span>$38.00</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Processing fee <i class="bi bi-question-circle" title="Payment handling charges"></i></span>
                    <span>$5.70</span>
                </div>

                <hr>
                <div class="d-flex justify-content-between fw-bold mb-3">
                    <span>Total USD</span>
                    <span>$43.70</span>
                </div>

                <div class="text-center">
                    <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_111x69.jpg" alt="PayPal Logo"
                        width="100" class="mb-2">
                    <p class="mb-0 small text-muted">Pay in 4 interest-free payments. <a href="#">Learn more</a></p>
                </div>
            </form>
        </div>

    </div>
</div>
<script>
function toggleStep(stepNumber) {
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const step2Header = document.getElementById('step2-header');

    if (stepNumber === 1) {
        step1.classList.add('active');
        step2.classList.remove('active');
    } else if (stepNumber === 2 && !step2Header.classList.contains('disabled')) {
        step2.classList.add('active');
        step1.classList.remove('active');
    }
}

function enableStep2() {
    const step2Header = document.getElementById('step2-header');
    step2Header.classList.remove('disabled');
    toggleStep(2);
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
</script>
<?php 
include("../includes/footer.php");

?>