<?php

// require '../starter.php';

error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();

$_SESSION['user_id'] = 1;
$_SESSION['username'] = "Tester";
$_SESSION['access_level'] = 3;

require '../../nobsc_main_set.php';

$dsn = 'mysql:host=' . DB_SN . ';dbname=' . DB_NA . ';charset=utf8';
$opt = [
	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES   => false
];
$conn = new PDO($dsn, DB_UN, DB_PW, $opt);



// data for equipment row
$sql = 'SELECT equipment_id, equipment_name FROM nobsc_equipment WHERE equipment_type_id = 2 ORDER BY equipment_name ASC';
$stmt = $conn->query($sql);
$allPreparingEquipment = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

$sql = 'SELECT equipment_id, equipment_name FROM nobsc_equipment WHERE equipment_type_id = 3 ORDER BY equipment_name ASC';
$stmt = $conn->query($sql);
$allCookingEquipment = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);



// data for ingredients row
$sql = 'SELECT measurement_id, measurement FROM nobsc_measurements';
$stmt = $conn->query($sql);
$allMeasurements = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

$sql = 'SELECT ingredient_type_id, ingredient_type_name FROM nobsc_ingredient_types';
$stmt = $conn->query($sql);
$allIngredientTypes = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// definitely not the most efficient with all these trips to the database, but we'll keep the code naive for now until a more sophisticated way is found
// 1
$sql = 'SELECT ingredient_id, ingredient_name FROM nobsc_ingredients WHERE ingredient_type_id = 1 ORDER BY ingredient_name ASC';
$stmt = $conn->query($sql);
$allFish = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
// 2
$sql = 'SELECT ingredient_id, ingredient_name FROM nobsc_ingredients WHERE ingredient_type_id = 2 ORDER BY ingredient_name ASC';
$stmt = $conn->query($sql);
$allShellfish = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
// 3
$sql = 'SELECT ingredient_id, ingredient_name FROM nobsc_ingredients WHERE ingredient_type_id = 3 ORDER BY ingredient_name ASC';
$stmt = $conn->query($sql);
$allBeef = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
// 4
$sql = 'SELECT ingredient_id, ingredient_name FROM nobsc_ingredients WHERE ingredient_type_id = 4 ORDER BY ingredient_name ASC';
$stmt = $conn->query($sql);
$allPork = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
// 5
$sql = 'SELECT ingredient_id, ingredient_name FROM nobsc_ingredients WHERE ingredient_type_id = 5 ORDER BY ingredient_name ASC';
$stmt = $conn->query($sql);
$allPoultry = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
// 6
$sql = 'SELECT ingredient_id, ingredient_name FROM nobsc_ingredients WHERE ingredient_type_id = 6 ORDER BY ingredient_name ASC';
$stmt = $conn->query($sql);
$allEgg = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
// 7
$sql = 'SELECT ingredient_id, ingredient_name FROM nobsc_ingredients WHERE ingredient_type_id = 7 ORDER BY ingredient_name ASC';
$stmt = $conn->query($sql);
$allDairy = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
// 8
$sql = 'SELECT ingredient_id, ingredient_name FROM nobsc_ingredients WHERE ingredient_type_id = 8 ORDER BY ingredient_name ASC';
$stmt = $conn->query($sql);
$allOil = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
// 9
$sql = 'SELECT ingredient_id, ingredient_name FROM nobsc_ingredients WHERE ingredient_type_id = 9 ORDER BY ingredient_name ASC';
$stmt = $conn->query($sql);
$allStarch = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
// 10
$sql = 'SELECT ingredient_id, ingredient_name FROM nobsc_ingredients WHERE ingredient_type_id = 10 ORDER BY ingredient_name ASC';
$stmt = $conn->query($sql);
$allBean = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
// 11
$sql = 'SELECT ingredient_id, ingredient_name FROM nobsc_ingredients WHERE ingredient_type_id = 11 ORDER BY ingredient_name ASC';
$stmt = $conn->query($sql);
$allVegetable = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
// 12
$sql = 'SELECT ingredient_id, ingredient_name FROM nobsc_ingredients WHERE ingredient_type_id = 12 ORDER BY ingredient_name ASC';
$stmt = $conn->query($sql);
$allFruit = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
// 13
$sql = 'SELECT ingredient_id, ingredient_name FROM nobsc_ingredients WHERE ingredient_type_id = 13 ORDER BY ingredient_name ASC';
$stmt = $conn->query($sql);
$allNut = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
// 14
$sql = 'SELECT ingredient_id, ingredient_name FROM nobsc_ingredients WHERE ingredient_type_id = 14 ORDER BY ingredient_name ASC';
$stmt = $conn->query($sql);
$allSeed = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
// 15
$sql = 'SELECT ingredient_id, ingredient_name FROM nobsc_ingredients WHERE ingredient_type_id = 15 ORDER BY ingredient_name ASC';
$stmt = $conn->query($sql);
$allSpice = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
// 16
$sql = 'SELECT ingredient_id, ingredient_name FROM nobsc_ingredients WHERE ingredient_type_id = 16 ORDER BY ingredient_name ASC';
$stmt = $conn->query($sql);
$allHerb = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
// 17
$sql = 'SELECT ingredient_id, ingredient_name FROM nobsc_ingredients WHERE ingredient_type_id = 17 ORDER BY ingredient_name ASC';
$stmt = $conn->query($sql);
$allAcid = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
// 18
$sql = 'SELECT ingredient_id, ingredient_name FROM nobsc_ingredients WHERE ingredient_type_id = 18 ORDER BY ingredient_name ASC';
$stmt = $conn->query($sql);
$allProduct = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);



