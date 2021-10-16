<?php
include 'config.php';

try{
$json_string = file_get_contents( "php://input");
$data = json_decode($json_string,true);

		// $emailData=stripcslashes($data['email']);
        $email = $data['email']; //mysqli_real_escape_string($conn, $emailData);
		$passwordData=$data['password'];
        $password =  $data['password']; //mysqli_real_escape_string($conn, $passwordData);

        $sql = "SELECT * FROM restaurants WHERE email = '$email' ";  
        $result = mysqli_query($CONNECTION, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);

    
        if($email == $row['email']){
      
        if (password_verify($password, $row['password'])) {
            $message = json_encode(array("message" => "Login Success ","token"=>$row['token'], "status" => true));	
            http_response_code(200);
            echo $message;
        } else {
            http_response_code(401);
            $message = json_encode(array("message" => "Invalid Password ","status" => false));	
            echo $message;
        }
    }
    else{
        http_response_code(401);
        $message = json_encode(array("message" => "Invalid Username or Password ","status" => false));	
        echo $message;
    }
		
}
catch(Exception $e) {
    http_response_code(401);
    echo('Message: ' .$e->getMessage());
    $message = json_encode(array("message" => $e->getMessage(),"status" => false));	
    echo $message;
  }