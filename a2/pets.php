<?php include('includes/header.inc'); ?>
<?php include('includes/nav.inc'); ?>
<?php include('includes/db_connect.inc'); ?>

<main>
  <h2>Available Pets</h2>
  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Caption</th>
        <th>Age</th>
        <th>Type</th>
        <th>Location</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = $db->query("SELECT * FROM pets");
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><a href='details.php?id={$row['petid']}'>{$row['petname']}</a></td>";
        echo "<td>{$row['caption']}</td>";
        echo "<td>{$row['age']}</td>";
        echo "<td>{$row['type']}</td>";
        echo "<td>{$row['location']}</td>";
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
</main>

<?php include('includes/footer.inc'); ?>