if (isset($_POST) && !empty($_FILES['image']['name'])) {
	
}

// process the four images                  *** CHANGE THIS TO RECEIVE POST, and redo/finish validation/feedback/foolproofing ***
function uploadRecipeImage() {
	
	// 1. setup
	$temporaryName = $_FILES['submitted_image']['tmp_name'];
	$imageNameOne = $_FILES['submitted_image']['name'];
	$imageDirectory = 'images/recipes/';
	$imagePath = $imageDirectory . $imageNameOne;
	
	
	
	// 2. check if the files use an allowed image type
	$imageCheck = getimagesize($temporaryName);
	$allowedImageTypes = array(IMAGETYPE_JPEG);
	if (!in_array($imageCheck[2], $allowedImageTypes)) {
		exec('submitted_image -bi ' . $temporaryName, $imageCheck);
	}
	
	
	
	// 3. check dimensions of images
	$imageWidth = $imageCheck[0];
	$imageHeight = $imageCheck[1];
	if (($imageWidth != "480") && ($imageHeight != "320")) {
		$feedback = '<div class="image_feedback">Image dimensions must be 480 pixels wide and 320 pixels high.</div>';
	}
	
	
	
	// 4. check file sizes
	$maxFileSize = 1000000;  // 1MB
	if (filesize($temporaryName) > $maxFileSize) {
		$feedback = '<div class="image_feedback">Image file size is too large.</div>';
	}
	
	
	
	// 5. check if the files already exist
	$targetDirectory = 'images/recipes/';
	$targetFile = $targetDirectory . basename($_FILES['submitted_image']['name']);
	if (file_exists($targetFile)) {
		$feedback = '<div class="image_feedback">Image file already exists.</div>';
		// die(); ?
	}	
	
	
	
	// 6. store the 4 image files in the images/recipes directory
	if (move_uploaded_file($temporaryName, $targetFile)) {
		chmod($targetFile, 0644);
		$feedback = '<div class="image_feedback">Image uploaded!</div>';
	} else {
		$feedback = '<div class="image_feedback">There was a problem storing your image. Try again?</div>';
	}
	
	
	
	// 7. make a copy of the recipe_image file, resized and name appended with a "-t", store in the images/irecipes/thumbs directory
	$thumbDirectory = 'images/recipes/thumbs/';
	$thumbName = substr_replace($imageNameOne, '-t.jpg', -4);
	$thumbPath = $thumbDirectory . $thumbName;
	$thumbWidth = '120';
	$thumbHeight = '80';
	$thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);
	$image = imagecreatefromjpeg($imagePath);
	imagecopyresampled($thumb, $image, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $imageWidth, $imageHeight);
	imagejpeg($thumb, $thumbPath, 100);
	imagedestroy($thumb);
	
	
	
	// 8. finally, make database insertions
	
	// user input
	$recipeTypeID = $_POST['recipe_type_id'];
	$cuisineID = $_POST['cuisine_id'];
	$recipeTitle = $_POST['recipe_title'];                            // sanitize/validate!
	$recipeDescription = $_POST['recipe_description'];                // sanitize/validate!
	$recipeImage = $imageNameOne;
	$recipeEquipmentImage = $imageNameTwo;
	$recipeIngredientsImage = $imageNameThree;
	$recipeCookingImage = $imageNameFour;

	$selectAmounts = json_decode($_POST['selectAmountsJSON'], true);
	$equipmentIDs = json_decode($_POST['selectEquipmentJSON'], true);
	
	$manualAmounts = json_decode($_POST['manualAmountsJSON'], true);  // sanitize/validate!
	$measurements = json_decode($_POST['selectUnitsJSON'], true);
	$ingredientIDs = json_decode($_POST['selectIngredientsJSON'], true);
	
	$stepTexts = json_decode($_POST['manualStepsJSON'], true);        // sanitize/validate!
	
	
	
	// get database connection
	global $conn;
	
	
	
	// nobsc_recipes insertions
	$sql = 'INSERT INTO nobsc_recipes (recipe_type_id, cuisine_id, recipe_title, recipe_description, recipe_image, recipe_equipment_image, recipe_ingredients_image, recipe_cooking_image)
			VALUES (:recipeTypeID, :cuisineID :, :recipeTitle, :recipeDescription, :recipeImage, :recipeEquipmentImage, :recipeIngredientsImage, :recipeCookingImage)';
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
		foreach ($parametersH as $h => $val) { $stmt->bindValue($h, $val, PDO::PARAM_INT); }
		foreach ($parametersJ as $j => $val) { $stmt->bindValue($j, $val, PDO::PARAM_INT); }
		foreach ($parametersK as $k => $val) { $stmt->bindValue($k, $val, PDO::PARAM_INT); }
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
	
}

