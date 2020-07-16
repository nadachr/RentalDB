<?php
    function fetchT($id){
        include "connrent.php";
        $query = mysqli_query($conn, "SELECT * FROM equipment WHERE EqID = $id");
        $resultArray = array();

        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, $row);
        }
        mysqli_close($conn);
        return $resultArray;
    }

    include "connrent.php";
    
    $update = false;
    $id = 0;
    $equipE = '';
    $equipT = '';
    $agency = '';
    $private = '';

    if(isset($_POST['submit'])){
        $equipT = $_POST['equipT'];
        $equipE = $_POST['equipE'];
        $agency = $_POST['agency'];
        $private = $_POST['private'];

        $query = mysqli_query($conn, "INSERT INTO equipment(EqTName, EqEname, EqAgency, EqPrivate)
                                      VALUES('$equipT', '$equipE', $agency, $private);");

        #echo "INSERT INTO type(equipTName, equipEname, TypeSeat, DFID)
        #VALUES('$equipT', '$equipE', '$private', $agency);";
        header('location:Equipment.php');
    }

    if((isset($_GET['p']))&(isset($_GET['hid']))){
        $p = $_GET['p'];
        $id = $_GET['hid'];

        $query = mysqli_query($conn, "UPDATE equipment SET EqStatus = 0 WHERE EqID = $id");

        header("location:Equipment.php?p=$p");
    }

    if((isset($_GET['p']))&(isset($_GET['push']))){
        $p = $_GET['p'];
        $id = $_GET['push'];

        $query = mysqli_query($conn, "UPDATE equipment SET EqStatus = 1 WHERE EqID = $id");

        header("location:Equipment.php?p=$p");
    }

    if(isset($_GET['edit'])){
        $update = true;
        $id = $_GET['edit'];
        $result = fetchT($id);

        foreach($result as $row){
            $equipT = $row['EqTName'];
            $equipE = $row['EqEName'];
            $agency = $row['EqAgency'];
            $private = $row['EqPrivate'];
        }
    }

    if(isset($_POST['update'])){
        $page = $_POST['page'];
        $id = $_POST['EqID'];
        $equipT = $_POST['equipT'];
        $equipE = $_POST['equipE'];
        $seat = $_POST['seat'];
        $agency = $_POST['agency'];
        $private = $_POST['private'];

        $updateT = mysqli_query($conn, "UPDATE equipment SET EqTName = '$equipT', EqEname = '$equipE', 
                                    EqAgency = $agency, EqPrivate = $private WHERE EqID = $id;");

        #echo "UPDATE Type SET equipTName = '$equipT', equipEname = '$equipE', 
        #TypeSeat = '$seat', DFID = $agency WHERE TypeID = $id";
        header("location: EquipDetail.php?show=$page");
    }   
?>