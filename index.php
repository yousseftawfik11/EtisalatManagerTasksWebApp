<?php

include 'db.php';

// AY HAG

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>
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
<body class="backgroundimage" style="background-color: #282828;">

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

	$MemberLoginQuery = "SELECT * FROM team_members WHERE email = '$userMail' AND password = '$password'";
    $MemberCheck = mysqli_query($conn, $MemberLoginQuery);
	$row2 = mysqli_fetch_array($MemberCheck);


    if(mysqli_num_rows($ManagerCheck) > 0){

		session_start();
        $_SESSION["username"] = $row['M_ID'];

		if(isset($_POST["rememberme"])) { //set cookie if checkbox is checked
			setcookie ("member_ID",  $userMail, time()+ (86400));
			setcookie ("member_Password", $password, time()+ (86400));
		}else { //delete cookie if checkbox is not checked
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
		}  elseif(mysqli_num_rows($MemberCheck) > 0) {

			session_start();
			$_SESSION["username"] = $row2['member_id'];

			if(isset($_POST["rememberme"])) { //set cookie if checkbox is checked
				setcookie ("member_ID",  $userMail, time()+ (86400));
				setcookie ("member_Password", $password, time()+ (86400));
			}else { //delete cookie if checkbox is not checked
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
											<input id="Loginpass" name="Loginpass" required value="'.$_COOKIE["member_Password"].'"type="password" data-type="password">
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
<div id="footer">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#63811F" fill-opacity="1" d="M0,64L34.3,64C68.6,64,137,64,206,74.7C274.3,85,343,107,411,138.7C480,171,549,213,617,197.3C685.7,181,754,107,823,101.3C891.4,96,960,160,1029,160C1097.1,160,1166,96,1234,74.7C1302.9,53,1371,75,1406,85.3L1440,96L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path></svg>
</div>
</body>
</html> 