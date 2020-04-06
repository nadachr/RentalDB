<?php
    include "connrent.php";
    
    if(isset($_POST['update'])){
        $AccNo = $_POST['accno'];
        $role = $_POST['role'];

        $updateT = mysqli_query($conn, "INSERT INTO AccRole(RoleID, AccNo) VALUES($role, $AccNo);");

        header("location:userSent.php?show=$AccNo&accept=$AccNo");
    }  
    
    if(isset($_GET['bann'])){
        $AccNo = $_GET['bann'];

        $updateT = mysqli_query($conn, "UPDATE AccRole SET ArStatus = 0 WHERE AccNo = $AccNo");

        header("location:userSent.php?show=$AccNo&accept=$AccNo");
    }   
?>