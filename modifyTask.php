<?php
session_start();
include 'sendmail.php';
include 'mailer.php';
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

    <title>Modify Tasks</title>
</head>
<body class="backgroundimage" style="color:white;">
<nav class="navbar navbar-expand-lg navbar-light bg-light navBar-color" >
<a class="navbar-brand navBar-color" href="#"><img class="logosize" src='images/horse.svg'><br><span class="logoText">Tornado</span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav  ml-auto">
      <a class="nav-item nav-link navBar-color" href="ManagerHome.php">Create Tasks</a>
      <a class="nav-item nav-link navBar-color" href="TasksView.php">View Tasks</a>
      <a class="nav-item nav-link navBar-color active" href="modifyTask.php">Modify Tasks</a>
      <a class="nav-item nav-link navBar-color" href="TasksHistory.php">History Tasks</a>
      <a class="nav-item nav-link navBar-color" href="DueCalendar.php">Calendar</a>
      <a class="nav-item nav-link navBar-color" href="newUser.php">Add User</a>
      <a class="nav-item nav-link navBar-color" href="logout.php">Log Out <img src="images/logout.svg" style="width:23px"></a>


    </div>
  </div>
</nav>

<?php
include 'db.php';   
if(!isset($_SESSION["username"])||$_SESSION["username"]!=5000){
    echo '
    <script>
    window.location.href="index.php";
    </script>
  ';
}
?>

<div class="tableTitles">
    <div>
    <h1>Modify Tasks</h1>
    </div>
    <div>
    <a id="ModifyCollap" class="btn btn-primary" data-toggle="collapse" href="#OpenTaskTable" role="button" aria-expanded="false" aria-controls="collapseExample" 
    style="background-color: transparent; border-color:transparent;">
    <img src='images/collapse-up.svg' style="width: 33px;">
    </a>
    </div>
  </div>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

    
<div id="OpenTaskTable" class="collapse">
<?php
   
               

