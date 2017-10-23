<?php

require_once '../starter.php';

// Login
if (isset($_POST['action']) && $_POST['action'] == 'Login') {
	$email = isset($_POST['email']) ? $_POST['email'] : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';
	$sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
	$validatedEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
	if (($sanitizedEmail !== false) && ($validatedEmail !== false)) {
		$sql = 'SELECT password FROM cms_users WHERE email = :email';
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(':email' => $email));
		$hashedPassword = $stmt->fetchColumn();
		$verifiedPassword = password_verify($password, $hashedPassword);
		if ($verifiedPassword !== false) {
			$sql = 'SELECT user_id, access_level, username FROM cms_users WHERE email = :email';
			$stmt = $conn->prepare($sql);
			$stmt->execute(array(':email' => $email));
			$result = $stmt->fetch();
			if ($result) {
				$_SESSION['user_id'] = $result['user_id'];
				$_SESSION['access_level'] = $result['access_level'];
				$_SESSION['username'] = $result['username'];
			}
			$result = null;
			header('Refresh: 1; URL = ../round_table.php');
			die();
		}
	}
}

?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>COOK EAT WIN REPEAT</title>
    <link href="../../images/master/nobsc-favicon-us.png" rel="shortcut icon">
	<link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
	<link href="../../css/staff/login.css" rel="stylesheet">
</head>
<body>
	<header>
		<a id="centered_logo" href="http://nobullshitcooking.com">
			<img src="../../images/nobsc-logo-large-white.png">
		</a>
	</header>
	<main>
		<form method="post" action="">
			<h1>Staff Login</h1>
			<div class="field_spacer">
				<label for="email">Email</label>
				<input type="text" name="email" id="email" maxlength="100" autofocus>
			</div>
			<div class="field_spacer">
				<label for="password">Password</label>
				<input type="password" name="password" id="password" maxlength="20">
			</div>
			<div class="field_spacer">
				<input type="submit" name="action" id="sign_in_button" value="Login">
			</div>
		</form>
		<p><a href="cms_forgot_password.php">Forgot password?</a></p>
	</main>
	<footer>
	</footer>
</body>
</html>