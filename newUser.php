<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>Document</title>
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
      <a class="nav-item nav-link" href="TasksHistory.php">History Tasks</a>
      <a class="nav-item nav-link" href="DueCalendar.php">Calendar</a>
      <a class="nav-item nav-link active" href="newUser.php">Add User</a>
      <a class="nav-item nav-link " href="logout.php"><img src="images/logout.svg" style="width:23px"></a>
    </div>
  </div>
</nav>

<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

<div>
    <label for="Username">Name</label>
    <input type="text" name="Username" required>
</div>
<div>
    <label for="Email">Email</label>
    <input type="email" name="userEmail" required>
</div>
<div>
    <label for="pass">Password</label>
    <input type="password" name="pass" required>
</div>
<div>
    <input type="submit" name="NewUser" value="Create User">
</div>

</form>

<?php
include('db.php');
    if(isset($_POST["NewUser"])){ //Add user to database

  
        $name= mysqli_real_escape_string($conn,$_POST['Username']);
        $password= mysqli_real_escape_string($conn,$_POST['pass']);
        $email= mysqli_real_escape_string($conn,$_POST['userEmail']);

        $query="INSERT INTO team_members(name,password,email) 
        VALUES('$name','$password','$email')";
        mysqli_query($conn,$query);

        echo '<script>
        alert("User Added")
        </script>';
 



    }

?>



<script src="js/controls.js"></script>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    
</body>
</html>