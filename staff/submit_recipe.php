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
$sql = 'SELECT equipment_id, equipment_name FROM nobsc_equipment WHERE equipment_type_id = 2';
$stmt = $conn->query($sql);
$allPreparingEquipment = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

$sql = 'SELECT equipment_id, equipment_name FROM nobsc_equipment WHERE equipment_type_id = 3';
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

/*
if (!isset($equipmentIDs)) {
	$equipmentIDs = [];
	$sql = 'SELECT ingredient_type_id FROM nobsc_ingredient_types';
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	while (($row = $stmt->fetch()) !== false) {
		if (isset($_GET['itid' . $row['ingredient_type_id']])) {
			$equipmentIDs[] = $row['ingredient_type_id'];
		}
	}
}
$equipmentIDsList = implode(", ", $equipmentIDs);
*/

// process image
function uploadRecipeImage() {
	
	// 1. setup
	$temporaryName = $_FILES['submitted_image']['tmp_name'];
	$imageName = $_FILES['submitted_image']['name'];
	$imageDirectory = 'images/recipes/';
	$imagePath = $imageDirectory . $imageName;
	
	
	// 2. check if image type is allowed
	$imageCheck = getimagesize($temporaryName);
	$allowedImageTypes = array(IMAGETYPE_JPEG);
	if (!in_array($imageCheck[2], $allowedImageTypes)) {
		exec('submitted_image -bi ' . $temporaryName, $imageCheck);
	}
	
	
	// 3. check image dimensions
	$imageWidth = $imageCheck[0];
	$imageHeight = $imageCheck[1];
	if (($imageWidth != "480") && ($imageHeight != "320")) {
		$feedback = '<div class="image_feedback">Image dimensions must be 480 pixels wide and 320 pixels high.</div>';
	}
	
	
	// 4. check file size
	$maxFileSize = 1000000;  // 1MB
	if (filesize($temporaryName) > $maxFileSize) {
		$feedback = '<div class="image_feedback">Image file size is too large.</div>';
	}
	
	
	// 5. check if file already exists
	$targetDirectory = 'images/recipes/';
	$targetFile = $targetDirectory . basename($_FILES['submitted_image']['name']);
	if (file_exists($targetFile)) {
		$feedback = '<div class="image_feedback">Image file already exists.</div>';
		// die(); ?
	}	


	// 6. store the image file in the images/recipes directory
	if (move_uploaded_file($temporaryName, $targetFile)) {
		chmod($targetFile, 0644);
		$feedback = '<div class="image_feedback">Image uploaded!</div>';
	} else {
		$feedback = '<div class="image_feedback">There was a problem storing your image. Try again?</div>';
	}
	
	
	// 7. make a copy of the image file, resized and name appended with a "-t", store in the images/irecipes/thumbs directory
	$thumbDirectory = 'images/recipes/thumbs/';
	$thumbName = substr_replace($imageName, '-t.jpg', -4);
	$thumbPath = $thumbDirectory . $thumbName;
	$thumbWidth = '120';
	$thumbHeight = '80';
	$thumb = imagecreatetruecolor($thumbWidth, $thumbHeight);
	$image = imagecreatefromjpeg($imagePath);
	imagecopyresampled($thumb, $image, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $imageWidth, $imageHeight);
	imagejpeg($thumb, $thumbPath, 100);
	imagedestroy($thumb);
	
	
	// 8. finally, make database insertions
	$recipeTypeID = $_POST['recipe_type_id'];
	$cuisineID = $_POST['cuisine_id'];
	$recipeTitle = $_POST['recipe_title'];  // sanitize/validate
	$recipeDescription = $_POST['recipe_description'];  // sanitize/validate
	$equipmentIDs;
	$ingredientIDs;
	
	global $conn;
	
	// nobsc_recipes
	$sql = 'INSERT INTO nobsc_recipes (recipe_type_id, cuisine_id, recipe_title, recipe_description, recipe_image, recipe_equipment_image, recipe_ingredients_image, recipe_cooking_image)
			VALUES (:typeID, :cuiID :, :title, :desc, :image, :eImage, :iImage, :cImage)';
	$stmt = $conn->prepare($sql);
	$stmt->execute([':typeID'  => $recipeTypeID,
					':cuiID'   => $cuisineID,
					':title'   => $recipeTitle,
					':desc'    => $recipeDescription,
					':image'   => recipeImage,
					':eImage' => $recipeEquipmentImage,
					':iImage' => $recipeIngredientsImage,
					':cImage' => $recipeCookingImage]);
	
	
	
	// get last insert ID
	$recipeID = $conn->lastInsertId();
	
	
	
	// nobsc_recipe_equipment
	if (count($equipmentIDs) > 1) {
		$inNamed = "";
		$parameters = [];
		foreach ($checkedTypes as $j => $chTy) {
			$key = ":id" . $j;
			$inNamed .= "$key, ";
			$parameters[$key] = $chTy;
		}
		$inNamedSet = rtrim($inNamed, ", ");
		
		// for each,
		// create :recipeID string and bindValue :recipeID to $recipeID
		// create :equipmentIDX string and bindValue :equipmentIDX to $equipmentIDs[X]
		// create :amount string and bindValue(PDO::PARAM_INT) :amountX to $amounts[X]
		
		$sql = "INSERT INTO nobsc_recipe_equipment (recipe_id, equipment_id, amount)
			VALUES " . $inNamedSet . "";
		$stmt = $conn->prepare($sql);
		foreach ($parameters as $k => $chType) {
			$stmt->bindValue($k, $chType);
		}
		$stmt->execute();
	} elseif (count($equipmentIDs) == 1) {
		$sql = 'INSERT INTO nobsc_recipe_equipment (recipe_id, equipment_id, amount)
				VALUES (:recipeID, :step_number, :step_text)'; // this needs to be built dynamically depending on how many equipment rows there are, and be sure the equipment are validated first so there are no errors here
		$stmt = $conn->prepare($sql);
		$stmt->execute([':recipeID' => $recipeID]); // this needs to be built dynamically
	}
	
	
	/*
	// nobsc_recipe_ingredients
	$sql = 'INSERT INTO nobsc_recipe_ingredients (recipe_id, ingredient_id, measurement_id, amount)
			VALUES (:recipeID, :step_number, :step_text)'; // this needs to be built dynamically depending on how many ingredient rows there are, and be sure the ingredients are validated first so there are no errors here
	$stmt = $conn->prepare($sql);
	$stmt->execute([':recipeID' => $recipeID]); // this needs to be built dynamically
	
	
	
	// nobsc_steps
	$sql = 'INSERT INTO nobsc_steps (recipe_id, step_number, step_text)
			VALUES (:recipeID, :step_number, :step_text)'; // this needs to be built dynamically depending on how many steps there are, and be sure the steps are validated first so there are no errors here
	$stmt = $conn->prepare($sql);
	$stmt->execute([':recipeID' => $recipeID]); // this needs to be built dynamically
	*/
}

