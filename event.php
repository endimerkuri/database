<?php
    session_start();
        
    $serverName = "dijkstra.ug.bcc.bilkent.edu.tr";
    $myUsername = "talha.sen";
    $myPassword = "p2yjILda";
    $dbName = "talha_sen";

    // Create connection
    $conn = new mysqli($serverName, $myUsername, $myPassword, $dbName);

    // Check connection
    if( $conn->connect_error) {
        echo "<script type='text/jscript'> alert('Connection failed') </script>";
        die( "Connection failed: " . $conn->connect_error);
    } 

    // $getName = " SELECT name FROM event WHERE id = '". $_GET['eventID']."';";
    $getEventName = " SELECT name FROM event WHERE id = 4;";
    $eventName = $conn->query( $getEventName);
    if( $eventName->num_rows <= 0){
        echo "<script type='text/jscript'> alert('Event not found') </script>";
        $eventName = "Error";
    }
    else
        $eventName = $eventName-> fetch_assoc()['name'];


    // $getName = " SELECT * FROM comment WHERE event_id = '". $_GET['eventID']."';";
    $getComments = " SELECT * FROM comment WHERE event_id = 4;";
    $comments = $conn->query( $getComments);

?>

<html>
<head>

<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" type="text/css" href="styleEvent.css">
<link rel="stylesheet" type="text/css" href="starRatingMin.css">
<script src="starRating.js"> </script>
<script src="imageUpload.js"> </script>

</head>

<body>

