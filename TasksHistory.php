<?php
include('db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>History</title>
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
      <a class="nav-item nav-link" href="TasksView.php">View Tasks</a>
      <a class="nav-item nav-link" href="modifyTask.php">Modify Tasks</a>
      <a class="nav-item nav-link active" href="TasksHistory.php">History Tasks</a>
      <a class="nav-item nav-link" href="DueCalendar.php">Calendar</a>
      <a class="nav-item nav-link " href="newUser.php">Add User</a>
    </div>
  </div>
</nav>
<h1>View Deadline History</h1>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

<?php

//get opened tasks to get due date history
$sql="SELECT task_id,Task_title,Content,start_Date,due FROM tasks WHERE status='0'";
if($result= mysqli_query($conn,$sql)){
    if(mysqli_num_rows($result)>0){
        echo "<table class='table table-hover'>";
        echo "<tr>";
                echo "<th scope='col'>Title</th>";
                echo "<th scope='col'>Content</th>";
                echo "<th scope='col'>Start Date</th>";
                echo "<th scope='col'>Due Date</th>";
                echo "<th scope='col'>Select Task</th>";               
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

    echo '<input type="submit" name="GetHistory" value="Get Due Dates History">';
?>


</form>
<?php

if(isset($_POST["GetHistory"])){

    $task_id= mysqli_real_escape_string($conn,$_POST['History_tasks_list']);

    $getHistory= "SELECT old_due,new_due FROM due_history WHERE task_id='$task_id'";

    if($result= mysqli_query($conn,$getHistory)){
        if(mysqli_num_rows($result)>0){
            echo "<table class='table table-hover'>";
            echo "<tr>";
                    echo "<th>Old Date</th>";
                    echo "<th>New Date</th>";             
                echo "</tr>";
    
             while($row = mysqli_fetch_array($result)){
                echo "<tr>";
                echo "<td scope='col'>" . $row['old_due'] . "</td>";
                echo "<td scope='col'>" . $row['new_due'] . "</td>";
                echo "</tr>";

             }
            }else{
                echo "no records change";
            }
        }    

}

?>



<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

<?php
//get opened tasks to get Title, content, priority history
$sql="SELECT task_id,Task_title,Content,priority FROM tasks WHERE status='0'";
if($result= mysqli_query($conn,$sql)){
    if(mysqli_num_rows($result)>0){
       

        echo "<table class='table table-hover'>";
        echo "<tr>";
                echo "<th scope='col'>Title</th>";
                echo "<th scope='col'>Content</th>";
                echo "<th scope='col'>Priority</th>";
                echo "<th scope='col'>Select Task</th>";               
            echo "</tr>";

         while($row = mysqli_fetch_array($result)){
            echo "<tr>";
            echo "<td>" . $row['Task_title'] . "</td>";
            echo "<td>" . $row['Content'] . "</td>";
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
            //put radio buttons and set thjeir values to the corrsponding task id
            echo "<td><input type='radio' name='History_tasks_list_content' value=".$row['task_id']."></input></td>";
            echo "</tr>";

         }
        }
    }
    echo "<h1>Content Change History</h1>";
    echo '<input type="submit" name="OldContent" value="Get Content History">';


?>

</form>

<?php

if(isset($_POST["OldContent"])){

    $task_id= mysqli_real_escape_string($conn,$_POST['History_tasks_list_content']);

    $getHistory= "SELECT task_title,Content,priority FROM tasks_history WHERE task_id='$task_id'";

    if($result= mysqli_query($conn,$getHistory)){
        if(mysqli_num_rows($result)>0){
            echo "<table class='table table-hover'>";
        echo "<tr>";
                echo "<th scope='col'>Title</th>";
                echo "<th scope='col'>Content</th>";
                echo "<th scope='col'>Priority</th>";
            echo "</tr>";
    
             while($row = mysqli_fetch_array($result)){
                echo "<tr>";
                echo "<td>" . $row['task_title'] . "</td>";
                echo "<td>" . $row['Content'] . "</td>";

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
                echo "</tr>";

             }
            }else{
                echo "no records change";
            }
        }    

}

?>


<script src="js/controls.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>