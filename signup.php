<?php
include 'config.php';
include 'token_generator.php';

try{
$json_string = file_get_contents( "php://input");
$data = json_decode($json_string,true);

		$name=$data['name'];
		$email=$data['email'];
		$phone=$data['phone'];
		$address=$data['address'];
        $password= password_hash($data['password'], PASSWORD_DEFAULT);
        $token = generateToken();
      $user_id = uniqid();

        $sql = "INSERT INTO `users`( `id`,`name`, `email`,`phone`,`address`,`token`,`password`) 
		VALUES ('$user_id','$name','$email','$phone','$address','$token','$password')";
		if (mysqli_query($CONNECTION, $sql)) {
            $message = json_encode(array("message" => "User Created Successfully", "status" => true));	
            http_response_code(201);
            echo $message;
		} 
		else {
		
      http_response_code(40);
            $message = json_encode(array("message" => mysqli_error($CONNECTION), "status" => false));
            echo $message;
 

		}
        // echo(json_encode($data));
        // echo($password);
}
catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
  }

?>