<?php
include 'db.php';   
session_start();
?>

<h1>Modify Tasks</h1>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

    <input type="button" onclick=selectsLeaders() value="Select All"/> 
    <input type="button" onclick=deSelectLeaders() value="Deselect All"/><br>   
    <input type="submit" name="Change_Leader" value="Change Leaders">
    <input type="submit" name="Change_Members" value ="Change Members">

<?php
    $sqlQMembers="SELECT * FROM team_members";
    $result1= mysqli_query($conn, $sqlQMembers);
    if(mysqli_num_rows($result1)>0){
        while($row= mysqli_fetch_assoc($result1)){
            echo '<input type="checkbox" name="check_list_leaders[]" value="'.$row["member_id"].'"><label>'.$row["name"].'</label> <br>' ;                
        }
    }else{
        echo "0 records";
    }
               

$sql="SELECT task_id,Task_title,Content,start_Date,due,status,priority,attachment_name FROM tasks WHERE status='0'";
if($result= mysqli_query($conn,$sql)){
    if(mysqli_num_rows($result)>0){
        echo "<table>";
        echo "<tr>";
        echo "<th>Title</th>";
        echo "<th>Content</th>";
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
             echo "<td>" . $row['Task_title'] . "</td>";
             echo "<td>" . $row['Content'] . "</td>";
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
                echo "<td>Leader ".$row2['name']."&nbsp&nbsp</td>";
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

?>

<input type="submit" name="load" value="Change"><br>


</form>


<?php
if(isset($_POST["load"])){ //loading info into the change textboxes and changing data in tasks
    
    $task_id = mysqli_real_escape_string($conn,$_POST['chosen_task']);
 
    $_SESSION["task_id"] = $task_id;
    // if($task_id && $leaderslist){        condition to handle if no inputs inserted
        $sql="SELECT Task_title,priority,Content FROM tasks WHERE task_id = ".$task_id;
        if($result= mysqli_query($conn,$sql)){
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_array($result)){

                    echo '<form action="'.$_SERVER["PHP_SELF"].'" method="post">
                    <label for="TaskTitle">Task title</label>
                    <input type="text" name="TaskTitle" value="'.$row["Task_title"].'"><br>
                    
                    <label for="TaskInfo">Task Info</label>
                    <input type="text" name="TaskInfo" value="'.$row["Content"].'"><br>
                    
                    <label for="priority">Priority: </label>
                    <select name="priority">
                      <option value="1">Low</option>
                      <option value="2">Medium</option>
                      <option value="3">High</option>
                      <option value="4">Very High</option>
                    </select>
                    <br>
                    <input type="submit" name="edit">
                    </form>';

                    

                }
            }
     
        }


    // }
}

if(isset($_POST["edit"])){ //update info of tasks in database

    $task_id = $_SESSION["task_id"];



    $title= mysqli_real_escape_string($conn,$_POST['TaskTitle']);
    $info = mysqli_real_escape_string($conn, $_POST['TaskInfo']);
    $priority = mysqli_real_escape_string($conn,$_POST["priority"]);
   

    $addTask = "UPDATE tasks SET Task_title ='$title' ,Content = '$info',priority = '$priority' 
    WHERE task_id = '$task_id'";

    $query = mysqli_query($conn, $addTask);

    echo "<meta http-equiv='refresh' content='0'>";


}



// adding a submit button to change the leaders
if(isset($_POST["Change_Leader"])){

    $task_id = mysqli_real_escape_string($conn,$_POST['chosen_task']);
    $leaderslist= $_POST["check_list_leaders"];

    // if($task_id && $leaderslist){        condition to handle if no inputs inserted
        $removeTask = "DELETE FROM task_leaders WHERE task_id = ".$task_id;
        $query = mysqli_query($conn, $removeTask);

        for($i=0; $i<sizeof($leaderslist); $i++){  
        
            $addTask = "INSERT INTO task_leaders(leader_id, task_id) VALUES(".$leaderslist[$i].",".$task_id.")";
            $query = mysqli_query($conn, $addTask);
            if ($query) {
                echo "team members added";
           }
     
        }
        echo "<meta http-equiv='refresh' content='0'>";



    // }
}

