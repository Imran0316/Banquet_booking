<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $banquet_id = $_POST['banquet_id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $price_per_head = $_POST['price_per_head'];
  $min_guests = $_POST['min_guests'];
  $status = $_POST['status'];

  $stmt = $conn->prepare("INSERT INTO catering (banquet_id, title, price_per_head, min_guests, status) 
                          VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$banquet_id, $title, $price_per_head, $min_guests, $status]);

  header("Location: catering_list.php?msg=added");
  exit;
}
