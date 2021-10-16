<?php
include 'Connection.php';
include "Authentication.php";

$connection = new Connection();
$authentication= new Authentication();
 
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
        $json_string = file_get_contents( "php://input");
        $data = json_decode($json_string,true); 

		$email=$authentication->check_input($data['email']);
		$password=md5($authentication->check_input($data['password']));
 
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              http_response_code(401);
              $message = json_encode(array("message" => "Invalid email format","status" => false));	
              echo $message;
		}
		else{
			$query = mysqli_query($connection->connectToLocalDb(),"select * from restaurants where email='$email' and user_password='$password'");

//            var_dump($query);
//            die();

            if(mysqli_num_rows($query) == 0){
                http_response_code(401);
                $message = json_encode(array("message" => "User not found","status" => false));	
                echo $message;
			}
			else{
				$row=mysqli_fetch_array($query);
				if($row['is_verified'] == 0){
                    http_response_code(401);
                    $message = json_encode(array("message" => "Account not Verified","status" => false));	
                    echo $message;
                }
				else{
                  //  show user Id =$row['userid'];
                  http_response_code(200);
                  $message = json_encode(array("message" => "User Id is".$row['id'],"status" => true));
                  echo $message;
				}
			}
		}
 
	}

    else{
        http_response_code(400);
                  $message = json_encode(array("message" => "Bad request","status" => false));	
                  echo $message;
    }
?>



  