<?php 
    include "connrent.php";

    if((isset($_GET['dprent']))&(isset($_GET['accno']))){
        $AccNo = $_GET['accno'];
        $dplace = $_GET['dprent'];

        //$query = mysqli_query($conn, "INSERT INTO DailyRental(AccNo) VALUE($AccNo);");

        function fetchRent($accno){
            include "connrent.php";
            //ดึง DRentID ล่าสุดจากฐานข้อมูล
            $query = mysqli_query($conn, "SELECT * FROM DailyRental WHERE DRentStatus = 0 AND AccNo = $accno AND DRentTimeStamp = (SELECT MAX(DRentTimeStamp) FROM dailyrental WHERE DRentID = DRentID );");
            $resultArray = array();

            while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
                array_push($resultArray, $row);
            }
            mysqli_close($conn);
            return $resultArray;
        }

        $fetchRent = fetchRent($AccNo);

        foreach($fetchRent as $row){
            $RentID = $row['DRentID'];
        }
        echo $AccNo.' '.$dplace.' '.$RentID;
        header("location:DailyRentDetail.php?rent=$RentID&dprent=$dplace");
    }

    if((isset($_POST['rent']))&(isset($_POST['sent']))&(isset($_POST['chk']))){
        $DRentID = $_POST['rent'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $DPlaceID = $_POST['placeID'];
        $EqID = $_POST['equip'];
        $total = $_POST['total'];

        //$query2 = mysqli_query($conn, "INSERT INTO DailyRentDetail VALUE($DRentID, $DPlaceID, $EqID, '$start', '$end', $total)");

        #echo "INSERT INTO DailyRentDetail VALUE($DRentID, $DPlaceID, '$start', '$end', '$total)";

        header("location:DailyRentSuccess.php?rent=$DRentID");
    }

    if((isset($_POST['rent']))&(isset($_POST['sent']))&(isset($_POST['chk'])==0)){
        $DRentID = $_POST['rent'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $DPlaceID = $_POST['placeID'];
        $total = $_POST['total'];

       // $query2 = mysqli_query($conn, "INSERT INTO DailyRentDetail(DRentID, DPlaceID, DRentStart, DRentEnd, DRentAmount) VALUE($DRentID, $DPlaceID, '$start', '$end', $total)");

        echo "INSERT INTO DailyRentDetail VALUE($DRentID, $DPlaceID, '$start', '$end', '$total)";
        header("location:DailyRentSuccess.php");
    }



?>