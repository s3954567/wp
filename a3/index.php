<?php
session_start();
$title = "Home";
include('includes/header.inc');
include('includes/nav.inc');
include('includes/db_connect.inc');

// Fetch the last four images added to the database
$sql = "SELECT image FROM pets ORDER BY created_at DESC LIMIT 4";
$result = $conn->query($sql);
$images = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $images[] = $row['image'];
    }
}
?>

<main class="container-fluid">
    <h1>Welcome to Pets Victoria</h1>
    <p>Your one-stop destination for pet adoption.</p>

    <!-- Image Carousel -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php for ($i = 0; $i < count($images); $i++): ?>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $i; ?>" class="<?php echo $i === 0 ? 'active' : ''; ?>" aria-current="true" aria-label="Slide <?php echo $i + 1; ?>"></button>
            <?php endfor; ?>
        </div>
        <div class="carousel-inner">
            <?php foreach ($images as $index => $image): ?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <img src="images/<?php echo htmlspecialchars($image); ?>" class="d-block w-100" alt="Pet Image" style="max-width: 500px; max-height: 500px; margin: 0 auto;">
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</main>

<?php include('includes/footer.inc'); ?>