if (!empty($_FILES)) { echo uploadRecipeImage(); } // delete this to prevent submission errors... submit using ajax
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>COOK EAT WIN REPEAT</title>
	<link href="../../images/master/nobsc-favicon-us.png" rel="shortcut icon">
	<link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
	<link href="../../css/staff/primary.css" rel="stylesheet">
	<link href="../../css/staff/header_white.css" rel="stylesheet">
	<link href="../../css/staff/submit_recipe.css" rel="stylesheet">
</head>
<body>
	<?php include 'header_white.php'; ?>
	<main>
		<div id="page">
			<div id="form">
			<!-- <form action="" method="post" enctype="multipart/form-data"> -->
				<h1>Submit New Recipe</h1>
				
				
				
				<!-- type, cuisine, title, & description -->
				<div>
					<label class="red_style">Type of Recipe</label>
					<select name="recipe_type_id" required>
						<option></option>
						<?php
						$sql = 'SELECT recipe_type_id, recipe_type_name FROM nobsc_recipe_types';
						$stmt = $conn->prepare($sql);
						$stmt->execute();
						while (($row = $stmt->fetch()) !== false) {
							echo '<option value="' . $row['recipe_type_id'] . '">' . $row['recipe_type_name'] . '</option>';
						}
						?>
					</select>
				</div>
				
				<div>
					<label class="red_style">Cuisine</label>
					<select name="cuisine_id" required>
						<option></option>
						<?php
						$sql = 'SELECT cuisine_id, cuisine FROM nobsc_cuisines';
						$stmt = $conn->prepare($sql);
						$stmt->execute();
						while (($row = $stmt->fetch()) !== false) {
							echo '<option value="' . $row['cuisine_id'] . '">' . $row['cuisine'] . '</option>';
						}
						?>
					</select>
				</div>
				
				<div>
					<label class="red_style">Title</label>
					<input type="text" name="recipe_title">
				</div>
				
				<div>
					<label class="red_style">Description / Author Note</label>
					<input type="text" name="recipe_description">
				</div>
				
				
				
				<!-- equipment, ingredients, & steps -->
				<div class="recipe_additions" id="equipment_div">
					<label class="red_style">Equipment</label>
					
					<div id="equipment_rows_container">
						
						<div class="equipment_row">
							<label>Amount:</label>
							<select class="select_amount" required>
								<option></option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
							<label>Type:</label>
							<select class="select_equipment_type" required>
								<option></option>
								<option value="2">Preparing</option>
								<option value="3">Cooking</option>
							</select>
							<label>Equipment:</label>
							<select class="select_equipment" required>
								<option></option>
							</select>
							<button class="remove_equipment_row_button">Remove</button>
						</div>
						
						
						<div class="equipment_row">
							<label>Amount:</label>
							<select class="select_amount" required>
								<option></option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
							<label>Type:</label>
							<select class="select_equipment_type" required>
								<option></option>
								<option value="2">Preparing</option>
								<option value="3">Cooking</option>
							</select>
							<label>Equipment:</label>
							<select class="select_equipment" required>
								<option></option>
							</select>
							<button class="remove_equipment_row_button">Remove</button>
						</div>
						
						
						<div class="equipment_row">
							<label>Amount:</label>
							<select class="select_amount" required>
								<option></option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
							<label>Type:</label>
							<select class="select_equipment_type" required>
								<option></option>
								<option value="2">Preparing</option>
								<option value="3">Cooking</option>
							</select>
							<label>Equipment:</label>
							<select class="select_equipment" required>
								<option></option>
							</select>
							<button class="remove_equipment_row_button">Remove</button>
						</div>
						
					</div>
					
					<button id="add_equipment_button">Add Equipment</button>
				</div>
				
				
				<div class="recipe_additions" id="ingredients_div">
					<label class="red_style">Ingredients</label>
					
					<div id="ingredient_rows_container">
					
						<div class="ingredient_row">
							<label>Amount:</label><input class="manual_amount" type="number" step="any" min="0.125" max="9999" required>
							<label>Unit:</label>
							<select class="select_unit" required>
								<option></option>
							</select>
							<label>Type:</label>
							<select class="select_ingredient_type" required>
								<option></option>
							</select>
							<label>Ingredient:</label>
							<select class="select_ingredient" required>
								<option></option>
							</select>
							<button class="remove_ingredient_row_button">Remove</button>
						</div>
						
						<div class="ingredient_row">
							<label>Amount:</label><input class="manual_amount" type="number" step="any" min="0.125" max="9999" required>
							<label>Unit:</label>
							<select class="select_unit" required>
								<option></option>
							</select>
							<label>Type:</label>
							<select class="select_ingredient_type" required>
								<option></option>
							</select>
							<label>Ingredient:</label>
							<select class="select_ingredient" required>
								<option></option>
							</select>
							<button class="remove_ingredient_row_button">Remove</button>
						</div>
						
						<div class="ingredient_row">
							<label>Amount:</label><input class="manual_amount" type="number" step="any" min="0.125" max="9999" required>
							<label>Unit:</label>
							<select class="select_unit" required>
								<option></option>
							</select>
							<label>Type:</label>
							<select class="select_ingredient_type" required>
								<option></option>
							</select>
							<label>Ingredient:</label>
							<select class="select_ingredient" required>
								<option></option>
							</select>
							<button class="remove_ingredient_row_button">Remove</button>
						</div>
					
					</div>
					
					<button id="add_ingredient_button">Add Ingredient</button>
				</div>
				
				
				<div class="recipe_additions" id="steps_div">
					<label class="red_style">Directions</label>
					<div class="step_row">
						<label>Step:</label><input type="text" maxlength="250" class="manual_step" required><button class="remove_step_row_button">Remove</button>
					</div>
					<div class="step_row">
						<label>Step:</label><input type="text" maxlength="250" class="manual_step" required><button class="remove_step_row_button">Remove</button>
					</div>
					<div class="step_row">
						<label>Step:</label><input type="text" maxlength="250" class="manual_step" required><button class="remove_step_row_button">Remove</button>
					</div>
					<button id="add_step_button">Add Step</button>
				</div>
				
				
				
				<!--images-->
				<div>
					<div class="image_div">
						<label class="red_style">Image of Finished Recipe</label>
						<div id="preview">
							<img src="" id="preview_image">
						</div>
						<?php if (isset($feedback)) { echo $feedback; } ?>
						<input type="file" name="submitted_image" class="submitted_image" id="submitted_image" required>
					</div>
					<div class="image_div">
						<label class="red_style">Image of All Equipment</label>
						<div id="preview_e">
							<img src="" id="preview_equipment_image">
						</div>
						<?php if (isset($feedback)) { echo $feedback; } ?>
						<input type="file" name="submitted_equipment_image" class="submitted_image" id="submitted_equipment_image" required>
					</div>
					<div class="image_div">
						<label class="red_style">Image of All Ingredients</label>
						<div id="preview_i">
							<img src="" id="preview_ingredients_image">
						</div>
						<?php if (isset($feedback)) { echo $feedback; } ?>
						<input type="file" name="submitted_ingredients_image" class="submitted_image" id="submitted_ingredients_image" required>
					</div>
					<div class="image_div">
						<label class="red_style">Image of Cooking Action</label>
						<div id="preview_c">
							<img src="" id="preview_cooking_image">
						</div>
						<?php if (isset($feedback)) { echo $feedback; } ?>
						<input type="file" name="submitted_cooking_image" class="submitted_image" id="submitted_cooking_image" required>
					</div>
				</div>
				
				
				
				<!--submit-->
				<div>
					<input type="submit" name="submit" id="submit_button" value="Submit Recipe">
				</div>
			<!-- </form> -->
			</div>
		</div>
	</main>
