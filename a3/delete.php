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
    $stmt = $conn->prepare("DELETE FROM pets WHERE petid = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Delete image from file system
        if (file_exists("images/" . $row['image'])) {
            unlink("images/" . $row['image']);
        }
        echo "Pet deleted successfully.";
    } else {
        echo "Error deleting pet: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>

<main class="container">
    <h2>Delete Pet</h2>
    <form action="delete.php?id=<?php echo $id; ?>" method="post">
        <p>Are you sure you want to delete the pet named "<?php echo htmlspecialchars($row['petname']); ?>"?</p>
        <button type="submit" class="btn btn-danger">Delete</button>
        <a href="pets.php" class="btn btn-secondary">Cancel</a>
    </form>
</main>

<?php include('includes/footer.inc'); ?>