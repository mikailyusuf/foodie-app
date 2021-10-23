<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <title>Welcome</title>
</head>
<body>
<style>
    .container {
        height: 200px;
        position: relative;
    }

    .center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 200px;
    }
</style>
<?php
require_once('Authentication.php');
$connection = new Connection();

if (isset($_GET['code'])) {
    $userId = $_GET['uid'];
    $code = $_GET['code'];

    $query = mysqli_query($connection->connectToDb(), "select * from restaurants where id='$userId'");
    $row = mysqli_fetch_array($query);

    if ($row['token'] == $code) {
        if ($row['is_verified'] == "1") {
            echo "<div class='alert' 'alert-primary' role='alert'>
           Account verified already </div>";
        } else {

            mysqli_query($connection->connectToDb(), "update restaurants set is_verified ='1', is_active = '1' where id='$userId'");
            echo "<div class='alert' 'alert-primary' role='alert'>
           Congrats !! Your email has been verified</div>";
        }
    } else {
        echo "<div class='alert' 'alert-danger' role='alert'>
           Sorry an error occured</div>";
        $_SESSION['sign_msg'] = "Something went wrong. Please sign up again.";
        header('location:signup.php');
    }
} else {
    header('location:web/index.html');
}

?>


<div class="container">
    <div class="center">
        <button type="button" class="btn btn-primary"><a href="web/index.html"> Check us Out</a></button>
    </div>
</div>
</body>
</html>



