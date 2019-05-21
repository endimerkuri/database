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
    $getGroupName = " SELECT * FROM `group` WHERE id = '". $_GET['groupID']."';";
    // $getGroupName = " SELECT * FROM `group` WHERE id = 1;";
    $groupName = $conn->query( $getGroupName);
    if( $groupName->num_rows <= 0){
        echo "<script type='text/jscript'> alert('group not found') </script>";
        $groupName = "Error";
    }
    else{
        $group = $groupName-> fetch_assoc();
        $groupName = $group['name'];
    }
    $isMember = "SELECT * FROM is_part_of WHERE username='".$_SESSION['user']."' AND group_id=".$_GET['groupID'].";";
    $isMemberRes = $conn->query($isMember);
    $isMember = $isMemberRes->num_rows;
    $isAdmin = 0;
    if ( $isMemberRes->fetch_assoc()['status'] == "admin") {
        $isAdmin = 1;
    }
    $month['01'] = 'Jan';
    $month['02'] = 'Feb';
    $month['03'] = 'Mar';
    $month['04'] = 'Apr';
    $month['05'] = 'May';
    $month['06'] = 'Jun';
    $month['07'] = 'Jul';
    $month['08'] = 'Aug';
    $month['09'] = 'Sep';
    $month['10'] = 'Oct';
    $month['11'] = 'Nov';
    $month['12'] = 'Dec';
    if (isset($_POST['acc'])) {
        $accept = "UPDATE is_part_of SET status = 'member' WHERE group_id = ".$_GET['groupID']." AND username = '". $_GET['userID']."';";
        $res = $conn->query($accept);
    } else if (isset($_POST['dec'])) {
        $decline = "DELETE FROM is_part_of WHERE group_id = ".$_GET['groupID']." AND username = '". $_GET['userID']."';";
        $res = $conn->query($decline);
    } 

    if(isset($_POST['newEventSubmit'])) {
        //echo "<script type='text/jscript'> alert('Button clicked') </script>"; }
            
            $newEventName = $conn->real_escape_string($_POST["newEventName"]);
            $newEventCity = $conn->real_escape_string($_POST["newEventCity"]);
            $newEventCountry = $conn->real_escape_string($_POST["newEventCountry"]);
            $newEventDate = $conn->real_escape_string($_POST["newEventDate"]);
            $newEventDescription= $conn->real_escape_string($_POST["newEventDescription"]);

            $newEventPrivacy = $_POST["newEventPrivacy"];

            $registerQuery = "INSERT INTO event(group_id, name, date, city_name, country, description, privacy) VALUES( ".$_GET['groupID'].",'$newEventName', '$newEventDate', '$newEventCity', '$newEventCountry', '$newEventDescription', '$newEventPrivacy');";
            // echo $registerQuery;
            if($conn->query($registerQuery) === true) {

                $getID = "SELECT LAST_INSERT_ID() AS newEventID;";
                $getID = $conn->query($getID);
                $getID = $getID->fetch_assoc()['newEventID'];

                $tagList = explode(",", $_POST['newEventCat']);
                foreach( $tagList as $tag){
                    $addTag = "INSERT INTO category VALUES('$tag');";
                    $addTag = $conn->query($addTag);

                    $addTag2 = "INSERT INTO event_category VALUES( '$getID', '$tag');";
                    $addTag2 = $conn->query($addTag2);
                }

                $addAdmin = "INSERT INTO participates VALUES('$getID', '".$_SESSION['user']."', 'going');";
                $addAdmin = $conn->query( $addAdmin);

                header("location: event.php?eventID=$getID");
            } else {
                echo "<script type='text/jscript'> alert('FAILED11') </script>"; 
            }  
    }

    if (isset($_POST['join'])) {
        $addMember = "INSERT INTO is_part_of(username, group_id, status) values('".$_SESSION['user']."',".$_GET['groupID'].", 'requested');";
        $addMember = $conn->query($addMember);
        header("location:group.php?groupID=".$_GET['groupID']);
    }
?>

<html>
<head>

<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" type="text/css" href="styleEvent.css">
<script src="imageUpload.js"> </script>

<!------ For categories ---------->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="categoriesCSS.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="categoriesJS.js"></script>

</head>

<body>

