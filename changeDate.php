<?php
include 'db.php';

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



</body>
</html>