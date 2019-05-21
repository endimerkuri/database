<?php
session_start();
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    
    <link rel="stylesheet" type ="text/css" href = "styles.css">
    <link rel="stylesheet" type ="text/css" href = "inboxStyles.css">
</head>

	<body>
  <nav class="navbar navbar-expand-sm bg-white navbar-light" style="border-bottom: 2px solid red">
        <a class="navbar-brand mr-auto" href="#">
            <img src="icon.jpeg" alt="Logo" style="height:50px;position:absolute;top:50%;transform:translate(0%,-50%)">
        </a>

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-danger" href="#">Explore <span class= "glyphicon glyphicon-search"> </span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger" href="#">Messages <span class= "glyphicon glyphicon-envelope"> </span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link text-danger" href="#">Notifications <span class= "glyphicon glyphicon-bell"> </span> </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger" href="profile.php">Profile <span class= "glyphicon glyphicon-user"> </span> </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color:red" href="login.php">Log out <span class= "glyphicon glyphicon-lock"> </span> </a>
            </li>
        </ul>
    </nav>
        
        <?php
        $dbServer = "localhost";
        $dbUsername = "talha.sen";
        $dbPassword = "p2yjILda";
        $dbName = "talha_sen";
        
        $con = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);
        
        if($con -> connect_error) {
            die("Connection Failed: " . $con -> connect_error) . "<br>";
        }
        
        
        
        $user = $_SESSION['user'];
        
        if(isset($_POST['saveChangesButton'])){
            
            //echo "Button is clicked! <br>";
            
            if($_POST['newPassword'] == $_POST['confirmPassword'] ){
                //$profilePic = $_POST["avatar"];
                $nameOfUser = $_POST["newName"];
                $email = $_POST["newEmail"];
                $city = $_POST["newCity"];
                $dateOfBirth = $_POST["newBirthday"];
                $personalInfo = $_POST["newInfo"];
                
                if($con -> connect_error) {
                    die("Connection Failed: " . $con -> connect_error) . "<br>";
                }
                
                //echo "Name:" . $nameOfUser ."<br>";
                //echo "Email:" . $email ."<br>";
                
                if ($nameOfUser != ""){
                    $updateNameQuery = "UPDATE user SET name = '$nameOfUser' WHERE username = '$user';";
                    $con->query($updateNameQuery);
                }
                
                
                if ($email != ""){
                    $updateEmailQuery = "UPDATE user SET email = '$email' WHERE username = '$user';";
                    $con->query($updateEmailQuery);
                }
                            
                if( $_POST['newPassword'] != ""){
                    $pass = $_POST["newPassword"];
                    
                    $updatePassQuery = "UPDATE user SET password = '$pass' WHERE username = '$user';";
                    $con->query($updatePassQuery);
                }
                
                if ($city != ""){
                    $updateCityQuery = "UPDATE user SET city = '$city' WHERE username = '$user';";
                    $con->query($updateCityQuery);
                }
                
                if ($dateOfBirth != ""){
                    $dateUF=strtotime($dateOfBirth);
                    $dateF=date("Y-m-d", $dateUF);
                    $updateBirthdayQuery = "UPDATE user SET date_of_birth = '$dateF' WHERE username = '$user';";
                    $con->query($updateBirthdayQuery);
                }
                
                if ($personalInfo != ""){
                    $updatePersonalInfoQuery = "UPDATE user SET personal_info = '$personalInfo' WHERE username = '$user';";
                    $con->query($updatePersonalInfoQuery);
                }
                $_SESSION['nameOfUser'] = $nameOfUser;
            } 
        }
        
        $getInfoQuery = "SELECT name, email, city, date_of_birth, personal_info FROM user WHERE username = '$user';";
        // echo $getNameQuery . "<br>";
        
        $userTable = $con->query($getInfoQuery);
        //echo "number of tuples: " . $nameOfUserTable->num_rows . "<br>";
        $userRes = $userTable->fetch_assoc();
        $nameOfUser = $userRes["name"];
        $email = $userRes["email"];
        $city = $userRes["city"];
        $dateOfBirth = $userRes["date_of_birth"];
        
        //echo "Type:" . gettype($dateOfBirth);
        
        $personalInfo = $userRes["personal_info"];
        
        //$profilePic = $userRes["profile_pic"];
        // echo "name of the user: " . $nameOfUser . "<br>";
        
        $_SESSION['nameOfUser'] = $nameOfUser;
        
        $getAllMessages = "SELECT C.sender AS sender, M.text AS text, M.time AS time FROM message M,
                            chat C WHERE C.receiver = '$user' AND C.message_id = M.id";
        $messages = $con->query($getAllMessages);
        
        // echo "Profile Page: <br> username: " . $user . "<br>" ;
        // echo "password: " . $pass . "<br>" ;
        
        //$getNumOfGroups = "SELECT COUNT(*) FROM is_part_of WHERE username = '$user';";
        //$numOfGroups = $con->query($getNumOfGroups);

        // CREATE GROUP
        echo "sdfsfsdfsdfsdfsfs";
        if(isset($_POST['newGroupSubmit'])) {
              $newGroupName = $con->real_escape_string($_POST["newGroupName"]);
              $newGroupDescription= $con->real_escape_string($_POST["newGroupDescription"]);
  
              $registerGroupQuery = "INSERT INTO `group`(name, description) VALUES( '$newGroupName', '$newGroupDescription');";

              if($con->query($registerGroupQuery) === true) {
  
                  $newGroupID = "SELECT LAST_INSERT_ID() AS newGroupID;";
                  $newGroupID = $con->query($newGroupID);
                  $newGroupID = $newGroupID->fetch_assoc()['newGroupID'];
  
                  $addGroupAdmin = "INSERT INTO is_part_of(username, group_id, status) VALUES('".$_SESSION['user']."', '$newGroupID', 'admin');";
                  $addGroupAdmin = $con->query( $addGroupAdmin);
  
                  header("location: group.php?groupID=$newGroupID");
              } else {
                  echo "<script type='text/jscript'> alert('FAILED') </script>"; 
              }  
      } else {
        echo "<script type='text/jscript'> alert('FAILED') </script>"; 
      }// end of Create Group php         
            
            ?>
            <div class="container">
  <div class="row">
    <div class="col-sm-10 col-sm-offset-1" id="logout">
        <div class="page-header">
            <h3 class="reviews"><span style="color:red"> <?= $nameOfUser  ?></span></h3>
        </div>
        <div class="comment-tabs">
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#comments-logout" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">My Groups</h4></a></li>
                <li><a href="#add-comment" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">My Events</h4></a></li>
                <li><a href="#account-settings" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">Account settings</h4></a></li>
                <li><a href="#inbox" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">Inbox</h4></a></li>
                <li><a href="#createGroup" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">Create Group</h4></a></li>
            </ul>            
            <div class="tab-content">
                <div class="tab-pane active" id="comments-logout">                
                    <ul class="media-list">
                        
                    <?php
                        $getGroups = "SELECT id, name, description, status FROM is_part_of P JOIN `group` G WHERE P.username = '$user' AND P.group_id = G.id;";
                        $groups = $con->query($getGroups);
                        if ($groups->num_rows > 0)
                        {
                            while ($row = $groups->fetch_assoc()){
                                
                              echo '<li class="media">
                                <a class="pull-left" href="#">
                                  <img class="media-object img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/dancounsell/128.jpg" alt="profile">
                                </a>
                                <div class="media-body">
                                  <div class="well well-lg">
                                      <h4 class="media-heading text-uppercase reviews">'. $row["name"] .'</h4>
                                      <ul class="media-date text-uppercase reviews list-inline">
                                        <li class="dd">22</li>
                                        <li class="mm">09</li>
                                        <li class="aaaa">2014</li>
                                      </ul>
                                      <div class= "caption">
                                        <span class="label label-success badge-success">'. $row["status"] .'</span>
                                      </div>
                                      <p class="media-comment">'.
                                       $row["description"].
                                      '</p>
                                      <a class="btn btn-info btn-circle text-uppercase" href="group.php?groupID='.$row['id'].'"><span class="glyphicon glyphicon-share-alt"></span> Go To Group</a>
                                  </div>              
                                </div>                        
                              </li>';
                            }
                        }
                        else{
                            echo '<li class="media">
                                <div class="media-body">
                                  <div class="well well-lg">
                                      <h4 class="media-heading text-uppercase reviews">You are not part of any group.</h4>
                                    </div>              
                                </div>
                            </li>';
                        }
                    ?>
                        
                        
                    </ul> 
                </div>
                
                
                <!--Event-->
                <div class="tab-pane" id="events">

                </div>
                
                                
                <div class="tab-pane" id="account-settings">
                    <form action="profile.php" method="post" class="form-horizontal" id="accountSetForm" role="form">
                        <div class="form-group">
                            <label for="avatar" class="col-sm-2 control-label">Avatar</label>
                            <div class="col-sm-10">                                
                                <div class="custom-input-file">
                                    <label class="uploadPhoto">
                                        <!--?php
                                        echo '<img src="'. $profilePic .' width = 100 height=100 id="profile-pic"/>';
                                        ?-->
                                        <input type="file" class="change-avatar" name="avatar" id="avatar">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="newName" id="newName" placeholder= "<?= $nameOfUser ?>" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="newEmail" id="newEmail" placeholder="<?= $email ?>">
                            </div>
                        </div>  
                        <div class="form-group">
                            <label for="city" class="col-sm-2 control-label">City</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="newCity" id="newCity" placeholder="<?= $city ?>">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="birthday" class="col-sm-2 control-label">Date Of Birth: <?= $dateOfBirth ?></label>
                            <div class="col-sm-10">
                              <input type="date" class="form-control" name="newBirthday" id="newBirthday" >
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="personal-info" class="col-sm-2 control-label">Personal Info</label>
                            <div class="col-sm-10">
                              <input type="text"  class="form-control" name="newInfo" id="newInfo" placeholder="<?= $personalInfo ?>">
                            </div>
                        </div>  
                        <div class="form-group">
                            <label for="newPassword" class="col-sm-2 control-label">New password</label>
                            <div class="col-sm-10">
                              <input type="password" class="form-control" name="newPassword" id="newPassword">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="confirmPassword" class="col-sm-2 control-label">Confirm password</label>
                            <div class="col-sm-10">
                              <input type="password" class="form-control" name="confirmPassword" id="confirmPassword">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">                    
                                <button class="btn btn-primary btn-circle text-uppercase" type="submit" name="saveChangesButton">Save changes</button>
                            </div>
                        </div>            
                    </form>
                </div>
                
                
                <!--Start of inbox-->
                <div class="tab-pane" id="inbox">
                    
                
                <div class="mailbox">
                  <div class="nav">
                    <a href="#" data-toggle="modal" data-target="#modalCompose">compose</a>
                    <a href="#" class="active">inbox</a>
                    <a href="#" >sent</a>
                  </div>
                  <div class="messages">
                    <input name="search" placeholder="search" />
                    <div class="actions-dropdown">
                      <label>actions <span>▼</span></label>
                      <ul>
                        <li>flag</li>
                        <li>move</li>
                        <li>delete</li>
                      </ul>
                    </div>

                    <?php
                        if ($messages->num_rows > 0)
                        {
                            while ($row = $messages->fetch_assoc()){
                                echo '<div class="message">
                              <input type="checkbox" />
                              <span class="sender">'. $row["sender"].'</span>
                              <span class="date">'. $row["time"].'</span>
                              <span class="title">'. $row["text"].'</span>
                            </div>';
                              
                            }
                        }

                    ?>


                  </div>
                </div>
                    
                <!-- Modal here-->
                    
                <!-- /.modal compose message -->
                <div class="modal fade" id="modalCompose">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Compose Message</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        
                      </div>
                      <div class="modal-body">
                        <form role="form" class="form-horizontal">
                            <div class="form-group">
                              <label class="col-sm-2" for="inputTo">To</label>
                              <div class="col-sm-10"><input type="email" class="form-control" id="inputTo" placeholder="comma separated list of recipients"></div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-2" for="inputSubject">Subject</label>
                              <div class="col-sm-10"><input type="text" class="form-control" id="inputSubject" placeholder="subject"></div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-12" for="inputBody">Message</label>
                              <div class="col-sm-12"><textarea class="form-control" id="inputBody" rows="18"></textarea></div>
                            </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button> 
                        <button type="button" class="btn btn-warning pull-left">Save Draft</button>
                        <button type="button" class="btn btn-primary ">Send <i class="fa fa-arrow-circle-right fa-lg"></i></button>

                      </div>
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div><!-- /.modal compose message -->
                    
                    
                </div>
                <!--End of inbox-->
                
                <!--Create Group-->
                <div class="tab-pane" id="createGroup">

                    <form action="profile.php" method="post" class="form-horizontal" id="newGroupSetForm" role="form">
                        
                        <div class="form-group">
                            <label for="avatar" class="col-sm-2 control-label">Avatar</label>
                            <div class="col-sm-10">                                
                                <div class="custom-input-file">
                                    <label class="uploadPhoto">
                                        Edit
                                        <input type="file" class="change-avatar" name="avatar" id="avatar">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="newGroupName" class="col-sm-2 control-label">Group Name</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="newGroupName" id="newGroupName" placeholder="Enter event name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="newGroupDescription" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                              <textarea class="form-control" name="newGroupDescription" id="newGroupDescription" placeholder="Description" rows="3"> </textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">                    
                                <button class="btn btn-primary btn-circle text-uppercase" type="submit" name="newGroupSubmit" id="newGroupSubmit">Create Group</button>
                            </div>
                        </div>            
                    </form>
                </div>

                
            </div>
        </div>
	</div>
  </div>
</div>
        
        
        
	</body>
</html>