<?php include('includes/header.inc'); ?>
<?php include('includes/nav.inc'); ?>
<?php include('includes/db_connect.inc'); ?>

<main>
    <h2>Pet Gallery</h2>
    <div class="gallery">
        <?php
        $result = $conn->query("SELECT petid, image, caption FROM pets");
        while ($row = $result->fetch_assoc()) {
            echo "<a href='details.php?id=" . $row['petid'] . "'>";
            echo "<img src='images/" . $row['image'] . "' alt='" . $row['caption'] . "'>";
            echo "</a>";
        }
        ?>
    </div>
</main>

<?php include('includes/footer.inc'); ?>

