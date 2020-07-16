<?php 
    include "connrent.php";

    if(isset($_GET['accept'])){
        $offer = $_GET['accept'];
        $AccNo = $_GET['accno'];

        $query = mysqli_query($conn, "UPDATE monthlyoffer SET MOfferResult = 'accepted' WHERE MOfferID = $offer;");
        $query2 = mysqli_query($conn, "INSERT INTO monthlyrental(MOfferID) VALUE ($offer);");
        
        function fetchRent($accno){
            include "connrent.php";
            //ดึง DRentID ล่าสุดจากฐานข้อมูล
            $query = mysqli_query($conn, "SELECT * FROM monthlyrental WHERE MRentStatus = 0 AND AccNo = $accno AND MRentStart = (SELECT MAX(MRentStart) FROM Monthlyrental WHERE MRentID = MRentID );");
            $resultArray = array();

            while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
                array_push($resultArray, $row);
            }
            mysqli_close($conn);
            return $resultArray;
        }

        $fetchRent = fetchRent($AccNo);

        foreach($fetchRent as $row){
            $RentID = $row['MRentID'];
        }

        #echo $offer;
        header("location:MRentSentPay.php?rent=$RentID&accno=$AccNo&offer=$offer");
    }

    if(isset($_GET['reject'])){
        $offer = $_GET['reject'];
        $AccNo = $_GET['accno'];

        $query = mysqli_query($conn, "UPDATE monthlyoffer SET MOfferResult = 'rejected' WHERE MOfferID = $offer;");
        #$query2 = mysqli_query($conn, "INSERT INTO MonthlyRental(MOfferID) VALUE ($offer);");
        #echo $offer;
        header("location:MRentDetail.php?accno=$AccNo&offer=$offer");
    }


?>
