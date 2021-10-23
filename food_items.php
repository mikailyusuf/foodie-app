<?php
require_once('Connection.php');
try {
    $connection = new  ConnectionLocal();

    $query = "SELECT * FROM `food_items`";
    $result = $connection->connectToDb()->query($query);

    echo "<table class='table'>
  <thead>
    <tr>
      <th scope='col'>Name</th>
      <th scope='col'>Description</th>
      <th scope='col'>Price</th>
      <th scope='col'>Available</th>
    </tr>
  </thead>
  <tbody>";

    if ($result->num_rows >= 1) {
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "<td>" . $row['is_available'] . "</td>";

            echo "</tr>";


        }
        echo " </tbody>";
        echo "</table>";
    }

} catch (Exception $e) {
    http_response_code(401);
    echo('Message: ' . $e->getMessage());
    $message = json_encode(array("message" => $e->getMessage(), "status" => false));
    echo $message;
}