<script>
function cmsSubmitRecipeActionOne(e) {
	var imageToSizeCheck = document.getElementsByClassName("submitted_image");
	var selectEquipmentType = document.getElementsByClassName('select_equipment_type');
	var selectIngredientType = document.getElementsByClassName('select_ingredient_type');
	var addEquipmentButton = document.getElementById('add_equipment_button');
	var addIngredientButton = document.getElementById('add_ingredient_button');
	var addStepButton = document.getElementById('add_step_button');
	var removeEquipmentRowButtons = document.getElementsByClassName('remove_equipment_row_button');
	var removeIngredientRowButtons = document.getElementsByClassName('remove_ingredient_row_button');
	var removeStepRowButtons = document.getElementsByClassName('remove_step_row_button');
	var submitButton = document.getElementById("submit_button");
	
	for (var i = 0; i < imageToSizeCheck.length; i++) { imageToSizeCheck[i].addEventListener('click', function(e) { clientSideEnforceImageSize(e); }, false); }
	for (var i = 0; i < selectEquipmentType.length; i++) {
		selectEquipmentType[i].className += " has_match";
		selectEquipmentType[i].addEventListener('change', function(e) { matchEquipmentToType(e); }, false);
	}
	for (var i = 0; i < selectIngredientType.length; i++) {
		selectEquipmentType[i].className += " has_match";
		selectIngredientType[i].addEventListener('change', function(e) { matchIngredientToType(e); }, false);
	}
	addEquipmentButton.addEventListener('click', function(e) { prepareEquipmentRow(e); }, false);
	addIngredientButton.addEventListener('click', function(e) { prepareIngredientRow(e); }, false);
	addStepButton.addEventListener('click', function(e) { addStepRow(e); }, false);
	for (var i = 0; i < removeEquipmentRowButtons.length; i++) {
		removeEquipmentRowButtons[i].className += " has_remove";
		removeEquipmentRowButtons[i].addEventListener('click', function(e) { removeEquipmentRow(e); }, false);
	}
	for (var i = 0; i < removeIngredientRowButtons.length; i++) {
		removeIngredientRowButtons[i].className += " has_remove";
		removeIngredientRowButtons[i].addEventListener('click', function(e) { removeIngredientRow(e); }, false);
	}
	for (var i = 0; i < removeStepRowButtons.length; i++) { removeStepRowButtons[i].addEventListener('click', function(e) { removeStepRow(e); }, false); }
	populateIngredientUnitsAndTypes();
	submitButton.addEventListener('click', postToServerSide, false);
}



