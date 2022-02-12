<?php
include('db.php');
session_start();
if(!isset($_SESSION["username"])||$_SESSION["username"]!=5000){
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
 
        <!-- alert box libraries -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script src="sweetalert2.min.js"></script>
<link rel="stylesheet" href="sweetalert2.min.css">
    <title>History</title>
</head>
<body class="backgroundimage" style="color:white;">
<nav class="navbar navbar-expand-lg navbar-light bg-light navBar-color" >
<a class="navbar-brand navBar-color" href="#"><img class="logosize" src='images/horse.svg'><span class="logoText">Tornado</span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav  ml-auto">
      <a class="nav-item nav-link navBar-color" href="ManagerHome.php">Create Tasks</a>
      <a class="nav-item nav-link navBar-color" href="TasksView.php">View Tasks</a>
      <a class="nav-item nav-link navBar-color" href="modifyTask.php">Modify Tasks</a>
      <a class="nav-item nav-link navBar-color active" href="TasksHistory.php">Tasks History</a>
      <a class="nav-item nav-link navBar-color" href="DueCalendar.php">Calendar</a>
      <a class="nav-item nav-link navBar-color" href="newUser.php">Add User</a>
      <a class="nav-item nav-link navBar-color" href="logout.php">Log Out <img src="images/logout.svg" style="width:23px"></a>

    </div>
  </div>
</nav>
<div class="tableTitles">
    <div>
    <h1>History(Deadline)</h1>
    </div>
    <div>
    <a id="DeadlineHistoryCollap" class="btn btn-primary" data-toggle="collapse" href="#OpenTaskTable" role="button" aria-expanded="false" aria-controls="collapseExample" 
    style="background-color: transparent; border-color:transparent;">
    <img src='images/collapse-up.svg' style="width: 33px;">
    </a>
    </div>
  </div>
  <div id='OpenTaskTable' class="collapse">
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
            echo "<td><pre>" . $row['Content'] . "</pre></td>";
            echo "<td>" . $row['start_Date'] . "</td>";
            echo "<td>" . $row['due'] . "</td>";
            //put radio buttons and set thjeir values to the corrsponding task id
            echo "<td><input type='radio' name='History_tasks_list' value=".$row['task_id']."></input></td>";
            echo "</tr>";

         }
         echo "</table>";
         
        }
    }

    echo '<input type="submit" name="GetHistory" class="submit_btns" value="Get History" style="margin-bottom:10px;">';



    if(isset($_POST["GetHistory"])){
    
        if(empty($_POST['History_tasks_list'])){
            echo "<script>Swal.fire({
                icon: 'error',
                title: 'Try Again!',
                text: 'Please choose task to view its history',
                confirmButtonColor: '#f27474',
                confirmButtonText: 'OK'
              })</script>";
        }else{
    
        $task_id= mysqli_real_escape_string($conn,$_POST['History_tasks_list']);
    
        $getHistory= "SELECT old_due,new_due FROM due_history WHERE task_id='$task_id'";
    
        if($result= mysqli_query($conn,$getHistory)){
            if(mysqli_num_rows($result)>0){

                echo "<script>
                    document.getElementById('DeadlineHistoryCollap').setAttribute('aria-expanded', 'true');
                    document.getElementById('DeadlineHistoryCollap').className = 'btn btn-primary';
                    document.getElementById('OpenTaskTable').className = 'collapse show';

                    </script>";
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
                 echo "</table>";
                 
                }else{
                    echo "no records change";
                }
            }    
        }
    }
    echo "</div>";




    
?>

</form>




<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

<?php
//get opened tasks to get Title, content, priority history
$sql="SELECT task_id,Task_title,Content,priority FROM tasks WHERE status='0'";

    echo '<div class="tableTitles">
    <div>
    <h1>History(Content)</h1>
    </div>
    <div>
    <a id="contentHistCollap" class="btn btn-primary" data-toggle="collapse" href="#OpenTaskTable2" role="button" aria-expanded="false" aria-controls="collapseExample" 
    style="background-color: transparent; border-color:transparent;">
    <img src="images/collapse-up.svg" style="width: 33px;">
    </a>
    </div>
  </div>';
    if($result= mysqli_query($conn,$sql)){
        if(mysqli_num_rows($result)>0){
           
    echo '<div id="OpenTaskTable2" class="collapse">';
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
                echo "<td><pre>" . $row['Content'] . "</pre></td>";
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
             echo "</table>";
             
            }
        }
        echo '<input type="submit" name="OldContent" class="submit_btns" value="Get History" style="margin-bottom:10px;">';
       

?>

</form>

<?php

if(isset($_POST["OldContent"])){

echo "<script>
document.getElementById('contentHistCollap').setAttribute('aria-expanded', 'true');
document.getElementById('contentHistCollap').className = 'btn btn-primary';
document.getElementById('OpenTaskTable2').className = 'collapse show';

</script>";

    if(empty($_POST['History_tasks_list_content'])){
        echo "<script>Swal.fire({
            icon: 'error',
            title: 'Try Again!',
            text: 'Please choose task to view its history',
            confirmButtonColor: '#f27474',
            confirmButtonText: 'OK'
          })</script>";
    }else{

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
                echo "<td><pre>" . $row['Content'] . "</pre></td>";

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
             echo "</table>";
             echo '</div>';
            }else{
                echo "no records change";
            }
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