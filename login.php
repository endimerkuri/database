<?php
	session_start();
?>

<html>
<head>
</head>
<body>

<?php
$serverName = "dijkstra.ug.bcc.bilkent.edu.tr";
$myUsername = "krisela.sknderi";
$myPassword = "meTFcbF4";
$dbName = "krisela_sknderi";

// Create connection
$conn = new mysqli($serverName, $myUsername, $myPassword, $dbName);

// Check connection
if( $conn->connect_error) {
    die( "Connection failed: " . $conn->connect_error);
} 

if($_SERVER["REQUEST_METHOD"] == "POST"){

	$username = $_POST["username"];
	$password = $_POST["password"];
	
	// check if any of the fields is blank and alert user
    if( $username == "" && $password == "" )
		echo "<script type='text/jscript'> alert('Username and password cannot be blank.') </script>";
	
	else if( $username == "")
		echo "<script type='text/jscript'> alert('Username cannot be blank.') </script>";
	
	else if( $password == "" )
		echo "<script type='text/jscript'> alert('Password cannot be blank.') </script>";
	
	else {
	    // get username and password from database
		$query = "SELECT cid FROM customer WHERE LOWER(name) = LOWER('$username') and cid = '$password'";
        
		if( $result = $conn->query( $query)){
			if( $result-> num_rows == 1){
				$_SESSION["username"] = $username;
				$_SESSION["password"] = $password;
				
				header( "location: welcome.php");		// redirect to welcome page
			}
			else if( $result-> num_rows == 0)
				echo "<script type='text/jscript'> alert('Password and username do not match.') </script>";
	
		}

    }
}
?>

	<div>

	<center> 
	<br><br>
		<h2>KRISELA'S BANKING SYSTEM</h2> <br> <br>
		
		<form action="index.php" method="post">

		<table>
			<tr> <td>Username: </td><td> <input type="text" id="username" name="username">	</td></tr>
			
			<tr> <td> Password: </td><td>  <input type="password" id="password" name="password"> </td></tr>

			</table>

			<br> <br>

			<input type = "submit" id="login" value="Log In" name = "login"> 

		</form>

	</center>

	</div>

</body>

</html>

