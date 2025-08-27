<?php
session_start();
include 'db.php';
include 'includes/header.php';
$page = "home";
include 'includes/navbar.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
  $stmt = $pdo->prepare("SELECT * FROM banquets WHERE name LIKE :search OR location LIKE :search");
  $stmt->execute(['search' => "%$search%"]);
} else {
  $stmt = $pdo->query("SELECT * FROM banquets LIMIT 6");
}




?>




<style>
  /* ====== Animations ====== */
  @keyframes fadeIn {
    from {
      opacity: 0;
    }

    to {
      opacity: 1;
    }
  }

  @keyframes scaleUp {
    from {
      transform: scale(0.7);
    }

    to {
      transform: scale(1);
    }
  }

  @keyframes slideUp {
    from {
      transform: translateY(100%);
    }

    to {
      transform: translateY(0);
    }
  }
</style>

<script>
  // Show popup automatically on page load
  window.addEventListener("load", function () {
    document.getElementById("vipOffer").style.display = "flex";
  });

  // Close popup
  document.getElementById("closePopup").onclick = function () {
    document.getElementById("vipOffer").style.display = "none";
  };

  // Close banner
  document.getElementById("closeBanner").onclick = function () {
    document.getElementById("vipBanner").style.display = "none";
  };
</script>


<!-- Hero Carousel -->
<div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
  <div class="carousel-inner">

    <div class="carousel-item active"
      style="height: 100vh; background: url('assets/images/banquet8.jpg') center center / cover no-repeat;">

      <div
        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(160, 0, 0, 0.18); z-index: 2;">
      </div>
      <div class="carousel-overlay d-flex align-items-center justify-content-center text-white text-center"
        style="background: rgba(0,0,0,0.5); height: 100%;">
        <div>
          <h1 class="display-4 fw-bold">Plan Your Dream <span class="wedding"> Wedding </span></h1>
          <p class="lead">Find beautiful venues that suit your occasion</p>

        </div>
      </div>
    </div>

    <div class="carousel-item"
      style="height: 90vh; background: url('assets/images/banquet9.jpg') center center / cover no-repeat;">
      <div
        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(160, 0, 0, 0.18); z-index: 1;">
      </div>
      <div class="carousel-overlay d-flex align-items-center justify-content-center text-white text-center"
        style="background: rgba(0,0,0,0.5); height: 100%;">
        <div>
          <h1 class="display-4 fw-bold">Book for <span class="wedding"> Every </span> Celebration</h1>
          <p class="lead">Birthdays, Parties, Corporate Events — all in one place</p>

        </div>
      </div>
    </div>

    <div class="carousel-item"
      style="height: 90vh; background: url('assets/images/banquet7.jpg') center center / cover no-repeat;">
      <div
        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(160, 0, 0, 0.18); z-index: 1;">
      </div>
      <div class="carousel-overlay d-flex align-items-center justify-content-center text-white text-center"
        style="background: rgba(0,0,0,0.5); height: 100%;">
        <div>
          <h1 class="display-4 fw-bold">Book Hassle-<span class="wedding">Free</span></h1>
          <p class="lead">Available slots, instant booking, no tension!</p>

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
<section class="sec-2 py-5  ">
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

<!--  TOP BANQUETS-->
<section id="banquet-list" class="py-5 bg-light sec-2">
  <h2 class="text-center mb-5 fw-bold text-dark">Our Top Banquets</h2>
  <div class="container">
    <div class="row g-4">
      <?php while ($banquet_row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        ?>
        <!-- Card Container -->
        <div class="col-md-4 mb-4">
          <a href="users/booking_page.php?id=<?php echo $banquet_row['id']; ?>" class="nav-link">


            <div class="card banquet-card shadow-sm border-0 rounded-4 overflow-hidden">

              <!-- Image -->
              <img src="<?php echo $banquet_row['image']; ?>" class="card-img-top"
                style="height: 180px; object-fit: cover;" alt="Banquet Image">

              <!-- Card Body -->
              <div class="card-body">
                <h5 class="fw-semibold mb-1">
                  <?php echo $banquet_row["name"] . " | " . $banquet_row["location"]; ?><span> | Banquet
                  </span>
                </h5>

                <p class="card-text mb-2">Starting From Rs. <?php echo $banquet_row["price"]; ?></p>

                <p><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"><i class="fa-solid fa-star"></i></i><i
                    class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><span></space>
                </p>


              </div>

            </div>
          </a>
        </div>


      <?php } ?>
      <a href="users/listed_banquets.php" style="font-size: 18px; color: goldenrod;"
        class="text-center nav-link py-3">View All <i class="bi bi-arrow-right-circle"></i></a>
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
    <h2 class="text-center fw-bold text-dark mb-5 ">Our Valued Guests</h2>
    <div class="row text-center align-items-stretch g-5">

      <!-- Testimonial 1 -->
      <div class="col-md-4">
        <div class="d-flex flex-column align-items-center">

          <!-- Text -->
          <blockquote class="fst-italic text-muted px-3">
            “Booked a banquet for my sister's wedding — and everything was perfect. Highly recommended!”
          </blockquote>
          <h5 class="fw-bold mt-2">Ali Raza</h5>
          <div class="text-warning fs-5">★★★★★</div>
        </div>
      </div>

      <!-- Testimonial 2 -->
      <div class="col-md-4">
        <div class="d-flex flex-column align-items-center">

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





