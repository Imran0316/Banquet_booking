  <!-- Navbar Start -->
  <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
      <a href="index.php" class="navbar-brand d-flex d-lg-none me-4">
          <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
      </a>
      <a href="#" class="sidebar-toggler flex-shrink-0">
          <i class="fa fa-bars"></i>
      </a>

      <form class="d-flex ms-auto" method="GET" action="search_results.php">
          <input class="form-control form-control-sm me-2" type="search" name="query" placeholder="Search..."
              aria-label="Search">
          <button class="btn btn-sm btn-outline-primary" type="submit">Search</button>
      </form>

      <div class="navbar-nav align-items-center ms-auto">
          <div class="nav-item dropdown">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                  <i class="fa fa-envelope me-lg-2"></i>
                  <span class="d-none d-lg-inline-flex">Message</span>
              </a>
              <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                  <a href="#" class="dropdown-item">
                      <div class="d-flex align-items-center">
                          <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                          <div class="ms-2">
                              <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                              <small>15 minutes ago</small>
                          </div>
                      </div>
                  </a>
                  <hr class="dropdown-divider">
                  <a href="#" class="dropdown-item">
                      <div class="d-flex align-items-center">
                          <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                          <div class="ms-2">
                              <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                              <small>15 minutes ago</small>
                          </div>
                      </div>
                  </a>
                  <hr class="dropdown-divider">
                  <a href="#" class="dropdown-item">
                      <div class="d-flex align-items-center">
                          <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                          <div class="ms-2">
                              <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                              <small>15 minutes ago</small>
                          </div>
                      </div>
                  </a>
                  <hr class="dropdown-divider">
                  <a href="#" class="dropdown-item text-center">See all message</a>
              </div>
          </div>
          <div class="nav-item dropdown">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                  <i class="fa fa-bell me-lg-2"></i>
                  <span class="d-none d-lg-inline-flex">Notificatin</span>
              </a>
              <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                  <a href="#" class="dropdown-item">
                      <h6 class="fw-normal mb-0">Profile updated</h6>
                      <small>15 minutes ago</small>
                  </a>
                  <hr class="dropdown-divider">
                  <a href="#" class="dropdown-item">
                      <h6 class="fw-normal mb-0">New user added</h6>
                      <small>15 minutes ago</small>
                  </a>
                  <hr class="dropdown-divider">
                  <a href="#" class="dropdown-item">
                      <h6 class="fw-normal mb-0">Password changed</h6>
                      <small>15 minutes ago</small>
                  </a>
                  <hr class="dropdown-divider">
                  <a href="#" class="dropdown-item text-center">See all notifications</a>
              </div>
          </div>
          <div class="nav-item dropdown">
              <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                  <img class="rounded-circle me-lg-2" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                  <span class="d-none d-lg-inline-flex">John Doe</span>
              </a>
              <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                  <a href="#" class="dropdown-item">My Profile</a>
                  <a href="#" class="dropdown-item">Settings</a>
                  <a href="../../logout.php" class="dropdown-item">Log Out</a>
              </div>
          </div>
      </div>
  </nav>
  <!-- Navbar End -->
   