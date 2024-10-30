<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$title = "User Profile";
include('includes/header.inc');
include('includes/nav.inc');
include('includes/db_connect.inc');

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = htmlspecialchars($_POST['username']);
    $new_password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);

    if ($new_password !== $confirm_password) {
        echo "Passwords do not match.";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET username = ?, password = ? WHERE username = ?");
        if ($stmt === false) {
            die("Error preparing the SQL statement: " . $conn->error);
        }

        $stmt->bind_param("sss", $new_username, $hashed_password, $username);

        if ($stmt->execute()) {
            $_SESSION['username'] = $new_username;
            echo "Profile updated successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
} else {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
}
?>

<main class="container">
    <h2>User Profile</h2>
    <form action="user.php" method="post">
        <div class="form-group">
            <label for="username">Username: <span>*</span></label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">New Password: <span>*</span></label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm New Password: <span>*</span></label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</main>

<?php include('includes/footer.inc'); ?>