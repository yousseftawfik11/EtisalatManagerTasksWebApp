<?php
session_start();
$userMail=$_SESSION["member_email"];

if(!isset($_SESSION["member_email"])){
    echo '
    <script>
    window.location.href="index.php";
    </script>
  ';
  }
  include 'db.php';
  include 'mailer.php';
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
    <a class="nav-item nav-link navBar-color" href="index.php"><img src="images/back.svg"  class="logoutAni backIcon"></a>
</div>
  </div>
</nav>

<div class="CreateTask AddUserPadding">
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="FormCenter"  >

    <h1 id="PageTitle">Change Password</h1>
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
        <input type="submit" name="changePass" value="Change Password" class="TaskSubmit-btn" style="margin-top: 20px; margin-bottom:0px;" >
    </div>

    </form>
</div>

<?php

if(isset($_POST["changePass"])){

    $newPassword=strtolower( mysqli_real_escape_string($conn,$_POST['newPass']));
    $ConfirmPass=strtolower( mysqli_real_escape_string($conn,$_POST['ConfirmPass']));
    $hashPass=password_hash($newPassword,PASSWORD_DEFAULT);

    if($newPassword==$ConfirmPass){

        $updateQuery="UPDATE team_members SET password='$hashPass' 
        WHERE  email='$userMail'";
                $queryExec=mysqli_query($conn,$updateQuery);
                unset($_SESSION['member_email']);
                echo '<script>
                window.location.href="index.php";
            </script>
        ';

    }else{
        echo "<script>Swal.fire({
            icon: 'error',
            title: 'Try Again!',
            text: 'Password confirmation does not match...',
            confirmButtonColor: '#f27474',
            confirmButtonText: 'OK'
          })</script>";
    }
}


?>

</body>
</html>



