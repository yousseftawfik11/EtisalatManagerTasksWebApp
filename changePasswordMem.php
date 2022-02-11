<?php
include('db.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Montserrat:wght@300&display=swap" rel="stylesheet">
 

    <!-- alert box libraries -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
    <title>Change Password</title>
</head>
<body  class="backgroundimage">

<nav class="navbar navbar-expand-lg navbar-light  navBar-color" >
<a class="navbar-brand navBar-color" href="#"><img class="logosize" src='images/horse.svg'><br><span class="logoText">Tornado</span></a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav  ml-auto">
    <a class="nav-item nav-link navBar-color" href="membersdash.php"><img src="images/back.svg"  class="logoutAni backIcon"></a>
<a class="nav-item nav-link navBar-color" href="logout.php">Log Out <img src="images/logout.svg"  class="logoutAni"></a>
<a class="nav-item nav-link navBar-color" href="changePasswordMem.php">Change Password </a>

</div>
  </div>
</nav>

<div class="CreateTask AddUserPadding">
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="FormCenter"  >

    <h1 id="PageTitle">Change Password</h1>
    <div class="fieldsSpacing2">
      <div>
        <label for="oldPass">Old Password</label>
        </div>
        <input type="text" name="oldPass" class="newUserInput" required>
    </div>
    <div class="fieldsSpacing2">
      <div>
        <label for="newPass">New Password</label>
        </div>
        <input type="text" name="newPass"class="newUserInput" required>
    </div>
    <div class="fieldsSpacing2">
      <div>
        <label for="ConfirmPass">Confirm New Password</label>
        </div>
        <input type="text" name="ConfirmPass"class="newUserInput" required>
    </div>
    <div>
        <input type="submit" name="changePass" value="Add Member" class="TaskSubmit-btn" style="margin-top: 20px; margin-bottom:0px;" >
    </div>

    </form>
</div>
    
<?php
include('db.php');
    if(isset($_POST["changePass"])){ //Add user to database
        session_start();
        $userId=$_SESSION["username"];


        $oldPass= strtolower(mysqli_real_escape_string($conn,$_POST['oldPass']));
        // $password= strtolower(mysqli_real_escape_string($conn,$_POST['pass']));
        $newPassword=strtolower( mysqli_real_escape_string($conn,$_POST['newPass']));
        $ConfirmPass=strtolower( mysqli_real_escape_string($conn,$_POST['ConfirmPass']));
        $passCheck="SELECT * FROM team_members WHERE member_id=$userId AND password = '$oldPass'";
        $queryExec=mysqli_query($conn,$passCheck);
        $row = mysqli_fetch_array($queryExec);

    if(mysqli_num_rows($queryExec) > 0){
        if($newPassword==$ConfirmPass){

            $updateQuery="UPDATE team_members SET password=' $newPassword' 
            WHERE  member_id=$userId";
                    $queryExec=mysqli_query($conn,$updateQuery);

            echo "<script>Swal.fire({
                title: 'Password Changed Successfully!',
                icon: 'success',
                confirmButtonColor: '#38a53e',
                confirmButtonText: 'OK'
              })</script>";

        }else{
            echo "<script>Swal.fire({
                icon: 'error',
                title: 'Try Again!',
                text: 'Password confirmation does not match...',
                confirmButtonColor: '#f27474',
                confirmButtonText: 'OK'
              })</script>";
        }

        }else{
            echo "<script>Swal.fire({
                icon: 'error',
                title: 'Try Again!',
                text: 'Wrong Old Password...',
                confirmButtonColor: '#f27474',
                confirmButtonText: 'OK'
              })</script>";
        }
    }


?>
</body>
</html>