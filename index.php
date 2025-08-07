<?php
session_start();
include 'db.php';
include 'includes/header.php';
$page ="home";
include 'includes/navbar.php';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
    $stmt = $pdo->prepare("SELECT * FROM banquets WHERE name LIKE :search OR location LIKE :search");
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM banquets LIMIT 6");
}

?>

<!-- Hero Carousel -->
<div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
  <div class="carousel-inner">

    <div class="carousel-item active" style="height: 100vh; background: url('assets/images/banquet8.jpg') center center / cover no-repeat;">
        
  <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(160, 0, 0, 0.18); z-index: 2;"></div>
      <div class="carousel-overlay d-flex align-items-center justify-content-center text-white text-center" style="background: rgba(0,0,0,0.5); height: 100%;">
        <div>
          <h1 class="display-4 fw-bold">Plan Your Dream <span class="wedding"> Wedding </span></h1>
          <p class="lead">Find beautiful venues that suit your occasion</p>
          <a href="banquet_list.php" class="btn btn-outline btn-lg mt-3">Explore Banquets</a>
        </div>
      </div>
    </div>

    <div class="carousel-item" style="height: 90vh; background: url('assets/images/banquet9.jpg') center center / cover no-repeat;">
          <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(160, 0, 0, 0.18); z-index: 1;"></div>
      <div class="carousel-overlay d-flex align-items-center justify-content-center text-white text-center" style="background: rgba(0,0,0,0.5); height: 100%;">
        <div>
          <h1 class="display-4 fw-bold">Book for <span class="wedding"> Every </span> Celebration</h1>
          <p class="lead">Birthdays, Parties, Corporate Events — all in one place</p>
          <a href="banquet_list.php" class="btn btn-outline btn-lg mt-3">Browse Now</a>
        </div>
      </div>
    </div>

    <div class="carousel-item" style="height: 90vh; background: url('assets/images/banquet7.jpg') center center / cover no-repeat;">
          <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(160, 0, 0, 0.18); z-index: 1;"></div>
      <div class="carousel-overlay d-flex align-items-center justify-content-center text-white text-center" style="background: rgba(0,0,0,0.5); height: 100%;">
        <div>
          <h1 class="display-4 fw-bold">Book Hassle-<span class="wedding">Free</span></h1>
          <p class="lead">Available slots, instant booking, no tension!</p>
          <a href="banquet_list.php" class="btn btn-outline btn-lg mt-3">Book Now</a>
        </div>
      </div>
    </div>

  </div>

  <!-- Optional controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- section-2 -->
 <!-- WHY CHOOSE US  -->
<section class="sec-2 py-5  pattern-bg">
  <div class="container text-center ">
    <h2 class="mb-4 fw-bold">Why Book With Us?</h2>
    <div class="row g-4 pt-5">
      
      <div class="col-md-4">
        <i class="fa-solid fa-calendar-check fa-3x mb-3 text-warning"></i>
        <h5 class="fw-semibold">Easy Booking</h5>
        <p class="text-muted">Book your desired banquet with just a few clicks. No hassle, no confusion.</p>
      </div>
      
      <div class="col-md-4">
        <i class="fa-solid fa-shield-halved fa-3x mb-3 text-warning"></i>
        <h5 class="fw-semibold">Trusted Owners</h5>
        <p class="text-muted">We verify each banquet and its owner to ensure reliable service.</p>
      </div>
      
      <div class="col-md-4">
        <i class="fa-solid fa-star fa-3x mb-3 text-warning"></i>
        <h5 class="fw-semibold">Top Rated Venues</h5>
        <p class="text-muted">Browse only the best-reviewed banquets in your city.</p>
      </div>

    </div>
  </div>
</section>
<!-- section-3 -->

<h2 class="text-center">Banquets</h2>
 <!--  TOP BANQUETS-->
