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
$results = [];

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['query'])) {
    $search_query = htmlspecialchars($_GET['query']);

    $stmt = $conn->prepare("SELECT * FROM pets WHERE petname LIKE ? OR type LIKE ? OR location LIKE ?");
    if ($stmt === false) {
        die("Error preparing the SQL statement: " . $conn->error);
    }

    $search_term = '%' . $search_query . '%';
    $stmt->bind_param("sss", $search_term, $search_term, $search_term);
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
    <h2>Search Results for "<?php echo $search_query; ?>"</h2>
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
        <p>No results found for "<?php echo $search_query; ?>".</p>
    <?php endif; ?>
</main>

<?php include('includes/footer.inc'); ?>