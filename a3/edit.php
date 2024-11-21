<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$title = "Edit Pet";
include('includes/header.inc');
include('includes/nav.inc');
include('includes/db_connect.inc');

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM pets WHERE petid = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Pet not found.";
        exit;
    }
    $stmt->close();
} else {
    echo "No pet ID provided.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $petname = htmlspecialchars($_POST['petname']);
    $description = htmlspecialchars($_POST['description']);
    $age = intval($_POST['age']);
    $location = htmlspecialchars($_POST['location']);
    $type = htmlspecialchars($_POST['type']);
    $image = $_FILES['file01']['name'];

    // Handle file upload securely
    if ($image) {
        $target_dir = "images/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);

// Check if file exists and delete it
if (file_exists($target_file)) {
    unlink($target_file); // Remove the existing file
}

// Move the uploaded file
if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    echo "File uploaded and replaced successfully!";
} else {
    echo "Sorry, there was an error uploading your file.";
}


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
    } else {
        // If no new image is uploaded, retain the existing image
        $image = $row['image'];
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE pets SET petname = ?, description = ?, age = ?, location = ?, type = ?, image = ? WHERE petid = ?");
    
    // Check if the prepare() method was successful
    if ($stmt === false) {
        die("Error preparing the SQL statement: " . $conn->error);
    }

    $stmt->bind_param("ssisssi", $petname, $description, $age, $location, $type, $image, $id);

    if ($stmt->execute()) {
        echo "Pet updated successfully.";
    } else {
        echo "Error updating pet: " . $stmt->error;
    }
    $stmt->close();
}
?>

<main class="container">
    <h2>Edit Pet</h2>
    <form action="edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="petname">Pet Name: <span>*</span></label>
            <input type="text" id="petname" name="petname" value="<?php echo htmlspecialchars($row['petname']); ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description: <span>*</span></label>
            <textarea id="description" name="description" class="form-control" required><?php echo htmlspecialchars($row['description']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="age">Age: <span>*</span></label>
            <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($row['age']); ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="location">Location: <span>*</span></label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($row['location']); ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="type">Type: <span>*</span></label>
            <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($row['type']); ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="image">Select an image: <span>*</span></label>
            <input type="file" id="image" name="file01" class="form-control">
            <span class="max-size"><i>Max image size 500 px</i></span>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</main>

<?php include('includes/footer.inc'); ?>