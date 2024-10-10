<?php include('includes/header.inc'); ?>
<?php include('includes/nav.inc'); ?>
<?php include('includes/db_connect.inc'); ?>

<main>
    <?php
    $petid = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM pets WHERE petid = ?");
    $stmt->bind_param("i", $petid);
    $stmt->execute();
    $result = $stmt->get_result();
    $pet = $result->fetch_assoc();
    ?>
    <h2><?php echo $pet['petname']; ?></h2>
    <img src="images/<?php echo $pet['image']; ?>" alt="<?php echo $pet['caption']; ?>">
    <p><strong>Description:</strong> <?php echo $pet['description']; ?></p>
    <p><strong>Age:</strong> <?php echo $pet['age']; ?> months</p>
    <p><strong>Type:</strong> <?php echo $pet['type']; ?></p>
    <p><strong>Location:</strong> <?php echo $pet['location']; ?></p>
</main>

<?php include('includes/footer.inc'); ?>
