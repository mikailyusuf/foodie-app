<?php

include 'config.php';
include 'token_generator.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function check_input($value){
    $value=trim($value); //remove the unwanted spaces
    $value=stripslashes($value); //remove the slashes
    $value=htmlspecialchars($value); //convert tags into special character format like from  < tag to < 
    return $value;
  }


  function registerUser($name,$email,$phone,$address,$password){
    $status=0;

    $token=md5($email.time());

    $uuid = uniqid();

    try{
        
        $sql = "INSERT INTO restaurants ( `id`,`name`, `email`,`phone`,`is_verified`,`is_active`,`user_address`,`token`,`user_password`) 
        VALUES ('$uuid','$name','$email','$phone','0','0','$address','$token','$password')";
    

    $results=mysql_query($sql);

    echo "error = ". $results;


    if (!mysqli_query($conn,$sql)) {
        printf("Error message: %s\n", mysqli_error($link));
    }
    die(mysql_error());
    mysqli_close($conn);

    // $conn->query($sql);
    // echo "Error creating user: " . $conn->error;

    // echo 'before query';
    // if ($conn->query($sql) === TRUE) {
    //     echo 'tei';
    //     echo "User created successfully";
    //   } else {

    //     echo 'fei';
    //     echo "Error creating user: " . $conn->error;
    //     http_response_code(400);
    //   }
    //   echo 'after query';

    // //   mysqli_query($conn, $sql);
    //     if (mysqli_query($conn, $sql)) {
    
    //         echo "registered user";
    //       http_response_code(201);
    //       $message = json_encode(array("message" => "User Created","status" => true));	
    //       echo $message;
    //     //   sendMail($email, $name);
    
    //     }
                
    
    //     else {
    //         echo " SQL ERROR $sql" .mysqli_error($conn,$sql);
    //       $message = json_encode(array("message" => "mysqli_error($conn)", "status" => false));	
    //       http_response_code(400);
    
    //      }
     }
    
      catch (Exception $e){
    // echo "not registered user";
      http_response_code(400);
      $message = json_encode(array("message" => "Error message = $e","status" => false));	
      echo $message;
    
      }
    
    }
  
  
  function verifyEmail($email){

    $connection = new Connection();
      $servername = "localhost";
      $username = "root";
      $password = "password";
      $dbname = "foodie";

    $token = bin2hex(random_bytes(50));
  
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      http_response_code(401);
      $message = json_encode(array("message" => "Email not valid","status" => false));	
      echo $message;
      return false;
    }
    else{
        echo "MAIL VERIFIED";

        try {

            $query = mysqli_query($connection->connectToLocalDb() , "SELECT * FROM restaurants where email='$email'");
            echo "AFTER CONNECTION";
            echo 'response = ' . $query;
            if (mysqli_num_rows($query) > 0) {
                http_response_code(401);
                $message = json_encode(array("message" => "Email already taken", "status" => false));
                echo $message;
                return false;
            } else {
                http_response_code(201);
                $message = json_encode(array("message" => "Email verified", "status" => true));
                echo $message;
                return true;
            }
        }
        catch (Exception $e){
            echo "Exception = ".$e;
        }
  
    }
      
  }



    function sendMail($email,$username){

        $message = "
                      <html>
                      <head>
                      <title>Verification Code</title>
                      </head>
                      <body>
                      <h2>Thank you for Registering.</h2>
                      <p>Your Account:</p>
                      <p>Email: ".$email."</p>
              
                      <p>Please click the link below to activate your account.</p>
                      <h4><a href='http://localhost/email_verification.php?uid=$uid&code=$code'>Activate My Account</h4>
                      </body>
                      </html>
                      ";
      
       $mail = new PHPMailer(true);
      
       try {
          //Server settings
          $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
          $mail->isSMTP();                                            //Send using SMTP
          $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
          $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
          $mail->Username   = 'devmikaeelkyusuf@gmail.com';                     //SMTP username
          $mail->Password   = 'mikail.kunle';                               //SMTP password
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
          $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
      
          //Recipients
          $mail->setFrom('from@example.com', 'Mailer');
          $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
          $mail->addAddress('ellen@example.com');               //Name is optional
          $mail->addReplyTo('devmikaeelkyusuf@gmail.com', 'Information');
         
          //Content
          $mail->isHTML(true);                                  //Set email format to HTML
          $mail->Subject = 'Email Verification';
          $mail->Body    = $message;
          //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
      
          $mail->send();
          echo 'Message has been sent';
        }
       catch (Exception $e) {
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    }
?>