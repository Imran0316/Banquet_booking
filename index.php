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

// Feedback form insert code
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['feedback_submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);
    $rating = intval($_POST['rating']);

    if (!empty($name) && !empty($email) && !empty($message) && $rating > 0) {
        $insert = $pdo->prepare("INSERT INTO feedback (name, email, message, rating) VALUES (:name, :email, :message, :rating)");
        $insert->execute([
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'rating' => $rating
        ]);
        echo "<script>alert('Feedback submitted successfully!');</script>";
    } else {
        echo "<script>alert('Please fill all fields correctly.');</script>";
    }
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

<!-- feedback form -->
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
      <form method="POST" action="">
      <h2 class="mb-3 text-center fw-bold">Feedback Form</h2>
      <p class="text-muted text-center mb-4">
        Aap ka feedback hamaray liye important hai — thora waqt nikal kar form bhar dain.
      </p>

      <form id="feedbackForm" class="feedback-form p-4 rounded shadow-sm bg-white" novalidate>
        <div class="mb-3">
          <label for="name" class="form-label required">Name</label>
          <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="Your name" required>
          <div class="invalid-feedback">Please enter your name.</div>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label required">Email</label>
          <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="name@example.com" required>
          <div class="invalid-feedback">Please enter a valid email address.</div>
        </div>

        <div class="mb-3">
          <label class="form-label required">Rating</label>
          <div class="rating d-flex flex-row-reverse justify-content-start gap-1 fs-3">
            <input type="radio" id="star5" name="rating" value="5">
            <label for="star5" title="5 stars">★</label>
            <input type="radio" id="star4" name="rating" value="4">
            <label for="star4" title="4 stars">★</label>
            <input type="radio" id="star3" name="rating" value="3">
            <label for="star3" title="3 stars">★</label>
            <input type="radio" id="star2" name="rating" value="2">
            <label for="star2" title="2 stars">★</label>
            <input type="radio" id="star1" name="rating" value="1" required>
            <label for="star1" title="1 star">★</label>
          </div>
          <div class="invalid-feedback d-block" id="ratingFeedback" style="display:none;">Please choose a rating.</div>
        </div>

        <div class="mb-3">
          <label for="message" class="form-label required">Feedback</label>
          <textarea class="form-control form-control-lg" id="message" name="message" rows="5" placeholder="Aapka feedback yahan likhain..." required></textarea>
          <div class="invalid-feedback">Please write your feedback.</div>
        </div>

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
          <div>
            <button type="submit" name="feedback_submit" class="btn btn-primary btn-lg">Send Feedback</button>
            <button type="reset" class="btn btn-outline-secondary btn-lg ms-2">Reset</button>
          </div>
          <small class="text-muted">We respect your privacy.</small>
        </div>
      </form>

      <div class="mt-4" id="result" style="display:none;"></div>
    </div>
  </form>
  </div>
</div>

<style>
.feedback-form {
  max-width: 100%;
}
.feedback-form label.required::after {
  content: " *";
  color: red;
}
.rating input {
  display: none;
}
.rating label {
  cursor: pointer;
  color: #ccc;
  font-size: 2rem;
  transition: color 0.2s;
}
.rating input:checked ~ label,
.rating label:hover,
.rating label:hover ~ label {
  color: gold;
}
</style>


<script>
(function() {
  const form = document.getElementById('feedbackForm');
  const result = document.getElementById('result');
  const ratingFeedback = document.getElementById('ratingFeedback');

  form.addEventListener('submit', function(e) {
    e.preventDefault();
    e.stopPropagation();

    if (!form.checkValidity()) {
      form.classList.add('was-validated');
    }

    const rating = form.querySelector('input[name="rating"]:checked');
    if (!rating) {
      ratingFeedback.style.display = 'block';
    } else {
      ratingFeedback.style.display = 'none';
    }

    if (form.checkValidity() && rating) {
      const data = new FormData(form);
      const preview = `
        <div class="alert alert-success" role="alert">
          <h5 class="alert-heading">Thank you!</h5>
          <p>Your feedback has been captured (demo). Here's what you submitted:</p>
          <hr>
          <p><strong>Name:</strong> ${data.get('name')}</p>
          <p><strong>Email:</strong> ${data.get('email')}</p>
          <p><strong>Rating:</strong> ${data.get('rating')}</p>
          <p><strong>Message:</strong><br>${data.get('message')}</p>
        </div>`;

      result.innerHTML = preview;
      result.style.display = 'block';
      form.reset();
      form.classList.remove('was-validated');
    }
  }, false);
})();
</script>




<?php
include '../Banquet_booking/includes/footer.php';

?>
