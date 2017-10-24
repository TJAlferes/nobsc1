document.getElementById("submitted_image").onchange = function () {
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
	reader.readAsDataURL(this.files[0]);
}