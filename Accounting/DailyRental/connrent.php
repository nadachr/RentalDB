<?php

    $servname = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'rentaldb';
    $conn = mysqli_connect($servname, $user, $pass, $dbname);
    if(!$conn){
        die($conn -> error());
    }
    $conn -> set_charset('utf8');
?>