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


// data for subrecipes row
$sql = 'SELECT recipe_type_id, recipe_type_name FROM nobsc_recipe_types';
$stmt = $conn->query($sql);
$allSubrecipeTypes = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
/*
$sql = 'SELECT recipe_id, recipe_title FROM nobsc_recipes WHERE recipe_type_id = 1 ORDER BY recipe_title ASC';
$stmt = $conn->query($sql);
$allProduct = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
*/

?>
<!DOCTYPE html>
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
				<h1>Submit New Recipe</h1>
				
				
				
				<!-- type, cuisine, title, & description -->
				<div>
					<label class="red_style">Type of Recipe</label>
					<select name="recipe_type_id" id="recipe_type_id" required>
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
					<select name="cuisine_id" id="cuisine_id" required>
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
					<input type="text" name="recipe_title" id="recipe_title">
				</div>
				<div>
					<label class="red_style">Description / Author Note</label>
					<input type="text" name="recipe_description" id="recipe_description">
				</div>
				
				
				
				<!--equipment-->
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
				
				
				
				<!--ingredients-->
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
				
				
				
				<!--subrecipes-->
				<div class="recipe_additions" id="subrecipes_div">
					<label class="red_style">Subrecipes</label>
					<div id="subrecipe_rows_container">
					</div>
					<button id="add_subrecipe_button">Add Subrecipe</button>
				</div>
				
				
				
				<!--steps-->
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
							<img src="" class="preview_frame" id="preview_image">
						</div>
						<?php if (isset($feedback)) { echo $feedback; } ?>
						<input type="file" name="submitted_image" class="submitted_image" id="submitted_image" required>
					</div>
					<div class="image_div">
						<label class="red_style">Image of All Equipment</label>
						<div id="preview_e">
							<img src="" class="preview_frame" id="preview_equipment_image">
						</div>
						<?php if (isset($feedback)) { echo $feedback; } ?>
						<input type="file" name="submitted_equipment_image" class="submitted_image" id="submitted_equipment_image" required>
					</div>
					<div class="image_div">
						<label class="red_style">Image of All Ingredients</label>
						<div id="preview_i">
							<img src="" class="preview_frame" id="preview_ingredients_image">
						</div>
						<?php if (isset($feedback)) { echo $feedback; } ?>
						<input type="file" name="submitted_ingredients_image" class="submitted_image" id="submitted_ingredients_image" required>
					</div>
					<div class="image_div">
						<label class="red_style">Image of Cooking Action</label>
						<div id="preview_c">
							<img src="" class="preview_frame" id="preview_cooking_image">
						</div>
						<?php if (isset($feedback)) { echo $feedback; } ?>
						<input type="file" name="submitted_cooking_image" class="submitted_image" id="submitted_cooking_image" required>
					</div>
				</div>
				
				
				
				<!-- status/feedback -->
				<div id="status">
				</div>
				
				
				
				<!--submit-->
				<div>
					<button id="submit_button">Submit Recipe</button>
					<!-- <input type="submit" name="submit" id="submit_button" value="Submit Recipe"> --> <!-- maybe change this -->
				</div>
			</div>
		</div>
	</main>
<script>
/*
Script Contents

Functions:

1.  cmsSubmitRecipeActionOne(e)
2.  previewImage()
3.  previewEImage()
4.  previewIImage()
5.  previewCImage()
6.  populateIngredientUnitsAndTypes()
7.  populateRecipeUnitsAndTypes()
8.  matchEquipmentToType(e)
9.  matchIngredientToType(e)
10. getJSON(url, callback)
11. postJSON
12. constructEquipmentRow(xhttp)
13. activateEquipmentRow()
14. prepareEquipmentRow(e)
15. constructIngredientRow(xhttp)
16. activateIngredientRow()
17. prepareIngredientRow(e)
18. constructSubrecipeRow(xhttp)
19. activateSubrecipeRow()
20. prepareSubrecipeRow(e)
21. liveSearch(str)
22. addStepRow(e)
23. removeEquipmentRow(e)
24. removeIngredientRow(e)
25. removeSubrecipeRow(e)
26. removeStepRow(e)
27. postToServerSide(e)

Function #1 is called on window load.

*/

