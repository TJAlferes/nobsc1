<?php

header("Content-type: application/json");

if (isset($_POST['allEquipmentDataJ'])) {
	$allEquipmentData = json_decode($_POST['allEquipmentDataJ']);
	$allPreparingEquipment = allEquipmentData[0];
	$allCookingEquipment = allEquipmentData[1];
}

?>
<label>Amount:</label>
<select required>
	<option></option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
</select>
<label>Type:</label> <!-- remember, this is just a filter to help them select the equipment -->
<select required> <!-- onchange, the Equipment select list below should have its options updated -->
	<option></option>
	<option value="1">Preparing</option>
	<option value="2">Cooking</option>
</select>
<label>Equipment:</label>
<select required>
	<option></option>
	<?php
	echo '<option value="test">Test</option>';
	?>
	<!-- these get dynamically updated based on the selected type above -->
	<?php
	if (/*value 1 is selected*/) {
		echo '<option value="' . $allPreparingEquipment[0] . '">' . $allPreparingEquipment[1] . '</option>';
	}
	
	if (/*value 2 is selected*/) {
		echo '<option value="' . $allCookingEquipment[0] . '">' . $allCookingEquipment[1] . '</option>';
	}
	?>
</select>
<button class="remove_row_button">Remove</button>