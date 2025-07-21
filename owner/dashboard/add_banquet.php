<?php 
session_start();
include("../../db.php");
include("include/header.php");
include("include/sidebar.php");

$owner_id = $_SESSION["owner_id"];

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST["banquet_submit"])) {

    $Banquet_name = $_POST["banquet_name"];
    $location = $_POST["location"];
    $capacity = $_POST["capacity"];
    $price = $_POST["price"];
    $description = $_POST["description"];

    $targetDir = "../../uploads/";
    $fileName = basename($_FILES["cover_image"]["name"]);
    $targetFile = $targetDir . time() . "_" . $fileName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $Allowedtype = ['jpg', 'jpeg', 'gif', 'png'];

    if (in_array($imageFileType, $Allowedtype)) {
        if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $targetFile)) {

            // INSERT MAIN BANQUET DATA
            $stmt = $pdo->prepare("INSERT INTO `banquets` (`owner_id`, `name`, `location`, `capacity`, `price`, `description`, `image`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$owner_id, $Banquet_name, $location, $capacity, $price, $description, $targetFile]);

            // GET LAST INSERTED ID
            $banquet_id = $pdo->lastInsertId();

            // NOW HANDLE GALLERY IMAGES
            if (isset($_FILES["GalleryImages"])) {
                $galleryImages = $_FILES["GalleryImages"];
                $imagesCount = count($galleryImages["name"]);

                for ($i = 0; $i < $imagesCount; $i++) {
                    if ($galleryImages["error"][$i] === 0) {
                        $galleryImageName = time() . "_" . rand(1000, 9999) . "_" . basename($galleryImages["name"][$i]);
                        $targetPath = "../../uploads/" . $galleryImageName;

                        if (move_uploaded_file($galleryImages["tmp_name"][$i], $targetPath)) {
                            // INSERT INTO banquet_images TABLE
                            $stmt2 = $pdo->prepare("INSERT INTO `banquet_images` (`banquet_id`, `image`, `uploaded_at`) VALUES (?, ?, NOW())");
                            $stmt2->execute([$banquet_id, $targetPath]);
                        }
                    }
                }
            }

            $_SESSION['success'] = "Banquet & Gallery Images uploaded successfully.";
            header("Location: add_banquet.php");
            exit();

        } else {
            $_SESSION['error'] = "Cover image upload failed.";
        }
    } else {
        $_SESSION['error'] = "Invalid cover image file type.";
    }
}
?>