<div class="container">
  <div class="row">
    <div class="col-sm-10 col-sm-offset-1" id="logout" width = "90%">
        <div class="page-header">

            <!-- EVENT NAME -->
            <h3 class="reviews"> <?php echo $eventName; ?> </h3>
        </div>

        <div class="comment-tabs">
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#comments-logout" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">Comments</h4></a></li>
                <li><a href="#add-comment" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">Participants</h4></a></li>
                <li><a href="#address" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">About</h4></a></li>
            </ul> 
			
            <div class="tab-content">
                <div class="tab-pane active" id="comments-logout">  
				
				<ul class="media-list">
				<li class="media">
					<form action="#" method="post" class="form-horizontal" id="commentForm" role="form"> 
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Comment</label>
                            <div class="col-sm-10">
                              <textarea class="form-control" name="addComment" id="addComment" rows="5"></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="input-group image-preview col-sm-10" style ="position:relative; padding-right:15px; padding-left:15px; float:right">
                                <input placeholder="" type="text" class="form-control image-preview-filename" disabled="disabled">
                                <!-- don't give a name === doesn't send on POST/GET --> 
                                <span class="input-group-btn"> 
                                <!-- image-preview-clear button -->
                                <button type="button" class="btn btn-default image-preview-clear" style="display:none;"> <span class="glyphicon glyphicon-remove"></span> Clear </button>
                                <!-- image-preview-input -->
                                <div class="btn btn-default image-preview-input"> <span class="glyphicon glyphicon-folder-open"></span> <span class="image-preview-input-title">Browse</span>
                                    <input type="file" accept="image/png, image/jpeg, image/gif" name="input-file-preview"/>
                                    <!-- rename it --> 
                                </div>
                                <button type="button" class="btn btn-labeled btn-default"> <span class="btn-label"><i class="glyphicon glyphicon-upload"></i> </span>Upload</button>
                                </span> 
                            </div>
                        </div>

                        <div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">

                                <div class="col-sm-7">
                                    <label for="input-1" class="control-label">Rate This</label>
                                    <input id="input-1" name="input-1" value="4.3" class="rating-loading">
                                    <script>
                                    $(document).on('ready', function(){
                                        $('#input-1').rating({min: 0, max: 5, step: 0.1, stars: 5});
                                    });
                                    </script>
                                </div>

                                <div class="col-sm-3" style="margin-top:20px; float:right">                    
                                    <button class="btn btn-success btn-circle text-uppercase" type="submit" id="submitComment"><span class="glyphicon glyphicon-send"></span> Submit comment</button>
                                </div>

                            </div>
                        </div>
           
					</form>
					</li>

            <li class="media">
                        
			<a class="pull-left" href="#">

			<!-- Add picture of user -->
                <img class="media-object img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/dancounsell/128.jpg" alt="profile">
            </a>

            <div class="media-body">
                <div class="well well-lg">
					<!-- Add name of user -->
                    <h4 class="media-heading text-uppercase reviews">Marco </h4>
                              
					<ul class="media-date text-uppercase reviews list-inline">

					<!-- Add date of comment -->
                    <li class="dd">22</li>
                    <li class="mm">09</li>
                    <li class="aaaa">2014</li>
                    </ul>

					<!-- Add comment -->
                    <p class="media-comment">
                    Great snippet! Thanks for sharing.
                    </p>

                    <a class="btn btn-info btn-circle text-uppercase" data-toggle="collapse" href="#writeReply" id="reply"><span class="glyphicon glyphicon-share-alt"></span> Reply</a>
                    <a class="btn btn-warning btn-circle text-uppercase" data-toggle="collapse" href="#replyOne"><span class="glyphicon glyphicon-comment"></span> 2 comments</a>
                          
					<div id = "writeReply" class= "collapse" name = "writeReply" style = "margin-top:20px">
						<form action="#" method="post" class="form-horizontal" id="commentForm" role="form"> 
							<div class="form-group">
								<div class="col-sm-12">
									<textarea class="form-control" name="addComment" id="addComment" rows="5" placeholder="Type reply ..."></textarea>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-sm-12">                    
									<button class="btn btn-success btn-circle text-uppercase" style="float:right" type="submit" id="submitComment"><span class="glyphicon glyphicon-send"></span> Submit reply</button>
								</div>
							</div>            
						</form>
					</div>
				</div> 
            </div>

            <div id = "replyOne" class= "collapse" name ="replyOne">
                <ul class="media-list">
                    <li class="media media-replied">
                        <a class="pull-left" href="#">
                            <img class="media-object img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/ManikRathee/128.jpg" alt="profile">
                        </a>
                        <div class="media-body">
                            <div class="well well-lg">
                                <h4 class="media-heading text-uppercase reviews"><span class="glyphicon glyphicon-share-alt"></span> The Hipster</h4>
                                <ul class="media-date text-uppercase reviews list-inline">
                                <li class="dd">22</li>
                                <li class="mm">09</li>
                                <li class="aaaa">2014</li>
                                </ul>
                                <p class="media-comment">
                                Nice job Maria.
                                </p>
                            </div>              
                        </div>
                    </li>

                    <li class="media media-replied" id="replied">
                        <a class="pull-left" href="#">
                            <img class="media-object img-circle" src="https://pbs.twimg.com/profile_images/442656111636668417/Q_9oP8iZ.jpeg" alt="profile">
                        </a>
                        <div class="media-body">
                            <div class="well well-lg">
                                <h4 class="media-heading text-uppercase reviews"><span class="glyphicon glyphicon-share-alt"></span> Mary</h4></h4>
                                <ul class="media-date text-uppercase reviews list-inline">
                                <li class="dd">22</li>
                                <li class="mm">09</li>
                                <li class="aaaa">2014</li>
                                </ul>
                                <p class="media-comment">
                                Thank you Guys!
                                </p>
                            </div>              
                        </div>
                    </li>
                </ul>  
            </div>

            </li>          
            <li class="media">
            <a class="pull-left" href="#">
                <img class="media-object img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/kurafire/128.jpg" alt="profile">
            </a>
            <div class="media-body">
                <div class="well well-lg">
                    <h4 class="media-heading text-uppercase reviews">Nico</h4>
                    <ul class="media-date text-uppercase reviews list-inline">
                    <li class="dd">22</li>
                    <li class="mm">09</li>
                    <li class="aaaa">2014</li>
                    </ul>
                    <p class="media-comment">
                    I'm looking for that. Thanks!
                    </p>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="//www.youtube.com/embed/80lNjkcp6gI" allowfullscreen></iframe>
                    </div>
                    <a class="btn btn-info btn-circle text-uppercase" href="#" id="reply"><span class="glyphicon glyphicon-share-alt"></span> Reply</a>
                </div>              
            </div>
            </li>
            <li class="media">
            <a class="pull-left" href="#">
                <img class="media-object img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/lady_katherine/128.jpg" alt="profile">
            </a>
            <div class="media-body">
                <div class="well well-lg">
                    <h4 class="media-heading text-uppercase reviews">Kriztine</h4>
                    <ul class="media-date text-uppercase reviews list-inline">
                    <li class="dd">22</li>
                    <li class="mm">09</li>
                    <li class="aaaa">2014</li>
                    </ul>
                    <p class="media-comment">
                    Yehhhh... Thanks for sharing.
                    </p>
                    <a class="btn btn-info btn-circle text-uppercase" href="#writeReply" id="reply"><span class="glyphicon glyphicon-share-alt"></span> Reply</a>
                    <a class="btn btn-warning btn-circle text-uppercase" data-toggle="collapse" href="#replyTwo"><span class="glyphicon glyphicon-comment"></span> 1 comment</a>
                </div>              
            </div>


            <div class="collapse" id="replyTwo">
                <ul class="media-list">
                    <li class="media media-replied">
                        <a class="pull-left" href="#">
                            <img class="media-object img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/jackiesaik/128.jpg" alt="profile">
                        </a>
                        <div class="media-body">
                            <div class="well well-lg">
                                <h4 class="media-heading text-uppercase reviews"><span class="glyphicon glyphicon-share-alt"></span> Lizz</h4>
                                <ul class="media-date text-uppercase reviews list-inline">
                                <li class="dd">22</li>
                                <li class="mm">09</li>
                                <li class="aaaa">2014</li>
                                </ul>
                                <p class="media-comment">
                                Classy!
                                </p>
                                <a class="btn btn-info btn-circle text-uppercase" href="#" id="reply"><span class="glyphicon glyphicon-share-alt"></span> Reply</a>
                            </div>              
                        </div>
                    </li>

                </ul>  
            </div>
            </li>
        </ul> 
    </div>



    <div class="tab-pane" id="add-comment">
        <form action="#" method="post" class="form-horizontal" id="commentForm" role="form"> 
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Comment</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="addComment" id="addComment" rows="5"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="uploadMedia" class="col-sm-2 control-label">Upload media</label>
                <div class="col-sm-10">                    
                    <div class="input-group">
                        <div class="input-group-addon">http://</div>
                        <input type="text" class="form-control" name="uploadMedia" id="uploadMedia">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">                    
                    <button class="btn btn-success btn-circle text-uppercase" type="submit" id="submitComment"><span class="glyphicon glyphicon-send"></span> Summit comment</button>
                </div>
            </div>            
        </form>
    </div>


    <!--EVENT TAB-->
    <div class="tab-pane" id="address">
        <form action="#" method="post" class="form-horizontal" id="accountSetForm" role="form">
            <div class="form-group">
                <div class="col-sm-8">                    
                    <!--Google map-->
                    <div class="container-fluid">
                        <div class="map-responsive">
                        <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=Eiffel+Tower+Paris+France" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div> 

                <div class="col-sm-2" style="text-align: center">                    
                    <div class="row" style="display: inline-block">
                        <h4 class="media-heading text-uppercase reviews">Time </h4>
                        <p class="media-comment">
                            Great snippet! Thanks for sharing.
                        </p>
                    </div>

                    <div class="row" style="display: inline-block"> 
                        <h4 class="media-heading text-uppercase reviews">Host </h4>
                        <p class="media-comment">
                            Great snippet! Thanks for sharing.
                        </p>
                    </div>
                    <div class="row" style="display: inline-block">
                        <h4 class="media-heading text-uppercase reviews">Description</h4>
                        <p class="media-comment">
                            Great snippet! Thanks for sharing.
                        </p>
                    </div>
                </div> 
			</div>			
			<div class="form-group">

						
            </div>     



        </form>
    </div>
            </div>
        </div>
	</div>
  </div>

</body>
</html>