<?php



// ////////////////////////////// OVERVIEW //////////////////////////////
// This page (user/activate.php) takes an activation key sent by a link clicked on in
// the user's email account (the same email account they registered with). It then updates
// their NOBSC account from "inactive" to "active".



//require_once '../starter.php';

//include '../header.php';

?>
<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>COOK EAT WIN REPEAT</title>
	<link href="../images/master/nobsc-favicon-us.png" rel="shortcut icon">
	<link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
	<link href="../css/user/sign_in.css" rel="stylesheet"> <!-- change to activate.css -->
</head>
<body>
	<header>
		<a id="centered_logo" href="https://nobullshitcooking.com">
			<img src="../images/master/nobsc-logo-large-white.png">
		</a>
	</header>
	<main>
	<?php
	if (isset($_GET['x'], $_GET['y']) && filter_var($_GET['x'], FILTER_VALIDATE_EMAIL) && (strlen($_GET['y']) == 32)) {
		$sql = 'UPDATE nobsc_users SET active = NULL WHERE (email = :x) AND (active = :y) LIMIT 1';
		$stmt = $conn->prepare($sql);
		$stmt->execute([(':x' => $_GET['x'], ':y' => $_GET['y']]);
		if ($stmt->rowCount() == 1) {
			echo '<h3>Your account is active. You may now <a href="https://nobullshitcooking.com/user/sign_in.php">sign in</a>.</h3>';
		} else {
			echo '<p class="error">Your account could not be activated. Please recheck the link or contact the administrator.</p>';
		}
	} else {
		ob_end_clean();
		header("Location: https://nobullshitcooking.com");
		exit();
	}
	?>
	</main>
	<footer>
		<ul>
			<li><a class="size_mini" href="https://www.nobullshitcooking.com">Terms of Use</a></li>
			<li><a class="size_mini" href="https://www.nobullshitcooking.com">Privacy Policy</a></li>
			<li><a class="size_mini" href="https://www.nobullshitcooking.com">Help</a></li>
		</ul>
		<p>Copyright 2015-2018 NoBullshitCooking. All Rights Reserved.</p>
	</footer>
</body>
</html>