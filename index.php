<?php
session_start();
include 'db.php';

// AY HAG

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tornado Team</title>
	<link rel="stylesheet" href="css/styles.css">

	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Montserrat:wght@300&display=swap" rel="stylesheet">
 
    <!-- alert box libraries -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>



</head>
<body class="backgroundimage">

<nav class="navbar navbar-expand-lg navbar-light  navBar-color" >
<a class="navbar-brand navBar-color" href="#" style="height:71px !important;"><img class="logosize" src='images/horse.svg' style="height:51px;"><br><span class="logoText" style="margin-top:17px;">Tornado</span></a>
</nav>

<div class="LoginBigContainer">
<!-- <div>
	<h1 class="welcomeText">Welcome Back!</h1>
</div> -->

<?php

if(isset($_POST['submit'])){

    $userMail = strtolower(mysqli_real_escape_string($conn, $_POST['userMail']));
	$password = strtolower(mysqli_real_escape_string($conn, $_POST['Loginpass']));


    $ManagerLoginQuery = "SELECT * FROM managers WHERE email = '$userMail' AND password = '$password'";
    $ManagerCheck = mysqli_query($conn, $ManagerLoginQuery);
	$row = mysqli_fetch_array($ManagerCheck);

	// $MemberLoginQuery = "SELECT * FROM team_members WHERE email = '$userMail' AND password = '$password'";
	$MemberLoginQuery = "SELECT * FROM team_members WHERE email = '$userMail'";
    $MemberCheck = mysqli_query($conn, $MemberLoginQuery);
	$row2 = mysqli_fetch_array($MemberCheck);



    if(mysqli_num_rows($ManagerCheck) > 0){


        $_SESSION["username"] = $row['M_ID'];

		if(isset($_POST["rememberme"])) { //set cookie if checkbox is checked
			$_SESSION["rememberme"]="yes";
			$_SESSION["member_ID"]=$userMail;
			$_SESSION["member_Password"]=$row['password'];
			// setcookie ("member_ID",  $userMail, time()+ (86400));
			// setcookie ("member_Password", $row['password'], time()+ (86400));
		}else { //delete cookie if checkbox is not checked
			$_SESSION["rememberme"]="no";
			if(isset($_COOKIE['member_ID']) && isset($_COOKIE["member_Password"])) {
				$CookieID = $_COOKIE["member_ID"];
				$Cookiepassword = $_COOKIE["member_Password"];
				setcookie("member_ID", $CookieID, time() - 1);
				setcookie("member_Password", $Cookiepassword, time() - 1);
			}
		} 		

        echo '
				<script>
				window.location.href="ManagerHome.php";
				</script>
			  ';
		}   elseif(mysqli_num_rows($MemberCheck) > 0 || password_verify($password,$row2['password'])) {

			session_start();
			$_SESSION["username"] = $row2['member_id'];

			if(isset($_POST["rememberme"])) { //set cookie if checkbox is checked
				$_SESSION["rememberme"]="yes";
		    	$_SESSION["member_ID"]=$userMail;
			    $_SESSION["member_Password"]=$password;
			// setcookie ("member_ID",  $userMail, time()+ (86400));
			// setcookie ("member_Password", $row['password'], time()+ (86400));
			}else { //delete cookie if checkbox is not checked					
			    $_SESSION["rememberme"]="no";
				if(isset($_COOKIE['member_ID']) && isset($_COOKIE["member_Password"])) {
					$CookieID = $_COOKIE["member_ID"];
					$Cookiepassword = $_COOKIE["member_Password"];
					setcookie("member_ID", $CookieID, time() - 1);
					setcookie("member_Password", $Cookiepassword, time() - 1);
				}
			} 

			echo '
				<script>
				window.location.href="membersdash.php";
				</script>
			  ';

		} else{
			echo "<script>Swal.fire({
				icon: 'error',
				title: 'Try Again!',
				text: 'Wrong email or password...',
				confirmButtonColor: '#f27474',
				confirmButtonText: 'OK'
			  })</script>";
		}


}
?>

<h1 class="welcomeText">Welcome Back Team!</h1>

	<?php 
	if(isset($_COOKIE['member_ID']) && isset($_COOKIE["member_Password"])){
$pass=$_COOKIE["member_Password"];

$options   = 0;
// Storingthe cipher method 
$ciphering = "AES-128-CTR";

// Non-NULL Initialization Vector for decryption 
$decryption_iv = '1234567891011121';

// Storing the decryption key 
$decryption_key = "losangleslakers";

// Using openssl_decrypt() function to decrypt the data 
$decryption = openssl_decrypt($pass, $ciphering, $decryption_key, $options, $decryption_iv);

		echo '
		<div class="LoginContainer">
				<form action="'.$_SERVER["PHP_SELF"].'" method="post">
										<div class="loginSpacing">
											<div>
											<label for="userID" >Email</label>
											</div>
											<div>
											<input id="userID" name="userMail" required value="'.$_COOKIE['member_ID'].'"type="text">
											</div>
											</div>
										<div class="loginSpacing">
										<div>
											<label for="Loginpass" >Password</label>
											</div>
											<div>
											<input id="Loginpass" name="Loginpass" required value="'.$decryption.'"type="password" data-type="password">
										</div>
										</div>
										<div>
											<input id="rememberme" type="checkbox" name="rememberme" value="1" checked = "checked">
											<label for="rememberme" style="font-size:18px;font-size: 18px;"><span ></span> Keep me Signed in</label>
										</div>
										<div>
											<input type="submit" name="submit" class="SignIn-btn" value="Sign In">
										</div>

									</form>
		</div>
		';
	}else{
		echo '
		<div class="LoginContainer">
				<form action="'.$_SERVER["PHP_SELF"].'" method="post">
										<div class="loginSpacing">
											<div>
											<label for="userID" >Email</label>
											</div>
											<div>
											<input id="userID" name="userMail" required type="text">
											</div>
										</div>
										<div class="loginSpacing">
										<div>
											<label for="Loginpass" >Password</label>
											</div>
											<div>
											<input id="Loginpass" name="Loginpass" required type="password" data-type="password">
										</div>
										</div>
										<div class="loginSpacing" style="text-align:left">
											<input id="rememberme" type="checkbox" name="rememberme" value="1">
											<label for="rememberme"style="font-size:18px; font-weight 500px;"><span ></span> Keep me Signed in</label>
										</div>
										<div>
											<input type="submit" name="submit" class="SignIn-btn" value="Sign In">
										</div>

									</form>
		</div>
		';
	}
		?>
</div>
</body>
</html> 