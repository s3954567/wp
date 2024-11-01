<?php
$title = "Home - Pets Victoria";
include('includes/header.inc');
include('includes/nav.inc');
include('includes/db_connect.inc');

// Fetch all images from the 'pets' table
$query = "SELECT * FROM pets";
$result = $conn->query($query);
$images = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --teal-primary: #008080;
            --coral: #ff7f50;
        }

        body {
            background-color: #fff9f2;
        }

        .navbar {
            background-color: var(--teal-primary);
        }

        .bg-teal {
            background-color: var(--teal-primary) !important;
        }

        .carousel-item img {
            object-fit: cover;
            height: 400px;
            width: 100%;
        }

        #hero {
            background-color: #fff9f2;
            padding: 2rem 0;
        }

        .hero-title {
            color: var(--coral);
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            color: var(--teal-primary);
            font-size: 2rem;
            font-weight: 500;
        }

        .search-section {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-subtitle {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <main class="container-fluid px-0">
        <!-- Alert Messages -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php 
                    echo htmlspecialchars($_SESSION['message']); 
                    unset($_SESSION['message']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['login_error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php
                    echo htmlspecialchars($_SESSION['login_error']); 
                    unset($_SESSION['login_error']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Hero Section -->
<section id="hero" class="py-5">
    <div class="container">
        <div class="row g-0 align-items-center">
            <!-- Carousel column (left side) -->
            <div class="col-lg-6">
                <div class="pe-lg-4">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <?php foreach ($images as $index => $image): ?>
                                <button type="button" 
                                    data-bs-target="#carouselExampleIndicators" 
                                    data-bs-slide-to="<?php echo $index; ?>" 
                                    class="<?php echo $index === 0 ? 'active' : ''; ?>" 
                                    aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>" 
                                    aria-label="Slide <?php echo $index + 1; ?>">
                                </button>
                            <?php endforeach; ?>
                        </div>
                        <div class="carousel-inner">
                            <?php foreach ($images as $index => $image): ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <img src="images/<?php echo htmlspecialchars($image['image']); ?>" 
                                         class="d-block w-100" 
                                         alt="<?php echo htmlspecialchars($image['image']); ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" 
                                data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" 
                                data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Text column (right side) -->
            <div class="col-lg-6 d-flex align-items-center">
                <div class="hero-content text-lg-start text-center w-100 ps-lg-4 mt-4 mt-lg-0">
                    <h1 class="hero-title" style="color: #ff7f50;">PETS VICTORIA</h1>
                    <p class="hero-subtitle" style="color: #008080;">WELCOME TO PET ADOPTION</p>
                </div>
            </div>
        </div>
    </div>
</section>
        <!-- Search Section -->
        <section id="search" class="py-5 bg-light">
            <div class="container">
                <div class="search-section">
                    <form class="row g-3" action="search.php" method="GET">
                        <div class="col-md-6">
                            <input class="form-control" type="search" name="keyword" 
                                   placeholder="I am looking for ..." aria-label="Search">
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" name="pet_type">
                                <option value="">--Select Pet Type--</option>
                                <option value="cat">Cat</option>
                                <option value="dog">Dog</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary bg-teal w-100" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Content Section -->
        <section id="content" class="py-5">
            <div class="container">
                <h2 class="text-center mb-4">Discover Pets Victoria</h2>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <p class="text-center">
                            Pets Victoria is a dedicated pet adoption organization based in
                            Victoria, Australia, focused on providing a safe and loving
                            environment for pets in need. With a compassionate approach, Pets
                            Victoria works tirelessly to rescue, rehabilitate, and rehome dogs,
                            cats, and other animals. Their mission is to connect these deserving
                            pets with caring individuals and families, creating lifelong bonds.
                            The organization offers a range of services, including adoption
                            counseling, pet education, and community support programs, all aimed
                            at promoting responsible pet ownership and reducing the number of
                            homeless animals.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include('includes/footer.inc'); ?>