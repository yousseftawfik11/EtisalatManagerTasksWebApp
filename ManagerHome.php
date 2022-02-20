<?php 

session_start();

setcookie ("member_ID",  $_SESSION["member_ID"], time()+ (86400));
setcookie ("member_Password", $_SESSION["member_Password"], time()+ (86400));
unset($_SESSION["member_ID"]);
unset($_SESSION["member_Password"]);

// if(isset($_SESSION["rememberme"])&&$_SESSION["rememberme"]=="yes"){
//     echo $_SESSION["rememberme"];
//     unset($_SESSION["rememberme"]);
//     setcookie ("member_ID",  $_SESSION["member_ID"], time()-1);
//     setcookie ("member_Password", $_SESSION["member_Password"], time()-1);
//     unset($_SESSION["member_ID"]);
//     unset($_SESSION["member_Password"]);
// }

include 'db.php';
include 'AddTask.php';

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
    <link rel="stylesheet" href="css/styles.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Montserrat:wght@300&display=swap" rel="stylesheet">
 

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!-- alert box libraries -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script src="sweetalert2.min.js"></script>
<link rel="stylesheet" href="sweetalert2.min.css">
    <title>Manager Page</title>
</head>

<body class="backgroundimage">
<nav class="navbar navbar-expand-lg navbar-light  navBar-color" >
<a class="navbar-brand navBar-color" href="#"><img class="logosize" src='images/horse.svg'><span class="logoText">Tornado</span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav  ml-auto">
      <a class="nav-item nav-link active navBar-color" href="ManagerHome.php">Create Tasks </a>
      <a class="nav-item nav-link navBar-color" href="TasksView.php">View Tasks</a>
      <a class="nav-item nav-link navBar-color" href="modifyTask.php">Modify Tasks</a>
      <a class="nav-item nav-link navBar-color" href="TasksHistory.php">History Tasks</a>
      <a class="nav-item nav-link navBar-color" href="DueCalendar.php">Calendar</a>
      <a class="nav-item nav-link navBar-color" href="newUser.php">Add User</a>
      <a class="nav-item nav-link navBar-color" href="logout.php">Log Out <img src="images/logout.svg"  class="logoutAni"></a>
    </div>
  </div>
</nav>

<div class="CreateTask FlexContainer">
<div class="LeftPart">
  
<h1 id="createTitle" style="text-align: center; margin-top:18px;">Create a new task</h1>


<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" class="FormCenter">
    <div class="fieldsSpacing">
      <div class="labelSpace">
       <label for="TaskTitle" class="NewTaskLabel">Task title</label>
      </div>
      <input type="text" name="TaskTitle" class="titleInput inputFeildsFont" required value="<?php if (isset($_POST['TaskTitle'])) echo $_POST['TaskTitle']; ?>">
    </div>
    <div class="fieldsSpacing">
      <div  class="labelSpace">
    <label for="TaskInfo" class="NewTaskLabel">Task Info</label>
    </div>
    <!-- <input type="text" name="TaskInfo" class="contentInput inputFeildsFont" required> -->
    <textarea name="TaskInfo" class="textAreaSize" required><?php if (isset($_POST['TaskInfo'])) echo $_POST['TaskInfo']; ?></textarea>
    </div>
    <div class="fieldsSpacing">
      <div  class="labelSpace">
    <label for="TaskDue" class="NewTaskLabel">Task Due</label>
      </div>
    <input type="date" name="TaskDue" class="titleInput" value="<?php if (isset($_POST['TaskDue'])) echo $_POST['TaskDue']; ?>">
    </div>
<div class="fieldsSpacing">
    <div>
    <label for="team_mem" class="NewTaskLabel">Team Members:</label>
    </div>

