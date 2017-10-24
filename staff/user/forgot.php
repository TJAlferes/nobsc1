<?php

require_once '../starter.php';

// Send new password
if (isset($_POST['action']) && $_POST['action'] == 'Send') {
	$email = isset($_POST['email']) ? $_POST['email'] : '';
	if (!empty($email)) {
		$sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
		$validatedEmail = filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL);
		if (($sanitizedEmail !== false) && ($validatedEmail !== false)) {
			$sql = 'SELECT user_id FROM cms_users WHERE email = :email';
			$stmt = $conn->prepare($sql);
			$stmt->execute([':email' => $email]);
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($result) {
				$newPassword = '';
				for ($i = 0; $i < 8; $i++) {
					$newPassword .= chr(mt_rand(33, 126));
				}
				$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
				$sql = 'UPDATE cms_users SET password = :password WHERE email = :email';
				$stmt = $conn->prepare($sql);
				$stmt->execute(array(':password' => $hashedPassword,
									 ':email'    => $email));
				$to = $email;
				$subject = "NOBSC staff account password reset";
				$message = "Your new password: $newPassword";
				$headers = "From: <admin@nobullshitcooking.com>\r\n";
				$headers .= "Reply-To: admin@nobullshitcooking\r\n";
				$headers .= "Content-type: text/html\r\n";
				mail($to, $subject, $message, $headers);
			}
			$result = null;
		}
	}
	header('Refresh: 1; URL = ../blog.php');
	die();
}

?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>COOK EAT WIN REPEAT</title>
    <link href="../../images/master/nobsc-favicon-us.png" rel="shortcut icon">
	<link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
	<link href="../../css/login.css" rel="stylesheet">
</head>
<body>
	<header>
		<a id="centered_logo" href="http://nobullshitcooking.com">
			<img src="../../images/master/nobsc-logo-large-white.png">
		</a>
	</header>
	<main>
		<form method="post" action="">
			<h1>Forgot Password</h1>
			<div class="field_spacer">
				<label for="email">Email Address</label>
				<input type="text" id="email" name="email" maxlength="100" autofocus>
			</div>
			<div class="field_spacer">
				<input type="submit" name="action" id="sign_in_button" value="Send">
			</div>
		</form>
	</main>
	<footer>
	</footer>
</body>
</html>