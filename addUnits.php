
<?php

//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "millerw3-db", "8iDcPKhFFwTktosp", "millerw3-db");

if ($mysqli->connect_errno) {
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

$civName = $_POST['dropDown'];

$addUnitName1 = $_POST['addUnit1'];
$addHP1 = $_POST['addHP1'];
$addMelee1 = $_POST['addMelee1'];
$addDefense1 = $_POST['addDefense1'];
$addSight1 = $_POST['addSight1'];
$addReplacesUnit1 = $_POST['addReplacesUnit1'];
$addUnit1 = $_POST['addUnit1'];
$addUnitName1 = $_POST['addUnit1'];

$addunitName2 = $_POST['addUnit2'];
$addHP2 = $_POST['addHP2'];
$addMelee2 = $_POST['addMelee2'];
$addDefense2 = $_POST['addDefense2'];
$addSight2 = $_POST['addSight2'];
$addReplacesUnit2 = $_POST['addReplacesUnit2'];
$addUnit2 = $_POST['addUnit2'];
$addUnitName2 = $_POST['addUnit2'];

$rows = array();
$json_array = array();

$unitAdded = "Unit(s) successfully added (" . $addUnitName1 . ", " .  $addUnitName2 . ).";

$civIdQuery = "SELECT id FROM civ_civs WHERE civ_civs.name = "$civName";
	if ($civIdResult = $mysqli->query($civIdQuery)) {
		if ($civIdRow = $civIdResult->fetch_assoc()) {
			$civId = $civIdRow["id"];
		}
	}

$addUnitsQuery = "INSERT INTO civ_unique_units (civ_id, name, hp, melee, defense, sight, descrip, replaces)
								  VALUES ($civId, ";
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