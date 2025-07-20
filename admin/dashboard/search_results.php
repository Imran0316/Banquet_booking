<?php
include("../../db.php"); // database connection
include("include/header.php");
include("include/sidebar.php");

$query = isset($_GET['query']) ? trim($_GET['query']) : '';
?>

<div class="content">
  <?php include("include/navbar.php"); ?>

  <div class="container-fluid px-4 mt-4">
    <h4 class="mb-4 text-primary">Search Results for: <span class="text-dark"><?php echo htmlspecialchars($query); ?></span></h4>

    <?php
    if (!empty($query)) {
        $stmt = $pdo->prepare("
            SELECT banquets.*, banquet_owner.name AS owner_name, banquet_owner.email AS owner_email
            FROM banquets 
            JOIN banquet_owner ON banquets.owner_id = banquet_owner.id
            WHERE banquets.name LIKE ? 
               OR banquets.location LIKE ? 
               OR banquet_owner.name LIKE ?
               OR banquet_owner.email LIKE ?
        ");
        $searchTerm = "%$query%";
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm,$searchTerm]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($results) > 0): ?>
            <div class="row">
              <?php foreach ($results as $row): ?>
                <div class="col-md-4 mb-4">
                  <div class="card shadow-sm h-100">
                    <img src='../../uploads<?php echo $row["image"]; ?>' class="card-img-top" height="200" style="object-fit: cover;" alt="Banquet Image">
                    <div class="card-body">
                      <h5 class="card-title"><?php echo htmlspecialchars($row["name"]); ?></h5>
                      <p class="card-text small mb-1 text-muted">📍 <?php echo htmlspecialchars($row["location"]); ?></p>
                      <p class="card-text small">👤 Owner: <?php echo htmlspecialchars($row["owner_name"]); ?></p>
                      <a href="banquet_details.php?id=<?php echo $row["id"]; ?>" class="btn btn-sm btn-outline-primary mt-2">View Details</a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">No results found.</div>
        <?php endif;
    } else {
        echo "<div class='alert alert-info'>Please enter a search term.</div>";
    }
    ?>
  </div>
</div>

<?php include("include/footer.php"); ?>
