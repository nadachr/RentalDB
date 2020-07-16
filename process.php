<?php 
    session_start();
    // get value from index.php
    include "connrent.php";
    error_reporting(0);
    $username = $_POST['user'];
    $password = $_POST['pass'];
    
    $username = stripcslashes($username);
    $password = stripcslashes($password);
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    $password = md5($password);

    $result = mysqli_query($conn, "SELECT * FROM vlogin where LogUser = '$username' AND LogPass = '$password'")
            or die("Failed".mysqli_error($conn));

    $row = mysqli_fetch_array($result);

    $accno = $row['AccNo'];

    if ($row['LogUser']==$username && $row['LogPass']==$password && $row['AccStatus']==1 && $row['RoleEName']=='Administrator' && $row['ArStatus']==1 ){
        //echo "Login Success!!! Welccome ".$row['LogUser'];
        $_SESSION['id'] = $row['LogUser'];
        $_SESSION['name'] = $row['AccName'];
        $_SESSION['role'] = $row['RoleEName'];
        $_SESSION['AccNo'] = $row['AccNo'];
        header('location:admin/index.php');
    }else if($row['LogUser']==$username && $row['LogPass']==$password && $row['AccStatus']==1 && $row['RoleEName']=='Boards' && $row['ArStatus']==1 ){
        $_SESSION['id'] = $row['LogUser'];
        $_SESSION['name'] = $row['AccName'];
        $_SESSION['AccNo'] = $row['AccNo'];
        header("location:boards/index.php?acc=$accno");
    }else if($row['LogUser']==$username && $row['LogPass']==$password && $row['AccStatus']==1 && $row['RoleEName']=='Personnel' && $row['ArStatus']==1 ){
        $_SESSION['id'] = $row['LogUser'];
        $_SESSION['name'] = $row['AccName'];
        $_SESSION['AccNo'] = $row['AccNo'];
        header("location:personel/index.php?acc=$accno");
    }else if($row['LogUser']==$username && $row['LogPass']==$password && $row['AccStatus']==1 && $row['RoleEName']=='Accounting' && $row['ArStatus']==1 ){
        $_SESSION['id'] = $row['LogUser'];
        $_SESSION['name'] = $row['AccName'];
        $_SESSION['AccNo'] = $row['AccNo'];
        header("location:Accounting/index.php?acc=$accno");
    }else if($row['LogUser']==$username && $row['LogPass']==$password && $row['AccStatus']==1 && $row['RoleEName']=='User' && $row['ArStatus']==1 ){
        $_SESSION['id'] = $row['LogUser'];
        $_SESSION['name'] = $row['AccName'];
        $_SESSION['AccNo'] = $row['AccNo'];
        header("location:user/index.php?acc=$accno");
    }else if($row['LogUser']==$username && $row['LogPass']==$password && $row['AccStatus']==0){
        echo "<script>alert('You're not autenticated, Please Try Again Later.');</script>";
        header('refresh:1 url=http://localhost/rentaldb/index.php');
    }else if($row['LogUser']==$username && $row['LogPass']==$password && $row['AccStatus']==1 && $row['RoleEName']=='Ban'){
        echo "<script>alert('You're Banned!!!');</script>";
        header('refresh:1 url=http://localhost/rentaldb/index.php');
    }else if($row['LogUser']!=$username || $row['LogPass'] !=$password){
        echo "<script>alert('Wrong Username or Password, Please Try Again.');</script>";
        header('refresh:1 url=http://localhost/rentaldb/index.php');
    }else{echo "<script>alert('Error');</script>";
        header('refresh:1 url=http://localhost/rentaldb/index.php'); }
?>