function clientSideEnforceImageSize(e) {
    var reader = new FileReader();
    reader.onload = function(e) {
		var image = new Image();
		image.src = e.target.result;
		image.onload = function() {
			var width = this.width;
			var height = this.height;
			if ((width != 480) || (height != 320)) {
				alert("Image dimensions must be 480 pixels wide and 320 pixels high.");
			} else {
				document.getElementById("preview_image").src = e.target.result;
			}
		}
    }
	reader.readAsDataURL(this.files[0]);
}



function populateIngredientUnitsAndTypes() {
	var container = document.getElementById("ingredient_rows_container");
	var selectUnits = container.getElementsByClassName("select_unit");
	var selectIngredientTypes = container.getElementsByClassName("select_ingredient_type");
	var unitOptionValues = <?php echo json_encode(array_keys($allMeasurements)) ?>;
	var unitOptionText = <?php echo json_encode(array_values($allMeasurements)) ?>;
	var ingredientTypeOptionValues = <?php echo json_encode(array_keys($allIngredientTypes)) ?>;
	var ingredientTypeOptionText = <?php echo json_encode(array_values($allIngredientTypes)) ?>;
	
	for (var i = 0; i < selectUnits.length; i++) {
		var list = selectUnits[i];
		if ((list.classList.contains('populated')) !== true) {
			list.className += " populated";
			list.innerHTML = "";
			var emptyOption = document.createElement("option");
			selectUnits[i].options.add(emptyOption);
			for (var j = 0; j < unitOptionValues.length; j++) {
				var newOption = document.createElement("option");
				newOption.value = unitOptionValues[j];
				newOption.innerHTML = unitOptionText[j];
				selectUnits[i].options.add(newOption);
			}
		}
	}
	
	for (var i = 0; i < selectIngredientTypes.length; i++) {
		var list = selectIngredientTypes[i];
		if ((list.classList.contains('populated')) !== true) {
			list.className += " populated";
			list.innerHTML = "";
			var emptyOption = document.createElement("option");
			selectIngredientTypes[i].options.add(emptyOption);
			for (var j = 0; j < ingredientTypeOptionValues.length; j++) {
				var newOption = document.createElement("option");
				newOption.value = ingredientTypeOptionValues[j];
				newOption.innerHTML = ingredientTypeOptionText[j];
				selectIngredientTypes[i].options.add(newOption);
			}
		}
	}
}



