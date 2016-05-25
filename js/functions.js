function populateUnitFields() {
  var populateURL = "php/populateUnits.php?dropDown1=" + $("#dropDown1 option:selected").text() + "&dropDown2=" + $("#dropDown2 option:selected").text();
  	console.log(populateURL);
  	$.get(populateURL, function(data) {
  		data = JSON.parse(data);
  		console.log(data[0]);
			$("[name=unit1").val(data[0].name);
			$("[name=combatStrength1").val(data[0].combat_strength);
			$("[name=rangedStrength1").val(data[0].ranged_strength);
			$("[name=movement1").val(data[0].movement);
			$("[name=descrip1").val(data[0].descrip);
			$("[name=replaces1").val(data[0].replaces);
			$("[name=unit2").val(data[1].name);
			$("[name=combatStrength2").val(data[1].combat_strength);
			$("[name=rangedStrength2").val(data[1].ranged_strength);
			$("[name=movement2").val(data[1].movement);
			$("[name=descrip2").val(data[1].descrip);
			$("[name=replaces2").val(data[1].replaces);
  	});
}

function addCiv() {
	
}

function renderCivInfo(data) {
	console.log(data);
}

function queryServer(queryString, renderFunction) {
	var req = new XMLHttpRequest();
	req.open("GET", queryString, true);
	req.addEventListener("load", function() {
		if (req.status >= 200 && req.status < 400) {
  		renderFunction(JSON.parse(req.responseText));
  	} else {
  		console.log("Error in network request: " + req.statusText);
  	}
	});
	req.send(null);
	event.preventDefault();
}

function updateBody(jsonArray) {
	var queryInfoDiv = document.getElementById("queryInfo");
	
	while (queryInfoDiv.firstChild) {
		queryInfoDiv.removeChild(queryInfoDiv.firstChild);
	}

	var headerRow = document.createElement("tr");
	var header = document.createElement("th");
	header.appendChild(document.createTextNode("Results"));
	headerRow.appendChild(header);
	queryInfoDiv.appendChild(headerRow);

	for (var i = 0; i < jsonArray.length; i++) {
		var row = document.createElement("tr");
		var cell = document.createElement("td");
		var link = document.createElement("a");
		var linkText = document.createTextNode(jsonArray[i].name);
		link.appendChild(linkText);
		cell.appendChild(link);
		row.appendChild(cell);
		queryInfoDiv.appendChild(row);
		var createFunction = function (currentIndex) {
			return function () {
				var civInfoQueryString = "php/civInfo.php?query=" + jsonArray[currentIndex].name;
 				queryServer(civInfoQueryString, renderCivInfo);	
			};
		};
 		link.addEventListener("click", createFunction(i));	
	}
}

// var query = document.getElementById("form");
// query.addEventListener("submit", function(event) {
// 	var searchString =  document.getElementById("searchString").value;
// 	var queryURL = "query.php" + "?query=" + searchString;
// 	var req = new XMLHttpRequest();
// 	req.open("GET", queryURL, true);
// 	req.addEventListener("load", function() {
// 		if (req.status >= 200 && req.status < 400) {
//   			updateBody(JSON.parse(req.responseText));
//   	} else {
//   		console.log("Error in network request: " + req.statusText);
//   	}
// 	});
// 	req.send(null);
// 	event.preventDefault();
// });

// $(document).ready(function() {
// 	$.get("query.php?query=",function(data) {
// 		var data = JSON.parse(data);
// 		var dropDown = document.getElementById("dropDown");
// 		while (dropDown.firstChild) {
// 			dropDown.removeChild(queryInfoDiv.firstChild);
// 		}

// 		for (var elem in data) {
// 			var option = document.createElement("option");
// 			option.appendChild(document.createTextNode(data[elem].name));
// 			dropDown.appendChild(option);
//   	}
// 	});
// });
