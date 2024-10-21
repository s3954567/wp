<?php
$title = "Register";
include('includes/header.inc');
include('includes/nav.inc');
include('includes/db_connect.inc');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = hash('sha256', $_POST['password']);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        echo "Registration successful.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<main class="container">
    <h2>Register</h2>
    <form action="register.php" method="post">
        <div class="form-group">
            <label for="username">Username: <span>*</span></label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password: <span>*</span></label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</main>

<?php include('includes/footer.inc'); ?>