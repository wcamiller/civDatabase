
<?php

//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "millerw3-db", "8iDcPKhFFwTktosp", "millerw3-db");

if ($mysqli->connect_errno) {
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

$civName = $_POST['addCivName'];
$uniqueAbility = '"' . $_POST['addUniqueAbility'] . '"';
$civLeader = $_POST['addLeader'];

$rows = array();
$json_array = array();

$civAdded = "Civilization " . $civName .  " successfully added.";
$abilityAdded = "Unique ability successfully added to civilization " . $civName . ".";
$civId;

if ($civName && $civLeader) {
	$addCivQuery = "INSERT INTO civ_civs (name, leader) VALUES ($civName, $civLeader)";
	if ($mysqli->query($addCivQuery)) {
		array_push($json_array, '{"success":' . '"' . $civAdded  . '"}');
	} else {
		array_push($json_array, '{"error":' . '"' . $mysqli->error . '"}');
		return;
	} 
} else {
	array_push($json_array, '{"error":' . '"Insufficient input data (both civilization and leader names are required)."}');
}

if ($uniqueAbility) {
	$civIdQuery = "SELECT id FROM civ_civs WHERE civ_civs.name LIKE '%$civName%'";
	if ($civIdResult = $mysqli->query($civIdQuery)) {
		if ($civIdRow = $civIdResult->fetch_assoc()) {
			$civId = $civIdRow["id"];
		}
	}
	$insertAbilityQuery = "FFJI";
	// $insertAbilityQuery = "INSERT INTO civ_unique_abilities (civ_id, descrip) VALUES ($civId, $uniqueAbility)";
	if ($mysqli->query($insertAbilityQuery)) {
		array_push($json_array, '{"success":' . '"' . $abilityAdded . '"}');
	} else {
		array_push($json_array, '{"error":' . '"' . $mysqli->error . '"}');
	}
}

 print json_encode($json_array);

?>