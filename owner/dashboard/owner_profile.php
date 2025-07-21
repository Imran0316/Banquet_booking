<?php
session_start();
include("../../db.php");
include("include/header.php");
include("include/sidebar.php");

$owner_id = $_GET['id'] ?? 0;
// $owner_id = $_SESSION["owner_id"] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM banquet_owner WHERE id = ?");
$stmt->execute([$owner_id]);
$owner_data = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="content">
  <?php include("include/navbar.php"); ?>

  <div class="container-fluid mt-4">
    <div class="row justify-content-center">
      <!-- Left: Profile Info -->
      <div class="col-lg-5 mb-4">
        <div class="card shadow-lg rounded-4 border-0" style="max-width: 650px; background: #fff5f7;">
          <div class="card-body p-4">
            <h4 class="mb-4 text-center fw-bold" style="color:#800000;">Banquet Owner Profile</h4>

            <!-- Profile Image Edit -->
            <form action="update_owner_profile.php" method="POST" enctype="multipart/form-data" id="profileForm">
              <input type="hidden" name="owner_id" value="<?php echo $owner_data['id']; ?>">
              <div class="text-center mb-4 position-relative">
                <div style="display:inline-block; position:relative;">
                  <img id="profileImgPreview"
                    src="<?php echo $owner_data['owner_image'] ? '../../uploads/' . $owner_data['owner_image'] : 'https://ui-avatars.com/api/?name=' . urlencode($owner_data['name']); ?>"
                    class="rounded-circle border border-3"
                    style="width:130px;height:130px;object-fit:cover;background:#fff;">
                  <label for="profileImgInput" class="position-absolute" style="bottom:10px;right:10px;cursor:pointer;">
                    <span class="bg-maroon text-white rounded-circle p-2 border shadow" style="font-size:16px;">
                      <i class="fa fa-pen"></i>
                    </span>
                  </label>
                  <input type="file" name="image" id="profileImgInput" class="d-none" accept="image/*">
                </div>
                <h5 class="mt-3 mb-0 fw-bold" style="color:#800000;"><?php echo htmlspecialchars($owner_data['name']); ?>
                </h5>
                <span
                  class="badge bg-maroon text-white px-3 py-1"><?php echo ($owner_data["status"] == 'approved') ? 'Approved' : 'Pending'; ?></span>
                <div class="mt-1 text-muted" style="font-size:13px;">Joined:
                  <?php echo date('d M Y', strtotime($owner_data['created_at'])); ?>
                </div>
              </div>

              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label fw-bold"><i class="fa fa-user me-1"></i> Name</label>
                  <input type="text" class="form-control rounded-pill" name="name"
                    value="<?php echo htmlspecialchars($owner_data['name']); ?>" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold"><i class="fa fa-envelope me-1"></i> Email</label>
                  <input type="email" class="form-control rounded-pill" name="email"
                    value="<?php echo htmlspecialchars($owner_data['email']); ?>" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold"><i class="fa fa-phone me-1"></i> Phone</label>
                  <input type="text" class="form-control rounded-pill" name="phone"
                    value="<?php echo htmlspecialchars($owner_data['phone']); ?>" required>
                </div>
                <div class="col-12 mt-3">
                  <button type="submit" name="update_profile" class="btn w-100 py-2 fw-bold rounded-pill"
                    style="background:linear-gradient(90deg,#800000,#b71c1c);color:#fff;">Update Profile</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Right: Tabs -->
      <div class="col-lg-7">
        <!-- Tabs -->
        <ul class="nav nav-tabs mt-4" id="profileTabs" role="tablist" style="border-bottom:2px solid #800000;">

          <li class="nav-item">
            <button class="nav-link active fw-bold" id="banquets-tab" data-bs-toggle="tab" data-bs-target="#banquets"
              type="button" role="tab" style="color:#800000;">Banquets</button>
          </li>
          <li class="nav-item">
            <button class="nav-link fw-bold" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity"
              type="button" role="tab" style="color:#800000;">Activity</button>
          </li>
        </ul>

        <div class="tab-content mt-3" id="profileTabsContent">


          <!-- Banquets Tab -->
          <div class="tab-pane fade show active" id="banquets" role="tabpanel">
            <div class="mt-3">
              <?php
              $stmt = $pdo->prepare("SELECT * FROM banquets WHERE owner_id = ?");
              $stmt->execute([$owner_id]);
              $banquets = $stmt->fetchAll(PDO::FETCH_ASSOC);

              if ($banquets): ?>
                <div class="row">
                  <?php foreach ($banquets as $b): ?>
                    <div class="col-md-6 mb-4">
                      <div class="card h-100 shadow border-0" style="background:#fff0f0;">
                        <img src="../../uploads<?php echo $b['image']; ?>" class="card-img-top rounded-top" height="160"
                          style="object-fit:cover;">
                        <div class="card-body">
                          <h5 class="card-title fw-bold" style="color:#800000;"><?php echo htmlspecialchars($b['name']); ?>
                          </h5>
                          <p class="text-muted mb-1"><i class="fa fa-map-marker-alt me-1"></i>
                            <?php echo htmlspecialchars($b['location']); ?></p>
                          <p class="mb-2"><span class="badge bg-maroon">PKR <?php echo number_format($b['price']); ?></span>
                          </p>
                          <a href="edit_banquet.php?id=<?php echo $b['id']; ?>"
                            class="btn btn-sm btn-outline-maroon rounded-pill">View</a>
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

          <!-- Activity Tab -->
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

