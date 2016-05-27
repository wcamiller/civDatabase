var query = document.getElementById("form");
query.addEventListener("submit", function(event) {
	var searchString =  document.getElementById("searchString").value;
	var queryURL = "php/query.php" + "?query=" + searchString;
	var req = new XMLHttpRequest();
	req.open("GET", queryURL, true);
	req.addEventListener("load", function() {
		if (req.status >= 200 && req.status < 400) {
  			updateTable(JSON.parse(req.responseText));
  	} else {
  		console.log("Error in network request: " + req.statusText);
  	}
	});
	req.send(null);
	event.preventDefault();

});

$(document).ready(function() {
	$.get("php/query.php?query=",function(data) {
		var data = JSON.parse(data);
		var dropDown = document.getElementById("dropDown");
		while (dropDown.firstChild) {
			dropDown.removeChild(queryInfoDiv.firstChild);
		}

		for (var elem in data) {
			var option = document.createElement("option");
			option.appendChild(document.createTextNode(data[elem].name));
			dropDown.appendChild(option);
  	}
		civInfo($("#dropDown option:selected").val());
	});

});


$("#dropDown").change(function() {
	console.log("changed dropdown")
	civInfo($("#dropDown option:selected").val());
});