<section id="banquet-list" class="py-5 bg-light sec-2">
    <div class="container">
        <div class="row g-4">
            <?php while($banquet_row = $stmt->fetch(PDO::FETCH_ASSOC)){

              ?>
            <!-- Card Container -->
            <div class="col-md-4 mb-4">
                <div class="card banquet-card shadow-sm border-0 rounded-4 overflow-hidden">

                    <!-- Image -->
                    <img src="uploads<?php echo $banquet_row['image']; ?>" class="card-img-top"
                        style="height: 180px; object-fit: cover;" alt="Banquet Image">

                    <!-- Card Body -->
                    <div class="card-body">
                        <h5 class="fw-semibold mb-1">
                            <?php echo $banquet_row["name"] . " | " . $banquet_row["location"]; ?><span> | Banquet
                            </span></h5>

                        <p class="card-text mb-2">Starting From Rs. <?php echo $banquet_row["price"]; ?></p>

                        <p><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"><i
                                    class="fa-solid fa-star"></i></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><span></space>
                        </p>
                        <!-- Button -->
                        <a href="users/booking_page.php?id=<?php echo $banquet_row['id']; ?>"
                            class="btn btn-sm btn-dark w-100 rounded-pill">
                            View Details
                        </a>
                    </div>

                </div>
            </div>


            <?php }?>
        </div>
    </div>
</section>

<!-- section 4 -->
 <!-- HOW IT WORKS -->
<section class="py-5 bg-white">
  <div class="container  sec-4  py-5 text-center">
    <h2 class="fw-bold mb-5">How It Works</h2>
    <div class="row g-4">

      <div class="col-md-4">
        <i class="fa-solid fa-magnifying-glass fa-3x text-warning mb-3"></i>
        <h5 class="fw-semibold">Search Banquets</h5>
        <p class="text-muted">Explore banquets by location, price, or capacity to find your perfect match.</p>
      </div>

      <div class="col-md-4">
        <i class="fa-solid fa-calendar-alt fa-3x text-warning mb-3"></i>
        <h5 class="fw-semibold">Book Instantly</h5>
        <p class="text-muted">Select your event date and time slot — book with ease in a few clicks.</p>
      </div>

      <div class="col-md-4">
        <i class="fa-solid fa-champagne-glasses fa-3x text-warning mb-3"></i>
        <h5 class="fw-semibold">Enjoy the Event</h5>
        <p class="text-muted">Show up on the day and enjoy a perfectly arranged event at your chosen venue.</p>
      </div>

    </div>
  </div>
</section>
<!-- Testimaonial -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center fw-bold mb-5">What Our Users Say</h2>

    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">

        <!-- Slide 1 -->
        <div class="carousel-item active">
          <div class="d-flex justify-content-center">
            <div class="card shadow-lg border-0 p-4 rounded-4" style="max-width: 600px;">
              <div class="text-center">
                <img src="assets/images/user1.jpg" class="rounded-circle mb-3 border border-3 border-white shadow" width="90" alt="User 1">
                <h5 class="fw-semibold">Ali Raza</h5>
                <p class="text-muted fst-italic">“Booked a banquet for my sister's wedding — the process was smooth and everything was perfect. Highly recommended!”</p>
                <div class="text-warning">★★★★★</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item">
          <div class="d-flex justify-content-center">
            <div class="card shadow-lg border-0 p-4 rounded-4" style="max-width: 600px;">
              <div class="text-center">
                <img src="assets/images/user2.jpg" class="rounded-circle mb-3 border border-3 border-white shadow" width="90" alt="User 2">
                <h5 class="fw-semibold">Sara Khan</h5>
                <p class="text-muted fst-italic">“Beautiful interface and easy booking system. I love how quickly I found the perfect banquet.”</p>
                <div class="text-warning">★★★★★</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Slide 3 -->
        <div class="carousel-item">
          <div class="d-flex justify-content-center">
            <div class="card shadow-lg border-0 p-4 rounded-4" style="max-width: 600px;">
              <div class="text-center">
                <img src="assets/images/user3.jpg" class="rounded-circle mb-3 border border-3 border-white shadow" width="90" alt="User 3">
                <h5 class="fw-semibold">Fahad Ahmed</h5>
                <p class="text-muted fst-italic">“Excellent customer support and the banquet listings are very detailed and genuine.”</p>
                <div class="text-warning">★★★★★</div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- Carousel Controls -->
      <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
</section>

<!-- banquet Owner Cta -->
 <section class="py-5 owner-cta text-center" >
   
  <div class="container">
    <h2 class="fw-bold mb-4">Own a Banquet Hall?</h2>
    <p class="lead mb-4">Join Pakistan’s growing digital banquet platform and boost your bookings effortlessly.</p>
    <a href="owner_register.php" class="btn btn-warning btn-lg fw-semibold px-4">
      List Your Banquet
    </a>
  </div>
</section>

<?php
include '../Banquet_booking/includes/footer.php';

?>