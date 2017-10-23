<?php

require 'starter.php';



// >>>>>>>>>>>>>>>>>>>> start pagination logic
// set number of recipes to list per page
$display = 25;



if (!isset($checkedTypes)) {
	$checkedTypes = [];
	$sql = 'SELECT recipe_type_id FROM nobsc_recipe_types';
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	while (($row = $stmt->fetch()) !== false) {
		if (isset($_GET['rtid' . $row['recipe_type_id']])) {
			$checkedTypes[] = $row['recipe_type_id'];
		}
	}
}
$checkedTypesList = implode(", ", $checkedTypes);



if (!isset($checkedCuisines)) {
	$checkedCuisines = [];
	$sql = 'SELECT cuisine_id FROM nobsc_cuisines';
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	while (($row = $stmt->fetch()) !== false) {
		if (isset($_GET['cid' . $row['cuisine_id']])) {
			$checkedCuisines[] = $row['cuisine_id'];
		}
	}
}
$checkedCuisinesList = implode(", ", $checkedCuisines);



// determine how many total pages of recipes there are without and with filters
if (isset($_GET['p']) && is_numeric($_GET['p'])) {
	$pages = $_GET['p'];
} else {
	// count recipes, by selected type(s) if any
	if (count($checkedTypes) > 1) {
		$in  = str_repeat('?, ', count($checkedTypes) - 1) . '?';
		$sql = 'SELECT COUNT(*) FROM nobsc_recipes WHERE recipe_type_id IN (' . $in . ')';
		$stmt = $conn->prepare($sql);
		$stmt->execute($checkedTypes);
		$records1 = $stmt->fetchColumn();
		
	} elseif (count($checkedTypes) == 1) {
		$sql = 'SELECT COUNT(*) FROM nobsc_recipes WHERE recipe_type_id = ?';
		$stmt = $conn->prepare($sql);
		$stmt->execute($checkedTypes);
		$records1 = $stmt->fetchColumn();
		
	} elseif (count($checkedTypes) == 0) {
		$sql = "SELECT COUNT(*) FROM nobsc_recipes";
		$stmt = $conn->query($sql);
		$records1 = $stmt->fetchColumn();
	}
	
	// count recipes, by selected cuisine(s) if any
	if (count($checkedCuisines) > 1) {
		$in  = str_repeat('?, ', count($checkedCuisines) - 1) . '?';
		$sql = 'SELECT COUNT(*) FROM nobsc_recipes WHERE cuisine_id IN (' . $in . ')';
		$stmt = $conn->prepare($sql);
		$stmt->execute($checkedCuisines);
		$records2 = $stmt->fetchColumn();
		
	} elseif (count($checkedCuisines) == 1) {
		$sql = 'SELECT COUNT(*) FROM nobsc_recipes WHERE cuisine_id = ?';
		$stmt = $conn->prepare($sql);
		$stmt->execute($checkedCuisines);
		$records2 = $stmt->fetchColumn();
		
	} elseif (count($checkedCuisines) == 0) {
		$sql = "SELECT COUNT(*) FROM nobsc_recipes";
		$stmt = $conn->query($sql);
		$records2 = $stmt->fetchColumn();
	}
	
	$records = ($records1 + $records2);
	
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
	<link href="css/recipes.css" rel="stylesheet">
	<link href="css/footer_gray.css" rel="stylesheet">
</head>
<body>



	<?php include 'header_red.php'; ?>
	
	
	
	<main>
		<?php include 'food_drop.php'; ?>
		<div id="page">
		
		
		
			<div id="page_col_left">
			
			
				
				<div id="list_header"><h1>No Bullshit Cooking Recipes</h1></div>

				
				
				<!-- filter display -->
				<div id="filters">
					<form id="itid" name="itid" method="GET">
						<span id="filter_title"><b>Filter by:</b></span>
						<div>
							<?php
							$sql = 'SELECT cuisine_id, cuisine FROM nobsc_cuisines';
							$stmt = $conn->prepare($sql);
							$stmt->execute();
							
							// create cuisine filter UI
							echo '<p class="filter_type"><b>Cuisine</b></p>';
							while (($row = $stmt->fetch()) !== false) {
								$optionHtml = '<span class="filter_span"><input type="checkbox" ';
								if (isset($_GET['cid' . $row['cuisine_id']]) && ($_GET['cid' . $row['cuisine_id']] == $row['cuisine_id'])) { $optionHtml .= 'checked '; }
								$optionHtml .= 'value="' . $row['cuisine_id'] . '" name="cid' . $row['cuisine_id'] . '">';
								$optionHtml .= '<label class="filter_label" for="' . $row['cuisine_id'] . '">' . $row['cuisine'] . '</label></span>';
								echo $optionHtml;
							}
							
							$sql = 'SELECT recipe_type_id, recipe_type_name FROM nobsc_recipe_types';
							$stmt = $conn->prepare($sql);
							$stmt->execute();
							
							// create recipe type filter UI
							echo '<p class="filter_type"><b>Recipe type</b></p>';
							while (($row = $stmt->fetch()) !== false) {
								$optionHtml = '<span class="filter_span"><input type="checkbox" ';
								if (isset($_GET['rtid' . $row['recipe_type_id']]) && ($_GET['rtid' . $row['recipe_type_id']] == $row['recipe_type_id'])) { $optionHtml .= 'checked '; }
								$optionHtml .= 'value="' . $row['recipe_type_id'] . '" name="rtid' . $row['recipe_type_id'] . '">';
								$optionHtml .= '<label class="filter_label" for="' . $row['recipe_type_id'] . '">' . $row['recipe_type_name'] . '</label></span>';
								echo $optionHtml;
							}
							
							
							
							// >>>>>>>>>>>>>>>>>>>> start filter logic
							// 1
							if (count($checkedTypes) > 1) {  // return multiple checked recipe types (filter)
								$inNamed = "";
								$parameters = [];
								foreach ($checkedTypes as $j => $chTy) {
									$key = ':id' . $j;
									$inNamed .= "$key, ";
									$parameters[$key] = $chTy;
								}
								$inNamed = rtrim($inNamed, ", ");
								
								// if cuisine(s)
								if (count($checkedCuisines) > 1) {  // return multiple checked cuisines (filter)
									$inNamedC = "";
									$parametersC = [];
									foreach ($checkedCuisines as $jC => $chCu) {
										$keyC = ':id' . $jC;
										$inNamedC .= "$keyC, ";
										$parametersC[$keyC] = $chCu;
									}
									$inNamedC = rtrim($inNamedC, ", ");
								} elseif (count($checkedCuisines) == 1) {  // return single checked cuisine (filter)
									$cuisineID = $checkedCuisinesList;
								}
								
								$sql = 'SELECT recipe_id, recipe_name, recipe_type_id, recipe_image
										FROM nobsc_recipes
										WHERE recipe_type_id IN (' . $inNamed . ')';
								
								if (count($checkedCuisines) > 1) {  // multiple checked cuisines
									$sql .= 'AND cuisine_id IN (' . $inNamedC . ')';
								} elseif (count($checkedCuisines) == 1) {
									$sql .= 'AND cuisine_id = :cuisineID';
								}
								
								$sql .= 'ORDER BY recipe_name ASC
										 LIMIT :start, :display';
										 
								$stmt = $conn->prepare($sql);
								
								foreach ($parameters as $k => $chType) {
									$stmt->bindValue($k, $chType);
								}
								
								// if cuisine(s)
								if (count($checkedCuisines) > 1) {
									foreach ($parametersC as $kC => $chCu) {
									$stmt->bindValue($kC, $chCuis);
									}
								} elseif (count($checkedCuisines) == 1) {
									$stmt->bindValue(':cuisineID', $cuisineID);
								}
								
								$stmt->bindValue(':start', $start, PDO::PARAM_INT);
								$stmt->bindValue(':display', $display, PDO::PARAM_INT);
								$stmt->execute();
								
								
							// 2
							} elseif (count($checkedTypes) == 1) {  // return single checked recipe type (filter)
								$recipeTypeID = $checkedTypesList;
								$sql = "SELECT recipe_id, recipe_name, recipe_type_id, recipe_image
									FROM nobsc_recipes
									WHERE recipe_type_id = :recipeTypeID
									ORDER BY recipe_name ASC
									LIMIT :start, :display";
								$stmt = $conn->prepare($sql);
								$stmt->execute([':recipeTypeID' => $recipeTypeID, ':start' => $start, ':display' => $display]);  // ........... TO DO: change everything to bindValue
								
								
							// 3
							} elseif (count($checkedTypes) == 0) {  // return all recipe types (no filter)
								$sql = "SELECT recipe_id, recipe_title, recipe_type_id, recipe_image
										FROM nobsc_recipes
										ORDER BY recipe_title ASC
										LIMIT :start, :display";
								$stmt = $conn->prepare($sql);
								$stmt->execute([':start' => $start, ':display' => $display]);  // ........... TO DO: change everything to bindValue
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
							echo '<a class="page_nav" href="recipes.php?' . $checkedTypesString . '&s=' . ($start - $display) . '&p=' . $pages . '">Prev</a>';
						}
						for ($i = 1; $i <= $pages; $i++) {
							if ($i != $currentPage) {
								echo '<a class="page_number" href="recipes.php?' . $checkedTypesString . '&s=' . (($display * ($i - 1))) . '&p=' . $pages . '">' . $i . '</a>';
							} else {
								echo '<a class="current_page_number" href="#">' . $i . '</a>';
							}
						}
						if ($currentPage != $pages) {
							echo '<a class="page_nav" href="recipes.php?' . $checkedTypesString . '&s=' . ($start + $display) . '&p=' . $pages . '">Next</a>';
						}
						echo '</span>';
					}
					?>
				</div>
				
				
				
				<!-- list display -->
				<div id="list">
					<?php
					// create list of appropriate recipes
					foreach ($stmt as $row) {
						echo '<div><a href="view_recipe.php?recipe_id=' . $row['recipe_id'] . '"><div><span>' . $row['recipe_title'] . '</span></div><img class="list_image" src="images/recipes/thumbnails/tn_' . $row['recipe_image'] . '.jpg"></a></div>';
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
							echo '<a class="page_nav" "href="recipes.php?' . $checkedTypesString . '&s=' . ($start - $display) . '&p=' . $pages . '">Prev</a>';
						}
						for ($i = 1; $i <= $pages; $i++) {
							if ($i != $currentPage) {
								echo '<a class="page_number" href="recipes.php?' . $checkedTypesString . '&s=' . (($display * ($i - 1))) . '&p=' . $pages . '">' . $i . '</a>';
							} else {
								echo '<a class="current_page_number" href="#">' . $i . '</a>';
							}
						}
						if ($currentPage != $pages) {
							echo '<a class="page_nav" href="recipes.php?' . $checkedTypesString . '&s=' . ($start + $display) . '&p=' . $pages . '">Next</a>';
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
	
	<script src="js/nobsc_header_red_scripts.js"></script>
	
	<script>
	// functions to automatically apply filter changes
	function recipesActionOne() {
		var iTID = document.getElementById('itid');
		iTID.addEventListener("change", niceFilter, false);
	}
	function niceFilter() {
		this.submit();
	}
	window.addEventListener("load", recipesActionOne, false);
	</script>
</body>
</html>