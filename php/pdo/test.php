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
		try {
			$conn = new PDO("mysql:host=$servername;dbname=$dbnamedbsv", $usernamesv, $passwordsv);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sth = $conn->prepare('SELECT pubkey FROM accounts WHERE username = ?');
			$sth->bindValue(1, $_SESSION['username'], PDO::PARAM_STR);
			$sth->execute();
			$row = $sth->fetch();
			$pubkey = $row[0];
			$conn = null;
			$puckey = "-----BEGIN PUBLIC KEY-----\r\n" . chunk_split($pubkey) . "-----END PUBLIC KEY-----";
			openssl_public_decrypt(base64_decode($hasha), $datanc, $puckey);
			$hashu = hash('sha256', $datanc);
			$hashc = $_SESSION['hashcode'];
		} catch(PDOException $e) {
			$conn = null;
			exit('<br> Alert Message ! <br><br>Error : ' . $e->getMessage());
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
