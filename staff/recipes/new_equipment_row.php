<div class="equipment_row"> <!-- this div needs a dynamically generated id, the question is when -->
	<label>Amount:</label>
	<select>
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
	</select>
	<label>Type:</label> <!-- remember, this is just a filter to help them select the equipment -->
	<select>
		<option value="1">Preparing</option>
		<option value="2">Cooking</option>
	</select>
	<label>Equipment:</label>
	<select>
		<?php
		
		// this needs to be done via AJAX so that every time the above select is changed, these options change respectively also
		
		$sql = 'SELECT equipment_id, equipment_name FROM nobsc_equipment WHERE equipment_type_id = :thisRowType'; // you need to get a JS this or PHP $this value, and possibly selectedIndex?
		$stmt = $conn->prepare($sql);
		$stmt->execute([':thisRowType' => $thisRowType]); // you need to get a JS this or PHP $this value, and possibly selectedIndex?
		
		while (($row = $stmt->fetch()) !== false) {
			echo '<option value="' . $row['equipment_id'] . '">' . $row['equipment_name'] . '</option>';
		}
		
		?>
	</select>
	<button class="remove_row_button">Remove</button>
</div>