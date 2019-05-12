<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
		<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="styles.css">
		<script>
		    $('#myCarousel').carousel({
				pause: 'none'
			})
		</script>
	<!------ Include the above in your HEAD tag ---------->
	</head>

	<body>
		<!-- <div class="bg"> -->
 
		<!-- The slideshow -->

		<div id="background-carousel">
			<div id="myCarousel" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<div class="item active" style= "background-image:url(https://www.bandt.com.au/information/uploads/2014/10/iStock_000040536788_Small-1260x840.jpg)">
					</div>
					<div class="item" style ="background-image:url(https://michellesdesignhouse.com/wp-content/uploads/2017/11/event-production-company-p2-entertainment-group-1.jpg)" >
					</div>
					<div class="item" style ="background-image:url(https://www.manheimtownship.org/ImageRepository/Document?documentID=4725)">
					</div>
					<div class="item" style ="background-image:url(http://1.bp.blogspot.com/-9aB3iVQt0Y8/UT8pnR9zq0I/AAAAAAAAAyI/OjJrI6zMJqY/s1600/Beach+Wedding+Sugokuii+Capri+Weddings.jpg)">
					</div>
				</div>
			</div>
		</div>

	<div id="content-wrapper">
	<div class="container">
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
			   <!-- Remind Passowrd -->
			<div id="formFooter">
			  <p> Don't have an account yet? <a class="underlineHover" href="signup.php">Sign up.</a> </p>
			</div>

		  </div>
		</div>
		</div>
	</div>
	</body>
</html>
