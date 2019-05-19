<?php 
    session_start();
    $_SESSION['message'] = "";
    $dbServer = "localhost";
    $dbUsername = "talha.sen";
    $dbPassword = "p2yjILda";
    $dbName = "talha_sen";

    $con = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);

    if($con -> connect_error) {
            die("Connection Failed: " . $con -> connect_error) . "<br>";
    }

    if(isset($_POST['registerButton'])) {
        //echo "Button is Clicked. <br>" ;
        
        if($_POST['passwordReg'] == $_POST['passwordReg2']){
            
            //echo "Passwords are matching. <br>";
            
            $userReg = $con->real_escape_string($_POST["usernameReg"]);
            $passReg = $con->real_escape_string($_POST["passwordReg"]);
            $nameOfUser = $con->real_escape_string($_POST["nameOfUser"]);
            $surnameOfUser = $con->real_escape_string($_POST["surnameOfUser"]);
            $emailaddress = $con->real_escape_string($_POST["emailaddress"]);
            
            $nameTogether = ucwords($nameOfUser . " " . $surnameOfUser);
            //echo "username: " . $userReg . "<br>";
            //echo "password: " . $passReg;
            $registerQuery = "INSERT INTO user(username, name, email, password) VALUES('$userReg', '$nameTogether', '$emailaddress', '$passReg');";
            
            if($con->query($registerQuery) === true) {
                $_SESSION['user'] = $userReg;
                header("location: profile.php");
            } else {
                $_SESSION['message'] = "<span style=\"color:red\"> Register is unsuccessful!</span>";
            }
          
        } else{
            $_SESSION['message'] = "<span style=\"color:red\"> Passwords do NOT match!</span>";
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
		<div class = "wrapper">
		  <div id="formContent">
			<div>
			  <img class="img-fluid" src="icon.jpeg" id="icon" alt="GatherTogether"/>
			</div>
			<form class="form" method="post" action="signup.php" >
              <div class="alert alert-error"><?= $_SESSION['message']?></div>
              <input type="text" class="fadeIn first" name="nameOfUser" placeholder="Enter your name" required>
              <input type="text" class="fadeIn second" name="surnameOfUser" placeholder="Enter your surname" required>
			  <input type="text" class="fadeIn third" name="usernameReg" placeholder="Enter a username" required>
              <input type="text" class="fadeIn fourth" name="emailaddress" placeholder="Enter your e-mail" required>
			  <input type="password" class="fadeIn fifth" name="passwordReg" placeholder="Enter a password" required>
			  <input type="password" class="fadeIn sixth" name="passwordReg2" placeholder="Confirm the password" required>
              
                
			  <input type="submit" name = "registerButton" class="fadeIn seventh" value="Sign Up">
			 </form> 
			<div id="formFooter">
			  <p> Already have an account? <a class="underlineHover" href="login.php">Log In.</a> </p>
			</div>
		  </div>
		</div>   
	</body>
</html>