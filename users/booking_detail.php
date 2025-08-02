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
body {
    font-family: 'Roboto', sans-serif;
    background-color: #fff;
    color: maroon;
    margin: 0;
    padding: 0;
}

.hero {
    background: url('https://yourdomain.com/your-hero-image.jpg') no-repeat center center/cover;
    height: 60vh;
    width: 100%;
}

.booking-wrapper {
    max-width: 1200px;
    margin: -100px auto 50px;
    padding: 30px;
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
}

.booking-form {
    flex: 1 1 60%;
}

.booking-form h2 {
    font-weight: bold;
    margin-bottom: 30px;
    color: maroon;
}

.form-control {
    border: none;
    border-bottom: 2px solid goldenrod;
    border-radius: 0;
    background: transparent;
    color: maroon;
}

.form-control::placeholder {
    color: #b97c00;
}

.form-control:focus {
    box-shadow: none;
    border-color: maroon;
}

label {
    font-weight: 500;
    color: goldenrod;
}

.submit-btn {
    background-color: goldenrod;
    color: white;
    font-weight: bold;
    border: none;
    transition: 0.3s;
}

.submit-btn:hover {
    background-color: maroon;
    color: white;
}

.banquet-card {
    flex: 1 1 35%;
    border: 1px solid #ddd;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.banquet-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.banquet-card .card-body {
    padding: 20px;
}

.banquet-card h4 {
    color: maroon;
    margin-bottom: 10px;
}

.banquet-card p {
    margin: 5px 0;
    color: #444;
}

@media (max-width: 768px) {
    .booking-wrapper {
        flex-direction: column;
    }
}
</style>
</head>

<body>

    <!-- ✅ Hero Section -->
    <div class="hero">Book your banquet</div>

    <!-- ✅ Booking + Card Layout -->
    <div class="booking-wrapper">

        <!-- ✅ Booking Form -->
        <div class="booking-form">
            <h2>Book This Banquet</h2>
            <form>
                <!-- <div class="form-row"> -->
                    <div class="form-group col-md-6">
                        <input type="hidden" name="banquetID" value="<?php echo $banquet_id ?>" class="form-control">

                        <input type="hidden" name="userID" value="<?php echo $user_id ?>" class="form-control">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Your Name">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Phone</label>
                        <input type="number" class="form-control" name="phone" placeholder="example@email.com">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" placeholder="example@email.com">
                    </div>
                     <div class="form-group col-md-6">
                        <label>Departure Date</label>
                        <input type="date" class="form-control">
                    </div>
                

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Banquet Type</label>
                        <select class="form-control">
                            <option selected disabled>Please Select</option>
                            <option>VIP Hall</option>
                            <option>Standard Hall</option>
                            <option>Garden Setup</option>
                        </select>
                    </div>
                    
                </div>

                

                <div class="form-group">
                    <label>Special Requests</label>
                    <textarea class="form-control" rows="3" placeholder="Any extra setup, decor, etc."></textarea>
                </div>

                <button type="submit" class="btn submit-btn btn-block">Submit Booking</button>
            </form>
        </div>

        <!-- ✅ Banquet Info Card -->
        <div class="banquet-card">
            <img src="https://yourdomain.com/banquet-thumbnail.jpg" alt="Banquet Image">
            <div class="card-body">
                <h4>Skydec Grand Banquet</h4>
                <p><strong>Location:</strong> North Nazimabad, Karachi</p>
                <p><strong>Capacity:</strong> 300 guests</p>
                <p><strong>Price:</strong> PKR 45,000 per event</p>
                <p><strong>Status:</strong> Available</p>
            </div>
        </div>

    </div>

</body>

</html>



<?php 
include("../includes/footer.php");

?>