<?php
session_start();
// ensure user logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}
$page = "inner";
include("../db.php");
include 'include/header.php';
include 'include/navbar.php';

$userId = $_SESSION['id'] ?? null;
$stmt = $pdo->prepare("
    SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT bookings.*,
banquets.name AS banquet_name 
    FROM bookings
    JOIN banquets ON bookings.banquet_id = banquets.id
    WHERE bookings.user_id = ?
");
$stmt->execute(params: [$userId]);
$bookings = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<style>
    .card {
        background: rgba(255, 255, 255, 0.8);
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
</style>
<div class="container py-5">
    <div class="row">
        <!-- Left Sidebar -->
        <div class="col-md-3">
            <div class="list-group mt-4">
                <div class="card p-3 text-center">
                    <h5><?php echo $userData["name"]; ?></h5>
                    <p class="text-muted mb-1"><?php echo $userData["email"] ?></p>
                    <p class="text-muted"><?php echo $userData["phone"] ?></p>
                    <button href="#edit" class="btn btn-sm btn-outline-primary list-group-item list-group-item-action"
                        data-bs-toggle="tab">Edit Profile</button>
                </div>

                <a href="#profile" class="list-group-item list-group-item-action active" data-bs-toggle="tab">👤 Profile
                    Info</a>
                <a href="#bookings" class="list-group-item list-group-item-action" data-bs-toggle="tab">📖 My
                    Bookings</a>
                <a href="#settings" class="list-group-item list-group-item-action" data-bs-toggle="tab">⚙️ Settings</a>
            </div>
        </div>

        <!-- Right Content -->
        <div class="col-md-9">
            <?php if (isset($_SESSION["success"])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION["success"];
                    unset($_SESSION["success"]); ?>
                </div>
            <?php elseif (isset($_SESSION["error"])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION["error"];
                    unset($_SESSION["error"]); ?>
                </div>
            <?php endif; ?>
            <div class="tab-content">
                <!--Edit Profile -->
                <div class="tab-pane fade show " id="edit">
                    <div class="card p-3">

                        <h5> Edit Profile </h5>
                        <form action="edit_profile.php" Method="post">
                            input
                            <input type="text" name="name" class="form-control mb-2" placeholder="Name"
                                value="<?php echo $userData['name']; ?>">
                            <input type="email" name="email" class="form-control mb-2" placeholder="Email"
                                value="<?php echo $userData['email']; ?>">
                            <input type="text" name="phone" class="form-control mb-2" placeholder="Phone"
                                value="<?php echo $userData['phone']; ?>">
                            <input type="submit" value="Save Changes" name="update" class="btn btn-primary">
                        </form>
                    </div>
                </div>
                <!-- Profile Info -->
                <div class="tab-pane fade show active" id="profile">
                    <div class="card p-3">
                        <h5>Profile Information</h5>
                        <p><strong>Name:</strong> <?php echo $userData["name"] ?></p>
                        <p><strong>Email:</strong> <?php echo $userData["email"] ?></p>
                        <p><strong>Phone:</strong> <?php echo $userData["phone"] ?></p>
                    </div>
                </div>

                <!-- My Bookings -->
                <div class="tab-pane fade" id="bookings">
                    <div class="card p-3">
                        <h5>My Bookings</h5>
                        <div class="border rounded p-3 mb-3">
                            <h6><?php echo $bookings["banquet_name"] ?></h6>
                            <p><?php echo $bookings["date"] . " | " . $bookings["time_slot"] ?></p>
                            <span class="badge bg-danger"><?php echo $bookings["status"] ?></span>
                        </div>
                    </div>
                </div>

                <!-- Settings -->
                <div class="tab-pane fade" id="settings">
                    <div class="card p-3">
                        <h5>Account Settings</h5>

                    </div>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        Change Password
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 rounded-3 shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="change_password.php" method="POST">

                    <!-- Current Password -->
                    <div class="mb-3 position-relative">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" name="current_password"
                            required>
                        <span class="toggle-password" onclick="togglePassword('currentPassword', this)"><i
                                class="bi bi-eye"></i></span>
                    </div>

                    <!-- New Password -->
                    <div class="mb-3 position-relative">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="new_password" required>
                        <span class="toggle-password" onclick="togglePassword('newPassword', this)"><i
                                class="bi bi-eye"></i></span>
                    </div>

                    <!-- Confirm New Password -->
                    <div class="mb-3 position-relative">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirm_password"
                            required>
                        <span class="toggle-password" onclick="togglePassword('confirmPassword', this)"><i
                                class="bi bi-eye"></i></span>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" name="update_password" class="btn btn-primary">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
include '../includes/footer.php';
?>
<script>
    function togglePassword(inputId, el) {
        const input = document.getElementById(inputId);
        const icon = el.querySelector("i");

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    }
</script>


<!-- CSS -->
<style>
    .toggle-password {
        position: absolute;
        top: 38px;
        right: 12px;
        cursor: pointer;
        user-select: none;
    }
</style>