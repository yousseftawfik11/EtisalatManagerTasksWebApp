<?php
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

    <title>Create User</title>
</head>
<body class="backgroundimage">
<nav class="navbar navbar-expand-lg navbar-light bg-light navBar-color" style="background-color: #3b6d4f !important;">
<a class="navbar-brand navBar-color" href="#"><img class="logosize" src='images/horse.svg'><br><span class="logoText">Tornado</span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link navBar-color" href="ManagerHome.php">Create Tasks </a>
      <a class="nav-item nav-link navBar-color" href="TasksView.php">View Tasks</a>
      <a class="nav-item nav-link navBar-color" href="modifyTask.php">Modify Tasks</a>
      <a class="nav-item nav-link navBar-color" href="TasksHistory.php">History Tasks</a>
      <a class="nav-item nav-link navBar-color " href="DueCalendar.php">Calendar</a>
      <a class="nav-item nav-link navBar-color active" href="newUser.php">Add User</a>
      <a class="nav-item nav-link navBar-color" href="logout.php">Log Out <img src="images/logout.svg"  class="logoutAni"></a>
    </div>
  </div>
</nav>
<div class="CreateTask AddUserPadding">
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="FormCenter"  >

    <h1 id="PageTitle">Add New Team Member</h1>
    <div class="fieldsSpacing2">
      <div>
        <label for="Username">Name</label>
        </div>
        <input type="text" name="Username" class="newUserInput" required>
    </div>
    <div class="fieldsSpacing2">
      <div>
        <label for="Email">Email</label>
        </div>
        <input type="email" name="userEmail"class="newUserInput" required>
    </div>
    <div class="fieldsSpacing2">
      <div>
        <label for="pass">Password</label>
        </div>
        <input type="password" name="pass" class="newUserInput" required>
    </div>
    <div>
        <input type="submit" name="NewUser" value="Add Member" class="TaskSubmit-btn" style="margin-top: 20px; margin-bottom:0px;" >
    </div>

    </form>
</div>
<?php
include('db.php');
    if(isset($_POST["NewUser"])){ //Add user to database

  
        $name= strtolower(mysqli_real_escape_string($conn,$_POST['Username']));
        $password= strtolower(mysqli_real_escape_string($conn,$_POST['pass']));
        $email=strtolower( mysqli_real_escape_string($conn,$_POST['userEmail']));

        //to make sure everything is in lower case in db
        



        $EmailQuery="SELECT email from team_members WHERE email='$email'";
        if($result= mysqli_query($conn,$EmailQuery)){
          if(mysqli_num_rows($result)>0){
            echo "<script>Swal.fire({
              icon: 'error',
              title: 'Try Again!',
              text: 'This Email Already Exists...',
              confirmButtonColor: '#f27474',
              confirmButtonText: 'OK'
            })</script>";

          }else{
        $query="INSERT INTO team_members(name,password,email) 
        VALUES('$name','$password','$email')";
        mysqli_query($conn,$query);

        echo "<script>Swal.fire({
          title: 'User Created Successfully!',
          icon: 'success',
          confirmButtonColor: '#38a53e',
          confirmButtonText: 'OK'
        })</script>";
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