<?php 
    include "connrent.php";

    if(isset($_GET['dpayid'])){
        $rent = $_GET['rent'];
        $payid = $_GET['dpayid'];

        $query = mysqli_query($conn, "UPDATE DPayment SET DPayStatus = 1 WHERE DPayID = $payid");

        echo $payid;
        header("location:PayDdetail.php?rent=$rent&pay=$payid");
    }

    if(isset($_GET['mpayid'])){
        $payid = $_GET['mpayid'];

        $query = mysqli_query($conn, "UPDATE MPayment SET MPayStatus = 1 WHERE MPayID = $payid");

        echo $payid;
        header("location:PayMdetail.php?rent=$payid");
    }


?>