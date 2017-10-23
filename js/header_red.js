function swapFacadeText() {
	var fT = document.getElementById("facade_text");
	var sInsert = document.getElementById("search_insert_input");
	var sIndex = document.getElementById("search_prefilter").selectedIndex;
	var x = document.getElementById("search_prefilter").options[sIndex].text;
	fT.innerHTML = x;
	sInsert.focus();
}