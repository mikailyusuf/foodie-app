<?php

require_once ('Connection.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

class Authentication{


    function check_input($value){
        $value=trim($value); //remove the unwanted spaces
        $value=stripslashes($value); //remove the slashes
        $value=htmlspecialchars($value); //convert tags into special character format like from  < tag to <
        return $value;
    }

    function verifyEmail($email){
         $connection = new Connection();
        $token = bin2hex(random_bytes(50));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(401);
            $message = json_encode(array("message" => "Email not valid","status" => false));
            echo $message;
            return false;
        }
        else{

            try {

                $query = mysqli_query($connection->connectToLocalDb() , "SELECT * FROM restaurants where email='$email'");

                if (mysqli_num_rows($query) > 0) {
                    http_response_code(401);
                    $message = json_encode(array("message" => "Email already taken", "status" => false));
                    echo $message;
                    return false;
                } else {
                    http_response_code(200);
                    return true;
                }
            }
            catch (Exception $e){
                echo "Exception = ".$e;
            }

        }

    }


    function registerUser($name,$email,$phone,$address,$password){
         $connection = new Connection();
        $status=0;

        $token=md5($email.time());

        $uuid = uniqid();

        try{

            $sql = "INSERT INTO restaurants ( `id`,`firstname`,`email`,`phone`,`is_verified`,`is_active`,`user_address`,`token`,`user_password`) 
        VALUES ('$uuid','$name','$email','$phone','0','0','$address','$token','$password')";


                 if (mysqli_query($connection->connectToLocalDb(), $sql)) {
                   http_response_code(201);
                   $message = json_encode(array("message" => "User Created","status" => true));
                   echo $message;
                    $this->sendMail($email, $name,$uuid,$token);

                 }

                 else {
                     echo mysqli_error($connection->connectToLocalDb());
                   http_response_code(400);

                  }
        }

        catch (Exception $e){
            // echo "not registered user";
            http_response_code(400);
            $message = json_encode(array("message" => "Error message = $e","status" => false));
            echo $message;

        }

    }

    function sendMail($email,$username,$uuid,$code){

        $message = "
                      <html>
                      <head>
                      <title>Verification Code</title>
                      </head>
                      <body>
                      <h2>Thank you $username for Registering.</h2>
                      <p>Your Account:</p>
                      <p>Email: ".$email."</p>
              
                      <p>Please click the link below to activate your account.</p>
                      <h4><a href='http://localhost/email_verification.php?uid=$uuid&code=$code'>Activate My Account</h4>
                      </body>
                      </html>
                      ";

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->SMTPDebug = 1;
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->Username   = 'devmikaeel@gmail.com';                     //SMTP username
            $mail->Password   = 'mikail.kunle';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('devmikaeel@gmail.com', "Foodie");
            $mail->addAddress($email);     //Add a recipient
            $mail->addReplyTo('devmikaeel@gmail.com', 'Information');

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


}

?>