function matchEquipmentToType(e) {
	var s1 = e.target;
	var sC = s1.parentNode.getElementsByClassName("select_equipment");
	var s2 = sC[0];
	s2.innerHTML = "";
	var emptyOption = document.createElement("option");
	s2.options.add(emptyOption);
	if (s1.value == "2") {
		var equipmentOptionValues = <?php echo json_encode(array_keys($allPreparingEquipment)) ?>;
		var equipmentOptionText = <?php echo json_encode(array_values($allPreparingEquipment)) ?>;
	} else if (s1.value == "3") {
		var equipmentOptionValues = <?php echo json_encode(array_keys($allCookingEquipment)) ?>;
		var equipmentOptionText = <?php echo json_encode(array_values($allCookingEquipment)) ?>;
	}
	if (typeof equipmentOptionValues !== 'undefined') {
		for (var i = 0; i < equipmentOptionValues.length; i++) {
			var newOption = document.createElement("option");
			newOption.value = equipmentOptionValues[i];
			newOption.innerHTML = equipmentOptionText[i];
			s2.options.add(newOption);
		}
	}
	e.preventDefault();
	e.stopPropagation();
}

function matchIngredientToType(e) {
	var s1 = e.target;
	var sC = s1.parentNode.getElementsByClassName("select_ingredient");
	var s2 = sC[0];
	s2.innerHTML = "";
	var emptyOption = document.createElement("option");
	s2.options.add(emptyOption);
	if (s1.value == "1") {
		var ingredientOptionValues = <?php echo json_encode(array_keys($allFish)) ?>;
		var ingredientOptionText = <?php echo json_encode(array_values($allFish)) ?>;
	}
	else if (s1.value == "2") {
		var ingredientOptionValues = <?php echo json_encode(array_keys($allShellfish)) ?>;
		var ingredientOptionText = <?php echo json_encode(array_values($allShellfish)) ?>;
	}
	else if (s1.value == "3") {
		var ingredientOptionValues = <?php echo json_encode(array_keys($allBeef)) ?>;
		var ingredientOptionText = <?php echo json_encode(array_values($allBeef)) ?>;
	}
	else if (s1.value == "4") {
		var ingredientOptionValues = <?php echo json_encode(array_keys($allPork)) ?>;
		var ingredientOptionText = <?php echo json_encode(array_values($allPork)) ?>;
	}
	else if (s1.value == "5") {
		var ingredientOptionValues = <?php echo json_encode(array_keys($allPoultry)) ?>;
		var ingredientOptionText = <?php echo json_encode(array_values($allPoultry)) ?>;
	}
	else if (s1.value == "6") {
		var ingredientOptionValues = <?php echo json_encode(array_keys($allEgg)) ?>;
		var ingredientOptionText = <?php echo json_encode(array_values($allEgg)) ?>;
	}
	else if (s1.value == "7") {
		var ingredientOptionValues = <?php echo json_encode(array_keys($allDairy)) ?>;
		var ingredientOptionText = <?php echo json_encode(array_values($allDairy)) ?>;
	}
	else if (s1.value == "8") {
		var ingredientOptionValues = <?php echo json_encode(array_keys($allOil)) ?>;
		var ingredientOptionText = <?php echo json_encode(array_values($allOil)) ?>;
	}
	else if (s1.value == "9") {
		var ingredientOptionValues = <?php echo json_encode(array_keys($allStarch)) ?>;
		var ingredientOptionText = <?php echo json_encode(array_values($allFish)) ?>;
	}
	else if (s1.value == "10") {
		var ingredientOptionValues = <?php echo json_encode(array_keys($allBean)) ?>;
		var ingredientOptionText = <?php echo json_encode(array_values($allBean)) ?>;
	}
	else if (s1.value == "11") {
		var ingredientOptionValues = <?php echo json_encode(array_keys($allVegetable)) ?>;
		var ingredientOptionText = <?php echo json_encode(array_values($allVegetable)) ?>;
	}
	else if (s1.value == "12") {
		var ingredientOptionValues = <?php echo json_encode(array_keys($allFruit)) ?>;
		var ingredientOptionText = <?php echo json_encode(array_values($allFruit)) ?>;
	}
	else if (s1.value == "13") {
		var ingredientOptionValues = <?php echo json_encode(array_keys($allNut)) ?>;
		var ingredientOptionText = <?php echo json_encode(array_values($allNut)) ?>;
	}
	else if (s1.value == "14") {
		var ingredientOptionValues = <?php echo json_encode(array_keys($allSeed)) ?>;
		var ingredientOptionText = <?php echo json_encode(array_values($allSeed)) ?>;
	}
	else if (s1.value == "15") {
		var ingredientOptionValues = <?php echo json_encode(array_keys($allSpice)) ?>;
		var ingredientOptionText = <?php echo json_encode(array_values($allSpice)) ?>;
	}
	else if (s1.value == "16") {
		var ingredientOptionValues = <?php echo json_encode(array_keys($allHerb)) ?>;
		var ingredientOptionText = <?php echo json_encode(array_values($allHerb)) ?>;
	}
	else if (s1.value == "17") {
		var ingredientOptionValues = <?php echo json_encode(array_keys($allAcid)) ?>;
		var ingredientOptionText = <?php echo json_encode(array_values($allAcid)) ?>;
	}
	else if (s1.value == "18") {
		var ingredientOptionValues = <?php echo json_encode(array_keys($allProduct)) ?>;
		var ingredientOptionText = <?php echo json_encode(array_values($allProduct)) ?>;
	}
	if (typeof ingredientOptionValues !== 'undefined') {
		for (var i = 0; i < ingredientOptionValues.length; i++) {
			var newOption = document.createElement("option");
			newOption.value = ingredientOptionValues[i];
			newOption.innerHTML = ingredientOptionText[i];
			s2.options.add(newOption);
		}
	}
	e.preventDefault();
	e.stopPropagation();
}



