<?php
    include "connrent.php";
    
    if(isset($_GET['accept'])){
        $AccNo = $_GET['accept'];
        $role = 6;

        $updateT = mysqli_query($conn, "INSERT INTO accrole(RoleID, AccNo) VALUES($role, $AccNo);");

        header("location:userSent.php?show=$AccNo&accept=$AccNo");
    }  

    if(isset($_POST['update'])){
        $AccNo = $_POST['accno'];
        $role = $_POST['role'];

        $updateT = mysqli_query($conn, "UPDATE accrole SET RoleID=$role WHERE AccNo=$AccNo");
        #echo "UPDATE AccRole SET RoleID=$role WHERE AccNo=$AccNo);";
        header("location:userSent.php?show=$AccNo&accept=$AccNo");
    }  
    
    if(isset($_GET['bann'])){
        $AccNo = $_GET['bann'];

        $updateT = mysqli_query($conn, "UPDATE accrole SET ArStatus = 0, RoleID = 7 WHERE AccNo = $AccNo");

        header("location:userSent.php?show=$AccNo&accept=$AccNo");
    }   
?>