// 1.
function cmsSubmitRecipeActionOne(e) {
	
	var image = document.getElementById("submitted_image");
	var eImage = document.getElementById("submitted_equipment_image");
	var iImage = document.getElementById("submitted_ingredients_image");
	var cImage = document.getElementById("submitted_cooking_image");
	
	var selectEquipmentType = document.getElementsByClassName('select_equipment_type');
	var selectIngredientType = document.getElementsByClassName('select_ingredient_type');
	var addEquipmentButton = document.getElementById('add_equipment_button');
	var addIngredientButton = document.getElementById('add_ingredient_button');
	var addStepButton = document.getElementById('add_step_button');
	var removeEquipmentRowButtons = document.getElementsByClassName('remove_equipment_row_button');
	var removeIngredientRowButtons = document.getElementsByClassName('remove_ingredient_row_button');
	var removeSubrecipeRowButtons = document.getElementsByClassName('remove_subrecipe_row_button');
	var removeStepRowButtons = document.getElementsByClassName('remove_step_row_button');
	var submitButton = document.getElementById("submit_button");
	
	image.addEventListener('change', previewImage, false);
	eImage.addEventListener('change', previewEImage, false);
	iImage.addEventListener('change', previewIImage, false);
	cImage.addEventListener('change', previewCImage, false);
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
	for (var i = 0; i < removeSubrecipeRowButtons.length; i++) {
		removeSubrecipeRowButtons[i].className += " has_remove";
		removeSubrecipeRowButtons[i].addEventListener('click', function(e) { removeSubrecipeRow(e); }, false);
	}
	for (var i = 0; i < removeStepRowButtons.length; i++) { removeStepRowButtons[i].addEventListener('click', function(e) { removeStepRow(e); }, false); }
	populateIngredientUnitsAndTypes();
	submitButton.addEventListener('click', function(e) { postToServerSide(e); }, false);
	
}



// 2.
function previewImage() {
    var reader = new FileReader();
    reader.onload = function(e) {
		var image = new Image();
		image.src = e.target.result;
		image.onload = function() {
			var width = this.width;
			var height = this.height;
			if ((width != 480) || (height != 320)) {
				alert("Image dimensions must be 480 pixels wide and 320 pixels high.");
				document.getElementById("preview_image").src = "";
			} else {
				document.getElementById("preview_image").src = e.target.result;
				
			}
		}
	}
	reader.readAsDataURL(this.files[0]);
}



// 3.
function previewEImage() {
    var reader = new FileReader();
    reader.onload = function (e) {
		var image = new Image();
		image.src = e.target.result;
		image.onload = function() {
			var width = this.width;
			var height = this.height;
			if ((width != 480) || (height != 320)) {
				alert("Equipment image dimensions must be 480 pixels wide and 320 pixels high.");
				document.getElementById("preview_equipment_image").src = "";
			} else {
				document.getElementById("preview_equipment_image").src = e.target.result;
			}
		}
	}
	reader.readAsDataURL(this.files[0]);
}



// 4.
function previewIImage() {
    var reader = new FileReader();
    reader.onload = function (e) {
		var image = new Image();
		image.src = e.target.result;
		image.onload = function() {
			var width = this.width;
			var height = this.height;
			if ((width != 480) || (height != 320)) {
				alert("Ingredients image dimensions must be 480 pixels wide and 320 pixels high.");
				document.getElementById("preview_ingredients_image").src = "";
			} else {
				document.getElementById("preview_ingredients_image").src = e.target.result;
			}
		}
	}
	reader.readAsDataURL(this.files[0]);
}



