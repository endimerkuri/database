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
    if (isset($_GET['eventID'])) {
        $_SESSION['eventID'] = $_GET['eventID'];
    }
    $getEventName = " SELECT * FROM event WHERE id = ". $_SESSION['eventID'].";";
    // $getEventName = " SELECT * FROM event WHERE id = 4;";
    $eventName = $conn->query( $getEventName);
    if( $eventName->num_rows <= 0){
        echo "<script type='text/jscript'> alert('Event not found') </script>";
        $eventName = "Error";
    }
    else{
        $event = $eventName-> fetch_assoc();
        $eventName = $event['name'];
        $address = $event['city_name']."+".$event['country'];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ( isset($_GET['reply'])  ) {
            $submitReply1 = 
                "INSERT INTO comment (rate, text_content, event_id, username, status) VALUES (0, '".$_POST['addComment']."',".$_SESSION['eventID'].", '".$_SESSION['user']."', 1);";
            $submitReply2 =
                "INSERT INTO reply(child, parent) VALUES(LAST_INSERT_ID(), ".$_GET['reply'].");";
            $conn->query( $submitReply1);
            $conn->query( $submitReply2);

        } else {
            $submitComment = "INSERT INTO comment (rate, text_content, event_id, username, status) ".
                            "VALUES (".$_POST['input-1'].", '".$_POST['addComment']."', ".$_SESSION['eventID'].", '".$_SESSION['user']."', 0);";
            $tttt = $conn->query( $submitComment);
        }
    }

    // $getName = " SELECT * FROM comment WHERE event_id = '". $_SESSION['eventID']."';";
    $getComments = " SELECT * FROM comment WHERE event_id = ".$_SESSION['eventID']." AND status = 0 ORDER BY time DESC;";
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
                <!-- Comment TextArea -->
				<li class="media">
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="form-horizontal" id="commentForm" role="form"> 
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
                                    <label for="rating" class="control-label">Rate This</label>
                                    <input id="rating" name="input-1" value="4.3" class="rating-loading">
                                    <script>
                                    $(document).on('ready', function(){
                                        $('#rating').rating({min: 0, max: 5, step: 0.1, stars: 5});
                                    });
                                    </script>
                                </div>

                                <div class="col-sm-3" style="margin-top:20px; float:right">                    
                                    <button class="btn btn-success btn-circle text-uppercase" type="submit" id="submitComment"><span class="glyphicon glyphicon-send"></span> Submit comment</button>
                                </div>

                            </div>
                        </div>
           
					</form>
				</li> <!-- end Comment TextArea -->


            <?php 
                while($row = $comments->fetch_assoc()){ 
                $getUserInfo = "SELECT * FROM user WHERE username = '".$row['username']."';";
                $result = $conn->query( $getUserInfo);
                $result = $result->fetch_assoc();

                $profile_pic = $result['profile_pic'];
                $name = $result['name'];
                $time = $row['time'];
                $text_content = $row['text_content'];
                $rate = $row['rate'];
                $replyID = $row['id'];
                $commentID = $row['id']."a";


                $replyNumQ = "SELECT count(*) AS count FROM reply WHERE parent = $replyID;";
                $replyNum = $conn->query( $replyNumQ);
                $replyNum = $replyNum->fetch_assoc()['count'];
                $text= <<<EOT
                <li class="media"> <!-- Comments-->
                            
                    <a class="pull-left" href="#">

                    <!-- Add picture of user -->
                        <img class="media-object img-circle" src="$profile_pic" alt="profile">
                    </a>

                    <div class="media-body">
                        <div class="well well-lg">
                            <!-- Add name of user -->
                            <h4 class="media-heading text-uppercase reviews"> $name </h4>
                                    
                            <p class="media-date text-uppercase reviews list-inline">
                            $time
                            </p>

                            <!-- Add comment -->
                            <p class="media-comment">
                            $text_content
                            </p> 

                            <a class="btn btn-info btn-circle text-uppercase" data-toggle="collapse" href="#$replyID"> <span class="glyphicon glyphicon-share-alt"></span> Reply</a>
                            <a class="btn btn-warning btn-circle text-uppercase" data-toggle="collapse" href="#$commentID"> <span class="glyphicon glyphicon-comment"></span> $replyNum Comments</a>

                            <div style="float:right;">
                                    <input id="input-$replyID" name="input-$replyID" value="$rate" class="rating-loading">
                            </div>
                            <script>
                                $(document).on('ready', function(){
                                    $('#input-$replyID').rating({displayOnly: true, step: 0.1});
                                });
                            </script>
                                

                            <div id = "$replyID" class= "collapse" name = "$replyID" style = "margin-top:20px">
                                <form action="?reply=$replyID" method="post" class="form-horizontal" id="commentForm" role="form"> 
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <textarea class="form-control" name="addComment" id="addComment" rows="5" placeholder="Type reply ..." required></textarea>
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

                    <div id = "$commentID" class= "collapse" name ="$commentID">
                       <ul class="media-list">
EOT;
                echo $text;
                $replies = "SELECT * FROM comment NATURAL JOIN (SELECT child AS id FROM reply WHERE parent = '".$row['id']."') AS temp ORDER BY time DESC; ";
                $repliesResult = $conn->query($replies);
                while( $replyRow = $repliesResult->fetch_assoc()){

                    $replyUser = " SELECT * FROM user WHERE username = '".$replyRow['username']."';";
                    $replyUser = $conn->query($replyUser);
                    $replyUser = $replyUser->fetch_assoc();

                    $profile_pic = $replyUser['profile_pic'];
                    $name = $replyUser['name'];
                    $time = $replyRow['time'];
                    $text_content = $replyRow['text_content'];
                
                    $replyText= <<<EOT
                            <li class="media media-replied">
                                <a class="pull-left" href="#">
                                    <img class="media-object img-circle" src="$profile_pic" alt="profile">
                                </a>
                                <div class="media-body">
                                    <div class="well well-lg">
                                        <h4 class="media-heading text-uppercase reviews"><span class="glyphicon glyphicon-share-alt"></span> $name</h4>
                                        
                                        <p class="media-date text-uppercase reviews list-inline">
                                        $time
                                        </p>
                
                                        <!-- Add comment -->
                                        <p class="media-comment">
                                        $text_content
                                        </p>
                                        
                                    </div>              
                                </div>
                            </li>
EOT;
                    echo $replyText;
                }
                echo "</ul></div></li>";
            }   
         ?>

        </ul> 
    </div>


    <div class="tab-pane" id="add-comment">
        <?php
            $partQuery = "SELECT * FROM participates WHERE event_id = ".$_SESSION['eventID'].";";
            // $partQuery = "SELECT * FROM participates WHERE event_id = 4;";
            $part = $conn->query( $partQuery);
            echo "<div class=\"row\" style=\"margin-right:0px;margin-left:0px\"><center>";
            while ( $participant = $part->fetch_assoc() ) {
                $partInfoQuery = "SELECT * FROM user NATURAL JOIN participates WHERE event_id = ". $_SESSION['eventID']. " AND username = '".$participant['username']."';";
                $partInfo = $conn->query( $partInfoQuery);
                $partInfo = $partInfo->fetch_assoc();
                $pic = $partInfo['profile_pic'];

                echo  "<div class=\"col-sm-3 well\">". 
                    "<a href=\"#\"><img style=\"max-width:120px;margin-bottom:10px\" class=\"img-circle\" src=\"$pic\" alt=\"profile\">". 
                    "</a><h5>".$partInfo['name']."</h5><p>".ucwords($partInfo['status'])."</p>".
                    "</div>";
            }
            echo "</center></div>";
        ?>
    </div>


            <!--EVENT TAB-->
            <div class="tab-pane" id="address">
                <form action="#" method="post" class="form-horizontal" id="accountSetForm" role="form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-8">                    
                                <!--Google map-->
                                <div class="container-fluid">
                                    <div class="map-responsive">
                                    <?php 
                                    echo "<iframe style=\"width:100%\" src=\"https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=$address\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>";
                                    ?>
                                    </div>
                                </div>
                            </div> 

                            <!-- <div class="row" style="text-align: center"> -->
                            <div class="col-sm-4" style="padding-left:0px">
                                <ul style="list-style-type:none;padding-left:0px">
                                    <li>
                                        <div style="display: inline-block">
                                            <h4 class="media-heading text-uppercase reviews">DATE </h4>
                                            <p class="media-comment">
                                                <?php echo $event['date']; ?>
                                            </p>
                                        </div>
                                    </li>

                                    <li>
                                        <div style="display: inline-block"> 
                                            <h4 class="media-heading text-uppercase reviews">TIME </h4>
                                            <p class="media-comment">
                                                <?php echo $event['start_time']; ?>
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-sm-12" style="display: inline-block; word-wrap:break-word; padding-left:0px">
                                            <h4 class="media-heading text-uppercase reviews">DESCRIPTION</h4>
                                            <p class="media-comment">
                                                <?php echo $event['description']; ?>
                                            </p>
                                        </div
                                    ></li>
                                </ul>
                            </div>
                        </div>
                        <!-- </div>  -->
                    </div>			    

                </form>
            </div>
        </div>
        </div>
	</div>
  </div>

</body>
</html>