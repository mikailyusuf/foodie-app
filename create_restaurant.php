<?php

require_once('Authentication.php');
$authentication = new Authentication();

$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($requestMethod == "POST") {
    try {

        $json_string = file_get_contents("php://input");
        $data = json_decode($json_string, true);

        if (sizeof($data) > 4) {

            $name = $data['name'];

            $email = $data['email'];

            $phone = $data['phone'];

            $address = $data['address'];

            $password = md5($authentication->check_input($data['password']));


            $authentication = new Authentication();

            if ($authentication->verifyEmail($email)) {
                $authentication->registerUser($name, $email, $phone, $address, $password);
            } else {

            }

        }

    } catch (Exception $e) {
        $message = json_encode(array("message" => "Bad Request $e", "status" => false));
        http_response_code(400);
        echo $message;
    }

} else {
    $message = json_encode(array("message" => "Bad Request", "status" => false));
    http_response_code(400);
    echo $message;
}

?>