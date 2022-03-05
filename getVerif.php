<?php
session_start();
include 'db.php';
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


    <title>Get Verification Code</title>
</head>
<body class="backgroundimage">

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

<div>
    <div id="cardsContainer" style="width: 280px; padding:24px;">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <div>
		<label for="userID" >Email</label>
	</div>
	<div style="margin-bottom: 25px;">
		<input id="userMail" name="userMail" required type="text" style="width: 100%;">
	</div> 
    <input type="submit" name="submit" class="SignIn-btn" value="Get Code">       
    </form>
    </div>
</div>


<?php

if(isset($_POST['submit'])){
    $email= mysqli_real_escape_string($conn, $_POST['userMail']);
    $checkEmail= "SELECT * FROM team_members WHERE email='$email'";
    $execute= mysqli_query($conn,$checkEmail);

    if(mysqli_num_rows($execute)>0){
        $row = mysqli_fetch_row($execute);
        $VerificationCode = mt_rand(1111, 9999);
        $ver = $VerificationCode;
        $_SESSION["member_email"]=$email;
        $_SESSION["verificationCode"]=$ver;

        SendVer($email, $ver);
        echo '<script>
        window.location.href="ConfirmCode.php";
    </script>
';
    }else{
        echo "<script>Swal.fire({
            icon: 'error',
            title: 'Try Again!',
            text: 'This email does not exist...',
            confirmButtonColor: '#f27474',
            confirmButtonText: 'OK'
          })</script>";
    }
}


?>
    
</body>
</html>