<?php
session_start();
include("../../db.php");
include("include/header.php");
include("include/sidebar.php");

// Assuming ?id=owner_id is passed
$owner_id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM banquet_owner WHERE id = ?");
$stmt->execute([$owner_id]);
$owner = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="content">
    <?php include("include/navbar.php"); ?>

    <div class="container-fluid mt-4">
        <div class="card shadow rounded-4">
            <div class="card-body p-4">
                <h4 class="mb-3 text-primary">👤 Owner Profile</h4>

                <!-- Tabs -->
                <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic"
                            type="button" role="tab">Basic Info</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="banquets-tab" data-bs-toggle="tab" data-bs-target="#banquets"
                            type="button" role="tab">Banquets</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity"
                            type="button" role="tab">Activity</button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content mt-3" id="profileTabsContent">
                    <!-- Basic Info -->
                    <form action="update_owner_profile.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="owner_id" value="<?php echo $owner['id']; ?>">

                        <div class="row g-3">
                            <!-- Profile Image -->
                            <div class="col-md-12 text-center">
                                <img src="../../uploads<?php echo $owner['owner_image']; ?>" alt="Profile Image" width="120"
                                    height="120" class="rounded-circle mb-2" style="object-fit: cover;">
                                <div>
                                    <input type="file" name="image" class="form-control-sm">
                                </div>
                            </div>

                            <!-- Name -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Name</label>
                                <input type="text" class="form-control" name="name"
                                    value="<?php echo $owner['name']; ?>" required>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control" name="email"
                                    value="<?php echo $owner['email']; ?>" required>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Phone</label>
                                <input type="text" class="form-control" name="phone"
                                    value="<?php echo $owner['phone']; ?>" required>
                            </div>

                            <!-- Status (Read-only) -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Status</label>
                                <input type="text" class="form-control"
                                    value="<?php echo ($owner['status'] == 'approved') ? 'Approved' : 'Pending'; ?>"
                                    readonly>
                            </div>

                            <!-- Created At (Read-only) -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Created At</label>
                                <input type="text" class="form-control" value="<?php echo $owner['created_at']; ?>"
                                    readonly>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12">
                                <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                            </div>
                        </div>
                    </form>

                    <!-- Banquets -->
                    <div class="tab-pane fade" id="banquets" role="tabpanel">
                        <div class="mt-3">
                            <?php
              $stmt = $pdo->prepare("SELECT * FROM banquets WHERE owner_id = ?");
              $stmt->execute([$owner_id]);
              $banquets = $stmt->fetchAll(PDO::FETCH_ASSOC);

              if ($banquets): ?>
                            <div class="row">
                                <?php foreach ($banquets as $b): ?>
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 shadow-sm border">
                                        <img src="../../uploads<?php echo $b['image']; ?>" class="card-img-top"
                                            height="180" style="object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo htmlspecialchars($b['name']); ?></h5>
                                            <p class="text-muted mb-1">📍
                                                <?php echo htmlspecialchars($b['location']); ?></p>
                                            <p>💰 PKR <?php echo number_format($b['price']); ?></p>
                                            <a href="edit_banquet.php?id=<?php echo $b['id']; ?>"
                                                class="btn btn-sm btn-outline-primary">View</a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php else: ?>
                            <div class="alert alert-info">No banquets found for this owner.</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Activity (Placeholder) -->
                    <div class="tab-pane fade" id="activity" role="tabpanel">
                        <div class="mt-3">
                            <p class="text-muted">Activity logs, bookings, or changes will appear here.</p>
                            <div class="alert alert-secondary">Coming soon...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include("include/footer.php"); ?>