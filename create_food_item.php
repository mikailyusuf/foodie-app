<?php
include 'config.php';
header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST");
header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Acess-Control-Allow-Methods, Authorization");

$data = json_decode(file_get_contents("php://input"), true); // collect input parameters and convert into readable format
	
$fileName  =  $_FILES['foodImage']['name'];
$tempPath  =  $_FILES['foodImage']['tmp_name'];
$fileSize  =  $_FILES['foodImage']['size'];


$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$restaurantId= $_POST['restaurant_id'];
$isAvailable = $_POST['isAvailable'];
$food_id = uniqid();

$min_rand=rand(0,1000);
$max_rand=rand(100000000000,10000000000000000);
$name_file=rand($min_rand,$max_rand);
$ext=end(explode(".", $_FILES["foodImage"]["name"]));
$fileName = $name_file.".".$ext;
		
if(empty($fileName))
{
	$errorMSG = json_encode(array("message" => "please select image", "status" => false));	
	echo $errorMSG;
}
else
{
	// $upload_path = getCwd(); 
    $upload_path = "upload/";
	
	$fileExt = strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // get image extension
		
	// valid image extensions
	$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); 
					
	// allow valid image file formats
	if(in_array($fileExt, $valid_extensions))
	{				
		//check file not exist our upload folder path
		if(!file_exists($upload_path . $fileName))
		{
			// check file size '5MB'
			if($fileSize < 5000000){



				$date = date_create();
				$newfile =  date_timestamp_get($date);
				move_uploaded_file($tempPath, $upload_path . $fileName); // move file from system temporary path to our upload folder path 
			}
			else{		
				$errorMSG = json_encode(array("message" => "Sorry, your file is too large, please upload 5 MB size", "status" => false));	
				echo $errorMSG;
			}
		}
		else
		{		
			$errorMSG = json_encode(array("message" => "Sorry, file already exists check upload folder", "status" => false));	
			echo $errorMSG;
		}
	}
	else
	{		http_response_code(400);
		$errorMSG = json_encode(array("message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed", "status" => false));	
		echo $errorMSG;		
	}
}

$imageName = $upload_path . $fileName;
// if no error caused, continue ....
if(!isset($errorMSG))
{
	$sql = "INSERT INTO `foods`( `id`,`name`, `description`,`price`,`restaurant_id`,`available`,`image`) 
    VALUES ('$food_id','$name','$description','$price','$restaurantId','$isAvailable','$imageName')";
    if (mysqli_query($CONNECTION, $sql)) {
        $message = json_encode(array("message" => "Food Created Successfully", "status" => true));
		http_response_code(201);	
        echo $message;
    } 
	else {
		echo "An error occured"; 
		http_response_code(400);
        $message = json_encode(array("message" => mysqli_error($CONNECTION), "status" => false));
        echo $message;

    }
}
else{
	http_response_code(400);
}
    
?>