<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require '../../nobsc_main_set.php';

$dsn = 'mysql:host=' . DB_SN . ';dbname=' . DB_NA . ';charset=utf8';
$opt = [
	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES   => false
];
$conn = new PDO($dsn, DB_UN, DB_PW, $opt);

// process user input                 *** redo/finish validation/feedback/foolproofing ***
if (isset($_POST) &&
	!empty($_POST['select_amounts']) && !empty($_POST['select_equipment']) &&
	!empty($_POST['manual_amounts']) && !empty($_POST['select_units']) && !empty($_POST['select_ingredients']) &&
	!empty($_POST['manual_steps']) &&
	!empty($_POST['recipe_type_id']) && !empty($_POST['cuisine_id']) && !empty($_POST['recipe_title']) && !empty($_POST['recipe_description']) &&
	!empty($_FILES['submitted_image']) &&
	!empty($_FILES['submitted_equipment_image']) &&
	!empty($_FILES['submitted_ingredients_image']) &&
	!empty($_FILES['submitted_cooking_image'])) {
	
	
	
	// 1. setup
	$feedback = "";
	
	$temporaryNameOne = $_FILES['submitted_image']['tmp_name'];
	$temporaryNameTwo = $_FILES['submitted_equipment_image']['tmp_name'];
	$temporaryNameThree = $_FILES['submitted_ingredients_image']['tmp_name'];
	$temporaryNameFour = $_FILES['submitted_cooking_image']['tmp_name'];
	
	$imageNameOne = $_FILES['submitted_image']['name'];
	$imageNameTwo = $_FILES['submitted_equipment_image']['name'];
	$imageNameThree = $_FILES['submitted_ingredients_image']['name'];
	$imageNameFour = $_FILES['submitted_cooking_image']['name'];
	
	$imageDirectory = '../images/recipes/';
	
	$imagePath = $imageDirectory . $imageNameOne;
	
	
	
	// 2. check if the files use an allowed image type
	$allowedImageTypes = array(IMAGETYPE_JPEG);
	
	$imageCheckOne = getimagesize($temporaryNameOne);
	if (!in_array($imageCheckOne[2], $allowedImageTypes)) { exec('submitted_image -bi ' . $temporaryNameOne, $imageCheckOne); }
	$imageCheckTwo = getimagesize($temporaryNameTwo);
	if (!in_array($imageCheckTwo[2], $allowedImageTypes)) { exec('submitted_equipment_image -bi ' . $temporaryNameTwo, $imageCheckTwo); }
	$imageCheckThree = getimagesize($temporaryNameThree);
	if (!in_array($imageCheckThree[2], $allowedImageTypes)) { exec('submitted_ingredients_image -bi ' . $temporaryNameThree, $imageCheckThree); }
	$imageCheckFour = getimagesize($temporaryNameFour);
	if (!in_array($imageCheckFour[2], $allowedImageTypes)) { exec('submitted_cooking_image -bi ' . $temporaryNameFour, $imageCheckFour); }
	
	
	
	// 3. check dimensions of images
	$imageWidthOne = $imageCheckOne[0];
	$imageHeightOne = $imageCheckOne[1];
	if (($imageWidthOne != "480") && ($imageHeightOne != "320")) {
		$feedback .= '<div class="image_feedback">Image dimensions must be 480 pixels wide and 320 pixels high.</div>';
	}
	$imageWidthTwo = $imageCheckTwo[0];
	$imageHeightTwo = $imageCheckTwo[1];
	if (($imageWidthTwo != "480") && ($imageHeightTwo != "320")) {
		$feedback .= '<div class="image_feedback">Equipment image dimensions must be 480 pixels wide and 320 pixels high.</div>';
	}
	$imageWidthThree = $imageCheckThree[0];
	$imageHeightThree = $imageCheckThree[1];
	if (($imageWidthThree != "480") && ($imageHeightThree != "320")) {
		$feedback .= '<div class="image_feedback">Ingredient image dimensions must be 480 pixels wide and 320 pixels high.</div>';
	}
	$imageWidthFour = $imageCheckFour[0];
	$imageHeightFour = $imageCheckFour[1];
	if (($imageWidthFour != "480") && ($imageHeightFour != "320")) {
		$feedback .= '<div class="image_feedback">Cooking image dimensions must be 480 pixels wide and 320 pixels high.</div>';
	}
	
	
	
	// 4. check file sizes
	$maxFileSize = 1000000;  // 1MB
	if (filesize($temporaryNameOne) > $maxFileSize) { $feedback .= '<div class="image_feedback">Image file size is too large.</div>'; }
	if (filesize($temporaryNameTwo) > $maxFileSize) { $feedback .= '<div class="image_feedback">Equipment image file size is too large.</div>'; }
	if (filesize($temporaryNameThree) > $maxFileSize) { $feedback .= '<div class="image_feedback">Ingredient image file size is too large.</div>'; }
	if (filesize($temporaryNameFour) > $maxFileSize) { $feedback .= '<div class="image_feedback">Cooking image file size is too large.</div>'; }
	
	
	
	// 5. check if the files already exist
	$targetDirectory = '../images/recipes/';
	$targetFileOne = $targetDirectory . basename($_FILES['submitted_image']['name']);
	if (file_exists($targetFileOne)) { $feedback .= '<div class="image_feedback">Image file already exists.</div>'; }
	$targetFileTwo = $targetDirectory . basename($_FILES['submitted_equipment_image']['name']);
	if (file_exists($targetFileTwo)) { $feedback .= '<div class="image_feedback">Equipment image file already exists.</div>'; }
	$targetFileThree = $targetDirectory . basename($_FILES['submitted_ingredients_image']['name']);
	if (file_exists($targetFileThree)) { $feedback .= '<div class="image_feedback">Ingredient image file already exists.</div>'; }
	$targetFileFour = $targetDirectory . basename($_FILES['submitted_cooking_image']['name']);
	if (file_exists($targetFileFour)) { $feedback .= '<div class="image_feedback">Cooking image file already exists.</div>'; }
	
	
	
	// 6. store the 4 image files in the images/recipes directory               *key step*
	if (move_uploaded_file($temporaryNameOne, $targetFileOne)) {
		chmod($targetFileOne, 0644);
		$feedback .= '<div class="image_feedback">Image uploaded!</div>';
	} else {
		$feedback .= '<div class="image_feedback">There was a problem storing your image. Try again?</div>';
	}
	if (move_uploaded_file($temporaryNameTwo, $targetFileTwo)) {
		chmod($targetFileTwo, 0644);
		$feedback .= '<div class="image_feedback">Equipment image uploaded!</div>';
	} else {
		$feedback .= '<div class="image_feedback">There was a problem storing your equipment image. Try again?</div>';
	}
	if (move_uploaded_file($temporaryNameThree, $targetFileThree)) {
		chmod($targetFileThree, 0644);
		$feedback .= '<div class="image_feedback">Ingredient image uploaded!</div>';
	} else {
		$feedback .= '<div class="image_feedback">There was a problem storing ingredient your image. Try again?</div>';
	}
	if (move_uploaded_file($temporaryNameFour, $targetFileFour)) {
		chmod($targetFileFour, 0644);
		$feedback .= '<div class="image_feedback">Cooking image uploaded!</div>';
	} else {
		$feedback .= '<div class="image_feedback">There was a problem storing your cooking image. Try again?</div>';
	}
	
	
	
	// 7. make a copy of the recipe_image (submitted_image) file, resized and name appended with a "-t", store in the images/recipes/thumbnails directory
	$thumbDirectory = '../images/recipes/thumbnails/';
	$thumbName = substr_replace($imageNameOne, '-t.jpg', -4);
	$thumbPath = $thumbDirectory . $thumbName;
	$thumbWidth = '120';
	$thumbHeight = '80';
	$thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);
	$image = imagecreatefromjpeg($imagePath);
	imagecopyresampled($thumb, $image, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $imageWidthOne, $imageHeightOne);
	imagejpeg($thumb, $thumbPath, 100);
	imagedestroy($thumb);
	
	
	
	
	
	// ...
	
	
	
	
	
	// 8. finally, make database insertions
	
	// user input
	$recipeTypeID = $_POST['recipe_type_id'];
	$cuisineID = $_POST['cuisine_id'];
	$recipeTitle = $_POST['recipe_title'];                            // sanitize/validate!
	$recipeDescription = $_POST['recipe_description'];                // sanitize/validate!
	
	$recipeImage = substr($imageNameOne, 0, -4);
	$recipeEquipmentImage = substr($imageNameTwo, 0, -4);
	$recipeIngredientsImage = substr($imageNameThree, 0, -4);
	$recipeCookingImage = substr($imageNameFour, 0, -4);
	
	$selectAmounts = explode(",", $_POST['select_amounts']);
	$equipmentIDs = explode(",", $_POST['select_equipment']);
	
	$manualAmounts = explode(",", $_POST['manual_amounts']);  // sanitize/validate!
	$measurements = explode(",", $_POST['select_units']);
	$ingredientIDs = explode(",", $_POST['select_ingredients']);
	
	if (!empty($_POST['select_subrecipes'])) { $subrecipeIDs = explode(",", $_POST['select_subrecipes']); }
	
	$rawSteps = $_POST['manual_steps'];
	$cleanSteps = substr($rawSteps, 0, -5);
	$stepTexts = explode("@#$%^,", $cleanSteps);        // sanitize/validate!
	
	
	
	
	// nobsc_recipes insertions
	$sql = 'INSERT INTO nobsc_recipes (recipe_type_id, cuisine_id, recipe_title, recipe_description, recipe_image, recipe_equipment_image, recipe_ingredients_image, recipe_cooking_image)
			VALUES (:recipeTypeID, :cuisineID, :recipeTitle, :recipeDescription, :recipeImage, :recipeEquipmentImage, :recipeIngredientsImage, :recipeCookingImage)';
	$stmt = $conn->prepare($sql);
	$stmt->execute([':recipeTypeID'           => $recipeTypeID,
					':cuisineID'              => $cuisineID,
					':recipeTitle'            => $recipeTitle,
					':recipeDescription'      => $recipeDescription,
					':recipeImage'            => $recipeImage,
					':recipeEquipmentImage'   => $recipeEquipmentImage,
					':recipeIngredientsImage' => $recipeIngredientsImage,
					':recipeCookingImage'     => $recipeCookingImage]);
	
	
	
	// get last insert ID
	$recipeID = $conn->lastInsertId();
	
	
	
	// nobsc_recipe_equipment insertions
	$numberOfEquipment = count($equipmentIDs);
	if ($numberOfEquipment > 1) {
		$allRows = "";
		$parametersH = [];
		$parametersJ = [];
		$parametersK = [];
		$equipmentIDsValues = array_values($equipmentIDs);
		$selectAmountsValues = array_values($selectAmounts);
		for ($i = 0; $i < $numberOfEquipment; $i++) {
			$h = ":recipeID" . $i;
			$j = ":equipmentID" . $i;
			$k = ":amount" . $i;
			$singleRow = "($h, $j, $k), ";
			$allRows .= $singleRow;
			$parametersH[$h] = $recipeID;
			$parametersJ[$j] = $equipmentIDsValues[$i];
			$parametersK[$k] = $selectAmountsValues[$i];
		}
		$allRowsCleaned = substr($allRows, 0, -2);
		
		$sql = "INSERT INTO nobsc_recipe_equipment (recipe_id, equipment_id, amount) VALUES " . $allRowsCleaned;
		$stmt = $conn->prepare($sql);
		foreach ($parametersH as $h => $val) { $stmt->bindValue($h, $val, PDO::PARAM_INT); }  // bind all recipe_id
		foreach ($parametersJ as $j => $val) { $stmt->bindValue($j, $val, PDO::PARAM_INT); }  // bind all equipment_id
		foreach ($parametersK as $k => $val) { $stmt->bindValue($k, $val, PDO::PARAM_INT); }  // bind all amount
		$stmt->execute();
		
	} elseif ($numberOfEquipment == 1) {
		$sql = 'INSERT INTO nobsc_recipe_equipment (recipe_id, equipment_id, amount) VALUES (:recipeID, :equipmentID, :amount)';
		$stmt = $conn->prepare($sql);
		$stmt->execute([':recipeID'    => $recipeID,
						':equipmentID' => $equipmentID,
						':amount'      => $selectAmount]);
	}
	
	
	
	// nobsc_recipe_ingredients insertions
	$numberOfIngredients = count($ingredientIDs);
	if ($numberOfIngredients > 1) {
		$allRows = "";
		$parametersH = [];
		$parametersJ = [];
		$parametersK = [];
		$parametersM = [];
		$ingredientIDsValues = array_values($ingredientIDs);
		$measurementsValues = array_values($measurements);
		$manualAmountsValues = array_values($manualAmounts);
		for ($i = 0; $i < $numberOfIngredients; $i++) {
			$h = ":recipeID" . $i;
			$j = ":ingredientID" . $i;
			$k = ":measurementID" . $i;
			$m = ":amount" . $i;
			$singleRow = "($h, $j, $k, $m), ";
			$allRows .= $singleRow;
			$parametersH[$h] = $recipeID;
			$parametersJ[$j] = $ingredientIDsValues[$i];
			$parametersK[$k] = $manualAmountsValues[$i];
			$parametersM[$m] = $measurementsValues[$i];
		}
		$allRowsCleaned = substr($allRows, 0, -2);
		
		$sql = "INSERT INTO nobsc_recipe_ingredients (recipe_id, ingredient_id, measurement_id, amount) VALUES " . $allRowsCleaned;
		$stmt = $conn->prepare($sql);
		foreach ($parametersH as $h => $val) { $stmt->bindValue($h, $val, PDO::PARAM_INT); }  // bind all recipe_id
		foreach ($parametersJ as $j => $val) { $stmt->bindValue($j, $val, PDO::PARAM_INT); }  // bind all ingredient_id
		foreach ($parametersK as $k => $val) { $stmt->bindValue($k, $val, PDO::PARAM_INT); }  // bind all measurement_id
		foreach ($parametersM as $m => $val) { $stmt->bindValue($m, $val, PDO::PARAM_INT); }  // bind all amount
		$stmt->execute();
		
	} elseif ($numberOfIngredients == 1) {
		$sql = 'INSERT INTO nobsc_recipe_ingredients (recipe_id, ingredient_id, measurement_id, amount) VALUES (:recipeID, :ingredientID, :measurementID, :amount)';
		$stmt = $conn->prepare($sql);
		$stmt->execute([':recipeID'      => $recipeID,
						':ingredientID'  => $ingredientID,
						':measurementID' => $measurementID,
						':amount'        => $manualAmount]);
	}
	
	
	
	// nobsc_recipe_subrecipes insertions
	$numberOfSubrecipes = count($subrecipeIDs);
	if ($numberOfSubrecipes > 1) {
		$allRows = "";
		$parametersH = [];
		$parametersJ = [];
		$parametersK = [];
		$parametersM = [];
		$subrecipeIDsValues = array_values($subrecipeIDs);
		$measurementsValues = array_values($measurements);      // RENAME ******************** (in the HTML for sure, possibly elsewhere)
		$manualAmountsValues = array_values($manualAmounts);    // RENAME ******************** (in the HTML for sure, possibly elsewhere)
		for ($i = 0; $i < $numberOfSubrecipes; $i++) {
			$h = ":recipeID" . $i;
			$j = ":subrecipeID" . $i;
			$k = ":measurementID" . $i;                         // ADD COLUMN TO DB TABLE ********************
			$m = ":amount" . $i;                                // ADD COLUMN TO DB TABLE ********************
			$singleRow = "($h, $j, $k, $m), ";
			$allRows .= $singleRow;
			$parametersH[$h] = $recipeID;
			$parametersJ[$j] = $subrecipeIDsValues[$i];
			$parametersK[$k] = $manualAmountsValues[$i];        // RENAME ********************
			$parametersM[$m] = $measurementsValues[$i];         // RENAME ********************
		}
		$allRowsCleaned = substr($allRows, 0, -2);
		
		$sql = "INSERT INTO nobsc_recipe_subrecipes (recipe_id, subrecipe_id, measurement_id, amount) VALUES " . $allRowsCleaned;
		$stmt = $conn->prepare($sql);
		foreach ($parametersH as $h => $val) { $stmt->bindValue($h, $val, PDO::PARAM_INT); }  // bind all recipe_id
		foreach ($parametersJ as $j => $val) { $stmt->bindValue($j, $val, PDO::PARAM_INT); }  // bind all ingredient_id
		foreach ($parametersK as $k => $val) { $stmt->bindValue($k, $val, PDO::PARAM_INT); }  // bind all measurement_id
		foreach ($parametersM as $m => $val) { $stmt->bindValue($m, $val, PDO::PARAM_INT); }  // bind all amount
		$stmt->execute();
		
	} elseif ($numberOfSubrecipes == 1) {
		$sql = 'INSERT INTO nobsc_recipe_subrecipes (recipe_id, subrecipe_id, measurement_id, amount) VALUES (:recipeID, :subrecipeID, :measurementID, :amount)';
		$stmt = $conn->prepare($sql);
		$stmt->execute([':recipeID'      => $recipeID,
						':subrecipeID'   => $subrecipeID,
						':measurementID' => $measurementID,
						':amount'        => $manualAmount]);    // RENAME ********************
	}
	
	
	
	// nobsc_steps insertions
	$numberOfSteps = count($stepTexts);
	if ($numberOfSteps > 1) {
		$allRows = "";
		$parametersH = [];
		$parametersJ = [];
		$parametersK = [];
		$stepTextsValues = array_values($stepTexts);
		for ($i = 0; $i < $numberOfSteps; $i++) {
			$h = ":recipeID" . $i;
			$j = ":stepNumber" . $i;
			$k = ":stepText" . $i;
			$singleRow = "($h, $j, $k), ";
			$allRows .= $singleRow;
			$parametersH[$h] = $recipeID;
			$parametersJ[$j] = $i;
			$parametersK[$k] = $stepTextsValues[$i];
		}
		$allRowsCleaned = substr($allRows, 0, -2);
		
		$sql = "INSERT INTO nobsc_steps (recipe_id, step_number, step_text) VALUES " . $allRowsCleaned;
		$stmt = $conn->prepare($sql);	
		foreach ($parametersH as $h => $val) { $stmt->bindValue($h, $val, PDO::PARAM_INT); }  // bind all recipe_id
		foreach ($parametersJ as $j => $val) { $stmt->bindValue($j, $val, PDO::PARAM_INT); }  // bind all step_number
		foreach ($parametersK as $k => $val) { $stmt->bindValue($k, $val, PDO::PARAM_INT); }  // bind all step_text
		$stmt->execute();
		
	} elseif ($numberOfSteps == 1) {
		$sql = 'INSERT INTO nobsc_steps (recipe_id, step_number, step_text) VALUES (:recipeID, :stepNumber, :stepText)';
		$stmt = $conn->prepare($sql);
		$stmt->execute([':recipeID'   => $recipeID,
						':stepNumber' => $stepNumber,
						':stepText'   => $stepText]);
	}
	
	
	
	// feedback
	if (isset($feedback)) { echo $feedback; }
	
	/*
	echo '<p>' . $recipeTypeID . '</p>';
	echo '<p>' . $cuisineID . '</p>';
	echo '<p>' . $recipeTitle . '</p>';
	echo '<p>' . $recipeDescription . '</p>';
	
	echo '<p>' . $recipeImage . '</p>';
	echo '<p>' . $recipeEquipmentImage . '</p>';
	echo '<p>' . $recipeIngredientsImage . '</p>';
	echo '<p>' . $recipeCookingImage . '</p>';
	
	echo '<p><pre>' . var_dump($selectAmounts) . '</pre></p>';
	echo '<p><pre>' . var_dump($equipmentIDs) . '</pre></p>';
	
	echo '<p><pre>' . var_dump($manualAmounts) . '</pre></p>';
	echo '<p><pre>' . var_dump($measurements) . '</pre></p>';
	echo '<p><pre>' . var_dump($ingredientIDs) . '</pre></p>';
	
	$recipeID = 1;
	if (is_array($stepTexts)) {
		$numberOfSteps = count($stepTexts);
		if ($numberOfSteps > 1) {
			$allRows = "";
			$parametersH = [];
			$parametersJ = [];
			$parametersK = [];
			$stepTextsValues = array_values($stepTexts);
			for ($i = 0; $i < $numberOfSteps; $i++) {
				$h = ":recipeID" . $i;
				$j = ":stepNumber" . $i;
				$k = ":stepText" . $i;
				$singleRow = "($h, $j, $k), ";
				$allRows .= $singleRow;
				$parametersH[$h] = $recipeID;
				$parametersJ[$j] = $i;
				$parametersK[$k] = $stepTextsValues[$i];
			}
			$allRowsCleaned = substr($allRows, 0, -2);
		}
		echo '<p><pre>' . var_dump($stepTexts) . '</pre></p>';
		echo '<p><pre>' . var_dump($stepTextsValues) . '</pre></p>';
		echo '<p>' . $allRowsCleaned . '</p>';
		echo '<p><pre>' . var_dump($parametersH) . '</pre></p>';
		echo '<p><pre>' . var_dump($parametersJ) . '</pre></p>';
		echo '<p><pre>' . var_dump($parametersK) . '</pre></p>';
	}
	*/
}



?>