<footer class="bg-orange text-teal text-center py-3">
    <div class="user-links">
        <?php
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Only show user links if user is logged in
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
            // Display the logged-in user's username
            $username = htmlspecialchars($_SESSION['username']); // Escape for security
            echo "<a href='user.php?username=$username' class='mx-2'>$username</a>";

            // Add the logout button
            echo "<a href='logout.php' class='mx-2'>Logout</a>";
        } else {
            // Optional: Show a message or login link for non-logged in users
            echo "<p>Please <a href='login.php'>login</a> to see user profiles</p>";
        }
        ?>
    </div>
    <p>&copy; <?php echo date('Y'); ?> S3954567 | All Rights Reserved | Designed for Pets Victoria</p>
</footer>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="./js/main.js"></script>
</body>
</html>