// 5.
function previewCImage() {
    var reader = new FileReader();
    reader.onload = function (e) {
		var image = new Image();
		image.src = e.target.result;
		image.onload = function() {
			var width = this.width;
			var height = this.height;
			if ((width != 480) || (height != 320)) {
				alert("Cooking image dimensions must be 480 pixels wide and 320 pixels high.");
				document.getElementById("preview_cooking_image").src = "";
			} else {
				document.getElementById("preview_cooking_image").src = e.target.result;
			}
		}
	}
	reader.readAsDataURL(this.files[0]);
}



// 6.
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



// 7.
function populateRecipeUnitsAndTypes() {
	var container = document.getElementById("subrecipe_rows_container");
	var selectSubUnits = container.getElementsByClassName("select_unit_sub");
	var selectSubrecipeTypes = container.getElementsByClassName("select_subrecipe_type");
	var unitOptionValues = <?php echo json_encode(array_keys($allMeasurements)) ?>;
	var unitOptionText = <?php echo json_encode(array_values($allMeasurements)) ?>;
	var subrecipeTypeOptionValues = <?php echo json_encode(array_keys($allSubrecipeTypes)) ?>;
	var subrecipeTypeOptionText = <?php echo json_encode(array_values($allSubrecipeTypes)) ?>;
	
	for (var i = 0; i < selectSubUnits.length; i++) {
		var list = selectSubUnits[i];
		if ((list.classList.contains('populated')) !== true) {
			list.className += " populated";
			list.innerHTML = "";
			var emptyOption = document.createElement("option");
			selectSubUnits[i].options.add(emptyOption);
			for (var j = 0; j < unitOptionValues.length; j++) {
				var newOption = document.createElement("option");
				newOption.value = unitOptionValues[j];
				newOption.innerHTML = unitOptionText[j];
				selectSubUnits[i].options.add(newOption);
			}
		}
	}
	
	for (var i = 0; i < selectSubrecipeTypes.length; i++) {
		var list = selectSubrecipeTypes[i];
		if ((list.classList.contains('populated')) !== true) {
			list.className += " populated";
			list.innerHTML = "";
			var emptyOption = document.createElement("option");
			selectSubrecipeTypes[i].options.add(emptyOption);
			for (var j = 0; j < ingredientTypeOptionValues.length; j++) {
				var newOption = document.createElement("option");
				newOption.value = subrecipeTypeOptionValues[j];
				newOption.innerHTML = subrecipeTypeOptionText[j];
				selectSubrecipeTypes[i].options.add(newOption);
			}
		}
	}
}



// 8.
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



// 9.
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



// 10.
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



// 11.
function postJSON(data) {
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "", true);
	xhttp.send(data);
}



// 12.
function constructEquipmentRow(xhttp) {
	var equipmentDiv = document.getElementById('equipment_rows_container');
	equipmentDiv.insertAdjacentHTML('beforeend', xhttp.responseText);
}



// 13.
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



// 14.
function prepareEquipmentRow(e) {
	getJSON('recipes/new_equipment_row.php', constructEquipmentRow);
	setTimeout(function() { activateEquipmentRow(); }, 500);  // horrible practice? ... it works for now at least
	e.preventDefault();
	e.stopPropagation();
}



// 15.
function constructIngredientRow(xhttp) {
	var ingredientDiv = document.getElementById('ingredient_rows_container');
	ingredientDiv.insertAdjacentHTML('beforeend', xhttp.responseText);
}



// 16.
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



// 17.
function prepareIngredientRow(e) {
	getJSON('recipes/new_ingredient_row.php', constructIngredientRow);
	setTimeout(function() { activateIngredientRow(); }, 400);  // horrible practice... it works for now at least
	setTimeout(function() { populateIngredientUnitsAndTypes(); }, 500);  // horrible practice... it works for now at least
	e.preventDefault();
	e.stopPropagation();
}



