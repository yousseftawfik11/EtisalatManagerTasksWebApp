<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="css/styles.css">

    <title>View Tasks</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Tasks System</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link " href="ManagerHome.php">Create Tasks</a>
      <a class="nav-item nav-link active" href="TasksView.php">View Tasks</a>
      <a class="nav-item nav-link" href="modifyTask.php">Modify Tasks</a>
      <a class="nav-item nav-link" href="TasksHistory.php">History Tasks</a>
      <a class="nav-item nav-link" href="DueCalendar.php">Calendar</a>
      <a class="nav-item nav-link " href="newUser.php">Add User</a>
    </div>
  </div>
</nav>  

<h1>Open Tasks</h1>

<?php 
include('db.php');

$sql="SELECT task_id,Task_title,Content,start_Date,due,status,priority,attachment_name FROM tasks WHERE status='0'";
if($result= mysqli_query($conn,$sql)){
    if(mysqli_num_rows($result)>0){
        echo "<table class='table table-hover'>";
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
                echo "<td>" . $row['Task_title'] . "</td>";
                echo "<td>" . $row['Content'] . "</td>";
                echo "<td>" . $row['start_Date'] . "</td>";
                echo "<td>" . $row['due'] . "</td>";
                echo "<td><img src='images/success.svg' class='OpenTickSize'></td>";
                echo "<td>" . $row['priority'] . "</td>";
                echo "<td> <a href='uploads/". $row['attachment_name'] ."' target='_blank'>" . $row['attachment_name'] . "</a></td>";
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


<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

<?php

echo "<h1>Closed Tasks</h1>";


$sql="SELECT task_id,Task_title,Content,start_Date,due,status,priority,attachment_name FROM tasks WHERE status='1'";
if($result= mysqli_query($conn,$sql)){
    if(mysqli_num_rows($result)>0){
        echo "<table class='table table-hover'>";
        echo "<tr>";
                    echo "<th scope='col'>Title</th>";
                    echo "<th scope='col'>Content</th>";
                    echo "<th scope='col'>Start Date</th>";
                    echo "<th scope='col'>Due Date</th>";
                    echo "<th scope='col'>Status</th>";
                    echo "<th scope='col'>Priority</th>";
                    echo "<th scope='col'>Attachment</th>";
                    echo "<th  scope='col'>Select Task</th>";

                
            echo "</tr>";
            while($row = mysqli_fetch_array($result)){

              
          
                
                echo "<tr>";
                echo "<td>" . $row['Task_title'] . "</td>";
                echo "<td>" . $row['Content'] . "</td>";
                echo "<td>" . $row['start_Date'] . "</td>";
                echo "<td>" . $row['due'] . "</td>";
                echo "<td><img src='images/false.svg' class='OpenTickSize'></td>";
                echo "<td>" . $row['priority'] . "</td>";
                echo "<td> <a href='uploads/". $row['attachment_name'] ."'>" . $row['attachment_name'] . "</a></td>";
                echo "<td><input type='radio' name='chosen_task' value=".$row['task_id']."></input></td>";

               

            echo "</tr>";
        }
        echo "</table>";
        mysqli_free_result($result);
        echo'<input type="submit" name="OpenClosedTask" value="Re-open Task">';
    }else{
        echo "No records";
    }
}else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}

if(isset($_POST["OpenClosedTask"])){ //Re-open closed tasks

    $task_id = mysqli_real_escape_string($conn,$_POST['chosen_task']);       

    $closeTask = "UPDATE tasks SET status ='0' 
    WHERE task_id = '$task_id'";

    $query = mysqli_query($conn, $closeTask);

    echo "<meta http-equiv='refresh' content='0'>";


}

?>

</form>



<h1>Team Members filter</h1>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<?php

$query="SELECT member_id,name FROM team_members";
if($result= mysqli_query($conn,$query)){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result)){
            echo "<input type='radio' name='memberList' value=".$row['member_id'].">".$row['name']."</input><br>";
        }

    }
}
?>
<input type="submit" name="namesFilter">
</form>


<?php
if(isset($_POST["namesFilter"])){

    if(empty($_POST["memberList"])){
        echo '<script>
        alert("Failed to show tasks, please choose member")
        </script>';
    }else{

        $member_id=$_POST["memberList"];
        
        $filterQuery="SELECT tasks.task_id,tasks.task_title,Content,start_Date,due,status,priority,attachment_name from tasks 
        INNER JOIN task_members ON task_members.task_id=tasks.task_id
        WHERE task_members.member_id=".$member_id;

        if($result= mysqli_query($conn,$filterQuery)){
            if(mysqli_num_rows($result)>0){
                echo "<table class='table table-hover'>";
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
                     echo "<td>" . $row['Content'] . "</td>";
                     echo "<td>" . $row['start_Date'] . "</td>";
                     echo "<td>" . $row['due'] . "</td>";
                     echo "<td>Closed</td>";
                     echo "<td>" . $row['priority'] . "</td>";
                     echo "<td> <a href='uploads/". $row['attachment_name'] ."' target='_blank'>" . $row['attachment_name'] . "</a></td>";
                     echo "<td>";
                     //loop to get all names from the sql result beause each task can have many names
                                     while($row2 = mysqli_fetch_array($names)){
                                         echo "<a>".$row2['name']."</a> ";
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
                                           echo "<a>".$row2['name']."</a> ";
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
}
    
     }
    
?>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>