function getJSON(url, callback) {
	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", url, true);
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && callback) {
			callback(xhttp);
		}
	}
	xhttp.send();
}

function postJSON(data) {
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "", true);
	xhttp.send(data);
}



function constructEquipmentRow(xhttp) {
	var equipmentDiv = document.getElementById('equipment_rows_container');
	equipmentDiv.insertAdjacentHTML('beforeend', xhttp.responseText);
}

function activateEquipmentRow() {
	var equipmentDiv = document.getElementById('equipment_rows_container');
	var selectEquipmentType = equipmentDiv.getElementsByClassName('select_equipment_type');
	var removeEquipmentRowButtons = equipmentDiv.getElementsByClassName('remove_equipment_row_button');
	// activate equipment type filter
	for (var i = 0; i < selectEquipmentType.length; i++) {
		var typeColumn = selectEquipmentType[i];
		if ((typeColumn.classList.contains('has_match')) !== true) {
			typeColumn.className += " has_match";
			typeColumn.addEventListener('change', function(e) { matchEquipmentToType(e); }, false);
		}
	}
	// activate row removability
	for (var i = 0; i < removeEquipmentRowButtons.length; i++) {
		var button = removeEquipmentRowButtons[i];
		if ((button.classList.contains('has_remove')) !== true) {
			button.className += " has_remove";
			button.addEventListener('click', function(e) { removeEquipmentRow(e); }, false);
		}
	}
}

function prepareEquipmentRow(e) {
	getJSON('recipes/new_equipment_row.php', constructEquipmentRow);
	setTimeout(function() { activateEquipmentRow(); }, 500);  // horrible practice? ... it works for now at least
	e.preventDefault();
	e.stopPropagation();
}



function constructIngredientRow(xhttp) {
	var ingredientDiv = document.getElementById('ingredient_rows_container');
	ingredientDiv.insertAdjacentHTML('beforeend', xhttp.responseText);
}

function activateIngredientRow() {
	var ingredientsDiv = document.getElementById('ingredient_rows_container');
	var selectIngredientType = ingredientsDiv.getElementsByClassName('select_ingredient_type');
	var removeIngredientRowButtons = ingredientsDiv.getElementsByClassName('remove_ingredient_row_button');
	// activate ingredient type filter
	for (var i = 0; i < selectIngredientType.length; i++) {
		var typeColumn = selectIngredientType[i];
		if ((typeColumn.classList.contains('has_match')) !== true) {
			typeColumn.className += " has_match";
			typeColumn.addEventListener('change', function(e) { matchIngredientToType(e); }, false);
		}
	}
	// activate row removability
	for (var i = 0; i < removeIngredientRowButtons.length; i++) {
		var button = removeIngredientRowButtons[i];
		if ((button.classList.contains('has_remove')) !== true) {
			button.className += " has_remove";
			button.addEventListener('click', function(e) { removeIngredientRow(e); }, false);
		}
	}
}

function prepareIngredientRow(e) {
	getJSON('recipes/new_ingredient_row.php', constructIngredientRow);
	setTimeout(function() { activateIngredientRow(); }, 400);  // horrible practice... it works for now at least
	setTimeout(function() { populateIngredientUnitsAndTypes(); }, 500);  // horrible practice... it works for now at least
	e.preventDefault();
	e.stopPropagation();
}



function addStepRow(e) {
	var stepsDiv = document.getElementById('steps_div');
	var addStepButton = document.getElementById('add_step_button');
	var newStepRow = document.createElement("div");
	var nSR2 = document.createElement("label");
	var nSR3 = document.createElement("input");
	var nSR4 = document.createElement("button");
	var nSR5 = document.createTextNode("Step:");
	var nSR6 = document.createTextNode("Remove");
	newStepRow.setAttribute("class", "step_row");
	nSR3.type = "text";
	nSR4.setAttribute("class", "remove_step_row_button");
	newStepRow.appendChild(nSR2);
	newStepRow.appendChild(nSR3);
	newStepRow.appendChild(nSR4);
	nSR2.appendChild(nSR5);
	nSR4.appendChild(nSR6);
	stepsDiv.insertBefore(newStepRow, addStepButton);
	nSR4.addEventListener('click', function(e) { removeStepRow(e); }, false);
	e.preventDefault();
	e.stopPropagation();
}



