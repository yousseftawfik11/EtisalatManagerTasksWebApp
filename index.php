<?php

include 'db.php';

// AY HAGA

if(isset($_POST['submit'])){

    $userMail = mysqli_real_escape_string($conn, $_POST['userMail']);
	$password = mysqli_real_escape_string($conn, $_POST['Loginpass']);

    $ManagerLoginQuery = "SELECT * FROM managers WHERE email = '$userMail' AND password = '$password'";
    $ManagerCheck = mysqli_query($conn, $ManagerLoginQuery);
	$row = mysqli_fetch_array($ManagerCheck);

	$MemberLoginQuery = "SELECT * FROM team_members WHERE email = '$userMail' AND password = '$password'";
    $MemberCheck = mysqli_query($conn, $MemberLoginQuery);
	$row2 = mysqli_fetch_array($MemberCheck);


    if(mysqli_num_rows($ManagerCheck) > 0){

		session_start();
        $_SESSION["username"] = $row['M_ID'];


        echo '
				<script>
				window.location.href="ManagerHome.php";
				</script>
			  ';
		}  elseif(mysqli_num_rows($MemberCheck) > 0) {

			session_start();
			$_SESSION["username"] = $row2['member_id'];


			echo '
				<script>
				window.location.href="MembersHome.php";
				</script>
			  ';

		} else{
			echo 'failed';
		}


}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>
	<link rel="stylesheet" href="css/styles.css">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>
		<div class="LoginContainer">
				<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
										<div>
											<div>
											<label for="userID" >Username</label>
											<input id="userID" name="userMail" type="text">
											</div>
										</div>
										<div >
											<label for="Loginpass" >Password</label>
											<input id="Loginpass" name="Loginpass" type="password" data-type="password">
										</div>
										<div>
											<input id="rememberme" type="checkbox" name="rememberme" value="1">
											<label for="rememberme"><span ></span> Keep me Signed in</label>
										</div>
										<div>
											<input type="submit" name="submit" class="SignIn-btn" value="Sign In">
										</div>

									</form>
		</div>

</body>
</html> 