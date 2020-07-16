<?php 
    include "connrent.php";

    if(isset($_GET['accept'])){
        $offer = $_GET['accept'];
        $AccNo = $_GET['accno'];

        $query = mysqli_query($conn, "UPDATE monthlyoffer SET MOfferResult = 'accepted' WHERE MOfferID = $offer;");
        $query2 = mysqli_query($conn, "INSERT INTO monthlyrental(MOfferID) VALUE ($offer);");
        
        function fetchRent($offer){
            include "connrent.php";
            //ดึง DRentID ล่าสุดจากฐานข้อมูล
            $query = mysqli_query($conn, "SELECT * FROM monthlyrental WHERE MOfferID = $offer");
            $resultArray = array();

            while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
                array_push($resultArray, $row);
            }
            mysqli_close($conn);
            return $resultArray;
        }

        $fetchRent = fetchRent($offer);

        foreach($fetchRent as $row){
            $RentID = $row['MRentID'];
        }

        #echo $RentID;
        header("location:MRentSentPay.php?rent=$RentID&accno=$AccNo&offer=$offer");
    }

    if(isset($_GET['reject'])){
        $offer = $_GET['reject'];
        $AccNo = $_GET['accno'];

        $query = mysqli_query($conn, "UPDATE monthlyoffer SET MOfferResult = 'rejected' WHERE MOfferID = $offer;");
        $query2 = mysqli_query($conn, "INSERT INTO monthlyrental(MOfferID) VALUE ($offer);");
        #echo $offer;
        header("location:MRentDetail.php?accno=$AccNo&offer=$offer");
    }


?>
