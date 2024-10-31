<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session if it hasn't been started already
}
?>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="images/logo.png" alt="Pets Victoria Logo" class="logo-img">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pets.php">Pets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add.php">Add</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gallery.php">Gallery</a>
                    </li>
                </ul>
                <form class="d-flex" action="search.php" method="GET">
                    <input 
                        class="form-control me-2" 
                        type="search" 
                        name="keyword" 
                        placeholder="Search" 
                        required
                    >
                    <button class="btn btn-transparent text-white" type="submit">
                        <span class="material-icons">search</span>
                    </button>
                </form>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <!-- Links for guests (not logged in) -->
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>