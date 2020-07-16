<?php
    function fetchT($id){
        include "connrent.php";
        $query = mysqli_query($conn, "SELECT * FROM dailyType WHERE DTID = $id");
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
    $typeE = '';
    $typeT = '';
    $seat = '';
    $agency = '';
    $private = '';

    if(isset($_POST['submit'])){
        $typeT = $_POST['typeT'];
        $typeE = $_POST['typeE'];
        $seat = $_POST['seat'];
        $agency = $_POST['agency'];
        $private = $_POST['private'];

        $query = mysqli_query($conn, "INSERT INTO dailytype(DTTName, DTEname, DTSeat, DTAgency, DTPrivate)
                                      VALUES('$typeT', '$typeE', '$seat', $agency, $private);");

        #echo "INSERT INTO type(TypeTName, TypeEname, TypeSeat, DFID)
        #VALUES('$typeT', '$typeE', '$seat', $agency);";
        header('location:DailyType.php');
    }

    if((isset($_GET['p']))&(isset($_GET['hid']))){
        $p = $_GET['p'];
        $id = $_GET['hid'];

        $query = mysqli_query($conn, "UPDATE dailytype SET DTStatus = 0 WHERE DTID = $id");

        header("location:DailyType.php?p=$p");
    }

    if((isset($_GET['p']))&(isset($_GET['push']))){
        $p = $_GET['p'];
        $id = $_GET['push'];

        $query = mysqli_query($conn, "UPDATE dailytype SET DTStatus = 1 WHERE DTID = $id");

        header("location:DailyType.php?p=$p");
    }

    if((isset($_GET['p']))&(isset($_GET['edit']))){
        $update = true;
        $id = $_GET['edit'];
        $result = fetchT($id);

        foreach($result as $row){
            $typeT = $row['DTTName'];
            $typeE = $row['DTEName'];
            $seat = $row['DTSeat'];
            $agency = $row['DTAgency'];
            $private = $row['DTPrivate'];
        }
    }

    if((isset($_GET['p']))&(isset($_GET['update']))){
        $p = $_GET['p'];
        $id = $_POST['typeID'];
        $typeT = $_POST['typeT'];
        $typeE = $_POST['typeE'];
        $seat = $_POST['seat'];
        $agency = $_POST['agency'];
        $private = $_POST['private'];

        $updateT = mysqli_query($conn, "UPDATE dailytype SET DTTName = '$typeT', DTEname = '$typeE', 
                                    DTSeat = '$seat', DTAgency = $agency, DTPrivate = $private WHERE DTID = $id;");

        #echo "UPDATE Type SET TypeTName = '$typeT', TypeEname = '$typeE', 
        #TypeSeat = '$seat', DFID = $agency WHERE TypeID = $id";
        header("location:DailyType.php?p=$p");
    }   
?>