<?php
include("db.php");
$member_id = 111;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members Page</title>
</head>
<body>
    
<h1>Your Open Tasks</h1>

<?php
    
    session_start();
    $id = $_SESSION["username"];; 
    echo $id;

    $filterQuery="SELECT tasks.task_id,tasks.task_title,Content,start_Date,due,status,priority,attachment_name from tasks 
    INNER JOIN task_members ON task_members.task_id=tasks.task_id
    WHERE status = '0' and task_members.member_id=".$member_id;
    
    if($result= mysqli_query($conn,$filterQuery)){
        if(mysqli_num_rows($result)>0){
            echo "<table>";
            echo "<tr>";
                    echo "<th>Title</th>";
                    echo "<th>Content</th>";
                    echo "<th>Start Date</th>";
                    echo "<th>Due Date</th>";
                    echo "<th>Status</th>";
                    echo "<th>Priority</th>";
                    echo "<th>Attachment</th>";
                    echo "<th>Member Names</th>";
                    echo "<th>leader Names</th>";
                    
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
                 echo "<td>";
                 echo "<td> <a href='/uploads/". $row['attachment_name'] ."'>" . $row['attachment_name'] . "</a></td>";
    //loop to get all names from the sql result beause each task can have many names
                 while($row2 = mysqli_fetch_array($names)){
                     echo "<td><br>member".$row2['name']." </td>";
                 }
                   //get members names for each task query and exectution
                   $namesSql="SELECT name FROM team_members INNER JOIN 
                   task_leaders ON team_members.member_id=task_leaders.leader_id 
                   WHERE task_id=".$row['task_id'];
                   $names= mysqli_query($conn,$namesSql);
                   echo mysqli_error($conn); 
    
    //loop to get all names from the sql result beause each task can have many names
                 while($row2 = mysqli_fetch_array($names)){
                     echo "<td>Leader ".$row2['name']."<br></td>";
                 }
    
             
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
            echo "<table>";
            echo "<tr>";
                    echo "<th>Title</th>";
                    echo "<th>Content</th>";
                    echo "<th>Start Date</th>";
                    echo "<th>Due Date</th>";
                    echo "<th>Status</th>";
                    echo "<th>Priority</th>";
                    echo "<th>Attachment</th>";
                    echo "<th>Member Names</th>";
                    echo "<th>leader Names</th>";
                    echo "<th>Select task</th>"; 
                    
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
                 echo "<td>";
                 echo "<td> <a href='/uploads/". $row['attachment_name'] ."'>" . $row['attachment_name'] . "</a></td>";
    //loop to get all names from the sql result beause each task can have many names
                 while($row2 = mysqli_fetch_array($names)){
                     echo "<td><br>member".$row2['name']." </td>";
                 }
                   //get members names for each task query and exectution
                   $namesSql="SELECT name FROM team_members INNER JOIN 
                   task_leaders ON team_members.member_id=task_leaders.leader_id 
                   WHERE task_id=".$row['task_id'];
                   $names= mysqli_query($conn,$namesSql);
                   echo mysqli_error($conn); 
    
    //loop to get all names from the sql result beause each task can have many names
                 while($row2 = mysqli_fetch_array($names)){
                     echo "<td>Leader ".$row2['name']."<br></td>";
                 }
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




</body>
</html>