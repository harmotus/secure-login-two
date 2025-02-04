<?php
	session_start();
	if ( !isset($_SESSION['connected']) ) {
		exit(header('Location: index.html'));
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Harmotus">
	<meta name="robots" content="noindex, nofollow">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="images/favicon.svg">
	<title>Home</title>
</head>
<body class="run">
	<nav class="nav">
		<div>
			<h1>Home</h1>
			<a class="hsa" href="profile.php">Profile</a><a class="hse" href="logout.php">Logout</a>
		</div>
	</nav>
	<div class="con">
		<div class="cox">
			<p class="hia">Hi,&nbsp; <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?> !</p>
		</div>
	</div>
</body>
</html>
