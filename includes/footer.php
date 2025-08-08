<footer class="bg-dark text-white pt-5 pb-4">
  <style>
    .footer-link:hover {
      color: #f9b233 !important;
      text-decoration: underline;
    }
    .social-icon {
      font-size: 18px;
      transition: 0.3s ease;
    }
    .social-icon:hover {
      color: #f9b233 !important;
      transform: scale(1.2);
    }
    .footer-title {
      color: #f9b233;
    }
    .text-light-muted {
      color: #cccccc;
    }
  </style>

  <div class="container">
    <div class="row g-4">

      <!-- Logo & Description -->
      <div class="col-md-3 col-sm-6">
        <h5 class="footer-title fw-bold">Mera ShadiHall</h5>
        <p class="text-light-muted">Book premium wedding & event venues with trust, ease, and elegance.</p>
      </div>

      <!-- Quick Links -->
      <div class="col-md-3 col-sm-6">
        <h6 class="fw-semibold mb-3 footer-title">Quick Links</h6>
        <ul class="list-unstyled">
          <li><a href="index.php" class="text-white footer-link">Home</a></li>
          <li><a href="banquet_list.php" class="text-white footer-link">Banquets</a></li>
          <li><a href="login.php" class="text-white footer-link">Login</a></li>
          <li><a href="register.php" class="text-white footer-link">Register</a></li>
        </ul>
      </div>

      <!-- For Owners -->
      <div class="col-md-3 col-sm-6">
        <h6 class="fw-semibold mb-3 footer-title">For Owners</h6>
        <ul class="list-unstyled">
          <li><a href="owner_register.php" class="text-white footer-link">List Your Banquet</a></li>
          <li><a href="owner_login.php" class="text-white footer-link">Owner Login</a></li>
          <li><a href="admin_login.php" class="text-white footer-link">Admin Panel</a></li>
        </ul>
      </div>

      <!-- Contact & Social -->
      <div class="col-md-3 col-sm-6">
        <h6 class="fw-semibold mb-3 footer-title">Contact Us</h6>
        <p class="mb-1"><i class="fa fa-phone me-2"></i>+92 300 1234567</p>
        <p><i class="fa fa-envelope me-2"></i>info@merashadihall.com</p>
        <div class="mt-2">
          <a href="#" class="text-white me-3 social-icon"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="text-white me-3 social-icon"><i class="fab fa-instagram"></i></a>
          <a href="#" class="text-white social-icon"><i class="fab fa-twitter"></i></a>
        </div>
      </div>

    </div>

    <hr class="border-secondary mt-4">
    <p class="text-center text-light-muted mb-0">© 2025 Mera ShadiHall. All rights reserved.</p>
  </div>
</footer>




<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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





</body>

</html>