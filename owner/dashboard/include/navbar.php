<?php
include("../../db.php");

$owner_id = $_SESSION['owner_id'];
$stmt = $pdo->prepare("SELECT owner_image FROM banquet_owner WHERE id = ?");
$stmt->execute([$owner_id]);
$owner = $stmt->fetch(PDO::FETCH_ASSOC);
$owner_img = !empty($owner['owner_image']) ? '../../uploads/' . $owner['owner_image'] : 'img/user.jpg';
?>
<nav class="navbar navbar-expand bg-white navbar-light sticky-top px-4 py-2 shadow-sm">
    <a href="index.php" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="mb-0" style="background: linear-gradient(45deg, #800000, #DAA520); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            <i class="fas fa-hotel"></i>
        </h2>
    </a>
    
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars" style="color: #800000;"></i>
    </a>
    
    <form class="d-none d-md-flex ms-4">
        <div class="input-group border rounded-pill overflow-hidden bg-light">
            <input class="form-control border-0 bg-transparent ps-4" type="search" placeholder="Search...">
            <button class="btn px-4" type="submit" style="background: linear-gradient(45deg, #800000, #DAA520);">
                <i class="fa fa-search text-white"></i>
            </button>
        </div>
    </form>
    
    <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle position-relative" data-bs-toggle="dropdown">
                <i class="fa fa-envelope me-lg-2" style="color: #800000;"></i>
                <span class="d-none d-lg-inline-flex text-dark">Messages</span>
                <!-- <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" 
                      style="background: #DAA520; margin-top: -5px; margin-left: -15px;">
                    3
                </span> -->
            </a>
            <div class="dropdown-menu dropdown-menu-end border-0 rounded-3 shadow-sm py-0 overflow-hidden" style="width: 300px;">
                <div class="p-3" style="background: linear-gradient(45deg, #800000, #DAA520);">
                    <h6 class="mb-0 text-white">Messages</h6>
                </div>
                <div class="bg-white">
                    <a href="#" class="dropdown-item p-3 border-bottom transition-hover">
                        <div class="d-flex align-items-center">
                            <img class="rounded-circle shadow-sm" src="img/user.jpg" alt="" style="width: 45px; height: 45px; object-fit: cover;">
                            <div class="ms-3">
                                <h6 class="fw-bold mb-1" style="color: #800000;">John Doe</h6>
                                <span class="text-muted small">15 minutes ago</span>
                                <p class="text-muted small mb-0">How are you doing?...</p>
                            </div>
                        </div>
                    </a>
                    <!-- Repeat for other messages -->
                    <a href="#" class="dropdown-item text-center p-3 bg-light">
                        <span class="text-dark">View All Messages</span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="nav-item dropdown ms-3">
            <a href="#" class="nav-link dropdown-toggle position-relative" data-bs-toggle="dropdown">
                <i class="fa fa-bell me-lg-2" style="color: #800000;"></i>
                <span class="d-none d-lg-inline-flex text-dark">Notifications</span>
                <!-- <span class="position badge circle" 
                      style="background: #DAA520; margin-top: -5px; margin-left: -15px;">
                    5
                </span> -->
            </a>
            <div class="dropdown-menu dropdown-menu-end border-0 rounded-3 shadow-sm py-0 overflow-hidden" style="width: 300px;">
                <div class="p-3" style="background: linear-gradient(45deg, #800000, #DAA520);">
                    <h6 class="mb-0 text-white">Notifications</h6>
                </div>
                <div class="bg-white">
                    <a href="#" class="dropdown-item p-3 border-bottom transition-hover">
                        <h6 class="fw-bold mb-1" style="color: #800000;">Profile updated</h6>
                        <span class="text-muted small">15 minutes ago</span>
                    </a>
                    <!-- Repeat for other notifications -->
                    <a href="#" class="dropdown-item text-center p-3 bg-light">
                        <span class="text-dark">View All Notifications</span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="nav-item dropdown ms-3">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img class="rounded-circle border shadow-sm me-lg-2" src="<?php echo $owner_img; ?>" alt="" style="width: 45px; height: 45px; object-fit: cover;">
                <span class="d-none d-lg-inline-flex fw-bold" style="color: #800000;">
                    <?php echo $_SESSION["owner_name"]; ?>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end border-0 rounded-3 shadow-sm py-0 overflow-hidden">
                <div class="p-3" style="background: linear-gradient(45deg, #800000, #DAA520);">
                    <h6 class="mb-0 text-white">User Menu</h6>
                </div>
                <div class="bg-white">
                    <a href="owner_profile.php?id=<?php echo $_SESSION["owner_id"]; ?>" class="dropdown-item p-3 border-bottom">
                        <i class="fas fa-user-circle me-2" style="color: #800000;"></i>My Profile
                    </a>
                    <a href="#" class="dropdown-item p-3 border-bottom">
                        <i class="fas fa-cog me-2" style="color: #800000;"></i>Settings
                    </a>
                    <a href="../../logout.php" class="dropdown-item p-3">
                        <i class="fas fa-sign-out-alt me-2" style="color: #800000;"></i>Log Out
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->

<style>
.transition-hover:hover {
    background-color: #fff5f5;
    transition: all 0.3s ease;
}
.dropdown-menu {
    margin-top: 0.7rem !important;
}
.nav-link:hover {
    color: #800000 !important;
}
.badge {
    font-size: 0.65rem;
    padding: 0.35em 0.65em;
}
.input-group .btn {
    margin-left: 0 !important;
    border: 1px solid white;
}

.input-group input:focus {
    box-shadow: none;
    border-color: transparent;
}

.nav-link .badge {
    font-size: 0.65rem;
    min-width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
}
.navbar-expand{
    border-bottom: 1px solid #DAA520;
    
}
</style>