<?php
session_start();
$title = "Search Results";
include('includes/header.inc');
include('includes/nav.inc');
include('includes/db_connect.inc');

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$search_query = '';
$pet_type = '';
$results = [];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['query'])) {
        $search_query = htmlspecialchars($_GET['query']);
    }
    if (isset($_GET['type'])) {
        $pet_type = htmlspecialchars($_GET['type']);
    }

    $sql = "SELECT * FROM pets WHERE (petname LIKE ? OR description LIKE ?)";
    $params = [];
    $types = "ss";
    $search_term = '%' . $search_query . '%';
    $params[] = $search_term;
    $params[] = $search_term;

    if (!empty($pet_type)) {
        $sql .= " AND type = ?";
        $types .= "s";
        $params[] = $pet_type;
    }

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing the SQL statement: " . $conn->error);
    }

    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }

    $stmt->close();
    $conn->close();
}
?>

<main class="container">
    <h2>Search Results</h2>
    <form action="search.php" method="get" class="mb-4">
        <div class="form-group">
            <label for="query">Keyword(s):</label>
            <input type="text" id="query" name="query" class="form-control" value="<?php echo htmlspecialchars($search_query); ?>">
        </div>
        <div class="form-group">
            <label for="type">Pet Type:</label>
            <select id="type" name="type" class="form-control">
                <option value="">All Types</option>
                <option value="dog" <?php if ($pet_type == 'dog') echo 'selected'; ?>>Dog</option>
                <option value="cat" <?php if ($pet_type == 'cat') echo 'selected'; ?>>Cat</option>
                <option value="bird" <?php if ($pet_type == 'bird') echo 'selected'; ?>>Bird</option>
                <option value="other" <?php if ($pet_type == 'other') echo 'selected'; ?>>Other</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Search</button>
    </form>

    <?php if (count($results) > 0): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Pet</th>
                    <th>Type</th>
                    <th>Age</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><a href="details.php?id=<?php echo htmlspecialchars($row['petid']); ?>"><?php echo htmlspecialchars($row['petname']); ?></a></td>
                        <td><?php echo htmlspecialchars($row['type']); ?></td>
                        <td><?php echo htmlspecialchars($row['age']); ?> months</td>
                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No results found for your search.</p>
    <?php endif; ?>
</main>

<?php include('includes/footer.inc'); ?>