<?php
session_start();

$password=$_SESSION["member_Password"];

// Storingthe cipher method 
$ciphering = "AES-128-CTR";

// Using OpenSSl Encryption method 
$iv_length = openssl_cipher_iv_length($ciphering);
$options   = 0;

// Non-NULL Initialization Vector for encryption 
$encryption_iv = '1234567891011121';

// Storing the encryption key 
$encryption_key = "losangleslakers";

// Using openssl_encrypt() function to encrypt the data 
$encryption = openssl_encrypt($password, $ciphering, $encryption_key, $options, $encryption_iv);




setcookie ("member_ID",$_SESSION["member_ID"], time()+ (86400));
setcookie ("member_Password",$encryption, time()+ (86400));
unset($_SESSION["member_ID"]);
unset($_SESSION["member_Password"]);
  
  
  if(!isset($_SESSION["username"])||$_SESSION["username"]==5000){
      echo '
      <script>
      window.location.href="index.php";
      </script>
    ';
  }
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
 

    <title>Members Dashboard</title>
</head>
<body  class="backgroundimage">

<nav class="navbar navbar-expand-lg navbar-light  navBar-color" >
<a class="navbar-brand navBar-color" href="#"><img class="logosize" src='images/horse.svg'><br><span class="logoText">Tornado</span></a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav  ml-auto">
<a class="nav-item nav-link navBar-color" href="logout.php">Log Out <img src="images/logout.svg"  class="logoutAni"></a>
<a class="nav-item nav-link navBar-color" href="changePasswordMem.php">Change Password </a>
</div>
  </div>
</nav>
<div>
    <div id="cardsContainer">
        <div class="card1">
            <a href="memberOpen.php">
                <img src="images/open.svg">
                <div class="cardsLabel">
                    Open Tasks
                </div>
                </a>
        </div>
        <div class="card2">
        <a href="membersown.php">

        <img src="images/owner.svg">
        <div class="cardsLabel">
                     Tasks You Own
                </div>
</a>
        </div>

    </div>


</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


</body>
</html>