$sql="SELECT task_id,Task_title,Content,start_Date,due,status,priority,attachment_name FROM tasks WHERE status='0'";
if($result= mysqli_query($conn,$sql)){
    if(mysqli_num_rows($result)>0){
        echo "<table class='table table-hover'>";
        echo "<tr>";
        echo "<th scope='col'>Title</th>";
        echo "<th scope='col'>Content</th>";
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
             echo "<td>" . $row['Task_title'] . "</td>";
             echo "<td><pre>" . $row['Content'] . "</pre></td>";
             echo "<td>";
//loop to get all names from the sql result beause each task can have many names
             while($row2 = mysqli_fetch_array($names)){
                 echo "<a>".$row2['name']." </a></br>";
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
                echo "<a> ".$row2['name']."</a></br>";
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



?>

    <button id='ShoweditMem' type="submit" name="show" class="submit_btns"  style="width: fit-content;">Change Members/Owner</button>
<input id='ShowModifyCont' type="submit" name="load" class="submit_btns" value="Change Content" style="width: fit-content;"><br>
<!-- </div> -->
<hr>



<?php
if(isset($_POST["show"])){
    echo "<script>
                    document.getElementById('ModifyCollap').setAttribute('aria-expanded', 'true');
                    document.getElementById('ModifyCollap').className = 'btn btn-primary';
                    document.getElementById('OpenTaskTable').className = 'collapse show';

                    </script>";
    if(empty($_POST['chosen_task'])){
        echo "<script>Swal.fire({
            icon: 'error',
            title: 'Try Again!',
            text: 'Please choose task to edit',
            confirmButtonColor: '#f27474',
            confirmButtonText: 'OK'
          })</script>";
    }else{

    echo "<div id='membersList' style='margin-left:23px;'>";
    $_SESSION["task_id"] = $_POST['chosen_task'];
    $sqlQMembers="SELECT * FROM team_members";
    $result1= mysqli_query($conn, $sqlQMembers);
    if(mysqli_num_rows($result1)>0){
        while($row= mysqli_fetch_assoc($result1)){
            echo '<input type="checkbox" name="check_list_leaders[]" value="'.$row["member_id"].'"><label class="checkboxesSpace inputFeildsFont">'.$row["name"].'</label> <br>' ;                
        }
    }else{
        echo "0 records";
    }
    echo "</div>";
    echo'<div id="membersList-ctrl">
    <input type="button" onclick=selectsLeaders() class="submit_btns" value="Select All"/> 
        <input type="button" onclick=deSelectLeaders() class="submit_btns" value="Deselect All"/> 
        <input type="submit" name="Change_Leader" class="submit_btns" value="Change Leaders" style="width: fit-content;">
        <input type="submit" name="Change_Members" class="submit_btns" value ="Change Members" style="width: fit-content;">
        </div>';
    }

}

if(isset($_POST["load"])){ //loading info into the change textboxes and changing data in tasks
    
    echo "<script>
    document.getElementById('ModifyCollap').setAttribute('aria-expanded', 'true');
    document.getElementById('ModifyCollap').className = 'btn btn-primary';
    document.getElementById('OpenTaskTable').className = 'collapse show';

    </script>";
    if(empty($_POST['chosen_task'])){
        echo "<script>Swal.fire({
            icon: 'error',
            title: 'Try Again!',
            text: 'Please choose task to edit',
            confirmButtonColor: '#f27474',
            confirmButtonText: 'OK'
          })</script>";
    }else{

        $task_id = mysqli_real_escape_string($conn,$_POST['chosen_task']);
        echo "<div style='margin-left:23px;'>";

        $_SESSION["task_id"] = $task_id;
        $sql="SELECT Task_title,priority,Content FROM tasks WHERE task_id = ".$task_id;
        if($result= mysqli_query($conn,$sql)){
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_array($result)){
                    echo '<form action="'.$_SERVER["PHP_SELF"].'" method="post">
                    <label for="TaskTitle">Task title</label></br>
                    <input type="text" style="width: 250px;" name="TaskTitle" required value="'.$row["Task_title"].'"><br>

                    <label for="TaskInfo">Task Info</label></br>
                    <textarea name="TaskInfo" class="textAreaSize">'.$row["Content"].'</textarea><br>
                    ';
                    if($row['priority']==1){
                    echo '
                    <label for="priority">Priority: </label></br>
                    <select name="priority">
                      <option value="1">Low</option>
                      <option value="2">Medium</option>
                      <option value="3">High</option>
                      <option value="4">Very High</option>
                    </select>
                    </div>
                    <br>
                    <input type="submit" class="submit_btns" value="Edit" name="edit" style="margin-left:24px;">
                    
                    </form>';
                    }elseif($row['priority']==2){
                        echo '
                        <label for="priority">Priority: </label></br>
                        <select name="priority">
                          <option value="1">Low</option>
                          <option value="2" selected="selected">Medium</option>
                          <option value="3">High</option>
                          <option value="4">Very High</option>
                        </select>
                        </div>
                        <br>
                        <input type="submit" class="submit_btns" value="Edit" name="edit" style="margin-left:24px;">
                        
                        </form>';
                        }elseif($row['priority']==3){
                            echo '
                            <label for="priority">Priority: </label></br>
                            <select name="priority">
                              <option value="1">Low</option>
                              <option value="2" >Medium</option>
                              <option value="3" selected="selected">High</option>
                              <option value="4">Very High</option>
                            </select>
                            </div>
                            <br>
                            <input type="submit" class="submit_btns" value="Edit" name="edit" style="margin-left:24px;">
                            
                            </form>';
                            }elseif($row['priority']==4){
                                echo '
                                <label for="priority">Priority: </label></br>
                                <select name="priority">
                                  <option value="1">Low</option>
                                  <option value="2" >Medium</option>
                                  <option value="3" >High</option>
                                  <option value="4" selected="selected">Very High</option>
                                </select>
                                </div>
                                <br>
                                <input type="submit" class="submit_btns" value="Edit" name="edit" style="margin-left:24px;">
                                
                                </form>';
                                }

                }
            }
        
        }


    }
}
?>
</form>
</div>
<?php
if(isset($_POST["edit"])){ //update info of tasks in database

    $task_id = $_SESSION["task_id"];

    $title= mysqli_real_escape_string($conn,$_POST['TaskTitle']);
    $info = mysqli_real_escape_string($conn, $_POST['TaskInfo']);
    $priority = mysqli_real_escape_string($conn,$_POST["priority"]);

    $sql="SELECT Task_title,priority,Content FROM tasks WHERE task_id = ".$task_id;
    if($result= mysqli_query($conn,$sql)){
        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_array($result)){
                $addToHistory="INSERT INTO tasks_history(task_id, task_title, Content, priority) 
                VALUES(".$task_id.",'".$row["Task_title"]."', '".$row["Content"]."',".$row["priority"].")";
                $query2= mysqli_query($conn,$addToHistory);
                echo mysqli_error($conn); 
            }
        

            $memberid="(SELECT member_id FROM task_members WHERE task_id = ".$task_id.")
            UNION(SELECT leader_id FROM task_leaders WHERE task_id = ".$task_id.")";
            // if($result= mysqli_query($conn,$memberid)){
            //     if(mysqli_num_rows($result)>0){
            //         while($row = mysqli_fetch_array($result)){
            //             $getEmail="SELECT email FROM team_members WHERE member_id=".$row["member_id"];
            //             $Emailexexcute= mysqli_query($conn, $getEmail);
            //             while($row2 = mysqli_fetch_array($Emailexexcute)){

            //                 $sql2="SELECT due FROM tasks WHERE task_id = ".$task_id;
            //                 if($result2= mysqli_query($conn,$sql2)){
            //                     if(mysqli_num_rows($result2)>0){
            //                         while($row3 = mysqli_fetch_array($result2)){
            //                             sendMailMemberModify($row2['email'],$title,$info,$priority,$row3['due']);
            //                         }
            //                     }
            //                 }
            //             }   
            //         }
            //     }
            // }
        $mailArray=[];
           
           if($result= mysqli_query($conn,$memberid)){
                if(mysqli_num_rows($result)>0){
                    while($row = mysqli_fetch_array($result)){
                        $getEmail="SELECT email FROM team_members WHERE member_id=".$row["member_id"];
                        $Emailexexcute= mysqli_query($conn, $getEmail);
                        while($row2 = mysqli_fetch_array($Emailexexcute)){
                            array_push($mailArray,$row2['email']);
                        }   
                        $sql2="SELECT due FROM tasks WHERE task_id = ".$task_id;
                            if($result2= mysqli_query($conn,$sql2)){
                                if(mysqli_num_rows($result2)>0){
                                    while($row3 = mysqli_fetch_array($result2)){
                                        // sendMailMemberModify($row2['email'],$title,$info,$priority,$row3['due']);
                                        sendModify($mailArray,$info,$row3['due'],$title,$priority);
                                    }
                                }
                            }
                    }
                }
            }

        }
    }


    
    
    $addTask = "UPDATE tasks SET Task_title ='$title' ,Content = '$info',priority = '$priority' 
    WHERE task_id = '$task_id'";
    $query = mysqli_query($conn, $addTask);
    
    
    echo "<script>Swal.fire({
  title: 'Task Edited Successfully!',
  icon: 'success',
  confirmButtonColor: '#38a53e',
  confirmButtonText: 'OK'
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href='modifyTask.php';

  }
})</script>";


}



