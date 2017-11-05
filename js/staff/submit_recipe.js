function cmsSubmitRecipeActionOne() {
	var imageToSizeCheck = document.getElementsByClassName("submitted_image");
	var addEquipmentButton = document.getElementById('add_equipment_button');
	var addIngredientButton = document.getElementById('add_ingredient_button');
	var addStepButton = document.getElementById('add_step_button');
	var removeRowButtons = document.getElementsByClassName('remove_row_button');
	for (var i = 0; i < imageToSizeCheck.length; i++) { imageToSizeCheck[i].addEventListener('click', function(e) { clientSideEnforceImageSize(e); }, false); }
	addEquipmentButton.addEventListener('click', function(e) { prepareEquipmentRow(e); }, false);
	addIngredientButton.addEventListener('click', function(e) { prepareIngredientRow(e); }, false);
	addStepButton.addEventListener('click', function(e) { addStepRow(e); }, false);
	for (var i = 0; i < removeRowButtons.length; i++) { removeRowButtons[i].addEventListener('click', function(e) { removeRow(e); }, false); }
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
	reader.readAsDataURL(this.files[0]);  // document this
}



function postJSON(url, data) {
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", url, true);
	xhttp.setRequestHeader("Content-Type", "application/json");
	xhttp.send(JSON.stringify(data));
}
function getJSON(url, callback) {
	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", url, true);
	xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && callback) {
			callback(xhttp);
		}
	}
	xhttp.setRequestHeader("Content-Type", "application/json");  // "text/html"?
	xhttp.send();
}



function constructEquipmentRow() {
	var equipmentDiv = document.getElementById('equipment_div');
	var addEquipmentButton = document.getElementById('add_equipment_button');
	var newEquipmentRow = document.createElement("div");
	var newSelectEquipmentType = newEquipmentRow.getElementsByClassName('select_equipment_type');
	
	newEquipmentRow.setAttribute("class", "equipment_row");
	equipmentDiv.insertBefore(newEquipmentRow, addEquipmentButton);
	newEquipmentRow.innerHTML = this.responseText;  // responseXML?
	
	newEquipmentRow.addEventListener('click', function(e) { removeRow(e); }, false);
	newSelectEquipmentType[0].addEventListener('change', function(e) { matchEquipmentToType(e); }, false);
}
function prepareEquipmentRow(e) {
	var allEquipmentDataJ = JSON.parse('<?php echo json_encode($allEquipmentData); ?>');
	postJSON('recipes/new_equipment_row.php', allEquipmentDataJ);
	getJSON('recipes/new_equipment_row.php', constructEquipmentRow);
}



function constructIngredientRow() {
	var ingredientsDiv = document.getElementById('ingredients_div');
	var addIngredientButton = document.getElementById('add_ingredient_button');
	var newIngredientRow = document.createElement("div");
	var newSelectIngredientType = newIngredientRow.getElementsByClassName('select_ingredient_type');
	
	newIngredientRow.setAttribute("class", "ingredient_row");
	ingredientsDiv.insertBefore(newIngredientRow, addIngredientButton);
	newIngredientRow.innerHTML = this.responseText;  // responseXML?
	
	newIngredientRow.addEventListener('click', function(e) { removeRow(e); }, false);
	newSelectIngredientType[0].addEventListener('change', function(e) { matchIngredientToType(e); }, false);
}
function prepareIngredientRow(e) {
	var allIngredientsDataJ = JSON.parse('<?php echo json_encode($allIngredientsData); ?>');
	postJSON('recipes/new_ingredient_row.php', allIngredientsDataJ);
	getJSON('recipes/new_ingredient_row.php', constructIngredientRow);
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
	nSR4.setAttribute("class", "remove_row_button");
	newStepRow.appendChild(nSR2);
	newStepRow.appendChild(nSR3);
	newStepRow.appendChild(nSR4);
	nSR2.appendChild(nSR5);
	nSR4.appendChild(nSR6);
	stepsDiv.insertBefore(newStepRow, addStepButton);
	nSR4.addEventListener('click', function(e) { removeRow(e); }, false);
	e.preventDefault();
	e.stopPropagation();
}



function removeRow(e) {
	var clicked = e.target;
	var divToRemove = clicked.parentNode;
	var stepsDiv = document.getElementById('steps_div');
	stepsDiv.removeChild(divToRemove);
	e.preventDefault();
	e.stopPropagation();
}



window.addEventListener("load", cmsSubmitRecipeActionOne, false);


