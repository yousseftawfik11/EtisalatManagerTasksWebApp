<?php 

include 'db.php';
include 'AddTask.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Page</title>
</head>

<body>

<h1>Create a new task</h1>
    
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
    
    <label for="TaskTitle">Task title</label>
    <input type="text" name="TaskTitle"><br>

    <label for="TaskInfo">Task Info</label>
    <input type="text" name="TaskInfo"><br>

    <label for="TaskDue">Task Due</label>
    <input type="date" name="TaskDue"><br>
    
    <label for="team_mem">Team Members:</label> <br>
    <input type="button" onclick='selectsMember()' value="Select All"/> 
        <input type="button" onclick='deSelectMember()' value="Deselect All"/> <br>
<?php
        $sqlQMembers="SELECT * FROM team_members";
        $result1= mysqli_query($conn, $sqlQMembers);

        if(mysqli_num_rows($result1)>0){

            while($row= mysqli_fetch_assoc($result1)){

                echo '<input type="checkbox" name="check_list_member[]" value="'.$row["member_id"].'"><label>'.$row["name"].'</label> <br>' ;                
            }
        }else{
            echo "0 records";
        }       
?>
<label for="team_mem">Team Leaders:</label> <br>
 
        <input type="button" onclick='selectsLeader()' value="Select All"/> 
        <input type="button" onclick='deSelectLeader()' value="Deselect All"/><br>   
<?php
        $sqlQMembers="SELECT * FROM team_members";
        $result1= mysqli_query($conn, $sqlQMembers);

        if(mysqli_num_rows($result1)>0){

            while($row= mysqli_fetch_assoc($result1)){

                echo '<input type="checkbox" name="check_list_leader[]" value="'.$row["member_id"].'"><label>'.$row["name"].'</label> <br>' ;                
            }
        }else{
            echo "0 records";
        }
               
?>

<label for="priority">Priority: </label>
<select name="priority">
  <option value="1">Low</option>
  <option value="2">Medium</option>
  <option value="3">High</option>
  <option value="4">Very High</option>
</select>
<br>
<input type="File" name="file"> <br>
<input type="submit" name="submit">
</form>

<a href="/18766-Youssef Tawfik ResumeBefore.pdf">trial </a>


<h1>Open Tasks</h1>

<?php 

$sql="SELECT task_id,Task_title,Content,start_Date,due,status,priority,attachment_name FROM tasks WHERE status='0'";
if($result= mysqli_query($conn,$sql)){
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
                echo "<td>" . $row['Task_title'] . "</td>";
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


echo "<h1>Closed Tasks</h1>";


$sql="SELECT task_id,Task_title,Content,start_Date,due,status,priority,attachment_name FROM tasks WHERE status='1'";
if($result= mysqli_query($conn,$sql)){
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
                echo "<th>Names</th>";
                
            echo "</tr>";
            while($row = mysqli_fetch_array($result)){

              
          
                
                echo "<tr>";
                echo "<td>" . $row['Task_title'] . "</td>";
                echo "<td>" . $row['Content'] . "</td>";
                echo "<td>" . $row['start_Date'] . "</td>";
                echo "<td>" . $row['due'] . "</td>";
                echo "<td>Closed</td>";
                echo "<td>" . $row['priority'] . "</td>";
                echo "<td>" . $row['attachment_name'] . "</td>";

               

            echo "</tr>";
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





<script src="js/controls.js"></script>
</body>
</html>