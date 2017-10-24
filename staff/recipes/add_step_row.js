function addStepRow(e) {  // This is INSANE! Use hyperapp or React ASAP!
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
	e.preventDefault();
	e.stopPropagation();
}