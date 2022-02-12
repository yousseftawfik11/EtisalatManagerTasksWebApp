<?php
include("db.php");
session_start();
if(!isset($_SESSION["username"])||$_SESSION["username"]==5000){
    echo '
    <script>
    window.location.href="index.php";
    </script>
  ';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Montserrat:wght@300&display=swap" rel="stylesheet">
 
    <title>Your Open Tasks</title>
</head>
<body class="backgroundimage" style="color:white;">
<nav class="navbar navbar-expand-lg navbar-light  navBar-color" >
<a class="navbar-brand navBar-color" href="#"><img class="logosize" src='images/horse.svg'><br><span class="logoText">Tornado</span></a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav  ml-auto">
    <a class="nav-item nav-link navBar-color" href="membersdash.php"><img src="images/back.svg"  class="logoutAni backIcon"></a>
<a class="nav-item nav-link navBar-color" href="logout.php">Log Out <img src="images/logout.svg"  class="logoutAni"></a>
<a class="nav-item nav-link navBar-color" href="changePasswordMem.php">Change Password </a>

</div>
  </div>
</nav>
<div class="tableTitles">
    <div>
    <h1>Your Open Tasks</h1>
    </div>
    <div>
    <a class="btn btn-primary" data-toggle="collapse" href="#OpenTaskTable" role="button" aria-expanded="false" aria-controls="collapseExample" 
    style="background-color: transparent; border-color:transparent;">
    <img src='images/collapse-up.svg' style="width: 33px;">
    </a>
    </div>
  </div>
  <div id='OpenTaskTable' class="collapse">

<?php
    


    $member_id = $_SESSION["username"];; 


    $filterQuery="SELECT tasks.task_id,tasks.task_title,Content,start_Date,due,status,priority,attachment_name from tasks 
    INNER JOIN task_members ON task_members.task_id=tasks.task_id
    WHERE status = '0' and task_members.member_id=".$member_id;
    
    if($result= mysqli_query($conn,$filterQuery)){
        if(mysqli_num_rows($result)>0){
            echo "<table class='table table-hover' >";
            echo "<tr>";
            echo "<th scope='col'>Title</th>";
            echo "<th scope='col'>Content</th>";
            echo "<th scope='col'>Start Date</th>";
            echo "<th scope='col'>Due Date</th>";
            echo "<th scope='col'>Status</th>";
            echo "<th scope='col'>Priority</th>";
            echo "<th scope='col'>Attachment</th>";
            echo "<th scope='col'>Member Names</th>";
            echo "<th scope='col'>leader Names</th>";
                    
                echo "</tr>";
    
                while($row = mysqli_fetch_array($result)){
                    //get members names for each task query and exectution
                     $namesSql="SELECT name FROM team_members INNER JOIN 
                 task_members ON team_members.member_id=task_members.member_id 
                 WHERE task_id=".$row['task_id'];
                 $names= mysqli_query($conn,$namesSql);
                 echo mysqli_error($conn); 
                 echo "</tr>";
     
                 echo "<tr>";
                 echo "<td>" . $row['task_title'] . "</td>";
                 echo "<td><pre>" . $row['Content'] . "</pre></td>";
                 echo "<td>" . $row['start_Date'] . "</td>";
                 echo "<td>" . $row['due'] . "</td>";
                 echo "<td><img src='images/success.svg' class='OpenTickSize'></td>";
                 switch($row['priority']){
                     case 1:
                         $priorityName="Low";
                         break;
                     case 2:
                         $priorityName="Medium";
                         break;
                     case 3:
                         $priorityName="High";
                         break;
                     case 4:
                         $priorityName="Very High";
                         break;
                     default:
                         $priorityName="default";
     
                 }
     
     
                 echo "<td>".$priorityName."</td>";
                 echo "<td> <a href='/uploads/". $row['attachment_name'] ."'>" . $row['attachment_name'] . "</a></td>";
                 echo "<td>";
    //loop to get all names from the sql result beause each task can have many names
                 while($row2 = mysqli_fetch_array($names)){
                     echo "<a>".$row2['name']."</a></br> ";
                 }
                 echo "</td>";
                   //get members names for each task query and exectution
                   $namesSql="SELECT name FROM team_members INNER JOIN 
                   task_leaders ON team_members.member_id=task_leaders.leader_id 
                   WHERE task_id=".$row['task_id'];
                   $names= mysqli_query($conn,$namesSql);
                   echo mysqli_error($conn); 
    
                   echo "<td>";
    //loop to get all names from the sql result beause each task can have many names
                 while($row2 = mysqli_fetch_array($names)){
                     echo "<a>".$row2['name']."</a></br>";
                 }
                 echo "</td>";
    
             
         }
         echo "</table>";
         mysqli_free_result($result);
     }else{
         echo "No records";
     }
    }else{
     echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
    
     
    
?>
  </div>
  

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>