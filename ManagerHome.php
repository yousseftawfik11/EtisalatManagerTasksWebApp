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
    <link rel="stylesheet" href="css/styles.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Manager Page</title>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Tasks System</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="ManagerHome.php">Create Tasks </a>
      <a class="nav-item nav-link" href="TasksView.php">View Tasks</a>
      <a class="nav-item nav-link" href="modifyTask.php">Modify Tasks</a>
      <a class="nav-item nav-link" href="TasksHistory.php">History Tasks</a>
      <a class="nav-item nav-link" href="DueCalendar.php">Calendar</a>
    </div>
  </div>
</nav>

<div class="CreateTask">
<h1>Create a new task</h1>
    
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
    
    <label for="TaskTitle">Task title</label>
    <input type="text" name="TaskTitle" required><br>

    <label for="TaskInfo">Task Info</label>
    <input type="text" name="TaskInfo" required><br>

    <label for="TaskDue">Task Due</label>
    <input type="date" name="TaskDue" required><br>
    
    <label for="team_mem">Team Members:</label> <br>
    <input type="button" onclick='selectsMember()' value="Select All"/> 
        <input type="button" onclick='deSelectMember()' value="Deselect All"/> <br>
<?php
        $sqlQMembers="SELECT * FROM team_members";
        $result1= mysqli_query($conn, $sqlQMembers);

        if(mysqli_num_rows($result1)>0){

            echo '<div class="checkbox-group required">';

            while($row= mysqli_fetch_assoc($result1)){

                echo '<input type="checkbox" name="check_list_member[]" value="'.$row["member_id"].'" ><label>'.$row["name"].'</label> <br>' ;                
            }
            echo'</div>';
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

                echo '<input type="checkbox" name="check_list_leader[]" value="'.$row["member_id"].'" ><label>'.$row["name"].'</label> <br>' ;                
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
</div>






<script src="js/controls.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
</body>
</html>