if (!empty($_FILES)) { echo uploadRecipeImage(); } // change this to prevent submission errors... submit using ajax?
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
				<!-- <p><pre><?php // var_dump($allIngredients); ?></pre></p> -->
				<p><?php echo json_encode($allPreparingEquipment); ?></p>
				<br><br><br><br>
				<p><?php echo json_encode($allCookingEquipment); ?></p>
				<h1>Submit New Recipe</h1>
				
				<div>
					<label class="red_style">1. Recipe Type</label>
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
					<label class="red_style">2. Cuisine</label>
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
					<div>
						<label class="red_style">3. Official Recipe Image</label>
						<div id="preview">
							<img src="" id="preview_image">
						</div>
						<?php if (isset($feedback)) { echo $feedback; } ?>
						<input type="file" name="submitted_image" class="submitted_image" id="submitted_image" required>
					</div>
					<div>
						<label class="red_style">4. All Equipment Image</label>
						<div id="preview_e">
							<img src="" id="preview_equipment_image">
						</div>
						<?php if (isset($feedback)) { echo $feedback; } ?>
						<input type="file" name="submitted_image" class="submitted_image" id="submitted_equipment_image" required>
					</div>
					<div>
						<label class="red_style">5. All Ingredients Image</label>
						<div id="preview_i">
							<img src="" id="preview_ingredients_image">
						</div>
						<?php if (isset($feedback)) { echo $feedback; } ?>
						<input type="file" name="submitted_image" class="submitted_image" id="submitted_ingredients_image" required>
					</div>
					<div>
						<label class="red_style">6. Cooking Action Image</label>
						<div id="preview_c">
							<img src="" id="preview_cooking_image">
						</div>
						<?php if (isset($feedback)) { echo $feedback; } ?>
						<input type="file" name="submitted_image" class="submitted_image" id="submitted_cooking_image" required>
					</div>
				</div>
				<div>
					<label class="red_style">7. Recipe Title</label>
					<input type="text" name="recipe_title">
				</div>
				<div>
					<label class="red_style">8. Recipe Description / Author Note</label>
					<input type="text" name="recipe_description">
				</div>
				
				
				<div class="recipe_additions" id="equipment_div">
					<p class="red_style">9. Recipe Equipment</p>
					
					
					<div class="equipment_row">
						<label>Amount:</label>
						<select required>
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
						<button class="remove_row_button">Remove</button>
					</div>
					
					
					<div class="equipment_row">
						<label>Amount:</label>
						<select required>
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
						<button class="remove_row_button">Remove</button>
					</div>
					
					
					<div class="equipment_row">
						<label>Amount:</label>
						<select required>
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
						<button class="remove_row_button">Remove</button>
					</div>
					
					
					<button id="add_equipment_button">Add Equipment</button>
				</div>
				
				
				<div class="recipe_additions" id="ingredients_div">
					<p class="red_style">10. Recipe Ingredients</p>
					<div class="ingredient_row">
						<label>Amount:</label><input class="manual_amount" type="number" step="any" min="0.125" max="9999" required>
						<label>Unit:</label>
						<select required>
							<option></option>
							<?php
							foreach ($allMeasurements as $key => $value) {
								echo '<option value="' . $key . '">' . $value . '</option>';
							}
							?>
						</select>
						<label>Type:</label>
						<select class="select_ingredient_type" required>
							<option></option>
							<?php
							foreach ($allIngredientTypes as $key => $value) {
								echo '<option value="' . $key . '">' . $value . '</option>';
							}
							?>
						</select>
						<label>Ingredient:</label>
						<select class="select_ingredient" required>
							<option></option>
						</select>
						<button class="remove_row_button">Remove</button>
					</div>
					<div class="ingredient_row">
						<label>Amount:</label><input class="manual_amount" type="number" step="any" min="0.125" max="9999" required>
						<label>Unit:</label>
						<select required>
							<option></option>
							<?php
							foreach ($allMeasurements as $key => $value) {
								echo '<option value="' . $key . '">' . $value . '</option>';
							}
							?>
						</select>
						<label>Type:</label>
						<select class="select_ingredient_type" required>
							<option></option>
							<?php
							foreach ($allIngredientTypes as $key => $value) {
								echo '<option value="' . $key . '">' . $value . '</option>';
							}
							?>
						</select>
						<label>Ingredient:</label>
						<select class="select_ingredient" required>
							<option></option>
						</select>
						<button class="remove_row_button">Remove</button>
					</div>
					<div class="ingredient_row">
						<label>Amount:</label><input class="manual_amount" type="number" step="any" min="0.125" max="9999" required>
						<label>Unit:</label>
						<select required>
							<option></option>
							<?php
							foreach ($allMeasurements as $key => $value) {
								echo '<option value="' . $key . '">' . $value . '</option>';
							}
							?>
						</select>
						<label>Type:</label>
						<select class="select_ingredient_type" required>
							<option></option>
							<?php
							foreach ($allIngredientTypes as $key => $value) {
								echo '<option value="' . $key . '">' . $value . '</option>';
							}
							?>
						</select>
						<label>Ingredient:</label>
						<select class="select_ingredient" required>
							<option></option>
						</select>
						<button class="remove_row_button">Remove</button>
					</div>
					<button id="add_ingredient_button">Add Ingredient</button>
				</div>
				
				
				<div class="recipe_additions" id="steps_div">
					<p class="red_style">11. Recipe Directions</p>
					<div class="step_row">
						<label>Step:</label><input type="text"><button class="remove_row_button">Remove</button>
					</div>
					<div class="step_row">
						<label>Step:</label><input type="text"><button class="remove_row_button">Remove</button>
					</div>
					<div class="step_row">
						<label>Step:</label><input type="text"><button class="remove_row_button">Remove</button>
					</div>
					<button id="add_step_button">Add Step</button>
				</div>
				
				
				<div>
					<input type="submit" name="submit" id="submit_button" value="Submit Recipe">
				</div>
				<p><?php echo json_last_error(); ?></p>
				<p><?php echo json_last_error_msg(); ?></p>
			<!-- </form> -->
			</div>
		</div>
	</main>
