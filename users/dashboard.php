<?php
session_start();
include '../db.php';
include '../includes/header.php';
?>

<p> welcome <?php echo $_SESSION['name']; ?> </p>

