<?php
require_once('Authentication.php');
$connection = new Connection();

	if(isset($_GET['code'])){
	$userId=$_GET['uid'];
	$code=$_GET['code'];
 
	$query=mysqli_query($connection->connectToLocalDb(),"select * from restaurants where id='$userId'");
	$row=mysqli_fetch_array($query);
 
	if($row['token']==$code){
		//activate account
		mysqli_query($connection->connectToLocalDb(),"update restaurants set is_verified ='1' where id='$userId'");
		?>
		<p>Account Verified!</p>
		<p><a href="index.php">Login Now</a></p>
		<?php
	}
	else{
		$_SESSION['sign_msg'] = "Something went wrong. Please sign up again.";
  		header('location:signup.php');
	}
	}
	else{
		header('location:index.php');
	}
?>