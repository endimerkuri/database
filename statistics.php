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

  
    $getEvents = "SELECT name, date, description, going/(going + notgoing)*100  as ratio
                  FROM (SELECT event_id AS id, count(*) AS going
                        FROM participates 
                        WHERE status = 'going'
                        GROUP BY event_id) AS a
                        NATURAL JOIN
                        (SELECT event_id AS id, count(*) AS notgoing
                        FROM participates 
                        WHERE status = 'not going'
                        GROUP BY event_id) AS b
                        NATURAL JOIN 
                        event
                        ORDER BY ratio DESC
                        LIMIT 10;";

    $getEvents = $conn->query( $getEvents);
 
    if( $getEvents->num_rows <= 0){
        echo "NO EVENTS WERE SUCCESSFUL";
    }
    else{

        $number = $getEvents->num_rows;
        $count = 0;

        while( $event = $getEvents-> fetch_assoc()){
               $label[$count] = $event['name'];
               $ratio[$count] = $event['ratio'];
               $count = $count + 1;
        }
    }

    $cities = 'SELECT city_name, count
                FROM (SELECT username, count(*) AS count
                FROM comment
                GROUP BY username) AS temp, city, user
                WHERE temp.username=user.username
                AND user.city = city.city_name
                ORDER BY count DESC
                LIMIT 10;';
    $cityList= $conn->query( $cities);
    
    if( $cityList->num_rows <= 0){
        echo "NO EVENTS WERE SUCCESSFUL";
    }
    else{

        $cityNo = $cityList->num_rows;
        $count1 = 0;

        while( $city = $cityList-> fetch_assoc()){
            $cityName[$count1] = $city['city_name'];
            $cityCount[$count1] = $city['count'];
            $count1 = $count1 + 1;
        }
    }
?>

<html>
<head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>    
<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" type="text/css" href="styleEvent.css">

</head>

<body>
<div class="container">
  <div class="row">
    <div class="col-sm-10 col-sm-offset-1" id="logout" width = "90%">
        <div class="page-header">

            <h3 class="reviews"> STATISTICS </h3>
        </div>

        <div class="comment-tabs">
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#rep1" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">Report1</h4></a></li>
                <li><a href="#rep2" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">Report2</h4></a></li>
            </ul> 
			
            <div class="tab-content">
                <div class="tab-pane active" id="rep1">  
	
            <?php echo'
                <script type="text/javascript">
                        window.onload = function () {

                        // var data = [];
                        // var i;
                    

                        // for (i = 0; i < 10; i++) { 
                        //     data.push(1);
                        // }

                        var chart = new CanvasJS.Chart("chartContainer", {
                            theme: "light1", // "light2", "dark1", "dark2"
                            animationEnabled: false, // change to true		
                            title:{
                                text: "Events with highest percentage of attending group members "
                            },
                            data: [
                            {
                                // Change type to "bar", "area", "spline", "pie",etc.
                                type: "column",
                                dataPoints: [';
                                $i = 0;
                                while( $i < $number - 1){
                                   echo ' { label:"'. $label[$i].'", y:'. $ratio[$i].'  },';
                                   $i = $i+1;
                                }

                                echo ' { label:"'. $label[$i].'", y:'. $ratio[$i].'  }';
                            echo ']
                            }
                            ]
                        });
                        chart.render();
                        
                        var chart1 = new CanvasJS.Chart("chartContainer1", {
                            theme: "light1", // "light2", "dark1", "dark2"
                            animationEnabled: false, // change to true		
                            title:{
                                text: "10 first cities with highest number of active users"
                            },
                            data: [
                            {
                                // Change type to "bar", "area", "spline", "pie",etc.
                                type: "column",
                                dataPoints: [';
                                $i = 0;
                                while( $i < $cityNo - 1){
                                   echo ' { label:"'. $cityName[$i].'", y:'. $cityCount[$i].'  },';
                                   $i = $i+1;
                                }

                                echo ' { label:"'. $cityName[$i].'", y:'. $cityCount[$i].'  }';
                            echo ']
                            }
                            ]
                        });
                        chart1.render();
                        }
                        </script>

                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"> </script>
                        


	            </div>
                <div class="tab-pane" id="rep2">  
	
                        <div id="chartContainer1" style="height: 370px; width: 100%;"></div>
                        </div>';
                        ?>


	            </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>