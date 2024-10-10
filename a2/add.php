<?php include('includes/header.inc'); ?>
<?php include('includes/nav.inc'); ?>

<main>
  <h2>Add a New Pet</h2>
  <form action="process_add.php" method="post" enctype="multipart/form-data">
    <label for="petname">Pet Name:</label>
    <input type="text" id="petname" name="petname" required><br>
    
    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea><br>

    <label for="caption">Image Caption:</label>
    <input type="text" id="caption" name="caption" required><br>

    <label for="age">Age (in months):</label>
    <input type="number" id="age" name="age" step="0.1" required><br>

    <label for="type">Type:</label>
    <input type="text" id="type" name="type" required><br>

    <label for="location">Location:</label>
    <input type="text" id="location" name="location" required><br>

    <label for="image">Image:</label>
    <input type="file" id="image" name="image" required><br>

    <button type="submit">Add Pet</button>
  </form>
</main>

<?php include('includes/footer.inc'); ?>
