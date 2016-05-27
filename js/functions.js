function addDataSubmitListeners() {
	$("#submitAddCiv").click(function () {
		var data = $("#addCivForm").serialize();
		console.log(data);
		if (!$("[name='civName']").val()) {
			$("#alertCiv").text("Civilization name is required.")
			$("#alertCiv").show()
			$("#alertCiv").fadeOut(25000, function () {
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
					$("#alertCiv").fadeOut(25000, function() {
						$(".deleteMe").remove();
					});
				}
				if (value.success) {
					$("#successCiv").append("<div class='deleteMe'>" + value.success + "</div>");
					$("#successCiv").show();
					$("#successCiv").fadeOut(25000, function() {
						$(".deleteMe").remove();
					});
					document.getElementById("addCivForm").reset();
				}
			});
		});
	});

	$("#submitAddUnits").click(function () {
		var data = $("#addUnitsForm").serialize();
		if (!$("[name='unit1']").val() && !$("[name='unit2']").val()) {
			$("#alertUnit").text("A unit name is required.")
			$("#alertUnit").show()
			$("#alertUnit").fadeOut(25000, function(event) {
				$(".deleteMe").remove();
			});
			return;
		}

		$.post("php/addUnits.php", data, function(event) {		
			event = JSON.parse(event);
			$.each(event, function (index, value) {  
				value = JSON.parse(value);
				if (value.error) {
					$("#alertUnit").append("<div class='deleteMe'>" + value.error + "</div>");
					$("#alertUnit").show();
					$("#alertUnit").fadeOut(25000, function() {
						$(".deleteMe").remove();
					});
				}
				if (value.success) {
					$("#successUnit").append("<div class='deleteMe'>" + value.success + "</div>");
					$("#successUnit").show();
					$("#successUnit").fadeOut(25000, function() {
						$(".deleteMe").remove();
					});
					document.getElementById("addUnitsForm").reset();
				}
			});
		});
	});

	$("#submitAddBuildings").click(function () {
		var data = $("#addBuildingsForm").serialize();
		if (!$("[name='buildingName1']").val() && !$("[name='buildingName2']").val()) {
			$("#alertBuilding").text("A building name is required.")
			$("#alertBuilding").show()
			$("#alertBuilding").fadeOut(25000, function(event) {
				$(".deleteMe").remove();
			});
			return;
		}

		$.post("php/addBuildings.php", data, function(event) {		
			event = JSON.parse(event);
			$.each(event, function (index, value) {  
				value = JSON.parse(value);
				if (value.error) {
					$("#alertBuilding").append("<div class='deleteMe'>" + value.error + "</div>");
					$("#alertBuilding").show();
					$("#alertBuilding").fadeOut(25000, function() {
						$(".deleteMe").remove();
					});
				}
				if (value.success) {
					$("#successBuilding").append("<div class='deleteMe'>" + value.success + "</div>");
					$("#successBuilding").show();
					$("#successBuilding").fadeOut(25000, function() {
						$(".deleteMe").remove();
					});
					document.getElementById("addBuildingsForm").reset();
				}
			});
		});
	});
}

function populateCivsFields() {
	var populateURL = "php/populateCivs.php?dropDown3=" + $("#dropDown3 option:selected").text();
	var civSelected3 = $("#dropDown3 option:selected");
	$.get(populateURL, function(data) {
		if (data.length !== 8) { // length of pre-parsed string.
			data = JSON.parse(data);
			console.log(data);
			$("[name=civName").val(data[0][0].name);
			$("[name=leader").val(data[0][0].leader);
			if (data[1].length > 1) {
				$("[name=uniqueAbility").val(data[1][0].descrip);
				$("[name=civAbilityType1").val(data[1][0].name);
				$("[name=civAbilityType2").val(data[1][1].name);
			} else {
				$("[name=uniqueAbility").val(data[1][0].descrip);
				$("[name=civAbilityType1").val(data[1][0].name);
				$("[name=civAbilityType2").val("");
			}
		} else {

			// $("#alertBuilding").append("<div class='deleteMe'>This civilization has no data.</div>");
			// $("#alertBuilding").show();
			// $("#alertBuilding").fadeOut(25000, function() {
			// 	$(".deleteMe").remove();
			// });
			document.getElementById("addCivForm").reset();
			$('[name=dropDown3]').val(civSelected3[0].innerText);
		}
	});
}


