
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
  	$("#dropDown").clone().appendTo(".dropDown");

	});
	$("#addCivDiv").hide();
	$("#alert").hide();
	$("#success").hide();
});


$("#submitAddCiv").click(function () {
	var data = $("#addCivForm").serialize();
	console.log(data);
	if (!$("[name='addCivName']").val()) {
		$("#alert").text("Civilization name is required.")
		$("#alert").fadeOut();
		$("#alert").show()
		return;
	}
	$.post("php/addCiv.php", data, function(event) {		
		event = JSON.parse(event);
		$.each(event, function (index, value) {  
			value = JSON.parse(value);
			if (value.error) {
				$("#alert").append("<div>" + value.error + "</div><br>");
				$("#alert").show();
				$("#alert").fadeOut(25000);
			}
			if (value.ability_added) {
				$("#success").append("<div>" + value.success + "</div><br>");
				$("#success").show();
				$("#alert").fadeOut();
			}
		});
	});
});

$("#submitAddBuildings").click(function () {
	var data = $("#addBuildingsForm").serialize();
	if (!data.addCivName) {
		$("#alert").show();
		return;
	}
	$.post("php/addBuildings.php", data, function(event) {		
		console.log(event);
	});
});

$("#submitAddUnits").click(function () {
	var data = $("#addUnitsForm").serialize();
	if (!data.addCivName) {
		$("#alert").show();
		return;
	}
	$.post("php/addUnits.php", data, function(event) {		
		console.log(event);
	});
});


$("#addCiv").click(function () {
	$("#addCivDiv").show();
	$("#editCivDiv").hide();
	$("#dropDown").hide();
});
$("#editCiv").click(function () {
	$("#editCivDiv").show();
	$("#addCivDiv").hide();
	$("#dropDown").show();
});