<script src="../js/staff/submit_recipe.js"></script>
<script>
var selectEquipmentType = document.getElementsByClassName('select_equipment_type');
var selectIngredientType = document.getElementsByClassName('select_ingredient_type');

for (var i = 0; i < selectEquipmentType.length; i++) { selectEquipmentType[i].addEventListener('change', function(e) { matchEquipmentToType(e); }, false); }
for (var i = 0; i < selectIngredientType.length; i++) { selectIngredientType[i].addEventListener('change', function(e) { matchIngredientToType(e); }, false); }

function matchEquipmentToType(e) {
	var s1 = e.target;
	var sC = s1.parentNode.getElementsByClassName("select_equipment");
	var s2 = sC[0];
	s2.innerHTML = "";
	if (s1.value == "2") {
		alert("2");
		var equipmentOptionArray = <?php echo json_encode($allPreparingEquipment) ?>;
	} else if (s1.value == "3") {
		alert("3");
		var equipmentOptionArray = <?php echo json_encode($allCookingEquipment) ?>;
	}
	for (var option in equipmentOptionArray) {
		var valueFill = option;
		var textFill = equipmentOptionArray[option];
		var newOption = document.createElement("option");
		newOption.value = valueFill;
		newOption.innerHTML = textFill;
		s2.options.add(newOption);
	}
	e.preventDefault();
	e.stopPropagation();
}

function matchIngredientToType(e) {
	var s1 = e.target;
	var sC = s1.parentNode.getElementsByClassName("select_ingredient");
	var s2 = sC[0];
	s2.innerHTML = "";
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
	for (var i = 0; i < ingredientOptionValues.length; i++) {
		var newOption = document.createElement("option");
		newOption.value = ingredientOptionValues[i];
		newOption.innerHTML = ingredientOptionText[i];
		s2.options.add(newOption);
	}
	e.preventDefault();
	e.stopPropagation();
}
</script>
</body>
</html>