// adding a submit button to change the leaders
if(isset($_POST["Change_Leader"])){

    if(empty($_POST['check_list_leaders'])){
        echo "<script>Swal.fire({
            icon: 'error',
            title: 'Try Again!',
            text: 'Please choose new leaders',
            confirmButtonColor: '#f27474',
            confirmButtonText: 'OK'
          })</script>";
    }else{
    
        $task_id = $_SESSION["task_id"];
        $leaderslist= $_POST["check_list_leaders"];

        $removeTask = "DELETE FROM task_leaders WHERE task_id = ".$task_id;
        $query = mysqli_query($conn, $removeTask);

        for($i=0; $i<sizeof($leaderslist); $i++){  
        
            $addTask = "INSERT INTO task_leaders(leader_id, task_id) VALUES(".$leaderslist[$i].",".$task_id.")";
            $query = mysqli_query($conn, $addTask);
            if ($query) {
                echo "<script>Swal.fire({
                    title: 'Task Edited Successfully!',
                    icon: 'success',
                    confirmButtonColor: '#38a53e',
                    confirmButtonText: 'OK'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href='modifyTask.php';
                  
                    }
                  })</script>";           }
     
        }


    }
    
}

if(isset($_POST["Change_Members"])){ //adding button to change members

    if(empty($_POST['check_list_leaders'])){
        echo "<script>Swal.fire({
            icon: 'error',
            title: 'Try Again!',
            text: 'Please choose new leaders',
            confirmButtonColor: '#f27474',
            confirmButtonText: 'OK'
          })</script>";
    }else{

        $task_id = $_SESSION["task_id"];
        $leaderslist= $_POST["check_list_leaders"];

        $removeTask = "DELETE FROM task_members WHERE task_id = ".$task_id;
        $query = mysqli_query($conn, $removeTask);

        for($i=0; $i<sizeof($leaderslist); $i++){  
        
            $addTask = "INSERT INTO task_members(member_id, task_id) VALUES(".$leaderslist[$i].",".$task_id.")";
            $query = mysqli_query($conn, $addTask);
            if ($query) {
                echo "<script>Swal.fire({
                    title: 'Task Edited Successfully!',
                    icon: 'success',
                    confirmButtonColor: '#38a53e',
                    confirmButtonText: 'OK'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href='modifyTask.php';
                  
                    }
                  })</script>";
            }
     
        }




    }
}



