<?php

require 'starter.php';



// >>>>>>>>>>>>>>>>>>>> start pagination logic
// set number of ingredients to list per page
$display = 25;



if (!isset($checkedTypes)) {
	$checkedTypes = [];
	$sql = 'SELECT ingredient_type_id FROM nobsc_ingredient_types';
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	while (($row = $stmt->fetch()) !== false) {
		if (isset($_GET['itid' . $row['ingredient_type_id']])) {
			$checkedTypes[] = $row['ingredient_type_id'];
		}
	}
}
$checkedTypesList = implode(", ", $checkedTypes);



// determine how many total pages of ingredients there are without and with filters
if (isset($_GET['p']) && is_numeric($_GET['p'])) {
	$pages = $_GET['p'];
} else {
	// count ingredients, by selected type(s) if any
	if (count($checkedTypes) > 1) {
		$in  = str_repeat('?, ', count($checkedTypes) - 1) . '?';
		$sql = 'SELECT COUNT(*) FROM nobsc_ingredients WHERE ingredient_type_id IN (' . $in . ')';
		$stmt = $conn->prepare($sql);
		$stmt->execute($checkedTypes);
		$records = $stmt->fetchColumn();
		
	} elseif (count($checkedTypes) == 1) {
		$sql = 'SELECT COUNT(*) FROM nobsc_ingredients WHERE ingredient_type_id = ?';
		$stmt = $conn->prepare($sql);
		$stmt->execute($checkedTypes);
		$records = $stmt->fetchColumn();
		
	} elseif (count($checkedTypes) == 0) {
		$sql = "SELECT COUNT(*) FROM nobsc_ingredients";
		$stmt = $conn->query($sql);
		$records = $stmt->fetchColumn();
	}
	
	if ($records > $display) {
		$pages = ceil($records / $display);
	} else {
		$pages = 1;
	}
}



if (isset($_GET['s']) && is_numeric($_GET['s'])) {
	$start = $_GET['s'];
} else {
	$start = 0;
}
// >>>>>>>>>>>>>>>>>>>> end pagination logic

?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>COOK EAT WIN REPEAT</title>
	<link href="images/master/nobsc-favicon-us.png" rel="shortcut icon">
	<link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
	<link href="css/primary.css" rel="stylesheet">
	<link href="css/header_red.css" rel="stylesheet">
	<link href="css/ingredients.css" rel="stylesheet">
	<link href="css/footer_gray.css" rel="stylesheet">
