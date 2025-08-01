<?php
// session_start();
// include("../db.php");
// $banquet_id=$_GET["id"];
// if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit_booking"])){
// $userId= $_POST["userID"];
// $date= $_POST["event_date"];
// $gunquetId= $_POST["banquetID"];
// $timeslot = $_POST["time_slot"];
// $guests= $_POST["guests"];
// $event_type= $_POST["event_type"];

// $stmt = $pdo->prepare("INSERT INTO `bookings`(`user_id`, `banquet_id`, `date`, `time_slot`, `guests`, `event_type`,  `created_at`) VALUES (?,?,?,?,?,?,NOW())");
// $submited = $stmt->execute([$userId,$banquet_id,$date,$timeslot,$guests,$event_type]);
// if($submited){
//   $_SESSION["success"] = "BOOKING REQUEST SUBMIT!";
//   header("Location: booking_page.php?id=$banquet_id");
//   exit();
// }else{
// $_SESSION["error"] = "BOOKING REQUEST ERORR!";
//   header("Location: booking_page.php?id=$banquet_id");
//   exit();
// }
// }
?>