if(isset($_POST["Change_Members"])){ //adding button to change members

    $task_id = mysqli_real_escape_string($conn,$_POST['chosen_task']);
    $leaderslist= $_POST["check_list_leaders"];

    // if($task_id && $leaderslist){        condition to handle if no inputs inserted
        $removeTask = "DELETE FROM task_members WHERE task_id = ".$task_id;
        $query = mysqli_query($conn, $removeTask);

        for($i=0; $i<sizeof($leaderslist); $i++){  
        
            $addTask = "INSERT INTO task_members(member_id, task_id) VALUES(".$leaderslist[$i].",".$task_id.")";
            $query = mysqli_query($conn, $addTask);
            if ($query) {
                echo "team members added";
           }
     
        }
        echo "<meta http-equiv='refresh' content='0'>";



    // }
}



//change due date form
if(isset($_POST["ChangeDate"])){

    //task id from table
        $task_id= mysqli_real_escape_string($conn,$_POST['tasks_list']);
        //new due date from calendar
        $newDue= mysqli_real_escape_string($conn,$_POST['new_due']);
    
        //get the current due date from the given task id
        $getDue="SELECT due FROM tasks WHERE task_id=".$task_id;
        
    
        if($result= mysqli_query($conn,$getDue)){
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_array($result)){
                    $OldDue=$row['due'];
                    //store in this varaible
                }
            }
        }
        
        //add the history in history table with new, old dates and task id as foreign key
        $History_input="INSERT INTO  due_history(task_id,old_due,new_due) 
        VALUES('$task_id','$OldDue','$newDue')";
        mysqli_query($conn,$History_input);
    
    //update the task record with new due date
        $updateDue="UPDATE tasks SET due='$newDue' WHERE task_id='$task_id'";
        mysqli_query($conn,$updateDue);
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

<?php

//get opened tasks to change their due date
$sql="SELECT task_id,Task_title,Content,start_Date,due FROM tasks WHERE status='0'";
if($result= mysqli_query($conn,$sql)){
    if(mysqli_num_rows($result)>0){
        echo "<table>";
        echo "<tr>";
        echo "<th>Title</th>";
        echo "<th>Content</th>";
        echo "<th>Status</th>";
        echo "<th>Priority</th>";
        echo "<th>Attachment</th>";
        echo "<th>Member Names</th>";
        echo "<th>leader Names</th>";              
        echo "</tr>";

        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
            echo "<td>" . $row['Task_title'] . "</td>";
            echo "<td>" . $row['Content'] . "</td>";
            echo "<td>" . $row['start_Date'] . "</td>";
            echo "<td>" . $row['due'] . "</td>";
            //put radio buttons and set thjeir values to the corrsponding task id
            echo "<td><input type='radio' name='tasks_list' value=".$row['task_id']."></input></td>";
            echo "</tr>";
         }
        }
    }

?>
<label for="new_due">New Due Date</label>
<input type="date" name="new_due">
<input type="submit" name="ChangeDate">
</form>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

<?php

//get opened tasks to get due date history
$sql="SELECT task_id,Task_title,Content,start_Date,due FROM tasks WHERE status='0'";
if($result= mysqli_query($conn,$sql)){
    if(mysqli_num_rows($result)>0){
        echo "<table>";
        echo "<tr>";
                echo "<th>Title</th>";
                echo "<th>Content</th>";
                echo "<th>Start Date</th>";
                echo "<th>Due Date</th>";
                echo "<th>Select Task</th>";               
            echo "</tr>";

         while($row = mysqli_fetch_array($result)){
            echo "<tr>";
            echo "<td>" . $row['Task_title'] . "</td>";
            echo "<td>" . $row['Content'] . "</td>";
            echo "<td>" . $row['start_Date'] . "</td>";
            echo "<td>" . $row['due'] . "</td>";
            //put radio buttons and set thjeir values to the corrsponding task id
            echo "<td><input type='radio' name='History_tasks_list' value=".$row['task_id']."></input></td>";
            echo "</tr>";

         }
        }
    }

?>
<input type="submit" name="GetHistory" value="Get History">
</form>
<?php

if(isset($_POST["GetHistory"])){

    $task_id= mysqli_real_escape_string($conn,$_POST['History_tasks_list']);

    $getHistory= "SELECT old_due,new_due FROM due_history WHERE task_id='$task_id'";

    if($result= mysqli_query($conn,$getHistory)){
        if(mysqli_num_rows($result)>0){
            echo "<table>";
            echo "<tr>";
                    echo "<th>Old Date</th>";
                    echo "<th>New Date</th>";             
                echo "</tr>";
    
             while($row = mysqli_fetch_array($result)){
                echo "<tr>";
                echo "<td>" . $row['old_due'] . "</td>";
                echo "<td>" . $row['new_due'] . "</td>";
                echo "</tr>";

             }
            }
        }    

}

?>


<script src="js/controls.js"></script>

</body>
</html>