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

<main class="pet-details">
    <h2><?php echo htmlspecialchars($row['petname']); ?></h2>
    <div class="pet-image">
        <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['petname']); ?>">
    </div>
    <div class="pet-info">
        <div class="info-item">
            <span class="material-icons">schedule</span>
            <p><?php echo htmlspecialchars($row['age']); ?></p>
        </div>
        <div class="info-item">
            <span class="material-icons">pets</span>
            <p><?php echo htmlspecialchars($row['type']); ?></p>
        </div>
        <div class="info-item">
            <span class="material-icons">place</span>
            <p><?php echo htmlspecialchars($row['location']); ?></p>
        </div>
    </div>
    <p class="pet-description"><?php echo htmlspecialchars($row['description']); ?></p>
</main>

<?php
include('includes/footer.inc');
?>
