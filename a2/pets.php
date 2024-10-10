<?php
$title = "Pets Victoria - Pets";
include('includes/header.inc');
include('includes/nav.inc');
?>
<main>
    <div class="pets-heading">
        <h2>Discover Pets Victoria</h2>
        <p class="description">Pets Victoria is a dedicated pet adoption organization based in Victoria, Australia, focused on providing a safe and loving environment for pets in need. With a compassionate approach, Pets Victoria works tirelessly to rescue, rehabilitate, and rehome dogs, cats, and other animals. Their mission is to connect these deserving pets with caring individuals and families, creating lifelong bonds. The organization offers a range of services, including adoption counseling, pet education, and community support programs, all aimed at promoting responsible pet ownership and reducing the number of homeless animals.</p>
    </div>

    <div class="content">
        <div class="pets-container">
            <div class="pets-image">
                <img src="images/pets.jpeg" alt="Pets">
            </div>
            <div class="pets-table">
                <table>
                    <thead>
                        <tr>
                            <th>Pet</th>
                            <th>Type</th>
                            <th>Age</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    include('includes/db_connect.inc');

                    // Check if the connection was successful
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT * FROM pets";
                    $result = $conn->query($sql);

                    // Check if the query was successful
                    if ($result && $result->num_rows > 0) {
                        // Loop through the results and print each row
                        while ($row = $result->fetch_assoc()) {
                            // Sanitize output to prevent XSS
                            $petid = htmlspecialchars(rawurlencode($row['petid']));
                            $petname = htmlspecialchars($row['petname']);
                            $type = htmlspecialchars($row['type']);
                            $age = htmlspecialchars($row['age']);
                            $location = htmlspecialchars($row['location']);

                            echo '<tr>';
                            echo '<td><a href="details.php?id=' . $petid . '">' . $petname . '</a></td>';
                            echo '<td>' . $type . '</td>';
                            echo '<td>' . $age . ' months</td>';
                            echo '<td>' . $location . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="4">No results found.</td></tr>';
                    }
                    ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</main>
<?php
include('includes/footer.inc');
?>
<script src="./js/main.js"></script>
