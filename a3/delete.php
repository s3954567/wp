<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$title = "Delete Pet";
include('includes/header.inc');
include('includes/nav.inc');
include('includes/db_connect.inc');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM pets WHERE petid = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Pet not found.";
        exit;
    }
} else {
    echo "No pet ID provided.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("DELETE FROM pets WHERE petid = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Delete image from file system
        unlink("images/" . $row['image']);
        echo "Pet deleted successfully.";
    } else {
        echo "Error deleting pet.";
    }

    $stmt->close();
    $conn->close();
}
?>

<main class="container">
    <h2>Delete Pet</h2>
    <p>Are you sure you want to delete this pet?</p>
    <form action="delete.php?id=<?php echo $id; ?>" method="post">
        <button type="submit" class="btn btn-danger">Delete</button>
        <a href="details.php?id=<?php echo $id; ?>" class="btn btn-secondary">Cancel</a>
    </form>
</main>

<?php include('includes/footer.inc'); ?>