<?php
        $sqlQMembers="SELECT * FROM team_members";
        $result1= mysqli_query($conn, $sqlQMembers);

        if(mysqli_num_rows($result1)>0){

            echo '<div class="checkbox-group required titleInput">';

            while($row= mysqli_fetch_assoc($result1)){

            if(isset($_POST['check_list_member'])){
              $checked = (in_array($row["member_id"],$_REQUEST['check_list_member']) ? 'checked' : '');
            }else{
              $checked = '';
            }
            echo '<input type="checkbox" name="check_list_member[]" value="'.$row["member_id"].'" '.$checked.' ><label id="content1" class="checkboxesSpace inputFeildsFont">'.$row["name"].'</label><span class="lineBreak"></br></span>' ;                

            }
            echo'</div>';
        }else{
            echo "0 records";
        }       
        
?>
    <input type="button" class="Checkbox-btns" onclick='selectsMember()' value="Select All"/> 
        <input type="button"  class="Checkbox-Debtns" onclick='deSelectMember()' value="Deselect All"/> 
        </div>
        </div>
        <div class="rightPart">
           <div class="fieldsSpacing" style=" margin-top:125px;">

<div>
<label for="team_mem" class="NewTaskLabel" >Team Owners:</label>
</div>
 
<?php
        $sqlQMembers="SELECT * FROM team_members";
        $result1= mysqli_query($conn, $sqlQMembers);

        if(mysqli_num_rows($result1)>0){
          echo '<div class="checkbox-group required titleInput">';

            while($row= mysqli_fetch_assoc($result1)){

              echo '<input type="checkbox" name="check_list_leader[]" value="'.$row["member_id"].'" ><label class="checkboxesSpace inputFeildsFont">'.$row["name"].'</label><span class="lineBreak"></br></span>' ;                
            }
            echo'</div>';
        }else{
            echo "0 records";
        }
               
?>
<div>
        <input type="button"  class="Checkbox-btns" onclick='selectsLeader()' value="Select All"/> 
        <input type="button" class="Checkbox-Debtns" onclick='deSelectLeader()' value="Deselect All"/> 
        </div>
           </div>
        <div class="fieldsSpacing">
        <div class="labelSpace">
<label for="priority" class="NewTaskLabel">Priority: </label>
</div>
<?php
if(isset($_POST['priority'])){
  if($_POST['priority']==2){
    echo '<select name="priority" class="titleInput inputFeildsFont" style="height: 35px;">
    <option value="1">Low</option>
    <option value="2"selected="selected">Medium</option>
    <option value="3">High</option>
    <option value="4">Very High</option>
  </select>'; 
      }elseif($_POST['priority']==3){
        echo '<select name="priority" class="titleInput inputFeildsFont" style="height: 35px;">
        <option value="1">Low</option>
        <option value="2">Medium</option>
        <option value="3"selected="selected">High</option>
        <option value="4">Very High</option>
      </select>'; 
          }elseif($_POST['priority']==4){
            echo '<select name="priority" class="titleInput inputFeildsFont" style="height: 35px;">
          <option value="1">Low</option>
          <option value="2">Medium</option>
          <option value="3">High</option>
          <option value="4"selected="selected">Very High</option>
        </select>';  
          
      }else{
        echo '<select name="priority" class="titleInput inputFeildsFont" style="height: 35px;">
        <option value="1">Low</option>
        <option value="2">Medium</option>
        <option value="3">High</option>
        <option value="4">Very High</option>
      </select>';
      }
    }
      else{
          echo '<select name="priority" class="titleInput inputFeildsFont" style="height: 35px;">
          <option value="1">Low</option>
          <option value="2">Medium</option>
          <option value="3">High</option>
          <option value="4">Very High</option>
        </select>';
        }
        
?>
<!-- <select name="priority" class="titleInput inputFeildsFont" style="height: 35px;">
  <option value="1">Low</option>
  <option value="2">Medium</option>
  <option value="3">High</option>
  <option value="4">Very High</option>
</select> -->
</div>
<div class="labelSpace inputFeildsFont fieldsSpacing">
<label for="priority" class="NewTaskLabel ">Upload File </label>
</div>
<div >
<input type="File" name="file" style="margin-bottom: 20px;">
</div>
<input type="submit" name="submit" class="TaskSubmit-btn">
</div>
</form>
</div>





<script src="js/controls.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
</body>
</html>