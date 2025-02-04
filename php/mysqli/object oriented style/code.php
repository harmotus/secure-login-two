<?php
	session_start();
	if ( !isset($_POST['username']) ) {
		exit(header('Location: login.php'));
	}
	$users = strval($_POST['username']);
	$userx = preg_replace('/[^a-zA-Z0-9]/', '', $users);
	$userc = strtolower($userx);
	$servername = 'localhost';
	$usernamesv = 'root';
	$passwordsv = '';
	$dbnamedbsv = 'slogin';
	$conn = new mysqli($servername, $usernamesv, $passwordsv, $dbnamedbsv);
	if ( $conn->connect_errno ) {
		exit('<br> Alert Message ! <br><br> Failed to connect to MySQL (' . $conn->connect_errno . ') ' . $conn->connect_error);
	}
	if ( $stmt = $conn->prepare('SELECT id FROM accounts WHERE username = ?') ) {
		$stmt->bind_param('s', $userc);
		$stmt->execute();
		$stmt->store_result();
		if ( $stmt->num_rows > 0 ) {
			$stmt->bind_result($id);
			$stmt->fetch();
			$stmt->close();
			$conn->close();
			// RANDOM CODE
			$randse = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randnc = '';
			for ( $i = 1; $i <= 108; $i++ ) { $randnc = $randnc . $randse[mt_rand(0,61)]; };
			$randnc = strval( str_shuffle($randnc) );
			$hashrc = hash('sha256', $randnc);
			// TIMEOUT DATA
			$timeux = time();
			// SESSION DATA
			$_SESSION['username'] = $userc;
			$_SESSION['hashcode'] = $hashrc;
			$_SESSION['timeus'] = $timeux;
			$_SESSION['id'] = $id;
		} else {
			$stmt->close();
			$conn->close();
			exit('<br> Alert Message ! <br><br> The username is not correct ( user : alex or anna )');
		}
	} else {
		$conn->close();
		exit(header('Location: login.php'));
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
	<title>Code</title>
</head>
<body>
	<div class="cod"><h1>Access Code</h1></div>
	<div class="alx">
		<div class="ima" id="qrcodejs"></div>
		<div class="box vox">
			<h1>Code</h1>
			<form>
				<div class="nox"></div>
				<label id="label-camera" for="inputFile" class="button">
					Camera
				</label>
				<input id="inputFile" type="file" onchange="onFileSelected(event)">
				<div class="nox nov"></div>
				<label id="label-archive" for="archive" class="button">
					Archive
				</label>
				<input id="archive" accept="image/*" type="file" onchange="onFileSelected(event)">
			</form>
		</div>
	</div>
	<form class="form-code" action="test.php" method="post">
		<textarea class="form-textarea" id="qrResult" name="usercode" placeholder="Enter the encrypted random code ( Base64 encoded )" rows="6" cols="33" autocomplete="off" spellcheck="false" autocapitalize="none" minlength="128" maxlength="256" required></textarea>
		<input class="form-input" id="form-submit" type="submit" value="Submit">
	</form>
	<div class="alc" id="txtcodec" onclick="myDisplay();">Display <span class="nux">&nbsp;the&nbsp;</span> <span class="nux">random&nbsp;</span> code<span class="nex">&nbsp;in plain text</span></div>
	<div class="aln" id="txtcoden"><span class="kpb"><?php echo $randnc; ?></span></div>

	<!--
	<div class="aln" id="txtcoden"><?php // echo '<span class="kpb">' . wordwrap($randnc, 1, '</span><span class="kpb">', true) . '</span>'; ?></div>
	-->
	<!--
	<div class="aln" id="txtcoden">function wordwrap . javascript from the user</div>
	-->

	<script src="qrcode/qrcode.min.js"></script>

	<script>
		var QRCodeDiv = document.getElementById("qrcodejs");
		var QRCodeNew = new QRCode(QRCodeDiv, {
			text: '<?php echo $randnc; ?>',
			width: 272,
			height: 272,
			colorDark : "#000000",
			colorLight : "#ffffff",
			correctLevel : QRCode.CorrectLevel.L
		});
		document.getElementById("qrcodejs").title="qr-code";
	</script>

	<!--

	<script src="js/wordwrap.js"></script>

	<script>
		document.getElementById("txtcoden").innerHTML = wordwrap (
			str = '<?php // echo $randnc; ?>',
			ope = '<span class="kpb">',
			int = '</span><span class="kpb">',
			clo = '</span>',
			brk = 1
		);
	</script>

	-->

	<img style="display:none" id="imagex" src="src" alt="img">

	<script src="scanner/qr-scanner.legacy.min.js"></script>

	<script>
		function onFileSelected(event) {
			var selectedFile = event.target.files[0];
			var reader = new FileReader();
			var imgtag = document.getElementById("imagex");
			imgtag.title = selectedFile.name;
			reader.onload = function(event) {
				imgtag.src = event.target.result;
			};
			reader.readAsDataURL(selectedFile);
			setTimeout(function(){myChange();}, 600);
		};
	</script>

	<script>
		function myChange() {
			QrScanner.scanImage(imagex)
			.then(result => document.getElementById("qrResult").innerHTML = result)
			.catch(error => document.getElementById("qrResult").innerHTML = (error || 'No QR code found'));
		};
	</script>

	<script>
		function myDisplay() {
			document.getElementById("txtcodec").style.display="none";
			document.getElementById("txtcoden").style.display="flex";
		};
	</script>

	<script>
		setTimeout(function(){document.write('<br> Alert Message ! <br><br> The access code has expired ( 240 seconds )');document.close();}, 240000);
	</script>

</body>
</html>
