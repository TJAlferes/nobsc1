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
	
	$input = filter_var(trim($_POST['search_insert_input']));
	$inputAll = filter_var(trim($_POST['search_insert_input'])) . "*";
	
	$hint = "";
	
	if (strlen($input) > 0) {
		$sql = 'SELECT ingredient_id, ingredient_name FROM nobsc_ingredients
				WHERE MATCH (ingredient_name) AGAINST (:input IN BOOLEAN MODE) LIMIT 5';  // add equipment and recipes, and eventually nutrients, anatomy, and exercises (remember, exercises are like recipes)
		$stmt = $conn->prepare($sql);
		$stmt->execute([':input' => $inputAll]);
		
		while (($row = $stmt->fetch()) !== false) {
			
			// use strtolower() ?
			
			// "highlight" the difference between their search term and the remaining suggestion
			$itemName = $row['ingredient_name'];
			$position = mb_strpos($itemName, $input, 0, "UTF-8");  // something is wrong with this..?
			$inputLength = mb_strlen($input, "UTF-8");
			$itemLength = mb_strlen($itemName, "UTF-8");
			$clip = ((int)$position + (int)$inputLength);
			$beforeInput = "";
			$afterInput = "";
			if ((int)$position > 0) {
				$beforeInput .= mb_substr($itemName, -$position, $inputLength);       // for this you want only everything before the position, "Standard Slicing ", so "Standard Slicing Cucumber" pos should be 17
			}
			$afterInput .= mb_substr($itemName, 0, (int)$position);               // this should be right actually
			
			// keep messing around with subtr and maybe subtr_replace
			
			// APPLY DEBOUNCING ON FRONT END
			
			//$afterInput = substr($itemName, $inputLength);      // this was just "ndard Slicing Cucumber" which resulted in "cucndard Slicing Cucumber", instead you want "umber"
			
			//$markedNamePre = substr_replace($itemName, $markOpen, $position, 0);
			//$markedNameApp = substr_replace($markedNamePre, $markClose, ($position + $length), 0);
			
			//substr($blah, 0, 30); // do last
			
			/*
			$hint .= '<span onclick="liveSearchWidthExtend(this)" class="search_suggestion_row"><a href="https://www.nobullshitcooking.com/view_ingredient.php?ingredient_id=' .
			$row['ingredient_id'] . '">' . (int)$position . '</a></span>';
			
			if ((int)$position == 0) {
				$hint .= '<span onclick="liveSearchWidthExtend(this)" class="search_suggestion_row"><a href="https://www.nobullshitcooking.com/view_ingredient.php?ingredient_id=' .
				$row['ingredient_id'] . '"><mark>' . $input . '</mark>' . $afterInput . '</a></span>';
			} else {
				$hint .= '<span onclick="liveSearchWidthExtend(this)" class="search_suggestion_row"><a href="https://www.nobullshitcooking.com/view_ingredient.php?ingredient_id=' .
				$row['ingredient_id'] . '">' . $beforeInput . '<mark>' . $input . '</mark>' . $afterInput . '</a></span>';
			}
			*/
			
			$hint .= '<span onclick="liveSearchWidthExtend(this)" class="search_suggestion_row"><a href="https://www.nobullshitcooking.com/view_ingredient.php?ingredient_id=' .
			$row['ingredient_id'] . '">' . $beforeInput . '<mark>' . $input . '</mark>' . $afterInput . '</a></span>';
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