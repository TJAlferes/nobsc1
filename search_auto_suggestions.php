<?php

require '../nobsc_main_set.php';

$dsn = 'mysql:host=' . DB_SN . ';dbname=' . DB_NA . ';charset=utf8';
$opt = [
	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES   => false
];
$conn = new PDO($dsn, DB_UN, DB_PW, $opt);



// ////////////////////////////// OVERVIEW //////////////////////////////
// This page (search_auto_suggestions.php) takes search terms submitted by a site user
// and returns more or less matching suggestions to aid them in their search.



if (isset($_POST) && !empty($_POST['search_insert_input'])) {
	
	$input = filter_var(trim($_POST['search_insert_input'])) . "*";
	
	$hint = "";
	
	if (strlen($input) > 0) {
		$sql = 'SELECT ingredient_id, ingredient_name FROM nobsc_ingredients
				WHERE MATCH (ingredient_name) AGAINST (:input IN BOOLEAN MODE) LIMIT 5';
		$stmt = $conn->prepare($sql);
		$stmt->execute([':input' => $input]);
		
		while (($row = $stmt->fetch()) !== false) {
			$hint .= '<span class="search_suggestion_row"><a href="view_ingredient.php?ingredient_id=' .
			$row['ingredient_id'] . '">' . substr($row['ingredient_name'], 0, 30) . '</a></span>';
		}
	}
	
	if ($hint == "") {
	  $response = "";
	} else {
	  $response = $hint;
	}
	
	echo $response;
	
}



?>