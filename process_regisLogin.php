<?php 
    session_start();

    include "connrent.php";
    
    if(isset($_POST['username'])){
        
        $username = stripslashes($_POST['username']);
        $username = mysqli_escape_string($conn, $username);
        $password = stripslashes($_POST['password']);
        $password = mysqli_escape_string($conn, $password);
        $email = stripslashes($_POST['email']);
        $email = mysqli_escape_string($conn, $email);

        $user_check = "SELECT * FROM Login WHERE LogUser = '$username' LIMIT 1;";
        $result = mysqli_query($conn, $user_check);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if($user['LogUser'] == $username){
            echo "<script>alert('Username already exists');</script>";
        } else {
            $pushLog = "INSERT INTO Login(LogUser, LogPass, LogEmail)
                    VALUES('$username',md5('$password'), '$email');";
            $result = mysqli_query($conn, $pushLog);

            if($result){
                $_SESSION['success'] = "กรอกข้อมูลส่วนตัว";
                header("location:regisProfile.php?user=$username");
            } else {
                $_SESSION['fail'] = "Register failed";
                header('location:index.php');
            }
        }
    }
?>