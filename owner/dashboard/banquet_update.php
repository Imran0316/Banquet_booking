<?php
session_start();
include("../../db.php");

$banquet_id = $_GET["id"];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["banquet_update"])) {
    $banquet_name = $_POST["banquet_name"];
    $location = $_POST["location"];
    $capacity = $_POST["capacity"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    
    // Get the old image from DB
    $stmt = $pdo->prepare("SELECT image FROM banquets WHERE id = ?");
    $stmt->execute([$banquet_id]);
    $oldData = $stmt->fetch(PDO::FETCH_ASSOC);
    $oldImage = $oldData['image'];

    $newImagePath = $oldImage; // Default image remains same

    // --- Cover Image Update ---
    if (!empty($_FILES["cover_image"]["name"])) {
        $targetDir = "../../uploads/";
        $fileName = basename($_FILES["cover_image"]["name"]);
        $newImageName = time() . "_" . $fileName;
        $targetFile = $targetDir . $newImageName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $AllowedTypes = ['jpg', 'jpeg', 'gif', 'png'];

        if (in_array($imageFileType, $AllowedTypes)) {
            if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $targetFile)) {
                // Delete old image
                if (!empty($oldImage) && file_exists($oldImage)) {
                    unlink($oldImage);
                }
                $newImagePath = $targetFile;
            } else {
                $_SESSION['error'] = "Image upload failed";
                header("Location: edit_banquet.php?id=$banquet_id");
                exit();
            }
        } else {
            $_SESSION['error'] = "Only JPG, JPEG, PNG, GIF files allowed";
            header("Location: edit_banquet.php?id=$banquet_id");
            exit();
        }
    }

    // --- Gallery Images Upload ---
    if (isset($_FILES["gallery_images"]) && !empty($_FILES["gallery_images"]["name"][0])) {
        $galleryImages = $_FILES["gallery_images"];
        $imagesCount = count($galleryImages["name"]);
        for ($i = 0; $i < $imagesCount; $i++) {
            if ($galleryImages["error"][$i] === 0) {
                $galleryImageName = time() . "_" . rand(1000, 9999) . "_" . basename($galleryImages["name"][$i]);
                $targetPath = "../../uploads/" . $galleryImageName;
                $imageFileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
                $AllowedTypes = ['jpg', 'jpeg', 'gif', 'png'];
                if (in_array($imageFileType, $AllowedTypes)) {
                    if (move_uploaded_file($galleryImages["tmp_name"][$i], $targetPath)) {
                        // INSERT INTO banquet_images TABLE
                        $stmt2 = $pdo->prepare("INSERT INTO `banquet_images` (`banquet_id`, `image`, `uploaded_at`) VALUES (?, ?, NOW())");
                        $stmt2->execute([$banquet_id, $galleryImageName]);
                    }
                }
            }
        }
    }

    // Update Query
    $stmt = $pdo->prepare("UPDATE banquets SET name = ?, location = ?, capacity = ?, price = ?, description = ?, image = ? WHERE id = ?");
    $stmt->execute([$banquet_name, $location, $capacity, $price, $description, $newImagePath, $banquet_id]);

    $_SESSION["success"] = "Updated successfully";
    header("Location: edit_banquet.php?id=$banquet_id");
    exit();
}
?>