<!-- Maroon Theme Styles & Image Preview JS -->
<style>
  .bg-maroon {
    background: #800000 !important;
  }

  .text-maroon {
    color: #800000 !important;
  }

  .text-gold {
    color: #DAA520 !important;
  }

  .bg-gold {
    background: #DAA520 !important;
  }

  .btn-outline-maroon {
    border: 1.5px solid #DAA520;
    color: #800000;
  }

  .btn-outline-maroon:hover {
    background: #DAA520;
    color: #fff;
    border-color: #800000;
  }

  .card {
    border-radius: 1.5rem !important;
    border: 2px solid #DAA52044 !important;
    box-shadow: 0 4px 24px #DAA52022;
  }

  input[type="file"] {
    display: none;
  }

  .badge.bg-maroon {
    background: linear-gradient(90deg, #800000, #DAA520) !important;
    color: #fff !important;
    font-weight: 500;
    letter-spacing: 1px;
  }

  .badge.bg-gold {
    background: linear-gradient(90deg, #DAA520, #800000) !important;
    color: #fff !important;
    font-weight: 500;
    letter-spacing: 1px;
  }

  .nav-tabs .nav-link.active {
    background: linear-gradient(90deg, #80000022, #DAA52022);
    color: #800000 !important;
    border-bottom: 3px solid #DAA520 !important;
    font-weight: bold;
  }

  .nav-tabs .nav-link {
    color: #800000 !important;
    font-weight: 500;
    border-radius: 8px 8px 0 0;
    margin-right: 4px;
    transition: background 0.2s;
  }

  .nav-tabs .nav-link:hover {
    background: #fffbe6;
    color: #DAA520 !important;
  }

  .btn-outline-maroon {
    border: 1.5px solid #DAA520;
    color: #800000;
    font-weight: 500;
  }

  .btn-outline-maroon:hover {
    background: linear-gradient(90deg, #DAA520, #800000);
    color: #fff;
    border-color: #800000;
  }
</style>
<script>
  document.getElementById('profileImgInput').addEventListener('change', function (e) {
    const [file] = e.target.files;
    if (file) {
      document.getElementById('profileImgPreview').src = URL.createObjectURL(file);
    }
  });
</script>

<?php include("include/footer.php"); ?>