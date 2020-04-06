<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login UI</title>
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Kanit&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="loginstyle.css">
</head>
<body>
    <img class="wave" src="wave.png">
    <div class="container">
        <div class="img">
            <img src="img/bg.svg">
        </div>
        <div class="login-container">
            <form action ="process.php" method="POST">
                <img class="avatar" src="img/avatar.svg">
                <h1>Welcome</h1>
                <h2>RUTS Places Rental</h2>
                <h3>ระบบบริหารการจัดการเช่าสถานที่ราชการ</h3>
                <div class = "input-div one focus">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <h5>Username</h5>
                        <input class = "input" type = "text"  name="user" id="user" required>
                    </div>
                </div>
                <div class="input-div">
                    <div class = "i">
                        <i class = "fas fa-lock"></i>
                    </div>
                    <div>
                        <h5>Password</h5>
                        <input class = "input" type = "password" name="pass" id="pass" required>
                    </div>
                </div>
                <a href="#">Forgot Password?</a>
                <a href="Register.php">Sign Up</a>
                <input type="submit" class="btn" value="Login">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="main.js"></script>
</body>
</html>