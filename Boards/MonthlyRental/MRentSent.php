<?php 
    include "connrent.php";

    if(isset($_GET['accept'])){
        $offer = $_GET['accept'];
        $AccNo = $_GET['accno'];

        $query = mysqli_query($conn, "UPDATE monthlyoffer SET MOfferResult = 'accepted' WHERE MOfferID = $offer;");
        $query2 = mysqli_query($conn, "INSERT INTO MonthlyRental(MOfferID) VALUE ($offer);");
        #echo $offer;
        header("location:MRentDetail.php?accno=$AccNo&offer=$offer");
    }

    if(isset($_GET['reject'])){
        $offer = $_GET['reject'];
        $AccNo = $_GET['accno'];

        $query = mysqli_query($conn, "UPDATE monthlyoffer SET MOfferResult = 'rejected' WHERE MOfferID = $offer;");
        $query2 = mysqli_query($conn, "INSERT INTO MonthlyRental(MOfferID) VALUE ($offer);");
        #echo $offer;
        header("location:MRentDetail.php?accno=$AccNo&offer=$offer");
    }


?>
