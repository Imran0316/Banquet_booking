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


<!-- 🎉 VIP Popup Offer -->
<div id="vipOffer">
  <div class="vip-content">
    <span id="closePopup">&times;</span>
    <h2>🎉 Welcome to <br> Mera Shadi Hall</h2>
    <p>Book your banquet today & enjoy <b>25% OFF</b> with premium services!</p>
    <a href="banquet_list.php" class="vip-btn">Book Now</a>
  </div>
</div>

<!-- 🔥 Sticky Banner -->
<div id="vipBanner">
  <span>🎊 Special Deal: Luxury Banquet Booking <b>25% OFF</b></span>
  <a href="banquet_list.php" class="banner-btn">Grab Offer</a>
  <span id="closeBanner">&times;</span>
</div>

<style>
/* ====== Popup Style ====== */
#vipOffer {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.7);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 10000;
  animation: fadeIn 0.6s ease;
}
.vip-content {
  background: #fff;
  padding: 40px;
  border-radius: 20px;
  text-align: center;
  max-width: 450px;
  position: relative;
  box-shadow: 0 8px 30px rgba(0,0,0,0.3);
  animation: scaleUp 0.5s ease;
}
.vip-content h2 {
  color: #ff4081;
  margin-bottom: 15px;
}
.vip-content p {
  font-size: 18px;
  color: #444;
  margin-bottom: 20px;
}
.vip-btn {
  display: inline-block;
  background: linear-gradient(45deg, #ff4081, #ff9800);
  color: white;
  padding: 12px 30px;
  border-radius: 30px;
  text-decoration: none;
  font-weight: bold;
  transition: all 0.3s ease;
}
.vip-btn:hover {
  background: linear-gradient(45deg, #ff9800, #ff4081);
  transform: scale(1.05);
}
#closePopup {
  position: absolute;
  top: 15px; right: 20px;
  font-size: 28px;
  cursor: pointer;
  color: #888;
}

/* ====== Sticky Banner ====== */
#vipBanner {
  position: fixed;
  bottom: 0; left: 0;
  width: 100%;
  background: #222;
  color: #fff;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 20px;
  padding: 15px;
  font-size: 18px;
  z-index: 9999;
  animation: slideUp 0.6s ease;
}
#vipBanner .banner-btn {
  background: #ff4081;
  color: white;
  padding: 8px 20px;
  border-radius: 20px;
  text-decoration: none;
  font-weight: bold;
  transition: 0.3s;
}
#vipBanner .banner-btn:hover {
  background: #ff9800;
}
#closeBanner {
  cursor: pointer;
  font-size: 24px;
  margin-left: auto;
}

/* ====== Animations ====== */
@keyframes fadeIn {
  from {opacity: 0;} to {opacity: 1;}
}
@keyframes scaleUp {
  from {transform: scale(0.7);} to {transform: scale(1);}
}
@keyframes slideUp {
  from {transform: translateY(100%);} to {transform: translateY(0);}
}
</style>

<script>
// Show popup automatically on page load
window.addEventListener("load", function(){
  document.getElementById("vipOffer").style.display = "flex";
});

// Close popup
document.getElementById("closePopup").onclick = function(){
  document.getElementById("vipOffer").style.display = "none";
};

