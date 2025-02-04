<?php
	session_start();
	if ( isset($_SESSION['connected']) ) {
		exit(header('Location: home.php'));
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Harmotus">
	<meta name="robots" content="index, nofollow">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="images/favicon.svg">
	<title>Login</title>
</head>
<body>
	<div class="cod"><h1>Access</h1></div>
	<div class="box">
		<h1>Login</h1>
		<form action="code.php" method="post">
			<div class="bax">
				<label for="username" title="user-icon">
					<img class="ico" src="images/user.svg" alt="user-icon">
				</label>
				<input id="username" type="text" name="username" placeholder="Username" minlength="1" maxlength="50" required>
			</div>
			<input type="submit" value="Submit">
		</form>
	</div>
</body>
</html>