<style>
.banquet-form {
    background: linear-gradient(120deg,#fffbe6 60%,#fff5f5 100%);
    border-radius: 1.5rem;
    box-shadow: 0 4px 32px #DAA52022;
    max-width: 900px;
    margin: auto;
}
.banquet-form h5 {
    font-family: 'Playfair Display',serif;
    color: #800000 !important;
    font-size: 2rem;
    font-weight: bold;
    letter-spacing: 1px;
}
.form-label {
    color: #800000;
    font-weight: 500;
}
.form-control, textarea {
    border-radius: 1rem !important;
    border: 2px solid #DAA520 !important;
    background: #fffbe6 !important;
}
.form-control:focus, textarea:focus {
    box-shadow: 0 0 0 2px #DAA52044 !important;
    border-color: #800000 !important;
}
.btn-primary, .btn.btn-primary {
    background: linear-gradient(90deg,#800000,#DAA520);
    border: none;
    font-weight: bold;
    font-size: 1.1rem;
    border-radius: 2rem;
    box-shadow: 0 2px 10px #DAA52044;
}
.btn-primary:hover, .btn.btn-primary:hover {
    background: linear-gradient(90deg,#DAA520,#800000);
}
.upload-box {
    border: 2px dashed #DAA520;
    background: #fffbe6;
}
.upload-box:hover {
    border-color: #800000;
    background: #fff5f5;
}
.plus-icon {
    font-size: 40px;
    color: #DAA520;
    font-weight: bold;
}
.preview-thumb {
    border: 2px solid #DAA520;
}
.remove-btn {
    background: white;
    color: #800000;
    border: 2px solid #DAA520;
}
.image-upload-section {
    margin-top: 20px;
}

.upload-box {
    width: 120px;
    height: 120px;
    border: 2px dashed #bbb;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    cursor: pointer;
    background: #f4f6f8;
    position: relative;
    transition: border-color 0.3s ease;
}

.upload-box:hover {
    border-color: #007bff;
}

.plus-icon {
    font-size: 40px;
    color: #007bff;
    font-weight: bold;
}

.preview-container {
    position: relative;
    width: 120px;
    height: 120px;
}

.preview-thumb {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 12px;
    border: 2px solid #ccc;
}

.remove-btn {
    position: absolute;
    top: -6px;
    right: -6px;
    background: white;
    color: red;
    border-radius: 50%;
    border: none;
    width: 24px;
    height: 24px;
    font-size: 18px;
    font-weight: bold;
    line-height: 20px;
    text-align: center;
    cursor: pointer;
    z-index: 10;
}
</style>


<!-- Content Start -->
<div class="content">


    <?php
include("include/navbar.php");

?>
    <!-- Banquet detail form -->
    <div class="container-fluid px-4">
        <div class="banquet-form mt-4 p-4">
            <h5 class="mb-3 text-primary fw-semibold">Add Banquet Details</h5>
            <?php
            if(isset($_SESSION['error'])) {
                echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']);
                
            }
            if(isset($_SESSION['success'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
                unset($_SESSION['success']);
            }
            ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <input type="hidden" class="form-control form-control-sm" value="<?php echo $owner_id ?>"
                        name="owner_id">

                    <div class="col-md-6">
                        <label class="form-label small">Banquet Name</label>
                        <input type="text" class="form-control form-control-sm" name="banquet_name" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Location</label>
                        <input type="text" class="form-control form-control-sm" name="location" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label small">Capacity</label>
                        <input type="number" class="form-control form-control-sm" name="capacity" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Price (PKR)</label>
                        <input type="number" class="form-control form-control-sm" name="price" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small">Description</label>
                    <textarea class="form-control form-control-sm" name="description" rows="2"></textarea>
                </div>

                <div class="mb-3">

                    <div class="image-upload-section" id="coverImageContainer">

                        <label class="upload-box" id="coverUploadBox">
                            <input type="file" name="cover_image" hidden accept="image/*" id="cover_image_input">
                            <span>Cover image</span>
                            <div class="plus-icon">+</div>

                        </label>
                    </div>


                </div>

                <div class="mb-3">

                    <div class="image-upload-section d-flex flex-wrap gap-3" id="imagePreviewContainer">
                        <label class="upload-box">

                            <input type="file" name="GalleryImages[]" multiple hidden accept="image/*"
                                id="gallery_image">
                            <span>Gallery images</span>
                            <div class="plus-icon">+</div>
                        </label>
                    </div>
                </div>

                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-sm btn-primary" name="banquet_submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // COVER IMAGE: Only one image, hide input after selection
    document.getElementById("cover_image_input").addEventListener("change", function(event) {
        const file = event.target.files[0];
        const coverContainer = document.getElementById("coverImageContainer");
        const uploadBox = document.getElementById("coverUploadBox");

        // Remove previous preview if any
        coverContainer.querySelectorAll(".preview-container").forEach(e => e.remove());

        if (file && file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const wrapper = document.createElement("div");
                wrapper.className = "preview-container";

                const img = document.createElement("img");
                img.src = e.target.result;
                img.className = "preview-thumb";

                const removeBtn = document.createElement("button");
                removeBtn.innerHTML = "×";
                removeBtn.className = "remove-btn";
                removeBtn.addEventListener("click", function() {
                    wrapper.remove();
                    document.getElementById("cover_image_input").value = "";
                    uploadBox.style.display = "flex"; // Show again
                });

                wrapper.appendChild(img);
                wrapper.appendChild(removeBtn);

                coverContainer.insertBefore(wrapper, uploadBox);
                uploadBox.style.display = "none"; // Hide plus
            };
            reader.readAsDataURL(file);
        }
    });

    // GALLERY IMAGES: Multiple preview
    document.getElementById("gallery_image").addEventListener("change", function(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById("imagePreviewContainer");

        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            if (file.type.startsWith("image/")) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const wrapper = document.createElement("div");
                    wrapper.className = "preview-container";

                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.className = "preview-thumb";

                    const removeBtn = document.createElement("button");
                    removeBtn.innerHTML = "×";
                    removeBtn.className = "remove-btn";
                    removeBtn.addEventListener("click", function() {
                        wrapper.remove();
                    });

                    wrapper.appendChild(img);
                    wrapper.appendChild(removeBtn);
                    previewContainer.insertBefore(wrapper, previewContainer.querySelector(".upload-box"));
                };
                reader.readAsDataURL(file);
            }
        }
    });
    </script>




    <?php 
include("include/footer.php");
?>