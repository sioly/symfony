var a = 0;
function addForm() {
	if (a == 0) {
  		document.getElementById("addform").style.display = "block";
  		a = 1;
  	} else if (a == 1) {
  		document.getElementById("addform").style.display = "none";
  		a = 0;
  	}
}

var b = 0;
function addUser() {
	if (b == 0) {
  		document.getElementById("adduser").style.display = "block";
  		b = 1;
  	} else if (b == 1) {
  		document.getElementById("adduser").style.display = "none";
  		b = 0;
  	}
}