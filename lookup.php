<?php
  require_once("socrata-php/public/socrata.php");

  $socrata = new Socrata("http://data.oregon.gov/api");

  $params = array();
  $params["max_rows"] = 10;
  $params["search"] = array_get("search", $_POST);

  $response = $socrata->get("/views/y3km-rmbz/rows.json", $params);
?>
<html>
  <head>
    <title>Oregon Business License Lookup Results</title>
  </head>
  <body>
    <h1>Oregon Business License Lookup Results</h1>

    <?# Create a table for our actual data ?>
    <table border="1">
      <tr>
        <?# Print header row ?>
        <?php foreach($response["meta"]["view"]["columns"] as $column) { ?>
          <th><?= $column["name"] ?> (<?= $column["id"] ?>)</th>
        <?php } ?>
        <th>Map</th>
      </tr>
      <?# Print rows ?>
      <?php foreach($response["data"] as $row) { ?>
        <tr>
          <?php foreach($row as $cell) { ?>
            <td><?= $cell ?></td>
          <?php } ?>
          <td><img src="<?= "http://maps.google.com/maps/api/staticmap?center=" . $row[25][1] . "," . $row[25][2] . "&zoom=14&size=400x400&sensor=false&markers=" . $row[25][1] . "," . $row[25][2] ?>"></td>
        </tr>
      <?php } ?>
    </table>
  </body>
</html>
