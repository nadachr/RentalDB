<?php 
    session_start();

    include "connrent.php";
    
    if(isset($_POST['firstEname'])){
        
        $logid = stripslashes($_POST['logid']);
        $logid = mysqli_escape_string($conn, $logid);
        $prefix = stripslashes($_POST['prefix']);
        $prefix = mysqli_escape_string($conn, $prefix);
        $firstEname = stripslashes($_POST['firstEname']);
        $firstEname = mysqli_escape_string($conn, $firstEname);
        $lastEname = stripslashes($_POST['lastEname']);
        $lastEname = mysqli_escape_string($conn, $lastEname);
        $firstTname = stripslashes($_POST['firstTname']);
        $firstTname = mysqli_escape_string($conn, $firstTname);
        $lastTname = stripslashes($_POST['lastTname']);
        $lastTname = mysqli_escape_string($conn, $lastTname);
        $accid = stripslashes($_POST['accid']);
        $accid = mysqli_escape_string($conn, $accid);
        $bdate = stripslashes($_POST['bdate']);
        $bdate = mysqli_escape_string($conn, $bdate);
        $email = stripslashes($_POST['email']);
        $email = mysqli_escape_string($conn, $email);
        $tel = stripslashes($_POST['tel']);
        $tel = mysqli_escape_string($conn, $tel);
        $inst = stripslashes($_POST['inst']);
        $inst = mysqli_escape_string($conn, $inst);
        $addr = stripslashes($_POST['addr']);
        $addr = mysqli_escape_string($conn, $addr);
        $dist = stripslashes($_POST['dist']);
        $dist = mysqli_escape_string($conn, $dist);
        $prov = stripslashes($_POST['prov']);
        $prov = mysqli_escape_string($conn, $prov);
        $city = stripslashes($_POST['city']);
        $city = mysqli_escape_string($conn, $city);
        $postcode = stripslashes($_POST['postcode']);
        $postcode = mysqli_escape_string($conn, $postcode);

        $pushAcc = "INSERT INTO Account(LogID, AccID, PreID, AccFName, AccLName, AccEngFName, AccEngLName, AccBirthdate, AccPhone, AccInst, AccAddress, AccDistrict, AccProvince, AccCity, AccPostcode)
            VALUES($logid, '$accid', $prefix, '$firstTname', '$lastTname', '$firstEname', '$lastEname','$bdate', '$tel','$inst','$addr','$dist','$prov','$city','$postcode');";
        $result = mysqli_query($conn, $pushAcc);

        if($result){
            $_SESSION['success'] = "Register Successfully";
            header('location:index.php');
        } else {
            echo "<script>alert('Register failed');</script>";
            header("location:regisProfile.php?user=$logid");
        }
    }
?>