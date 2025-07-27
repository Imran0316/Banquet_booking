<?php
include("../../db.php");
$owner_id = $_GET['id'] ?? 0;

// Get owner image
$stmt = $pdo->prepare("SELECT owner_image FROM banquet_owner WHERE id = ?");
$stmt->execute([$owner_id]);
$owner = $stmt->fetch(PDO::FETCH_ASSOC);

if (!empty($owner['owner_image']) && file_exists('../../uploads/' . $owner['owner_image'])) {
    unlink('../../uploads/' . $owner['owner_image']);
}

// Delete owner from DB
$stmt = $pdo->prepare("DELETE FROM banquet_owner WHERE id = ?");
$stmt->execute([$owner_id]);

$_SESSION['success'] = "Owner and image deleted successfully.";
header("Location: manage_owners.php");
exit;
?>