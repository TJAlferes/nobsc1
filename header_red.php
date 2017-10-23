<header>
	<div id="header_row_1">
		<div id="header_row_1_col_1">
			<a id="logo_link" href="http://nobullshitcooking.com">
				<img id="logo_img" src="images/master/nobsc-logo-alt-slim.png">
			</a>
		</div>
		<div id="header_row_1_col_2">
			<form name="search_form" id="search_form" accept-charset="utf-8" method="get" action="nobsc_transact_search.php">
				<div id="search_left">
					<div id="search_category">
						<div id="search_facade">
							<span id="facade_text">All</span>
							<img id="facade_arrow" src="images/master/down-arrow-gray.png">
						</div>
						<select name="search_prefilter" id="search_prefilter" type="select-one" onchange="swapFacadeText()">
							<option id="search_all" value="search-filter-none">All</option>
							<option id="search_recipes" value="search-filter-recipes">Recipes</option>
							<option id="search_ingredients" value="search-filter-ingredients">Ingredients</option>
							<option id="search_nutrients" value="search-filter-nutrients">Nutrients</option>
							<option id="search_kitchen_equipment" value="search-filter-kitchen-equipment">Kitchen Equipment</option>
							<option id="search_fitness_gear" value="search-filter-fitness-gear">Fitness Gear</option>
							<option id="search_exercises" value="search-filter-exercises">Exercises</option>
						</select>
					</div>
				</div>
				<div id="search_insert">
					<input id="search_insert_input" type="text" autocomplete="off">
				</div>
				<div id="search_execute">
					<input id="search_execute_input" type="submit" value="Search">
				</div>
			</form>
		</div>
		<div id="header_row_1_col_3">
			<img src="images/master/promotions/nobsc-header-announcement-05-03-17.png">
		</div>
	</div>
	<div id="header_row_2">
		<div id="header_row_2_col_1">
			<ul id="site_nav">
				<li><a href="nobsc_food.php" class="fancy_food_toggle" id="fancy_food_button">Food</a></li>
				<li><a href="nobsc_fitness.php">Fitness</a></li>
				<li><a href="nobsc_supply.php">Supply</a></li>
				<li><a href="nobsc_dashboard.php">Member Area</a></li>
			</ul>
		</div>
		<div id="header_row_2_col_2">
		</div>
		<div id="header_row_2_col_3">
			<ul id="user_nav">
				<li><a href="nobsc_help.php">Help</a></li>
				<li><a href="nobsc_registration.php">Create Account</a></li>
				<li><a href="nobsc_sign_in.php">Sign In</a></li>
				<li><a href="nobsc_view_cart.php">View Cart</a></li>
			</ul>
		</div>
	</div>
</header>