//change due date form
if(isset($_POST["ChangeDate"])){

    if(empty($_POST['tasks_list'])){
        echo "<script>Swal.fire({
            icon: 'error',
            title: 'Try Again!',
            text: 'Please choose task to edit',
            confirmButtonColor: '#f27474',
            confirmButtonText: 'OK'
          })</script>";
    }else{

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

        echo "<script>Swal.fire({
            title: 'Date Updated Successfully!',
            icon: 'success',
            confirmButtonColor: '#38a53e',
            confirmButtonText: 'OK'
          })</script>";
        
    }
}

?>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

<div class="tableTitles">
    <div>
    <h1>Change Task Due Date</h1>
    </div>
    <div>
    <a class="btn btn-primary" data-toggle="collapse" href="#OpenTaskTable2" role="button" aria-expanded="false" aria-controls="collapseExample" 
    style="background-color: transparent; border-color:transparent;">
    <img src='images/collapse-up.svg' style="width: 33px;">
    </a>
    </div>
  </div>

  <div id="OpenTaskTable2" class="collapse">

<label for="new_due" style="margin-left: 23px;">New Due Date</label>
<input type="date" name="new_due" >
<input type="submit" class="submit_btns" value="Edit" name="ChangeDate">

<?php

//get opened tasks to change their due date
$sql="SELECT task_id,Task_title,Content,start_Date,due FROM tasks WHERE status='0'";
if($result= mysqli_query($conn,$sql)){
    if(mysqli_num_rows($result)>0){
        echo "<table class='table table-hover'>";
        echo "<tr>";
        echo "<th  scope='col'>Title</th>";
        echo "<th  scope='col'>Content</th>";
        echo "<th  scope='col'>Start Date</th>";
        echo "<th  scope='col'>Due Date</th>"; 
        echo "<th  scope='col'>Select Task</th>"; 
                
        echo "</tr>";

        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
            echo "<td>" . $row['Task_title'] . "</td>";
            echo "<td><pre>" . $row['Content'] . "</pre></td>";
            echo "<td>" . $row['start_Date'] . "</td>";
            echo "<td>" . $row['due'] . "</td>";
            //put radio buttons and set thjeir values to the corrsponding task id
            echo "<td><input type='radio' name='tasks_list' value=".$row['task_id']."></input></td>";
            echo "</tr>";
         }
        }
    }

?>

</div>
</form>

<script>

   
function ShowEditMembers() {
    document.getElementById("membersList").style.display = "none";
    document.getElementById("membersList-ctrl").style.display = "none";
    document.getElementById("ShoweditMem").style.display = "none";
    document.getElementById("ShowModifyCont").style.display = "none";

  } 

</script>


<script src="js/controls.js"></script>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>


