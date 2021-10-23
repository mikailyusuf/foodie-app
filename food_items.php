<html>
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <title>Food Items</title>
</head>
<body>

<?php
require_once('Connection.php');
try {
    $connection = new  Connection();

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
?>

</body>
</html>