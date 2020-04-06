<?php

    include "connrent.php";

    $id = 0;
    $placeE = '';
    $placeT = '';
    $location = '';

    if((isset($_GET['p']))&(isset($_GET['offer']))){
        $p = $_GET['p'];
        $id = $_GET['offer'];

        $query = mysqli_query($conn, "UPDATE MonthlyOffer SET MOfferStatus = 1 WHERE MOfferID = $id");
        header("location:MOfferRent.php?p=$p");
        #echo "UPDATE MonthlyOffer SET MOfferStatus = 1 WHERE MOfferID = $id";
    }

    if((isset($_GET['p']))&(isset($_GET['placeshow']))){
        $p = $_GET['p'];
        $show = $_GET['show'];
        $id = $_GET['placeshow'];

        $query = mysqli_query($conn, "UPDATE MonthlyPlace SET MPlaceStatus = 1 WHERE MPlaceID = $id");
        header("location:MonthlyPlace.php?p=$p&show=$show");
        #echo $page;
    }

    if(isset($_POST['submit'])){
        $page = $_POST['page'];
        $placeT = $_POST['placeT'];
        $placeE = $_POST['placeE'];
        $location = $_POST['location'];
        $MTID = $_POST['placeType'];
        $query = mysqli_query($conn, "INSERT INTO MonthlyPlace(MPlaceEName, MPlaceTName, MTID, LocID)
                                      VALUES('$placeE', '$placeT', $MTID, $location);");

        #echo "INSERT INTO MonthlyPlace(MPlaceNo, MPlaceEname, MPlaceTName, MTID, LocID)
        #                            VALUES($placeNo, '$placeE', '$placeT', $MTID, $location)";
        header("location:MonthlyPlace.php?show=$page");
    }
    
    if(isset($_POST['update'])){
        $page = $_POST['page'];
        $id = $_POST['placeID'];
        $placeT = $_POST['placeT'];
        $placeE = $_POST['placeE'];
        $location = $_POST['location'];
        $MTID = $_POST['placeType'];

        $updateT = mysqli_query($conn, "UPDATE MonthlyPlace SET MPlaceTName = '$placeT', MPlaceEName = '$placeE', 
                                    MTID = $MTID, LocID = $location WHERE MPlaceID = $id;");

        #echo "UPDATE MonthlyPlace SET MPlaceTName = '$placeT', MPlaceEName = '$placeE', 
         #   MTID = $MTID, LocID = $location WHERE MPlaceID = $id;";
        header("location:MPlaceDetail.php?show=$page");
    }   
?>