</head>
<body>



	<?php include 'header_red.php'; ?>
	
	
	
	<main>
		<div id="search_auto_suggestions_shadow"></div>
		<?php include 'food_drop.php'; ?>
		<div id="page">
		
		
		
			<div id="page_col_left">
			
			
				
				<div id="list_header"><h1>No Bullshit Cooking Ingredients</h1></div>

				
				
				<!-- filter display -->
				<div id="filters">
					<form id="itid" name="itid" method="GET">
						<span id="filter_title"><b>Filter by:</b></span>
						<div>
							<?php
							
							$sql = 'SELECT ingredient_type_id, ingredient_type_name FROM nobsc_ingredient_types';
							$stmt = $conn->prepare($sql);
							$stmt->execute();
							
							// create ingredient type filter UI
							echo '<p class="filter_type"><b>Ingredient type</b></p>';
							while (($row = $stmt->fetch()) !== false) {
								$optionHtml = '<span class="filter_span"><input type="checkbox" ';
								if (isset($_GET['itid' . $row['ingredient_type_id']]) && ($_GET['itid' . $row['ingredient_type_id']] == $row['ingredient_type_id'])) { $optionHtml .= 'checked '; }
								$optionHtml .= 'value="' . $row['ingredient_type_id'] . '" name="itid' . $row['ingredient_type_id'] . '">';
								$optionHtml .= '<label class="filter_label" for="' . $row['ingredient_type_id'] . '">' . $row['ingredient_type_name'] . '</label></span>';
								echo $optionHtml;
							}
							
							
							
							// >>>>>>>>>>>>>>>>>>>> start filter logic
							if (count($checkedTypes) > 1) {  // return multiple checked ingredient types (filter)
								$inNamed = "";
								$parameters = [];
								foreach ($checkedTypes as $j => $chTy) {
									$key = ":id" . $j;
									$inNamed .= "$key, ";
									$parameters[$key] = $chTy;
								}
								$inNamedSet = rtrim($inNamed, ", ");
								
								$sql = "SELECT ingredient_id, ingredient_name, ingredient_type_id, ingredient_image
									FROM nobsc_ingredients
									WHERE ingredient_type_id IN (" . $inNamedSet . ")
									ORDER BY ingredient_name ASC
									LIMIT :start, :display";
								$stmt = $conn->prepare($sql);
								foreach ($parameters as $k => $chType) {
									$stmt->bindValue($k, $chType);
								}
								$stmt->bindValue(':start', $start, PDO::PARAM_INT);
								$stmt->bindValue(':display', $display, PDO::PARAM_INT);
								$stmt->execute();
								
								
							} elseif (count($checkedTypes) == 1) {  // return single checked ingredient type (filter)
								$ingredientTypeID = $checkedTypesList;
								$sql = "SELECT ingredient_id, ingredient_name, ingredient_type_id, ingredient_image
									FROM nobsc_ingredients
									WHERE ingredient_type_id = :ingredientTypeID
									ORDER BY ingredient_name ASC
									LIMIT :start, :display";
								$stmt = $conn->prepare($sql);
								$stmt->execute([':ingredientTypeID' => $ingredientTypeID, ':start' => $start, ':display' => $display]);
								
								
							} elseif (count($checkedTypes) == 0) {  // return all ingredient types (no filter)
								$sql = "SELECT ingredient_id, ingredient_name, ingredient_type_id, ingredient_image
										FROM nobsc_ingredients
										ORDER BY ingredient_name ASC
										LIMIT :start, :display";
								$stmt = $conn->prepare($sql);
								$stmt->execute([':start' => $start, ':display' => $display]);
							}
							// >>>>>>>>>>>>>>>>>>>> end filter logic
							
							?>
						</div>
						<button type="submit" style="display: none;">
					</form>
				</div>
				
				
				
				<!-- sort display -->
				<div id="sorters">
					<span id="sort_title"><b>Sort by:</b></span>
					<a href="">Name</a>
				</div>
				
				
				
				<!-- pagination display top -->
				<div class="page_links">
					<?php
					if ($pages > 1) {
						
						
						
						// >>>>>>>>>>>>>>>>>>>> start pagination logic modification
						if (isset($_GET)) {
							$checkedTypesBuild = '';
							foreach ($_GET as $cTBkey => $cTBvalue) {
								if (($cTBkey != "s") && ($cTBkey != "p")) {
									$checkedTypesBuild .= '&' . $cTBkey . '=' . $cTBvalue;
								}
							}
							$checkedTypesString = substr($checkedTypesBuild, 1);
						}
						// >>>>>>>>>>>>>>>>>>>> end pagination logic modification
						
						
						
						// create pagination at top of list
						$currentPage = ($start / $display) + 1;
						echo '<span class="page_numbers">';
						if ($currentPage != 1) {
							echo '<a class="page_nav" href="ingredients.php?' . $checkedTypesString . '&s=' . ($start - $display) . '&p=' . $pages . '">Prev</a>';
						}
						for ($i = 1; $i <= $pages; $i++) {
							if ($i != $currentPage) {
								echo '<a class="page_number" href="ingredients.php?' . $checkedTypesString . '&s=' . (($display * ($i - 1))) . '&p=' . $pages . '">' . $i . '</a>';
							} else {
								echo '<a class="current_page_number" href="#">' . $i . '</a>';
							}
						}
						if ($currentPage != $pages) {
							echo '<a class="page_nav" href="ingredients.php?' . $checkedTypesString . '&s=' . ($start + $display) . '&p=' . $pages . '">Next</a>';
						}
						echo '</span>';
					}
					?>
				</div>
				
				
				
				<!-- list display -->
				<div id="list">
					<?php
					// create list of appropriate ingredients
					foreach ($stmt as $row) {
						echo '<div><a href="view_ingredient.php?ingredient_id=' . $row['ingredient_id'] . '"><div><span>' . $row['ingredient_name'] . '</span></div><img class="list_image" src="images/ingredients/thumbnails/tn_' . $row['ingredient_image'] . '.jpg"></a></div>';
					}
					?>
				</div>
				
				
				
				<!-- pagination display bottom -->
				<div class="page_links">
					<?php
					if ($pages > 1) {
						// create pagination at bottom of list
						$currentPage = ($start / $display) + 1;
						echo '<span class="page_numbers">';
						if ($currentPage != 1) {
							echo '<a class="page_nav" "href="ingredients.php?' . $checkedTypesString . '&s=' . ($start - $display) . '&p=' . $pages . '">Prev</a>';
						}
						for ($i = 1; $i <= $pages; $i++) {
							if ($i != $currentPage) {
								echo '<a class="page_number" href="ingredients.php?' . $checkedTypesString . '&s=' . (($display * ($i - 1))) . '&p=' . $pages . '">' . $i . '</a>';
							} else {
								echo '<a class="current_page_number" href="#">' . $i . '</a>';
							}
						}
						if ($currentPage != $pages) {
							echo '<a class="page_nav" href="ingredients.php?' . $checkedTypesString . '&s=' . ($start + $display) . '&p=' . $pages . '">Next</a>';
						}
						echo '</span>';
					}
					?>
				</div>
			</div>
			
			
			
			<div id="page_col_right">
			</div>
			
			
			
		</div>
	</main>
	
	
	
	<?php include 'footer_gray.php'; ?>
	
	
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="js/nobsc_fancy_menu_scripts.js"></script>
<script src="js/nobsc_fancy_menu_plugin.js"></script>
<script src="js/header_red.js"></script>
<script>

function headerRedActionOne() {
	var sInsert = document.getElementById("search_insert_input");
	
	sInsert.addEventListener("input", liveSearchRed, false);
	sInsert.addEventListener("input", liveSearchShow, false);
	document.addEventListener("click", function(e) { liveSearchHide(e); }, false);
}

// functions to automatically apply filter changes
function ingredientsActionOne() {
	var iTID = document.getElementById('itid');
	iTID.addEventListener("change", niceFilter, false);
}
function niceFilter() {
	this.submit();
}

window.addEventListener("load", function() { headerRedActionOne(); }, false);
window.addEventListener("load", ingredientsActionOne, false);

</script>
</body>
</html>