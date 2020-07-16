<?php
    function fetchT($id){
        include "connrent.php";
        $query = mysqli_query($conn, "SELECT * FROM monthlytype WHERE MTID = $id");
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
    $interm = '';
    $offterm = '';
    $maintain = '';

    if(isset($_POST['submit'])){
        $typeT = $_POST['typeT'];
        $typeE = $_POST['typeE'];
        $interm = $_POST['interm'];
        $offterm = $_POST['offterm'];
        $maintain = $_POST['maintain'];

        $query = mysqli_query($conn, "INSERT INTO monthlytype(MTTName, MTEName, MTInTerm, MTOffTerm, MTmaintain)
                                      VALUES('$typeT', '$typeE', $interm, $offterm, $maintain);");

        #echo "INSERT INTO type(TypeTName, TypeEname, Typeinterm, DFID)
        #VALUES('$typeT', '$typeE', '$interm', $offterm, $maintain);";
        header('location:MonthlyType.php');
    }

    if((isset($_GET['p']))&(isset($_GET['hid']))){
        $p = $_GET['p'];
        $id = $_GET['hid'];

        $query = mysqli_query($conn, "UPDATE monthlytype SET MTStatus = 0 WHERE MTID = $id");

        header("location:MonthlyType.php?p=$p");
    }

    if((isset($_GET['p']))&(isset($_GET['push']))){
        $p = $_GET['p'];
        $id = $_GET['push'];

        $query = mysqli_query($conn, "UPDATE monthlytype SET MTStatus = 1 WHERE MTID = $id");

        header("location:MonthlyType.php?p=$p");
    }

    if(isset($_GET['edit'])){
        $update = true;
        $id = $_GET['edit'];
        $result = fetchT($id);

        foreach($result as $row){
            $typeT = $row['MTTName'];
            $typeE = $row['MTEName'];
            $interm = $row['MTInTerm'];
            $offterm = $row['MTOffTerm'];
            $maintain = $row['MTmaintain'];
        }
    }

    if(isset($_POST['update'])){
        $p = $_POST['p'];
        $id = $_POST['typeID'];
        $typeT = $_POST['typeT'];
        $typeE = $_POST['typeE'];
        $interm = $_POST['interm'];
        $offterm = $_POST['offterm'];
        $maintain = $_POST['maintain'];

        $updateT = mysqli_query($conn, "UPDATE monthlytype SET MTTName = '$typeT', MTEname = '$typeE', 
                                    MTInTerm = '$interm', MTOffTerm = $offterm, MTmaintain = $maintain WHERE MTID = $id;");

        #echo "UPDATE Type SET TypeTName = '$typeT', TypeEname = '$typeE', 
        #Typeinterm = '$interm', DFID = $offterm WHERE TypeID = $id";
        header("location:MonthlyType.php?p=$p");
    }   
?>