<?php
require_once('ConnectionLocal.php');
try {
    $connecion = new  ConnectionLocal();

    $query = "SELECT * FROM `food_items`";
    $result = $connecion->connectToDb()->query($query);

    if ($result->num_rows >= 1) {
        $emparray = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $emparray[] = $row;
        }
        echo json_encode($emparray);
    }

} catch (Exception $e) {
    http_response_code(401);
    echo('Message: ' . $e->getMessage());
    $message = json_encode(array("message" => $e->getMessage(), "status" => false));
    echo $message;
}