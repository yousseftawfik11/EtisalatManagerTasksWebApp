<?php
include("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">

    <title>Members Page</title>
</head>
<body>
    
<h1>Your Open Tasks</h1>

<?php
    
    session_start();
    $member_id = $_SESSION["username"];; 
    echo $member_id;

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
                 echo "<td>" . $row['Content'] . "</td>";
                 echo "<td>" . $row['start_Date'] . "</td>";
                 echo "<td>" . $row['due'] . "</td>";
                 echo "<td>Open</td>";
                 echo "<td>" . $row['priority'] . "</td>";
                 echo "<td> <a href='/uploads/". $row['attachment_name'] ."'>" . $row['attachment_name'] . "</a></td>";
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
                     echo "<a>".$row2['name']."</a>";
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




<h1>Tasks You Own</h1>

<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

    
    <input type="submit" name="close_task" value ="Close">



<?php
    
    $filterQuery="SELECT tasks.task_id,tasks.task_title,Content,start_Date,due,status,priority,attachment_name from tasks 
    INNER JOIN task_leaders ON task_leaders.task_id=tasks.task_id
    WHERE status = '0' and task_leaders.leader_id=".$member_id;
    
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
                    echo "<th scope='col'>Select task</th>"; 
                    
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
                 echo "<td>Open</td>";
                 echo "<td>" . $row['priority'] . "</td>";
                 echo "<td> <a href='/uploads/". $row['attachment_name'] ."'>" . $row['attachment_name'] . "</a></td>";
                 echo "<td>";
    //loop to get all names from the sql result beause each task can have many names
                 while($row2 = mysqli_fetch_array($names)){
                     echo "<a>".$row2['name']." </a> ";
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
                     echo "<a>".$row2['name']." </a>";
                 }
                 echo "</td>";
                 echo "<td><input type='radio' name='chosen_task' value=".$row['task_id']."></input></td>";

             
         }
         echo "</table>";
         mysqli_free_result($result);
     }else{
         echo "No records";
     }
    }else{
     echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
    

    if(isset($_POST["close_task"])){ //update info of tasks in database

        $task_id = mysqli_real_escape_string($conn,$_POST['chosen_task']);       
    
        $closeTask = "UPDATE tasks SET status ='1' 
        WHERE task_id = '$task_id'";
    
        $query = mysqli_query($conn, $closeTask);
    
        echo "<meta http-equiv='refresh' content='0'>";
    
    
    }
     
    
?>

</form>



<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


</body>
</html>