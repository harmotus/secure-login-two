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
		$conn = new mysqli($servername, $usernamesv, $passwordsv, $dbnamedbsv);
		if ( $conn->connect_errno ) {
			exit('<br> Alert Message ! <br><br> Failed to connect to MySQL (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}
		if ( $stmt = $conn->prepare('SELECT pubkey FROM accounts WHERE username = ?') ) {
			$stmt->bind_param('s', $_SESSION['username']);
			$stmt->execute();
			$stmt->bind_result($pubkey);
			$stmt->fetch();
			$stmt->close();
			$conn->close();
			$puckey = "-----BEGIN PUBLIC KEY-----\r\n" . chunk_split($pubkey) . "-----END PUBLIC KEY-----";
			openssl_public_decrypt(base64_decode($hasha), $datanc, $puckey);
			$hashu = hash('sha256', $datanc);
			$hashc = $_SESSION['hashcode'];
		} else {
			$conn->close();
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
