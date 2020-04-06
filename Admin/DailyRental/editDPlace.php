<?php
    function fetchT($id){
        include "connrent.php";
        $query = mysqli_query($conn, "SELECT * FROM DailyType WHERE DTID = $id");
        $resultArray = array();

        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $row);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    include "connrent.php";

    $id = 0;
    $placeE = '';
    $placeT = '';
    $location = '';

    
    if((isset($_GET['p']))&(isset($_GET['placehid']))){
        $p = $_GET['p'];
        $show = $_GET['show'];
        $id = $_GET['placehid'];

        $query = mysqli_query($conn, "UPDATE DailyPlace SET DPlaceStatus = 0 WHERE DPlaceID = $id");
        header("location:DailyPlace.php?p=$p&show=$show");
        #echo $page;
    }

    if((isset($_GET['p']))&(isset($_GET['placeshow']))){
        $p = $_GET['p'];
        $show = $_GET['show'];
        $id = $_GET['placeshow'];

        $query = mysqli_query($conn, "UPDATE DailyPlace SET DPlaceStatus = 1 WHERE DPlaceID = $id");
        header("location:DailyPlace.php?p=$p&show=$show");
        #echo $page;
    }

    if(isset($_POST['submit'])){
        $page = $_POST['page'];
        $placeNo = $_POST['placeNo'];
        $placeT = $_POST['placeT'];
        $placeE = $_POST['placeE'];
        $location = $_POST['location'];
        $DTID = $_POST['placeType'];
        $query = mysqli_query($conn, "INSERT INTO DailyPlace(DPlaceNo, DPlaceEname, DPlaceTName, DTID, LocID)
                                      VALUES($placeNo, '$placeE', '$placeT', $DTID, $location);");

        #echo "INSERT INTO DailyPlace(DPlaceNo, DPlaceEname, DPlaceTName, DTID, LocID)
        #                            VALUES($placeNo, '$placeE', '$placeT', $DTID, $location)";
        header("location:DailyPlace.php?show=$page");
    }

    if(isset($_POST['update'])){
        $page = $_POST['page'];
        $id = $_POST['placeID'];
        $placeNo = $_POST['placeNo'];
        $placeT = $_POST['placeT'];
        $placeE = $_POST['placeE'];
        $location = $_POST['location'];
        $DTID = $_POST['placeType'];

        $updateT = mysqli_query($conn, "UPDATE DailyPlace SET DPlaceNo = $placeNo, DPlaceTName = '$placeT', DPlaceEName = '$placeE', 
                                    DTID = $DTID, LocID = $location WHERE DPlaceID = $id;");

        #echo "UPDATE DailyPlace SET DPlaceNo = $placeNo, DPlaceTName = '$placeT', DPlaceEName = '$placeE', 
        #    DTID = $DTID, LocID = $location WHERE DPlaceID = $id;";
        header("location:DPlaceDetail.php?show=$page");
    }   
?>