function removeEquipmentRow(e) {
	var clicked = e.target;
	var divToRemove = clicked.parentNode;
	var stepsDiv = document.getElementById('equipment_rows_container');
	
	//clicked.removeEventListener('click', removeEquipmentRow);
	stepsDiv.removeChild(divToRemove);
	//clicked = null;
	//divToRemove = null;
	e.preventDefault();
	e.stopPropagation();
}

function removeIngredientRow(e) {
	var clicked = e.target;
	var divToRemove = clicked.parentNode;
	var stepsDiv = document.getElementById('ingredient_rows_container');
	
	//clicked.removeEventListener('click', removeIngredientRow);
	stepsDiv.removeChild(divToRemove);
	//clicked = null;
	//divToRemove = null;
	e.preventDefault();
	e.stopPropagation();
}

function removeStepRow(e) {
	var clicked = e.target;
	var divToRemove = clicked.parentNode;
	var stepsDiv = document.getElementById('steps_div');
	
	//clicked.removeEventListener('click', removeStepRow);
	stepsDiv.removeChild(divToRemove);
	e.preventDefault();
	e.stopPropagation();
}



function postToServerSide() {
	
	// validate this with an if statement? (duh)
	
	// 1. prepare equipment amounts
	var getSelectAmounts = document.getElementsByClassName("select_amount");
	var selectAmounts = [];
	for (var i = 0; i < getSelectAmounts.length; i++) {
		selectAmounts[i] = getSelectAmounts[i].options[getSelectAmounts.selectedIndex].value;
	}
	var selectAmountsJSON = JSON.stringify(selectAmounts);
	// 2. prepare equipment ids
	var getSelectEquipment = document.getElementsByClassName("select_equipment");
	var selectEquipment = [];
	for (var i = 0; i < getSelectEquipment.length; i++) {
		selectEquipment[i] = getSelectEquipment[i].options[getSelectEquipment.selectedIndex].value;
	}
	var selectEquipmentJSON = JSON.stringify(selectEquipment);
	
	
	// 3. prepare ingredient amounts
	var getManualAmounts = document.getElementsByClassName("manual_amount");
	var manualAmounts = [];
	for (var i = 0; i < getManualAmounts.length; i++) {
		manualAmounts[i] = getManualAmounts[i].value;
	}
	var manualAmountsJSON = JSON.stringify(manualAmounts);
	// 4. prepare measurement ids
	var getSelectUnits = document.getElementsByClassName("select_unit");
	var selectUnits = [];
	for (var i = 0; i < getSelectUnits.length; i++) {
		selectUnits[i] = getSelectUnits[i].options[getSelectUnits.selectedIndex].value;
	}
	var selectUnitsJSON = JSON.stringify(selectUnits);
	// 5. prepare ingredient ids
	var getSelectIngredients = document.getElementsByClassName("select_ingredient");
	var selectIngredients = [];
	for (var i = 0; i < getSelectIngredients.length; i++) {
		selectIngredients[i] = getSelectIngredients[i].options[getSelectIngredients.selectedIndex].value;
	}
	var selectIngredientsJSON = JSON.stringify(selectIngredients);
	
	
	// 6. prepare step texts
	var getManualSteps = document.getElementsByClassName("manual_step");
	var manualSteps = [];
	for (var i = 0; i < getManualSteps.length; i++) {
		manualSteps[i] = getManualSteps[i].value;
	}
	var manualStepsJSON = JSON.stringify(manualSteps);
	
	
	// POST prepared strings to server (These need some sort of status, success, and error feedback)
	postJSON(selectAmountsJSON);
	postJSON(selectEquipmentJSON);
	postJSON(manualAmountsJSON);
	postJSON(selectUnitsJSON);
	postJSON(selectIngredientsJSON);
	postJSON(manualStepsJSON);
	
	
	// upload the images using AJAX as well (These need some sort of status, success, and error feedback)
	var theImages = document.getElementByClassName("submitted_image");
	for (var i = 0; i < 4; i++) {
		var theImage = theImages[i];
		var theName = theImage.getAttribute("name");
		var theFile = theImage.files[0];
		var imageData = new FormData();
		
		imageData.append(theName, theFile);
		postJSON(imageData);
	}
	
}


window.addEventListener("load", function() { cmsSubmitRecipeActionOne(); }, false);



</script>
</body>
</html>