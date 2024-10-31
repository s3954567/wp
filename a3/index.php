<?php
session_start();
$title = "Home - Pets Victoria";
include('includes/header.inc');
include('includes/nav.inc');
include('includes/db_connect.inc');

// Fetch the last four images added to the database
$sql = "SELECT image FROM pets ORDER BY created_at DESC LIMIT 4";
$result = $conn->query($sql);

// Check if the query was successful
if ($result === false) {
    die("Error executing the query: " . $conn->error);
}

$images = $result->fetch_all(MYSQLI_ASSOC); // Fetch data as an associative array
?>

<main class="container-fluid">
    <!-- Display success message if available -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php 
                echo htmlspecialchars($_SESSION['message']); 
                unset($_SESSION['message']);  // Clear the message after displaying
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Display login error if any -->
    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php
                echo htmlspecialchars($_SESSION['login_error']); 
                unset($_SESSION['login_error']);  // Clear error after displaying
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <section id="hero">
        <div class="container pt-2 pb-4">
            <div class="row pt-2 pb-5">
                <div class="col-12 text-center">
                    <h1>Welcome to Pets Victoria</h1>
                    <p>Your one-stop destination for pet adoption.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Image Carousel -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php foreach ($images as $index => $image): ?>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>" aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>" aria-label="Slide <?php echo $index + 1; ?>"></button>
            <?php endforeach; ?>
        </div>
        <div class="carousel-inner">
            <?php foreach ($images as $index => $image): ?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <img src="uploads/<?php echo htmlspecialchars($image['image']); ?>" class="d-block w-100" style="max-width: 500px; max-height: 500px;" alt="Pet Image">
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
