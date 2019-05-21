<?php 
    session_start();
    $_SESSION['message'] = "";
    $dbServer = "localhost";
    $dbUsername = "talha.sen";
    $dbPassword = "p2yjILda";
    $dbName = "talha_sen";

    $con = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);

    if($con -> connect_error) {
        die("Connection Failed: " . $con -> connect_error);
    }

    if(isset($_POST['loginButton'])) {
        // echo "Button is Clicked. <br>" ;
        $userLog = $_POST["usernameLog"];
        $passLog = $_POST["passwordLog"];

        $checkUser = "SELECT username FROM user WHERE username = '$userLog' AND password = '$passLog';";
        $existsUserResult = $con->query($checkUser);

        // echo "username: " . $userLog . "<br>" ;
        // echo "password: " . $passLog . "<br>" ;
        //echo $existsUserResult->num_rows;

        if ($existsUserResult->num_rows == 0) {
            // echo "Wrong username or password <br>";
            // echo "<a href= \"index.php\"> Try again </a>";
            $_SESSION['message'] = "<span style=\"color:red\"> Login failed! Try again. </span>";
        }
        else {
            // echo "Login Successful!";
            $_SESSION['user'] = $userLog;
            header("location: profile.php");
        }
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <!------ Include the above in your HEAD tag ---------->
    </head>
    <body>
        <div id="demo" class="carousel slide" data-ride="carousel" data-interval="1500">
            <div class="carousel-inner">
                <div id="content-wrapper" class="wrapper">
                    <div class="wrapper fadeInDown">
                        <div id="formContent">
                            <div class="fadeIn first">
                                <img class="img-fluid" src="icon.jpeg" id="icon" alt="GatherTogether"/>
                            </div>
                            <form action="login.php" method="post" >
                                <div class="alert alert-error"><?= $_SESSION['message']?></div>
                                <input type="text" class="fadeIn second" name="usernameLog" placeholder="Please enter username" required>
                                <input type="password" class="fadeIn third" name="passwordLog" placeholder="Please enter password" required>
                                <input type="submit" name ="loginButton" class="fadeIn fourth" value="Log In">
                            </form>
                            <div id="formFooter">
                                <p> Don't have an account yet? <a class="underlineHover" href="signup.php">Sign up.</a> </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item item active" style= "background-image:url(img1.jpg)">
                </div>
                <div class="carousel-item item" style ="background-image:url(img2.jpg)" >
                </div>
                <div class="carousel-item item" style ="background-image:url(img3.jpeg)">
                </div>
                <div class="carousel-item item" style ="background-image:url(img4.jpg)">
                </div>
            </div>
        </div>
    </body>
</html>