function populateBuildingFields() {
	var populateURL = "php/populateBuildings.php?dropDown2=" + $("#dropDown2 option:selected").text();
	var civSelected2 = $("#dropDown2 option:selected");
	$.get(populateURL, function(data) {
		if (data.length !== 11) { // length of pre-parsed string.
			data = JSON.parse(data);
			console.log(data);
			$("[name=buildingName1").val(data[0][0].name);
			$("[name=replacesBuilding1").val(data[0][0].replaces);
			$("[name=buildingAbility1").val(data[1][0].descrip);
			$("[name=civAbilityType3").val(data[2][0].name);
			if(data[2].length > 1) {
				$("[name=civAbilityType4").val(data[2][1].name);
			} else {
				$("[name=civAbilityType4]").val("");
			}
		} else {
			$("#alertBuilding").append("<div class='deleteMe'>This civilization has no building data.</div>");
			$("#alertBuilding").show();
			$("#alertBuilding").fadeOut(25000, function() {
				$(".deleteMe").remove();
			});
			document.getElementById("addBuildingsForm").reset();
			$('[name=dropDown2]').val(civSelected2[0].innerText);
		}
	});
}

function populateUnitFields() {
	var populateURL = "php/populateUnits.php?dropDown1=" + $("#dropDown1 option:selected").text();
	var civSelected1 = $("#dropDown1 option:selected");
	$.get(populateURL, function(data) {
		if (data.length !== 3) {
			data = JSON.parse(data);
			$("[name=unit1").val(data[0].name);
			$("[name=combatStrength1").val(data[0].combat_strength);
			$("[name=rangedStrength1").val(data[0].ranged_strength);
			$("[name=movement1").val(data[0].movement);
			$("[name=descrip1").val(data[0].descrip);
			$("[name=replacesUnit1").val(data[0].replaces);
			if (data.length === 2) {
				$("[name=unit2").val(data[1].name);
				$("[name=combatStrength2").val(data[1].combat_strength);
				$("[name=rangedStrength2").val(data[1].ranged_strength);
				$("[name=movement2").val(data[1].movement);
				$("[name=descrip2").val(data[1].descrip);
				$("[name=replacesUnit2").val(data[1].replaces);
			}	else {
				$("[name=unit2").val("");
				$("[name=combatStrength2").val("");
				$("[name=rangedStrength2").val("");
				$("[name=movement2").val("");
				$("[name=descrip2").val("");
				$("[name=replacesUnit2").val("");
			}
		} else {
			$("#alertUnit").append("<div class='deleteMe'>This civilization has no unit data.</div>");
			$("#alertUnit").show();
			$("#alertUnit").fadeOut(25000, function() {
				$(".deleteMe").remove();
			});
			document.getElementById("addUnitsForm").reset();
			$('[name=dropDown1]').val(civSelected1[0].innerText);
		}
	});
}

function updateTable(jsonArray) {
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
	

		$(link).click(function(linkText) {
			return function() {
				civInfo(linkText.data);
			}
		}(linkText));
	}
}
function civInfo(civName) {
	var basicInfo = document.getElementById("basicInfo");
	while ((basicInfo).firstChild) {
		basicInfo.removeChild(basicInfo.firstChild);
	}

	$.get("php/civInfo.php?query=" + civName, function(data) {
		console.log(civName);
		console.log(data);
		data = JSON.parse(data);
		console.log(data);
		if (data[0].length) {
			$("#basicInfo").append("<p><strong>Leader</strong>:</p><p>" + data[0][0].leader + "</p><br>");
		}
		if (data[1].length) {
			$("#basicInfo").append("<p><strong>Unique Ability:</strong></p><p> " + data[1][0].descrip + "</p><br>");
		}
		if (data[3].length) {

			$("#basicInfo").append("<p><strong>Unique Units:</strong></p><table id='unitTable' width=750><tr><th>Name</th><th>Combat Strength</th><th>Ranged Strength</th><th>Movement</th><th>Replaces</th><th>Description<th></tr></table><br>");
			$.each(data[3], function (index, value) {
				$("#unitTable").append("<tr><td>" + value.name + "</td><td>" + value.combat_strength + "</td><td>" + value.ranged_strength +
					"</td><td>" + value.movement + "</td><td>" + value.replaces + "</td><td>" + value.descrip + "</td></tr>");
				});
		}
		if (data[2].length) {

			$("#basicInfo").append("<p><strong>Unique Buildings:</strong></p><table id='buildingTable' width=750><tr><th>Name</th><th>Replaces</th><th>Description</th></tr></table>");
			$.each(data[2], function (index, value) {
				$("#buildingTable").append("<tr><td>" + value.name + "</td><td>" + value.replaces + "</td><td>" + value.descrip + "</td></tr>");
				});
		}
	});
}




