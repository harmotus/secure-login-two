<?php
	session_start();
	if ( !isset($_SESSION['connected']) ) {
		exit(header('Location: index.html'));
	}
	$servername = 'localhost';
	$usernamesv = 'root';
	$passwordsv = '';
	$dbnamedbsv = 'slogin';
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbnamedbsv", $usernamesv, $passwordsv);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sth = $conn->prepare('SELECT email, pubkey FROM accounts WHERE id = ?');
		$sth->bindValue(1, $_SESSION['id'], PDO::PARAM_INT);
		$sth->execute();
		$row = $sth->fetch();
		$email = $row[0];
		$pubkey = $row[1];
		$conn = null;
	} catch(PDOException $e) {
		$conn = null;
		exit('<br> Alert Message ! <br><br>Error : ' . $e->getMessage());
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
	<title>Profile</title>
</head>
<body class="run">
	<nav class="nav">
		<div>
			<h1>Profile</h1>
			<a class="hsa" href="home.php">Home</a><a class="hse" href="logout.php">Logout</a>
		</div>
	</nav>
	<div class="con">
		<div class="cox">
			<table>
				<tr>
					<td class="tda">ID:</td>
					<td class="tde"><?php echo $_SESSION['id']; ?></td>
				</tr>
				<tr>
					<td class="tda">User:</td>
					<td class="tde"><?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?></td>
				</tr>
				<tr>
					<td class="tda">Email:</td>
					<td class="tde"><?php echo htmlspecialchars($email, ENT_QUOTES); ?></td>
				</tr>
				<tr>
					<td class="tda kva">Public<br>Key:</td>
					<td class="tde kbe">
						-----BEGIN PUBLIC KEY-----
						<div class="kpa" id="txtpkcode"><span class="kpb"><?php echo $pubkey; ?></span></div>
						<!--
						<div class="kpa" id="txtpkcode"><?php // echo '<span class="kpb">' . wordwrap($pubkey, 4, '</span><span class="kpb">', true) . '</span>'; ?></div>
						-->
						<!--
						<div class="kpa" id="txtpkcode">function wordwrap . javascript from the user</div>
						-->
						-----END PUBLIC KEY-----
					</td>
				</tr>
			</table>
		</div>
	</div>

	<!--

	<script src="js/wordwrap.js"></script>

	<script>
		document.getElementById("txtpkcode").innerHTML = wordwrap (
			str = '<?php // echo $pubkey; ?>',
			ope = '<span class="kpb">',
			int = '</span><span class="kpb">',
			clo = '</span>',
			brk = 4
		);
	</script>

	-->

</body>
</html>