// Close banner
document.getElementById("closeBanner").onclick = function(){
  document.getElementById("vipBanner").style.display = "none";
};
</script>


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
                    <img src="<?php echo $banquet_row['image']; ?>" class="card-img-top"
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
              <a href="users/listed_banquets.php" class="btn btn-dark rounded-pill ">View All</a>
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
<section class="py-5" style="background:linear-gradient(to right, #f8f9fa, #ffffff);">
  <div class="container">
    <h2 class="text-center fw-bold mb-5 display-6">Our Valued Guests</h2>
    <div class="row text-center align-items-stretch g-5">

      <!-- Testimonial 1 -->
      <div class="col-md-4">
        <div class="d-flex flex-column align-items-center">
          <!-- Image with golden frame -->
          <div class="position-relative mb-3" style="width:110px; height:110px;">
            <img src="../assets/images/aliraza.jpg" class="rounded-circle shadow-lg w-100 h-100" alt="User 1">
            <span class="position-absolute top-0 start-0 w-100 h-100 rounded-circle border border-4 border-warning"></span>
          </div>
          <!-- Text -->
          <blockquote class="fst-italic text-muted px-3">
            “Booked a banquet for my sister's wedding — the process was smooth and everything was perfect. Highly recommended!”
          </blockquote>
          <h5 class="fw-bold mt-2">Ali Raza</h5>
          <div class="text-warning fs-5">★★★★★</div>
        </div>
      </div>

      <!-- Testimonial 2 -->
      <div class="col-md-4">
        <div class="d-flex flex-column align-items-center">
          <div class="position-relative mb-3" style="width:110px; height:110px;">
            <img src="../assets/images/sarakhan.jpg" class="rounded-circle shadow-lg w-100 h-100" alt="User 2">
            <span class="position-absolute top-0 start-0 w-100 h-100 rounded-circle border border-4 border-warning"></span>
          </div>
          <blockquote class="fst-italic text-muted px-3">
            “Beautiful interface and easy booking system. I love how quickly I found the perfect banquet.”
          </blockquote>
          <h5 class="fw-bold mt-2">Sara Khan</h5>
          <div class="text-warning fs-5">★★★★★</div>
        </div>
      </div>

      <!-- Testimonial 3 -->
      <div class="col-md-4">
        <div class="d-flex flex-column align-items-center">
          <div class="position-relative mb-3" style="width:110px; height:110px;">
            <img src="../assets/images/fahad.jpg" class="rounded-circle shadow-lg w-100 h-100" alt="User 3">
            <span class="position-absolute top-0 start-0 w-100 h-100 rounded-circle border border-4 border-warning"></span>
          </div>
          <blockquote class="fst-italic text-muted px-3">
            “Excellent customer support and the banquet listings are very detailed and genuine.”
          </blockquote>
          <h5 class="fw-bold mt-2">Fahad Ahmed</h5>
          <div class="text-warning fs-5">★★★★★</div>
        </div>
      </div>

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
<section class="feedback-section d-flex align-items-center justify-content-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-9"> <!-- 👈 Chorai barhadi -->
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
          <div class="card-body p-5 bg-white position-relative">
            
            <!-- Heading -->
            <h2 class="mb-3 text-center fw-bold text-dark">💬 Share Your Feedback</h2>
            <p class="text-muted text-center mb-4">
              Aap ka feedback hamaray liye <span class="fw-semibold text-warning">bohot important</span> hai.
            </p>

            <!-- Form -->
            <form id="feedbackForm" method="POST" action="" novalidate>
              <!-- Name -->
              <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Name</label>
                <input type="text" class="form-control rounded-3 shadow-sm border-0" id="name" name="name" placeholder="Your Name" required>
                <div class="invalid-feedback">Please enter your name.</div>
              </div>

              <!-- Email -->
              <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" class="form-control rounded-3 shadow-sm border-0" id="email" name="email" placeholder="name@example.com" required>
                <div class="invalid-feedback">Please enter a valid email address.</div>
              </div>

              <!-- Rating -->
              <div class="mb-3">
                <label class="form-label fw-semibold">Rating</label>
                <div class="rating d-flex flex-row-reverse justify-content-start gap-1 fs-3">
                  <input type="radio" id="star5" name="rating" value="5"><label for="star5" title="5 stars">★</label>
                  <input type="radio" id="star4" name="rating" value="4"><label for="star4" title="4 stars">★</label>
                  <input type="radio" id="star3" name="rating" value="3"><label for="star3" title="3 stars">★</label>
                  <input type="radio" id="star2" name="rating" value="2"><label for="star2" title="2 stars">★</label>
                  <input type="radio" id="star1" name="rating" value="1" required><label for="star1" title="1 star">★</label>
                </div>
                <div class="invalid-feedback d-block" id="ratingFeedback" style="display:none;">Please choose a rating.</div>
              </div>

              <!-- Feedback -->
              <div class="mb-3">
                <label for="message" class="form-label fw-semibold">Feedback</label>
                <textarea class="form-control rounded-3 shadow-sm border-0" id="message" name="message" rows="4" placeholder="Aapka feedback yahan likhain..." required></textarea>
                <div class="invalid-feedback">Please write your feedback.</div>
              </div>

              <!-- Buttons -->
              <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <button type="submit" name="feedback_submit" class="btn btn-warning fw-semibold px-4 shadow-sm rounded-3">Send</button>
                <button type="reset" class="btn btn-outline-secondary rounded-3">Reset</button>
              </div>
            </form>

            <div class="mt-3" id="result" style="display:none;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
  /* Background Section */
  .feedback-section {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8f9fc, #eef1f7, #dde3f0);
    padding: 20px;
  }

  /* Card hover effect */
  .card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
  }

  /* Input focus */
  .form-control:focus {
    box-shadow: 0 0 8px rgba(255,193,7,0.5);
    border: 1px solid #ffc107;
  }

  /* Rating Stars Styling */
  .rating input {
    display: none;
  }
  .rating label {
    color: #ccc;
    cursor: pointer;
    transition: color 0.2s ease;
  }
  .rating input:checked ~ label,
  .rating label:hover,
  .rating label:hover ~ label {
    color: #ffc107;
  }
</style>


<!-- Floating Review Button -->
<button id="reviewBtn">
   ⭐
</button>

<!-- Confetti Script -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

<script>
document.getElementById("reviewBtn").addEventListener("click", function () {
    // Confetti animation
    confetti({
        particleCount: 150,
        spread: 80,
        origin: { y: 0.6 }
    });

    // Popup ya message
    alert("🎉 Shukriya! welcome to mera shadi hall.");
});
</script>

<!-- Scroll to Top Button -->
<button id="scrollTopBtn">
  <i class="fa-solid fa-chevron-up"></i>
</button>

<style>
/* Scroll-to-Top Style */
#scrollTopBtn {
  position: fixed;
  left: 20px;        /* 👈 left side */
  bottom: 30px;      /* bottom distance */
  width: 45px;
  height: 45px;
  border: none;
  border-radius: 50%;
  background: #777;  /* gray background */
  color: #fff;
  font-size: 18px;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
  display: none; /* hidden by default */
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  z-index: 9999;
}
#scrollTopBtn:hover {
  transform: scale(1.15);
  background: #555; /* darker gray on hover */
}
</style>

<script>
// Show/Hide on scroll
let scrollBtn = document.getElementById("scrollTopBtn");

window.onscroll = function () {
  if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
    scrollBtn.style.display = "flex";
  } else {
    scrollBtn.style.display = "none";
  }
};

// Smooth scroll to top
scrollBtn.addEventListener("click", function () {
  window.scrollTo({ top: 0, behavior: 'smooth' });
});
</script>


<style>
/* Floating Button Style */
#reviewBtn {
  position: fixed;
  right: 20px;       /* right side distance */
  bottom: 100px;     /* bottom se distance */
  width: 50px;
  height: 50px;
  border: none;
  border-radius: 50%;
  background: #ff4081;
  color: #fff;
  font-size: 20px;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  z-index: 9999;
}
#reviewBtn:hover {
  transform: scale(1.15);
  background: #e73370;
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
