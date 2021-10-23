<?php
include 'config.php';
require_once('Connection.php');
header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST");
header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Acess-Control-Allow-Methods, Authorization");

$data = json_decode(file_get_contents("php://input"), true); // collect input parameters and convert into readable format

$fileName = $_FILES['food_image']['name'];
$tempPath = $_FILES['food_image']['tmp_name'];
$fileSize = $_FILES['food_image']['size'];


$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$restaurantId = $_POST['restaurant_token'];

$min_rand = rand(0, 1000);
$max_rand = rand(100000000000, 10000000000000000);
$name_file = rand($min_rand, $max_rand);
$var_explode = explode(".", $_FILES["food_image"]["name"]);
$ext = end($var_explode);
$fileName = $name_file . "." . $ext;

if (empty($fileName)) {
    $errorMSG = json_encode(array("message" => "please select image", "status" => false));
    echo $errorMSG;
} else {
    // $upload_path = getCwd();
    $upload_path = "upload/";

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // get image extension

    // valid image extensions
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');

    // allow valid image file formats
    if (in_array($fileExt, $valid_extensions)) {
        //check file not exist our upload folder path
        if (!file_exists($upload_path . $fileName)) {
            // check file size '5MB'
            if ($fileSize < 5000000) {

                $date = date_create();
                $newfile = date_timestamp_get($date);
                move_uploaded_file($tempPath, $upload_path . $fileName); // move file from system temporary path to our upload folder path
            } else {
                $errorMSG = json_encode(array("message" => "Sorry, your file is too large, please upload 5 MB size", "status" => false));
                echo $errorMSG;
            }
        } else {
            $errorMSG = json_encode(array("message" => "Sorry, file already exists check upload folder", "status" => false));
            echo $errorMSG;
        }
    } else {
        http_response_code(400);
        $errorMSG = json_encode(array("message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed", "status" => false));
        echo $errorMSG;
    }
}

$imageName = $upload_path . $fileName;
// if no error caused, continue ....
if (!isset($errorMSG)) {
    $connecion = new  Connection();
    $conn = new mysqli($connecion->servername, $connecion->username, $connecion->password, $connecion->dbname);
    $uuid = uniqid();

    $sql = "INSERT INTO `food_items`( `id`,`name`, `description`,`price`,`restaurant_token`,`is_available`,`image_url`) 
    VALUES ('$uuid','$name','$description','$price','$restaurantId','1','$imageName')";

    if ($conn->query($sql) === TRUE) {
        $message = json_encode(array("message" => "Food Item Created Successfully", "status" => true));
        echo $message;
        http_response_code(201);

    } else {
        http_response_code(400);
        $message = json_encode(array("message" => $conn->error, "status" => false));
        echo $message;
    }

} else {
    http_response_code(400);
}

?>