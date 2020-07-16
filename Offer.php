<?php 
    include "connrent.php";
    ini_set('display_errors', 1);
    error_reporting(~0);


    $query = mysqli_query($conn, "SELECT COUNT(*) FROM offer WHERE OfferStatus = 0;");
    
    $resultq = mysqli_fetch_array($query, MYSQLI_ASSOC);
    
    echo $resultq["COUNT(*)"];

?>