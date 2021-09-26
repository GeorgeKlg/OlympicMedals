<?php      
    $host = "localhost";  
    $user = "george";  
    $password = '';  
    $db_name = "testing";  
      
    $con = mysqli_connect($host, $user, $password, $db_name);  
    if(mysqli_connect_errno()) {  
        die("Failed to connect with MySQL: ". mysqli_connect_error());  
    }  
?>  