// 18.
function constructSubrecipeRow(xhttp) {
	var subrecipeDiv = document.getElementById('subrecipe_rows_container');
	subrecipeDiv.insertAdjacentHTML('beforeend', xhttp.responseText);
}



// 19.
function activateSubrecipeRow() {
	var subrecipeDiv = document.getElementById('subrecipe_rows_container');
	var selectSubrecipeType = subrecipeDiv.getElementsByClassName('select_subrecipe_type');
	var removeSubrecipeRowButtons = subrecipeDiv.getElementsByClassName('remove_subrecipe_row_button');
	// activate recipe type filter
	for (var i = 0; i < selectSubrecipeType.length; i++) {
		var typeColumn = selectSubrecipeType[i];
		if ((typeColumn.classList.contains('has_match')) !== true) {
			typeColumn.className += " has_match";
			typeColumn.addEventListener('change', function(e) { matchSubrecipeToType(e); }, false);
		}
	}
	// activate row removability
	for (var i = 0; i < removeSubrecipeRowButtons.length; i++) {
		var button = removeSubrecipeRowButtons[i];
		if ((button.classList.contains('has_remove')) !== true) {
			button.className += " has_remove";
			button.addEventListener('click', function(e) { removeSubrecipeRow(e); }, false);
		}
	}
}



// 20.
function prepareSubrecipeRow(e) {
	getJSON('recipes/new_subrecipe_row.php', constructSubrecipeRow);
	setTimeout(function() { activateSubrecipeRow(); }, 400);  // horrible practice... it works for now at least
	setTimeout(function() { populateRecipeUnitsAndTypes(); }, 500);  // horrible practice... it works for now at least
	e.preventDefault();
	e.stopPropagation();
}



// 21.
function liveSearch(str) {
	if (str.length == 0) {
		document.getElementById("livesearch").innerHTML="";
		document.getElementById("livesearch").style.border="0px";
		return;
	}
	
	xhttp=new XMLHttpRequest();
	xhttp.onreadystatechange=function() {
		if (this.readyState == 4 && this.status == 200) {
		  document.getElementById("livesearch").innerHTML = this.responseText;
		  document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
		}
	}
	xhttp.open("GET","live_search.php?q=" + str, true);
	xhttp.send();
}



// 22.
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
	nSR3.setAttribute("class", "manual_step");
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



// 23.
function removeEquipmentRow(e) {
	var clicked = e.target;
	var divToRemove = clicked.parentNode;
	var stepsDiv = document.getElementById('equipment_rows_container');
	
	stepsDiv.removeChild(divToRemove);
	e.preventDefault();
	e.stopPropagation();
}



// 24.
function removeIngredientRow(e) {
	var clicked = e.target;
	var divToRemove = clicked.parentNode;
	var stepsDiv = document.getElementById('ingredient_rows_container');
	
	stepsDiv.removeChild(divToRemove);
	e.preventDefault();
	e.stopPropagation();
}



// 25.
function removeSubrecipeRow(e) {
	var clicked = e.target;
	var divToRemove = clicked.parentNode;
	var stepsDiv = document.getElementById('subrecipe_rows_container');
	
	stepsDiv.removeChild(divToRemove);
	e.preventDefault();
	e.stopPropagation();
}



// 26.
function removeStepRow(e) {
	var clicked = e.target;
	var divToRemove = clicked.parentNode;
	var stepsDiv = document.getElementById('steps_div');
	
	stepsDiv.removeChild(divToRemove);
	e.preventDefault();
	e.stopPropagation();
}



