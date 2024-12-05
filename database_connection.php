<?php
    $host = 'localhost';
    $user = 'dkl67';
    $password = 'wf4itv4/E3f0EfSS';
    $database = 'dkl67_db';
    $connection = mysqli_connect($host, $user, $password, $database);
    if(!$connection){
        die("Connection failed: " . mysqli_connect_error());
    }
    echo "Connected successfully!";
?>