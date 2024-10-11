<?php
$title = "Pet Details";
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
?>

<main>
    <h2><?php echo htmlspecialchars($row['petname']); ?></h2>
    <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['petname']); ?>">
    <p><?php echo htmlspecialchars($row['description']); ?></p>
    <p>Type: <?php echo htmlspecialchars($row['type']); ?></p>
    <p>Age: <?php echo htmlspecialchars($row['age']); ?></p>
    <p>Location: <?php echo htmlspecialchars($row['location']); ?></p>
</main>

<?php
include('includes/footer.inc');
?>
