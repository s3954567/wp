<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$title = "Add Pet";
include('includes/header.inc');
include('includes/nav.inc');
include('includes/db_connect.inc');

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $petname = htmlspecialchars($_POST['petname']);
    $description = htmlspecialchars($_POST['description']);
    $age = intval($_POST['age']);
    $location = htmlspecialchars($_POST['location']);
    $type = htmlspecialchars($_POST['type']);
    $caption = htmlspecialchars($_POST['caption']);
    $image = $_FILES['file01']['name'];
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

    // Handle file upload securely
    if ($image) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES['file01']['tmp_name']);
        if ($check === false) {
            echo "File is not an image.";
            exit;
        }

        // Check file size
        if ($_FILES['file01']['size'] > 500000) {
            echo "Sorry, your file is too large.";
            exit;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            exit;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            exit;
        }

        // Move uploaded file to target directory
        if (!move_uploaded_file($_FILES['file01']['tmp_name'], $target_file)) {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    }

    // Insert pet details into the database
    $stmt = $conn->prepare("INSERT INTO pets (petname, description, age, location, type, caption, image, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissssi", $petname, $description, $age, $location, $type, $caption, $image, $user_id);
    if ($stmt->execute()) {
        echo "Pet added successfully.";
    } else {
        echo "Error adding pet: " . $stmt->error;
    }
    $stmt->close();
}
?>

<main class="container">
    <h2>Add Pet</h2>
    <form action="add.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="petname">Pet Name: <span>*</span></label>
            <input type="text" id="petname" name="petname" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description: <span>*</span></label>
            <textarea id="description" name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="age">Age: <span>*</span></label>
            <input type="number" id="age" name="age" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="location">Location: <span>*</span></label>
            <input type="text" id="location" name="location" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="type">Type: <span>*</span></label>
            <input type="text" id="type" name="type" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="image">Select an image: <span>*</span></label>
            <input type="file" id="image" name="file01" class="form-control">
            <span class="max-size"><i>Max image size 500 px</i></span>
        </div>
        <div class="form-group">
            <label for="caption">Image caption: <span>*</span></label>
            <input type="text" id="caption" name="caption" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Pet</button>
    </form>
</main>

<?php include('includes/footer.inc'); ?>
