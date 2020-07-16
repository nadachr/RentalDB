<?php 
    include "connrent.php";

    if((isset($_GET['dprent']))&(isset($_GET['rent']))){
        $RentID = $_GET['rent'];
        $dplace = $_GET['dprent'];

        $query = mysqli_query($conn, "INSERT INTO dpayment(DRentID) VALUE($RentID);");
        
        #echo "INSERT INTO DPayment(DRentID) VALUE($RentID)";
        header("location:DailyRentDetail.php?rent=$RentID&dprent=$dplace");
    }

?>