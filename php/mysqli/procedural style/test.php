<?php
	session_start();
	if ( !isset($_POST['usercode'], $_SESSION['hashcode'], $_SESSION['timeus']) ) {
		exit(header('Location: login.php'));
	}
	if ( time() - $_SESSION['timeus'] > 240 ) {
		exit('<br> Alert Message ! <br><br> The access code has expired ( 240 seconds )');
	} else {
		$hashs = strval($_POST['usercode']);
		$hasha = preg_replace('/[^a-zA-Z0-9\+\/\=]/', '', $hashs);
		$servername = 'localhost';
		$usernamesv = 'root';
		$passwordsv = '';
		$dbnamedbsv = 'slogin';
		$conn = mysqli_connect($servername, $usernamesv, $passwordsv, $dbnamedbsv);
		if ( mysqli_connect_errno() ) {
			exit('<br> Alert Message ! <br><br> Failed to connect to MySQL (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
		}
		if ( $stmt = mysqli_prepare($conn, 'SELECT pubkey FROM accounts WHERE username = ?') ) {
			mysqli_stmt_bind_param($stmt, 's', $_SESSION['username']);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $pubkey);
			mysqli_stmt_fetch($stmt);
			mysqli_stmt_close($stmt);
			mysqli_close($conn);
			$puckey = "-----BEGIN PUBLIC KEY-----\r\n" . chunk_split($pubkey) . "-----END PUBLIC KEY-----";
			openssl_public_decrypt(base64_decode($hasha), $datanc, $puckey);
			$hashu = hash('sha256', $datanc);
			$hashc = $_SESSION['hashcode'];
		} else {
			mysqli_close($conn);
			exit(header('Location: home.php'));
		}
	}
	if ( $hashu === $hashc ) {
		session_regenerate_id();
		$_SESSION['connected'] = TRUE;
		$_SESSION['username'] = $_SESSION['username'];
		$_SESSION['id'] = $_SESSION['id'];
		header('Location: home.php');
	} else {
		echo '<br> Alert Message ! <br><br> The code is not correct ( private keys : <a href="keys/keys.html">keys/keys.html</a>)';
	}
?>
