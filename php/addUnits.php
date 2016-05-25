
<?php

//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "millerw3-db", "8iDcPKhFFwTktosp", "millerw3-db");

if ($mysqli->connect_errno) {
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}



$civName = $_POST['dropDown1'];
$cidId;

$unit1 = $_POST['unit1'];
$combatStrength1 = (empty($_POST['combatStrength1'])) ? 0 : $_POST['combatStrength1'];
$rangedStrength1 = (empty($_POST['rangedStrength1'])) ? 0 : $_POST['rangedStrength1'];
$movement1 = (empty($_POST['movement1'])) ? 0 : $_POST['movement1'];
$replacesUnit1 = (empty($_POST['replacesUnit1'])) ? NULL : $_POST['replacesUnit1'];
$descrip1 = (empty($_POST['descrip1'])) ? NULL : $_POST['descrip1'];

$unit2 = $_POST['unit2'];
$combatStrength2 = (empty($_POST['combatStrength2'])) ? 0 : $_POST['combatStrength2'];
$rangedStrength2 = (empty($_POST['rangedStrength2'])) ? 0 : $_POST['rangedStrength2'];
$movement2 = (empty($_POST['movement2'])) ? 0 : $_POST['movement2'];
$replacesUnit2 = (empty($_POST['replacesUnit2'])) ? NULL : $_POST['replacesUnit2'];
$descrip2 = (empty($_POST['descrip2'])) ? NULL : $_POST['descrip2'];

$rows = array();
$json_array = array();



$unitAdded1 = "Unit successfully added (" . $unit1 . ").";
$unitAdded2 = "Unit successfully added (" . $unit2 . ").";

$civIdQuery = "SELECT id FROM civ_civs WHERE civ_civs.name = '$civName'";



if ($civIdResult = $mysqli->query($civIdQuery)) {
	if ($civIdRow = $civIdResult->fetch_assoc()) {
		$civId = $civIdRow["id"];
	}
} else {
		//print $mysqli->error;
		array_push($json_array, '{"error":' . '"' . $mysqli->error . '"}');
}

$addUnit1Query = "INSERT INTO civ_unique_units (civ_id, name, combat_strength, ranged_strength, movement, descrip, replaces)
								  VALUES ($civId, '$unit1', $combatStrength1, $rangedStrength1, $movement1, '$descrip1', '$replacesUnit1')";

$addUnit2Query = "INSERT INTO civ_unique_units (civ_id, name, combat_strength, ranged_strength, movement, descrip, replaces)
								  VALUES ($civId, '$unit2', $combatStrength2, $rangedStrength2, $movement2, '$descrip2', '$replacesUnit2')";

if ($unit1) {
	if ($mysqli->query($addUnit1Query)) {
		array_push($json_array, '{"success":' . '"' . $unitAdded1 . '"}');
	} else {
		//print $mysqli->error;
		array_push($json_array, '{"error":' . '"' . $mysqli->error . '"}');
	}
}

if ($unit2) {
	if ($mysqli->query($addUnit2Query)) {
		array_push($json_array, '{"success":' . '"' . $unitAdded2 . '"}');
	} else {
		//print $mysqli->error;
		array_push($json_array, '{"error":' . '"' . $mysqli->error . '"}');
	}
}

print json_encode($json_array);

?>