// 27.
function postToServerSide(e) {
	
	// validate this with an if statement? (duh)
	
	// 1. prepare equipment amounts
	var getSelectAmounts = document.getElementsByClassName("select_amount");
	var selectAmounts = [];
	for (var i = 0; i < getSelectAmounts.length; i++) {
		selectAmounts[i] = getSelectAmounts[i].options[getSelectAmounts[i].selectedIndex].value;
	}
	// 2. prepare equipment ids
	var getSelectEquipment = document.getElementsByClassName("select_equipment");
	var selectEquipment = [];
	for (var i = 0; i < getSelectEquipment.length; i++) {
		selectEquipment[i] = getSelectEquipment[i].options[getSelectEquipment[i].selectedIndex].value;
	}
	
	// 3. prepare ingredient amounts
	var getManualAmounts = document.getElementsByClassName("manual_amount");
	var manualAmounts = [];
	for (var i = 0; i < getManualAmounts.length; i++) {
		manualAmounts[i] = getManualAmounts[i].value;
	}
	// 4. prepare measurement ids
	var getSelectUnits = document.getElementsByClassName("select_unit");
	var selectUnits = [];
	for (var i = 0; i < getSelectUnits.length; i++) {
		selectUnits[i] = getSelectUnits[i].options[getSelectUnits[i].selectedIndex].value;
	}
	// 5. prepare ingredient ids
	var getSelectIngredients = document.getElementsByClassName("select_ingredient");
	var selectIngredients = [];
	for (var i = 0; i < getSelectIngredients.length; i++) {
		selectIngredients[i] = getSelectIngredients[i].options[getSelectIngredients[i].selectedIndex].value;
	}
	
	// 6. prepare step texts
	var getManualSteps = document.getElementsByClassName("manual_step");
	var manualSteps = [];
	var delimiter = "@#$%^";
	for (var i = 0; i < getManualSteps.length; i++) {
		manualSteps.push(getManualSteps[i].value + delimiter);
	}
	
	// 7. prepare recipe type id
	var getRecipeTypeID = document.getElementById("recipe_type_id")
	var recipeTypeID = getRecipeTypeID.options[getRecipeTypeID.selectedIndex].value;
	// 8. prepare cuisine id
	var getCuisineID = document.getElementById("cuisine_id")
	var cuisineID = getCuisineID.options[getCuisineID.selectedIndex].value;
	// 9. prepare recipe title
	var recipeTitle = document.getElementById("recipe_title").value;
	// 10. prepare recipe description
	var recipeDescription = document.getElementById("recipe_description").value;
	
	// 11. prepare uploaded image files
	var mainImage = document.getElementById("submitted_image").files[0];
	var equipmentImage = document.getElementById("submitted_equipment_image").files[0];
	var ingredientsImage = document.getElementById("submitted_ingredients_image").files[0];
	var cookingImage = document.getElementById("submitted_cooking_image").files[0];
	
	
	// append prepared items to a FormData object
	var fdata = new FormData();
	
	fdata.append("select_amounts", selectAmounts);                 // 1.
	fdata.append("select_equipment", selectEquipment);             // 2.
	
	fdata.append("manual_amounts", manualAmounts);                 // 3.
	fdata.append("select_units", selectUnits);                     // 4.
	fdata.append("select_ingredients", selectIngredients);         // 5.
	
	fdata.append("manual_steps", manualSteps);                     // 6.
	
	fdata.append("recipe_type_id", recipeTypeID);                  // 7.
	fdata.append("cuisine_id", cuisineID);                         // 8.
	fdata.append("recipe_title", recipeTitle);                     // 9.
	fdata.append("recipe_description", recipeDescription);         // 10.
	
	fdata.append("submitted_image", mainImage);                    // 11.
	fdata.append("submitted_equipment_image", equipmentImage);     // 11.
	fdata.append("submitted_ingredients_image", ingredientsImage); // 11.
	fdata.append("submitted_cooking_image", cookingImage);         // 11.
	
	
	// POST FormData object to server (These need some sort of status, success, and error feedback)
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "process_recipe.php");
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			var status = document.getElementById("status");
			status.innerHTML = xhttp.responseText;
		}
	}
	xhttp.send(fdata);
	
	
	e.preventDefault();
	e.stopPropagation();
	
}



window.addEventListener("load", function() { cmsSubmitRecipeActionOne(); }, false);



</script>
</body>
</html>