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
		<div id="demo" class="carousel slide" data-ride="carousel" data-interval="1000">

		<!-- The slideshow -->
				<div class="carousel-inner">
				<div id="content-wrapper" class="wrapper">
						<!-- LOG IN -->
						<div class="wrapper fadeInDown">
							<div id="formContent">
								<!-- Tabs Titles -->
								<!-- Icon -->
								<div class="fadeIn first">
									<img class="img-fluid" src="icon.jpeg" id="icon" alt="GatherTogether"/>
								</div>
								<!-- Login Form -->
								<form method="post" >
									<input type="text" id="login" class="fadeIn second" name="login" placeholder="Please enter username">
									<input type="text" id="password" class="fadeIn third" name="login" placeholder="Please enter password">
									<input type="submit" class="fadeIn fourth" value="Log In">
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
	</body>
</html>
