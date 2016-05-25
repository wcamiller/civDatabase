
$(document).ready(function() {
	$.get("php/query.php?query=",function(data) {
		var data = JSON.parse(data);
		var dropDown1 = document.getElementById("dropDown1");
		var dropDown2 = document.getElementById("dropDown2");
		while (dropDown1.firstChild) {
			dropDown1.removeChild(dropDown1.firstChild);
		}
		while (dropDown2.firstChild) {
			dropDown2.removeChild(dropDown2.firstChild);
		}

		for (var elem in data) {
			var option1 = document.createElement("option");
			var option2 = document.createElement("option");
			option1.appendChild(document.createTextNode(data[elem].name));
			option2.appendChild(document.createTextNode(data[elem].name));
			dropDown1.appendChild(option1);
			dropDown2.appendChild(option2);
  	}

  	populateUnitFields();

	});

	$("#alert").hide();
	$("#success").hide();
});


$("#submitAddCiv").click(function () {
	var data = $("#addCivForm").serialize();
	console.log(data);
	if (!$("[name='civName']").val()) {
		$("#alertCiv").text("Civilization name is required.")
		$("#alertCiv").show()
		$("#alertCiv").fadeOut(15000, function () {
			$(".deleteMe").remove();
		});
		return;
	}
	$.post("php/addCiv.php", data, function(event) {		
		event = JSON.parse(event);
		$.each(event, function (index, value) {  
			value = JSON.parse(value);
			if (value.error) {
				$("#alertCiv").append("<div class='deleteMe'>" + value.error + "</div>");
				$("#alertCiv").show();
				$("#alertCiv").fadeOut(15000, function() {
					$(".deleteMe").remove();
				});
			}
			if (value.success) {
				$("#successCiv").append("<div class='deleteMe'>" + value.success + "</div>");
				$("#successCiv").show();
				$("#successCiv").fadeOut(15000, function() {
					$(".deleteMe").remove();
				});
			}
		});
	});
});

$("#submitAddUnits").click(function () {
	var data = $("#addUnitsForm").serialize();
	console.log(data);
	if (!$("[name='unit1']").val() && !$("[name='unit2']").val()) {
		$("#alertUnit").text("A unit name is required.")
		$("#alertUnit").show()
		$("#alertUnit").fadeOut(15000, function(event) {
			$(".deleteMe").remove();
		});
		return;
	}

	$.post("php/addUnits.php", data, function(event) {		
		event = JSON.parse(event);
		console.log(event);
		$.each(event, function (index, value) {  
			value = JSON.parse(value);
			if (value.error) {
				$("#alertUnit").append("<div class='deleteMe'>" + value.error + "</div>");
				$("#alertUnit").show();
				$("#alertUnit").fadeOut(15000, function() {
					$(".deleteMe").remove();
				});
			}
			if (value.success) {
				$("#successUnit").append("<div class='deleteMe'>" + value.success + "</div>");
				$("#successUnit").show();
				$("#successUnit").fadeOut(15000, function() {
					$(".deleteMe").remove();
				});
				document.getElementById("addUnitsForm").reset();
			}
		});
	});
});


// $("#submitAddBuildings").click(function () {
// 	var data = $("#addBuildingsForm").serialize();
// 	if (!data.addCivName) {
// 		$("#alert").show();
// 		return;
// 	}
// 	$.post("php/addBuildings.php", data, function(event) {		
// 		console.log(event);
// 	});
// });

// $("#submitAddUnits").click(function () {
// 	var data = $("#addUnitsForm").serialize();
// 	if (!data.addCivName) {
// 		$("#alert").show();
// 		return;
// 	}
// 	$.post("php/addUnits.php", data, function(event) {		
// 		console.log(event);
// 	});
// });

$("#")




