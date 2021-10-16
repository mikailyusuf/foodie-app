<?php
require_once('Authentication.php');
$connection = new Connection();

	if(isset($_GET['code'])){
	$userId=$_GET['uid'];
	$code=$_GET['code'];
 
	$query=mysqli_query($connection->connectToliveDb(),"select * from restaurants where id='$userId'");
	$row=mysqli_fetch_array($query);
 
	if($row['token']==$code){
		//activate account
		mysqli_query($connection->connectToliveDb(),"update restaurants set is_verified ='1', is_active = '1' where id='$userId'");
		?>
		<p>Account Verified!</p>
		<p><a href="https://rocky-badlands-50144.herokuapp.com/index.html">Login Now</a></p>
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