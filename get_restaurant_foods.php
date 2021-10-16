<?php
include 'config.php';

try{
$json_string = file_get_contents( "php://input");
$data = json_decode($json_string,true);

		$id=stripcslashes($data['id']);
        $restaurant_id = mysqli_real_escape_string($CONNECTION, $id);
	

        $sql = "SELECT * FROM foods WHERE restaurant_id = '$restaurant_id' ";  
            $result = mysqli_query($CONNECTION, $sql);
          
            $emparray = array();
            while($row =mysqli_fetch_assoc($result))
            {
                $emparray[] = $row;
            }
            
            http_response_code(200);
            echo json_encode($emparray);
		
}
catch(Exception $e) {
    http_response_code(400);
    echo('Message: ' .$e->getMessage());
    $message = json_encode(array("message" => $e->getMessage(),"status" => false));	
    echo $message;
  }