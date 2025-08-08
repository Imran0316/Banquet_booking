<?php
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $banquet_id = $_POST['banquet_id'];
  $owner_id = $_POST['owner_id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $price_per_head = $_POST['price_per_head'];
  $min_guests = $_POST['min_guests'];
  $status = $_POST['status'];

  $stmt = $pdo->prepare("INSERT INTO catering_services (banquet_id, owner_id, title, description ,price_per_head, min_guests, status) 
                          VALUES (?, ? ,?,?, ?, ?, ?)");
  $stmt->execute([$banquet_id,$owner_id, $title, $description, $price_per_head, $min_guests, $status]);

  header("Location: catering_list.php?msg=added");
  exit;
}