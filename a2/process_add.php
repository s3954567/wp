<?php
include('includes/db_connect.inc');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $petname = $_POST['petname'];
    $description = $_POST['description'];
    $age = $_POST['age'];
    $type = $_POST['type'];
    $location = $_POST['location'];
    $caption = $_POST['caption'];
    
    $image = $_FILES['image']['name'];
    $target = "images/" . basename($image);
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $stmt = $conn->prepare("INSERT INTO pets (petname, description, age, type, location, caption, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssdssss', $petname, $description, $age, $type, $location, $caption, $image);
        $stmt->execute();
        header("Location: pets.php");
    } else {
        echo "Failed to upload image.";
    }
}
?>
