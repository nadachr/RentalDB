<?php 
    include "connrent.php";

    if(isset($_GET['dpayid'])){
        $payid = $_GET['dpayid'];

        $query = mysqli_query($conn, "UPDATE DPayment SET DPayStatus = 1 WHERE DRentID = $payid");

        echo $payid;
        #header("location:PayDdetail.php?rent=$payid");
    }

    if(isset($_GET['mpayid'])){
        $payid = $_GET['mpayid'];

        $query = mysqli_query($conn, "UPDATE MPayment SET MPayStatus = 1 WHERE MRentID = $payid");

        echo $payid;
        header("location:PayMdetail.php?rent=$payid");
    }


?>