<?php
include 'config.php';

try{

        $sql = "SELECT * FROM foods";  
        $result = mysqli_query($CONNECTION, $sql);
        // $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        // $count = mysqli_num_rows($result);

        $emparray = array();
        while($row =mysqli_fetch_assoc($result))
        {
            $emparray[] = $row;
        }

        echo json_encode($emparray);

    
		
}
catch(Exception $e) {
    http_response_code(401);
    echo('Message: ' .$e->getMessage());
    $message = json_encode(array("message" => $e->getMessage(),"status" => false));	
    echo $message;
  }