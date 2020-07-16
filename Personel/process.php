<?php
    function fetchT($id){
        include "connrent.php";
        $query = mysqli_query($conn, "SELECT * FROM vtypedf WHERE TypeID = $id");
        $resultArray = array();

        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $row);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    function fetchDF($agency){
        include "connrent.php";
        $query = mysqli_query($conn, "SELECT * FROM dailyfee WHERE DFagency = $agency;");
        $resultArray = array();

        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $row);
        }
        mysqli_close($conn);
        return $resultArray;
    }
    include "connrent.php";
    session_start();

    $update = false;
    $id = 0;
    $typeE = '';
    $typeT = '';
    $seat = '';
    $agency = '';
    $private = '';

    if(isset($_POST['submit'])){
        $typeT = $_POST['typeT'];
        $typeE = $_POST['typeE'];
        $seat = $_POST['seat'];
        $agency = $_POST['df'];

        $query = mysqli_query($conn, "INSERT INTO type(TypeTName, TypeEname, TypeSeat, DFID)
                                      VALUES('$typeT', '$typeE', '$seat', $agency);");

        #echo "INSERT INTO type(TypeTName, TypeEname, TypeSeat, DFID)
        #VALUES('$typeT', '$typeE', '$seat', $agency);";
        header('location:placeDF.php');
    }

    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        $query = mysqli_query($conn, "DELETE FROM type WHERE TypeID = $id");

        header('location:placeDF.php');
    }

    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        $typeF = fetchT($id);
        $update = true;
        foreach($typeF as $row){
            $typeT = $row['TypeTName'];
            $typeE = $row['TypeEname'];
            $seat = $row['TypeSeat'];
            $agency = $row['DFagency'];
            $private = $row['DFprivate'];
        }
    }

    if(isset($_POST['update'])){
        $id = $_POST['typeID'];
        $typeT = $_POST['typeT'];
        $typeE = $_POST['typeE'];
        $seat = $_POST['seat'];
        $agency = $_POST['df'];

        $updateT = mysqli_query($conn, "UPDATE type SET TypeTName = '$typeT', TypeEname = '$typeE', 
                                    TypeSeat = '$seat', DFID = $agency WHERE TypeID = $id;");

        #echo "UPDATE Type SET TypeTName = '$typeT', TypeEname = '$typeE', 
        #TypeSeat = '$seat', DFID = $agency WHERE TypeID = $id";
        header('location: PlaceDF.php');
    }
?>