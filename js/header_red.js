


// ////////////////////////////// OVERVIEW //////////////////////////////
// This page (header_red.js) contains the functionality for the NOBSC red header.



function swapFacadeText() {
	var fT = document.getElementById("facade_text");
	var sInsert = document.getElementById("search_insert_input");
	var sIndex = document.getElementById("search_prefilter").selectedIndex;
	var x = document.getElementById("search_prefilter").options[sIndex].text;
	fT.innerHTML = x;
	sInsert.focus();
}



function liveSearchShow() {
	var sInsert = document.getElementById("search_insert_input");
	var sAuto = document.getElementById("search_auto_suggestions");
	var sAutoShadow = document.getElementById("search_auto_suggestions_shadow");
	
	if (sInsert == document.activeElement) {
		sAuto.style.display = "block";
		sAutoShadow.style.display = "block";
	}
}



function liveSearchHide(e) {
	var sInsert = document.getElementById("search_insert_input");
	var sAuto = document.getElementById("search_auto_suggestions");
	var sAutoShadow = document.getElementById("search_auto_suggestions_shadow");
	
	if (e.target != sInsert) && (e.target != sAuto)) {
		sAuto.style.display = "none";
		sAutoShadow.style.display = "none";
	}
}



function liveSearchRed() {
	
}


