<?php

//Generate a random string.

function generateToken(){
    $token = openssl_random_pseudo_bytes(16);

    //Convert the binary data into hexadecimal representation.
    $token = bin2hex($token);
    
    //Print it out for example purposes.
    return $token;
}
?>