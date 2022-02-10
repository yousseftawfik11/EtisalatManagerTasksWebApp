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
<body class="backgroundimage">

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

		session_start();
        $_SESSION["username"] = $row['M_ID'];

		if(isset($_POST["rememberme"])) { //set cookie if checkbox is checked
			setcookie ("member_ID",  $userMail, time()+ (86400));
			setcookie ("member_Password", $row['password'], time()+ (86400));
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

			if(password_verify($password, $row2['password'])) {


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
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#7cad3e " fill-opacity="1" d="M0,224L26.7,218.7C53.3,213,107,203,160,176C213.3,149,267,107,320,117.3C373.3,128,427,192,480,202.7C533.3,213,587,171,640,170.7C693.3,171,747,213,800,234.7C853.3,256,907,256,960,240C1013.3,224,1067,192,1120,181.3C1173.3,171,1227,181,1280,165.3C1333.3,149,1387,107,1413,85.3L1440,64L1440,320L1413.3,320C1386.7,320,1333,320,1280,320C1226.7,320,1173,320,1120,320C1066.7,320,1013,320,960,320C906.7,320,853,320,800,320C746.7,320,693,320,640,320C586.7,320,533,320,480,320C426.7,320,373,320,320,320C266.7,320,213,320,160,320C106.7,320,53,320,27,320L0,320Z"></path></svg></html> 