<nav class="navbar navbar-expand-sm bg-white navbar-light" style="border-bottom: 2px solid red">
        <a class="navbar-brand" href="#">
            <img src="icon.jpeg" alt="Logo" style="height:50px;position:absolute;top:50%;transform:translate(0%,-50%)">
        </a>

        <ul class="navbar-nav" style="list-style-type:none;float:right;margin-top:15px">
            <li class="nav-item">
                <a class="nav-link" style="color:red" href="statistics.php">Statistics <span class= "glyphicon glyphicon-stats"> </span> </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color:red" href="profile.php">Profile <span class= "glyphicon glyphicon-user"> </span> </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color:red" href="login.php">Log out <span class= "glyphicon glyphicon-lock"> </span> </a>
            </li>
        </ul>
    </nav>
<div class="container">
  <div class="row">
    <div class="col-sm-10 col-sm-offset-1" id="logout" width = "90%">
        <div class="page-header row">

            <!-- EVENT NAME -->
            <h3 class="reviews col-sm-11"> <?php echo $groupName; ?> </h3>
            <?php
                if ( $isMember <= 0 ) {
                    echo "<form action=\"group.php?groupID=".$_GET['groupID']."\" method=\"post\">";
                    echo "<button class=\"btn btn-primary btn-circle text-uppercase\" type=\"submit\" name=\"join\" id=\"join\">Join</button>";
                    echo "</form>";
                }
            ?>
        </div>

        <div class="comment-tabs">
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#comments-logout" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">Events</h4></a></li>
                <li><a href="#add-comment" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">Members</h4></a></li>
                <?php
                if ( $isAdmin == 1 ) {
                echo '<li><a href="#createEvent" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">Create Event</h4></a></li>';
                }
                ?>
            </ul> 
			
            <div class="tab-content">
                <div class="tab-pane active" id="comments-logout">  
				
				<div>
                    <div>
                        <ul class="event-list">
                            <?php
                                $indexQ = "CREATE INDEX groupIndex USING BTREE on event(group_id);";
                                $resultIndex = $conn->query($indexQ);
                                $eventsQuery = "SELECT * FROM event WHERE group_id = ". $_GET['groupID'] . ";";
                                $eventsList = $conn->query( $eventsQuery);
                                if( $eventsList->num_rows > 0){
                                while ( $currEvent = $eventsList->fetch_assoc() ) {
                                    $timeDate = explode("-", $currEvent['date']);
                                    echo 
                                    '<li>
                                        <time datetime="'.$currEvent['date'].'">
                                            <span class="day">'.$timeDate[2].'</span>
                                            <span class="month">'.$month[$timeDate[1]].'</span>
                                            <span class="year">'.$timeDate[0].'</span>
                                            <span class="time">ALL DAY</span>
                                        </time>
                                        <img alt="Independence Day" src="https://farm4.staticflickr.com/3100/2693171833_3545fb852c_q.jpg" />
                                        <div class="info">
                                            <a href="event.php?eventID='.$currEvent['id'].'"><h2 class="title">'.$currEvent['name'].'</h2></a>
                                            <p class="desc">'.$currEvent['description'].'</p>
                                        </div>
                                    </li>';
                                }
                            }else{
                                    echo '<li class="media">
                                            <div class="media-body">
                                              <div class="well well-lg">
                                                  <h4 class="media-heading text-uppercase reviews">This group has no events yet. Add one!</h4>
                                                </div>              
                                            </div>
                                        </li>';
                                }
                            ?>
                        </ul>
                    </div>
                </div>

            </div>


    <div class="tab-pane" id="add-comment">
        <?php
            $partQuery = "SELECT * FROM is_part_of WHERE group_id = ".$_GET['groupID']." ORDER BY status;";
            // $partQuery = "SELECT * FROM is_part_of WHERE group_id = 1;";
            $part = $conn->query( $partQuery);
            echo "<div class=\"row\" style=\"margin-right:0px;margin-left:0px\"><center>";
            while ( $participant = $part->fetch_assoc() ) {
                $partInfoQuery = "SELECT *".
                                " FROM user NATURAL JOIN is_part_of". 
                                " WHERE username = '".$participant['username']."' AND group_id = ". $_GET['groupID'].";";
                $partInfo = $conn->query( $partInfoQuery);
                $partInfo = $partInfo->fetch_assoc();
                $pic = $partInfo['profile_pic'];
                if ( $isAdmin == 1 ) {
                    if ( $partInfo['status'] == "requested" ) {
                        echo  "<div class=\"col-sm-3 well\">". 
                            "<a href=\"#\"><img style=\"max-width:120px;margin-bottom:10px\" class=\"img-circle\" src=\"$pic\" alt=\"profile\">". 
                            "</a><h5>".$partInfo['name']."</h5>".
                            "<div class=\"caption\">".
                                "<span class=\"label label-success badge-success\">". ucwords($partInfo['status']) ."</span>".
                                "<form action=\"group.php?userID=".$participant['username']."&groupID=".$_GET['groupID']."\" method=\"post\">".
                                "<button class=\"btn btn-primary btn-circle text-uppercase\" type=\"submit\" name=\"acc\"><span class=\"glyphicon glyphicon-ok\"></span></button>".
                                "<button class=\"btn btn-primary btn-circle text-uppercase\" type=\"submit\" name=\"dec\"><span class=\"glyphicon glyphicon-remove\"></span></button>".
                                "</form>".
                            "</div>".
                            "</div>";
                    } else {
                        echo  "<div class=\"col-sm-3 well\">". 
                        "<a href=\"#\"><img style=\"max-width:120px;margin-bottom:10px\" class=\"img-circle\" src=\"$pic\" alt=\"profile\">". 
                        "</a><h5>".$partInfo['name']."</h5>".
                        "<div class=\"caption\">".
                            "<span class=\"label label-success badge-success\">". ucwords($partInfo['status']) ."</span>".
                        "</div>".
                        "</div>";
                    }
                } else {
                    echo  "<div class=\"col-sm-3 well\">". 
                        "<a href=\"#\"><img style=\"max-width:120px;margin-bottom:10px\" class=\"img-circle\" src=\"$pic\" alt=\"profile\">". 
                        "</a><h5>".$partInfo['name']."</h5>".
                        "<div class=\"caption\">".
                            "<span class=\"label label-success badge-success\">". ucwords($partInfo['status']) ."</span>".
                        "</div>".
                        "</div>";
                }                
            }
            echo "</center></div>";
        ?>
    </div>



            <?php 
            $isAdmin = "SELECT status".
                       " FROM is_part_of". 
                       " WHERE username = '".$_SESSION['user']."' AND group_id = ". $_GET['groupID'].";";

            $isAdmin = $conn->query( $isAdmin);
            $isAdmin = $isAdmin->fetch_assoc()['status'];

            if( $isAdmin == "admin"){

            echo '                            
            <div class="tab-pane" id="createEvent">

                    <form action="group.php?groupID='.$_GET['groupID'].'" method="post" class="form-horizontal" id="newEventSetForm" role="form">
                        
                        <div class="form-group">
                            <label for="avatar" class="col-sm-2 control-label">Event Picture</label>
                            <div class="col-sm-10">                                
                                <div class="custom-input-file">
                                    <img style="max-width:150px" class="media-object img-circle" src="https://farm4.staticflickr.com/3100/2693171833_3545fb852c_q.jpg" alt="profile">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="newEventName" class="col-sm-2 control-label">Event Name</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="newEventName" id="newEventName" placeholder="Enter event name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="newEventCity" class="col-sm-2 control-label">City</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="newEventCity" id="newEventCity" placeholder="City" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="newEventCountry" class="col-sm-2 control-label">Country</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="newEventCountry" id="newEventCountry" placeholder="Country" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="newEventDate" class="col-sm-2 control-label">Date </label>
                            <div class="col-sm-10">
                              <input type="date" class="form-control" name="newEventDate" id="newEventDate" required>
                            </div>
                        </div> 

                        <div class="form-group">
                            <label for="newEventPrivacy" class="col-sm-2 control-label">Privacy</label>
                            <div class="col-sm-10">
                                <label class="radio-inline"><input type="radio" id="newEventPrivacy" value="0" name="newEventPrivacy" checked>Public</label>
                                <label class="radio-inline"><input type="radio" id="newEventPrivacy" value= "1" name="newEventPrivacy">Private</label>
                            </div>
                        </div> 

                        <div class="form-group">
                            <label for="newEventDescription" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                              <textarea class="form-control" name="newEventDescription" id="newEventDescription" placeholder="Description" rows="3"> </textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="newEventCat" class="col-sm-2 control-label">Categories</label>
                            <div class="col-sm-10">
                                <input type="text" data-role="tagsinput" placeholder="Add tags" name="newEventCat" id ="newEventCat" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">                    
                                <button class="btn btn-primary btn-circle text-uppercase" type="submit" name="newEventSubmit" id="newEventSubmit">Create Event</button>
                            </div>
                        </div>            
                    </form>
                </div>
            ';}
             ?>

        </div>
        </div>
	</div>
  </div>

</body>
</html>