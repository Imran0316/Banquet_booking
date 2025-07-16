<footer class="bg-dark text-white pt-5 pb-3">
    <div class="container foot">
        <div class="row">

            <!-- Brand Info -->
            <div class="col-md-3">
                <h5 class="fw-bold">Banquet Booking</h5>
                <p class="text-muted">Find and book the perfect banquet for any occasion with ease and trust.</p>
            </div>

            <!-- Quick Links -->
            <div class="col-md-3">
                <h6 class="fw-semibold mb-3">Quick Links</h6>
                <ul class="list-unstyled text-muted">
                    <li><a href="index.php" class="text-white text-decoration-none">Home</a></li>
                    <li><a href="banquet_list.php" class="text-white text-decoration-none">Banquets</a></li>
                    <li><a href="login.php" class="text-white text-decoration-none">Login</a></li>
                    <li><a href="register.php" class="text-white text-decoration-none">Register</a></li>
                </ul>
            </div>

            <!-- For Banquet Owners -->
            <div class="col-md-3">
                <h6 class="fw-semibold mb-3">For Banquet Owners</h6>
                <ul class="list-unstyled text-muted">
                    <li><a href="owner_register.php" class="text-white text-decoration-none">List Your Banquet</a></li>
                    <li><a href="owner_login.php" class="text-white text-decoration-none">Owner Login</a></li>
                    <li><a href="admin_login.php" class="text-white text-decoration-none">Admin Panel</a></li>
                </ul>
            </div>

            <!-- Contact & Social -->
            <div class="col-md-3">
                <h6 class="fw-semibold mb-3">Contact Us</h6>
                <p class="text-muted mb-1"><i class="fa fa-phone me-2"></i>+92 300 1234567</p>
                <p class="text-muted"><i class="fa fa-envelope me-2"></i>info@banquetbook.com</p>
                <div>
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                </div>
            </div>

        </div>

        <hr class="bg-light mt-4">
        <p class="text-center text-muted mb-0">© 2025 Banquet Booking. All rights reserved.</p>
    </div>
</footer>




<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
window.addEventListener('scroll', function() {
    const nav = document.querySelector('.navbar');
    if (window.scrollY > 200) {
        nav.classList.add('scrolled');
    } else {
        nav.classList.remove('scrolled');
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// $(document).ready(function() {
//     $.getJSON("get_booked_dates.php", function(bookedDates) {
//         flatpickr("#myDatePicker", {
//             dateFormat: "Y-m-d",
//             disable: bookedDates
//         });
//     });
// });
</script>

<script>
// $(document).ready(function () {
//     $.getJSON("get_booked_dates.php", function (bookedDates) {
//         flatpickr("#myDatePicker", {
//             dateFormat: "Y-m-d",
//             disable: bookedDates,
//             onChange: function (selectedDates, dateStr) {
//                 $.getJSON("get_booked_slots.php", { date: dateStr }, function (bookedSlots) {
//                     // Map full labels to values
//                     const slotMap = {
//                         "Morning (10 AM - 2 PM)": "Morning (10 AM - 2 PM)",
//                         "Evening (7 PM - 11 PM)": "Evening (7 PM - 11 PM)"
//                     };

//                     // Step 1: Reset all options to enabled and original text
//                     $("#timeSlot option").each(function () {
//                         const originalText = $(this).data("original-text");
//                         if (originalText) {
//                             $(this).text(originalText);
//                         }
//                         $(this).prop("disabled", false);
//                     });

//                     // Step 2: Disable the booked slots and label them
//                     bookedSlots.forEach(function (slotLabel) {
//                         const slotValue = slotMap[slotLabel];
//                         const $option = $("#timeSlot option[value='" + slotValue + "']");
//                         if ($option.length) {
//                             // Save original text (once only)
//                             if (!$option.data("original-text")) {
//                                 $option.data("original-text", $option.text());
//                             }
//                             // Update text and disable
//                             $option.text($option.text() + " (Booked)");
//                             $option.prop("disabled", true);
//                         }
//                     });

//                     // Reset dropdown selection
//                     $("#timeSlot").val("");
//                 });
//             }
//         });
//     });
// });
</script>



<script>
$(document).ready(function() {
    $.getJSON("get_booked_dates.php", function(data) {
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

// ...existing code...
</body>

</html>