<!-- Feedback Section -->
<section class="feedback-section d-flex align-items-center justify-content-center ">
  <div class="container py-5">
    <?php
    if (isset($_SESSION["success"])): ?>
      <small class="alert alert-success">
        <?php echo $_SESSION["success"];
        unset($_SESSION["success"]); ?>
      </small>
    <?php elseif (isset($_SESSION["error"])): ?>
      <small class="alert alert-danger">
        <?php echo $_SESSION["error"];
        unset($_SESSION["error"]); ?>
      </small>
    <?php endif;
    ?>
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-9">
        <!-- Heading -->
        <h2 class="mb-3 text-center fw-bold text-dark"> Share Your Feedback</h2>
        <p class="text-muted text-center mb-4">
          Your feedback is <span class="fw-semibold text-warning">very important</span> to us.
        </p>

        <!-- Form -->
        <form id="feedbackForm" method="POST" action="feedback_insert.php" novalidate>
          <div class="row mb-3">
            <!-- Name -->
            <div class="col-md-6">
              <label for="name" class="form-label fw-semibold">Name</label>
              <input type="text" class="form-control rounded-3 shadow-sm" name="name" placeholder="Your Name">
            </div>

            <!-- Email -->
            <div class="col-md-6">
              <label for="email" class="form-label fw-semibold">Email</label>
              <input type="email" class="form-control rounded-3 shadow-sm" name="email" placeholder="name@example.com">

            </div>
          </div>

          <!-- Rating -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Rating</label>
            <div class="rating d-flex flex-row-reverse justify-content-start gap-1 fs-3">
              <input type="radio" id="star5" name="rating" value="5"><label for="star5" title="5 stars">★</label>
              <input type="radio" id="star4" name="rating" value="4"><label for="star4" title="4 stars">★</label>
              <input type="radio" id="star3" name="rating" value="3"><label for="star3" title="3 stars">★</label>
              <input type="radio" id="star2" name="rating" value="2"><label for="star2" title="2 stars">★</label>
              <input type="radio" id="star1" name="rating" value="1"><label for="star1" title="1 star">★</label>
            </div>

          </div>

          <!-- Feedback -->
          <div class="mb-3">
            <label for="message" class="form-label fw-semibold">Feedback</label>
            <textarea class="form-control rounded-3 shadow-sm" name="message" rows="4"
              placeholder="Write your feedback here..."></textarea>
          </div>

          <!-- Buttons -->
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <button type="submit" name="feedback_submit" style="background-color: goldenrod;"
              class="btn  rounded-3">Send</button>

          </div>
        </form>


      </div>
    </div>
  </div>
</section>

<style>
  /* Professionally Redesigned Feedback Section */
  .feedback-section {
    height: auto;
    /* Adjust height dynamically */
    padding: 40px 0;
  }

  .form-control {
    border: 1px solid #ced4da;
    box-shadow: none;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
  }

  .form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 5px rgba(255, 193, 7, 0.5);
  }

  .rating {
    display: flex;
    align-items: center;
    /* Align stars vertically with the label */
    gap: 5px;
    /* Add spacing between stars */
  }

  .rating input {
    display: none;
    /* Hide radio buttons */
  }

  .rating label {
    color: #ccc;
    cursor: pointer;
    transition: color 0.2s ease;
    font-size: 1.5rem;
    /* Adjust star size */
    margin: 0;
    /* Remove extra margin */
  }

  .rating input:checked~label,
  .rating label:hover,
  .rating label:hover~label {
    color: #ffc107;
  }
</style>


<!-- Floating Review Button -->
<button id="reviewBtn" title="Leave a Review" style="background-color: maroon;">
  ⭐
</button>

<!-- Confetti Script -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

<script>
  document.getElementById("reviewBtn").addEventListener("click", function () {
    // Confetti animation
    confetti({
      particleCount: 300,
      spread: 150,
      origin: { y: 0.6 }
    });


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
    left: 20px;
    /* 👈 left side */
    bottom: 30px;
    /* bottom distance */
    width: 45px;
    height: 45px;
    border: none;
    border-radius: 50%;
    background: #777;
    /* gray background */
    color: #fff;
    font-size: 18px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    display: none;
    /* hidden by default */
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    z-index: 9999;
  }

  #scrollTopBtn:hover {
    transform: scale(1.15);
    background: #555;
    /* darker gray on hover */
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
    right: 20px;
    /* right side distance */
    bottom: 100px;
    /* bottom se distance */
    width: 50px;
    height: 50px;
    border: none;
    border-radius: 50%;
    background: #ff4081;
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
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
  (function () {
    const form = document.getElementById('feedbackForm');
    const ratingFeedback = document.getElementById('ratingFeedback');

    if (!form) return;

    form.addEventListener('submit', function (e) {
      const rating = form.querySelector('input[name="rating"]:checked');

      // Agar invalid ho to prevent aur show errors
      if (!form.checkValidity() || !rating) {
        e.preventDefault();
        e.stopPropagation();
        form.classList.add('was-validated');

        if (!rating) {
          ratingFeedback.style.display = 'block';
        } else {
          ratingFeedback.style.display = 'none';
        }
        return;
      }

      // Agar sab theek ho to koi preventDefault nahi — normal POST server ko jayega
    }, false);
  })();
</script>





<?php
include '../Banquet_booking/includes/footer.php';

?>