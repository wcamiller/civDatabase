
<?php

//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "millerw3-db", "8iDcPKhFFwTktosp", "millerw3-db");

if ($mysqli->connect_errno) {
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

$civName = $_POST['civName'];
$uniqueAbility = $_POST['uniqueAbility'];
$civLeader = $_POST['leader'];
$abilityType1 = $_POST['civAbilityType1'];
$abilityType2 = $_POST['civAbilityType2'];

$rows = array();
$json_array = array();

$civAdded = "Civilization " . $civName .  " successfully added / updated.";
$abilityAdded = "Unique ability successfully added to civilization " . $civName . ".";
$abilityTypeSet = "Unique ability type successfully added.";
$abilityTypeAdded = "Unique ability type successfully associated.";
$civId;



if ($civName) {

	$addCivQuery = sprintf("INSERT INTO civ_civs (name, leader) VALUES ('%s', '%s') 
									ON DUPLICATE KEY UPDATE name='%s', leader='%s'", $civName, $civLeader, $civName, $civLeader);

	if ($mysqli->query($addCivQuery)) {

		array_push($json_array, '{"success":' . '"' . $civAdded  . '"}');
	} else {
		array_push($json_array, '{"error":' . '"' . $mysqli->error . '"}');		
	} 
} else {
	array_push($json_array, '{"error":' . '"Civ name required."}');
}

if ($uniqueAbility) {
	$civIdQuery = sprintf("SELECT id FROM civ_civs WHERE civ_civs.name='%s'", $civName);
	if ($civIdResult = $mysqli->query($civIdQuery)) {
		if ($civIdRow = $civIdResult->fetch_assoc()) {
			$civId = $civIdRow["id"];
		}
	}
	
	$insertAbilityQuery = sprintf("INSERT INTO civ_unique_abilities (civ_id, descrip) 
												 VALUES (%d, '%s') ON DUPLICATE KEY
												 UPDATE descrip='%s'", $civId, $uniqueAbility, $uniqueAbility);

	if ($insertAbilitySuccess = $mysqli->query($insertAbilityQuery)) {
		array_push($json_array, '{"success":' . '"' . $abilityAdded . '"}');
	} else {
		array_push($json_array, '{"error":' . '"' . $mysqli->error . '"}');
	}
							 
	$insertAbilityTypeQuery1 = sprintf("INSERT INTO civ_abil_to_type (ability_id, type_id) VALUES
														 ((SELECT abils.id FROM civ_unique_abilities abils WHERE
														 abils.civ_id = %d), (SELECT type.id FROM civ_ability_types type WHERE
														 type.name = '%s')) ON DUPLICATE KEY UPDATE type_id=
														 (SELECT type.id FROM civ_ability_types type WHERE type.name = '%s')", $civId, $abilityType1, $abilityType1);

	$insertAbilityTypeQuery2 = sprintf("INSERT INTO civ_abil_to_type (ability_id, type_id) VALUES
															 ((SELECT abils.id FROM civ_unique_abilities abils WHERE
															 abils.civ_id = %d), (SELECT type.id FROM civ_ability_types type WHERE
															 type.name = '%s')) ON DUPLICATE KEY UPDATE type_id=
															 (SELECT type.id FROM civ_ability_types type WHERE type.name = '%s')", $civId, $abilityType2, $abilityType2);


if ($insertAbilitySuccess) {
	if ($mysqli->query($insertAbilityTypeQuery1)) {
			array_push($json_array, '{"success":' . '"' . $abilityTypeAdded . '"}');
	} else {
			array_push($json_array, '{"error":' . '"' . $mysqli->error . '"}');
	}
}

if ($insertAbilitySuccess && $abilityType2) {
		if ($mysqli->query($insertAbilityTypeQuery2)) {
				array_push($json_array, '{"success":' . '"' . $abilityTypeAdded . '"}');
		} else {
				array_push($json_array, '{"error":' . '"' . $mysqli->error . '"}');
		}
}

}

 print json_encode($json_array);

?>