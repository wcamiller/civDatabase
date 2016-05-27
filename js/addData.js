
$(document).ready(function() {
	$.get("php/query.php?query=",function(data) {
		var data = JSON.parse(data);
		var dropDown1 = document.getElementById("dropDown1");
		var dropDown2 = document.getElementById("dropDown2");
		var dropDown3 = document.getElementById("dropDown3");
		while (dropDown1.firstChild) {
			dropDown1.removeChild(dropDown1.firstChild);
		}
		while (dropDown2.firstChild) {
			dropDown2.removeChild(dropDown2.firstChild);
		}

		for (var elem in data) {
			var option1 = document.createElement("option");
			var option2 = document.createElement("option");
			var option3 = document.createElement("option");
			option1.appendChild(document.createTextNode(data[elem].name));
			option2.appendChild(document.createTextNode(data[elem].name));
			option3.appendChild(document.createTextNode(data[elem].name));
			dropDown1.appendChild(option1);
			dropDown2.appendChild(option2);
			dropDown3.appendChild(option3);
  	}

  	populateCivsFields();
  	populateUnitFields();
  	populateBuildingFields();

	});

	$("#alert").hide();
	$("#success").hide();
	$("#dropDown3").prepend("<option>Add New Civilization</option>");

});

$("#dropDown1").change(function() {
	populateUnitFields();
});

$("#dropDown2").change(function() {
	populateBuildingFields();

});

$("#dropDown3").change(function() {
	populateCivsFields();
});

addDataSubmitListeners();

